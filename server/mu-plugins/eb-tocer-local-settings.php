<?php
/**
 * Plugin Name: 이지복지 tocer 기본 설정 파일 직접 읽기
 * Description: tocer(목차) 플러그인이 자기 기본 설정 파일(default.settings.json)을 HTTP로 자기 사이트에 요청하는 대신, 서버 디스크의 같은 파일을 바로 돌려줍니다. tocer 파일은 고치지 않습니다.
 * Version:     1.0.0
 * Author:      이지복지
 *
 * 둘 곳: wp-content/mu-plugins/eb-tocer-local-settings.php (스테이징·운영 공통으로 쓸 수 있음)
 *
 * 왜 필요한가 (2026-10-18 원인 확인, tocer 4.2.3)
 *  - tocer config.php 102줄: define( DEFAULT_SETTINGS_JSON, fetch_json_data( ROOT_URL . 'default.settings.json' ) )
 *    → PHP가 실행될 때마다(관리자·캐시 안 된 페이지·크론) 자기 사이트에 HTTP 요청을 한 번 보냄
 *  - 응답이 JSON이 아니면(비밀번호 보호 401, 서버 바쁨 503, 방화벽 차단 화면 등) 값이 null이 되고
 *    functions.php 1179줄 flatten_underscore_array( null ) 에서 TypeError → 사이트 전체(관리자 포함) 500 오류
 *  - 스테이징은 Cloudways Password Protection 때문에 늘 401 → 늘 오류(재현함)
 *  - 운영은 지금은 정상이지만 같은 이유로 일시적으로 사이트가 멈출 수 있고, 요청마다 시간이 더 듦
 *
 * 하는 일: 요청 주소가 '이 사이트의 /wp-content/plugins/<tocer 폴더>/default.settings.json'이고
 *          그 폴더에 tocer.php가 있을 때만, 디스크 파일 내용을 200 응답으로 돌려줌. 그 밖의 요청은 손대지 않음.
 * 끄기: 이 파일을 지우면 tocer는 원래대로 HTTP로 받음.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'pre_http_request', function ( $pre, $args, $url ) {
	if ( false !== $pre ) {
		return $pre;
	}
	$path = (string) wp_parse_url( $url, PHP_URL_PATH );
	if ( ! preg_match( '#/wp-content/plugins/([A-Za-z0-9._-]+)/default\.settings\.json$#', $path, $m ) ) {
		return $pre;
	}
	$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );
	$own  = array(
		strtolower( (string) wp_parse_url( get_option( 'home' ), PHP_URL_HOST ) ),
		strtolower( (string) wp_parse_url( get_option( 'siteurl' ), PHP_URL_HOST ) ),
	);
	$dir = WP_PLUGIN_DIR . '/' . $m[1];
	if ( ! in_array( $host, $own, true ) || ! is_readable( $dir . '/tocer.php' ) || ! is_readable( $dir . '/default.settings.json' ) ) {
		return $pre;
	}
	$body = (string) file_get_contents( $dir . '/default.settings.json' ); // phpcs:ignore
	if ( null === json_decode( $body, true ) ) {
		return $pre; // 파일이 깨졌으면 원래 방식에 맡김
	}
	return array(
		'headers'  => array( 'content-type' => 'application/json' ),
		'body'     => $body,
		'response' => array( 'code' => 200, 'message' => 'OK' ),
		'cookies'  => array(),
		'filename' => null,
	);
}, 0, 3 );
