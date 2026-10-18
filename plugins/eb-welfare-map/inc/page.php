<?php
/**
 * 복지지도 화면 [eb_welfare_map] (/welfare-map/)
 *
 * - 첫 목록은 서버에서 그림(검색엔진·느린 기기·스크립트 실패 대비). 지역 링크는 진짜 주소(?sd=경기도&sg=수원시)라 새로고침·공유해도 같음.
 * - 지도는 data/geo의 미리 만든 SVG 경로를 화면이 뜬 뒤 받아 그림. 실패해도 검색·목록으로 모두 고를 수 있음.
 * - 지역 기억: 복지 캘린더와 같은 ebs_region(이 기기)만 씀. 맞춤 찾기 기록(eb_finder_last)은 읽기만 하고 쓰지 않음.
 */

defined( 'ABSPATH' ) || exit;

function ebm_page_id() {
	return (int) get_option( 'ebm_page_id', 0 );
}

function ebm_url() {
	$id = ebm_page_id();
	return $id && get_post( $id ) ? get_permalink( $id ) : home_url( '/welfare-map/' );
}

/** 페이지 만들기(없을 때만). 공개 전에는 비공개 */
function ebm_ensure_page() {
	$id = ebm_page_id();
	if ( $id && get_post( $id ) && 'trash' !== get_post_status( $id ) ) {
		return $id;
	}
	$p = get_page_by_path( 'welfare-map' );
	if ( $p ) {
		update_option( 'ebm_page_id', $p->ID, false );
		return $p->ID;
	}
	$id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => ebm_is_public() ? 'publish' : 'private',
		'post_title'   => '우리 지역 복지지도',
		'post_name'    => 'welfare-map',
		'post_content' => '<!-- wp:shortcode -->[eb_welfare_map]<!-- /wp:shortcode -->',
		'post_excerpt' => '사는 곳을 고르면 그 지역의 시·군·구 사업, 시·도 사업, 전국 공통 사업을 모아 보여 드려요.',
	) );
	if ( $id && ! is_wp_error( $id ) ) {
		update_option( 'ebm_page_id', $id, false );
	}
	return $id;
}

/** 공개 전환: 페이지 상태도 함께 */
function ebm_set_public( $on ) {
	update_option( 'ebm_public', $on ? 1 : 0, false );
	$id = ebm_ensure_page();
	if ( $id ) {
		wp_update_post( array( 'ID' => $id, 'post_status' => $on ? 'publish' : 'private' ) );
	}
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain(); // 홈·메뉴 진입점이 모든 페이지에 있어서
	}
	delete_transient( 'eb_search_index_v2' );
}

function ebm_is_page() {
	return ebm_page_id() && is_page( ebm_page_id() );
}

// 비공개 미리 보기 중 제목 앞 '비공개:' 빼기
add_filter( 'private_title_format', function ( $f, $post = null ) {
	return $post && (int) $post->ID === ebm_page_id() ? '%s' : $f;
}, 10, 2 );

// 넓은 화면(사이드바 없음 + body.eb-wide - 복지 캘린더·계산기 모음과 같은 머리). 테마 body_class(10)보다 먼저 넣어 eb-head가 붙지 않게
add_filter( 'generate_sidebar_layout', function ( $layout ) {
	return ebm_is_page() ? 'no-sidebar' : $layout;
}, 20 );
add_filter( 'body_class', function ( $c ) {
	if ( ebm_is_page() ) {
		$c[] = 'eb-wide';
		$c[] = 'wmap-page';
	}
	return $c;
}, 5 );

/* 모든 페이지 머리: 지역 하나로 맞추기(작게) ----------------------------------------------------
 * ebRegionNewer(L): 복지지도·캘린더에서 고른 지역(ebs_region)이 맞춤 찾기 기록(eb_finder_last L)보다 나중이면 그 지역 {sd, sg}
 *   → 테마의 맞춤 찾기·홈 찾기·빠른 찾기가 지역만 바꿔 씀(가구 상황·필요한 도움은 그대로). 플러그인을 끄면 함수가 없어 예전처럼 동작.
 * 복지 캘린더(/schedule/?sd=&sg=): 주소의 지역을 ebs_region에 먼저 넣어 같은 지역 일정이 열림(공유 링크).
 */
add_action( 'wp_head', function () {
	if ( ! ebm_can_view() ) {
		return;
	}
	$js = "window.ebRegionNewer=function(L){var a=null;try{a=JSON.parse(localStorage.getItem('ebs_region')||'null');}catch(e){}if(!a||!a.at)return null;if(L&&L.v===2&&(L.at||0)>=a.at)return null;return{sd:a.sd||'',sg:a.sg||''};};";
	if ( is_page( 'schedule' ) ) {
		$js .= "(function(){var q=new URLSearchParams(location.search),sd=q.get('sd');if(sd===null)return;try{localStorage.setItem('ebs_region',JSON.stringify({sd:sd,sg:q.get('sg')||'',at:Date.now()}));}catch(e){}})();";
	}
	echo '<script nowprocket>' . $js . "</script>\n"; // phpcs:ignore
}, 1 );

// 맞춤 찾기(/find/): '사는 곳' 아래 '이 지역 정책 전체 보기 › 복지지도' 링크(고른 지역을 따라감)
add_action( 'wp_footer', function () {
	if ( ! ebm_can_view() || ! is_page( 'find' ) ) {
		return;
	}
	$base = wp_json_encode( ebm_url() );
	echo "<script nowprocket>\n(function(){var R=document.querySelector('#finder .f2__region');if(!R)return;var sd=R.querySelector('.f2__sd'),sg=R.querySelector('.f2__sg');var a=document.createElement('a');a.className='wmap-flink';a.href={$base};a.innerHTML='<span>이 지역 정책 전체 보기</span><b>복지지도 ›</b>';R.parentNode.insertBefore(a,R.nextSibling);var up=function(){var p=new URLSearchParams();if(sd&&sd.value){p.set('sd',sd.value);if(sg&&sg.value)p.set('sg',sg.value);}var q=p.toString();a.href={$base}+(q?'?'+q:'');a.querySelector('span').textContent=sd&&sd.value?(sg&&sg.value?sg.value:sd.value)+' 정책 전체 보기':'지역별 정책 한눈에 보기';};[sd,sg].forEach(function(s){if(s)s.addEventListener('change',function(){setTimeout(up,0);});});setTimeout(up,0);setTimeout(up,800);})();\n</script>\n<style>.wmap-flink{display:flex;justify-content:space-between;gap:8px;margin:8px 0 0;padding:8px 10px;font-size:.84rem;line-height:1.35;color:var(--contrast-2,#4a5568);text-decoration:none;background:var(--base-2,#f5f7fa);border-radius:8px}.wmap-flink b{flex:none;color:var(--accent,#1e4fa3);font-weight:700}.wmap-flink:hover b,.wmap-flink:focus-visible b{text-decoration:underline}</style>\n"; // phpcs:ignore
}, 70 );

/* 홈·메뉴 진입점 - 테마가 function_exists로 부름(플러그인을 끄면 자리째 사라짐) ---------------------- */

/** PC 메가메뉴 '바로 쓰는 도구'·휴대폰 전체 메뉴 항목: [주소, 이름, 짧은 설명] 또는 null(공개 전 방문자) */
function ebm_menu_item() {
	return ebm_can_view() ? array( ebm_url(), '우리 지역 복지지도', '사는 곳의 지원 한눈에' ) : null;
}

/** 홈 상단 찾기 카드의 탭 줄 오른쪽 '지도로 찾기' 링크 */
function ebm_home_link() {
	if ( ! ebm_can_view() ) {
		return '';
	}
	return '<a class="hx__map" href="' . esc_url( ebm_url() ) . '"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 4 3 6.5v13L9 17l6 2.5 6-2.5v-13L15 6.5 9 4zM9 4v13M15 6.5v13"/></svg><span>지도로 찾기</span></a>';
}
add_action( 'wp_head', function () {
	if ( ! is_front_page() || ! ebm_can_view() ) {
		return;
	}
	// 탭 줄(.hx__tabs)과 같은 높이·글자, 오른쪽 끝. 휴대폰은 아이콘+짧은 글자
	echo '<style id="ebm-home">.hx__fc{position:relative}.hx__fc>.hx__map{position:absolute;top:6px;right:8px;display:inline-flex;align-items:center;gap:5px;height:36px;padding:0 10px;font-size:.88rem;font-weight:700;color:var(--accent,#1d3c78);text-decoration:none;border-radius:8px}.hx__fc>.hx__map svg{width:17px;height:17px;flex:none}.hx__fc>.hx__map:hover,.hx__fc>.hx__map:focus-visible{background:var(--accent-3,#eaf0fa);text-decoration:none}@media (max-width:767px){.hx__fc>.hx__map{top:4px;right:4px;padding:0 8px;font-size:.82rem}}</style>' . "\n"; // phpcs:ignore
}, 20 );

/* 자산 ------------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! ebm_is_page() ) {
		return;
	}
	// 파일을 고치면 주소가 바뀌어 브라우저·CDN 캐시가 새 파일을 받음
	wp_enqueue_style( 'ebm-map', EBM_URL . 'assets/map.css', array(), EBM_VER . '.' . (int) @filemtime( EBM_DIR . 'assets/map.css' ) ); // phpcs:ignore
	wp_enqueue_script( 'ebm-map', EBM_URL . 'assets/map.js', array(), EBM_VER . '.' . (int) @filemtime( EBM_DIR . 'assets/map.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) ); // phpcs:ignore
}, 30 );
// WP Rocket이 지도 스크립트를 늦추거나 합치지 않게
add_filter( 'rocket_delay_js_exclusions', function ( $l ) {
	$l[] = 'eb-welfare-map/assets/map.js';
	return $l;
} );
add_filter( 'rocket_exclude_js', function ( $l ) {
	$l[] = '/wp-content/plugins/eb-welfare-map/assets/map.js';
	return $l;
} );

// 비공개 미리 보기 중에는 방문자에게 이 페이지가 없음(관리자만)
add_action( 'template_redirect', function () {
	if ( ebm_is_page() && ! ebm_can_view() ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
	}
} );

// 검색엔진: 지역별 화면도 같은 페이지의 다른 보기라 정식 주소는 /welfare-map/ 하나(필터 조합이 끝없이 색인되지 않게). 지역만 고른 주소는 색인 허용
add_filter( 'rank_math/frontend/robots', function ( $robots ) {
	if ( ebm_is_page() && ( isset( $_GET['life'] ) || isset( $_GET['hh'] ) || isset( $_GET['th'] ) || isset( $_GET['st'] ) || isset( $_GET['q'] ) ) ) { // phpcs:ignore
		$robots['index'] = 'noindex';
	}
	return $robots;
} );

/* 화면 ------------------------------------------------------------------------------- */

/** 상황별 가이드(테마 eb_find_situations + eb_guide_list) → [이름, 주소, 짧은 이름, 조건] */
function ebm_guides() {
	if ( ! function_exists( 'eb_find_situations' ) ) {
		return array();
	}
	$short = array();
	foreach ( function_exists( 'eb_guide_list' ) ? eb_guide_list() : array() as $g ) {
		$short[ trim( $g[0], '/' ) ] = $g[4];
	}
	$out = array();
	foreach ( eb_find_situations() as $s ) {
		$key   = 'guide/' . $s[1];
		$out[] = array( 'n' => $s[0], 'u' => home_url( '/' . $key . '/' ), 's' => isset( $short[ $key ] ) ? $short[ $key ] : $s[0], 'c' => $s[2] );
	}
	return $out;
}

/** 편집 글(테마 맞춤 찾기와 같은 목록 eb_f2_posts): 제목·주소·분야·태그·대상 지역 */
function ebm_posts() {
	if ( ! function_exists( 'eb_f2_posts' ) ) {
		return array();
	}
	$out = array();
	foreach ( eb_f2_posts() as $p ) {
		$r = array();
		foreach ( (array) ( isset( $p['r'] ) ? $p['r'] : array() ) as $name ) {
			$c = ebm_sd_code( $name ); // 옛 시·도 이름(광주광역시 등) 태그도 지금 시·도로
			if ( $c ) {
				$r[] = $c;
			}
		}
		$out[] = array( 't' => $p['t'], 'u' => $p['u'], 'c' => $p['c'], 'p' => (int) $p['p'], 'l' => $p['l'], 'h' => $p['h'], 'th' => $p['th'], 'r' => array_values( array_unique( $r ) ) );
	}
	return $out;
}

function ebm_esc_ymd( $ymd, $year = false ) {
	if ( ! $ymd ) {
		return '';
	}
	$t = strtotime( $ymd . ' 12:00:00' );
	return $year ? wp_date( 'Y.n.j', $t ) : wp_date( 'n.j', $t );
}

/** 카드 HTML(스크립트 화면과 같은 모양 - assets/map.js card()) */
function ebm_card_html( $c, $today ) {
	$labels = ebm_status_labels();
	$now    = ebm_status_now( $c['st'], $today );
	$st     = $c['st'];
	$per    = '';
	if ( 'period' === $st['k'] ) {
		$per = '<p class="wmap-c__per">' . ( $st['s'] ? esc_html( ebm_esc_ymd( $st['s'] ) ) . ' ~ ' : '~ ' ) . esc_html( ebm_esc_ymd( $st['e'] ) ) . ' <small>' . ( 'cal' === $st['src'] ? '복지 캘린더 기준' : '이지복지 확인' ) . '</small></p>';
	} elseif ( 'always' === $st['k'] ) {
		$per = '<p class="wmap-c__per">상시 신청 <small>이지복지 확인</small></p>';
	}
	$dl = '<div><dt>대상</dt><dd>' . esc_html( $c['tg'] ? $c['tg'] : '원문에서 확인' ) . '</dd></div>';
	$dl .= $c['bn'] ? '<div><dt>혜택</dt><dd>' . esc_html( $c['bn'] ) . '</dd></div>' : ( $c['sm'] ? '<div><dt>목적</dt><dd>' . esc_html( $c['sm'] ) . '</dd></div>' : '' );
	$ft = array();
	if ( $c['m'] ) {
		$ft[] = '복지로 수정 ' . esc_html( ebm_esc_ymd( $c['m'], true ) );
	}
	if ( ! empty( $st['chk'] ) ) {
		$ft[] = '이지복지 확인 ' . esc_html( ebm_esc_ymd( $st['chk'], true ) );
	}
	$h  = '<li class="wmap-c" data-i="' . esc_attr( $c['i'] ) . '"><div class="wmap-c__hd"><span class="wmap-st is-' . esc_attr( $now ) . '">' . esc_html( $labels[ $now ] ) . '</span><span class="wmap-c__area">' . esc_html( $c['a'] ) . '</span></div>';
	$h .= '<h3 class="wmap-c__t">' . esc_html( $c['n'] ) . '</h3><p class="wmap-c__o">' . esc_html( $c['o'] ) . '</p><dl class="wmap-c__dl">' . $dl . '</dl>' . $per;
	if ( $c['nt'] ) {
		$h .= '<p class="wmap-c__nt">' . esc_html( $c['nt'] ) . '</p>';
	}
	$h .= '<div class="wmap-c__ft"><span class="wmap-c__dt">' . ( $ft ? implode( ' · ', $ft ) : '수정일 정보 없음' ) . '</span>';
	if ( $c['u'] ) {
		$h .= '<a class="wmap-c__src" href="' . esc_url( $c['u'] ) . '" target="_blank" rel="noopener">공식 정보 보기<span class="screen-reader-text"> - ' . esc_html( $c['n'] ) . ' (복지로, 새 창)</span></a>';
	}
	$h .= '</div></li>';
	return $h;
}

/** 첫 화면에서 그릴 지역(주소) */
function ebm_request_region() {
	$sd = isset( $_GET['sd'] ) ? sanitize_text_field( wp_unslash( $_GET['sd'] ) ) : ''; // phpcs:ignore
	$sg = isset( $_GET['sg'] ) ? sanitize_text_field( wp_unslash( $_GET['sg'] ) ) : ''; // phpcs:ignore
	$r  = isset( $_GET['r'] ) ? sanitize_text_field( wp_unslash( $_GET['r'] ) ) : ''; // phpcs:ignore
	return array( $sd, $sg, $r );
}

/** 지역 목록 HTML(시·도 또는 한 시·도의 시·군·구) - 지도와 같은 선택 수단 */
function ebm_pick_html( $sd, $sg, $counts ) {
	if ( '' === $sd ) {
		$li = '';
		foreach ( ebm_regions()['sido'] as $s ) {
			$c   = $counts[ $s['id'] ];
			$n   = $c['s'] + array_sum( $c['g'] );
			$li .= '<li><a href="' . esc_url( ebm_region_url( $s['id'] ) ) . '" data-sd="' . esc_attr( $s['id'] ) . '"><span>' . esc_html( $s['s'] ) . '</span><small>' . esc_html( number_format_i18n( $n ) ) . '건</small></a></li>';
		}
		return '<h2 class="wmap__h" id="wmap-pick-h">시·도 고르기</h2><ul class="wmap__list is-sd" aria-labelledby="wmap-pick-h">' . $li . '</ul>';
	}
	$s = ebm_sido( $sd );
	$c = $counts[ $sd ];
	if ( ! $s['g'] ) {
		return '<h2 class="wmap__h" id="wmap-pick-h">' . esc_html( $s['n'] ) . '</h2><p class="wmap__one">시·군·구가 없는 단층 지역이에요. 아래 결과가 ' . esc_html( $s['s'] ) . ' 전체 사업이에요.</p><p class="wmap__up"><a href="' . esc_url( ebm_url() ) . '" data-sd="">전국 시·도 다시 고르기</a></p>';
	}
	$li = '<li class="is-all"><a href="' . esc_url( ebm_region_url( $sd ) ) . '" data-sd="' . esc_attr( $sd ) . '" data-sg=""' . ( '' === $sg ? ' aria-current="true"' : '' ) . '><span>' . esc_html( $s['s'] ) . ' 전체 사업만</span><small>' . esc_html( number_format_i18n( $c['s'] ) ) . '건</small></a></li>';
	foreach ( $s['g'] as $g ) {
		$li .= '<li><a href="' . esc_url( ebm_region_url( $sd, $g['id'] ) ) . '" data-sd="' . esc_attr( $sd ) . '" data-sg="' . esc_attr( $g['id'] ) . '"' . ( $g['id'] === $sg ? ' aria-current="true"' : '' ) . '><span>' . esc_html( $g['n'] ) . '</span><small>' . esc_html( number_format_i18n( $c['g'][ $g['id'] ] ) ) . '건</small></a></li>';
	}
	return '<h2 class="wmap__h" id="wmap-pick-h">' . esc_html( $s['n'] ) . '의 시·군·구</h2><ul class="wmap__list" aria-labelledby="wmap-pick-h">' . $li . '</ul><p class="wmap__up"><a href="' . esc_url( ebm_url() ) . '" data-sd="">전국 시·도 다시 고르기</a></p>';
}

add_shortcode( 'eb_welfare_map', function () {
	if ( ! ebm_can_view() ) {
		return '';
	}
	list( $qsd, $qsg, $qr ) = ebm_request_region();
	$counts  = ebm_region_counts();
	$f       = ebm_freshness();
	$today   = current_time( 'Y-m-d' );
	$payload = ( '' !== $qsd || '' !== $qr ) ? ebm_region_payload( $qsd, $qsg, $qr ) : null;
	$sd      = $payload && ! empty( $payload['ok'] ) ? $payload['sd'] : '';
	$sg      = $payload && ! empty( $payload['ok'] ) ? $payload['sg'] : '';
	$d       = ebm_data();
	$cfg     = array(
		'api'    => rest_url( 'ebm/v1/' ),
		'nonce'  => is_user_logged_in() ? wp_create_nonce( 'wp_rest' ) : '',
		'geo'    => EBM_URL . 'data/geo/',
		'gv'     => EBM_VER,
		'base'   => ebm_url(),
		'find'   => home_url( '/find/' ),
		'cal'    => home_url( '/schedule/' ),
		'near'   => home_url( '/nearby/' ),
		'saved'  => home_url( '/saved/' ),
		'today'  => $today,
		'reg'    => ebm_regions_for_js(),
		'cnt'    => $counts,
		'nation' => count( $d['nation'] ),
		'at'     => array( 'local' => $f['local'], 'central' => $f['central'], 'stale' => $f['stale'] ),
		'guides' => ebm_guides(),
		'posts'  => ebm_posts(),
		'init'   => $payload,
	);

	$h  = '<div class="wmap" id="wmap">';
	$h .= '<script type="application/json" id="wmap-cfg">' . wp_json_encode( $cfg, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ) . '</script>';
	$h .= '<p class="wmap__lead">사는 곳을 고르면 우리 지역에서 확인할 만한 지원을 모아 보여 드려요. <span>지역을 골랐다고 대상이 되는 건 아니에요. 자격은 사업마다 달라요.</span></p>';

	// 검색·경로
	$h .= '<div class="wmap__bar"><div class="wmap__search" role="search"><label class="screen-reader-text" for="wmap-q">지역 이름으로 찾기</label>'
		. '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>'
		. '<input id="wmap-q" type="search" autocomplete="off" placeholder="지역 이름 (예: 수원, 광산구)" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="wmap-sug" aria-describedby="wmap-q-hint">'
		. '<ul class="wmap__sug" id="wmap-sug" role="listbox" aria-label="찾은 지역" hidden></ul><span class="screen-reader-text" id="wmap-q-hint">시·도나 시·군·구 이름을 쓰면 아래에 목록이 나와요. 위아래 화살표로 고르고 Enter.</span></div>'
		. '<p class="wmap__last" hidden></p></div>';
	$h .= '<nav class="wmap__crumb" aria-label="고른 지역"' . ( $sd ? '' : ' hidden' ) . '><ol>' . ebm_crumb_html( $sd, $sg ) . '</ol><button type="button" class="wmap__clear">선택 지우기</button></nav>';

	$h .= '<div class="wmap__grid' . ( $sd ? ' has-sd' : '' ) . ( $sg ? ' has-sg' : '' ) . '">';
	$h .= '<div class="wmap__side"><section class="wmap__pick" id="wmap-pick" aria-labelledby="wmap-pick-h">' . ebm_pick_html( $sd, $sg, $counts ) . '</section>'
		. '<figure class="wmap__map" aria-labelledby="wmap-map-cap"><div class="wmap__svg" data-state="wait"><p class="wmap__msg">지도를 불러오는 중이에요…</p></div><figcaption id="wmap-map-cap"><span class="wmap__mt">지도에서 고르기</span> <small>색은 고른 지역 표시일 뿐, 복지 수준과 상관없어요.</small></figcaption></figure></div>';
	$h .= '<section class="wmap__main" id="wmap-main" aria-label="지역 복지정책">' . ebm_main_html( $payload, $today, $d ) . '</section>';
	$h .= '</div>';

	// 데이터·개인정보 안내
	$h .= '<footer class="wmap__foot"><p><b>자료</b> 정책: 한국사회보장정보원(복지로) 지자체·중앙부처 복지서비스, 받은 날 지역 ' . esc_html( $f['local'] ? wp_date( 'Y.n.j H:i', $f['local'] ) : '-' ) . ' · 전국 ' . esc_html( $f['central'] ? wp_date( 'Y.n.j H:i', $f['central'] ) : '-' ) . ( $f['stale'] ? ' <em class="wmap__stale">최근 갱신이 늦어지고 있어 마지막으로 받은 자료를 보여 드려요.</em>' : '' ) . '</p>'
		. '<p><b>신청 상태</b> 이지복지가 공식 공고로 확인한 기간이나 복지 캘린더의 확인된 일정이 있을 때만 표시해요. 그 밖에는 \'기간 확인 필요\'예요.</p>'
		. '<p><b>지도</b> 통계청 SGIS 행정구역 경계(' . esc_html( preg_replace( '/^(\d{4})(\d{2})(\d{2})$/', '$1.$2.$3', ebm_regions()['ver'] ) ) . ' 기준, vuski/admdongkor 가공, CC BY 4.0)</p>'
		. '<p><b>개인정보</b> 정확한 주소나 위치 권한은 쓰지 않아요. 고른 지역은 이 기기에 기억되고(복지 캘린더와 같이 씀), 정책을 불러올 때 고른 지역 이름만 서버로 전달돼요.</p></footer>';
	$h .= '</div>';
	return $h;
} );

function ebm_crumb_html( $sd, $sg ) {
	$h = '<li><a href="' . esc_url( ebm_url() ) . '" data-sd="">전국</a></li>';
	if ( $sd ) {
		$s  = ebm_sido( $sd );
		$h .= $sg ? '<li><a href="' . esc_url( ebm_region_url( $sd ) ) . '" data-sd="' . esc_attr( $sd ) . '" data-sg="">' . esc_html( $s['n'] ) . '</a></li>' : '<li aria-current="page">' . esc_html( $s['n'] ) . '</li>';
	}
	if ( $sg ) {
		$h .= '<li aria-current="page">' . esc_html( ebm_sgg( $sg )['n'] ) . '</li>';
	}
	return $h;
}

/** 결과 영역 첫 HTML(필터는 스크립트가 붙임) */
function ebm_main_html( $p, $today, $d ) {
	if ( ! $p ) {
		return '<div class="wmap-intro"><h2>어느 지역을 볼까요?</h2><p>시·도를 고르면 시·군·구 목록이 나와요. 시·군·구까지 고르면 <b>시·군·구 사업 · 시·도 사업 · 전국 공통 사업</b>을 나눠 보여 드려요.</p><p class="wmap-intro__n">전국 공통 사업 <b>' . esc_html( number_format_i18n( count( $d['nation'] ) ) ) . '건</b>은 어느 지역을 골라도 함께 보여요.</p></div>';
	}
	if ( empty( $p['ok'] ) ) {
		return '<div class="wmap-err" role="alert"><p>' . esc_html( $p['msg'] ) . '</p></div>';
	}
	if ( ! empty( $p['split'] ) ) {
		$b = '';
		foreach ( $p['split']['choices'] as $c ) {
			$b .= '<a class="wmap-btn" href="' . esc_url( ebm_region_url( $p['sd'], $c['id'] ) ) . '" data-sd="' . esc_attr( $p['sd'] ) . '" data-sg="' . esc_attr( $c['id'] ) . '">' . esc_html( $c['n'] ) . '</a>';
		}
		return '<div class="wmap-split"><h2>' . esc_html( ebm_sido( $p['sd'] )['n'] . ' ' . $p['split']['from'] ) . '</h2><p>' . esc_html( $p['split']['note'] ) . ' 지금 사는 곳을 골라 주세요.</p><p class="wmap-split__b">' . $b . '</p></div>';
	}
	$s  = ebm_sido( $p['sd'] );
	$g  = $p['sg'] ? ebm_sgg( $p['sg'] ) : null;
	$gr = $p['groups'];
	$h  = '<header class="wmap-hd"><p class="wmap-hd__eb">고른 지역</p><h2 class="wmap-hd__t">' . esc_html( $p['label'] ) . '</h2>'
		. '<p class="wmap-hd__n">등록된 정책 ' . ( $g ? esc_html( $g['n'] ) . ' ' . count( $gr['sgg'] ) . '건 · ' : '' ) . esc_html( $s['s'] ) . ' 전체 ' . count( $gr['sido'] ) . '건 · 전국 공통 ' . (int) $p['nation_n'] . '건</p>'
		. '<p class="wmap-hd__warn">지역을 골랐다고 지원 대상이 되는 건 아니에요. 나이·소득 같은 자격은 사업마다 달라요.</p></header>';
	$groups = array();
	if ( $g ) {
		$groups[] = array( 'sgg', $g['n'] . ' 사업', $gr['sgg'] );
	}
	$groups[] = array( 'sido', $s['n'] . ( '36' === $p['sd'] ? ' 사업' : ' 전체 사업' ), $gr['sido'] );
	foreach ( $groups as $x ) {
		$li = '';
		foreach ( array_slice( $x[2], 0, 10 ) as $c ) {
			$li .= ebm_card_html( $c, $today );
		}
		$h .= '<section class="wmap-g" data-g="' . $x[0] . '"><h2 class="wmap-g__h">' . esc_html( $x[1] ) . ' <b>' . count( $x[2] ) . '</b></h2>' . ( $li ? '<ul class="wmap-g__l">' . $li . '</ul>' : '<p class="wmap-empty">등록된 사업이 없어요.</p>' ) . ( count( $x[2] ) > 10 ? '<p class="wmap-g__more"><a href="#wmap-main">' . ( count( $x[2] ) - 10 ) . '건 더 있어요(화면이 다 뜨면 더 보기)</a></p>' : '' ) . '</section>';
	}
	$h .= '<section class="wmap-g" data-g="nation"><h2 class="wmap-g__h">전국 공통 사업 <b>' . (int) $p['nation_n'] . '</b></h2><p class="wmap-empty">화면이 다 뜨면 목록이 나와요.</p></section>';
	if ( $gr['check'] ) {
		$h .= '<section class="wmap-g is-check" data-g="check"><h2 class="wmap-g__h">적용 지역 확인 중인 ' . esc_html( $s['s'] ) . ' 사업 <b>' . count( $gr['check'] ) . '</b></h2><p class="wmap-g__d">복지로 원문에 시·군·구가 비어 있거나 옛 지역 이름이라, 어디에 적용되는지 확인하고 있어요.</p></section>';
	}
	return $h;
}
