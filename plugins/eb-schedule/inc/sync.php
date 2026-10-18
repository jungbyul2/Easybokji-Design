<?php
/**
 * 정부24 공공서비스(혜택) 목록 받기 — 공공데이터포털 '행정안전부_대한민국 공공서비스(혜택) 정보'
 * GET https://api.odcloud.kr/api/gov24/v3/serviceList?page=&perPage=&serviceKey=
 *
 * 키: 테마의 '복지서비스 API' 화면에 저장된 공공데이터포털 인증키(eb_ws_key)를 그대로 씀.
 *     공공데이터포털은 계정당 키가 하나라서, 이 API 활용신청만 승인되면 같은 키로 됩니다.
 *
 * 저장: 기간이 날짜로 적힌 서비스만 'ebs_raw'(자동 불러오기 끔)에 저장. 1만여 건 중 일부.
 */

defined( 'ABSPATH' ) || exit;

function ebs_key() {
	$k = trim( (string) get_option( 'ebs_key', '' ) );
	return '' !== $k ? $k : trim( (string) get_option( 'eb_ws_key', '' ) );
}

function ebs_meta() {
	return wp_parse_args( (array) get_option( 'ebs_meta', array() ), array(
		'synced' => 0,
		'total'  => 0,
		'dated'  => 0,
		'err'    => '',
		'tried'  => 0,
		'fields' => array(),
	) );
}

/** 한 쪽 받기 → array( 'rows' => [], 'total' => n ) 또는 WP_Error */
function ebs_fetch_page( $page, $per = 1000 ) {
	$key = ebs_key();
	if ( '' === $key ) {
		return new WP_Error( 'ebs_nokey', '공공데이터포털 인증키가 없습니다. 설정 > 복지서비스 API에 먼저 저장해 주세요.' );
	}
	// 키에 이미 %가 있으면(Encoding 키) 그대로, 아니면(Decoding 키) 인코딩
	$k   = false !== strpos( $key, '%' ) ? $key : rawurlencode( $key );
	$url = 'https://api.odcloud.kr/api/gov24/v3/serviceList?page=' . (int) $page . '&perPage=' . (int) $per . '&returnType=JSON&serviceKey=' . $k;
	$res = wp_remote_get( $url, array( 'timeout' => 40 ) );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$code = (int) wp_remote_retrieve_response_code( $res );
	$body = wp_remote_retrieve_body( $res );
	$json = json_decode( $body, true );
	if ( 200 !== $code || ! is_array( $json ) || ! isset( $json['data'] ) ) {
		$msg = is_array( $json ) && isset( $json['msg'] ) ? $json['msg'] : wp_html_excerpt( $body, 160 );
		if ( 401 === $code ) {
			$msg = '인증키가 이 API에 등록되지 않았습니다(승인 직후라면 최대 1시간 뒤 다시 시도). ' . $msg;
		}
		return new WP_Error( 'ebs_http', 'HTTP ' . $code . ' · ' . $msg );
	}
	return array(
		'rows'  => (array) $json['data'],
		'total' => isset( $json['totalCount'] ) ? (int) $json['totalCount'] : 0,
	);
}

function ebs_sync() {
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	$meta          = ebs_meta();
	$meta['tried'] = time();

	$old   = (array) get_option( 'ebs_raw', array() );
	$all   = array();
	$total = 0;
	$seen  = 0;
	$per   = 1000;
	$today = current_time( 'Y-m-d' );
	$keep  = gmdate( 'Y-m-d', strtotime( $today . ' -400 days' ) );

	for ( $page = 1; $page <= 30; $page++ ) {
		$r = ebs_fetch_page( $page, $per );
		if ( is_wp_error( $r ) ) {
			$meta['err'] = $r->get_error_message();
			update_option( 'ebs_meta', $meta, false );
			return $r;
		}
		$total = $r['total'];
		if ( 1 === $page && $r['rows'] ) {
			$meta['fields'] = array_keys( (array) $r['rows'][0] ); // 응답 항목 이름(관리 화면 확인용)
		}
		foreach ( $r['rows'] as $row ) {
			$seen++;
			$item = ebs_row_to_item( $row, $old );
			if ( ! $item ) {
				continue;
			}
			// 끝난 지 400일 넘은 기간뿐이면 버림(연도 없는 반복 기간은 남김)
			$fresh = false;
			foreach ( $item['p'] as $p ) {
				if ( ! empty( $p['ny'] ) || $p['e'] >= $keep ) {
					$fresh = true;
					break;
				}
			}
			if ( $fresh ) {
				$all[ $item['id'] ] = $item;
			}
		}
		if ( ! $r['rows'] || $seen >= $total ) {
			break;
		}
	}

	if ( $seen < 1 ) {
		$meta['err'] = '받은 서비스가 0건입니다. 잠시 뒤 다시 시도해 주세요.';
		update_option( 'ebs_meta', $meta, false );
		return new WP_Error( 'ebs_empty', $meta['err'] );
	}

	update_option( 'ebs_raw', $all, false );
	$meta['synced'] = time();
	$meta['total']  = $seen;
	$meta['dated']  = count( $all );
	$meta['err']    = '';
	update_option( 'ebs_meta', $meta, false );
	ebs_purge_cache();
	return true;
}

function ebs_row_to_item( $row, $old ) {
	$g   = function ( $k ) use ( $row ) {
		return isset( $row[ $k ] ) && is_scalar( $row[ $k ] ) ? trim( (string) $row[ $k ] ) : '';
	};
	$id  = $g( '서비스ID' );
	$raw = $g( '신청기한' );
	if ( '' === $id || '' === $raw ) {
		return null;
	}
	$p = ebs_parse_periods( $raw );
	if ( ! $p ) {
		return null;
	}
	return array(
		'id'    => $id,
		'n'     => $g( '서비스명' ),
		'sum'   => ebs_cut( $g( '서비스목적요약' ), 120 ),
		'tgt'   => ebs_cut( $g( '지원대상' ), 300 ),
		'cnt'   => ebs_cut( $g( '지원내용' ), 300 ),
		'how'   => ebs_cut( $g( '신청방법' ), 160 ),
		'raw'   => ebs_cut( $raw, 200 ),
		'url'   => esc_url_raw( $g( '상세조회URL' ) ),
		'org'   => $g( '소관기관명' ),
		'orgt'  => $g( '소관기관유형' ),
		'field' => $g( '서비스분야' ),
		'user'  => $g( '사용자구분' ),
		'rcv'   => ebs_cut( $g( '접수기관' ), 60 ),
		'tel'   => ebs_cut( $g( '전화문의' ), 60 ),
		'mod'   => $g( '수정일시' ),
		'p'     => $p,
		'first' => isset( $old[ $id ]['first'] ) ? (int) $old[ $id ]['first'] : time(),
	);
}

/** WP Rocket 캐시: 메인과 복지 캘린더만 비움 */
function ebs_purge_cache() {
	update_option( 'ebs_rev', (int) get_option( 'ebs_rev', 0 ) + 1, false );
	if ( function_exists( 'rocket_clean_home' ) ) {
		rocket_clean_home();
	}
	if ( function_exists( 'rocket_clean_files' ) ) {
		rocket_clean_files( array( home_url( '/schedule/' ) ) );
	}
}
