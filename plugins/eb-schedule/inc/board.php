<?php
/**
 * [eb_schedule_board] — 신청·마감 일정 보드 (2026-10-10 2차: 한 줄 목록·우리 지역)
 *
 *   [eb_schedule_board]                  메인용: 5줄 + 더 보기, 세금은 아래 한 줄로 접음
 *   [eb_schedule_board view="full"]      복지 캘린더 '지금 신청 중' 탭용: 전부, 세금 포함
 *
 * 넓은 칸(640px 이상)은 한 줄 표(D-day · 이름·대상 · 금액 · 기간 · 버튼), 좁은 칸은 두 줄 목록 + 맨 위 '가장 가까운 마감'.
 * 지역(지자체) 사업은 data-local로 내보내고, 방문자가 고른 지역(맞춤 찾기 eb_finder_last 또는 이 보드에서 고른 ebs_region)과
 * 맞을 때만 보입니다. 상태·D-day·숫자는 방문자 기기 날짜로 다시 계산(WP Rocket 캐시 대비).
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'eb_schedule_board', 'ebs_board_html' );

function ebs_board_html( $atts = array() ) {
	$a     = shortcode_atts( array( 'view' => 'home', 'max' => '5', 'ahead' => '60', 'title' => '신청·마감 일정' ), $atts, 'eb_schedule_board' );
	$full  = 'full' === $a['view'];
	$today = current_time( 'Y-m-d' );
	$ahead = max( 7, (int) $a['ahead'] );
	// 목록 계산 결과를 1시간 보관(저장·동기화 때 ebs_purge_cache()가 판 번호를 올려 무효화)
	$tkey = 'ebs_board_' . md5( $today . '|' . $ahead . '|' . (int) get_option( 'ebs_rev', 0 ) );
	$pack = get_transient( $tkey );
	if ( ! is_array( $pack ) || ! isset( $pack['items'] ) ) {
		$pack = array(
			'items'   => ebs_items( array( 'ahead' => $ahead, 'today' => $today, 'local' => true ) ),
			'regions' => ebs_region_options(),
		);
		set_transient( $tkey, $pack, HOUR_IN_SECONDS );
	}

	$main = array();
	$tax  = array();
	foreach ( $pack['items'] as $x ) {
		if ( ! $full && '세금' === $x['cat'] ) {
			$tax[] = $x;
		} else {
			$main[] = $x;
		}
	}

	$who_on = array();
	foreach ( $main as $x ) {
		if ( ! $x['local'] ) {
			foreach ( $x['who'] as $w ) {
				$who_on[ $w ] = true;
			}
		}
	}

	$rows = '';
	$deferred = '';
	$initial = 0;
	$local = 0;
	foreach ( $main as $x ) {
		if ( $x['local'] ) {
			$local++; // 지역 사업 줄은 사는 곳을 고른 방문자만 따로 받아 감(ebs/v1/local-rows) - 메인·캘린더 HTML을 가볍게 (2026-10-15)
			continue;
		}
		$row = ebs_row_html( $x );
		if ( ! $full && $initial >= max( 3, (int) $a['max'] ) ) {
			$deferred .= $row;
		} else {
			$rows .= $row;
			$initial++;
		}
	}

	$h  = ebs_assets_once();
	$h .= '<section class="ebs' . ( $full ? ' ebs--full' : '' ) . '" data-max="' . ( $full ? 0 : max( 3, (int) $a['max'] ) ) . '" data-regions="' . esc_attr( wp_json_encode( $pack['regions'], JSON_UNESCAPED_UNICODE ) ) . '"' . ( $local ? ' data-local-src="' . esc_url( rest_url( 'ebs/v1/local-rows' ) . '?ahead=' . $ahead ) . '"' : '' ) . ' aria-label="' . esc_attr( '' !== $a['title'] ? $a['title'] : '신청·마감 일정' ) . '">';

	// 머리: 제목 · 개수 · 우리 지역 · 전체 일정
	$h .= '<div class="ebs__h">';
	if ( '' !== $a['title'] ) {
		$h .= '<h2 class="ebs__t">' . esc_html( $a['title'] ) . '</h2>'; // 다른 섹션 제목처럼 아이콘 없이(강조는 박스 배경으로)
	}
	$h .= '<span class="ebs__sum">접수 중 <b data-c="open">0</b><span class="ebs__sum-next"><span aria-hidden="true"> · </span>곧 시작 <b data-c="next">0</b></span></span>';
	$h .= '<details class="ebs-rg"><summary>' . ebs_svg( 'pin' ) . '<span class="ebs-rg__k">우리 지역</span><b class="ebs-rg__v">선택</b>' . ebs_svg( 'down' ) . '</summary>'
		. '<div class="ebs-rg__pop"><b>사는 곳을 고르면 그 지역 지원사업도 함께 보여요</b>'
		. '<label><span>시·도</span><select class="ebs-rg__sd"><option value="">선택</option></select></label>'
		. '<label><span>시·군·구</span><select class="ebs-rg__sg"><option value="">시·도 전체</option></select></label>'
		. '<span class="ebs-rg__btns"><button type="button" class="ebs-rg__clear">지우기</button><button type="button" class="ebs-rg__ok">적용</button></span>'
		. '<small>맞춤 찾기에서 고른 지역이 있으면 그대로 써요. 이 기기에만 저장돼요.</small></div></details>';
	if ( ! $full ) {
		$h .= '<a class="ebs__more" href="' . esc_url( home_url( '/schedule/#applying' ) ) . '">전체 일정' . ebs_svg( 'chev' ) . '</a>';
	}
	$h .= '</div>';

	// 상태 탭 + 대상 칩
	$h .= '<div class="ebs__bar"><div class="ebs__tabs" role="tablist" aria-label="상태로 보기">';
	foreach ( array( 'all' => '전체', 'open' => '접수 중', 'local' => '우리 지역', 'next' => '곧 시작' ) as $k => $label ) {
		$h .= '<button type="button" role="tab" data-f="' . $k . '" aria-selected="' . ( 'all' === $k ? 'true' : 'false' ) . '">' . esc_html( $label ) . ' <span data-c="' . $k . '">0</span></button>';
	}
	$h .= '</div>';
	if ( count( $who_on ) > 1 ) {
		$h .= '<div class="ebs__chips" role="group" aria-label="대상으로 보기"><button type="button" data-w="" aria-pressed="true">모두</button>';
		foreach ( ebs_personas() as $k => $label ) {
			if ( isset( $who_on[ $k ] ) ) {
				$h .= '<button type="button" data-w="' . esc_attr( $k ) . '" aria-pressed="false">' . esc_html( $label ) . '</button>';
			}
		}
		$h .= '</div>';
	}
	$h .= '</div>';

	// 좁은 칸 맨 위: 가장 가까운 마감(스크립트가 채움)
	$h .= '<a class="ebs__hero" href="#" hidden><span class="ebs__hero-t"><small></small><b></b></span><b class="ebs__hero-d"></b></a>';

	$h .= '<ul class="ebs__list">' . $rows . '</ul>';
	if ( $deferred ) { $h .= '<template class="ebs__deferred">' . $deferred . '</template>'; }
	$h .= '<div class="ebs__hint" hidden><span></span><button type="button" data-f="all">전체 일정 보기</button></div>';
	$h .= '<p class="ebs__empty"' . ( $rows ? ' hidden' : '' ) . '>' . ( $rows ? '고른 조건에 맞는 일정이 없어요. 다른 대상을 골라 보세요.' : '지금은 접수 중이거나 곧 시작하는 일정이 없어요. 새 공고가 나오면 이곳에 바로 올라와요.' ) . '</p>';

	// 아래 줄: 더 보기 · 세금 · 출처
	$h .= '<div class="ebs__foot"><button type="button" class="ebs__toggle" hidden aria-expanded="false"><span>더 보기</span>' . ebs_svg( 'down' ) . '</button>';
	if ( $tax ) {
		$first = $tax[0];
		$h    .= '<a class="ebs__tax" href="' . esc_url( home_url( '/schedule/#applying' ) ) . '">세금·납부 <b>' . count( $tax ) . '건</b> · ' . esc_html( $first['name'] ) . ' <b class="dd" data-dd="' . esc_attr( $first['open'] ? $first['e'] : $first['s'] ) . '"></b></a>';
	}
	$meta = ebs_meta();
	$h   .= '<span class="ebs__note">정부24·각 기관 공고 기준' . ( $meta['synced'] ? ' · ' . esc_html( wp_date( 'n.j', $meta['synced'] ) ) . ' 확인' : '' ) . ' · 신청 전 공고를 꼭 확인해 주세요</span></div>';
	$h   .= '</section>';
	return $h;
}

/** 지역 고르기 목록: 정부24 지역 사업에 나온 시·도 → 시·군·구 */
function ebs_region_options() {
	$out = array();
	foreach ( (array) get_option( 'ebs_raw', array() ) as $it ) {
		if ( 'local' !== ebs_org_kind( $it ) ) {
			continue;
		}
		$r = ebs_region_of( $it['org'] );
		if ( '' === $r[0] ) {
			continue;
		}
		if ( ! isset( $out[ $r[0] ] ) ) {
			$out[ $r[0] ] = array();
		}
		if ( '' !== $r[1] ) {
			$out[ $r[0] ][ $r[1] ] = true;
		}
	}
	ksort( $out );
	foreach ( $out as $sd => $sgs ) {
		$list = array_keys( $sgs );
		sort( $list );
		$out[ $sd ] = $list;
	}
	return $out;
}

function ebs_row_html( $x ) {
	$open = $x['open'];
	$key  = $open || ! $x['s'] ? $x['e'] : $x['s'];
	$name = esc_html( $x['name'] );
	$link = $x['guide'] ? $x['guide'] : $x['apply'];
	$ext  = ! $x['guide'] && $x['apply'];
	$per  = ebs_range( $x['s'], $x['e'] );
	$who  = $x['target'] ? esc_html( $x['target'] ) : '';
	$amt  = $x['amount'] ? esc_html( $x['amount'] ) : '';
	$lt   = $x['local'] ? '<span class="ebs-lc">' . esc_html( $x['sg'] ? $x['sg'] : ebs_short_sd( $x['sd'] ) ) . '</span>' : '';

	$h  = '<li class="ebs-r' . ( $x['local'] ? ' is-local' : '' ) . '" data-s="' . esc_attr( $x['s'] ) . '" data-e="' . esc_attr( $x['e'] ) . '" data-w="' . esc_attr( implode( ' ', $x['who'] ) ) . '"'
		. ( $x['local'] ? ' data-local="1" data-sd="' . esc_attr( $x['sd'] ) . '" data-sg="' . esc_attr( $x['sg'] ) . '" hidden' : '' ) . '>';
	$h .= '<span class="ebs-r__dd"><b class="dd" data-dd="' . esc_attr( $key ) . '"></b><small>' . ( $open ? '마감까지' : '시작까지' ) . '</small></span>';

	// 이름 · 분류·대상 (좁은 칸: 금액 · 마감일)
	$h .= '<span class="ebs-r__m"><span class="ebs-r__top">' . $lt
		. '<strong class="ebs-r__n">' . ( $link ? '<a href="' . esc_url( $link ) . '"' . ( $ext ? ' target="_blank" rel="noopener"' : '' ) . '>' . $name . '</a>' : $name ) . '</strong></span>'
		. '<span class="ebs-r__meta"><span class="ebs-r__cat">' . esc_html( $x['cat'] ) . '</span>' . ( $who ? '<span class="ebs-r__sep" aria-hidden="true">·</span>' . $who : '' ) . '</span>'
		. '<span class="ebs-r__mm">' . ( $amt ? '<b>' . $amt . '</b><span class="ebs-r__sep" aria-hidden="true">·</span>' : '' ) . esc_html( ( $open || ! $x['s'] ? '~' . ebs_nj( $x['e'] ) . ' 마감' : ebs_nj( $x['s'] ) . ' 시작' ) ) . '</span></span>';

	$h .= '<span class="ebs-r__amt">' . $amt . '</span>';
	$h .= '<span class="ebs-r__pl"><span class="ebs-r__p">' . esc_html( $per ) . '</span>' . ( $x['s'] ? '<span class="ebs-r__bar" aria-hidden="true"><i></i></span>' : '' ) . '</span>';

	// 버튼: 신청방법(내 글) → 신청하는 곳(공식) → 캘린더
	$h .= '<span class="ebs-r__act">';
	if ( $x['guide'] ) {
		$h .= '<a class="is-guide" href="' . esc_url( $x['guide'] ) . '">신청방법</a>';
	}
	if ( $x['apply'] ) {
		$h .= '<a href="' . esc_url( $x['apply'] ) . '" target="_blank" rel="noopener">' . esc_html( $x['apply_label'] ) . ebs_svg( 'ext' ) . '<span class="screen-reader-text"> (새 창)</span></a>';
	}
	$h .= ebs_bell_html( $x );
	$cal_d   = $open || ! $x['s'] ? $x['e'] : $x['s'];
	$cal_t   = $x['name'] . ( $open || ! $x['s'] ? ' 마감' : ' 접수 시작' );
	$details = '이지복지닷컴 신청·마감 일정 ' . home_url( '/schedule/' ) . ' - 기간은 공고에 따라 바뀔 수 있으니 담당 기관에서 확인해 주세요.';
	$gcal    = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . rawurlencode( $cal_t ) . '&dates=' . str_replace( '-', '', $cal_d ) . '/' . gmdate( 'Ymd', strtotime( $cal_d . ' +1 day' ) ) . '&details=' . rawurlencode( $details );
	$h      .= '<details class="ebs-cal"><summary aria-label="' . esc_attr( $cal_t . ' 날짜를 캘린더에 추가' ) . '">' . ebs_svg( 'calplus' ) . '</summary><span class="ebs-cal__pop"><b>' . esc_html( ebs_md( $cal_d ) . ( $open || ! $x['s'] ? ' 마감일' : ' 접수 시작일' ) ) . '</b><a href="' . esc_url( $gcal ) . '" target="_blank" rel="noopener">구글 캘린더에 추가</a><button type="button" data-ics="' . esc_attr( $cal_d ) . '" data-t="' . esc_attr( $cal_t ) . '">휴대폰·PC 캘린더 파일(.ics)</button></span></details>';
	$h      .= '</span>';
	$h      .= ebs_bell_html( $x ); // 좁은 칸(휴대폰)에서는 버튼 칸이 숨으므로 줄 오른쪽에 한 번 더 - board.css가 화면 폭에 맞는 하나만 보여 줌
	$h      .= '<span class="ebs-r__go" aria-hidden="true">' . ebs_svg( 'chev' ) . '</span>';
	$h      .= '</li>';
	return $h;
}

/** 마감 알림(웹 푸시) 종 버튼 - eb-schedule.php 끝 '마감 알림', board.js pushToggle (2026-10-15) */
function ebs_bell_html( $x ) {
	if ( get_option( 'ebs_push_off' ) ) {
		return '';
	}
	return '<button type="button" class="ebs-bell" data-push="' . esc_attr( $x['key'] ) . '" data-n="' . esc_attr( $x['name'] ) . '" aria-pressed="false" aria-label="' . esc_attr( $x['name'] . ' 시작·마감 알림 받기' ) . '" title="시작·마감 알림 받기">' . ebs_svg( 'bell' ) . '</button>';
}

/** "11.17" (요일 없이 - 휴대폰 두 줄 목록용) */
function ebs_nj( $ymd ) {
	return $ymd ? gmdate( 'n.j', strtotime( $ymd . ' 12:00:00 UTC' ) ) : '';
}

/** "서울특별시" → "서울", "충청북도" → "충북" (테마 맞춤 찾기와 같은 줄임) */
function ebs_short_sd( $sd ) {
	$s = preg_replace( '/(특별자치시|특별자치도|특별시|광역시)$/u', '', (string) $sd );
	$s = preg_replace_callback( '/^(충청|전라|경상)(남|북)도$/u', function ( $m ) {
		return mb_substr( $m[1], 0, 1 ) . $m[2];
	}, $s );
	return '경기도' === $s ? '경기' : $s;
}

function ebs_svg( $k ) {
	$p = array(
		'cal'     => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18M8 14h3"/>',
		'calplus' => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18M12 13v5M9.5 15.5h5"/>',
		'chev'    => '<path d="m9 6 6 6-6 6"/>',
		'down'    => '<path d="m6 9 6 6 6-6"/>',
		'ext'     => '<path d="M14 4h6v6M20 4l-9 9M18 14v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4"/>',
		'doc'     => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
		'pin'     => '<path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		'bell'    => '<path d="M6 9a6 6 0 0 1 12 0c0 6.5 2.5 8.5 2.5 8.5h-17S6 15.5 6 9"/><path d="M10.3 21a2 2 0 0 0 3.4 0"/>',
	);
	return '<svg class="ebs-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ( isset( $p[ $k ] ) ? $p[ $k ] : '' ) . '</svg>';
}

/** 스타일·스크립트는 한 페이지에 한 번만 */
/** 지역 사업 줄(HTML) - 보드가 사는 곳을 아는 방문자에게만 받아 감 (2026-10-15) */
add_action( 'rest_api_init', function () {
	register_rest_route( 'ebs/v1', '/local-rows', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function ( $req ) {
			$ahead = max( 7, min( 400, (int) $req->get_param( 'ahead' ) ) );
			$today = current_time( 'Y-m-d' );
			$tkey  = 'ebs_local_' . md5( $today . '|' . $ahead . '|' . (int) get_option( 'ebs_rev', 0 ) );
			$html  = get_transient( $tkey );
			if ( false === $html ) {
				$html = '';
				foreach ( ebs_items( array( 'ahead' => $ahead, 'today' => $today, 'local' => true ) ) as $x ) {
					if ( $x['local'] ) {
						$html .= ebs_row_html( $x );
					}
				}
				set_transient( $tkey, $html, HOUR_IN_SECONDS );
			}
			$res = new WP_REST_Response( array( 'html' => $html ) );
			$res->header( 'Cache-Control', 'public, max-age=3600' );
			return $res;
		},
	) );
} );

function ebs_assets_once() {
	static $done = false;
	if ( $done ) {
		return '';
	}
	$done = true;
	$css  = file_get_contents( __DIR__ . '/../assets/board.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$js   = file_get_contents( __DIR__ . '/../assets/board.js' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	return '<style id="ebs-css">' . $css . '</style><script nowprocket id="ebs-js">' . $js . '</script>';
}

/* 모든 페이지: 메가메뉴 미니 달력 '마감' 점 + 범례, 월간 달력 지역 표시 (작아서 head에 바로) */
add_action( 'wp_head', function () {
	echo '<style id="ebs-global">'
		. '.mx .m-days .due{position:relative;display:grid;place-items:center;height:27px;border-radius:6px;font-size:12.5px;color:#333d4b;font-weight:700;text-decoration:none}'
		. '.mx .m-days .due::after{content:"";position:absolute;bottom:1px;width:4px;height:4px;border-radius:50%;background:#d92d20}'
		. '.mx .m-days .due.pay::after{box-shadow:-5px 0 0 #1d3c78;transform:translateX(2.5px)}'
		. '.mx .m-days a:hover{background:#eef3fb}.mx .m-days .due.sun,.mx .m-days .due.hol{color:#d14b4b}.mx .m-days .due.today{color:#fff}'
		. '.mx .m-cal__h span.is-due i{background:#d92d20}'
		. '.eb-cal__pill.is-local{background:#efeafc!important;color:#4b2fa0!important;border-color:#d3c8f5!important}'
		. '.eb-cal__ongo{display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin:0 0 10px;padding:8px 10px;border-radius:10px;background:#f3faf6;font-size:12.5px}'
		. '.eb-cal__ongo>b{color:#0b7a55;font-weight:700;margin-right:2px}'
		. '.eb-cal__ongo a{display:inline-flex;align-items:center;gap:4px;height:24px;padding:0 9px;border-radius:999px;background:#fff;border:1px solid #cfeadd;color:#1b2433;text-decoration:none;white-space:nowrap}'
		. '.eb-cal__ongo a em{font-style:normal;color:#0b7a55;font-weight:700}.eb-cal__ongo a.is-local{border-color:#d3c8f5}.eb-cal__ongo a.is-local em{color:#4b2fa0}'
		. '.eb-cal__ongo a:hover{border-color:#9fd3bb}.eb-cal__ongo[hidden]{display:none}'
		. '.eb-cal__legend i.is-local{background:#efeafc;border:1px solid #d3c8f5}'
		. '@media (max-width:767px){.eb-cal__ongo{flex-wrap:nowrap;overflow-x:auto;scrollbar-width:none;-webkit-mask-image:linear-gradient(90deg,#000 85%,transparent);mask-image:linear-gradient(90deg,#000 85%,transparent)}.eb-cal__ongo::-webkit-scrollbar{display:none}.eb-cal__ongo>*{flex:none}}'
		. '</style>' . "\n";
}, 30 );
