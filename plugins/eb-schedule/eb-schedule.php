<?php
/**
 * Plugin Name: 이지복지 일정 (정부24 신청기한 자동 수집)
 * Description: 정부24 공공서비스(혜택) API의 신청기한을 매일 받아 '지금 신청 중'·'곧 시작' 일정을 만듭니다. 관리자 > 복지 일정에서 검수하고, [eb_schedule_board] 숏코드로 표시합니다.
 * Version: 0.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: 이지복지닷컴
 * Text Domain: eb-schedule
 */

defined( 'ABSPATH' ) || exit;

define( 'EBS_VER', '0.1.0' );
define( 'EBS_FILE', __FILE__ );

require_once __DIR__ . '/inc/parse.php';
require_once __DIR__ . '/inc/sync.php';
require_once __DIR__ . '/inc/items.php';
require_once __DIR__ . '/inc/board.php';

if ( is_admin() ) {
	require_once __DIR__ . '/inc/admin.php';
}

/* 매일 새벽 4시 45분(사이트 시간)에 정부24 데이터를 새로 받음. 테마의 복지로 동기화(4시 30분) 다음 순서. */
register_activation_hook( __FILE__, function () {
	if ( ! wp_next_scheduled( 'ebs_daily' ) ) {
		$first = strtotime( 'tomorrow 04:45' ) - (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		wp_schedule_event( $first, 'daily', 'ebs_daily' );
	}
	// 처음 켰을 때 1분 뒤 한 번 받아 둠(활성화 화면이 오래 걸리지 않도록 바로 받지 않음)
	if ( ! get_option( 'ebs_meta' ) ) {
		wp_schedule_single_event( time() + 60, 'ebs_daily' );
	}
} );

register_deactivation_hook( __FILE__, function () {
	wp_clear_scheduled_hook( 'ebs_daily' );
} );

add_action( 'ebs_daily', 'ebs_sync' );

/* ── 마감 알림(웹 푸시) - 방문자가 고른 일정만 (2026-10-15) ─────────────────────────────────
 * 일정 줄의 종 버튼 → 브라우저 푸시 구독 + 그 일정 키를 저장(wp_ebs_push: 푸시 주소·일정 키만, 이름·연락처 없음).
 * 매일 09시(ebs_push_daily) 시작일·마감 3일 전·마감일이면 내용 없는 신호(VAPID)를 보내고,
 * 서비스 워커(/sw.js, 테마 35번)가 /ebs/v1/push-msg 로 문구를 받아 띄움. 끄기: 옵션 ebs_push_off = 1
 */
define( 'EBS_PUSH_DB', 1 );

function ebs_push_table() {
	global $wpdb;
	return $wpdb->prefix . 'ebs_push';
}

add_action( 'init', function () {
	if ( EBS_PUSH_DB !== (int) get_option( 'ebs_push_db' ) ) {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( 'CREATE TABLE ' . ebs_push_table() . " (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  ep_hash char(40) NOT NULL,
  endpoint text NOT NULL,
  items longtext NOT NULL,
  queue longtext NOT NULL,
  created datetime NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ep_hash (ep_hash)
) " . $wpdb->get_charset_collate() . ';' );
		update_option( 'ebs_push_db', EBS_PUSH_DB, false );
	}
	if ( ! wp_next_scheduled( 'ebs_push_daily' ) ) {
		$at = new DateTimeImmutable( 'tomorrow 09:00', wp_timezone() );
		wp_schedule_event( $at->getTimestamp(), 'daily', 'ebs_push_daily' );
	}
} );

function ebs_b64u( $s ) {
	return rtrim( strtr( base64_encode( $s ), '+/', '-_' ), '=' );
}

/** VAPID 키(P-256) - 처음 한 번 만들어 옵션에 보관. pub = 브라우저 구독에 쓰는 공개키(base64url) */
function ebs_vapid() {
	$v = get_option( 'ebs_vapid' );
	if ( is_array( $v ) && ! empty( $v['pem'] ) && ! empty( $v['pub'] ) ) {
		return $v;
	}
	$key = openssl_pkey_new( array( 'curve_name' => 'prime256v1', 'private_key_type' => OPENSSL_KEYTYPE_EC ) );
	if ( ! $key || ! openssl_pkey_export( $key, $pem ) ) {
		return null;
	}
	$d   = openssl_pkey_get_details( $key );
	$pub = "\x04" . str_pad( $d['ec']['x'], 32, "\0", STR_PAD_LEFT ) . str_pad( $d['ec']['y'], 32, "\0", STR_PAD_LEFT );
	$v   = array( 'pem' => $pem, 'pub' => ebs_b64u( $pub ) );
	update_option( 'ebs_vapid', $v, false );
	return $v;
}

/** VAPID JWT(ES256). openssl 서명(DER)을 r||s 64바이트로 바꿈 */
function ebs_vapid_jwt( $endpoint, $v ) {
	$p   = wp_parse_url( $endpoint );
	$h   = ebs_b64u( wp_json_encode( array( 'typ' => 'JWT', 'alg' => 'ES256' ) ) );
	$c   = ebs_b64u( wp_json_encode( array( 'aud' => $p['scheme'] . '://' . $p['host'], 'exp' => time() + 12 * HOUR_IN_SECONDS, 'sub' => home_url( '/' ) ) ) );
	$der = '';
	if ( ! openssl_sign( $h . '.' . $c, $der, $v['pem'], OPENSSL_ALGO_SHA256 ) ) {
		return '';
	}
	$rl = ord( $der[3] );
	$r  = substr( $der, 4, $rl );
	$sl = ord( $der[ 5 + $rl ] );
	$s  = substr( $der, 6 + $rl, $sl );
	$r  = str_pad( ltrim( $r, "\0" ), 32, "\0", STR_PAD_LEFT );
	$s  = str_pad( ltrim( $s, "\0" ), 32, "\0", STR_PAD_LEFT );
	return $h . '.' . $c . '.' . ebs_b64u( $r . $s );
}

/** 내용 없는 푸시 한 번. 돌려주는 값 = HTTP 상태(0 = 실패) */
function ebs_push_send( $endpoint, $v ) {
	$jwt = ebs_vapid_jwt( $endpoint, $v );
	if ( '' === $jwt ) {
		return 0;
	}
	$r = wp_remote_post( $endpoint, array(
		'timeout' => 10,
		'headers' => array(
			'TTL'           => '86400',
			'Urgency'       => 'normal',
			'Authorization' => 'vapid t=' . $jwt . ', k=' . $v['pub'],
			'Content-Length' => '0',
		),
		'body'    => '',
	) );
	return is_wp_error( $r ) ? 0 : (int) wp_remote_retrieve_response_code( $r );
}

/** 브라우저 푸시 서비스 주소만 받음(크롬·삼성=FCM, 엣지=WNS, 파이어폭스, 사파리) */
function ebs_push_ok_endpoint( $ep ) {
	$p = wp_parse_url( (string) $ep );
	return strlen( (string) $ep ) < 1000 && ! empty( $p['host'] ) && isset( $p['scheme'] ) && 'https' === $p['scheme']
		&& (bool) preg_match( '/(^|\.)(fcm\.googleapis\.com|push\.services\.mozilla\.com|notify\.windows\.com|push\.apple\.com)$/', $p['host'] );
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ebs/v1', '/push-key', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			$v = get_option( 'ebs_push_off' ) ? null : ebs_vapid();
			return rest_ensure_response( array( 'key' => $v ? $v['pub'] : '' ) );
		},
	) );
	// 구독 + 일정 하나 켜기/끄기
	register_rest_route( 'ebs/v1', '/push-sub', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => function ( $req ) {
			global $wpdb;
			$ep = (string) $req->get_param( 'endpoint' );
			$k  = sanitize_text_field( (string) $req->get_param( 'k' ) );
			if ( get_option( 'ebs_push_off' ) || ! ebs_push_ok_endpoint( $ep ) || ! preg_match( '/^[gmr]-[\w-]{1,64}$/', $k ) ) {
				return new WP_Error( 'ebs_push', 'bad request', array( 'status' => 400 ) );
			}
			$t     = ebs_push_table();
			$hash  = sha1( $ep );
			$row   = $wpdb->get_row( $wpdb->prepare( "SELECT id, items FROM $t WHERE ep_hash = %s", $hash ) ); // phpcs:ignore
			$items = $row ? (array) json_decode( $row->items, true ) : array();
			unset( $items[ $k ] );
			if ( rest_sanitize_boolean( $req->get_param( 'on' ) ) ) {
				$items[ $k ] = array( 'n' => ebs_cut( sanitize_text_field( (string) $req->get_param( 'n' ) ), 60 ), 'e' => '', 'sent' => array() );
				$items       = array_slice( $items, -30, null, true );
			}
			if ( $row ) {
				$wpdb->update( $t, array( 'items' => wp_json_encode( $items ) ), array( 'id' => $row->id ) );
			} else {
				$wpdb->insert( $t, array( 'ep_hash' => $hash, 'endpoint' => $ep, 'items' => wp_json_encode( $items ), 'queue' => '[]', 'created' => current_time( 'mysql' ) ) );
			}
			return rest_ensure_response( array( 'ok' => true, 'n' => count( $items ) ) );
		},
	) );
	// 서비스 워커가 신호를 받으면 여기서 문구를 가져감(가져가면 비움)
	register_rest_route( 'ebs/v1', '/push-msg', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => function ( $req ) {
			global $wpdb;
			$t   = ebs_push_table();
			$row = $wpdb->get_row( $wpdb->prepare( "SELECT id, queue FROM $t WHERE ep_hash = %s", sha1( (string) $req->get_param( 'endpoint' ) ) ) ); // phpcs:ignore
			if ( ! $row ) {
				return rest_ensure_response( array() );
			}
			$wpdb->update( $t, array( 'queue' => '[]' ), array( 'id' => $row->id ) );
			$res = new WP_REST_Response( array_values( (array) json_decode( $row->queue, true ) ) );
			$res->header( 'Cache-Control', 'no-store' );
			return $res;
		},
	) );
} );

add_action( 'ebs_push_daily', 'ebs_push_run' );

/** 오늘 알릴 것: 시작일 · 마감 3일 전 · 마감일. $test = 가장 최근 구독 기기 하나에 시험 알림 */
function ebs_push_run( $test = false ) {
	global $wpdb;
	$v = get_option( 'ebs_push_off' ) ? null : ebs_vapid();
	if ( ! $v ) {
		return 0;
	}
	$t     = ebs_push_table();
	$today = current_time( 'Y-m-d' );
	$icon  = get_site_icon_url( 192 );
	if ( $test ) {
		$row = $wpdb->get_row( "SELECT id, endpoint, queue FROM $t ORDER BY id DESC LIMIT 1" ); // phpcs:ignore
		if ( ! $row ) {
			return 0;
		}
		$q   = (array) json_decode( $row->queue, true );
		$q[] = array( 'title' => '알림이 잘 와요', 'body' => '이지복지닷컴 마감 알림 시험이에요. 고른 일정의 시작일·마감 3일 전·마감일 아침 9시에 알려 드려요.', 'url' => home_url( '/schedule/#applying' ), 'tag' => 'ebs-test', 'icon' => $icon );
		$wpdb->update( $t, array( 'queue' => wp_json_encode( $q ) ), array( 'id' => $row->id ) );
		$code = ebs_push_send( $row->endpoint, $v );
		update_option( 'ebs_push_last', array( 'at' => time(), 'sent' => 1, 'code' => $code, 'test' => 1 ), false );
		return $code;
	}
	$map = array();
	foreach ( ebs_items( array( 'ahead' => 400, 'today' => $today, 'local' => true ) ) as $x ) {
		$map[ $x['key'] ] = $x;
	}
	$sent = 0;
	foreach ( (array) $wpdb->get_results( "SELECT id, endpoint, items, queue FROM $t" ) as $row ) { // phpcs:ignore
		$items = (array) json_decode( $row->items, true );
		$queue = (array) json_decode( $row->queue, true );
		$add   = array();
		foreach ( $items as $k => $it ) {
			if ( empty( $map[ $k ] ) ) {
				if ( empty( $it['e'] ) || $it['e'] < $today ) {
					unset( $items[ $k ] ); // 끝났거나 목록에서 빠진 일정
				}
				continue;
			}
			$x    = $map[ $k ];
			$left = (int) round( ( strtotime( $x['e'] ) - strtotime( $today ) ) / DAY_IN_SECONDS );
			$st   = $x['s'] && $x['s'] === $today ? 'start' : ( 3 === $left ? 'd3' : ( 0 === $left ? 'd0' : '' ) );
			$items[ $k ]['e'] = $x['e'];
			if ( '' === $st || in_array( $st . $x['e'], (array) $it['sent'], true ) ) {
				continue;
			}
			$items[ $k ]['sent'][] = $st . $x['e'];
			$add[] = array(
				'title' => 'start' === $st ? '오늘부터 신청할 수 있어요' : ( 'd3' === $st ? '신청 마감 3일 전이에요' : '오늘 신청 마감이에요' ),
				'body'  => $x['name'] . ' · ' . ebs_md( $x['e'] ) . ' 마감',
				'url'   => $x['guide'] ? $x['guide'] : home_url( '/schedule/#applying' ),
				'tag'   => $k,
				'icon'  => $icon,
			);
		}
		if ( $add ) {
			$queue = array_slice( array_merge( $queue, $add ), -10 );
			$wpdb->update( $t, array( 'queue' => wp_json_encode( $queue ) ), array( 'id' => $row->id ) );
			$code = ebs_push_send( $row->endpoint, $v );
			if ( 404 === $code || 410 === $code ) {
				$wpdb->delete( $t, array( 'id' => $row->id ) ); // 브라우저에서 알림을 끈 기기
				continue;
			}
			$sent++;
		}
		if ( ! $items ) {
			$wpdb->delete( $t, array( 'id' => $row->id ) );
			continue;
		}
		$wpdb->update( $t, array( 'items' => wp_json_encode( $items ) ), array( 'id' => $row->id ) );
	}
	update_option( 'ebs_push_last', array( 'at' => time(), 'sent' => $sent ), false );
	return $sent;
}
