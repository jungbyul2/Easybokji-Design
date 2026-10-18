<?php
/**
 * 정부24 '신청기한' 글자 → 기간 목록
 *
 * 들어오는 모양(2026-10 확인):
 *   "2026. 6. 15.(월) ~ 2026. 12. 31.(목)"      → 2026-06-15 ~ 2026-12-31
 *   "2026. 2. 2. ~ 11. 30."                      → 끝 연도 생략 = 시작 연도
 *   "2026년 3월 30일(월) 09:00 ~ 5월 29일(금) 16:00"
 *   "(1차) 2026년 5월 22일~6월 22일 (2차) 2026년 8월 12일~ 9월 9일" → 기간 2개
 *   "2026. 6. 8.~6.19. 18:00까지"
 *   "2026. 11. 30.까지"                          → 시작 없이 마감만
 *   "○ 정기신청 : 5.1.~5.31."                     → 연도 없음(ny = 해마다 반복으로 보고 검수 대기)
 *   "상시신청", "연 2회", "공고 시" ...           → 기간 없음(빈 배열)
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return array[] 각 항목 array( 's' => 'Y-m-d' 또는 ''(시작 없음), 'e' => 'Y-m-d', 'ny' => 연도 없이 적힌 기간인지 )
 */
function ebs_parse_periods( $text, $ref_year = 0 ) {
	$t = (string) $text;
	if ( '' === trim( $t ) ) {
		return array();
	}
	$ref_year = $ref_year ? (int) $ref_year : (int) current_time( 'Y' );
	$t        = str_replace( array( '～', '∼', '〜', '~', '–', '—' ), '~', $t );
	$t        = preg_replace( "/[’‘']\s?(\d{2})\s*\./u", '20$1.', $t ); // '26. 2. 25. → 2026. 2. 25.

	// 날짜 한 개: [연도 + (년|.|-|/)] 월 (월|.|-|/) 일 [일|.]
	$re = '/(?:(20\d{2})\s*(?:년|[.\-\/])\s*)?(\d{1,2})\s*(?:월|[.\-\/])\s*(\d{1,2})\s*(?:일|\.)?/u';
	if ( ! preg_match_all( $re, $t, $m, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
		return array();
	}

	$toks = array();
	foreach ( $m as $x ) {
		$mo = (int) $x[2][0];
		$d  = (int) $x[3][0];
		if ( $mo < 1 || $mo > 12 || $d < 1 || $d > 31 ) {
			continue; // 전화번호(02-721-0600) 같은 숫자 걸러냄
		}
		$y      = ( isset( $x[1] ) && $x[1][1] >= 0 && '' !== $x[1][0] ) ? (int) $x[1][0] : 0;
		$toks[] = array(
			'y' => $y,
			'm' => $mo,
			'd' => $d,
			'a' => $x[0][1],
			'b' => $x[0][1] + strlen( $x[0][0] ),
		);
	}

	$out       = array();
	$last_year = 0;
	$n         = count( $toks );
	for ( $i = 0; $i < $n; $i++ ) {
		$a = $toks[ $i ];
		if ( $a['y'] ) {
			$last_year = $a['y'];
		}
		$next = $i + 1 < $n ? $toks[ $i + 1 ] : null;
		$gap  = $next ? substr( $t, $a['b'], $next['a'] - $a['b'] ) : '';

		// 시작 ~ 끝 (사이에 요일·시각 정도만 허용)
		if ( $next && strlen( $gap ) <= 40 && false !== strpos( $gap, '~' ) ) {
			$sy = $a['y'] ? $a['y'] : $last_year;
			$ny = ! $sy;
			$sy = $sy ? $sy : $ref_year;
			$ey = $next['y'] ? $next['y'] : $sy;
			if ( $next['y'] ) {
				$last_year = $next['y'];
			}
			$s = ebs_ymd( $sy, $a['m'], $a['d'] );
			$e = ebs_ymd( $ey, $next['m'], $next['d'] );
			if ( $s && $e && $e < $s && ! $next['y'] ) {
				$e = ebs_ymd( $ey + 1, $next['m'], $next['d'] ); // 12.1 ~ 1.31 처럼 해를 넘는 기간
			}
			if ( $s && $e && $e >= $s && ebs_days( $s, $e ) <= 400 ) {
				$out[] = array( 's' => $s, 'e' => $e, 'ny' => $ny );
			}
			$i++;
			continue;
		}

		// 마감만: "2026. 11. 30.까지"
		$after = substr( $t, $a['b'], 24 );
		if ( false !== strpos( $after, '까지' ) && ( $a['y'] || $last_year ) ) {
			$e = ebs_ymd( $a['y'] ? $a['y'] : $last_year, $a['m'], $a['d'] );
			if ( $e ) {
				$out[] = array( 's' => '', 'e' => $e, 'ny' => false );
			}
		}
	}
	return $out;
}

function ebs_ymd( $y, $m, $d ) {
	return checkdate( (int) $m, (int) $d, (int) $y ) ? sprintf( '%04d-%02d-%02d', $y, $m, $d ) : '';
}

function ebs_days( $from, $to ) {
	return (int) round( ( strtotime( $to . ' 00:00:00 UTC' ) - strtotime( $from . ' 00:00:00 UTC' ) ) / DAY_IN_SECONDS );
}

/** 연도 없이 적힌 기간(해마다 반복)을 오늘 기준 올해 또는 내년 날짜로 */
function ebs_roll_year( $p, $today ) {
	if ( empty( $p['ny'] ) ) {
		return $p;
	}
	$y = (int) substr( $today, 0, 4 );
	foreach ( array( $y, $y + 1 ) as $yy ) {
		$s = $p['s'] ? $yy . substr( $p['s'], 4 ) : '';
		$e = $yy . substr( $p['e'], 4 );
		if ( $s && $e < $s ) {
			$e = ( $yy + 1 ) . substr( $p['e'], 4 );
		}
		if ( $e >= $today ) {
			return array( 's' => $s, 'e' => $e, 'ny' => true );
		}
	}
	return $p;
}

/** "6.15(월)" */
function ebs_md( $ymd ) {
	if ( ! $ymd ) {
		return '';
	}
	$w = array( '일', '월', '화', '수', '목', '금', '토' );
	$t = strtotime( $ymd . ' 12:00:00 UTC' );
	return gmdate( 'n.j', $t ) . '(' . $w[ (int) gmdate( 'w', $t ) ] . ')';
}

/** 기간 "6.15(월) ~ 12.31(목)". 시작·끝의 해가 다르면 '25.12.22(월) ~ '26.12.11(금)처럼 연도를 붙임(거꾸로 보이지 않게, 2026-10-15). $nj = 요일 없이 "12.22~12.11" */
function ebs_range( $s, $e, $nj = false ) {
	$one = function ( $ymd ) use ( $s, $e, $nj ) {
		return ebs_year_mark( $s, $e, $ymd ) . ( $nj ? gmdate( 'n.j', strtotime( $ymd . ' 12:00:00 UTC' ) ) : ebs_md( $ymd ) );
	};
	return trim( ( $s ? $one( $s ) : '' ) . ( $nj ? '~' : ' ~ ' ) . $one( $e ) );
}

/** 해를 넘는 기간이면 "'25." 같은 연도 머리(아니면 빈 글자) */
function ebs_year_mark( $s, $e, $ymd ) {
	return $s && substr( $s, 0, 4 ) !== substr( $e, 0, 4 ) ? "'" . substr( $ymd, 2, 2 ) . '.' : '';
}

/** 지원내용에서 금액 한 토막: "월 최대 20만원", "연 15만원", "최대 4,000만 원" */
function ebs_amount_hint( $text ) {
	$text = (string) $text;
	if ( preg_match( '/((?:연|월|1인당|가구당|1회)\s*)?(?:최대\s*)?[\d,]+(?:\.\d+)?\s*(?:만|억|천)?\s*원(?:\s*(?:이내|한도|상당))?/u', $text, $m ) ) {
		return trim( preg_replace( '/\s+/u', ' ', $m[0] ) );
	}
	return '';
}

/** 짧게 자르기(한글 기준) */
function ebs_cut( $text, $len ) {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $text ) ) );
	$text = preg_replace( '/^[○◦•·\-\*※\s]+/u', '', $text );
	if ( function_exists( 'mb_strlen' ) && mb_strlen( $text ) > $len ) {
		return rtrim( mb_substr( $text, 0, $len - 1 ) ) . '…';
	}
	return $text;
}
