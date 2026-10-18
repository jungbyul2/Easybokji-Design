<?php
/**
 * Plugin Name: 이지복지 우리 지역 복지지도
 * Description: 시·도/시·군·구를 골라 그 지역에서 확인할 만한 복지정책(시·군·구 / 시·도 / 전국 공통)을 찾는 /welfare-map/ 페이지와 관리자 검수 화면. 정책 원본은 테마의 복지로 데이터(eb_ws_local·eb_ws_all)를 그대로 읽고, 지도용 사본을 따로 두지 않음.
 * Version: 1.0.0
 * Author: 이지복지
 * Requires PHP: 7.4
 *
 * 구성
 *   inc/regions.php   지역 코드표(data/regions.json) · 이름 → 지역 ID 해석(옛 이름 포함)
 *   inc/policies.php  정책 정규화 · 적용 범위 판정 · 신청 상태 · 지역별 색인(캐시)
 *   inc/rest.php      /wp-json/ebm/v1/region · nation · regions
 *   inc/page.php      [eb_welfare_map] 화면(첫 목록은 서버에서 그림) · 자산 · 페이지 만들기 · 다른 화면 연결 스크립트
 *   inc/admin.php     복지지도 > 상태 · 검수 · 지역 코드표 (관리자)
 *   data/regions.json 시·도 16 + 시·군·구 229 (SGIS 2026-10-01 경계 기준) + 옛 이름
 *   data/geo/*.json   지도 경로(미리 화면 좌표로 바꾼 SVG path)
 *
 * 공개 전환: 설정 전에는 관리자에게만 보임(페이지 비공개, API·메뉴 진입점 숨김). 복지지도 > 상태에서 '공개'로 바꿈.
 */

defined( 'ABSPATH' ) || exit;

define( 'EBM_VER', '1.0.0' );
define( 'EBM_DIR', plugin_dir_path( __FILE__ ) );
define( 'EBM_URL', plugin_dir_url( __FILE__ ) );

require EBM_DIR . 'inc/regions.php';
require EBM_DIR . 'inc/policies.php';
require EBM_DIR . 'inc/rest.php';
require EBM_DIR . 'inc/page.php';
if ( is_admin() ) {
	require EBM_DIR . 'inc/admin.php';
}

/** 방문자에게 공개했는지(아니면 관리자 미리 보기만) */
function ebm_is_public() {
	return (bool) get_option( 'ebm_public', 0 );
}

/** 지금 사용자가 복지지도를 볼 수 있는지 */
function ebm_can_view() {
	return ebm_is_public() || current_user_can( 'manage_options' );
}

register_activation_hook( __FILE__, 'ebm_activate' );
function ebm_activate() {
	ebm_ensure_page();
	ebm_flush_cache();
}
