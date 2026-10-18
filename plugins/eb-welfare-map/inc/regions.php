<?php
/**
 * 지역 코드표
 *
 * 내부 지역 ID = 통계청(SGIS) 행정구역 코드. 시·도 2자리, 시·군·구 5자리.
 * 일반구가 있는 시(수원시 장안구 등)는 사이트 지역 단위에 맞춰 시 하나로 묶고 '앞 4자리 + 0'(수원시 41110)을 씀.
 * 세종특별자치시(36)는 시·군·구가 없는 단층이라 시·도 하나만 있음.
 *
 * 이름이 바뀌어도 옛 공유 링크가 열리도록 옛 이름을 지금 지역으로 이어 줌(data/regions.json의 sdAlias·sgAlias).
 *   예) 광주광역시 광산구 → 전남광주통합특별시 광산구(12330), 인천 동구 → 제물포구(28125)
 *   둘 이상으로 나뉜 곳(인천 옛 중구 → 제물포구·영종구)은 하나로 정하지 않고 고르게 함.
 */

defined( 'ABSPATH' ) || exit;

function ebm_regions() {
	static $r = null;
	if ( null === $r ) {
		$r = json_decode( (string) file_get_contents( EBM_DIR . 'data/regions.json' ), true );
		if ( ! is_array( $r ) ) {
			$r = array( 'sido' => array(), 'sdAlias' => array(), 'sgAlias' => array(), 'ver' => '' );
		}
		$r['bySd'] = array();
		$r['bySg'] = array();
		foreach ( $r['sido'] as $i => $sd ) {
			$r['bySd'][ $sd['id'] ] = $i;
			foreach ( $sd['g'] as $j => $g ) {
				$r['bySg'][ $g['id'] ] = array( $i, $j );
			}
		}
	}
	return $r;
}

/** 시·도 하나: array( id, n(정식 이름), s(짧은 이름), g(시·군·구 목록) ) 또는 null */
function ebm_sido( $code ) {
	$r = ebm_regions();
	return isset( $r['bySd'][ $code ] ) ? $r['sido'][ $r['bySd'][ $code ] ] : null;
}

/** 시·군·구 하나: array( id, n, sd(시·도 코드), sdn(시·도 이름) ) 또는 null */
function ebm_sgg( $id ) {
	$r = ebm_regions();
	if ( ! isset( $r['bySg'][ $id ] ) ) {
		return null;
	}
	list( $i, $j ) = $r['bySg'][ $id ];
	$sd            = $r['sido'][ $i ];
	$g             = $sd['g'][ $j ];
	return array( 'id' => $g['id'], 'n' => $g['n'], 'sd' => $sd['id'], 'sdn' => $sd['n'], 'sds' => $sd['s'] );
}

function ebm_norm_name( $s ) {
	return preg_replace( '/\s+/u', '', (string) $s );
}

/** 시·도 이름(정식·짧은·옛 이름) 또는 코드 → 코드('' = 모름) */
function ebm_sd_code( $name ) {
	$name = ebm_norm_name( $name );
	if ( '' === $name ) {
		return '';
	}
	$r = ebm_regions();
	if ( isset( $r['bySd'][ $name ] ) ) {
		return $name;
	}
	foreach ( $r['sido'] as $sd ) {
		if ( $sd['n'] === $name || $sd['s'] === $name ) {
			return $sd['id'];
		}
	}
	return isset( $r['sdAlias'][ $name ] ) ? (string) $r['sdAlias'][ $name ] : '';
}

/** 시·도 안의 시·군·구 이름 → 시·군·구 ID('' = 없음) */
function ebm_sg_id( $sd_code, $name ) {
	$name = ebm_norm_name( $name );
	$sd   = ebm_sido( $sd_code );
	if ( ! $sd || '' === $name ) {
		return '';
	}
	foreach ( $sd['g'] as $g ) {
		if ( $g['n'] === $name || $g['id'] === $name ) {
			return $g['id'];
		}
	}
	return '';
}

/** 옛 시·군·구 이름이면 이어 줄 정보 array( to => [ID…], note ) */
function ebm_sg_alias( $sd_code, $name ) {
	$name = ebm_norm_name( $name );
	foreach ( (array) ebm_regions()['sgAlias'] as $a ) {
		if ( $a['sd'] === $sd_code && $a['n'] === $name ) {
			return $a;
		}
	}
	return null;
}

/**
 * 주소의 sd·sg(이름 또는 코드)·r(코드) → 지역
 * @return array sd(코드)·sg(시·군·구 ID 또는 '')·split(옛 이름이 둘 이상으로 나뉨: alias)·moved(옛 이름을 이어 줌)·bad(못 찾음)
 */
function ebm_resolve( $sd, $sg = '', $r = '' ) {
	$out = array( 'sd' => '', 'sg' => '', 'split' => null, 'moved' => false, 'bad' => false );
	$r   = preg_replace( '/\D/', '', (string) $r );
	if ( '' !== $r ) {
		if ( 5 === strlen( $r ) && ebm_sgg( $r ) ) {
			$g = ebm_sgg( $r );
			return array_merge( $out, array( 'sd' => $g['sd'], 'sg' => $g['id'] ) );
		}
		if ( 2 === strlen( $r ) && ebm_sido( $r ) ) {
			return array_merge( $out, array( 'sd' => $r ) );
		}
		$out['bad'] = true;
		return $out;
	}
	$code = ebm_sd_code( $sd );
	if ( '' === $code ) {
		$out['bad'] = '' !== trim( (string) $sd );
		return $out;
	}
	$out['sd']    = $code;
	$out['moved'] = ebm_norm_name( $sd ) !== ebm_sido( $code )['n'] && ebm_norm_name( $sd ) !== $code && ebm_norm_name( $sd ) !== ebm_sido( $code )['s'];
	if ( '' === trim( (string) $sg ) || '36' === $code ) {
		return $out;
	}
	$id = ebm_sg_id( $code, $sg );
	if ( $id ) {
		$out['sg'] = $id;
		return $out;
	}
	$al = ebm_sg_alias( $code, $sg );
	if ( $al ) {
		if ( 1 === count( $al['to'] ) ) {
			$out['sg']    = $al['to'][0];
			$out['moved'] = true;
		} else {
			$out['split'] = $al;
		}
		return $out;
	}
	$out['bad'] = true;
	return $out;
}

/** 화면 표시 이름: '경기도 수원시', '세종특별자치시' */
function ebm_region_label( $sd, $sg = '', $short = false ) {
	$s = ebm_sido( $sd );
	if ( ! $s ) {
		return '';
	}
	$name = $short ? $s['s'] : $s['n'];
	if ( $sg ) {
		$g = ebm_sgg( $sg );
		return $g ? $name . ' ' . $g['n'] : $name;
	}
	return $name;
}

/** 공유·새로고침용 주소(이름으로 - 읽기 쉬움, 옛 이름도 이어 줌) */
function ebm_region_url( $sd, $sg = '', $extra = array() ) {
	$q = array();
	if ( $sd ) {
		$s       = ebm_sido( $sd );
		$q['sd'] = $s ? $s['n'] : $sd;
		if ( $sg ) {
			$g       = ebm_sgg( $sg );
			$q['sg'] = $g ? $g['n'] : $sg;
		}
	}
	return add_query_arg( array_map( 'rawurlencode', array_merge( $q, array_filter( (array) $extra, 'strlen' ) ) ), ebm_url() );
}

/** 테마·캘린더가 쓰는 지역 이름(복지로·정부24 정식 이름) → 같은 ID. 둘 다 정식 이름이라 그대로 맞음 */
function ebm_site_names( $sd, $sg = '' ) {
	$s = ebm_sido( $sd );
	$g = $sg ? ebm_sgg( $sg ) : null;
	return array( 'sd' => $s ? $s['n'] : '', 'sg' => $g ? $g['n'] : '' );
}

/** 브라우저용 지역 목록(검색·목록·지도 공통) - 작게 */
function ebm_regions_for_js() {
	$r   = ebm_regions();
	$out = array( 'ver' => $r['ver'], 'sd' => array(), 'al' => array() );
	foreach ( $r['sido'] as $sd ) {
		$out['sd'][] = array( $sd['id'], $sd['n'], $sd['s'], array_map( function ( $g ) {
			return array( $g['id'], $g['n'] );
		}, $sd['g'] ) );
	}
	foreach ( (array) $r['sdAlias'] as $name => $code ) {
		$out['al'][] = array( $name, (string) $code, '' );
	}
	foreach ( (array) $r['sgAlias'] as $a ) {
		$out['al'][] = array( $a['n'], $a['sd'], implode( ',', $a['to'] ), $a['note'] );
	}
	return $out;
}
