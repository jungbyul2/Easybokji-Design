<?php
/**
 * 정책 조회 계층
 *
 * 원본(그대로 읽기만 함, 지도용 사본 없음)
 *   eb_ws_local  복지로 지자체 복지서비스(테마 56번이 매일 받음): n,o,s,u,sd,sg,l,h,t (+ id,m,ap,cy,pv - 테마 패치 후)
 *   eb_ws_all    복지로 중앙부처 복지서비스(테마 54번): id,name,org,sum,link,life,hh,them (+ cy,pv,m)
 *   ebm_review   관리자 검수 결과(이 플러그인): 적용 범위·신청 상태·근거·대상/혜택 한 줄·캘린더/글 연결
 *   ebs_items()  복지 캘린더 일정(eb-schedule 플러그인) - 관리자가 연결했거나 확인된(노출 중) 지역 일정만
 *
 * 규칙
 *   - 같은 정책은 복지로 서비스 ID(servId, 없으면 주소의 wlfareInfoId) 하나로만 셈. 이름이 비슷한 것은 합치지 않고 검수 목록에 '중복 후보'로만 올림.
 *   - 적용 지역은 원문의 시·도/시·군·구 칸으로만 정함. 운영 기관 주소로 정하지 않음.
 *     시·군·구 칸이 비었는데 기관·이름에 시·군·구가 보이면 '시·도 전체'로 단정하지 않고 '적용 지역 확인 필요'로 둠(관리자가 정함).
 *   - 신청 상태는 근거가 있을 때만: 관리자가 확인한 기간·상시 / 복지 캘린더의 확인된 일정. 그 밖은 '기간 확인 필요'.
 */

defined( 'ABSPATH' ) || exit;

function ebm_review_all() {
	return (array) get_option( 'ebm_review', array() );
}

/** 캐시 열쇠: 원본 받은 시각·검수 판·코드표 판이 바뀌면 새로 계산 */
function ebm_stamp() {
	return md5( (int) get_option( 'eb_ws_local_synced' ) . '|' . (int) get_option( 'eb_ws_synced' ) . '|' . (int) get_option( 'ebm_review_rev', 0 ) . '|' . EBM_VER . '|' . ebm_regions()['ver'] );
}

// 복지로 자료를 새로 받으면 지도 첫 화면(WP Rocket 캐시) 건수도 새로
add_action( 'update_option_eb_ws_local_synced', 'ebm_purge_page' );
add_action( 'update_option_eb_ws_synced', 'ebm_purge_page' );
function ebm_purge_page() {
	if ( function_exists( 'rocket_clean_files' ) && function_exists( 'ebm_url' ) ) {
		rocket_clean_files( array( ebm_url() ) );
	}
}

function ebm_flush_cache() {
	update_option( 'ebm_review_rev', (int) get_option( 'ebm_review_rev', 0 ) + 1, false );
	if ( function_exists( 'rocket_clean_files' ) && function_exists( 'ebm_url' ) ) {
		rocket_clean_files( array( ebm_url() ) );
	}
}

/** '임신 · 출산, 영유아' → ['임신·출산','영유아'] (테마 /local과 같은 정리) */
function ebm_list( $s ) {
	if ( is_array( $s ) ) {
		return array_values( array_filter( array_map( 'trim', $s ) ) );
	}
	return array_values( array_filter( array_map( function ( $v ) {
		return preg_replace( '/\s*·\s*/u', '·', trim( $v ) );
	}, explode( ',', (string) $s ) ) ) );
}

function ebm_id_of( $id, $url ) {
	$id = trim( (string) $id );
	if ( '' === $id && preg_match( '/wlfareInfoId=([A-Z0-9]+)/', (string) $url, $m ) ) {
		$id = $m[1];
	}
	return $id;
}

function ebm_ymd( $s ) {
	$s = preg_replace( '/\D/', '', (string) $s );
	return 8 <= strlen( $s ) ? substr( $s, 0, 4 ) . '-' . substr( $s, 4, 2 ) . '-' . substr( $s, 6, 2 ) : '';
}

/**
 * 원문에 시·군·구가 빠졌을 때 기관 이름 두 번째 낱말·사업 이름에 보이는 같은 시·도의 시·군·구(관리자 '추천'과 '확인 필요' 판단에만 씀)
 * @return string[] 시·군·구 ID
 */
function ebm_mentioned_sgg( $sd_code, $name, $org ) {
	$sd = ebm_sido( $sd_code );
	if ( ! $sd || ! $sd['g'] ) {
		return array();
	}
	$hit  = array();
	$toks = preg_split( '/\s+/u', trim( (string) $org ) );
	foreach ( $sd['g'] as $g ) {
		$re = '/(?<![가-힣])' . preg_quote( $g['n'], '/' ) . '(?![가-힣])/u';
		if ( ( isset( $toks[1] ) && $toks[1] === $g['n'] ) || preg_match( $re, (string) $name ) ) {
			$hit[] = $g['id'];
		}
	}
	foreach ( (array) ebm_regions()['sgAlias'] as $a ) {
		if ( $a['sd'] === $sd_code && isset( $toks[1] ) && $toks[1] === $a['n'] ) {
			$hit = array_merge( $hit, $a['to'] );
		}
	}
	return array_values( array_unique( $hit ) );
}

/**
 * 원문 지역 칸(시·도, 시·군·구 여러 쌍) → 적용 범위
 * @param array $pairs [ [sd 이름, sg 이름], ... ]  같은 ID로 여러 줄이 오면 모두
 * @return array sc(sido|sgg|multi|legacy|check), r(지역 ID들), sd(시·도 코드), why, nt(안내)
 */
function ebm_scope_of( $pairs, $name, $org ) {
	$sd_code = '';
	$ids     = array();
	$sido    = false;
	$legacy  = array();
	$why     = '';
	foreach ( $pairs as $p ) {
		$code = ebm_sd_code( $p[0] );
		if ( '' === $code ) {
			return array( 'sc' => 'check', 'r' => array(), 'sd' => '', 'why' => 'sd-unknown', 'nt' => '' );
		}
		$sd_code = $code;
		$sg      = trim( (string) $p[1] );
		if ( '' === $sg || '-' === $sg || '36' === $code ) {
			$sido = true;
			continue;
		}
		if ( preg_match( '/교육청$/u', $sg ) && ! preg_match( '/교육지원청$/u', $sg ) ) {
			$sido = true;
			$why  = 'edu';
			continue;
		}
		foreach ( preg_split( '/\s*,\s*/u', $sg ) as $one ) {
			$id = ebm_sg_id( $code, $one );
			if ( $id ) {
				$ids[] = $id;
				continue;
			}
			$al = ebm_sg_alias( $code, $one );
			if ( $al ) {
				$legacy[] = $al;
				continue;
			}
			return array( 'sc' => 'check', 'r' => array(), 'sd' => $code, 'why' => 'sg-unknown', 'nt' => '원문 시·군·구 "' . $one . '"를 지역 코드표에서 찾지 못했어요.' );
		}
	}
	if ( $sido ) {
		if ( 'edu' !== $why ) {
			// 원문이 시·도까지만 적혀 있는데 시·군·구 기관·이름이 보이면 단정하지 않음
			if ( ebm_mentioned_sgg( $sd_code, $name, $org ) ) {
				return array( 'sc' => 'check', 'r' => array(), 'sd' => $sd_code, 'why' => 'sg-missing', 'nt' => '원문에 시·군·구가 비어 있지만 시·군·구 사업일 수 있어요.' );
			}
			// 통합 전 지역(옛 광주광역시·전라남도) 기준 사업일 수 있음
			if ( '12' === $sd_code && preg_match( '/광주광역시|전라남도|전남도|^광주\s|^전남\s/u', $name . ' ' . preg_replace( '/^전남광주통합특별시/u', '', (string) $org ) ) ) {
				return array( 'sc' => 'check', 'r' => array(), 'sd' => $sd_code, 'why' => 'merged', 'nt' => '통합 전 광주광역시·전라남도 기준 사업일 수 있어요.' );
			}
		}
		return array( 'sc' => 'sido', 'r' => array( $sd_code ), 'sd' => $sd_code, 'why' => $why, 'nt' => '' );
	}
	if ( $legacy ) {
		$to = $ids;
		$nt = array();
		foreach ( $legacy as $al ) {
			$to   = array_merge( $to, $al['to'] );
			$nt[] = $al['note'];
		}
		return array( 'sc' => 'legacy', 'r' => array_values( array_unique( $to ) ), 'sd' => $sd_code, 'why' => 'old-name', 'nt' => implode( ' ', array_unique( $nt ) ) . ' 지금 주소가 해당하는지 확인해 주세요.' );
	}
	$ids = array_values( array_unique( $ids ) );
	if ( ! $ids ) {
		return array( 'sc' => 'check', 'r' => array(), 'sd' => $sd_code, 'why' => 'empty', 'nt' => '' );
	}
	return array( 'sc' => count( $ids ) > 1 ? 'multi' : 'sgg', 'r' => $ids, 'sd' => $sd_code, 'why' => '', 'nt' => '' );
}

/** 관리자 검수의 적용 범위를 덮어씀 */
function ebm_apply_review_scope( $it, $rv ) {
	if ( empty( $rv['sc'] ) || 'auto' === $rv['sc'] ) {
		return $it;
	}
	$it['auto'] = array( 'sc' => $it['sc'], 'r' => $it['r'], 'why' => $it['why'] );
	if ( 'hide' === $rv['sc'] ) {
		$it['sc'] = 'hide';
	} elseif ( 'sido' === $rv['sc'] && $it['sd'] ) {
		$it['sc'] = 'sido';
		$it['r']  = array( $it['sd'] );
	} elseif ( 'sgg' === $rv['sc'] && ! empty( $rv['r'] ) ) {
		$r        = array_values( array_filter( (array) $rv['r'], 'ebm_sgg' ) );
		$it['sc'] = count( $r ) > 1 ? 'multi' : 'sgg';
		$it['r']  = $r;
		if ( $r ) {
			$it['sd'] = ebm_sgg( $r[0] )['sd'];
		}
	}
	$it['why'] = 'review';
	$it['nt']  = '';
	return $it;
}

/**
 * 정규화한 정책 전체 + 지역별 색인 (원본 갱신·검수 저장 때만 다시 계산)
 * @return array items[id] · ix[sgg|sido|check][지역 ID][] · nation[] · dup[] · st(통계)
 */
function ebm_data() {
	static $d = null;
	if ( null !== $d ) {
		return $d;
	}
	$key = 'ebm_data_' . ebm_stamp();
	$d   = get_transient( $key );
	if ( is_array( $d ) ) {
		return $d;
	}
	$rev   = ebm_review_all();
	$items = array();
	$pairs = array();

	// 지역(지자체) 서비스: 같은 ID가 여러 줄이면 지역 칸을 모두 모음
	foreach ( (array) get_option( 'eb_ws_local', array() ) as $s ) {
		if ( empty( $s['n'] ) ) {
			continue;
		}
		$id = ebm_id_of( isset( $s['id'] ) ? $s['id'] : '', isset( $s['u'] ) ? $s['u'] : '' );
		if ( '' === $id ) {
			$id = 'X' . substr( md5( $s['n'] . '|' . $s['o'] ), 0, 10 ); // ID 없는 줄(관리자 검수 대상)
		}
		$pairs[ $id ][] = array( isset( $s['sd'] ) ? $s['sd'] : '', isset( $s['sg'] ) ? $s['sg'] : '' );
		if ( isset( $items[ $id ] ) ) {
			continue;
		}
		$items[ $id ] = array(
			'i'   => $id,
			'k'   => 'L',
			'n'   => (string) $s['n'],
			'o'   => (string) $s['o'],
			's'   => wp_strip_all_tags( (string) $s['s'] ),
			'u'   => 0 === strpos( (string) $s['u'], 'http' ) ? (string) $s['u'] : '',
			'l'   => ebm_list( $s['l'] ),
			'h'   => ebm_list( $s['h'] ),
			't'   => ebm_list( $s['t'] ),
			'cy'  => isset( $s['cy'] ) ? (string) $s['cy'] : '',
			'pv'  => isset( $s['pv'] ) ? (string) $s['pv'] : '',
			'ap'  => isset( $s['ap'] ) ? (string) $s['ap'] : '',
			'm'   => isset( $s['m'] ) ? ebm_ymd( $s['m'] ) : '',
			'raw' => array( (string) $s['sd'], (string) $s['sg'] ),
		);
	}
	foreach ( $items as $id => &$it ) {
		$it += ebm_scope_of( $pairs[ $id ], $it['n'], $it['o'] );
		if ( count( $pairs[ $id ] ) > 1 ) {
			$it['rows'] = count( $pairs[ $id ] );
		}
	}
	unset( $it );

	// 중앙부처 서비스 = 전국 공통
	foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
		if ( empty( $s['name'] ) ) {
			continue;
		}
		$id = ebm_id_of( isset( $s['id'] ) ? $s['id'] : '', isset( $s['link'] ) ? $s['link'] : '' );
		if ( '' === $id ) {
			continue;
		}
		$items[ $id ] = array(
			'i'  => $id,
			'k'  => 'C',
			'n'  => (string) $s['name'],
			'o'  => (string) $s['org'],
			's'  => wp_strip_all_tags( (string) $s['sum'] ),
			'u'  => 0 === strpos( (string) $s['link'], 'http' ) ? (string) $s['link'] : '',
			'l'  => ebm_list( $s['life'] ),
			'h'  => ebm_list( $s['hh'] ),
			't'  => ebm_list( $s['them'] ),
			'cy' => isset( $s['cy'] ) ? (string) $s['cy'] : '',
			'pv' => isset( $s['pv'] ) ? (string) $s['pv'] : '',
			'ap' => '',
			'm'  => isset( $s['m'] ) ? ebm_ymd( $s['m'] ) : '',
			'sc' => 'nation',
			'r'  => array(),
			'sd' => '',
			'why' => '',
			'nt' => '',
		);
	}

	// 관리자 검수 덮어쓰기
	foreach ( $rev as $id => $rv ) {
		if ( isset( $items[ $id ] ) && 'L' === $items[ $id ]['k'] ) {
			$items[ $id ] = ebm_apply_review_scope( $items[ $id ], (array) $rv );
		}
	}

	// 색인
	$ix     = array( 'sgg' => array(), 'sido' => array(), 'check' => array() );
	$nation = array();
	$st     = array( 'L' => 0, 'C' => 0, 'sc' => array() );
	$dupk   = array();
	foreach ( $items as $id => $it ) {
		$st[ $it['k'] ]++;
		$st['sc'][ $it['sc'] ] = ( isset( $st['sc'][ $it['sc'] ] ) ? $st['sc'][ $it['sc'] ] : 0 ) + 1;
		switch ( $it['sc'] ) {
			case 'nation':
				$nation[] = $id;
				break;
			case 'sido':
				$ix['sido'][ $it['sd'] ][] = $id;
				break;
			case 'sgg':
			case 'multi':
			case 'legacy':
				foreach ( $it['r'] as $r ) {
					$ix['sgg'][ $r ][] = $id;
				}
				break;
			case 'check':
				$ix['check'][ $it['sd'] ? $it['sd'] : '00' ][] = $id;
				break;
		}
		if ( 'hide' !== $it['sc'] ) {
			// 중복 후보(자동으로 합치지 않음): 이름·기관이 같고 지역이 겹치는데 ID가 다른 것
			$dupk[ preg_replace( '/[\s·()\[\]]+/u', '', $it['n'] ) . '|' . $it['o'] . '|' . $it['sd'] ][] = $id;
		}
	}
	$dup = array();
	foreach ( $dupk as $ids ) {
		if ( count( $ids ) < 2 ) {
			continue;
		}
		$seen = array();
		foreach ( $ids as $id ) {
			foreach ( ( $items[ $id ]['r'] ? $items[ $id ]['r'] : array( 'all' ) ) as $r ) {
				$seen[ $r ][] = $id;
			}
		}
		foreach ( $seen as $grp ) {
			if ( count( $grp ) > 1 ) {
				$dup[] = $grp;
			}
		}
	}

	$d = array( 'items' => $items, 'ix' => $ix, 'nation' => $nation, 'dup' => $dup, 'st' => $st, 'at' => time() );
	set_transient( $key, $d, DAY_IN_SECONDS );
	return $d;
}

/* 신청 상태 -------------------------------------------------------------------------- */

/** 복지 캘린더 일정 중 지도가 쓸 수 있는 것(노출 중·자동 노출 + 직접 추가) key => item */
function ebm_cal_items() {
	static $m = null;
	if ( null !== $m ) {
		return $m;
	}
	$m = array();
	if ( ! function_exists( 'ebs_items' ) ) {
		return $m;
	}
	foreach ( ebs_items( array( 'ahead' => 400, 'local' => true ) ) as $x ) {
		if ( 'rule' === $x['src'] ) {
			continue;
		}
		$m[ $x['key'] ] = $x;
	}
	return $m;
}

/** 이 일정이 확인된 것인지(검수 대기 지역 일정은 아님) */
function ebm_cal_confirmed( $x ) {
	return in_array( $x['state'], array( 'show', 'auto' ), true );
}

/**
 * 정책 하나의 신청 상태 근거
 * @return array k(period|always|closed|unknown), s, e, src(admin|cal), url, chk(확인일), cal(캘린더 key), why
 */
function ebm_status( $id ) {
	$rv = ebm_review_all();
	$rv = isset( $rv[ $id ] ) ? (array) $rv[ $id ] : array();
	$st = isset( $rv['st'] ) ? $rv['st'] : '';
	$chk = isset( $rv['chk'] ) ? $rv['chk'] : '';
	if ( 'always' === $st ) {
		return array( 'k' => 'always', 'src' => 'admin', 'url' => isset( $rv['src'] ) ? $rv['src'] : '', 'chk' => $chk );
	}
	if ( 'period' === $st && ! empty( $rv['e'] ) ) {
		return array( 'k' => 'period', 's' => isset( $rv['s'] ) ? $rv['s'] : '', 'e' => $rv['e'], 'src' => 'admin', 'url' => isset( $rv['src'] ) ? $rv['src'] : '', 'chk' => $chk );
	}
	if ( 'closed' === $st ) {
		return array( 'k' => 'closed', 'src' => 'admin', 'url' => isset( $rv['src'] ) ? $rv['src'] : '', 'chk' => $chk );
	}
	if ( ! empty( $rv['cal'] ) ) {
		$cal = ebm_cal_items();
		if ( isset( $cal[ $rv['cal'] ] ) && ebm_cal_confirmed( $cal[ $rv['cal'] ] ) ) {
			$x = $cal[ $rv['cal'] ];
			return array( 'k' => 'period', 's' => $x['s'], 'e' => $x['e'], 'src' => 'cal', 'cal' => $x['key'], 'chk' => $chk );
		}
		return array( 'k' => 'unknown', 'cal' => $rv['cal'], 'why' => 'cal-wait', 'chk' => $chk );
	}
	return array( 'k' => 'unknown', 'chk' => $chk );
}

/** 오늘 기준 상태 이름: open(접수 중) soon(곧 시작) always(상시) closed(마감) unknown(기간 확인 필요) */
function ebm_status_now( $st, $today = '' ) {
	$today = $today ? $today : current_time( 'Y-m-d' );
	if ( 'period' !== $st['k'] ) {
		return $st['k'];
	}
	if ( $st['e'] < $today ) {
		return 'closed';
	}
	if ( $st['s'] && $st['s'] > $today ) {
		return 'soon';
	}
	return 'open';
}

function ebm_status_labels() {
	return array( 'open' => '접수 중', 'soon' => '곧 시작', 'always' => '상시', 'unknown' => '기간 확인 필요', 'closed' => '마감' );
}

/* 카드 ------------------------------------------------------------------------------- */

function ebm_cycle_label( $c ) {
	$m = array( '년' => '해마다', '월' => '매달', '분기' => '분기마다', '반기' => '반년마다', '1회성' => '한 번', '수시' => '필요할 때' );
	return isset( $m[ $c ] ) ? $m[ $c ] : $c;
}

/** 통합 전 지역 전체를 고른 경우 이름 하나로: 옛 전라남도 22개 시·군 / 옛 광주광역시 5개 구 (1.0.1) */
function ebm_old_area_label( $r ) {
	$r = array_map( 'strval', (array) $r );
	sort( $r );
	if ( count( $r ) < 2 ) {
		return '';
	}
	$gj = array( '12210', '12240', '12270', '12300', '12330' );
	if ( $r === $gj ) {
		return '옛 광주광역시 지역';
	}
	$s12 = ebm_sido( '12' );
	if ( $s12 && ! empty( $s12['g'] ) ) {
		$jn = array_values( array_diff( array_map( 'strval', wp_list_pluck( $s12['g'], 'id' ) ), $gj ) );
		sort( $jn );
		if ( $r === $jn ) {
			return '옛 전라남도 지역';
		}
	}
	return '';
}

/** 적용 지역 표시 */
function ebm_area_label( $it ) {
	switch ( $it['sc'] ) {
		case 'nation':
			return '전국 공통';
		case 'sido':
			$s = ebm_sido( $it['sd'] );
			return ( $s ? $s['n'] : '' ) . ( 'edu' === $it['why'] ? ' 교육청 사업' : ( '36' === $it['sd'] ? '' : ' 전체' ) );
		case 'sgg':
		case 'multi':
		case 'legacy':
			$names = array();
			foreach ( $it['r'] as $r ) {
				$g = ebm_sgg( $r );
				if ( $g ) {
					$names[] = $g['n'];
				}
			}
			if ( 'legacy' === $it['sc'] ) {
				return '옛 ' . ebm_sido( $it['sd'] )['s'] . ' ' . ( isset( $it['raw'][1] ) ? $it['raw'][1] : '' ) . ' 지역';
			}
			$old = ebm_old_area_label( $it['r'] );
			if ( '' !== $old ) {
				return $old;
			}
			return count( $names ) > 3 ? implode( '·', array_slice( $names, 0, 3 ) ) . ' 외 ' . ( count( $names ) - 3 ) . '곳' : implode( '·', $names );
		default:
			return '적용 지역 확인 필요';
	}
}

/**
 * 화면용 카드(JSON·서버 그리기 공통)
 * i n o a(적용 지역) g(묶음) tg(대상) bn(혜택) sm(목적 요약) st(상태 근거) m(복지로 수정일) c(확인일) u(공식 출처) l h t nt(안내) p(쉽게 읽는 안내 글)
 */
function ebm_card( $it, $group ) {
	$rv = ebm_review_all();
	$rv = isset( $rv[ $it['i'] ] ) ? (array) $rv[ $it['i'] ] : array();
	$tg = ! empty( $rv['tg'] ) ? $rv['tg'] : implode( ' · ', array_merge( $it['l'], $it['h'] ) );
	$bn = ! empty( $rv['bn'] ) ? $rv['bn'] : trim( implode( ' · ', array_filter( array( $it['pv'], ebm_cycle_label( $it['cy'] ) ) ) ) );
	$st = ebm_status( $it['i'] );
	$posts = array();
	foreach ( ! empty( $rv['post'] ) ? (array) $rv['post'] : array() as $pid ) {
		if ( 'publish' === get_post_status( (int) $pid ) ) {
			$posts[] = array( 't' => html_entity_decode( get_the_title( (int) $pid ), ENT_QUOTES, 'UTF-8' ), 'u' => get_permalink( (int) $pid ) );
		}
	}
	return array(
		'i'  => $it['i'],
		'n'  => $it['n'],
		'o'  => $it['o'],
		'a'  => ebm_area_label( $it ),
		'g'  => $group,
		'tg' => $tg,
		'bn' => $bn,
		'tgr' => ! empty( $rv['tg'] ),
		'sm' => wp_html_excerpt( $it['s'], 90, '…' ),
		'st' => $st,
		'm'  => $it['m'],
		'u'  => $it['u'],
		'l'  => $it['l'],
		'h'  => $it['h'],
		't'  => $it['t'],
		'nt' => $it['nt'],
		'p'  => $posts,
	);
}

/**
 * 지역 하나의 결과
 * @param string $sd 시·도 코드 · $sg 시·군·구 ID('' = 시·도 전체 사업 보기)
 * @return array groups(sgg·sido·check: 카드 목록) · n(묶음별 건수) · nation_n
 */
function ebm_region_result( $sd, $sg = '' ) {
	$d   = ebm_data();
	$out = array( 'sgg' => array(), 'sido' => array(), 'check' => array() );
	if ( $sg && isset( $d['ix']['sgg'][ $sg ] ) ) {
		foreach ( $d['ix']['sgg'][ $sg ] as $id ) {
			$out['sgg'][] = ebm_card( $d['items'][ $id ], 'sgg' );
		}
	}
	foreach ( isset( $d['ix']['sido'][ $sd ] ) ? $d['ix']['sido'][ $sd ] : array() as $id ) {
		$out['sido'][] = ebm_card( $d['items'][ $id ], 'sido' );
	}
	foreach ( isset( $d['ix']['check'][ $sd ] ) ? $d['ix']['check'][ $sd ] : array() as $id ) {
		$out['check'][] = ebm_card( $d['items'][ $id ], 'check' );
	}
	foreach ( $out as &$list ) {
		usort( $list, 'ebm_card_cmp' );
	}
	unset( $list );
	return array( 'groups' => $out, 'nation_n' => count( $d['nation'] ) );
}

/** 정렬: 접수 중 → 곧 시작 → 상시 → 기간 확인 필요 → 마감, 같은 상태면 가나다 */
function ebm_card_cmp( $a, $b ) {
	static $rank = array( 'open' => 0, 'soon' => 1, 'always' => 2, 'unknown' => 3, 'closed' => 4 );
	$x = $rank[ ebm_status_now( $a['st'] ) ];
	$y = $rank[ ebm_status_now( $b['st'] ) ];
	if ( $x !== $y ) {
		return $x - $y;
	}
	if ( 'period' === $a['st']['k'] && 'period' === $b['st']['k'] && $a['st']['e'] !== $b['st']['e'] ) {
		return strcmp( $a['st']['e'], $b['st']['e'] );
	}
	return strcmp( $a['n'], $b['n'] );
}

function ebm_nation_cards() {
	$d   = ebm_data();
	$out = array();
	foreach ( $d['nation'] as $id ) {
		$out[] = ebm_card( $d['items'][ $id ], 'nation' );
	}
	usort( $out, 'ebm_card_cmp' );
	return $out;
}

/** 지역별 등록 건수(목록·지도 배지): sd => [ 'sido' => n, 'g' => [sgg => n] ] */
function ebm_region_counts() {
	$d   = ebm_data();
	$out = array();
	foreach ( ebm_regions()['sido'] as $sd ) {
		$g = array();
		foreach ( $sd['g'] as $x ) {
			$g[ $x['id'] ] = isset( $d['ix']['sgg'][ $x['id'] ] ) ? count( $d['ix']['sgg'][ $x['id'] ] ) : 0;
		}
		$out[ $sd['id'] ] = array(
			's' => isset( $d['ix']['sido'][ $sd['id'] ] ) ? count( $d['ix']['sido'][ $sd['id'] ] ) : 0,
			'c' => isset( $d['ix']['check'][ $sd['id'] ] ) ? count( $d['ix']['check'][ $sd['id'] ] ) : 0,
			'g' => $g,
		);
	}
	return $out;
}

/**
 * 이 지역의 확인된 캘린더 일정(지도 요약용, 최대 $max)
 *   ① 관리자가 이 지역 정책에 연결한 일정
 *   ② 캘린더에서 '노출 중'(확인됨)인 지역 일정 중 캘린더가 이 시·군·구로 분류한 것
 *      (캘린더는 기관 이름으로 지역을 나누므로, 시·도 단위로 분류된 일정은 연결된 것만 - 시·도 기관이 한 시·군·구 사업을 하는 경우가 있어서)
 */
function ebm_region_cal( $sd, $sg, $linked_keys = array(), $max = 3 ) {
	$names = ebm_site_names( $sd, $sg );
	$out   = array();
	foreach ( ebm_cal_items() as $key => $x ) {
		if ( ! ebm_cal_confirmed( $x ) ) {
			continue;
		}
		$hit = in_array( $key, $linked_keys, true );
		if ( ! $hit && $sg && ! empty( $x['local'] ) && $x['sd'] && '' !== $x['sg'] && ebm_sd_code( $x['sd'] ) === $sd ) {
			$al  = ebm_sg_alias( $sd, $x['sg'] );
			$hit = ebm_sg_id( $sd, $x['sg'] ) === $sg || ( $al && 1 === count( $al['to'] ) && $al['to'][0] === $sg );
		}
		if ( $hit ) {
			$out[] = array( 'k' => $key, 'n' => $x['name'], 's' => $x['s'], 'e' => $x['e'], 'lc' => ! empty( $x['local'] ), 'a' => $x['apply'], 'al' => $x['apply_label'] );
		}
	}
	usort( $out, function ( $a, $b ) {
		return strcmp( $a['e'], $b['e'] );
	} );
	return array( 'n' => count( $out ), 'items' => array_slice( $out, 0, $max ), 'names' => $names );
}

/** 원본 갱신 정보: 받은 시각·오류·멈춤(36시간 넘게 못 받음) */
function ebm_freshness() {
	$l   = (int) get_option( 'eb_ws_local_synced' );
	$c   = (int) get_option( 'eb_ws_synced' );
	$now = time();
	return array(
		'local'   => $l,
		'central' => $c,
		'stale'   => ( $l && $now - $l > 36 * HOUR_IN_SECONDS ) || ( $c && $now - $c > 36 * HOUR_IN_SECONDS ),
		'err'     => trim( get_option( 'eb_ws_local_err' ) . ' ' . get_option( 'eb_ws_sync_err' ) ),
	);
}
