<?php
/**
 * REST
 *   GET /wp-json/ebm/v1/region?sd=경기도&sg=수원시  (또는 ?r=41110) → 시·군·구 사업 · 시·도 사업 · 확인 필요 + 캘린더 요약
 *   GET /wp-json/ebm/v1/nation                        → 전국 공통(중앙부처) 사업 - 지역과 상관없이 같아서 따로(브라우저 1시간 캐시)
 * 기존 테마 /eb/v1/local 응답은 건드리지 않음(맞춤 찾기가 그대로 씀).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', function () {
	register_rest_route( 'ebm/v1', '/region', array(
		'methods'             => 'GET',
		'permission_callback' => 'ebm_can_view',
		'args'                => array(
			'sd' => array( 'default' => '' ),
			'sg' => array( 'default' => '' ),
			'r'  => array( 'default' => '' ),
		),
		'callback'            => function ( $req ) {
			$res = rest_ensure_response( ebm_region_payload( (string) $req['sd'], (string) $req['sg'], (string) $req['r'] ) );
			$res->header( 'Cache-Control', ebm_is_public() ? 'public, max-age=600' : 'private, no-store' );
			return $res;
		},
	) );
	register_rest_route( 'ebm/v1', '/nation', array(
		'methods'             => 'GET',
		'permission_callback' => 'ebm_can_view',
		'callback'            => function () {
			$f   = ebm_freshness();
			$res = rest_ensure_response( array( 'ok' => true, 'at' => $f['central'], 'items' => ebm_nation_cards() ) );
			$res->header( 'Cache-Control', ebm_is_public() ? 'public, max-age=3600' : 'private, no-store' );
			return $res;
		},
	) );
} );

/** 지역 결과 묶음(REST·첫 화면 공통) */
function ebm_region_payload( $sd, $sg = '', $r = '' ) {
	$res = ebm_resolve( $sd, $sg, $r );
	$f   = ebm_freshness();
	$out = array(
		'ok'    => true,
		'at'    => array( 'local' => $f['local'], 'central' => $f['central'], 'stale' => $f['stale'] ),
		'today' => current_time( 'Y-m-d' ),
	);
	if ( $res['bad'] || '' === $res['sd'] ) {
		return array_merge( $out, array( 'ok' => false, 'err' => 'region', 'msg' => '지역을 찾지 못했어요. 목록에서 다시 골라 주세요.' ) );
	}
	$out['sd'] = $res['sd'];
	$out['sg'] = $res['sg'];
	$out['label'] = ebm_region_label( $res['sd'], $res['sg'] );
	$out['moved'] = $res['moved'];
	if ( $res['split'] ) {
		$out['split'] = array(
			'from'    => $res['split']['n'],
			'note'    => $res['split']['note'],
			'choices' => array_map( function ( $id ) {
				$g = ebm_sgg( $id );
				return array( 'id' => $id, 'n' => $g ? $g['n'] : $id );
			}, $res['split']['to'] ),
		);
		return $out;
	}
	$r            = ebm_region_result( $res['sd'], $res['sg'] );
	$out['groups']   = $r['groups'];
	$out['nation_n'] = $r['nation_n'];
	$keys = array();
	foreach ( $r['groups'] as $list ) {
		foreach ( $list as $c ) {
			if ( ! empty( $c['st']['cal'] ) ) {
				$keys[] = $c['st']['cal'];
			}
		}
	}
	$out['cal'] = ebm_region_cal( $res['sd'], $res['sg'], $keys );
	return $out;
}
