<?php
/**
 * 화면에 보일 일정 목록 만들기
 *
 * 출처 3가지를 한 모양으로 합침:
 *   gov24  : 정부24 자동 수집(ebs_raw) + 검수 결과(ebs_review)
 *   manual : 관리자가 직접 추가(ebs_manual)
 *   rule   : 테마의 법정 신청·납부 기간(eb_deadline_rules, 세금·근로장려금)
 *
 * 정부24 항목 기본 노출 규칙(ebs_auto):
 *   'central' = 중앙부처 사업이고 연도가 적힌 기간이면 자동 노출, 나머지는 검수 대기
 *   'none'    = 모두 검수 후 노출
 */

defined( 'ABSPATH' ) || exit;

function ebs_personas() {
	return array(
		'senior'   => '어르신',
		'parent'   => '부모·아이',
		'youth'    => '청년·학생',
		'low'      => '저소득',
		'disabled' => '장애인',
		'worker'   => '일하는 분·사업자',
	);
}

function ebs_categories() {
	return array( '복지', '생활안정', '주거', '에너지', '교육', '건강', '일자리', '문화', '임신·출산', '보육', '세금' );
}

function ebs_guess_who( $text ) {
	$map = array(
		'senior'   => '/노인|어르신|65세|고령|기초연금/u',
		'parent'   => '/아동|영유아|출산|임신|임산부|자녀|양육|육아|보육|신생아|다자녀|한부모|부모/u',
		'youth'    => '/청년|대학생|대학원생|학생|청소년|장학|19세|34세|39세/u',
		'low'      => '/수급|차상위|저소득|중위소득|취약계층|한부모/u',
		'disabled' => '/장애/u',
		'worker'   => '/근로|소상공인|사업자|자영업|중소기업|농업인|어업인|구직|실업|창업|직장/u',
	);
	$out = array();
	foreach ( $map as $k => $re ) {
		if ( preg_match( $re, (string) $text ) ) {
			$out[] = $k;
		}
	}
	return $out;
}

/** 서비스분야 → 짧은 분류 이름 */
function ebs_field_label( $field ) {
	$f = (string) $field;
	$map = array(
		'에너지'  => '/에너지|난방|연료/u',
		'주거'   => '/주거|주택/u',
		'교육'   => '/교육|장학/u',
		'보육'   => '/보육/u',
		'임신·출산' => '/임신|출산/u',
		'건강'   => '/보건|의료|건강/u',
		'일자리'  => '/고용|창업|일자리/u',
		'문화'   => '/문화|체육|관광/u',
		'생활안정' => '/생활안정|생계/u',
	);
	foreach ( $map as $label => $re ) {
		if ( preg_match( $re, $f ) ) {
			return $label;
		}
	}
	return '복지';
}

/** 소관기관유형: central(중앙행정기관) | public(공공기관 — 한전·발전사 등) | local(지자체) */
function ebs_org_kind( $it ) {
	$t = (string) ( isset( $it['orgt'] ) ? $it['orgt'] : '' );
	if ( false !== strpos( $t, '중앙' ) ) {
		return 'central';
	}
	if ( preg_match( '/시도|시군구|지방|자치/u', $t ) ) { // 정부24 값: 중앙행정기관 · 공공기관 · 광역시도 · 시군구
		return 'local';
	}
	if ( '' !== $t ) {
		return 'public';
	}
	return ebs_is_local_name( isset( $it['org'] ) ? $it['org'] : '' ) ? 'local' : 'central';
}

function ebs_is_central( $it ) {
	return 'central' === ebs_org_kind( $it );
}

function ebs_is_local_name( $org ) {
	return (bool) preg_match( '/^(서울|부산|대구|인천|광주|대전|울산|세종|경기|강원|충청|충북|충남|전라|전북|전남|경상|경북|경남|제주)|[가-힣]+(시|군|구)\s|[가-힣]+(시|군|구)$/u', $org );
}

/** 대상 문구 머리 정리: "1. 지원대상: …", "□ (지원대상) …", "- …" → "…" */
function ebs_clean_lead( $t ) {
	$t = trim( wp_strip_all_tags( (string) $t ) );
	for ( $i = 0; $i < 3; $i++ ) {
		$t = preg_replace( '/^\s*(?:\d{1,2}\s*[.)]|[○◦•·\-\*※□■▪❍ㅇ①-⑳➊-➓❶-❿<〈\[(【]+)\s*/u', '', $t );
		$t = preg_replace( '/^\s*[(\[<〈【]?\s*(?:지원\s*대상|신청\s*자격|신청\s*대상|기본\s*자격\s*요건|자격\s*요건|대상자?|지원\s*조건|신청\s*가구)\s*[)\]>〉】]?\s*[:：]?\s*/u', '', $t );
	}
	return $t;
}

function ebs_has_year( $it ) {
	foreach ( (array) $it['p'] as $p ) {
		if ( empty( $p['ny'] ) ) {
			return true;
		}
	}
	return false;
}

/** 소관기관명 → [시·도, 시·군·구]: "서울특별시 관악구" → ['서울특별시', '관악구'], "충청남도교육청" → ['충청남도', ''] */
function ebs_region_of( $org ) {
	$org = trim( preg_replace( '/\s+/u', ' ', (string) $org ) );
	$org = preg_replace( '/\s*교육청$/u', '', $org );
	$p   = explode( ' ', $org );
	$sd  = isset( $p[0] ) ? $p[0] : '';
	if ( ! preg_match( '/(특별시|광역시|특별자치시|특별자치도|도)$/u', $sd ) ) {
		return array( '', '' ); // '(재)○○진흥원'처럼 시·도 이름이 아닌 기관
	}
	$sg  = isset( $p[1] ) && preg_match( '/(시|군|구)$/u', $p[1] ) ? $p[1] : '';
	return array( $sd, $sg );
}

/** 달력 칸에 들어갈 짧은 이름: 괄호 빼고 10자 안쪽 */
function ebs_short_name( $name ) {
	$n = trim( preg_replace( '/\s+/u', ' ', preg_replace( '/[(\[（][^)\]）]*[)\]）]/u', '', (string) $name ) ) );
	$n = '' === $n ? (string) $name : $n;
	if ( function_exists( 'mb_strlen' ) && mb_strlen( $n ) > 10 ) {
		$n = rtrim( mb_substr( $n, 0, 9 ) ) . '…';
	}
	return $n;
}

/** 메가메뉴 미니 달력에 점 찍을 날짜(접수 중은 마감일, 예정은 시작일) - 지역 사업 제외 */
function ebs_due_marks() {
	static $m = null;
	if ( null === $m ) {
		$m = array();
		foreach ( ebs_items( array( 'ahead' => 70 ) ) as $x ) {
			$m[] = $x['open'] || ! $x['s'] ? $x['e'] : $x['s'];
		}
		$m = array_values( array_unique( $m ) );
	}
	return $m;
}

/** 월간 달력(테마 eb_calendar, 'eb_calendar_data' 필터): 시작·마감 표시 + '이달 내내 접수 중' 목록. 지역 사업은 [5]에 '시도|시군구' */
add_filter( 'eb_calendar_data', function ( $data ) {
	$first = current_time( 'Y-m' ) . '-01';
	$data['ongoing'] = array();
	foreach ( ebs_items( array( 'ahead' => 120, 'local' => true ) ) as $x ) {
		if ( 'rule' === $x['src'] ) {
			continue; // 법정 기간은 테마가 이미 넣음
		}
		$short = ebs_short_name( $x['name'] );
		$per   = ebs_range( $x['s'], $x['e'], true );
		$rk    = $x['local'] ? $x['sd'] . '|' . $x['sg'] : '';
		if ( $x['s'] && $x['s'] >= $first ) {
			$data['dues'][ $x['s'] ][] = array( 's', $x['name'], $x['e'], $short, $per, $rk );
		}
		$data['dues'][ $x['e'] ][] = array( 'e', $x['name'], $x['e'], $short, $per, $rk );
		$data['ongoing'][]         = array( $x['name'], $x['s'], $x['e'], $rk, $x['guide'] ? $x['guide'] : $x['apply'] );
	}
	return $data;
} );

function ebs_review() {
	return (array) get_option( 'ebs_review', array() );
}

/** 정부24 한 항목의 노출 상태: show | hide | auto(자동 노출) | wait(검수 대기) */
function ebs_state( $it, $rev = null ) {
	$rev = null === $rev ? ebs_review() : $rev;
	$id  = $it['id'];
	if ( isset( $rev[ $id ]['st'] ) && in_array( $rev[ $id ]['st'], array( 'show', 'hide' ), true ) ) {
		return $rev[ $id ]['st'];
	}
	$has_year = false;
	foreach ( $it['p'] as $p ) {
		if ( empty( $p['ny'] ) ) {
			$has_year = true;
		}
	}
	if ( 'central' === get_option( 'ebs_auto', 'central' ) && $has_year && ebs_is_central( $it ) ) {
		return 'auto';
	}
	return 'wait';
}

/** 오늘 이후 가장 가까운 기간 하나(끝났으면 null) */
function ebs_pick_period( $periods, $today ) {
	$best = null;
	foreach ( (array) $periods as $p ) {
		$p = ebs_roll_year( $p, $today );
		if ( $p['e'] < $today ) {
			continue;
		}
		if ( ! $best || $p['e'] < $best['e'] ) {
			$best = $p;
		}
	}
	return $best;
}

function ebs_guide_url( $guide ) {
	$guide = (int) $guide;
	if ( $guide && 'publish' === get_post_status( $guide ) ) {
		return get_permalink( $guide );
	}
	return '';
}

/**
 * @param array $o ahead = 며칠 뒤 시작까지 '곧 시작'으로 볼지, today = 'Y-m-d', all = 숨김·대기까지(관리 화면용)
 * @return array[] key, src, id, name, s, e, open, cat, who, target, amount, guide, apply, apply_label, org, state
 */
function ebs_items( $o = array() ) {
	$o     = wp_parse_args( $o, array( 'ahead' => 60, 'today' => current_time( 'Y-m-d' ), 'all' => false, 'local' => false ) );
	$today = $o['today'];
	$until = gmdate( 'Y-m-d', strtotime( $today . ' +' . (int) $o['ahead'] . ' days' ) );
	$rev   = ebs_review();
	$out   = array();

	// 1) 정부24
	foreach ( (array) get_option( 'ebs_raw', array() ) as $it ) {
		$state = ebs_state( $it, $rev );
		$local = 'local' === ebs_org_kind( $it );
		if ( ! $o['all'] && ! in_array( $state, array( 'show', 'auto' ), true ) ) {
			// 지역(지자체) 사업: 숨기지 않았고 연도가 적힌 기간이면, 그 지역 방문자에게만 보이도록 함께 내보냄(local = true)
			if ( ! ( $o['local'] && $local && 'wait' === $state && ebs_has_year( $it ) ) ) {
				continue;
			}
		}
		if ( ! $o['local'] && $local && ! $o['all'] ) {
			continue; // 메뉴·알림 줄처럼 지역을 모르는 곳에는 지역 사업을 넣지 않음
		}
		$p = ebs_pick_period( $it['p'], $today );
		if ( ! $p || ( $p['s'] && $p['s'] > $until ) ) {
			continue;
		}
		$r     = isset( $rev[ $it['id'] ] ) ? (array) $rev[ $it['id'] ] : array();
		$who   = ! empty( $r['who'] ) ? (array) $r['who'] : ebs_guess_who( $it['n'] . ' ' . $it['tgt'] . ' ' . $it['sum'] );
		$rg    = $local ? ebs_region_of( $it['org'] ) : array( '', '' );
		$out[] = array(
			'local'       => $local,
			'sd'          => $rg[0],
			'sg'          => $rg[1],
			'key'         => 'g-' . $it['id'],
			'src'         => 'gov24',
			'id'          => $it['id'],
			'name'        => ! empty( $r['name'] ) ? $r['name'] : $it['n'],
			's'           => $p['s'],
			'e'           => $p['e'],
			'ny'          => ! empty( $p['ny'] ),
			'cat'         => ! empty( $r['cat'] ) ? $r['cat'] : ebs_field_label( $it['field'] . ' ' . $it['n'] ),
			'who'         => $who,
			'target'      => ! empty( $r['target'] ) ? $r['target'] : ebs_cut( ebs_clean_lead( $it['tgt'] ? $it['tgt'] : $it['sum'] ), 44 ),
			'amount'      => isset( $r['amount'] ) && '' !== $r['amount'] ? $r['amount'] : ebs_amount_hint( $it['cnt'] ),
			'guide'       => ebs_guide_url( isset( $r['guide'] ) ? $r['guide'] : 0 ),
			'apply'       => ! empty( $r['apply'] ) ? $r['apply'] : $it['url'],
			'apply_label' => ! empty( $r['apply_label'] ) ? $r['apply_label'] : '정부24',
			'org'         => $it['org'],
			'state'       => $state,
			'raw'         => $it['raw'],
		);
	}

	// 2) 직접 추가
	foreach ( (array) get_option( 'ebs_manual', array() ) as $m ) {
		if ( empty( $m['on'] ) && ! $o['all'] ) {
			continue;
		}
		$p = ebs_pick_period( array( array( 's' => $m['s'], 'e' => $m['e'], 'ny' => ! empty( $m['yearly'] ) ) ), $today );
		if ( ! $p || ( $p['s'] && $p['s'] > $until ) ) {
			continue;
		}
		$out[] = array(
			'key'         => 'm-' . $m['id'],
			'src'         => 'manual',
			'id'          => $m['id'],
			'name'        => $m['n'],
			's'           => $p['s'],
			'e'           => $p['e'],
			'ny'          => ! empty( $m['yearly'] ),
			'cat'         => $m['cat'] ? $m['cat'] : '복지',
			'who'         => (array) $m['who'],
			'target'      => $m['target'],
			'amount'      => $m['amount'],
			'guide'       => ebs_guide_url( $m['guide'] ),
			'apply'       => $m['url'],
			'apply_label' => $m['url_label'] ? $m['url_label'] : '신청하는 곳',
			'org'         => '',
			'state'       => empty( $m['on'] ) ? 'hide' : 'show',
			'raw'         => '',
		);
	}

	// 3) 테마의 법정 신청·납부 기간
	foreach ( ebs_rule_items( $today, $until ) as $r ) {
		$out[] = $r;
	}

	foreach ( $out as &$x ) {
		$x        += array( 'local' => false, 'sd' => '', 'sg' => '' );
		$x['open'] = ( ! $x['s'] || $x['s'] <= $today ) && $today <= $x['e'];
	}
	unset( $x );

	usort( $out, function ( $a, $b ) {
		if ( $a['open'] !== $b['open'] ) {
			return $a['open'] ? -1 : 1;
		}
		return $a['open'] ? strcmp( $a['e'], $b['e'] ) : strcmp( $a['s'], $b['s'] );
	} );

	return apply_filters( 'ebs_items', $out, $o );
}

function ebs_rule_items( $today, $until ) {
	if ( ! function_exists( 'eb_deadline_rules' ) || ! function_exists( 'eb_due_date' ) ) {
		return array();
	}
	$hide = (array) get_option( 'ebs_rule_hide', array() );
	$y    = (int) substr( $today, 0, 4 );
	$out  = array();
	foreach ( eb_deadline_rules() as $r ) {
		$name = $r[1];
		if ( in_array( $name, $hide, true ) ) {
			continue;
		}
		foreach ( array( $y, $y + 1 ) as $yy ) {
			$s = $r[2] ? $yy . '-' . $r[2] : '';
			$e = eb_due_date( $yy, $r[3] )->format( 'Y-m-d' );
			if ( $e < $today || ( $s && $s > $until ) ) {
				continue;
			}
			$is_tax = false === strpos( $name, '장려금' );
			$wetax  = preg_match( '/자동차세|재산세|주민세/u', $name );
			// 같은 이름이 해마다 여러 번 있으면(자동차세 연납 등) 가장 가까운 것 하나만
			if ( isset( $out[ $name ] ) && $out[ $name ]['e'] <= $e ) {
				continue;
			}
			$out[ $name ] = array(
				'key'         => 'r-' . md5( $name ),
				'src'         => 'rule',
				'id'          => $name,
				'name'        => $name,
				's'           => $s,
				'e'           => $e,
				'ny'          => false,
				'cat'         => $is_tax ? '세금' : '복지',
				'who'         => $is_tax ? array( 'worker' ) : array( 'worker', 'low' ),
				'target'      => $is_tax ? '' : '소득·재산 요건을 갖춘 근로·사업소득 가구',
				'amount'      => '',
				'guide'       => '',
				'apply'       => $wetax ? 'https://www.wetax.go.kr/' : 'https://www.hometax.go.kr/',
				'apply_label' => $wetax ? '위택스' : '홈택스',
				'org'         => '',
				'state'       => 'show',
				'raw'         => '',
			);
		}
	}
	$rules = get_option( 'ebs_rule_guides', array() );
	foreach ( $out as $name => &$x ) {
		if ( ! empty( $rules[ $name ] ) ) {
			$x['guide'] = ebs_guide_url( $rules[ $name ] );
		}
	}
	unset( $x );
	return array_values( $out );
}

/**
 * 테마(GeneratePress Child functions.php)와 잇는 곳
 *
 * eb_upcoming_dues()에 apply_filters( 'eb_upcoming_dues', $dues, $today )를 넣어 두면,
 * 메뉴 '다가오는 일정'·홈 알림 줄·달력 카드에도 정부24·직접 추가 일정이 함께 들어갑니다.
 * 테마의 법정 기간(rule)은 이미 $dues에 있으니 빼고 더합니다.
 */

add_filter( 'eb_upcoming_dues', function ( $dues, $today = null ) {
	$label = function ( $ymd ) {
		if ( function_exists( 'eb_payday_label' ) ) {
			return eb_payday_label( new DateTimeImmutable( $ymd, wp_timezone() ) );
		}
		return ebs_md( $ymd );
	};
	static $add = null; // 한 페이지에서 여러 번 불려도 한 번만 계산
	if ( null !== $add ) {
		return ebs_merge_dues( $dues, $add );
	}
	$add = array();
	foreach ( ebs_items( array( 'ahead' => 45 ) ) as $x ) {
		if ( 'rule' === $x['src'] ) {
			continue;
		}
		$add[] = array(
			'n'  => $x['name'],
			'k'  => '',
			'e'  => $x['e'],
			'el' => ebs_year_mark( $x['s'], $x['e'], $x['e'] ) . $label( $x['e'] ),
			'ej' => gmdate( 'n.j', strtotime( $x['e'] . ' 12:00:00 UTC' ) ),
			's'  => $x['s'],
			'sl' => $x['s'] ? ebs_year_mark( $x['s'], $x['e'], $x['s'] ) . $label( $x['s'] ) : '',
		);
	}
	return ebs_merge_dues( $dues, $add );
}, 10, 2 );

function ebs_merge_dues( $dues, $add ) {
	if ( ! $add ) {
		return $dues;
	}
	$dues = array_merge( (array) $dues, $add );
	usort( $dues, function ( $a, $b ) {
		return strcmp( $a['e'], $b['e'] );
	} );
	return $dues;
}
