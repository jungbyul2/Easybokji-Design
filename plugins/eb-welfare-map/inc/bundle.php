<?php
/**
 * 검수 묶음 적용 (복지지도 > 검수 묶음) - 2026-10-18
 *
 * data/review-YYYYMMDD.json 의 지역 검수 결과를 한 번에 ebm_review에 넣는 관리자 화면.
 * 스테이징·운영 어디서나 같은 결과가 되도록:
 *   - 이미 같은 값으로 검수된 사업은 건너뜀(스테이징에 먼저 적용한 33건)
 *   - 다른 값으로 이미 검수한 사업은 덮어쓰지 않음(사람이 고친 것 우선)
 *   - 사업 이름이 다르거나, 자동 판정이 '확인 필요'가 아니게 된 사업은 건너뜀(자료가 바뀐 것)
 *   - 적용 전 값을 옵션에 백업, '되돌리기'는 이번 묶음이 넣은 값 그대로일 때만
 * 운영 이관: 스테이징 DB를 덮어쓰지 않고 이 화면에서 같은 묶음을 적용하면 됨.
 */

defined( 'ABSPATH' ) || exit;

function ebm_bundle() {
	static $b = null;
	if ( null === $b ) {
		$f = EBM_DIR . 'data/review-20261018.json';
		$b = is_readable( $f ) ? json_decode( (string) file_get_contents( $f ), true ) : null; // phpcs:ignore
		if ( ! is_array( $b ) || empty( $b['items'] ) ) {
			$b = array();
		}
	}
	return $b;
}

function ebm_bundle_key() {
	$b = ebm_bundle();
	return 'ebm_bundle_' . preg_replace( '/\D/', '', (string) ( $b['id'] ?? '' ) );
}

/** 검수값 비교용: 적용 범위와 지역만 */
function ebm_bundle_norm( $sc, $r ) {
	$r = array_map( 'strval', (array) $r );
	sort( $r );
	if ( 'hide' === $sc ) {
		$r = array();
	}
	return $sc . '|' . implode( ',', $r );
}

/** 사업마다 할 일: apply(적용) · done(이미 같음) · other(다른 값으로 검수됨) · missing(자료에 없음·이름 다름) · changed(자동 판정이 바뀜) */
function ebm_bundle_plan() {
	$b      = ebm_bundle();
	$data   = ebm_data();
	$review = ebm_review_all();
	$rows   = array();
	foreach ( (array) ( $b['items'] ?? array() ) as $p ) {
		$id  = (string) $p['id'];
		$it  = $data['items'][ $id ] ?? null;
		$rv  = isset( $review[ $id ] ) ? (array) $review[ $id ] : array();
		$cur = empty( $rv['sc'] ) || 'auto' === $rv['sc'] ? '' : ebm_bundle_norm( $rv['sc'], $rv['r'] ?? array() );
		if ( ! $it || $it['n'] !== $p['name'] ) {
			$do = 'missing';
		} elseif ( $cur === ebm_bundle_norm( $p['sc'], $p['r'] ) ) {
			$do = 'done';
		} elseif ( '' !== $cur ) {
			$do = 'other';
		} elseif ( 'check' !== $it['sc'] ) {
			$do = 'changed';
		} else {
			$do = 'apply';
		}
		$rows[] = array( 'p' => $p, 'do' => $do );
	}
	return $rows;
}

add_action( 'admin_menu', function () {
	if ( ebm_bundle() ) {
		add_submenu_page( 'ebm', '검수 묶음 적용', '검수 묶음', 'manage_options', 'ebm-bundle', 'ebm_bundle_page' );
	}
}, 20 );

function ebm_bundle_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$b    = ebm_bundle();
	$bk   = get_option( ebm_bundle_key() );
	$rows = ebm_bundle_plan();
	$n    = array_count_values( wp_list_pluck( $rows, 'do' ) );
	$labs = array( 'apply' => '적용할 것', 'done' => '이미 적용됨', 'other' => '다른 값으로 검수돼 있어 건너뜀', 'missing' => '자료에 없음(건너뜀)', 'changed' => '자동 판정이 바뀌어 건너뜀' );
	echo '<div class="wrap"><h1>' . esc_html( $b['title'] ) . '</h1>';
	if ( isset( $_GET['ebm_msg'] ) ) { // phpcs:ignore
		echo '<div class="notice notice-success"><p>' . esc_html( sanitize_text_field( wp_unslash( $_GET['ebm_msg'] ) ) ) . '</p></div>'; // phpcs:ignore
	}
	echo '<p>' . esc_html( $b['note'] ) . '</p><p>';
	foreach ( $labs as $k => $l ) {
		echo esc_html( $l ) . ' <strong>' . (int) ( $n[ $k ] ?? 0 ) . '</strong>건 &nbsp; ';
	}
	echo '</p>';

	if ( is_array( $bk ) && 'applied' === ( $bk['status'] ?? '' ) ) {
		echo '<div class="notice notice-info inline"><p>' . esc_html( wp_date( 'Y-m-d H:i', (int) $bk['at'] ) ) . '에 ' . count( $bk['after'] ) . '건을 적용했습니다. 이전 값은 백업해 두었습니다.</p></div>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="ebm_bundle_restore">';
		wp_nonce_field( 'ebm_bundle_restore' );
		submit_button( '이번에 적용한 ' . count( $bk['after'] ) . '건만 적용 전으로 되돌리기', 'secondary', 'submit', false );
		echo '</form>';
	}

	if ( ! empty( $n['apply'] ) ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:16px 0"><input type="hidden" name="action" value="ebm_bundle_apply">';
		echo '<input type="hidden" name="sig" value="' . esc_attr( md5( wp_json_encode( $rows ) ) ) . '">';
		wp_nonce_field( 'ebm_bundle_apply' );
		echo '<p><label><input type="checkbox" name="ok" value="1" required> 아래 \'적용할 것\' ' . (int) $n['apply'] . '건의 지역 분류를 저장합니다(공개 설정·신청 기간은 바꾸지 않음).</label></p>';
		submit_button( '이전 값을 백업하고 ' . (int) $n['apply'] . '건 적용', 'primary', 'submit', false );
		echo '</form>';
	}

	echo '<table class="widefat striped" style="max-width:1100px"><thead><tr><th style="width:110px">할 일</th><th>사업</th><th style="width:200px">적용 지역</th><th>근거·주의</th></tr></thead><tbody>';
	usort( $rows, function ( $a, $c ) {
		$o = array( 'apply' => 0, 'changed' => 1, 'other' => 2, 'missing' => 3, 'done' => 4 );
		return $o[ $a['do'] ] <=> $o[ $c['do'] ];
	} );
	foreach ( $rows as $row ) {
		$p = $row['p'];
		echo '<tr><td><strong>' . esc_html( $labs[ $row['do'] ] ) . '</strong></td><td>' . esc_html( $p['name'] ) . '<br><small>' . esc_html( $p['id'] . ' · ' . $p['grp'] ) . '</small></td><td>' . esc_html( $p['area'] ) . '</td><td>' . esc_html( $p['reason'] ) . ' <a href="' . esc_url( $p['url'] ) . '" target="_blank" rel="noopener noreferrer">복지로 원문</a></td></tr>';
	}
	echo '</tbody></table></div>';
}

add_action( 'admin_post_ebm_bundle_apply', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'ebm_bundle_apply' );
	$rows = ebm_bundle_plan();
	if ( '1' !== ( $_POST['ok'] ?? '' ) || ! hash_equals( md5( wp_json_encode( $rows ) ), (string) wp_unslash( $_POST['sig'] ?? '' ) ) ) {
		wp_die( '미리 보기 이후 검수값이 바뀌었거나 확인란이 비어 있습니다. 화면을 새로 열어 다시 확인해 주세요.' );
	}
	$review = ebm_review_all();
	$before = array();
	$after  = array();
	foreach ( $rows as $row ) {
		if ( 'apply' !== $row['do'] ) {
			continue;
		}
		$p             = $row['p'];
		$id            = (string) $p['id'];
		$before[ $id ] = array( 'exists' => array_key_exists( $id, $review ), 'value' => $review[ $id ] ?? null );
		$rv            = isset( $review[ $id ] ) ? (array) $review[ $id ] : array();
		$rv['sc']      = $p['sc'];
		$rv['r']       = 'hide' === $p['sc'] ? array() : array_values( array_map( 'strval', (array) $p['r'] ) );
		$rv['chk']     = current_time( 'Y-m-d' );
		$rv['by']      = get_current_user_id();
		$rv['memo']    = trim( (string) ( $rv['memo'] ?? '' ) . "\n[지역 검수 " . $p['grp'] . '] ' . $p['reason'] . ' 근거: ' . $p['url'] );
		$review[ $id ] = $rv;
		$after[ $id ]  = $rv;
	}
	if ( ! $after ) {
		wp_safe_redirect( add_query_arg( array( 'page' => 'ebm-bundle', 'ebm_msg' => '적용할 사업이 없습니다.' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	update_option( ebm_bundle_key(), array( 'status' => 'prepared', 'at' => time(), 'before' => $before, 'after' => $after ), false );
	if ( ! update_option( 'ebm_review', $review, false ) ) {
		wp_die( '검수 저장에 실패했습니다. 백업은 남겨 두었습니다.' );
	}
	$bk           = get_option( ebm_bundle_key() );
	$bk['status'] = 'applied';
	update_option( ebm_bundle_key(), $bk, false );
	ebm_flush_cache();
	wp_safe_redirect( add_query_arg( array( 'page' => 'ebm-bundle', 'ebm_msg' => count( $after ) . '건을 적용했습니다.' ), admin_url( 'admin.php' ) ) );
	exit;
} );

add_action( 'admin_post_ebm_bundle_restore', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'ebm_bundle_restore' );
	$bk = get_option( ebm_bundle_key() );
	if ( ! is_array( $bk ) || 'applied' !== ( $bk['status'] ?? '' ) ) {
		wp_die( '되돌릴 적용 기록이 없습니다.' );
	}
	$review = ebm_review_all();
	foreach ( $bk['after'] as $id => $v ) {
		if ( ! isset( $review[ $id ] ) || $review[ $id ] !== $v ) {
			wp_die( '적용 뒤 직접 고친 사업이 있어 자동으로 되돌리지 않았습니다. 복지지도 > 검수에서 확인해 주세요. 사업: ' . esc_html( $id ) );
		}
	}
	foreach ( $bk['before'] as $id => $old ) {
		if ( $old['exists'] ) {
			$review[ $id ] = $old['value'];
		} else {
			unset( $review[ $id ] );
		}
	}
	update_option( 'ebm_review', $review, false );
	delete_option( ebm_bundle_key() );
	ebm_flush_cache();
	wp_safe_redirect( add_query_arg( array( 'page' => 'ebm-bundle', 'ebm_msg' => '적용 전으로 되돌렸습니다.' ), admin_url( 'admin.php' ) ) );
	exit;
} );
