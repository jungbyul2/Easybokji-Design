<?php
/**
 * Plugin Name: 복지지도 검수 목록 내려받기 (스테이징 전용)
 * Description: 관리자에게 검수용 JSON 다운로드만 제공합니다. 외부 요청과 검수 저장은 하지 않습니다.
 * Version: 1.0.0
 */
defined( 'ABSPATH' ) || exit;

function ebmrx_is_staging() {
	return 'wordpress-1073525-6734075.cloudwaysapps.com' === strtolower( (string) wp_parse_url( get_option( 'home' ), PHP_URL_HOST ) );
}

if ( ! ebmrx_is_staging() ) {
	return;
}

add_action( 'admin_menu', function () {
	add_management_page( '복지지도 목록 내려받기', '복지지도 목록 내려받기', 'manage_options', 'ebmrx-export', 'ebmrx_page' );
} );

function ebmrx_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>복지지도 검수 목록 내려받기</h1>';
	echo '<p>확인이 필요한 사업과 이미 지역 검수를 반영한 사업의 이름·원문 링크·지역 분류를 파일로 받습니다.</p>';
	echo '<p>API 키, 사용자 계정, 알림 구독 정보와 관리자 메모는 포함하지 않습니다. 검수 결과나 공개 설정은 바꾸지 않습니다.</p>';
	if ( ! function_exists( 'ebm_data' ) ) {
		echo '<p>복지지도 플러그인을 먼저 활성화해 주세요.</p></div>';
		return;
	}
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="ebmrx_download">';
	wp_nonce_field( 'ebmrx_download' );
	submit_button( '검수 목록 파일 받기' );
	echo '</form></div>';
}

add_action( 'admin_post_ebmrx_download', function () {
	if ( ! ebmrx_is_staging() || ! current_user_can( 'manage_options' ) ) {
		wp_die( '스테이징 관리자만 사용할 수 있습니다.', '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'ebmrx_download' );
	if ( ! function_exists( 'ebm_data' ) ) {
		wp_die( '복지지도 플러그인이 필요합니다.' );
	}
	$data = ebm_data();
	$rows = array();
	$fields = array_flip( array( 'i', 'n', 'o', 's', 'u', 'm', 'raw', 'sc', 'r', 'sd', 'why', 'nt', 'auto' ) );
	foreach ( (array) ( $data['items'] ?? array() ) as $item ) {
		if ( 'L' !== ( $item['k'] ?? '' ) ) {
			continue;
		}
		if ( 'check' !== ( $item['sc'] ?? '' ) && 'check' !== ( $item['auto']['sc'] ?? '' ) ) {
			continue;
		}
		$rows[] = array_intersect_key( $item, $fields );
	}
	$payload = array(
		'format' => 'eb-map-review-v1',
		'exported_at_utc' => gmdate( 'c' ),
		'pending_count' => count( array_filter( $rows, function ( $item ) { return 'check' === $item['sc']; } ) ),
		'total_count' => count( $rows ),
		'items' => $rows,
	);
	$json = wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
	if ( false === $json ) {
		wp_die( '파일을 만들지 못했습니다.' );
	}
	nocache_headers();
	header( 'Content-Type: application/json; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="welfare-map-review.json"' );
	header( 'X-Content-Type-Options: nosniff' );
	echo $json; // JSON attachment, never rendered as HTML.
	exit;
} );
