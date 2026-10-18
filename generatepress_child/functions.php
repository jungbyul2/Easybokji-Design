<?php
/**
 * 이지복지(easybokji.com) GeneratePress 자식 테마 기능
 *
 * 원칙: 사용자 정의(Customizer)·Elements·플러그인 설정으로 안 되는 것만 여기에 둡니다.
 * 찾는 법: 편집기에서 Ctrl+F로 "/* 번호." (예: "/* 16.")를 찾으면 그 절로 갑니다.
 * 번호는 만든 순서라 분야별로 흩어져 있어, 아래에 분야별로 모았습니다. (47번은 비어 있음)
 * 새 기능은 65번부터 이어 붙이고, 이 목차의 맞는 분야에도 한 줄 추가합니다.
 * 복지 캘린더 일정·마감 알림(웹 푸시)은 이 파일이 아니라 eb-schedule 플러그인에 있습니다.
 * 디자인(CSS)은 css/ 폴더의 분야별 파일에 있습니다. 아래 주석의 'style.css NN번'은 나누기 전 옛 번호예요.
 *
 * [사이트 공통·디자인]
 *  1    Pretendard 글꼴
 *  2    사이트 제목(로고) · 2-1 로고 글자 SVG
 *  22   바탕색 (홈·분야·검색 body.eb-bg)
 *  23   콤팩트 푸터
 *  37   페이지스피드·접근성
 *  51   사이트 전체 글자 크기 (가 / 가+ / 가++)
 *  64   CSS 만들기: css/ 폴더 분야별 파일 → 페이지 종류별 파일 (안내: css/README.txt)
 *  67   사이드바 통일 (카드 모양·위젯 정리·가이드 칩·따라오는 상자)
 *  68   휴대폰 전체 메뉴 (하단 탭·머리 '메뉴' → 전체 화면 메뉴 #ebm, 메뉴 안 검색)
 *  69   글 속 관련 영상 손질 (영상 교체·소제목 통일·출처 줄)
 *  70   어르신 복지용구 안내 [eb_equip] (/senior-equipment/, 쿠팡 검색 상품)
 *  71   협업·제휴 안내 [eb_partners] (/partners/)
 *
 * [메뉴·헤더]
 *  9    메가 메뉴 설명
 *  20   메뉴 항목 묶음 제목(eb-menu-heading) - 옛 옆 메뉴 스크립트는 삭제(68번으로 대체)
 *  46   (삭제됨 - 68번 휴대폰 전체 메뉴로 대체)
 *  48   PC 헤더·메가메뉴 + 새 홈 [eb_home]
 *  49   메가메뉴 키보드 이동
 *  50   메가메뉴 미니 달력
 *  62   휴대폰·태블릿 손보기 (떠 있는 버튼 숨김·넓은 표)
 *
 * [홈]
 *  18   홈 화면(포털형) [eb_home]
 *  24   복지 정책 새 소식 (보건복지부 보도자료)
 *  32   홈 사이드바 중복 위젯 빼기
 *  40   많이 찾는 검색어 TOP 10 [eb_trend]
 *
 * [글 페이지]
 *  3    브레드크럼 (Rank Math)
 *  5    댓글 폼
 *  6    작성자 정보 보호
 *  14   TablePress 표 (넓은 표 상자·표 안 검색)
 *  15   글 읽는 경험 · 15-2 도움이 되었나요 · 15-4 목차
 *  27   글 속 이미지 갤러리 뷰어
 *  31   글 아래 순서 정리
 *  38   PC 사이드바 따라오는 목차 + 작은 광고
 *  45   글 아래 '함께 쓰면 좋은 도구'
 *  60   글 페이지 손질 (하단 탭 숨김 등)
 *  61   글 페이지 2차
 *  63   경로에 상위 분야·대표 이미지 alt
 *
 * [검색·목록]
 *  7    검색 결과 제목
 *  8    많이 본 글 [eb_popular]
 *  16   검색 (동의어·도구 상자·결과 없음 화면)
 *  19   글 도구 · 19-2 404 페이지 · 19-3 검색어 분석
 *       19-4·19-5 시험 검색 기록 정리 · 19-6 검색어 → 새 글 초안 · 19-7 맞춤 찾기 점검
 *  34   분야·태그·검색 목록을 게시판형으로
 *  39   사이드바 '많이 찾는' 검색어
 *
 * [맞춤 찾기·복지 정보]
 *  10   복지 급여 지급일 자동 계산 [eb_paydays] [eb_payday_table]
 *  12   지금 신청할 수 있는 지원 [eb_applying]
 *  13   오래 머무르게 하는 기능
 *       13-1·13-2 관련 계산기 · 13-4 분야 상단 · 13-5 최근 본 글
 *       13-6 맞춤 혜택 찾기 [eb_finder] · 13-7 용어사전 · 13-9 오래된 글 점검
 *  21   복지 캘린더 [eb_calendar]
 *  53   맞춤 찾기용 전용 태그 · 53-2 대상 지역 태그
 *  54   복지서비스 API 연결
 *  55   맞춤 혜택 찾기 화면 스크립트
 *  56   지자체 복지서비스 (사는 곳)
 *  57   혜택 찾기 아래 상황별·분야별 [eb_find_more]
 *  65   상황별 가이드 아래 '이 상황으로 혜택 찾기' + 가이드 이어 보기 (목록: eb_guide_list)
 *  66   계산기·가이드 저장·공유·최근 본 글 + /saved/ 알림 켠 일정 (휴대폰 메뉴 '알림'은 68번 아이콘 줄)
 *  59   휴대폰 빠른 맞춤 찾기 창
 *
 * [도구 페이지]
 *  11   계산기·기준표 [eb_calc] [eb_median_table]
 *  33   공식 서식 한글 파일(.hwp) 올리기 (/forms/)
 *  35   홈 화면 설치(PWA) · /manifest.webmanifest · /sw.js
 *  36   도로명주소·우편번호 찾기 [eb_juso]
 *  43   긴급·상담 전화 모음 [eb_hotlines]
 *  44   우리 동네 복지 기관 찾기 [eb_nearby]
 *  52   휴대폰 '홈 화면에 추가' 안내
 *
 * [광고·제휴·후원]
 *  4    제휴 링크 처리 (쿠팡 파트너스 고지·rel)
 *  25   광고 제외 페이지
 *  26   홈·목록 광고 칸
 *  28   돕는 방법 [eb_support] · 28-2 후원하기
 *  29   쿠팡 파트너스 API
 *
 * [운영·관리자]
 *  17   제안서 접수 폼 [eb_proposal_form]
 *  30   구글 애널리틱스(GA4)
 *  41   연락 이메일 [eb_email]
 *  42   사이트 메일 발송 (SMTP)
 *  58   관리자 화면 콤팩트
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 1. Pretendard 글꼴 --------------------------------------------------------
 * 페이지에 쓰인 글자만 내려받는 동적 서브셋을 사용합니다.
 * (GeneratePress 폰트 라이브러리는 한글 전체 파일만 올릴 수 있어 훨씬 무겁습니다.)
 * 글꼴 이름 지정은 사용자 정의 > 타이포그래피에서 합니다.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'pretendard',
		'https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css',
		array(),
		'1.3.9'
	);
}, 5 );

add_filter( 'wp_resource_hints', function ( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://cdn.jsdelivr.net',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}, 10, 2 );

/* 2. 사이트 제목(로고) ----------------------------------------------------------
 * - 홈에서 헤더·고정 메뉴·모바일 헤더의 사이트 제목이 모두 <h1>로 나오던 문제 해결
 *   (홈의 H1은 Elements "홈 상단 소개"가 담당)
 * - 로고 글자: 심볼(새싹) + '이지복지닷컴' 한 줄(2026-10-07, 휴대폰 메뉴와 통일). 글자는 2-1번 SVG, 심볼은 style.css에서 표시
 * - 화면 낭독기·검색엔진용 사이트 이름(설정 > 일반 '이지복지닷컴')은 숨김 텍스트로 유지
 */
/* 2-1. 로고 글자 '이지복지닷컴' (SVG, 2026-10-07) ------------------------------------------------
 * G마켓 산스 Bold 글자 모양을 그림(path)으로 바꿔 넣음 → 글꼴 파일을 따로 받지 않아 속도 영향 없음.
 * 색은 글자색(currentColor)을 따름. 헤더(2번)·푸터(23번)에서 쓰고, 휴대폰 메뉴(46번 JS)는 헤더 것을 복사해 씀.
 */
function eb_wordmark() {
	return '<svg class="eb-wordmark" viewBox="7 -75 542 87" fill="currentColor" aria-hidden="true" focusable="false"><path d="M87.5-75L70.6-75L70.6 10.4L87.5 10.4ZM34.3-74C18.2-74 7.4-61.4 7.4-33.3C7.4-5.2 18.2 7.4 34.3 7.4C50.4 7.4 61.1-5.2 61.1-33.3C61.1-61.4 50.4-74 34.3-74ZM34.3-58.5C39.9-58.5 44.4-52.4 44.4-33.3C44.4-14.1 39.9-8.1 34.3-8.1C28.6-8.1 24.1-14.1 24.1-33.3C24.1-52.4 28.6-58.5 34.3-58.5ZM162.8-75L162.8 10.4L179.7 10.4L179.7-75ZM137.3-57.5L155.6-57.5L155.6-73L101-73L101-57.5L120.3-57.5C119.7-30.1 111.1-12 98.6-10.6L98.6 6.4C111.6 6.3 122.5-2.2 129.4-17.4L146.6 6L160-4L135.2-36.2C136.4-42.7 137.1-49.8 137.3-57.5ZM240.9-33.5L240.9-38.4L270.5-38.4L270.5-75L254-75L254-69L211-69L211-75L194.5-75L194.5-38.4L224.1-38.4L224.1-33.5L189.3-33.5L189.3-20.1L275.7-20.1L275.7-33.5ZM211-56.8L254-56.8L254-50.9L211-50.9ZM193.9-2.7L253.6-2.7L253.6 11.4L270.7 11.4L270.7-15.9L193.9-15.9ZM347.2-75L347.2 10.4L364.1 10.4L364.1-75ZM321.7-57.5L340-57.5L340-73L285.4-73L285.4-57.5L304.7-57.5C304.1-30.1 295.5-12 283-10.6L283 6.4C296 6.3 306.9-2.2 313.8-17.4L331 6L344.4-4L319.6-36.2C320.8-42.7 321.5-49.8 321.7-57.5ZM453.9-59.1L453.9-75L437-75L437-16.7L453.9-16.7L453.9-42.7L463.9-42.7L463.9-59.1ZM433-30.4L433-44.2C428.5-42.4 421-41.4 413.3-41.4L392.6-41.4L392.6-59.9L428.1-59.9L428.1-74L375.6-74L375.6-27.4L412.6-27.4C420.6-27.4 428.6-28.5 433-30.4ZM427.7-21.2L410.8-24.2C407.6-12.2 393.6-5.4 377.7-5.4L377.7 10.4C391.8 10.4 405.6 6.2 415.4-2L451.9 11.5L457.9-3.5L425-14.1C426.1-16.3 427-18.7 427.7-21.2ZM532-75L532-59.3L519.6-59.3L519.6-60.2L519.6-74L467.9-74L467.9-61.5L503.5-61.5L503.5-57.2L467.9-57.2L467.9-45.1L498.2-45.1C492.3-41.1 481.5-40.1 467.9-40.1L467.9-27.5C489-27.5 506.9-32.1 515-44L532-44L532-27.4L548.9-27.4L548.9-75ZM472.5 10.4L548.9 10.4L548.9-24.4L472.5-24.4ZM489.4-10.7L532-10.7L532-3.3L489.4-3.3Z"/></svg>';
}

add_filter( 'generate_site_title_output', function ( $output ) {
	$output = preg_replace( array( '/<h1(\s|>)/', '/<\/h1>/' ), array( '<p$1', '</p>' ), $output );

	$brand = '<span class="eb-brand">'
		. '<span class="eb-brand__name" aria-hidden="true">' . eb_wordmark() . '</span>'
		. '</span>'
		. '<span class="screen-reader-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';

	return preg_replace_callback(
		'#(<a[^>]*>).*?(</a>)#s',
		function ( $m ) use ( $brand ) {
			return $m[1] . $brand . $m[2];
		},
		$output,
		1
	);
} );

/* 3. 브레드크럼 ---------------------------------------------------------------
 * Rank Math 브레드크럼을 사용합니다(구조화 데이터와 일치).
 * 문구·구분자는 Rank Math > 일반 설정 > 브레드크럼에서 설정합니다.
 */
add_action( 'generate_before_entry_title', function () {
	if ( is_single() && function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	}
} );

// 이전/다음 글을 같은 카테고리 안에서만 연결
add_filter( 'generate_category_post_navigation', '__return_true' );

// 글 목록 카드에는 최종 수정일만 표시 (글 본문에서는 최종 수정일·최초 작성일 모두 표시)
add_filter( 'generate_post_date_show_updated_only', function () {
	return ! is_singular();
} );

/* 4. 제휴 링크 ----------------------------------------------------------------
 * - 쿠팡 링크가 있는 글에만 본문 맨 위에 공정위 고지 문구를 자동 표시합니다.
 *   (공정위 추천·보증 심사지침: 게시물 첫 부분 또는 제목에 표시)
 * - 쿠팡 링크에 rel="sponsored nofollow"를 붙입니다(구글 권장).
 */
function eb_has_coupang_link( $content ) {
	return (bool) preg_match( '#https?://(link\.)?coupang\.com|coupa\.ng#i', $content );
}

add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	if ( ! eb_has_coupang_link( $content ) ) {
		return $content;
	}

	$tags = new WP_HTML_Tag_Processor( $content );
	while ( $tags->next_tag( 'a' ) ) {
		$href = (string) $tags->get_attribute( 'href' );
		if ( eb_has_coupang_link( $href ) ) {
			$tags->set_attribute( 'rel', 'sponsored nofollow noopener' );
		}
	}
	$content = $tags->get_updated_html();

	$notice = '<p class="eb-disclosure">이 포스팅은 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받습니다.</p>';

	return $notice . $content;
}, 20 );

/* 5. 댓글 폼 ------------------------------------------------------------------ */

// 닉네임만 받기(이메일·웹사이트 칸 제거) + 저장 체크박스 문구
add_filter( 'comment_form_default_fields', function ( $fields ) {
	$commenter = wp_get_current_commenter();

	unset( $fields['url'], $fields['email'] );

	$fields['author'] = sprintf(
		'<p class="comment-form-author"><label for="author" class="screen-reader-text">닉네임</label><input id="author" name="author" type="text" placeholder="닉네임 *" value="%s" size="30" maxlength="30" autocomplete="nickname" required /></p>',
		esc_attr( $commenter['comment_author'] )
	);

	$consent = empty( $commenter['comment_author'] ) ? '' : ' checked';

	$fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /><label for="wp-comment-cookies-consent">이 브라우저에 닉네임을 저장합니다.</label></p>';

	return $fields;
}, 20 );

// 댓글 입력칸 안내 문구
add_filter( 'comment_form_field_comment', function () {
	return '<p class="comment-form-comment"><label for="comment" class="screen-reader-text">댓글</label><textarea id="comment" name="comment" cols="45" rows="5" maxlength="65525" placeholder="궁금한 점이나 의견을 남겨 주세요. 개인정보(주민번호·연락처)는 적지 마세요." required></textarea></p>';
}, 20 );

// 비로그인 댓글은 닉네임 필수
add_filter( 'preprocess_comment', function ( $commentdata ) {
	if ( ! is_user_logged_in() && '' === trim( (string) $commentdata['comment_author'] ) ) {
		wp_die(
			'닉네임을 입력해 주세요.',
			'댓글 등록 오류',
			array( 'back_link' => true, 'response' => 400 )
		);
	}
	return $commentdata;
} );


// 댓글 폼 제목·안내·버튼 문구
add_filter( 'comment_form_defaults', function ( $defaults ) {
	$defaults['title_reply']          = '댓글 남기기';
	$defaults['title_reply_to']       = '%s 님에게 답글 남기기';
	$defaults['cancel_reply_link']    = '답글 취소';
	$defaults['label_submit']         = '댓글 등록';
	$defaults['comment_notes_before'] = '<p class="comment-notes">궁금한 점이나 의견을 편하게 남겨 주세요. 댓글은 운영자 확인 후 게시되며, 주민번호·연락처 같은 개인정보는 적지 마세요.</p>';
	return $defaults;
}, 20 );

/* 6. 작성자 정보 보호 ---------------------------------------------------------
 * 작성자 링크는 소개 페이지로 연결하고, 방문자에게는 사용자 목록 API를 숨깁니다.
 * (작성자 아카이브 자체는 Rank Math > 제목 및 메타 > 작성자에서 '사용 안 함')
 */
add_filter( 'author_link', function () {
	return home_url( '/about/' );
} );

add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );

/* 7. 검색 결과 제목 ------------------------------------------------------------
 * "'검색어' 검색 결과 · 총 N건" 형식 (결과 없음 안내는 Elements "검색 결과 없음 안내")
 */
add_filter( 'generate_search_title_output', function () {
	global $wp_query;
	return sprintf(
		'<header class="page-header eb-search-head"><h1 class="page-title">‘<span>%1$s</span>’ 검색 결과</h1><p class="eb-search-count">글 %2$s건</p></header>',
		esc_html( get_search_query() ),
		esc_html( number_format_i18n( (int) $wp_query->found_posts ) )
	);
} );

/* 8. 많이 본 글 [eb_popular] --------------------------------------------------
 * WP Statistics의 최근 30일 조회수 기준 상위 5개. 결과는 6시간 캐시.
 * 사이드바 위젯(단축코드 블록)에서 사용합니다.
 */
function eb_popular_posts_html( $limit = 5 ) {
	$cached = get_transient( 'eb_popular_posts' );
	if ( false !== $cached ) {
		return $cached;
	}

	global $wpdb;
	$table = $wpdb->prefix . 'statistics_pages';
	$ids   = array();
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
		$ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE type = 'post' AND date >= %s GROUP BY id ORDER BY SUM(count) DESC LIMIT 15",
				gmdate( 'Y-m-d', strtotime( '-30 days' ) )
			)
		);
	}
	$ids = array_values( array_filter( array_map( 'intval', (array) $ids ) ) );

	$html = '';
	if ( $ids ) {
		$posts = get_posts( array(
			'post__in'            => $ids,
			'orderby'             => 'post__in',
			'posts_per_page'      => $limit,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		) );
		if ( $posts ) {
			$html .= '<h2 class="widget-title">많이 본 글</h2><ol class="eb-popular">';
			foreach ( $posts as $post ) {
				$html .= sprintf(
					'<li><a href="%1$s">%2$s</a></li>',
					esc_url( get_permalink( $post ) ),
					esc_html( get_the_title( $post ) )
				);
			}
			$html .= '</ol>';
		}
	}

	set_transient( 'eb_popular_posts', $html, 6 * HOUR_IN_SECONDS );
	return $html;
}
add_shortcode( 'eb_popular', function () {
	return eb_popular_posts_html( 5 );
} );

/* 9. 메가 메뉴 설명 ------------------------------------------------------------
 * 메인 메뉴 2단계 항목(분야 제목) 아래에 메뉴 항목의 "설명"을 한 줄로 표시합니다.
 * 설명 문구는 외모 > 메뉴 > 각 항목의 "설명"에서 고칩니다.
 */
add_filter( 'nav_menu_item_title', function ( $title, $item, $args, $depth ) {
	if ( 1 === $depth && 'primary' === $args->theme_location && ! empty( $item->description ) ) {
		$title .= '<span class="eb-menu-desc">' . esc_html( $item->description ) . '</span>';
	}
	return $title;
}, 10, 4 );

/* 10. 복지 급여 지급일 자동 계산 ------------------------------------------------
 * 매달 정해진 날(20일·25일)이 토·일요일이나 공휴일이면 그 전 평일로 당겨 표시합니다.
 * [eb_paydays]      : 사이드바 "다가오는 지급일"
 * [eb_payday_table] : 신청 일정 페이지의 월별 실제 지급일 표 (months="4")
 * ※ 공휴일 목록은 해마다 한 번 eb_holidays()에 추가해야 합니다(대체공휴일·임시공휴일 포함).
 */
// 공휴일·대체공휴일(달력 표시용 이름 포함) - 목록은 eb_holidays() 한 곳에서 고칩니다.
function eb_kr_holiday_names() {
	// 2026-10-18: 따로 적어 두던 목록에 노동절·제헌절(과 대체일)이 빠져 있어서, 날짜 계산기와 같은 eb_holidays() 하나로 합침
	return eb_holidays();
}

function eb_kr_holidays() {
	return array_keys( eb_kr_holiday_names() );
}

function eb_payday_groups() {
	return array(
		20 => '생계급여·주거급여·장애인연금',
		25 => '기초연금·국민연금·아동수당·부모급여',
	);
}

function eb_payday_date( $year, $month, $day ) {
	$date     = new DateTimeImmutable( sprintf( '%04d-%02d-%02d', $year, $month, $day ), wp_timezone() );
	$holidays = eb_kr_holidays();
	while ( (int) $date->format( 'N' ) >= 6 || in_array( $date->format( 'Y-m-d' ), $holidays, true ) ) {
		$date = $date->modify( '-1 day' );
	}
	return $date;
}

function eb_payday_label( DateTimeImmutable $date ) {
	$weekdays = array( '월', '화', '수', '목', '금', '토', '일' );
	return $date->format( 'n.j' ) . '(' . $weekdays[ (int) $date->format( 'N' ) - 1 ] . ')';
}

// 다가오는 신청·납부 기간(21번 eb_deadline_rules, 마감 가까운 순). 사이드바 '신청·마감'(아래 [eb_paydays])과 휴대폰 메뉴 '다가오는 일정'(46번)이 함께 씀
function eb_upcoming_dues( $today, $limit = 6 ) {
	$dues = array();
	foreach ( array( (int) $today->format( 'Y' ), (int) $today->format( 'Y' ) + 1 ) as $y ) {
		foreach ( eb_deadline_rules() as $r ) {
			$end = eb_due_date( $y, $r[3] );
			if ( $end < $today ) {
				continue;
			}
			$start  = '' !== $r[2] ? new DateTimeImmutable( $y . '-' . $r[2], wp_timezone() ) : null;
			$dues[] = array(
				'n'  => $r[1],
				'k'  => $r[0], // 짧은 이름(달력 칸) - 홈 '신청·마감 일정'에서 신청하는 곳 연결에 씀 (2026-10-09)
				'e'  => $end->format( 'Y-m-d' ),
				'el' => eb_payday_label( $end ),
				'ej' => $end->format( 'n.j' ),
				's'  => $start ? $start->format( 'Y-m-d' ) : '',
				'sl' => $start ? eb_payday_label( $start ) : '',
			);
		}
	}
	usort( $dues, function ( $a, $b ) {
		return strcmp( $a['e'], $b['e'] );
	} );
	// 복지 일정 플러그인(eb-schedule)이 정부24·직접 추가 일정을 더함 - 메뉴 '다가오는 일정'·알림 줄·달력 카드 (2026-10-10)
	$dues = apply_filters( 'eb_upcoming_dues', $dues, $today );
	return array_slice( $dues, 0, $limit );
}

add_shortcode( 'eb_paydays', function () {
	$today = current_datetime()->setTime( 0, 0 );
	$html  = '';
	$data  = array();
	foreach ( eb_payday_groups() as $day => $what ) {
		// 이번 달·다음 달·다다음 달 날짜를 함께 넣어 두고, 화면에서 방문자 날짜로 다시 고릅니다(캐시된 페이지 대비)
		for ( $i = 0; $i < 3; $i++ ) {
			$m      = $today->modify( 'first day of this month' )->modify( "+{$i} month" );
			$d      = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $day );
			$data[] = array( 'g' => $day, 'd' => $d->format( 'Y-m-d' ), 'l' => eb_payday_label( $d ) );
		}
		$date = eb_payday_date( (int) $today->format( 'Y' ), (int) $today->format( 'n' ), $day );
		if ( $date < $today ) {
			$next = $today->modify( 'first day of next month' );
			$date = eb_payday_date( (int) $next->format( 'Y' ), (int) $next->format( 'n' ), $day );
		}
		$diff = (int) $today->diff( $date )->days;
		$html .= sprintf(
			'<li data-g="%4$d"><span class="eb-paydays__day">%1$s</span><span class="eb-paydays__what">%2$s</span><span class="eb-paydays__dday">%3$s</span></li>',
			esc_html( eb_payday_label( $date ) ),
			esc_html( $what ),
			0 === $diff ? '오늘' : 'D-' . $diff,
			$day
		);
	}
	$html = '<ul class="eb-paydays" data-pay="' . esc_attr( wp_json_encode( $data ) ) . '">' . $html . '</ul>';

	// 신청·마감 1건: 복지 캘린더(21번)의 법정 신청·납부 기간 중 마감이 가장 가까운 것. 접수 중이면 마감일, 아직이면 시작일을 보여 줌
	$dues = eb_upcoming_dues( $today );
	if ( $dues ) {
		$x     = $dues[0];
		$open  = '' === $x['s'] || $x['s'] <= $today->format( 'Y-m-d' );
		$to    = new DateTimeImmutable( $open ? $x['e'] : $x['s'], wp_timezone() );
		$diff  = (int) $today->diff( $to )->days;
		$html .= '<p class="eb-paydays__sub">신청·마감</p>';
		$html .= sprintf(
			'<ul class="eb-paydays eb-paydays--due" data-due="%1$s"><li class="%2$s"><span class="eb-paydays__day">%3$s</span><span class="eb-paydays__what">%4$s<small class="eb-paydays__state">%5$s</small></span><span class="eb-paydays__dday">%6$s</span></li></ul>',
			esc_attr( wp_json_encode( $dues ) ),
			$open ? 'is-open' : 'is-soon',
			esc_html( $open ? $x['el'] : $x['sl'] ),
			esc_html( $x['n'] ),
			esc_html( $open ? '접수 중 · ' . $x['ej'] . ' 마감' : '접수 시작 · ' . $x['ej'] . ' 마감' ),
			0 === $diff ? '오늘' : 'D-' . $diff
		);
	}

	$html .= '<p class="eb-paydays__note">주말·공휴일을 반영한 날짜 · <a href="/schedule/">전체 일정 →</a></p>';
	$html .= "<script nowprocket>(function(){var n=new Date(),t=new Date(n.getFullYear(),n.getMonth(),n.getDate());function day(s){return new Date(s+'T00:00:00');}function dd(s){var v=Math.round((day(s)-t)/864e5);return v?'D-'+v:'오늘';}document.querySelectorAll('.eb-paydays[data-pay]').forEach(function(u){var d=JSON.parse(u.getAttribute('data-pay'));u.querySelectorAll('li[data-g]').forEach(function(li){var g=+li.getAttribute('data-g'),x=d.filter(function(i){return i.g===g&&day(i.d)>=t;})[0];if(!x){return;}li.querySelector('.eb-paydays__day').textContent=x.l;li.querySelector('.eb-paydays__dday').textContent=dd(x.d);});});document.querySelectorAll('.eb-paydays[data-due]').forEach(function(u){var x=JSON.parse(u.getAttribute('data-due')).filter(function(i){return day(i.e)>=t;})[0],li=u.querySelector('li');if(!x||!li){return;}var open=!x.s||day(x.s)<=t;li.className=open?'is-open':'is-soon';li.querySelector('.eb-paydays__day').textContent=open?x.el:x.sl;li.querySelector('.eb-paydays__what').firstChild.nodeValue=x.n;li.querySelector('.eb-paydays__state').textContent=(open?'접수 중 · ':'접수 시작 · ')+x.ej+' 마감';li.querySelector('.eb-paydays__dday').textContent=dd(open?x.e:x.s);});})();</script>";
	return $html;
} );

add_shortcode( 'eb_payday_table', function ( $atts ) {
	$atts   = shortcode_atts( array( 'months' => 4 ), $atts );
	$today  = current_datetime()->setTime( 0, 0 );
	$month  = $today->modify( 'first day of this month' );
	$groups = eb_payday_groups();

	$html = '<figure class="wp-block-table eb-payday-table"><table class="has-fixed-layout"><thead><tr><th>월</th>';
	foreach ( $groups as $day => $what ) {
		$html .= sprintf( '<th>%1$d일 지급<br><small>%2$s</small></th>', $day, esc_html( $what ) );
	}
	$html .= '</tr></thead><tbody>';
	for ( $i = 0; $i < max( 1, (int) $atts['months'] ); $i++ ) {
		$m     = $month->modify( "+{$i} month" );
		$html .= '<tr><td><strong>' . esc_html( $m->format( 'Y년 n월' ) ) . '</strong></td>';
		foreach ( array_keys( $groups ) as $day ) {
			$date  = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $day );
			$moved = (int) $date->format( 'j' ) !== $day;
			$html .= sprintf(
				'<td class="%1$s">%2$s%3$s</td>',
				$date < $today ? 'is-past' : '',
				esc_html( eb_payday_label( $date ) ),
				$moved ? ' <small>앞당김</small>' : ''
			);
		}
		$html .= '</tr>';
	}
	$html .= '</tbody></table></figure>';
	return $html;
} );

/* 11. 계산기·기준표 ------------------------------------------------------------
 * [eb_calc type="..."] : median(기준 중위소득) severance(퇴직금) unemployment(실업급여)
 *                        weekly(주휴수당·월급) leave(연차) notice(해고예고수당)
 *                        insurance(4대보험) saving(적금 이자) pension(기초연금)
 *                        age(만 나이) eitc(근로·자녀장려금) parental(육아휴직급여)
 * [eb_median_table]    : 가구원 수별 기준 중위소득·선정기준 표
 * ※ 해마다 바뀌는 숫자는 eb_median_income()·eb_rates()·eb_eitc()·eb_parental()에만 있습니다.
 *    기준 중위소득: 매년 8월 보건복지부 고시 / 나머지: 매년 1월(국민연금 소득 상·하한은 7월)
 */
function eb_median_income() {
	return array(
		'year'   => 2026,
		'source' => '보건복지부 고시 제2025-135호',
		'median' => array(
			1 => 2564238,
			2 => 4199292,
			3 => 5359036,
			4 => 6494738,
			5 => 7556719,
			6 => 8555952,
			7 => 9515150,
		),
	);
}

function eb_rates() {
	return array(
		'year'          => 2026,
		'min_wage'      => 10320,   // 최저임금 시간급
		'unemp_max'     => 68100,   // 구직급여 1일 상한액
		'pension_rate'  => 4.75,    // 국민연금 근로자 부담(%)
		'pension_floor' => wp_date( 'Y-m-d' ) >= '2026-07-01' ? 410000 : 400000,
		'pension_cap'   => wp_date( 'Y-m-d' ) >= '2026-07-01' ? 6590000 : 6370000,
		'pension_period'=> wp_date( 'Y-m-d' ) >= '2026-07-01' ? '2026.7~2027.6' : '2025.7~2026.6',
		'health_rate'   => 3.595,   // 건강보험 근로자 부담(%)
		'health_total'  => 7.19,    // 건강보험료율 전체(%)
		'care_total'    => 0.9448,  // 장기요양보험료율 전체(%)
		'employ_rate'   => 0.9,     // 고용보험 근로자 부담(%)
		'bp_single'     => 2470000, // 기초연금 선정기준액(단독)
		'bp_couple'     => 3952000, // 기초연금 선정기준액(부부)
		'bp_amount'     => 349700,  // 기초연금 기준연금액(월 최대)
		'mat_cap'       => 2200000, // 출산전후휴가급여 상한(30일 기준, 2026.1~)
	);
}

// 연도별 최저임금 시간급(최저임금 월급 계산기). 새 연도가 고시되면 한 줄 추가
function eb_min_wages() {
	return array(
		2026 => 10320,
		2027 => 10700,
	);
}

// 공휴일·대체공휴일(날짜 계산기 근무일). 관공서 공휴일 규정 기준, 2026년부터 노동절(5.1)·제헌절(7.17) 포함. 새해 공휴일이 발표되면 추가
function eb_holidays() {
	return array(
		'2026-01-01' => '신정', '2026-02-16' => '설날 연휴', '2026-02-17' => '설날', '2026-02-18' => '설날 연휴', '2026-03-01' => '삼일절', '2026-03-02' => '대체공휴일',
		'2026-05-01' => '노동절', '2026-05-05' => '어린이날', '2026-05-24' => '부처님오신날', '2026-05-25' => '대체공휴일', '2026-06-03' => '지방선거일', '2026-06-06' => '현충일',
		'2026-07-17' => '제헌절', '2026-08-15' => '광복절', '2026-08-17' => '대체공휴일', '2026-09-24' => '추석 연휴', '2026-09-25' => '추석', '2026-09-26' => '추석 연휴',
		'2026-10-03' => '개천절', '2026-10-05' => '대체공휴일', '2026-10-09' => '한글날', '2026-12-25' => '성탄절',
		'2027-01-01' => '신정', '2027-02-06' => '설날 연휴', '2027-02-07' => '설날', '2027-02-08' => '설날 연휴', '2027-02-09' => '대체공휴일', '2027-03-01' => '삼일절',
		'2027-05-01' => '노동절', '2027-05-03' => '대체공휴일', '2027-05-05' => '어린이날', '2027-05-13' => '부처님오신날', '2027-06-06' => '현충일', '2027-07-17' => '제헌절',
		'2027-07-19' => '대체공휴일', '2027-08-15' => '광복절', '2027-08-16' => '대체공휴일', '2027-09-14' => '추석 연휴', '2027-09-15' => '추석', '2027-09-16' => '추석 연휴',
		'2027-10-03' => '개천절', '2027-10-04' => '대체공휴일', '2027-10-09' => '한글날', '2027-10-11' => '대체공휴일', '2027-12-25' => '성탄절', '2027-12-27' => '대체공휴일',
	);
}

// 근로·자녀장려금: 매년 5월 정기신청 기준(전년도 소득분). 세법이 바뀌면 이 숫자만 고칩니다.
function eb_eitc() {
	return array(
		'year'        => 2026,
		'income_year' => 2025,
		// 가구 유형 => 점증 구간 끝, 평탄 구간 끝, 소득 상한, 최대 지급액 (총급여액 기준, 원)
		'eitc'        => array(
			'single' => array( 4000000, 9000000, 22000000, 1650000 ),
			'one'    => array( 7000000, 14000000, 32000000, 2850000 ),
			'two'    => array( 8000000, 17000000, 44000000, 3300000 ),
		),
		// 자녀장려금: 자녀 1인당 최대 금액을 받는 소득 구간 끝, 소득 상한, 최대·최소 금액
		'ctc'         => array(
			'one'   => 21000000,
			'two'   => 25000000,
			'limit' => 70000000,
			'max'   => 1000000,
			'min'   => 500000,
		),
		'asset_half'  => 170000000,
		'asset_limit' => 240000000,
	);
}

// 육아휴직급여: 2026-01-01 이후 시작한 육아휴직 기준
function eb_parental() {
	return array(
		'year'  => 2026,
		'floor' => 700000,
		// 몇 개월째까지 => 통상임금 대비 %, 월 상한액
		'steps' => array(
			array( 3, 100, 2500000 ),
			array( 6, 100, 2000000 ),
			array( 18, 80, 1600000 ),
		),
		// 6+6 부모육아휴직제: 1~6개월째 월 상한액(통상임금 100%)
		'six'   => array( 2500000, 2500000, 3000000, 3500000, 4000000, 4500000 ),
	);
}

function eb_median_rates() {
	return array(
		array( '생계급여', 32 ),
		array( '의료급여', 40 ),
		array( '주거급여', 48 ),
		array( '교육급여·차상위', 50 ),
	);
}

add_shortcode( 'eb_median_table', function () {
	$data = eb_median_income();
	$html = '<figure class="wp-block-table eb-scroll-table"><table><thead><tr><th>가구원 수</th><th>기준 중위소득</th>';
	foreach ( eb_median_rates() as $rate ) {
		$html .= sprintf( '<th>%1$s<br><small>중위 %2$d%%</small></th>', esc_html( $rate[0] ), $rate[1] );
	}
	$html .= '</tr></thead><tbody>';
	foreach ( $data['median'] as $size => $median ) {
		$html .= sprintf( '<tr><td><strong>%1$d인</strong></td><td>%2$s</td>', $size, number_format( $median ) );
		foreach ( eb_median_rates() as $rate ) {
			$html .= '<td>' . number_format( round( $median * $rate[1] / 100 ) ) . '</td>';
		}
		$html .= '</tr>';
	}
	$html .= '</tbody></table><figcaption>' . esc_html( $data['year'] . '년 기준, 단위: 원/월 · 출처: ' . $data['source'] ) . '</figcaption></figure>';
	return $html;
} );

// 계산기 빈 칸 예시값(placeholder '예: …'). 키는 '계산기 종류.칸 이름' (2026-10-18)
function eb_calc_ph( $type, $name ) {
	$ph = array(
		'median.income'     => '1,500,000',
		'severance.wage'    => '9,000,000',
		'severance.bonus'   => '3,000,000',
		'severance.leave'   => '500,000',
		'unemployment.wage' => '9,000,000',
		'insurance.pay'     => '3,000,000',
		'saving.amount'     => '300,000',
		'saving.rate'       => '3.5',
		'pension.income'    => '800,000',
		'eitc.income'       => '15,000,000',
		'parental.wage'     => '3,000,000',
		'minwage.pay'       => '2,200,000',
		'leavepay.wage'     => '3,000,000',
		'maternity.wage'    => '3,000,000',
	);
	return $ph[ $type . '.' . $name ] ?? '';
}

// 계산기 입력 칸 정의: 이름, 이름표, 종류(money·number·date·select), 도움말, 선택지/기본값, 한 줄 전체 여부
function eb_calc_defs() {
	$r     = eb_rates();
	$e     = eb_eitc();
	$sizes = array();
	foreach ( array_keys( eb_median_income()['median'] ) as $size ) {
		$sizes[ $size ] = $size . '인 가구';
	}
	// 최저임금 연도: 올해를 맨 앞(기본값)에
	$years = array();
	foreach ( eb_min_wages() as $year => $wage ) {
		$years[ $year ] = $year . '년 (시급 ' . number_format( $wage ) . '원)';
	}
	$this_year = (int) wp_date( 'Y' );
	if ( isset( $years[ $this_year ] ) ) {
		$years = array( $this_year => $years[ $this_year ] ) + $years;
	}
	return array(
		'median'       => array( '확인하기', array(
			array( 'n', '가구원 수', 'select', '', $sizes ),
			array( 'income', '월 소득인정액', 'money', '선택', '' ),
		) ),
		'severance'    => array( '퇴직금 계산하기', array(
			array( 'start', '입사일', 'date', '', '' ),
			array( 'last', '마지막 근무일', 'date', '', '' ),
			array( 'wage', '퇴직 전 3개월 임금 총액', 'money', '세전 · 기본급과 매달 받는 수당 포함', '', true ),
			array( 'bonus', '연간 상여금 총액', 'money', '선택', '' ),
			array( 'leave', '연차수당', 'money', '선택', '' ),
		) ),
		'unemployment' => array( '실업급여 계산하기', array(
			array( 'last', '마지막 근무일', 'date', '', '' ),
			array( 'wage', '퇴직 전 3개월 임금 총액', 'money', '세전', '' ),
			array( 'age', '퇴직 당시 나이', 'select', '', array( 'u50' => '50세 미만', 'o50' => '50세 이상 또는 장애인' ) ),
			array( 'period', '고용보험 가입 기간', 'select', '', array( '0' => '1년 미만', '1' => '1년 이상 ~ 3년 미만', '2' => '3년 이상 ~ 5년 미만', '3' => '5년 이상 ~ 10년 미만', '4' => '10년 이상' ) ),
			array( 'hours', '하루 소정근로시간', 'number', '시간', '8' ),
		) ),
		'weekly'       => array( '월급 계산하기', array(
			array( 'wage', '시급', 'money', '원', number_format( $r['min_wage'] ) ),
			array( 'hours', '1주 소정근로시간', 'number', '시간 (최대 40)', '40' ),
		) ),
		'leave'        => array( '연차 계산하기', array(
			array( 'start', '입사일', 'date', '', '' ),
			array( 'base', '기준일', 'date', '비우면 오늘', '' ),
		) ),
		'notice'       => array( '해고예고수당 계산하기', array(
			array( 'wage', '통상 시급', 'money', '원', number_format( $r['min_wage'] ) ),
			array( 'hours', '하루 소정근로시간', 'number', '시간', '8' ),
		) ),
		'insurance'    => array( '4대보험료 계산하기', array(
			array( 'pay', '월 급여', 'money', '세전 · 식대 등 비과세 금액 제외', '', true ),
		) ),
		'saving'       => array( '이자 계산하기', array(
			array( 'amount', '월 납입액', 'money', '원', '' ),
			array( 'months', '기간', 'number', '개월', '12' ),
			array( 'rate', '연 이자율', 'number', '%', '' ),
			array( 'tax', '과세 방식', 'select', '', array( '15.4' => '일반과세 (15.4%)', '9.5' => '세금우대 (9.5%)', '0' => '비과세' ) ),
		) ),
		'pension'      => array( '확인하기', array(
			array( 'type', '가구 형태', 'select', '', array( 'single' => '혼자 사는 어르신(단독가구)', 'couple' => '부부가구' ) ),
			array( 'income', '월 소득인정액', 'money', '부부는 두 사람 합계', '' ),
		) ),
		'age'          => array( '만 나이 계산하기', array(
			array( 'birth', '생년월일', 'date', '', '' ),
			array( 'base', '기준일', 'date', '비우면 오늘', '' ),
		) ),
		'eitc'         => array( '장려금 계산하기', array(
			array( 'type', '가구 유형', 'select', '배우자 총급여가 연 300만 원 이상이면 맞벌이', array( 'single' => '단독가구 (혼자 사는 경우)', 'one' => '홑벌이가구 (외벌이·자녀나 부모 부양)', 'two' => '맞벌이가구' ), true ),
			array( 'income', '부부 합산 연간 총급여', 'money', $e['income_year'] . '년 세전 근로소득', '' ),
			array( 'kids', '18세 미만 부양자녀', 'number', '명', '0' ),
			array( 'asset', '가구원 재산 합계', 'select', '', array( 'low' => '1억 7천만 원 미만', 'mid' => '1억 7천만 원 ~ 2억 4천만 원 미만', 'high' => '2억 4천만 원 이상' ), true ),
		) ),
		'parental'     => array( '육아휴직급여 계산하기', array(
			array( 'wage', '월 통상임금', 'money', '세전 · 기본급과 매달 고정으로 받는 수당', '', true ),
			array( 'months', '휴직 기간', 'number', '개월 (최대 18)', '12' ),
			array( 'mode', '사용 방식', 'select', '', array( 'normal' => '일반 육아휴직', 'six' => '부모가 함께 사용 (6+6, 생후 18개월 이내 자녀)' ) ),
		) ),
		'minwage'      => array( '최저 월급 확인하기', array(
			array( 'year', '기준 연도', 'select', '', $years ),
			array( 'hours', '1주 소정근로시간', 'number', '시간 (최대 40)', '40' ),
			array( 'probation', '수습 여부', 'select', '', array( 'no' => '수습 아님', 'yes' => '수습 3개월 이내 (1년 이상 계약)' ) ),
			array( 'pay', '내 월급', 'money', '선택 · 세전, 고정 수당 포함', '' ),
		) ),
		'leavepay'     => array( '연차수당 계산하기', array(
			array( 'wage', '월 통상임금', 'money', '세전 · 기본급과 매달 고정으로 받는 수당', '', true ),
			array( 'mhours', '월 소정근로시간', 'number', '시간 (주 40시간이면 209)', '209' ),
			array( 'dhours', '하루 소정근로시간', 'number', '시간', '8' ),
			array( 'days', '못 쓴 연차', 'number', '일', '5' ),
		) ),
		'maternity'    => array( '출산휴가급여 계산하기', array(
			array( 'wage', '월 통상임금', 'money', '세전 · 기본급과 매달 고정으로 받는 수당', '', true ),
			array( 'size', '회사 규모', 'select', '', array( 'small' => '우선지원대상기업 (중소기업 등)', 'large' => '대규모기업' ) ),
			array( 'multi', '태아 수', 'select', '', array( 'one' => '한 명 (휴가 90일)', 'multi' => '쌍둥이 이상 (휴가 120일)' ) ),
		) ),
		'date'         => array( '계산하기', array(
			array( 'mode', '계산 종류', 'select', '', array( 'span' => '기간·근무일 (며칠 동안)', 'dday' => 'D-day (며칠 남았나)', 'add' => '날짜 더하기 (며칠 뒤)' ), true ),
			array( 'a', '시작일·기준일', 'date', '비우면 오늘', '' ),
			array( 'b', '끝 날·목표일', 'date', '', '' ),
			array( 'n', '더할 기간', 'number', '일 또는 개월', '90' ),
			array( 'unit', '단위', 'select', '', array( 'd' => '일', 'm' => '개월' ) ),
			array( 'inc', '시작일 포함', 'select', '', array( '1' => '포함 (시작일이 1일째)', '0' => '미포함 (다음 날부터 셈)' ) ),
		) ),
	);
}

add_shortcode( 'eb_calc', function ( $atts ) {
	$atts = shortcode_atts( array( 'type' => 'median' ), $atts );
	$defs = eb_calc_defs();
	if ( ! isset( $defs[ $atts['type'] ] ) ) {
		return '';
	}
	$GLOBALS['eb_calc_used'] = true;
	$GLOBALS['eb_calc_types'][ $atts['type'] ] = true;

	list( $button, $fields ) = $defs[ $atts['type'] ];
	$html = '';
	foreach ( $fields as $f ) {
		list( $name, $label, $type, $hint, $value ) = $f;
		$wide  = ! empty( $f[5] ) ? ' is-wide' : '';
		$hint  = '' === $hint ? '' : ' <small>' . esc_html( $hint ) . '</small>';
		$input = '';
		if ( 'select' === $type ) {
			foreach ( $value as $key => $text ) {
				$input .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $key ), esc_html( $text ) );
			}
			$input = '<select name="' . esc_attr( $name ) . '">' . $input . '</select>';
		} elseif ( 'date' === $type ) {
			$input = '<input type="date" name="' . esc_attr( $name ) . '">';
		} else {
			// 빈 칸 예시(2026-10-18): '0' 대신 '예: 3,000,000'처럼 실제로 넣을 만한 값 - eb_calc_ph()
			$ph    = '' === (string) $value ? eb_calc_ph( $atts['type'], $name ) : '';
			$input = sprintf(
				'<input type="text" inputmode="%1$s" name="%2$s" value="%3$s"%4$s autocomplete="off">',
				'number' === $type ? 'decimal' : 'numeric',
				esc_attr( $name ),
				esc_attr( $value ),
				( 'money' === $type ? ' data-money' : '' ) . ( '' !== $ph ? ' placeholder="' . esc_attr( '예: ' . $ph ) . '"' : '' )
			);
		}
		$html .= sprintf( '<label class="eb-calc__field%1$s"><span>%2$s%3$s</span>%4$s</label>', $wide, esc_html( $label ), $hint, $input );
	}

	$data = array( 'rates' => eb_rates() );
	if ( 'median' === $atts['type'] ) {
		$data['median'] = eb_median_income()['median'];
		$data['steps']  = eb_median_rates();
	}
	if ( 'eitc' === $atts['type'] ) {
		$data['eitc'] = eb_eitc();
	}
	if ( 'parental' === $atts['type'] ) {
		$data['pl'] = eb_parental();
	}
	if ( 'minwage' === $atts['type'] ) {
		$data['mw'] = eb_min_wages();
	}
	if ( 'date' === $atts['type'] ) {
		$data['hol'] = eb_holidays();
	}
	$calc_html = sprintf(
		'<div class="eb-calc" data-calc="%1$s" data-set="%2$s"><form class="eb-calc__form">%3$s<button type="submit" class="eb-calc__btn">%4$s</button></form><div class="eb-calc__result" aria-live="polite"></div></div>',
		esc_attr( $atts['type'] ),
		esc_attr( wp_json_encode( $data ) ),
		$html,
		esc_html( $button )
	);
	// 계산기 페이지(복지 계산기 14866의 하위)에서만: 위 같은 분야 탭 + 아래 계산 예시·관련 글 (style.css 39번)
	if ( is_page() && 14866 === wp_get_post_parent_id( get_the_ID() ) ) {
		$calc_html = eb_calc_tabs( $atts['type'] ) . $calc_html
			. '<section class="eb-calc-example" data-example="' . esc_attr( $atts['type'] ) . '" hidden><h2>숫자로 보는 계산 예시</h2><div class="eb-calc-example__body"></div></section>'
			. eb_ad_slot( 'list-mid', 'eb-ad-row eb-ad-calc' ) // 계산 예시 다음, 관련 글 앞 광고 한 칸(26번 배치 재사용, 버튼과 떨어진 자리)
			. eb_calc_related( $atts['type'] );
	}
	return $calc_html;
} );

// 계산기 위 탭: 상황별 묶음(같은 묶음 안에서는 어느 계산기를 열어도 탭 순서가 그대로)
function eb_calc_tabs( $type ) {
	$short  = array(
		'median'       => '중위소득',
		'severance'    => '퇴직금',
		'unemployment' => '실업급여',
		'notice'       => '해고예고수당',
		'weekly'       => '주휴수당',
		'leave'        => '연차',
		'insurance'    => '4대보험',
		'saving'       => '적금 이자',
		'pension'      => '기초연금',
		'age'          => '만 나이',
		'eitc'         => '근로·자녀장려금',
		'parental'     => '육아휴직',
		'minwage'      => '최저임금',
		'leavepay'     => '연차수당',
		'maternity'    => '출산휴가',
		'date'         => '날짜',
	);
	$groups = array(
		'일할 때'    => array( 'minwage', 'weekly', 'insurance', 'leave', 'leavepay' ),
		'그만둘 때'  => array( 'severance', 'unemployment', 'notice' ),
		'출산·육아'  => array( 'maternity', 'parental' ),
		'복지·생활'  => array( 'median', 'pension', 'eitc', 'age', 'saving', 'date' ),
	);
	// 한 계산기는 한 묶음에만(겹치면 탭을 누를 때마다 탭 줄이 바뀜)
	$label = '';
	foreach ( $groups as $name => $keys ) {
		if ( in_array( $type, $keys, true ) ) {
			$label = $name;
			break;
		}
	}
	if ( '' === $label ) {
		return '';
	}
	$catalog = eb_calc_catalog();
	$html    = '<nav class="eb-calc-tabs" aria-label="' . esc_attr( $label ) . ' 쓰는 계산기"><span class="eb-calc-tabs__label">' . esc_html( $label ) . '</span>';
	foreach ( $groups[ $label ] as $key ) {
		if ( $key === $type ) {
			$html .= '<span class="eb-calc-tabs__item" aria-current="page">' . esc_html( $short[ $key ] ) . '</span>';
		} elseif ( isset( $catalog[ $key ] ) ) {
			$html .= '<a class="eb-calc-tabs__item" href="' . esc_url( home_url( $catalog[ $key ][0] ) ) . '">' . esc_html( $short[ $key ] ) . '</a>';
		}
	}
	return $html . '<a class="eb-calc-tabs__all" href="' . esc_url( home_url( '/calculator/' ) ) . '">전체 계산기 <span aria-hidden="true">›</span></a></nav>';
}

// 계산기 아래 관련 글: 계산기 목록의 검색어가 제목에 들어간 글(최근 수정 순 4개, 12시간 저장)
function eb_calc_related( $type ) {
	$catalog = eb_calc_catalog();
	if ( empty( $catalog[ $type ][3] ) ) {
		return '';
	}
	$ids = get_transient( 'eb_calc_rel_' . $type );
	if ( false === $ids ) {
		$ids = array();
		foreach ( get_posts( array( 'numberposts' => 200, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) ) as $id ) {
			if ( preg_match( '/' . $catalog[ $type ][3] . '/u', get_the_title( $id ) ) ) {
				$ids[] = $id;
			}
			if ( count( $ids ) >= 4 ) {
				break;
			}
		}
		set_transient( 'eb_calc_rel_' . $type, $ids, 12 * HOUR_IN_SECONDS );
	}
	if ( ! $ids ) {
		return '';
	}
	$html = '<section class="eb-calc-related"><h2>이 계산기와 관련된 글</h2><ul>';
	foreach ( $ids as $id ) {
		$html .= '<li><a href="' . esc_url( get_permalink( $id ) ) . '">' . esc_html( get_the_title( $id ) ) . '</a></li>';
	}
	return $html . '</ul></section>';
}

// 계산기 스크립트: 계산기가 있는 페이지에만 출력. nowprocket = WP Rocket 지연 로딩 제외
add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_calc_used'] ) ) {
		return;
	}
	$script = <<<'JS'
(function () {
	var DAY = 86400000;
	function num(v) {
		var s = String(v == null ? '' : v).trim();
		if (!s) { return 0; }
		if (s.indexOf(',') !== -1 && !/^[+\-]?\d{1,3}(?:,\d{3})+(?:\.\d+)?$/.test(s)) { return NaN; }
		s = s.replace(/,/g, '');
		return /^[+\-]?(?:\d+(?:\.\d*)?|\.\d+)$/.test(s) && isFinite(Number(s)) ? Number(s) : NaN;
	}
	function won(n) { return Math.floor(n).toLocaleString('ko-KR') + '원'; }
	function day(v) { if (!v) { return null; } var p = v.split('-'); return Date.UTC(+p[0], +p[1] - 1, +p[2]); }
	function today() { var d = new Date(); return Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()); }
	function floor10(n) { return Math.floor((n + 1e-7) / 10) * 10; }
	function rows(list) {
		return '<table class="eb-calc__table"><tbody>' + list.map(function (r) {
			return '<tr><td>' + r[0] + '</td><td>' + r[1] + '</td></tr>';
		}).join('') + '</tbody></table>';
	}
	function lead(label, value, sub) { return '<p class="eb-calc__lead">' + label + ' <strong>' + value + '</strong>' + (sub ? ' <small>' + sub + '</small>' : '') + '</p>'; }
	function hint(t) { return '<p class="eb-calc__hint">' + t + '</p>'; }
	function warn(t) { return '<p class="eb-calc__warn">' + t + '</p>'; }
	function note(t) { return '<p class="eb-calc__note">' + t + '</p>'; }
	function n2(v) { return (Math.round(v * 100) / 100).toLocaleString('ko-KR'); }
	// 계산 과정 보기(접힘). 인쇄할 때는 펼쳐서 함께 나옴
	function how(list) {
		return '<details class="eb-calc__how"><summary>계산 과정 보기</summary><ol>' + list.map(function (x) { return '<li>' + x + '</li>'; }).join('') + '</ol></details>';
	}
	// 퇴직일(마지막 근무일 다음 날) 이전 3개월의 날짜 수
	function threeMonthDays(l) {
		var quit = new Date(l + DAY), y = quit.getUTCFullYear(), mo = quit.getUTCMonth() - 3;
		var last = new Date(Date.UTC(y, mo + 1, 0)).getUTCDate();
		return Math.round((l + DAY - Date.UTC(y, mo, Math.min(quit.getUTCDate(), last))) / DAY);
	}
	function fullMonths(s, e) {
		var a = new Date(s), b = new Date(e);
		var m = (b.getUTCFullYear() - a.getUTCFullYear()) * 12 + b.getUTCMonth() - a.getUTCMonth();
		if (b.getUTCDate() < a.getUTCDate()) { m--; }
		return Math.max(0, m);
	}

	var calc = {
		median: function (f, d) {
			var n = f.n.value, m = d.median[n];
			var inc = f.income.value.trim() === '' ? null : num(f.income.value);
			var steps = d.steps.concat([['기준 중위소득 100%', 100], ['기준 중위소득 150%', 150]]);
			var h = lead(n + '인 가구 기준 중위소득', won(m))
				+ '<table class="eb-calc__table"><thead><tr><th>구분</th><th>월 기준 금액</th>' + (inc !== null ? '<th>내 소득인정액</th>' : '') + '</tr></thead><tbody>';
			steps.forEach(function (r) {
				var t = Math.round(m * r[1] / 100);
				h += '<tr><td>' + r[0] + (r[1] < 100 ? ' <small>중위 ' + r[1] + '%</small>' : '') + '</td><td>' + won(t) + '</td>'
					+ (inc !== null ? '<td>' + (inc <= t ? '<span class="eb-calc__ok">기준 이하</span>' : '<span class="eb-calc__no">기준 초과</span>') + '</td>' : '') + '</tr>';
			});
			h += '</tbody></table>';
			if (inc !== null) {
				h += note('입력한 소득인정액은 기준 중위소득의 약 <strong>' + (Math.round(inc / m * 1000) / 10) + '%</strong>입니다. 소득 기준만 비교한 결과이며, 실제 선정은 재산·부양의무자 기준 등을 함께 봅니다.');
			}
			return h;
		},
		severance: function (f) {
			var s = day(f.start.value), l = day(f.last.value), wage = num(f.wage.value);
			if (s === null || l === null || !wage) { return hint('입사일, 마지막 근무일, 3개월 임금 총액을 입력하면 예상 퇴직금이 나옵니다.'); }
			if (l < s) { return warn('마지막 근무일이 입사일보다 빠릅니다. 날짜를 확인해 주세요.'); }
			var work = Math.round((l - s) / DAY) + 1, days = threeMonthDays(l);
			var bonus = num(f.bonus.value), leaveP = num(f.leave.value), sum = wage + bonus * 3 / 12 + leaveP * 3 / 12;
			var avg = sum / days, pay = avg * 30 * work / 365;
			var h = rows([['재직 일수', work.toLocaleString('ko-KR') + '일'], ['평균임금 산정 기간', days + '일'], ['1일 평균임금', won(avg)]]);
			if (work < 365) { return warn('재직 기간이 ' + work + '일로 1년 미만이라 법정 퇴직금 대상이 아닙니다.') + h; }
			return lead('예상 퇴직금', won(pay), '세전') + h + how([
				'재직 일수 = 마지막 근무일 − 입사일 + 1 = <b>' + work.toLocaleString('ko-KR') + '일</b>',
				'평균임금 계산 금액 = 3개월 임금 ' + won(wage) + (bonus ? ' + 상여금 ' + won(bonus) + ' × 3/12' : '') + (leaveP ? ' + 연차수당 ' + won(leaveP) + ' × 3/12' : '') + ' = <b>' + won(sum) + '</b>',
				'1일 평균임금 = ' + won(sum) + ' ÷ ' + days + '일(퇴직 전 3개월) = <b>' + won(avg) + '</b>',
				'퇴직금 = ' + won(avg) + ' × 30일 × (' + work.toLocaleString('ko-KR') + '일 ÷ 365일) = <b>' + won(pay) + '</b>'
			]);
		},
		unemployment: function (f, d) {
			var l = day(f.last.value), wage = num(f.wage.value), hours = Math.min(8, num(f.hours.value) || 8);
			if (l === null || !wage) { return hint('마지막 근무일과 3개월 임금 총액을 입력하면 예상 실업급여가 나옵니다.'); }
			var days = threeMonthDays(l), avg = wage / days, r = d.rates;
			var raw = avg * 0.6, daily = raw, low = Math.floor(r.min_wage * 0.8 * hours), capped = '';
			if (daily > r.unemp_max) { daily = r.unemp_max; capped = '상한액 적용'; }
			if (daily < low) { daily = low; capped = '하한액 적용'; }
			daily = Math.floor(daily);
			var table = { u50: [120, 150, 180, 210, 240], o50: [120, 180, 210, 240, 270] };
			var period = table[f.age.value][+f.period.value];
			return lead('예상 실업급여 총액', won(daily * period), '세금 없음')
				+ rows([['1일 평균임금', won(avg)], ['1일 구직급여', won(daily) + (capped ? ' <small>' + capped + '</small>' : '')], ['받을 수 있는 기간', period + '일'], ['한 달(30일) 기준', won(daily * 30)]])
				+ note('1일 구직급여는 평균임금의 60%이며, ' + r.year + '년 상한은 ' + won(r.unemp_max) + ', 하한은 최저임금의 80% × 하루 소정근로시간(' + won(low) + ')입니다.')
				+ how([
					'1일 평균임금 = 3개월 임금 ' + won(wage) + ' ÷ ' + days + '일 = <b>' + won(avg) + '</b>',
					'1일 구직급여 = ' + won(avg) + ' × 60% = ' + won(raw) + (capped ? ' → ' + capped + ' <b>' + won(daily) + '</b>' : ' → <b>' + won(daily) + '</b>'),
					'받는 기간 = ' + f.age.options[f.age.selectedIndex].text + ', 가입 ' + f.period.options[f.period.selectedIndex].text + ' → <b>' + period + '일</b>',
					'총액 = ' + won(daily) + ' × ' + period + '일 = <b>' + won(daily * period) + '</b>'
				]);
		},
		weekly: function (f, d) {
			var wage = num(f.wage.value), hours = Math.min(40, num(f.hours.value)), r = d.rates;
			if (!wage || !hours) { return hint('시급과 1주 소정근로시간을 입력해 주세요.'); }
			var juhu = hours >= 15 ? hours / 40 * 8 : 0;
			var monthHours = Math.round((hours + juhu) * 365 / 7 / 12);
			var h = lead('예상 월급', won(wage * monthHours), '세전')
				+ rows([['주휴시간', (Math.round(juhu * 10) / 10) + '시간' + (hours < 15 ? ' <small>주 15시간 미만은 주휴수당 없음</small>' : '')], ['주휴수당(1주)', won(wage * juhu)], ['1주 급여', won(wage * (hours + juhu))], ['월 환산 시간', monthHours + '시간']]);
			if (wage < r.min_wage) { h += warn(r.year + '년 최저임금(' + won(r.min_wage) + ')보다 시급이 낮습니다.'); }
			return h + how([
				'주휴시간 = ' + (hours >= 15 ? '1주 ' + hours + '시간 ÷ 40시간 × 8시간 = <b>' + n2(juhu) + '시간</b>' : '주 15시간 미만이라 <b>0시간</b>'),
				'월 환산 시간 = (' + hours + '시간 + 주휴 ' + n2(juhu) + '시간) × 365일 ÷ 7일 ÷ 12개월 ≈ <b>' + monthHours + '시간</b>',
				'월급 = 시급 ' + won(wage) + ' × ' + monthHours + '시간 = <b>' + won(wage * monthHours) + '</b>'
			]);
		},
		leave: function (f) {
			var s = day(f.start.value), b = f.base.value ? day(f.base.value) : today();
			if (s === null) { return hint('입사일을 입력해 주세요.'); }
			if (b < s) { return warn('기준일이 입사일보다 빠릅니다.'); }
			var months = fullMonths(s, b), years = Math.floor(months / 12), leave, detail;
			if (years < 1) {
				leave = Math.min(11, months);
				detail = '입사 1년 미만: 1개월 개근할 때마다 1일(최대 11일)';
			} else {
				leave = Math.min(25, 15 + Math.floor((years - 1) / 2));
				detail = '1년 이상: 기본 15일 + 3년차부터 2년마다 1일 추가(최대 25일)';
			}
			return lead('현재 연차', leave + '일')
				+ rows([['근속 기간', (years ? years + '년 ' : '') + (months % 12) + '개월'], ['계산 기준', detail]])
				+ note('1년 이상 근무자는 직전 1년 출근율이 80% 이상이어야 15일이 생깁니다. 상시 근로자 5인 미만 사업장은 연차 규정이 적용되지 않습니다.');
		},
		notice: function (f) {
			var wage = num(f.wage.value), hours = num(f.hours.value) || 8;
			if (!wage) { return hint('통상 시급을 입력해 주세요.'); }
			return lead('해고예고수당', won(wage * hours * 30), '30일분 통상임금')
				+ rows([['1일 통상임금', won(wage * hours)], ['지급 일수', '30일']])
				+ how([
					'1일 통상임금 = 통상 시급 ' + won(wage) + ' × ' + hours + '시간 = <b>' + won(wage * hours) + '</b>',
					'해고예고수당 = ' + won(wage * hours) + ' × 30일 = <b>' + won(wage * hours * 30) + '</b>'
				]);
		},
		insurance: function (f, d) {
			var pay = num(f.pay.value), r = d.rates;
			if (!pay) { return hint('월 급여를 입력하면 근로자가 내는 4대보험료가 나옵니다.'); }
			var base = Math.min(r.pension_cap, Math.max(r.pension_floor, Math.floor(pay / 1000) * 1000));
			var pension = floor10(base * r.pension_rate / 100);
			var health = floor10(pay * r.health_rate / 100);
			var care = floor10(health * r.care_total / r.health_total);
			var employ = floor10(pay * r.employ_rate / 100);
			var total = pension + health + care + employ;
			return lead('근로자 부담 합계', won(total), '월')
				+ rows([['국민연금 <small>' + r.pension_rate + '%</small>', won(pension)], ['건강보험 <small>' + r.health_rate + '%</small>', won(health)], ['장기요양보험 <small>건강보험료의 ' + (Math.round(r.care_total / r.health_total * 10000) / 100) + '%</small>', won(care)], ['고용보험 <small>' + r.employ_rate + '%</small>', won(employ)], ['4대보험 뺀 금액', won(pay - total)]])
				+ note('소득세·지방소득세는 빠져 있지 않습니다. 국민연금은 기준소득월액 상한(' + won(r.pension_cap) + ')·하한(' + won(r.pension_floor) + ')을 적용했습니다. 기준소득월액은 1,000원 미만을 버립니다. 적용 기간: ' + r.pension_period + '.')
				+ how([
					'국민연금 = 기준소득월액 ' + won(base) + (base !== pay ? ' <small>(상·하한 적용)</small>' : '') + ' × ' + r.pension_rate + '% = <b>' + won(pension) + '</b>',
					'건강보험 = 월 급여 ' + won(pay) + ' × ' + r.health_rate + '% = <b>' + won(health) + '</b>',
					'장기요양보험 = 건강보험료 ' + won(health) + ' × ' + (Math.round(r.care_total / r.health_total * 10000) / 100) + '% = <b>' + won(care) + '</b>',
					'고용보험 = 월 급여 ' + won(pay) + ' × ' + r.employ_rate + '% = <b>' + won(employ) + '</b>',
					'보험료마다 10원 미만은 버립니다. 합계 <b>' + won(total) + '</b>'
				]);
		},
		saving: function (f) {
			var m = num(f.amount.value), n = Math.round(num(f.months.value)), rate = num(f.rate.value), tax = num(f.tax.value);
			if (!m || !n || f.rate.value.trim() === '') { return hint('월 납입액, 기간, 연 이자율을 입력해 주세요.'); }
			var interest = Math.floor(m * n * (n + 1) / 2 * rate / 100 / 12), t = floor10(interest * tax / 100);
			return lead('만기 수령액', won(m * n + interest - t), '세후')
				+ rows([['납입 원금', won(m * n)], ['세전 이자', won(interest)], ['이자 과세', won(t)], ['세후 이자', won(interest - t)]])
				+ note('매달 같은 날 넣는 정기적금(단리) 기준입니다. 은행마다 이자 계산 방식이 조금씩 다를 수 있습니다.')
				+ how([
					'납입 원금 = ' + won(m) + ' × ' + n + '개월 = <b>' + won(m * n) + '</b>',
					'세전 이자 = ' + won(m) + ' × (' + n + ' × ' + (n + 1) + ' ÷ 2) × ' + rate + '% ÷ 12 = <b>' + won(interest) + '</b> <small>첫 달 넣은 돈은 ' + n + '개월, 마지막 달은 1개월 이자</small>',
					'이자 과세 = ' + won(interest) + ' × ' + tax + '% = <b>' + won(t) + '</b> <small>10원 미만 버림</small>',
					'만기 수령액 = 원금 + 이자 − 세금 = <b>' + won(m * n + interest - t) + '</b>'
				]);
		},
		pension: function (f, d) {
			var r = d.rates, couple = f.type.value === 'couple', limit = couple ? r.bp_couple : r.bp_single;
			var inc = f.income.value.trim() === '' ? null : num(f.income.value);
			var max = couple ? Math.floor(r.bp_amount * 0.8) * 2 : r.bp_amount;
			var h = rows([['선정기준액 <small>월 소득인정액</small>', won(limit) + ' 이하'], ['최대 지급액 <small>월</small>', won(max) + (couple ? ' <small>부부 각각 20% 감액</small>' : '')]]);
			if (inc === null) { return hint('월 소득인정액을 넣으면 선정기준액 이하인지 알려 드립니다.') + h; }
			return (inc <= limit ? lead('선정기준액', '이하', '받을 가능성이 있습니다') : lead('선정기준액', '초과', '소득 기준을 넘습니다')) + h
				+ note('만 65세 이상이어야 하며, 국민연금을 받는 금액 등에 따라 실제 금액은 줄어들 수 있습니다.');
		},
		age: function (f) {
			var b = day(f.birth.value), t = f.base.value ? day(f.base.value) : today();
			if (b === null) { return hint('생년월일을 입력하면 만 나이와 주요 나이 기준을 알려 드립니다.'); }
			if (t < b) { return warn('기준일이 생년월일보다 빠릅니다. 날짜를 확인해 주세요.'); }
			var B = new Date(b), T = new Date(t), by = B.getUTCFullYear();
			// 나이가 바뀌는 날(2월 29일생은 평년에 3월 1일 - 민법 기간 계산)
			function bday(y) { return Date.UTC(y, B.getUTCMonth(), B.getUTCDate()); }
			function ymd(v) { var d = new Date(v); return d.getUTCFullYear() + '.' + (d.getUTCMonth() + 1) + '.' + d.getUTCDate(); }
			var ty = T.getUTCFullYear(), age = ty - by - (t < bday(ty) ? 1 : 0);
			var next = bday(ty) > t ? bday(ty) : bday(ty + 1), dd = Math.round((next - t) / DAY);
			var isBirthday = bday(ty) === t && ty > by;
			function mark(n, what) {
				var at = bday(by + n);
				return [what + ' <small>만 ' + n + '세</small>', ymd(at) + (at <= t ? ' <small>지남</small>' : ' <small>' + Math.ceil((at - t) / DAY).toLocaleString('ko-KR') + '일 남음</small>')];
			}
			var youth = age >= 19 && age <= 34;
			return lead('만 나이', age + '세', isBirthday ? '오늘 생일입니다' : '')
				+ rows([['연 나이 <small>올해 − 출생 연도</small>', (ty - by) + '세'], ['다음 생일', ymd(next) + ' <small>D-' + dd + '</small>'], ['청년 정책 <small>대부분 만 19~34세</small>', youth ? '<span class="eb-calc__ok">해당</span> <small>' + ymd(bday(by + 35) - DAY) + '까지</small>' : '<span class="eb-calc__no">해당 안 됨</span>'], mark(65, '기초연금·어르신 복지'), mark(75, '고령운전자 교통안전교육')])
				+ note('2023년 6월 28일부터 법령·행정·계약의 나이는 만 나이가 원칙입니다. 청년 기준은 제도마다 달라(만 19~39세 등) 공고를 꼭 확인하세요. 기초연금은 만 65세 생일이 속한 달의 1개월 전부터 신청할 수 있습니다.');
		},
		eitc: function (f, d) {
			var e = d.eitc, type = f.type.value, inc = num(f.income.value), kids = Math.max(0, Math.round(num(f.kids.value)));
			if (!inc) { return hint('가구 유형과 ' + e.income_year + '년 연간 총급여를 입력하면 예상 근로·자녀장려금이 나옵니다.'); }
			if (f.asset.value === 'high') { return warn('가구원 재산 합계가 2억 4천만 원 이상이면 근로·자녀장려금을 받을 수 없습니다.'); }
			if (type === 'single' && kids > 0) { return warn('18세 미만 부양자녀가 있으면 단독가구가 아닙니다. 홑벌이가구 또는 맞벌이가구를 골라 주세요.'); }
			var t = e.eitc[type], w = 0;
			if (inc < t[0]) { w = inc * t[3] / t[0]; } else if (inc < t[1]) { w = t[3]; } else if (inc < t[2]) { w = t[3] - (inc - t[1]) * t[3] / (t[2] - t[1]); }
			var c = e.ctc, per = 0;
			if (kids && type !== 'single' && inc < c.limit) { per = inc < c[type] ? c.max : c.max - (inc - c[type]) * (c.max - c.min) / (c.limit - c[type]); }
			var half = f.asset.value === 'mid', k = half ? 0.5 : 1;
			w = Math.floor(w * k); var child = Math.floor(per * kids * k);
			var h = lead('예상 장려금 합계', won(w + child), '1년 1회 지급')
				+ rows([['근로장려금 <small>최대 ' + won(t[3]) + '</small>', inc >= t[2] ? '<span class="eb-calc__no">소득 기준 초과</span> <small>' + won(t[2]) + ' 미만</small>' : won(w)], ['자녀장려금 <small>' + kids + '명</small>', !kids ? '해당 없음' : (inc >= c.limit ? '<span class="eb-calc__no">소득 기준 초과</span>' : won(child) + ' <small>1인당 ' + won(per * k) + '</small>')], ['재산 감액', half ? '50% 감액 적용 <small>1억 7천만 원 이상</small>' : '없음']]);
			var band = inc < t[0] ? '점증 구간(' + won(t[0]) + ' 미만): ' + won(t[3]) + ' × ' + won(inc) + ' ÷ ' + won(t[0])
				: inc < t[1] ? '평탄 구간(' + won(t[0]) + ' ~ ' + won(t[1]) + '): 최대액 ' + won(t[3])
				: inc < t[2] ? '점감 구간(' + won(t[1]) + ' ~ ' + won(t[2]) + '): ' + won(t[3]) + ' − (' + won(inc) + ' − ' + won(t[1]) + ') × ' + won(t[3]) + ' ÷ ' + won(t[2] - t[1])
				: '소득 기준(' + won(t[2]) + ') 이상이라 0원';
			return h + note(e.income_year + '년 소득분(' + e.year + '년 5월 정기신청, 8월 말 지급) 기준이며, 근로소득만 있는 경우로 계산했습니다. 사업소득이 있으면 업종별 조정률이 적용되어 달라집니다. 정확한 금액은 국세청 홈택스의 장려금 모의계산에서 확인하세요.')
				+ how([
					'근로장려금 ' + f.type.options[f.type.selectedIndex].text.split(' (')[0] + ' · ' + band + (half ? ' → 재산 50% 감액' : '') + ' = <b>' + won(w) + '</b>',
					!kids ? '자녀장려금: 18세 미만 부양자녀 없음' : (type === 'single' || inc >= c.limit ? '자녀장려금: 대상 아님' : '자녀장려금 = 1인당 ' + won(per) + (half ? ' × 50%' : '') + ' × ' + kids + '명 = <b>' + won(child) + '</b> <small>총급여 ' + won(c[type]) + '부터 ' + won(c.limit) + '까지 1인당 ' + won(c.max) + ' → ' + won(c.min) + '으로 줄어듦</small>'),
					'합계 = <b>' + won(w + child) + '</b>'
				]);
		},
		parental: function (f, d) {
			var p = d.pl, wage = num(f.wage.value), months = Math.round(num(f.months.value)), six = f.mode.value === 'six';
			if (!wage || !months) { return hint('월 통상임금과 휴직 기간을 입력하면 매달 받는 육아휴직급여가 나옵니다.'); }
			var h = '';
			if (months > 18) { months = 18; h += warn('육아휴직급여는 최대 18개월까지 계산합니다.'); }
			var list = [], total = 0;
			for (var m = 1; m <= months; m++) {
				var pay, rule;
				if (six && m <= 6) { pay = Math.min(wage, p.six[m - 1]); rule = '100% · 상한 ' + won(p.six[m - 1]); } else {
					var s = p.steps.filter(function (x) { return m <= x[0]; })[0];
					pay = Math.min(wage * s[1] / 100, s[2]); rule = s[1] + '% · 상한 ' + won(s[2]);
				}
				pay = Math.floor(Math.max(pay, p.floor));
				total += pay;
				var lastRow = list[list.length - 1];
				if (lastRow && lastRow.pay === pay && lastRow.rule === rule) { lastRow.to = m; } else { list.push({ from: m, to: m, pay: pay, rule: rule }); }
			}
			h = lead('육아휴직급여 총액', won(total), months + '개월 · 세금 없음') + h
				+ '<table class="eb-calc__table"><thead><tr><th>기간</th><th>월 지급액</th></tr></thead><tbody>' + list.map(function (r) {
					return '<tr><td>' + (r.from === r.to ? r.from + '개월째' : r.from + '~' + r.to + '개월째') + ' <small>' + r.rule + '</small></td><td>' + won(r.pay) + '</td></tr>';
				}).join('') + '</tbody></table>';
			if (months > 12) { h += note('1년을 넘는 육아휴직(최대 1년 6개월)은 부모가 각각 3개월 이상 육아휴직을 쓴 경우 등에만 가능합니다.'); }
			return h + note(p.year + '년 1월 1일 이후 시작한 육아휴직 기준입니다. 2025년부터 사후지급금 없이 매달 전액 지급되며, 월 하한액은 ' + won(p.floor) + '입니다. 한부모 근로자 등은 기준이 다를 수 있으니 고용24 모의계산으로 확인하세요.');
		},
		minwage: function (f, d) {
			var y = f.year.value, base = d.mw[y], hours = Math.min(40, num(f.hours.value)), prob = f.probation.value === 'yes';
			if (!hours) { return hint('1주 소정근로시간을 입력해 주세요.'); }
			var wage = prob ? Math.ceil(base * 0.9) : base, juhu = hours >= 15 ? hours / 40 * 8 : 0;
			var mh = Math.round((hours + juhu) * 365 / 7 / 12), month = wage * mh;
			var pay = f.pay.value.trim() === '' ? null : num(f.pay.value);
			var list = [['최저 시급' + (prob ? ' <small>수습 90%</small>' : ''), won(wage)], ['주휴시간 <small>1주</small>', n2(juhu) + '시간' + (hours < 15 ? ' <small>주 15시간 미만은 없음</small>' : '')], ['월 환산 시간', mh + '시간'], ['연봉 환산 <small>× 12개월</small>', won(month * 12)]];
			if (pay !== null) {
				list.push(['내 월급의 시급 환산', won(pay / mh) + ' ' + (pay >= month ? '<span class="eb-calc__ok">최저임금 이상</span>' : '<span class="eb-calc__no">최저임금 미달</span>')]);
			}
			var h = lead(y + '년 최저 월급', won(month), '주 ' + hours + '시간 · 주휴 포함') + rows(list);
			if (pay !== null && pay < month) { h += warn('입력한 월급이 ' + y + '년 최저 월급보다 ' + won(month - pay) + ' 적습니다. 매월 현금으로 지급하는 식대·교통비·상여금은 최저임금에 포함되므로 함께 비교하세요. 연장·야간·휴일근로수당과 현물 복리후생비 등 제외 항목을 확인하고, 미달이면 고용노동부(국번 없이 1350)에 상담할 수 있습니다.'); }
			var other = Object.keys(d.mw).filter(function (k) { return k !== y; })[0];
			return h + note((prob ? '수습 감액은 1년 이상 근로계약을 맺은 경우 수습 3개월까지만 가능하고, 단순노무 직종은 감액할 수 없습니다. ' : '') + (other ? other + '년 최저임금은 시급 ' + won(d.mw[other]) + '입니다.' : ''))
				+ how([
					'주휴시간 = ' + (hours >= 15 ? '1주 ' + hours + '시간 ÷ 40시간 × 8시간 = <b>' + n2(juhu) + '시간</b>' : '주 15시간 미만이라 <b>0시간</b>'),
					'월 환산 시간 = (' + hours + '시간 + 주휴 ' + n2(juhu) + '시간) × 365일 ÷ 7일 ÷ 12개월 ≈ <b>' + mh + '시간</b>',
					(prob ? '수습 시급 = ' + won(base) + ' × 90% = ' + won(wage) + ', ' : '') + '최저 월급 = 시급 ' + won(wage) + ' × ' + mh + '시간 = <b>' + won(month) + '</b>'
				].concat(pay !== null ? ['내 월급 시급 환산 = ' + won(pay) + ' ÷ ' + mh + '시간 = <b>' + won(pay / mh) + '</b>'] : []));
		},
		leavepay: function (f) {
			var wage = num(f.wage.value), mh = num(f.mhours.value) || 209, dh = num(f.dhours.value) || 8, days = num(f.days.value);
			if (!wage || !days) { return hint('월 통상임금과 못 쓴 연차 일수를 입력해 주세요.'); }
			var hourly = wage / mh, daily = Math.floor(hourly * dh), pay = daily * days;
			return lead('예상 연차수당', won(pay), '세전 · ' + n2(days) + '일분')
				+ rows([['통상 시급', won(hourly)], ['1일 통상임금', won(daily)], ['못 쓴 연차', n2(days) + '일']])
				+ note('연차가 생긴 날부터 1년 안에 쓰지 못한 연차를 돈으로 받는 금액입니다. 회사가 법에 맞게 연차 사용을 촉진했다면 수당이 없을 수 있고, 상시 근로자 5인 미만 사업장은 연차 규정이 적용되지 않습니다. 퇴사할 때 남은 연차도 같은 방식으로 정산합니다.')
				+ how([
					'통상 시급 = 월 통상임금 ' + won(wage) + ' ÷ ' + n2(mh) + '시간 = <b>' + won(hourly) + '</b>',
					'1일 통상임금 = ' + won(hourly) + ' × ' + n2(dh) + '시간 = <b>' + won(daily) + '</b>',
					'연차수당 = ' + won(daily) + ' × ' + n2(days) + '일 = <b>' + won(pay) + '</b>'
				]);
		},
		maternity: function (f, d) {
			var r = d.rates, wage = num(f.wage.value), small = f.size.value === 'small', multi = f.multi.value === 'multi';
			if (!wage) { return hint('월 통상임금을 입력하면 출산휴가 기간에 받는 돈을 계산합니다.'); }
			var total = multi ? 120 : 90, paid = multi ? 75 : 60, floor = r.min_wage * 209;
			var base = Math.max(wage, floor), gm = Math.min(base, r.mat_cap), govDays = small ? total : total - paid;
			var gov = Math.floor(gm / 30 * govDays);
			var co = small ? Math.floor(Math.max(0, wage - gm) / 30 * paid) : Math.floor(wage / 30 * paid);
			var h = lead('출산휴가 기간 받는 돈', won(gov + co), total + '일 합계')
				+ rows([['고용보험 출산휴가급여 <small>' + govDays + '일 · 세금 없음</small>', won(gov)], ['회사가 주는 임금 <small>' + (co ? paid + '일' : '없음') + '</small>', won(co)], ['고용보험 30일 상한', won(r.mat_cap)]]);
			if (wage < floor) { h += note('통상임금이 최저임금 월 환산액(' + won(floor) + ')보다 적어 고용보험 급여는 최저임금 기준으로 계산했습니다.'); }
			return h + note(small ? '우선지원대상기업은 ' + total + '일 모두 고용보험에서 상한까지 지급하고, 처음 ' + paid + '일은 통상임금과의 차액을 회사가 줍니다.' : '대규모기업은 처음 ' + paid + '일을 회사가 통상임금 100%로 주고, 나머지 ' + (total - paid) + '일을 고용보험에서 상한까지 지급합니다.')
				+ note(r.year + '년 1월 1일 이후 기준(30일 상한 ' + won(r.mat_cap) + ')입니다. 고용보험 가입 기간이 휴가 끝나는 날 전까지 180일 이상이어야 하며, 고용24에서 신청합니다.')
				+ how([
					'급여 기준 월액 = 통상임금 ' + won(wage) + (wage < floor ? ' → 최저임금 ' + won(floor) : '') + ', 상한 ' + won(r.mat_cap) + ' 적용 → <b>' + won(gm) + '</b>',
					'고용보험 = ' + won(gm) + ' ÷ 30일 × ' + govDays + '일 = <b>' + won(gov) + '</b>',
					small ? '회사 = (통상임금 − ' + won(gm) + ') ÷ 30일 × ' + paid + '일 = <b>' + won(co) + '</b>' : '회사 = 통상임금 ' + won(wage) + ' ÷ 30일 × ' + paid + '일 = <b>' + won(co) + '</b>',
					'합계 = <b>' + won(gov + co) + '</b>'
				]);
		},
		date: function (f, d) {
			var m = f.mode.value, hol = d.hol || {};
			function show(name, on) { var l = f[name].closest('label'); if (l) { l.hidden = !on; } }
			show('b', m !== 'add'); show('n', m === 'add'); show('unit', m === 'add'); show('inc', m === 'add');
			function w(t) { var x = new Date(t); return x.getUTCFullYear() + '.' + (x.getUTCMonth() + 1) + '.' + x.getUTCDate() + ' (' + '일월화수목금토'.charAt(x.getUTCDay()) + ')'; }
			function iso(t) { return new Date(t).toISOString().slice(0, 10); }
			function off(t) { var g = new Date(t).getUTCDay(); return hol[iso(t)] ? hol[iso(t)] : (g === 0 ? '일요일' : (g === 6 ? '토요일' : '')); }
			var A = f.a.value ? day(f.a.value) : today(), B = f.b.value ? day(f.b.value) : null;
			var outside = function (t) { var y = new Date(t).getUTCFullYear(); return y < 2026 || y > 2027; };
			var holNote = '공휴일은 2026·2027년 관공서 공휴일(대체공휴일·선거일 포함)을 반영했습니다. 5인 미만 사업장 등은 회사 휴일이 다를 수 있습니다.';
			if (m === 'add') {
				var n = Math.max(0, Math.round(num(f.n.value))), inc = f.inc.value === '1', R;
				if (!n) { return hint('더할 기간을 입력해 주세요.'); }
				if (n > (f.unit.value === 'm' ? 120 : 3650)) { return warn('10년 이내(120개월 또는 3,650일)로 입력해 주세요.'); }
				if (f.unit.value === 'm') {
					var x = new Date(A), dd = x.getUTCDate();
					x.setUTCDate(1); x.setUTCMonth(x.getUTCMonth() + n);
					x.setUTCDate(Math.min(dd, new Date(Date.UTC(x.getUTCFullYear(), x.getUTCMonth() + 1, 0)).getUTCDate()));
					R = x.getTime() - (inc ? DAY : 0);
				} else {
					R = A + (n - (inc ? 1 : 0)) * DAY;
				}
				var unit = f.unit.value === 'm' ? '개월' : '일', o = off(R);
				var h = lead(inc ? '끝나는 날' : n + unit + ' 뒤', w(R)) + rows([['시작일', w(A)], ['더한 기간', n + unit + (inc ? ' <small>시작일을 1일째로 셈</small>' : ' <small>다음 날부터 셈</small>')], ['그날', o ? '<span class="eb-calc__no">' + o + '</span>' : '평일']]);
				if (o) { h += note('법령에서 정한 기간은 마지막 날이 토요일이나 공휴일이면 그다음 날 끝나는 것이 원칙입니다(민법 제161조). 신청 마감이라면 담당 기관 공고도 확인하세요.'); }
				return h + how([
					inc ? '시작일 ' + w(A) + '을 1일째로 세면 ' + n + unit + '째' + (f.unit.value === 'm' ? ' 전날' : '') + ' = <b>' + w(R) + '</b>' : w(A) + ' 다음 날부터 ' + n + unit + ' = <b>' + w(R) + '</b>',
					'일 단위는 날짜에 그대로 더하고, 개월 단위는 같은 날짜(없으면 그달 마지막 날)로 계산합니다.'
				]);
			}
			if (B === null) { return hint(m === 'dday' ? '목표일(예: 신청 마감일)을 입력해 주세요.' : '끝 날을 입력해 주세요.'); }
			if (m === 'dday') {
				var dl = Math.round((B - A) / DAY), wd = 0;
				if (Math.abs(dl) > 3660) { return warn('10년 이내 날짜만 계산합니다.'); }
				for (var t = Math.min(A, B) + DAY; t <= Math.max(A, B); t += DAY) { if (!off(t)) { wd++; } }
				return lead(dl > 0 ? 'D-' + dl : (dl < 0 ? 'D+' + (-dl) : 'D-day'), dl === 0 ? '오늘' : Math.abs(dl).toLocaleString('ko-KR') + '일 ' + (dl > 0 ? '남음' : '지남'))
					+ rows([['기준일', w(A)], ['목표일', w(B) + (off(B) ? ' <small>' + off(B) + '</small>' : '')], ['그사이 근무일', wd + '일 <small>주말·공휴일 제외</small>']])
					+ note(holNote + (outside(A) || outside(B) ? ' 2026·2027년이 아닌 날짜는 주말만 뺐습니다.' : ''));
			}
			if (B < A) { return warn('끝 날이 시작일보다 빠릅니다. 날짜를 확인해 주세요.'); }
			var all = Math.round((B - A) / DAY) + 1;
			if (all > 3660) { return warn('10년 이내 기간만 계산합니다.'); }
			var we = 0, hl = 0, names = [];
			for (var u = A; u <= B; u += DAY) {
				var g = new Date(u).getUTCDay();
				if (g === 0 || g === 6) { we++; } else if (hol[iso(u)]) { hl++; if (names.length < 8) { names.push(iso(u).slice(5).replace('-', '.') + ' ' + hol[iso(u)]); } }
			}
			return lead('양 끝 포함', all.toLocaleString('ko-KR') + '일', '약 ' + Math.floor(all / 7) + '주 ' + (all % 7) + '일')
				+ rows([['근무일', (all - we - hl).toLocaleString('ko-KR') + '일'], ['토·일', we + '일'], ['평일 공휴일', hl + '일' + (names.length ? ' <small>' + names.join(', ') + (hl > names.length ? ' 외' : '') + '</small>' : '')], ['시작일 빼고 세면', (all - 1).toLocaleString('ko-KR') + '일 <small>민법 기간 계산(초일 불산입)</small>']])
				+ note(holNote + (outside(A) || outside(B) ? ' 2026·2027년이 아닌 날짜는 주말만 뺐습니다.' : ''))
				+ how([
					'전체 일수 = 끝 날 − 시작일 + 1 = <b>' + all.toLocaleString('ko-KR') + '일</b>',
					'근무일 = 전체 ' + all + '일 − 토·일 ' + we + '일 − 평일 공휴일 ' + hl + '일 = <b>' + (all - we - hl).toLocaleString('ko-KR') + '일</b>'
				]);
		}
	};

	// 결과 아래 도구: 인쇄·PDF 저장, 입력값이 담긴 결과 링크 복사
	var TOOLS = '<div class="eb-calc__tools"><button type="button" data-act="print">인쇄·PDF 저장</button><button type="button" data-act="link">결과 링크 복사</button></div>';
	function shareUrl(type, f) {
		var q = ['calc=' + encodeURIComponent(type)];
		[].forEach.call(f.elements, function (i) {
			if (i.name && i.value.trim() !== '') { q.push(encodeURIComponent(i.name) + '=' + encodeURIComponent(i.value.replace(/,/g, ''))); }
		});
		return location.origin + location.pathname + '#' + q.join('&');
	}
	function prefill(type, f) {
		var p = new URLSearchParams(location.hash && location.hash.indexOf('#calc=') === 0 ? location.hash.slice(1) : location.search);
		if (p.get('calc') !== type) { return false; }
		[].forEach.call(f.elements, function (i) {
			var v = p.get(i.name);
			if (!i.name || v === null || !/^[0-9A-Za-z.\-]{1,20}$/.test(v)) { return; }
			if (i.tagName === 'SELECT' && !i.querySelector('option[value="' + v + '"]')) { return; }
			var value = num(v); i.value = i.hasAttribute('data-money') && isFinite(value) && value >= 0 ? Math.floor(value).toLocaleString('ko-KR') : v;
		});
		return true;
	}
	// 화면 아래 잠깐 뜨는 알림(style.css 40번)
	function toast(msg) {
		var t = document.querySelector('.eb-toast');
		if (!t) { t = document.createElement('div'); t.className = 'eb-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
		t.textContent = msg;
		t.classList.add('is-on');
		clearTimeout(t._h);
		t._h = setTimeout(function () { t.classList.remove('is-on'); }, 2600);
	}
	// 복사: 클립보드 API가 막힌 앱 안 브라우저(카톡 등)는 예전 방식, 그래도 안 되면 주소 창
	function copyText(text, done) {
		function legacy() {
			var ta = document.createElement('textarea'), ok = false;
			ta.value = text; ta.setAttribute('readonly', ''); ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
			document.body.appendChild(ta); ta.select();
			try { ok = document.execCommand('copy'); } catch (e) {}
			document.body.removeChild(ta);
			if (ok) { done(); } else { window.prompt('아래 주소를 복사하세요', text); }
		}
		if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(text).then(done, legacy); } else { legacy(); }
	}
	function printResult(el) {
		var how = el.querySelector('.eb-calc__how'), wasOpen = how && how.open;
		if (how) { how.open = true; }
		el.setAttribute('data-print-date', new Date().toLocaleDateString('ko-KR'));
		el.setAttribute('data-print-title', document.title.split(' - ')[0]);
		document.body.classList.add('eb-printing');
		el.classList.add('eb-print-target');
		window.print();
		setTimeout(function () {
			document.body.classList.remove('eb-printing');
			el.classList.remove('eb-print-target');
			if (how) { how.open = wasOpen; }
		}, 500);
	}
	function init(el) {
		var type = el.getAttribute('data-calc'), data = JSON.parse(el.getAttribute('data-set'));
		var f = el.querySelector('form'), out = el.querySelector('.eb-calc__result');
		if (!calc[type]) { return; }
		function run() {
			var invalid = null;
			[].forEach.call(f.elements, function (i) {
				i.removeAttribute('aria-invalid');
				if (invalid || i.tagName !== 'INPUT' || i.type === 'date' || !i.value.trim()) { return; }
				var label = i.closest('label');
				if (label && label.hidden) { return; }
				var value = num(i.value), integer = ['months', 'kids', 'n'].indexOf(i.name) > -1;
				var maxHours = type === 'unemployment' ? 8 : (type === 'weekly' || type === 'minwage' ? 40 : null);
				var message = !isFinite(value) || value < 0 ? '0 이상의 숫자를 입력해 주세요. 음수나 문자가 섞인 값은 계산하지 않습니다.' :
					(integer && Math.floor(value) !== value ? '기간·일수·인원은 정수로 입력해 주세요.' :
					(i.name === 'hours' && maxHours && value > maxHours ? '근로시간은 ' + maxHours + '시간 이내로 입력해 주세요.' :
					(i.name === 'tax' && value > 100 ? '세율은 0~100%로 입력해 주세요.' : '')));
				if (message) { i.setAttribute('aria-invalid', 'true'); invalid = message; }
			});
			if (invalid) { out.innerHTML = '<div role="alert">' + warn(invalid) + '</div>'; return; }
			var h = calc[type](f, data);
			out.innerHTML = h + (h.indexOf('eb-calc__lead') > -1 ? TOOLS : '');
		}
		f.addEventListener('input', run);
		f.addEventListener('change', run);
		f.addEventListener('submit', function (e) { e.preventDefault(); run(); });
		f.querySelectorAll('[data-money]').forEach(function (i) {
			i.addEventListener('blur', function () { var value = num(i.value); if (i.value.trim() !== '' && isFinite(value) && value >= 0) { i.value = Math.floor(value).toLocaleString('ko-KR'); } });
			// 입력하는 동안 큰 금액을 한글로 함께(9000000 → = 900만 원, 2026-10-15)
			var kr = document.createElement('small');
			kr.className = 'eb-calc__kr';
			kr.setAttribute('aria-live', 'polite');
			i.insertAdjacentElement('afterend', kr);
			var showKr = function () {
				var v = Math.floor(num(i.value)), eok = Math.floor(v / 1e8), man = Math.floor(v % 1e8 / 1e4), won = v % 1e4, p = [];
				if (i.value.trim() === '' || !isFinite(v) || v < 10000) { kr.textContent = ''; return; }
				if (eok) { p.push(eok.toLocaleString('ko-KR') + '억'); }
				if (man) { p.push(man.toLocaleString('ko-KR') + '만'); }
				if (won && !eok) { p.push(won.toLocaleString('ko-KR')); }
				kr.textContent = '= ' + p.join(' ') + ' 원';
			};
			i.addEventListener('input', showKr);
			i.addEventListener('change', showKr);
			setTimeout(showKr, 0);
		});
		out.addEventListener('click', function (e) {
			var b = e.target.closest('[data-act]');
			if (!b) { return; }
			if (b.getAttribute('data-act') === 'print') { printResult(el); return; }
			var url = shareUrl(type, f), done = function () {
				b.textContent = '✓ 복사됨'; b.classList.add('is-done');
				toast('결과 링크를 복사했어요. 카톡·문자에 붙여 넣으면 같은 결과가 열려요.');
				setTimeout(function () { b.textContent = '결과 링크 복사'; b.classList.remove('is-done'); }, 2500);
			};
			copyText(url, done);
		});
		var shared = prefill(type, f);
		run();
		if (shared) { setTimeout(function () { el.scrollIntoView({ block: 'start' }); }, 300); }
	}
	// 계산기 페이지 아래 '숫자로 보는 계산 예시': 예시 값으로 같은 계산을 돌려 보여 줌(기준 금액이 바뀌면 자동 반영)
	var SAMPLE = {
		severance: { start: '2021-03-02', last: '2026-09-30', wage: '9000000', bonus: '2000000' },
		unemployment: { last: '2026-09-30', wage: '9000000', age: 'u50', period: '2', hours: '8' },
		weekly: { hours: '20' },
		leave: { start: '2023-03-02', base: '2026-10-01' },
		notice: { wage: '12000', hours: '8' },
		insurance: { pay: '3000000' },
		saving: { amount: '300000', months: '12', rate: '5', tax: '15.4' },
		pension: { type: 'single', income: '1000000' },
		median: { n: '4', income: '3000000' },
		age: { birth: '1961-05-20', base: '2026-10-01' },
		eitc: { type: 'one', income: '18000000', kids: '2', asset: 'low' },
		parental: { wage: '3000000', months: '12', mode: 'normal' },
		minwage: { hours: '20', probation: 'no', pay: '1000000' },
		leavepay: { wage: '2500000', mhours: '209', dhours: '8', days: '5' },
		maternity: { wage: '3000000', size: 'small', multi: 'one' },
		date: { mode: 'span', a: '2026-10-01', b: '2026-10-31' }
	};
	function example(box) {
		var type = box.getAttribute('data-example'), el = document.querySelector('.eb-calc[data-calc="' + type + '"]'), s = SAMPLE[type];
		if (!el || !s || !calc[type]) { return; }
		var f = el.querySelector('form').cloneNode(true), data = JSON.parse(el.getAttribute('data-set')), shown = [];
		[].forEach.call(f.elements, function (i) {
			if (i.name && s[i.name] !== undefined) { i.value = s[i.name]; }
		});
		// 계산을 먼저 해서(날짜 계산기는 종류에 따라 칸을 숨김) 숨은 칸은 예시 입력값에서 뺌
		var out = calc[type](f, data).replace('<details class="eb-calc__how">', '<details class="eb-calc__how" open>');
		[].forEach.call(f.elements, function (i) {
			if (!i.name || i.value === '') { return; }
			var lab = i.closest('label'), sm = lab.querySelector('small'), v;
			if (lab.hidden) { return; }
			if (i.tagName === 'SELECT') { v = i.options[i.selectedIndex].text; }
			else if (i.hasAttribute('data-money')) { v = Math.floor(num(i.value)).toLocaleString('ko-KR') + '원'; }
			else if (i.type === 'date') { v = i.value.replace(/-/g, '.'); }
			else { v = i.value + (sm && ['시간', '개월', '%', '명', '일'].indexOf(sm.textContent.split(' ')[0]) > -1 ? sm.textContent.split(' ')[0] : ''); }
			shown.push('<li><span>' + lab.querySelector('span').firstChild.textContent.trim() + '</span><b>' + v + '</b></li>');
		});
		box.querySelector('.eb-calc-example__body').innerHTML = '<ul class="eb-calc-example__in">' + shown.join('') + '</ul>' + out;
		box.hidden = false;
	}
	function start() {
		document.querySelectorAll('.eb-calc').forEach(init);
		document.querySelectorAll('.eb-calc-example').forEach(example);
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', start); } else { start(); }
})();
JS;
	$used = isset( $GLOBALS['eb_calc_types'] ) ? $GLOBALS['eb_calc_types'] : array();
	if ( $used ) {
		$script = preg_replace_callback(
			'/^\t\t([a-z]+): function \(.*?(?=^\t\t[a-z]+: function \(|^\t};)/ms',
			function ( $match ) use ( $used ) { return isset( $used[ $match[1] ] ) ? $match[0] : ''; },
			$script
		);
	}
	echo "<script nowprocket>\n" . $script . "\n</script>\n";
}, 30 );

/* 12. 지금 신청할 수 있는 지원 ----------------------------------------------------
 * 글에 "신청 중" 태그(applying)를 달면 목록에 자동으로 올라가고, 태그를 빼면 내려갑니다.
 * [eb_applying]              : 사이드바용(글이 없으면 아무것도 표시하지 않음)
 * [eb_applying empty="..."]  : 페이지용(글이 없을 때 안내 문구 표시)
 */
add_shortcode( 'eb_applying', function ( $atts ) {
	$atts  = shortcode_atts( array( 'limit' => 5, 'title' => '지금 신청할 수 있는 지원', 'empty' => '' ), $atts );
	$posts = get_posts( array(
		'tag'                 => 'applying',
		'posts_per_page'      => (int) $atts['limit'],
		'orderby'             => 'modified',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
	if ( ! $posts ) {
		return '' === $atts['empty'] ? '' : '<p class="eb-applying__empty">' . esc_html( $atts['empty'] ) . '</p>';
	}
	$html = '' === $atts['title'] ? '' : '<h2 class="widget-title">' . esc_html( $atts['title'] ) . '</h2>';
	$html .= '<ul class="eb-applying">';
	foreach ( $posts as $post ) {
		$html .= sprintf(
			'<li><span class="eb-applying__badge">신청 중</span><a href="%1$s">%2$s</a></li>',
			esc_url( get_permalink( $post ) ),
			esc_html( get_the_title( $post ) )
		);
	}
	return $html . '</ul>';
} );

/* 13. 오래 머무르게 하는 기능 ----------------------------------------------------
 * 13-1 계산기 목록        13-2 글 아래 관련 계산기     (13-3 글 중간 추천 박스: 삭제)
 * 13-4 카테고리 상단 안내  13-5 최근 본 글(사이드바)    13-6 맞춤 지원금 찾기 [eb_finder]
 * 13-7 용어사전 [eb_glossary] + 글 속 용어 설명        (13-8 지급일 캘린더 파일: 삭제)
 * 13-9 알림판 "오래된 글 점검"
 */

// 13-1 계산기 목록: 주소, 이름, 설명, 글 제목에서 찾을 단어
function eb_calc_catalog() {
	return array(
		'quitall'      => array( '/calculator/quit-all/', '퇴사 한 번에 계산기', '퇴직금·연차수당·해고예고수당·실업급여 한 번에', '퇴사|권고사직|계약 ?만료' ), // 72번(2026-10-17)
		'baby'         => array( '/calculator/baby-all/', '출산·육아 한 번에 계산기', '두 살까지 달마다 받는 돈 한눈에', '출산|육아|부모급여|아동수당|첫만남' ), // 73번
		'pay'          => array( '/calculator/take-home-pay/', '연봉 실수령액 계산기', '월급에서 4대보험·세금 빼고 받는 돈', '연봉|실수령|월급' ), // 73번
		'closing'      => array( '/calculator/closing-all/', '폐업 한 번에 계산기', '철거비·노란우산·자영업자 실업급여', '폐업|노란우산|희망리턴' ), // 73번
		'severance'    => array( '/calculator/severance-pay/', '퇴직금 계산기', '입사일·퇴사일과 3개월 임금으로 계산', '퇴직금|퇴직공제' ),
		'unemployment' => array( '/calculator/unemployment-benefit/', '실업급여 계산기', '하루 구직급여·받는 기간·총액', '실업|구직급여|대지급금|임금체불' ),
		'notice'       => array( '/calculator/dismissal-notice-pay/', '해고예고수당 계산기', '30일분 통상임금 계산', '해고' ),
		'weekly'       => array( '/calculator/weekly-holiday-pay/', '주휴수당·월급 계산기', '시급과 주 근무시간으로 월급 환산', '알바|주휴|최저임금|시급' ),
		'leave'        => array( '/calculator/annual-leave/', '연차 계산기', '입사일 기준 발생한 연차 일수', '연차' ),
		'insurance'    => array( '/calculator/social-insurance/', '4대보험 계산기', '월급에서 빠지는 보험료', '4대보험|건강보험료|국민연금|고용보험' ),
		'saving'       => array( '/calculator/savings-interest/', '적금 이자 계산기', '세전·세후 이자와 만기 수령액', '적금|통장|펀드|채움공제' ),
		'pension'      => array( '/calculator/basic-pension/', '기초연금 모의계산기', '선정기준액 이하인지, 최대 얼마 받는지', '기초연금|노인|어르신|65세|75세' ),
		'median'       => array( '/calculator/median-income/', '기준 중위소득 계산기', '가구원 수별 급여 기준 금액', '수급|기초생활|저소득|차상위|중위소득|취약계층' ),
		'age'          => array( '/calculator/age/', '만 나이 계산기', '만 나이와 청년·65세 등 나이 기준', '만 나이|나이 계산|연령' ),
		'eitc'         => array( '/calculator/work-incentive/', '근로·자녀장려금 계산기', '가구 유형과 연 소득으로 예상 장려금', '근로장려금|자녀장려금|장려금' ),
		'parental'     => array( '/calculator/parental-leave-pay/', '육아휴직급여 계산기', '통상임금으로 매달 받는 급여와 총액', '육아휴직|육아기' ),
		'maternity'    => array( '/calculator/maternity-leave-pay/', '출산휴가급여 계산기', '90일 동안 정부·회사가 주는 금액', '출산휴가|출산전후|임신|출산' ),
		'minwage'      => array( '/calculator/minimum-wage/', '최저임금 월급 계산기', '주 근무시간별 최저 월급, 내 월급 확인', '최저임금|최저시급' ),
		'leavepay'     => array( '/calculator/annual-leave-pay/', '연차수당 계산기', '못 쓴 연차를 돈으로 받으면 얼마', '연차수당|미사용 연차' ),
		'date'         => array( '/calculator/date/', '날짜 계산기', 'D-day·며칠 뒤·근무일 수', 'D-day|디데이|날짜 계산|며칠|기한|마감일' ),
	);
}

// 카테고리별 기본 계산기(글 제목에서 못 찾았을 때)
function eb_calc_by_category() {
	return array(
		215 => array( 'median', 'pension' ),
		216 => array( 'median', 'pension' ),
		218 => array( 'parental', 'median' ),
		223 => array( 'saving', 'insurance' ),
		225 => array( 'eitc', 'saving' ),
		231 => array( 'insurance', 'unemployment' ),
		226 => array( 'severance', 'unemployment' ),
		228 => array( 'severance', 'unemployment' ),
	);
}

function eb_calc_cards( $keys, $class = '' ) {
	$catalog = eb_calc_catalog();
	$html    = '';
	foreach ( $keys as $key ) {
		if ( isset( $catalog[ $key ] ) ) {
			$html .= sprintf(
				'<a class="eb-calccard" href="%1$s"><strong>%2$s</strong><span>%3$s</span></a>',
				esc_url( $catalog[ $key ][0] ),
				esc_html( $catalog[ $key ][1] ),
				esc_html( $catalog[ $key ][2] )
			);
		}
	}
	return '' === $html ? '' : '<div class="eb-calcgrid ' . esc_attr( $class ) . '">' . $html . '</div>';
}

function eb_calcs_for_post( $post, $limit = 2 ) {
	$keys  = array();
	$title = get_the_title( $post );
	foreach ( eb_calc_catalog() as $key => $calc ) {
		if ( preg_match( '/' . $calc[3] . '/u', $title ) ) {
			$keys[] = $key;
		}
	}
	if ( count( $keys ) < $limit ) {
		$map = eb_calc_by_category();
		foreach ( wp_get_post_categories( $post->ID ) as $cat_id ) {
			foreach ( array( $cat_id, (int) get_category( $cat_id )->parent ) as $id ) {
				if ( isset( $map[ $id ] ) ) {
					$keys = array_merge( $keys, $map[ $id ] );
				}
			}
		}
	}
	return array_slice( array_values( array_unique( $keys ) ), 0, $limit );
}

// 13-2 글 아래 관련 계산기 (안내 박스·글쓴이 박스보다 먼저)
add_action( 'generate_after_entry_content', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	$t_keys = eb_tools_for_post( get_post() ); // 45번: 긴급·상담 전화, 동네 기관 찾기
	$c_keys = eb_calcs_for_post( get_post() );
	if ( count( $t_keys ) + count( $c_keys ) < 2 ) { // 카드가 2개 안 되면 분야에 맞는 도구로 채움(2026-10-15)
		$t_keys = array_merge( $t_keys, eb_tools_fill_for_post( get_post(), $t_keys, 2 - count( $c_keys ) ) );
	}
	$tools = eb_tool_cards( $t_keys );
	$cards = eb_calc_cards( $c_keys );
	if ( $tools ) {
		$cards = '<div class="eb-calcgrid">' . $tools . preg_replace( '#^<div class="eb-calcgrid ?">|</div>$#', '', $cards ) . '</div>';
	}
	if ( $cards ) {
		echo '<aside class="eb-postcalc"><p class="eb-postcalc__title">이 글과 함께 쓰면 좋은 ' . ( $tools ? '도구' : '계산기' ) . '</p>' . $cards . '</aside>'; // phpcs:ignore
	}
}, 4 );

// 13-4 카테고리 상단: 세부 분야 · 이 분야 많이 본 글 · 관련 계산기
function eb_popular_ids() {
	$ids = get_transient( 'eb_popular_ids' );
	if ( false !== $ids ) {
		return $ids;
	}
	global $wpdb;
	$table = $wpdb->prefix . 'statistics_pages';
	$ids   = array();
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
		$ids = array_map( 'intval', (array) $wpdb->get_col(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE type = 'post' AND date >= %s GROUP BY id ORDER BY SUM(count) DESC LIMIT 60",
				gmdate( 'Y-m-d', strtotime( '-30 days' ) )
			)
		) );
	}
	set_transient( 'eb_popular_ids', $ids, 6 * HOUR_IN_SECONDS );
	return $ids;
}

add_action( 'generate_after_archive_description', function () {
	if ( ! is_category() || is_paged() ) {
		return;
	}
	$term = get_queried_object();
	$html = '';

	$children = get_categories( array( 'parent' => $term->term_id, 'hide_empty' => true ) );
	if ( $children ) {
		$html .= '<div class="eb-cathead__subs"><span>세부 분야</span>';
		foreach ( $children as $child ) {
			$html .= sprintf( '<a href="%1$s">%2$s <em>%3$d</em></a>', esc_url( get_category_link( $child ) ), esc_html( $child->name ), (int) $child->count );
		}
		$html .= '</div>';
	}

	$in_cat = get_posts( array(
		'cat'            => $term->term_id,
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	) );
	$top = array_slice( array_values( array_intersect( eb_popular_ids(), $in_cat ) ), 0, 3 );
	if ( count( $top ) < 3 ) {
		$top = array_slice( array_values( array_unique( array_merge( $top, $in_cat ) ) ), 0, 3 );
	}
	if ( $top ) {
		$html .= '<div class="eb-cathead__popular"><p class="eb-cathead__label">이 분야 많이 본 글</p><ol>';
		foreach ( $top as $id ) {
			$html .= sprintf( '<li><a href="%1$s">%2$s</a></li>', esc_url( get_permalink( $id ) ), esc_html( get_the_title( $id ) ) );
		}
		$html .= '</ol></div>';
	}

	$map  = eb_calc_by_category();
	$keys = isset( $map[ $term->term_id ] ) ? $map[ $term->term_id ] : ( isset( $map[ $term->parent ] ) ? $map[ $term->parent ] : array() );
	if ( $keys ) {
		$html .= '<div class="eb-cathead__calc"><p class="eb-cathead__label">이 분야 계산기</p>' . eb_calc_cards( $keys ) . '</div>';
	}

	// 휴대폰: 상위 분야 '전체' + 세부 분야를 탭 한 줄로, 지금 보는 분야가 켜짐(세부 분야 페이지에서도) - css/10-list.css 끝 '분야 머리 콤팩트' (2026-10-16)
	$root = $term->parent ? get_category( $term->parent ) : $term;
	$kids = $root ? get_categories( array( 'parent' => $root->term_id, 'hide_empty' => true ) ) : array();
	if ( $kids ) {
		$total = (int) $root->count;
		foreach ( $kids as $k ) {
			$total += (int) $k->count;
		}
		$html .= '<nav class="eb-cattabs" aria-label="세부 분야">' . sprintf( '<a href="%1$s"%2$s>전체 <em>%3$d</em></a>', esc_url( get_category_link( $root ) ), $root->term_id === $term->term_id ? ' aria-current="page"' : '', $total );
		foreach ( $kids as $k ) {
			$html .= sprintf( '<a href="%1$s"%2$s>%3$s <em>%4$d</em></a>', esc_url( get_category_link( $k ) ), $k->term_id === $term->term_id ? ' aria-current="page"' : '', esc_html( $k->name ), (int) $k->count );
		}
		$html .= '</nav>';
	}

	if ( $html ) {
		echo '<div class="eb-cathead">' . $html . '</div>'; // phpcs:ignore
		// 휴대폰에서는 '이 분야 많이 본 글' 상자를 숨기는 대신 아래 글 목록의 같은 글에 '인기' 표시(.eb-row.is-hot)
		echo "<script nowprocket>document.addEventListener('DOMContentLoaded',function(){var s={};document.querySelectorAll('.eb-cathead__popular a').forEach(function(a){s[a.href]=1;});document.querySelectorAll('.eb-list .eb-row').forEach(function(r){if(s[r.href]){r.classList.add('is-hot');}});});</script>\n";
	}
} );

// 13-5 최근 본 글: 방문자 브라우저에만 저장(서버 저장 없음). 사이드바 위젯 [eb_recent_viewed]
add_shortcode( 'eb_recent_viewed', function () {
	return '<div class="eb-recentview" hidden><h2 class="widget-title">최근 본 글</h2><ul></ul></div>';
} );

// 13-6 맞춤 지원금 찾기 [eb_finder]
// 선택지: 이름, 카테고리 ID, 글 제목에서 찾을 단어, 함께 추천할 계산기(13-1 목록의 키)
function eb_finder_options() {
	return array(
		'age'  => array( '나이', 'radio', array(
			'any'    => array( '상관없음', array(), '' ),
			'youth'  => array( '청년(19~39세)', array( 218 ), '청년|유스|군적금|대학', array( 'age', 'saving' ) ),
			'senior' => array( '65세 이상', array( 216 ), '노인|어르신|65세|75세|기초연금|틀니|결핵|응급안전|안심콜', array( 'pension', 'age' ) ),
		) ),
		'case' => array( '해당하는 상황을 모두 골라 주세요', 'check', array(
			'kids'     => array( '아이를 키우거나 준비해요', array( 218 ), '아동|아이|자녀|유스|디딤씨앗|난자|출산|임신', array( 'parental', 'eitc' ) ),
			'low'      => array( '소득이 적어요', array( 216 ), '수급|저소득|취약계층|기초생활|압류방지|보일러|의료비 지원|장례', array( 'median', 'eitc' ) ),
			'job'      => array( '월급·퇴직금 문제가 있어요', array( 228 ), '실업|퇴직|해고|임금|대지급금', array( 'severance', 'unemployment' ) ),
			'business' => array( '가게·사업을 해요', array( 231 ), '소상공인|폐업|사업자|창업', array( 'insurance' ) ),
			'car'      => array( '차를 운전해요', array( 220 ), '운전|면허|주차|화물|경차|유류' ),
			'pet'      => array( '반려동물을 키워요', array( 230 ), '반려|펫' ),
			'health'   => array( '병원·건강이 걱정돼요', array( 221 ), '건강|검진|진료|틀니|임플란트|결핵' ),
			'edu'      => array( '법정 의무교육 대상이에요', array( 217 ), '교육|선임' ),
			'money'    => array( '목돈을 모으고 싶어요', array( 225 ), '적금|통장|펀드|채움공제', array( 'saving' ) ),
		) ),
	);
}

// 13-6 맞춤 혜택 찾기 [eb_finder] - 2026-10-09 전면 개편(style.css 99번, 아래 55번 스크립트)
// 복지로와 같은 세 갈래(생애주기·가구 상황·관심 주제)로 고르면 ① 이지복지 정리 글(전용 태그 53번) ② 정부 복지서비스 전체(54번 API, 하루 1회 저장)를 한 번에
// 예전 '나이 3개 + 상황 9개'(eb_finder_options)는 다른 곳 호환용으로 함수만 남김
function eb_f2_posts() {
	$out = get_transient( 'eb_f2_posts' );
	if ( is_array( $out ) ) {
		return $out;
	}
	$out = array();
	$pop = array_slice( (array) eb_popular_ids(), 0, 10 );
	foreach ( get_posts( array( 'posts_per_page' => -1, 'post_status' => 'publish', 'no_found_rows' => true ) ) as $p ) {
		$names = function ( $tax ) use ( $p ) {
			$t = get_the_terms( $p->ID, $tax );
			return ( $t && ! is_wp_error( $t ) ) ? array_values( wp_list_pluck( $t, 'name' ) ) : array();
		};
		$out[] = array(
			't'  => html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' ),
			'u'  => get_permalink( $p ),
			'c'  => eb_short_cat( $p->ID ),
			'd'  => get_the_modified_date( 'm.d', $p ),
			'p'  => in_array( $p->ID, $pop, true ) ? 1 : 0,
			'l'  => $names( 'eb_life' ),
			'h'  => $names( 'eb_hh' ),
			'th' => $names( 'eb_theme' ),
			'r'  => function_exists( 'eb_post_regions' ) ? eb_post_regions( $p->ID ) : array(), // 대상 지역(53-2번, 2026-10-09)
		);
		if ( $out[ count( $out ) - 1 ]['r'] ) {
			$rn = eb_region_names();
			$r0 = $out[ count( $out ) - 1 ]['r'][0];
			$out[ count( $out ) - 1 ]['rs'] = isset( $rn[ $r0 ] ) ? $rn[ $r0 ] : $r0; // 'OO 한정' 표시용 짧은 이름
		}
	}
	set_transient( 'eb_f2_posts', $out, 6 * HOUR_IN_SECONDS );
	return $out;
}
add_action( 'save_post_post', function () {
	delete_transient( 'eb_f2_posts' );
} );
add_action( 'set_object_terms', function () {
	delete_transient( 'eb_f2_posts' );
} );

// 정부 복지서비스 목록(54번에서 저장한 것) - 맞춤 찾기 화면이 열린 뒤 따로 받아 감(페이지를 무겁게 하지 않게)
add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/services', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			$sp  = function ( $s ) {
				return array_values( array_filter( array_map( function ( $v ) { return preg_replace( '/\s*·\s*/u', '·', trim( $v ) ); }, explode( ',', (string) $s ) ) ) ); // '임신 · 출산' → '임신·출산'
			};
			$out = array();
			foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
				if ( empty( $s['name'] ) ) {
					continue;
				}
				$out[] = array(
					'n' => $s['name'],
					'o' => $s['org'],
					's' => wp_strip_all_tags( $s['sum'] ),
					'u' => 0 === strpos( (string) $s['link'], 'https://' ) || 0 === strpos( (string) $s['link'], 'http://' ) ? $s['link'] : 'https://www.bokjiro.go.kr/',
					'l' => $sp( $s['life'] ),
					'h' => $sp( $s['hh'] ),
					't' => $sp( $s['them'] ),
				);
			}
			$res = new WP_REST_Response( array( 'at' => (int) get_option( 'eb_ws_synced' ), 'items' => $out ) );
			$res->header( 'Cache-Control', 'public, max-age=3600' );
			return $res;
		},
	) );
} );

// 혜택 찾기 페이지(14851)는 사이드바 없이 넓게 - 왼쪽 조건 · 오른쪽 결과 2단
// 2026-10-09 개선안 7번: 넓게 써야 하는 도구·허브 페이지도 같은 방식(사이드바 없음 + body.eb-wide, style.css 112번)
// 복지 캘린더 14852 · 계산기 모음 14866 · 상황별 가이드 모음 14907 · 2026 기준표 14869 · 우리 동네 복지 기관 15087 · 주소 찾기 15044 · 저장한 글 14937
function eb_wide_pages() {
	return array( 14851, 14852, 14866, 14907, 14869, 15087, 15044, 14937 );
}
add_filter( 'generate_sidebar_layout', function ( $layout ) {
	return is_page( eb_wide_pages() ) ? 'no-sidebar' : $layout;
} );
add_filter( 'body_class', function ( $classes ) {
	if ( is_page( eb_wide_pages() ) && ! is_page( 14851 ) ) {
		$classes[] = 'eb-wide';
	}
	// 나머지 페이지·분야·검색·404도 머리(꼬리표 + 큰 제목 + 안내 한 줄)를 같게 - style.css 끝 '페이지 머리 통일' (2026-10-15)
	if ( ( is_page() && ! is_front_page() && ! in_array( 'eb-wide', $classes, true ) ) || is_category() || is_search() || is_404() ) {
		$classes[] = 'eb-head';
	}
	return $classes;
} );
// 2026-10-09 개선안 7번: 도구·계산기 아이콘(계산기 모음·상황별 가이드 카드 + 계산기 사이드바 '관련 계산기'에서 같이 씀, style.css 112번)
function eb_tool_icons() {
	return array(
		'median-income'        => '<path d="M5 20V12M11 20V6M17 20v-9M3 20h18"/>',
		'basic-pension'        => '<circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 20.5a6.5 6.5 0 0 1 13 0"/>',
		'work-incentive'       => '<circle cx="12" cy="12" r="9"/><path d="M7.5 9l1.8 6 2.7-5 2.7 5 1.8-6M7 12h10"/>',
		'age'                  => '<path d="M4 21h16M5 21v-6.5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2V21M5 17c2.3 0 2.3-1.3 4.7-1.3s2.3 1.3 4.6 1.3 2.4-1.3 4.7-1.3M12 12.5V9.5M12 6.5v-.5"/>',
		'baby-all'             => '<path d="M9 21a2 2 0 1 0 0-.01M17 21a2 2 0 1 0 0-.01M3 5h2l2.5 10h11L21 8H6.2"/>',
		'take-home-pay'        => '<path d="M19 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2"/><path d="M21 12h-5a2 2 0 0 0 0 4h5z"/>',
		'closing-all'          => '<path d="M3.5 9 5 4h14l1.5 5M4.5 9v11h15V9M3.5 9h17"/><path d="M9.5 20v-5.5h5V20"/>',
		'quit-all'             => '<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8.5 7h7M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15h.01"/>',
		'severance-pay'        => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7M3 13h18"/>',
		'unemployment-benefit' => '<path d="M3 12a9 9 0 0 1 18 0z"/><path d="M12 12v6.5a2 2 0 0 1-4 0"/>',
		'minimum-wage'         => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
		'weekly-holiday-pay'   => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18M9 15l2 2 4-4"/>',
		'annual-leave'         => '<circle cx="12" cy="12" r="4"/><path d="M12 2.5v2M12 19.5v2M4.6 4.6 6 6M18 18l1.4 1.4M2.5 12h2M19.5 12h2M4.6 19.4 6 18M18 6l1.4-1.4"/>',
		'annual-leave-pay'     => '<rect x="2.5" y="6" width="19" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 9.5v.01M18 14.5v.01"/>',
		'dismissal-notice-pay' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M12 11.5V15M12 18h.01"/>',
		'social-insurance'     => '<path d="M12 3l7.5 3v5.5c0 4.6-3.2 7.8-7.5 9.5-4.3-1.7-7.5-4.9-7.5-9.5V6z"/><path d="M9 12l2 2 4-4"/>',
		'maternity-leave-pay'  => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>',
		'parental-leave-pay'   => '<circle cx="12" cy="12" r="8.5"/><path d="M9.5 10.5h.01M14.5 10.5h.01M9.5 14.5a3.5 3.5 0 0 0 5 0"/>',
		'savings-interest'     => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
		'date'                 => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18M8 14h.01M12 14h.01M16 14h.01M8 17.5h.01M12 17.5h.01"/>',
		'address'              => '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0C18.5 15.4 12 21 12 21z"/><circle cx="12" cy="10" r="2.5"/>',
		'standards'            => '<rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9.5h18M3 14.5h18M9 9.5V20"/>',
		'schedule'             => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18"/>',
		'forms'                => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
		'after-quit'           => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7"/>',
		'parents-65'           => '<circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 20.5a6.5 6.5 0 0 1 13 0"/>',
		'raising-kids'         => '<circle cx="12" cy="12" r="8.5"/><path d="M9.5 10.5h.01M14.5 10.5h.01M9.5 14.5a3.5 3.5 0 0 0 5 0"/>',
		'closing-business'     => '<path d="M3.5 9 5 4h14l1.5 5M4.5 9v11h15V9M3.5 9h17"/><path d="M9.5 20v-5.5h5V20"/>',
		'hard-times'           => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="3.5"/><path d="m14.5 9.5 3.5-3.5M9.5 14.5 6 18M14.5 14.5 18 18M9.5 9.5 6 6"/>',
		'youth'                => '<path d="m12 3.5 2.6 5.3 5.8.8-4.2 4.1 1 5.8L12 16.8l-5.2 2.7 1-5.8-4.2-4.1 5.8-.8z"/>',
		'sick-or-injured'      => '<path d="M3 12h4l2-5 4 10 2-5h6"/>',
		'moving-house'         => '<path d="M3.5 11 12 4l8.5 7"/><path d="M5.5 9.5V20h13V9.5"/>',
	);
}
function eb_tool_icon( $href ) {
	$slug = basename( untrailingslashit( (string) wp_parse_url( $href, PHP_URL_PATH ) ) );
	$ic   = eb_tool_icons();
	return '<i class="eb-cc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . ( isset( $ic[ $slug ] ) ? $ic[ $slug ] : '<path d="M5 12h14M13 6l6 6-6 6"/>' ) . '</svg></i>';
}
// 넓은 페이지 중 긴 페이지(계산기 모음 14866 · 2026 기준표 14869 · 주소 찾기 15044): 제목(h2)으로 '바로 가기' 줄을 만들어 위에 붙임(따라 내려옴, style.css 112번)
add_action( 'wp_footer', function () {
	if ( ! is_page( array( 14866, 14869, 15044 ) ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var c = document.querySelector('.eb-wide .entry-content');
	if (!c) { return; }
	var hs = [].slice.call(c.querySelectorAll(':scope > h2')).filter(function (h) { return h.offsetParent !== null; });
	if (hs.length < 3) { return; }
	var nav = document.createElement('nav');
	nav.className = 'eb-secnav';
	nav.setAttribute('aria-label', '이 페이지 바로 가기');
	nav.innerHTML = '<div class="eb-secnav__in">' + hs.map(function (h, i) {
		if (!h.id) { h.id = 'sec-' + (i + 1); }
		return '<a href="#' + h.id + '">' + h.textContent.replace(/[<>&]/g, '') + '</a>';
	}).join('') + '</div>';
	var lead = c.querySelector(':scope > p:first-child');
	c.insertBefore(nav, lead ? lead.nextSibling : c.firstChild);
	var links = [].slice.call(nav.querySelectorAll('a'));
	var top = function () {
		var t = 0;
		['#wpadminbar', '.xh', '#mobile-header', '.main-navigation.is_stuck'].forEach(function (s) {
			var e = document.querySelector(s);
			if (e) { var r = e.getBoundingClientRect(), p = getComputedStyle(e).position; if ((p === 'fixed' || p === 'sticky') && r.height && r.bottom > t && r.top <= t + 2) { t = r.bottom; } }
		});
		return t;
	};
	var setTop = function () { nav.style.top = top() + 'px'; };
	setTop();
	window.addEventListener('scroll', setTop, { passive: true });
	window.addEventListener('resize', setTop);
	nav.addEventListener('click', function (e) {
		var a = e.target.closest('a');
		if (!a) { return; }
		var t = document.getElementById(a.getAttribute('href').slice(1));
		if (!t) { return; }
		e.preventDefault();
		window.scrollTo({ top: t.getBoundingClientRect().top + window.pageYOffset - top() - nav.offsetHeight - 16, behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
		history.replaceState(null, '', '#' + t.id);
	});
	var on = function () {
		var y = top() + nav.offsetHeight + 40, cur = 0;
		hs.forEach(function (h, i) { if (h.getBoundingClientRect().top <= y) { cur = i; } });
		links.forEach(function (a, i) {
			a.classList.toggle('is-on', i === cur);
			if (i === cur && a.parentNode.scrollWidth > a.parentNode.clientWidth) { a.parentNode.scrollLeft = a.offsetLeft - 16; }
		});
	};
	window.addEventListener('scroll', on, { passive: true });
	on();
})();
JS
	. "\n</script>\n";
}, 99 );

// 넓은 페이지(계산기 모음·상황별 가이드 등)의 카드 앞에 아이콘
add_filter( 'the_content', function ( $html ) {
	if ( ! is_page( eb_wide_pages() ) || false === strpos( $html, 'eb-calccard' ) ) {
		return $html;
	}
	return preg_replace_callback( '#(<a class="eb-calccard" href="([^"]+)">)#', function ( $m ) {
		return $m[1] . eb_tool_icon( $m[2] );
	}, $html );
}, 20 );
// 계산기 페이지(모음 14866의 하위) 사이드바: 검색창 바로 아래 '관련 계산기' - 같은 묶음 계산기 먼저, 모자라면 많이 쓰는 것으로
add_action( 'dynamic_sidebar', function ( $w ) {
	static $done = false;
	if ( $done || is_admin() || ! is_page() || 14866 !== (int) wp_get_post_parent_id( get_queried_object_id() ) || ( isset( $w['id'] ) && 'block-97' === $w['id'] ) ) {
		return;
	}
	$done   = true;
	$cur    = basename( untrailingslashit( (string) wp_parse_url( get_permalink( get_queried_object_id() ), PHP_URL_PATH ) ) );
	$groups = array(
		array( 'median-income', 'basic-pension', 'work-incentive', 'age' ),
		array( 'quit-all', 'severance-pay', 'unemployment-benefit', 'dismissal-notice-pay', 'annual-leave', 'annual-leave-pay', 'weekly-holiday-pay', 'minimum-wage', 'social-insurance', 'maternity-leave-pay', 'parental-leave-pay' ),
		array( 'savings-interest', 'date' ),
		// 2026-10-17 한 번에 계산기: 뒤에 있는 묶음이 이김(같은 계산기가 두 묶음에 있으면 뒤 묶음 기준)
		array( 'take-home-pay', 'social-insurance', 'minimum-wage', 'weekly-holiday-pay', 'annual-leave' ),
		array( 'baby-all', 'maternity-leave-pay', 'parental-leave-pay', 'work-incentive', 'median-income' ),
		array( 'closing-all', 'social-insurance', 'savings-interest', 'unemployment-benefit', 'quit-all' ),
	);
	$pick = array();
	foreach ( $groups as $g ) {
		if ( in_array( $cur, $g, true ) ) {
			$pick = array_values( array_diff( $g, array( $cur ) ) );
		}
	}
	foreach ( array( 'unemployment-benefit', 'severance-pay', 'median-income', 'basic-pension', 'work-incentive', 'minimum-wage' ) as $s ) {
		if ( count( $pick ) >= 5 ) {
			break;
		}
		if ( $s !== $cur && ! in_array( $s, $pick, true ) ) {
			$pick[] = $s;
		}
	}
	$li = '';
	foreach ( array_slice( $pick, 0, 5 ) as $s ) {
		$p = get_page_by_path( 'calculator/' . $s );
		if ( ! $p || 'publish' !== $p->post_status ) {
			continue;
		}
		$name = trim( preg_replace( '/\s*\([^)]*\)\s*$/u', '', get_the_title( $p ) ) ); // '(2026)' 같은 꼬리 빼기
		$li  .= '<li><a href="' . esc_url( get_permalink( $p ) ) . '">' . eb_tool_icon( '/' . $s . '/' ) . '<span>' . esc_html( $name ) . '</span><svg class="eb-rc__go" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg></a></li>';
	}
	if ( $li ) {
		echo '<aside class="widget inner-padding eb-rc"><h2 class="widget-title">관련 계산기</h2><ul>' . $li . '</ul><a class="eb-rc__all" href="' . esc_url( home_url( '/calculator/' ) ) . '">계산기 ' . count( eb_calc_catalog() ) . '개 모두 보기</a></aside>'; // phpcs:ignore
	}
} );


// 생애주기 아이콘(혜택 찾기 1단계 · 59번 빠른 찾기 창 같이 씀)
function eb_f2_life_icons() {
	return array(
		'pregnancy' => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>',
		'infant'    => '<circle cx="12" cy="12" r="8"/><path d="M9.5 10.5h.01M14.5 10.5h.01M9.5 14.5a3.5 3.5 0 0 0 5 0"/>',
		'child'     => '<circle cx="12" cy="5.5" r="2.5"/><path d="M8 21l1.6-7L7 11.5 10 9h4l3 2.5-2.6 2.5L16 21"/>',
		'teen'      => '<path d="M3 9.5 12 5l9 4.5-9 4.5z"/><path d="M7 12v4c0 1.5 2.2 3 5 3s5-1.5 5-3v-4M21 9.5V15"/>',
		'youth'     => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7M3 13h18"/>',
		'middle'    => '<circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0"/><circle cx="17" cy="9" r="2.3"/><path d="M15.6 14.3A4.5 4.5 0 0 1 21 18.6"/>',
		'senior'    => '<circle cx="11" cy="5" r="2.3"/><path d="M8 21l2-7-1-3 3-2 2 3 3 1M10 14l-2 2M17 13v8"/>',
	);
}

// 필요한 도움: 자주 찾는 8개 + 나머지(복지로 6 + 사이트 전용 3)
function eb_f2_themes( $terms ) {
	$th_gov  = array_slice( array_values( $terms['eb_theme'][1] ), 0, 14 );
	$th_site = array( '교통·자동차', '반려동물', '사업·창업' );
	$th_top  = array( '생활지원', '일자리', '주거', '신체건강', '보호·돌봄', '서민금융', '정신건강', '교육' );
	return array( $th_top, array_merge( array_values( array_diff( $th_gov, $th_top ) ), $th_site ) );
}

function eb_f2_icon( $p ) {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}

add_shortcode( 'eb_finder', function () {
	$GLOBALS['eb_f2_used'] = true;
	$terms = eb_tax_terms();
	$life_ic = eb_f2_life_icons();
	$life = '';
	foreach ( $terms['eb_life'][1] as $slug => $name ) {
		$life .= '<button type="button" class="f2__tile" data-g="life" data-v="' . esc_attr( $name ) . '" aria-pressed="false"><i>' . eb_f2_icon( $life_ic[ $slug ] ) . '</i><span>' . esc_html( $name ) . '</span></button>';
	}
	$chips = function ( $list, $g ) {
		$h = '';
		foreach ( $list as $name ) {
			$h .= '<button type="button" class="f2__chip" data-g="' . $g . '" data-v="' . esc_attr( $name ) . '" aria-pressed="false">' . esc_html( $name ) . '</button>';
		}
		return $h;
	};
	list( $th_top, $th_rest ) = eb_f2_themes( $terms );
	// 고른 조건에 따라 함께 보여 줄 계산기(13-1 목록 키) - 관심 주제·생애주기·가구 상황 이름 → 계산기
	$cmap = array( '일자리' => array( 'severance', 'unemployment', 'weekly' ), '생활지원' => array( 'median', 'eitc' ), '저소득' => array( 'median', 'eitc' ), '노년' => array( 'pension' ), '영유아' => array( 'parental' ), '보육' => array( 'parental' ), '임신·출산' => array( 'parental' ), '서민금융' => array( 'saving' ), '청년' => array( 'saving' ), '사업·창업' => array( 'insurance' ) );
	$cat   = function_exists( 'eb_calc_catalog' ) ? eb_calc_catalog() : array();
	$calcs = array();
	foreach ( $cmap as $k => $keys ) {
		foreach ( $keys as $key ) {
			if ( isset( $cat[ $key ] ) ) {
				$calcs[ $k ][] = array( home_url( $cat[ $key ][0] ), preg_replace( '/\s*(모의)?계산기$/u', '', $cat[ $key ][1] ) );
			}
		}
	}
	$n_svc = count( (array) get_option( 'eb_ws_all', array() ) );
	$regions = function_exists( 'eb_ws_regions' ) ? eb_ws_regions() : array();
	$data    = array( 'posts' => eb_f2_posts(), 'calcs' => $calcs, 'api' => rest_url( 'eb/v1/services' ), 'nsvc' => $n_svc, 'lapi' => rest_url( 'eb/v1/local' ), 'regions' => $regions );
	$sd_opts = '';
	foreach ( array_keys( $regions ) as $sd ) {
		$sd_opts .= '<option value="' . esc_attr( $sd ) . '">' . esc_html( $sd ) . '</option>';
	}
	$step  = function ( $n, $title, $hint ) {
		return '<h3 class="f2__h"><b>' . $n . '</b><span class="f2__ht">' . $title . '</span><small>' . $hint . '</small><em class="f2__hv"></em></h3>'; // em: 휴대폰 접힌 단계에 고른 값
	};
	return '<span id="quick"></span><div class="f2" id="finder" data-set="' . esc_attr( wp_json_encode( $data ) ) . '"><div class="f2__grid">'
		. '<aside class="f2__panel" aria-label="조건 고르기"><div class="f2__panel-in">'
		// 순서(2026-10-09 조정): 1 시기(가장 쉬움) → 2 사는 곳(결과에 가장 큰 영향, 지역 서비스가 중앙의 10배) → 3 가구 상황(민감·해당 없는 사람 많아 뒤로) → 4 필요한 도움(좁히기)
		. '<div class="f2__step">' . $step( 1, '지금 시기', '하나만' ) . '<div class="f2__life" role="group" aria-label="생애주기">' . $life . '</div></div>'
		. ( $regions ? '<div class="f2__step">' . $step( 2, '사는 곳', '지역 서비스까지' ) . '<div class="f2__region"><label><span class="screen-reader-text">시·도</span><select class="f2__sd"><option value="">시·도 선택</option>' . $sd_opts . '</select></label><label><span class="screen-reader-text">시·군·구</span><select class="f2__sg" disabled><option value="">시·군·구 전체</option></select></label></div></div>' : '' )
		. '<div class="f2__step">' . $step( $regions ? 3 : 2, '가구 상황', '해당하면 모두' ) . '<div class="f2__chips" role="group" aria-label="가구 상황">' . $chips( array_values( $terms['eb_hh'][1] ), 'hh' ) . '</div></div>'
		// 필요한 도움: 자주 찾는 8개 먼저, 나머지 9개(복지로 6 + 사이트 전용 3)는 '더 보기' - 패널을 한 화면에 (2026-10-09)
		. '<div class="f2__step">' . $step( $regions ? 4 : 3, '필요한 도움', '여러 개' ) . '<div class="f2__chips" role="group" aria-label="필요한 도움">' . $chips( $th_top, 'th' )
		. '<span class="f2__thx" hidden>' . $chips( $th_rest, 'th' ) . '</span><button type="button" class="f2__thmore" aria-expanded="false">+' . count( $th_rest ) . '개 더 보기</button></div></div>'
		. '<p class="f2__mem">고른 조건은 이 기기에만 기억되고 서버로 보내지 않아요. <button type="button" class="f2__reset">선택 지우기</button></p>'
		. '</div></aside>'
		. '<section class="f2__res" aria-label="찾은 혜택"><div class="f2__body" aria-live="polite"></div>'
		. '<p class="f2__src">정부 복지서비스 ' . number_format_i18n( $n_svc ) . '개 · 지역 복지서비스 ' . number_format_i18n( count( (array) get_option( 'eb_ws_local', array() ) ) ) . '개 · 출처: 한국사회보장정보원(복지로) 중앙부처·지자체 복지서비스, 매일 새로 받음. 실제 지원 자격은 복지로나 보건복지상담센터(129)에서 꼭 확인해 주세요.</p></section>'
		. '</div><a class="f2__jump" href="#f2-res" hidden>결과 <b>0</b>개 보기 <span aria-hidden="true">↓</span></a></div>';
} );

// 13-7 용어사전
function eb_glossary() {
	return array(
		'기준 중위소득'       => '우리나라 전체 가구를 소득 순으로 줄 세웠을 때 가운데 가구의 소득입니다. 보건복지부가 매년 고시하며 여러 복지 급여의 선정 기준으로 씁니다.',
		'소득인정액'          => '소득평가액과 재산의 소득환산액을 더한 금액입니다. 기초생활보장·기초연금 등 대부분의 복지 급여는 월급이 아니라 이 금액으로 대상자를 정합니다.',
		'소득평가액'          => '실제 소득에서 근로소득 공제 등 정해진 금액을 뺀 소득입니다. 소득인정액을 계산할 때 쓰입니다.',
		'재산의 소득환산액'   => '집·땅·예금·자동차 같은 재산에서 기본재산액과 부채를 뺀 뒤, 정해진 비율을 곱해 월 소득으로 바꾼 금액입니다.',
		'차상위계층'          => '기초생활보장 수급자는 아니지만 소득인정액이 기준 중위소득의 50% 이하인 가구입니다. 여러 감면·지원 제도의 대상이 됩니다.',
		'기초생활수급자'      => '국민기초생활보장법에 따라 생계·의료·주거·교육급여 가운데 하나 이상을 받는 사람입니다.',
		'부양의무자'          => '수급자의 부모·자녀 등 1촌 직계혈족과 그 배우자입니다. 의료급여 등은 부양의무자의 소득·재산도 함께 봅니다.',
		'선정기준액'          => '기초연금을 받을 수 있는 소득인정액의 상한선입니다. 만 65세 이상 가운데 소득 하위 70%가 받을 수 있도록 매년 정합니다.',
		'기준연금액'          => '기초연금으로 받을 수 있는 최대 금액입니다. 2026년에는 월 349,700원입니다.',
		'평균임금'            => '그만두기 전 3개월 동안 받은 임금 총액을 그 기간의 날짜 수로 나눈 금액입니다. 퇴직금과 실업급여 계산에 쓰입니다.',
		'통상임금'            => '정해진 근로에 대해 정기적·일률적으로 주기로 한 임금입니다. 해고예고수당과 연장근로수당 계산의 기준이 됩니다.',
		'소정근로시간'        => '법정 근로시간(하루 8시간, 주 40시간) 안에서 회사와 근로자가 일하기로 정한 시간입니다.',
		'주휴수당'            => '1주에 15시간 이상 일하고 정해진 날을 모두 출근한 근로자가 쉬는 날에도 받는 하루치 임금입니다.',
		'구직급여'            => '흔히 실업급여라고 부르는 돈으로, 원하지 않게 일을 그만둔 고용보험 가입자가 재취업 활동을 하는 동안 받습니다.',
		'피보험 단위기간'     => '고용보험에 가입한 기간 가운데 임금을 받은 날을 합한 기간입니다. 실업급여를 받으려면 그만두기 전 18개월 동안 180일 이상이어야 합니다.',
		'소정급여일수'        => '실업급여를 받을 수 있는 날 수입니다. 나이와 고용보험 가입 기간에 따라 120일에서 270일까지입니다.',
		'간이대지급금'        => '회사에서 받지 못한 임금·퇴직금을 나라가 회사 대신 일정 한도 안에서 먼저 주는 돈입니다.',
		'해고예고수당'        => '회사가 30일 전에 해고를 알리지 않았을 때 근로자에게 주어야 하는 30일분 이상의 통상임금입니다.',
		'4대보험'             => '국민연금·건강보험·고용보험·산재보험을 함께 부르는 말입니다. 산재보험료는 회사가 모두 냅니다.',
		'기준소득월액'        => '국민연금 보험료를 계산하는 기준이 되는 월 소득입니다. 상한과 하한이 있고 매년 7월에 조정됩니다.',
		'본인부담금'          => '병원비 가운데 건강보험이 내 주지 않아 환자가 직접 내는 금액입니다.',
		'바우처'              => '정해진 서비스에만 쓸 수 있도록 나라가 비용을 대신 내 주는 이용권입니다.',
		'지역화폐'            => '지방자치단체가 발행해 그 지역 가맹점에서만 쓸 수 있는 상품권이나 카드입니다. 구매할 때 할인이나 캐시백을 주는 경우가 많습니다.',
		'과태료'              => '법에서 정한 의무를 지키지 않았을 때 내는 돈입니다. 벌금과 달리 형벌이 아니라 전과가 남지 않습니다.',
		'비과세'              => '세금을 매기지 않는다는 뜻입니다. 비과세 적금은 이자에서 세금을 떼지 않습니다.',
		'원천징수'            => '돈을 주는 쪽이 세금을 미리 떼어 대신 내는 방식입니다. 월급의 소득세, 예·적금 이자의 이자소득세가 대표적입니다.',
	);
}

add_shortcode( 'eb_glossary', function () {
	$html = '<dl class="eb-glossary">';
	foreach ( eb_glossary() as $term => $desc ) {
		$html .= sprintf( '<div class="eb-glossary__item" id="%1$s"><dt>%2$s</dt><dd>%3$s</dd></div>', esc_attr( 'term-' . md5( $term ) ), esc_html( $term ), esc_html( $desc ) );
	}
	return $html . '</dl>';
} );

// 13-9 알림판 위젯 "오래된 글 점검": 1년 넘게 수정하지 않은 글, 제목에 지난 연도가 있는 글
add_action( 'wp_dashboard_setup', function () {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'eb_stale_posts', '이지복지닷컴 · 오래된 글 점검', function () {
		$year  = (int) current_datetime()->format( 'Y' );
		$old   = get_posts( array(
			'posts_per_page' => 15,
			'orderby'        => 'modified',
			'order'          => 'ASC',
			'date_query'     => array( array( 'column' => 'post_modified', 'before' => '1 year ago' ) ),
		) );
		$dated = array();
		foreach ( get_posts( array( 'posts_per_page' => -1 ) ) as $p ) {
			if ( preg_match_all( '/(20\d\d)/', $p->post_title, $m ) && max( array_map( 'intval', $m[1] ) ) < $year ) {
				$dated[] = $p;
			}
		}
		$list = function ( $items, $empty ) {
			if ( ! $items ) {
				return '<p>' . esc_html( $empty ) . '</p>';
			}
			$html = '<ul>';
			foreach ( $items as $p ) {
				$html .= sprintf(
					'<li><a href="%1$s">%2$s</a> <span style="color:#8a93a3">· %3$s 수정</span></li>',
					esc_url( get_edit_post_link( $p->ID ) ),
					esc_html( get_the_title( $p ) ),
					esc_html( get_the_modified_date( 'Y.m.d', $p ) )
				);
			}
			return $html . '</ul>';
		};
		echo '<p><strong>1년 넘게 수정하지 않은 글</strong> (오래된 순)</p>' . $list( $old, '없습니다.' ); // phpcs:ignore
		echo '<p><strong>제목에 지난 연도가 들어간 글</strong></p>' . $list( $dated, '없습니다.' ); // phpcs:ignore
		// 공식 서식 페이지(/forms/)에 올린 한글 파일: 6개월마다 최신 양식인지 확인
		$forms = get_post( 15016 );
		if ( $forms && strtotime( $forms->post_modified ) < strtotime( '-6 months' ) ) {
			printf(
				'<p><strong>공식 서식 점검</strong></p><p>서식 페이지를 6개월 넘게 고치지 않았습니다(%1$s). 표의 공식 출처에서 새 양식이 나왔는지 확인하고, 바뀌었으면 파일을 교체한 뒤 기준일을 고쳐 업데이트하세요. <a href="%2$s">서식 페이지 편집</a></p>',
				esc_html( get_the_modified_date( 'Y.m.d', $forms ) ),
				esc_url( get_edit_post_link( $forms->ID ) )
			);
		}
		echo '<p style="color:#8a93a3">내용을 확인해 최신 정보로 고친 뒤 업데이트하면 목록에서 빠집니다.</p>';
	} );
} );

// 13-5·13-6·13-7 스크립트: 모든 페이지 공통(작은 크기). nowprocket = WP Rocket 지연 로딩 제외
add_action( 'wp_footer', function () {
	$terms = is_singular( 'post' ) ? eb_glossary() : array();
	printf(
		"<script nowprocket>window.ebGlossary=%s;window.ebGlossaryUrl=%s;</script>\n",
		wp_json_encode( $terms ),
		wp_json_encode( home_url( '/glossary/' ) )
	);
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function store(k, v) { try { if (v === undefined) { return JSON.parse(localStorage.getItem(k) || '[]'); } localStorage.setItem(k, JSON.stringify(v)); } catch (e) { return []; } }

	// 최근 본 글
	function recent() {
		var list = store('eb_recent') || [], here = location.origin + location.pathname;
		var title = document.querySelector('body.single-post .entry-title');
		if (title) {
			list = list.filter(function (x) { return x.u !== here; });
			list.unshift({ u: here, t: title.textContent.trim() });
			store('eb_recent', list.slice(0, 8));
		}
		document.querySelectorAll('.eb-recentview').forEach(function (box) {
			var items = list.filter(function (x) { return x.u !== here; }).slice(0, 5);
			if (!items.length) { return; }
			box.querySelector('ul').innerHTML = items.map(function (x) { return '<li><a href="' + esc(x.u) + '">' + esc(x.t) + '</a></li>'; }).join('');
			box.hidden = false;
			var w = box.closest('.widget'); if (w) { w.classList.add('has-recent'); }
		});
	}

	// 맞춤 지원금 찾기
	function finder(el) {
		var d = JSON.parse(el.getAttribute('data-set')), f = el.querySelector('form'), out = el.querySelector('.eb-finder__result');
		function rules() {
			var r = [];
			['age', 'case'].forEach(function (g) {
				f.querySelectorAll('input[name="' + g + '"]:checked').forEach(function (i) {
					var o = d.options[g][2][i.value];
					if (o && (o[1].length || o[2])) { r.push({ label: o[0], cats: o[1], re: o[2] ? new RegExp(o[2]) : null, calcs: o[3] || [] }); }
				});
			});
			return r;
		}
		function run() {
			var r = rules();
			if (!r.length) { try { localStorage.removeItem('eb_finder_last'); } catch (e) {} out.innerHTML = '<p class="eb-finder__hint">나이나 상황을 하나 이상 고르면 이지복지닷컴에 정리된 관련 정보를 바로 모아 드립니다.</p>'; return; }
			var list = d.posts.map(function (p) {
				var s = 0;
				r.forEach(function (x) { if ((x.re && x.re.test(p.t)) || p.c.some(function (c) { return x.cats.indexOf(c) > -1; })) { s++; } });
				return { p: p, s: s };
			}).filter(function (x) { return x.s > 0; }).sort(function (a, b) { return b.s - a.s; });
			// 고른 조건에 맞는 계산기를 먼저, 그다음 결과 글 제목과 관련된 계산기
			var picked = [];
			r.forEach(function (x) { x.calcs.forEach(function (k) { if (d.calcs[k] && picked.indexOf(k) < 0) { picked.push(k); } }); });
			var calcs = picked.concat(Object.keys(d.calcs).filter(function (k) { return picked.indexOf(k) < 0 && list.slice(0, 12).some(function (x) { return new RegExp(d.calcs[k][2]).test(x.p.t); }); })).slice(0, 3);
			var h = '<p class="eb-finder__count">관련 정보 <strong>' + list.length + '개</strong>를 찾았어요' + (r.length > 1 ? ' <small>여러 조건에 겹치는 글이 먼저 나옵니다</small>' : '') + '</p>';
			h += '<ul class="eb-finder__list">' + list.slice(0, 12).map(function (x) {
				return '<li><span class="eb-finder__cat">' + esc(x.p.n) + '</span><a href="' + esc(x.p.u) + '">' + esc(x.p.t) + '</a>' + (x.s > 1 ? '<em>조건 ' + x.s + '개 해당</em>' : '') + '</li>';
			}).join('') + '</ul>';
			if (list.length > 12) { h += '<p class="eb-finder__more">조건을 더 골라 범위를 좁혀 보세요.</p>'; }
			if (calcs.length) {
				h += '<p class="eb-finder__sub">함께 쓰면 좋은 계산기</p><div class="eb-finder__calcs">' + calcs.map(function (k) { return '<a href="' + esc(d.calcs[k][0]) + '">' + esc(d.calcs[k][1]) + ' →</a>'; }).join('') + '</div>';
			}
			out.innerHTML = h;
			// 고른 조건·결과 수를 이 기기에 기억 → 홈 '내 맞춤' 줄·다음에 열 때 조건 그대로 (2026-10-09)
			try {
				var k = [].map.call(f.querySelectorAll('input:checked'), function (i) { return i.name + ':' + i.value; });
				localStorage.setItem('eb_finder_last', JSON.stringify({ k: k, l: r.map(function (x) { return x.label; }), n: list.length, at: Date.now() }));
			} catch (e) {}
		}
		// 지난번 고른 조건 다시 체크(아무것도 안 골라져 있을 때만)
		try {
			var last = JSON.parse(localStorage.getItem('eb_finder_last') || 'null');
			if (last && last.k && !f.querySelector('input:checked:not([value="any"])')) {
				last.k.forEach(function (s) { var p = s.split(':'), i = f.querySelector('input[name="' + p[0] + '"][value="' + p[1] + '"]'); if (i) { i.checked = true; } });
			}
		} catch (e) {}
		// 선택 지우기: '상관없음'만 남기고 기억도 지움(run()이 조건 없으면 eb_finder_last 삭제)
		var rs = el.querySelector('.eb-finder__reset');
		if (rs) { rs.addEventListener('click', function () { f.querySelectorAll('input').forEach(function (i) { i.checked = i.value === 'any'; }); run(); }); }
		f.addEventListener('change', run);
		run();
	}

	// 글 속 용어 설명
	function glossary() {
		var terms = window.ebGlossary || {}, keys = Object.keys(terms).sort(function (a, b) { return b.length - a.length; });
		var root = document.querySelector('body.single-post .entry-content');
		if (!root || !keys.length) { return; }
		var used = {}, tip = document.createElement('div');
		tip.className = 'eb-tip'; tip.hidden = true; tip.setAttribute('role', 'tooltip'); tip.id = 'eb-tip';
		document.body.appendChild(tip);
		root.querySelectorAll('p, li, td').forEach(function (block) {
			if (block.closest('a, h2, h3, h4, .eb-calc, .eb-inline-related, .eb-postcalc, nav, .tocer, aside')) { return; }
			var walker = document.createTreeWalker(block, NodeFilter.SHOW_TEXT), nodes = [], n;
			while ((n = walker.nextNode())) { if (!n.parentNode.closest('a, .eb-term')) { nodes.push(n); } }
			nodes.forEach(function (node) {
				keys.forEach(function (k) {
					if (used[k] || !node.parentNode) { return; }
					var i = node.nodeValue.indexOf(k);
					if (i < 0) { return; }
					used[k] = true;
					var after = node.splitText(i), rest = after.splitText(k.length);
					var span = document.createElement('span');
					span.className = 'eb-term'; span.tabIndex = 0; span.textContent = k; span.setAttribute('data-term', k);
					span.setAttribute('aria-describedby', 'eb-tip');
					after.parentNode.replaceChild(span, after);
					node = rest;
				});
			});
		});
		function show(t) {
			var k = t.getAttribute('data-term');
			tip.innerHTML = '<strong>' + esc(k) + '</strong><span>' + esc(terms[k]) + '</span><a href="' + esc(window.ebGlossaryUrl) + '">용어사전 전체 보기 →</a>';
			tip.hidden = false;
			var r = t.getBoundingClientRect(), w = Math.min(320, window.innerWidth - 24);
			tip.style.width = w + 'px';
			tip.style.left = Math.max(12, Math.min(r.left + window.scrollX, window.scrollX + window.innerWidth - w - 12)) + 'px';
			tip.style.top = (r.bottom + window.scrollY + 8) + 'px';
		}
		document.addEventListener('click', function (e) {
			var t = e.target.closest('.eb-term');
			if (t) { show(t); } else if (!e.target.closest('.eb-tip')) { tip.hidden = true; }
		});
		document.addEventListener('mouseover', function (e) { var t = e.target.closest && e.target.closest('.eb-term'); if (t) { show(t); } });
		document.addEventListener('focusin', function (e) { var t = e.target.closest && e.target.closest('.eb-term'); if (t) { show(t); } });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { tip.hidden = true; } });
	}

	function start() {
		recent();
		document.querySelectorAll('.eb-finder').forEach(finder);
		glossary();
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', start); } else { start(); }
})();
JS
	. "\n</script>\n";
}, 40 );

/* 14. TablePress ----------------------------------------------------------------
 * - TablePress 기본 CSS는 끄고 style.css 8번 표 스타일만 사용합니다.
 * - 20줄 이상인 긴 표에는 표 위에 검색창을 자동으로 붙입니다(합쳐진 칸이 있어도 동작).
 */
add_filter( 'tablepress_use_default_css', '__return_false' );

// 표 정리: TablePress 표는 eb-tscroll 상자로 감싸기(넓으면 상자 안에서 옆으로), 숫자만 있는 열은 eb-num(오른쪽 정렬), 합쳐진 칸이 있는 표는 eb-has-span (style.css 8번)
add_action( 'wp_footer', function () {
	if ( ! is_singular() ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var NUM = /^[\s\d,.%~+\-−()·약최대최소월연일주년개명회세원만천억백시간분이하상미만초과까지부터]*\d[\s\d,.%~+\-−()·약최대최소월연일주년개명회세원만천억백시간분이하상미만초과까지부터]*$/;
	document.querySelectorAll('.entry-content table.tablepress, .entry-content .wp-block-table table').forEach(function (t) {
		if (t.classList.contains('tablepress') && !t.parentElement.classList.contains('eb-tscroll')) {
			var box = document.createElement('div');
			box.className = 'eb-tscroll';
			t.parentNode.insertBefore(box, t);
			box.appendChild(t);
		}
		if (t.querySelector('[rowspan]:not([rowspan="1"]), [colspan]:not([colspan="1"])')) { t.classList.add('eb-has-span'); return; }
		var rows = Array.prototype.slice.call(t.tBodies.length ? t.tBodies[0].rows : t.rows);
		if (rows.length < 2) { return; }
		var cols = rows[0].cells.length;
		for (var c = 1; c < cols; c++) {
			var cells = rows.map(function (r) { return r.cells[c]; }).filter(function (td) { return td && td.textContent.trim() !== ''; });
			if (cells.length < 2 || !cells.every(function (td) { return td.textContent.trim().length <= 24 && NUM.test(td.textContent.trim()); })) { continue; }
			cells.forEach(function (td) { td.classList.add('eb-num'); });
			if (t.tHead && t.tHead.rows[0] && t.tHead.rows[0].cells[c]) { t.tHead.rows[0].cells[c].classList.add('eb-num'); }
		}
	});
})();
JS
	. "\n</script>\n";
}, 45 );

// 글 속 링크 정리: '> ○○ 신청하기'처럼 기호로 시작하는 링크 한 줄은 eb-cta-p(작은 버튼),
// 링크만 모아 둔 목록은 eb-linklist(줄 단위 목록) (style.css 6번 링크)
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var root = document.querySelector('.entry-content');
	if (!root) { return; }
	var MARK = /^\s*(>|▶|►|☞|👉|→)\s*/;
	root.querySelectorAll('p').forEach(function (p) {
		var links = p.querySelectorAll('a');
		if (links.length !== 1 || !MARK.test(p.textContent)) { return; }
		var rest = p.textContent.replace(MARK, '').trim();
		if (rest !== links[0].textContent.trim()) { return; }
		// 앞의 기호 글자만 지우기(링크·굵게 표시는 그대로)
		var walker = document.createTreeWalker(p, NodeFilter.SHOW_TEXT), n;
		while ((n = walker.nextNode())) {
			if (n.nodeValue.trim() === '') { continue; }
			if (!links[0].contains(n)) { n.nodeValue = n.nodeValue.replace(MARK, ''); }
			break;
		}
		p.classList.add('eb-cta-p');
	});
	root.querySelectorAll('ul').forEach(function (ul) {
		if (ul.className && ul.className !== 'wp-block-list') { return; }
		var items = Array.prototype.filter.call(ul.children, function (li) { return li.tagName === 'LI'; });
		if (items.length < 2) { return; }
		var ok = items.every(function (li) {
			var a = li.querySelectorAll('a');
			return a.length === 1 && li.children.length === 1 && li.textContent.trim() === a[0].textContent.trim();
		});
		if (ok) { ul.classList.add('eb-linklist'); }
	});
})();
JS
	. "\n</script>\n";
}, 46 );

add_action( 'wp_footer', function () {
	if ( ! is_singular() ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	function norm(s) { return s.replace(/\s+/g, '').toLowerCase(); }
	// 합쳐진 칸(rowspan)을 줄마다 복사해 각 줄을 따로 걸러낼 수 있게 합니다.
	function expand(tbody) {
		var pend = {};
		Array.prototype.forEach.call(tbody.rows, function (row) {
			var cells = Array.prototype.slice.call(row.cells), c = 0, i = 0;
			while (i < cells.length || pend[c]) {
				if (pend[c]) {
					var copy = pend[c].cell.cloneNode(true);
					row.insertBefore(copy, cells[i] || null);
					if (--pend[c].left === 0) { delete pend[c]; }
					c += copy.colSpan || 1;
					continue;
				}
				var cell = cells[i++];
				if (cell.rowSpan > 1) { pend[c] = { cell: cell, left: cell.rowSpan - 1 }; cell.removeAttribute('rowspan'); }
				c += cell.colSpan || 1;
			}
		});
	}
	function init() {
		document.querySelectorAll('.entry-content table.tablepress').forEach(function (t) {
			var tb = t.tBodies[0];
			if (!tb || tb.rows.length < 20) { return; }
			var original = tb.cloneNode(true), expanded = null, total = tb.rows.length;
			var box = document.createElement('div');
			box.className = 'eb-tsearch';
			box.innerHTML = '<label class="eb-tsearch__field"><span class="screen-reader-text">표에서 찾기</span><input type="search" placeholder="표에서 찾기 (예: 지역·이름)"></label><span class="eb-tsearch__count">전체 ' + total + '개</span>';
			t.parentNode.insertBefore(box, t);
			var input = box.querySelector('input'), count = box.querySelector('.eb-tsearch__count');
			input.addEventListener('input', function () {
				var q = norm(input.value);
				if (!q) {
					if (expanded) { t.replaceChild(original.cloneNode(true), t.tBodies[0]); expanded = null; }
					count.textContent = '전체 ' + total + '개';
					return;
				}
				if (!expanded) { expanded = original.cloneNode(true); expand(expanded); t.replaceChild(expanded, t.tBodies[0]); }
				var n = 0;
				Array.prototype.forEach.call(expanded.rows, function (r) {
					var ok = norm(r.textContent).indexOf(q) > -1;
					r.hidden = !ok;
					if (ok) { n++; }
				});
				count.textContent = n ? n + '개 찾음 / 전체 ' + total + '개' : '찾는 내용이 없습니다';
			});
		});
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); } else { init(); }
})();
JS
	. "\n</script>\n";
}, 45 );

/* 15. 글 읽는 경험 ---------------------------------------------------------------
 * 15-1 (핵심 요약 박스는 삭제) 관리자 REST 요청에 eb_keep_modified=1을 붙이면 최종 수정일 유지
 * 15-2 "이 글이 도움이 되었나요?" 버튼: 결과는 글 목록의 "도움" 칸에서 확인합니다.
 * 15-3 읽기 진행 막대(화면 맨 위 얇은 막대)
 */
// 관리자가 본문 외 정보만 고칠 때 최종 수정일이 바뀌지 않도록(REST 요청에 eb_keep_modified=1)
add_filter( 'wp_insert_post_data', function ( $data, $postarr ) {
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST && ! empty( $_GET['eb_keep_modified'] ) && ! empty( $postarr['ID'] ) && current_user_can( 'edit_post', $postarr['ID'] ) ) { // phpcs:ignore
		$old                       = get_post( $postarr['ID'] );
		$data['post_modified']     = $old->post_modified;
		$data['post_modified_gmt'] = $old->post_modified_gmt;
	}
	return $data;
}, 99, 2 );

// 15-2 도움이 되었나요?
add_action( 'generate_after_entry_content', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	// 공유 줄 + "이지복지 돕는 방법" 링크(/support/ 페이지가 공개된 경우에만 표시)
	$support = get_page_by_path( 'support' );
	$cheer   = $support && 'publish' === $support->post_status ? '<a class="eb-share__support" href="' . esc_url( get_permalink( $support ) ) . '">이지복지닷컴 돕는 방법 →</a>' : '';
	$share   = '<div class="eb-share"><span class="eb-share__label">도움이 됐다면 필요한 분께 알려 주세요</span><div class="eb-share__btns"><button type="button" class="eb-share__btn" data-share hidden>카톡·문자로 공유</button><button type="button" class="eb-share__btn" data-copy>링크 복사</button></div>' . $cheer . '</div>';
	printf(
		'<div class="eb-feedback" data-post="%1$d"><p class="eb-feedback__q">이 글이 도움이 되었나요?</p><div class="eb-feedback__btns"><button type="button" data-v="yes">도움이 됐어요</button><button type="button" data-v="no">아쉬워요</button></div><p class="eb-feedback__msg" hidden></p>%2$s</div>',
		get_the_ID(),
		$share // phpcs:ignore
	);
}, 3 );

function eb_feedback_vote() {
	$post_id = isset( $_POST['post'] ) ? absint( $_POST['post'] ) : 0; // phpcs:ignore
	$vote    = isset( $_POST['v'] ) && 'no' === $_POST['v'] ? 'no' : 'yes'; // phpcs:ignore
	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) || 'post' !== get_post_type( $post_id ) ) {
		wp_send_json_error();
	}
	$key = 'eb_fb_' . md5( ( $_SERVER['REMOTE_ADDR'] ?? '' ) . '|' . $post_id ); // phpcs:ignore
	if ( get_transient( $key ) ) {
		wp_send_json_success( array( 'dup' => true ) );
	}
	set_transient( $key, 1, DAY_IN_SECONDS );
	$meta = '_eb_fb_' . $vote;
	update_post_meta( $post_id, $meta, (int) get_post_meta( $post_id, $meta, true ) + 1 );
	wp_send_json_success();
}
add_action( 'wp_ajax_eb_feedback', 'eb_feedback_vote' );
add_action( 'wp_ajax_nopriv_eb_feedback', 'eb_feedback_vote' );

add_filter( 'manage_post_posts_columns', function ( $cols ) {
	$cols['eb_fb'] = '도움 됨 / 아쉬움';
	return $cols;
} );
add_action( 'manage_post_posts_custom_column', function ( $col, $post_id ) {
	if ( 'eb_fb' === $col ) {
		printf( '%d / %d', (int) get_post_meta( $post_id, '_eb_fb_yes', true ), (int) get_post_meta( $post_id, '_eb_fb_no', true ) );
	}
}, 10, 2 );

// 15-2·15-3 스크립트
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	printf( "<div class=\"eb-progress\" aria-hidden=\"true\"><span></span></div>\n<script nowprocket>window.ebAjax=%s;window.ebContact=%s;</script>\n", wp_json_encode( admin_url( 'admin-ajax.php' ) ), wp_json_encode( home_url( '/contact/' ) ) );
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	// 읽기 진행 막대
	var bar = document.querySelector('.eb-progress span'), body = document.querySelector('.entry-content'), ticking = false;
	function update() {
		ticking = false;
		if (!bar || !body) { return; }
		var r = body.getBoundingClientRect(), total = r.height - window.innerHeight * 0.6;
		var p = total > 0 ? Math.min(1, Math.max(0, -r.top / total)) : 1;
		bar.style.transform = 'scaleX(' + p + ')';
	}
	window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
	update();

	// 도움이 되었나요?
	document.querySelectorAll('.eb-feedback').forEach(function (box) {
		var id = box.getAttribute('data-post'), key = 'eb_fb_' + id, msg = box.querySelector('.eb-feedback__msg');
		function done(v) {
			box.classList.add('is-done');
			msg.hidden = false;
			msg.innerHTML = v === 'no'
				? '의견 고맙습니다. 어떤 점이 부족했는지 <a href="' + window.ebContact + '">문의하기</a>로 알려 주시면 글을 고칠 때 반영할게요.'
				: '고맙습니다! 더 정확한 정보로 계속 업데이트할게요.';
		}
		try { var saved = localStorage.getItem(key); if (saved) { done(saved); return; } } catch (e) {}
		box.querySelectorAll('button').forEach(function (b) {
			b.addEventListener('click', function () {
				var v = b.getAttribute('data-v'), fd = new FormData();
				fd.append('action', 'eb_feedback'); fd.append('post', id); fd.append('v', v);
				fetch(window.ebAjax, { method: 'POST', body: fd, credentials: 'same-origin' }).catch(function () {});
				try { localStorage.setItem(key, v); } catch (e) {}
				done(v);
			});
		});
	});

	// 공유하기(휴대폰 공유 창: 카톡·문자 등) · 링크 복사. 주소는 짧은 ?p=번호 형식
	document.querySelectorAll('.eb-share').forEach(function (box) {
		var fb = box.closest('.eb-feedback'), url = location.origin + '/?p=' + (fb ? fb.getAttribute('data-post') : '');
		var h1 = document.querySelector('.entry-title'), title = h1 ? h1.textContent.trim() : document.title;
		var share = box.querySelector('[data-share]'), copy = box.querySelector('[data-copy]');
		if (navigator.share) { share.hidden = false; }
		share.addEventListener('click', function () { navigator.share({ title: title, text: title, url: url }).catch(function () {}); });
		copy.addEventListener('click', function () {
			function ok() { copy.textContent = '✓ 복사했어요'; setTimeout(function () { copy.textContent = '링크 복사'; }, 2000); }
			function manual() {
				var ta = document.createElement('textarea'), done = false;
				ta.value = url; ta.setAttribute('readonly', ''); ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
				document.body.appendChild(ta); ta.select();
				try { done = document.execCommand('copy'); } catch (e) {}
				document.body.removeChild(ta);
				if (done) { ok(); } else { window.prompt('아래 주소를 복사해 주세요', url); }
			}
			if (navigator.clipboard) { navigator.clipboard.writeText(url).then(ok, manual); } else { manual(); }
		});
	});
})();
JS
	. "\n</script>\n";
}, 50 );

/* 16. 검색 --------------------------------------------------------------------
 * 16-1 검색창 추천어: 글자를 치는 동안 글·계산기·가이드 제목을 바로 추천(모든 검색창)
 *      목록 주소: /wp-json/eb/v1/search-index (12시간 캐시, 글·페이지를 저장하면 새로 만듦)
 * 16-2 검색 결과에서 약관·방침 페이지는 제외
 */
function eb_search_excluded_slugs() {
	return array( 'privacy-policy', 'terms-of-service', 'disclaimer', 'home', 'saved' );
}

function eb_search_index() {
	$data = get_transient( 'eb_search_index_v2' );
	if ( false !== $data ) {
		return $data;
	}
	$data = array();
	foreach ( get_posts( array( 'post_type' => array( 'post', 'page' ), 'posts_per_page' => -1, 'post_status' => 'publish', 'no_found_rows' => true ) ) as $p ) {
		if ( in_array( $p->post_name, eb_search_excluded_slugs(), true ) ) {
			continue;
		}
		if ( 'post' === $p->post_type ) {
			$cats  = get_the_category( $p->ID );
			$label = $cats ? $cats[0]->name : '정보';
		} else {
			$uri   = get_page_uri( $p );
			$label = 0 === strpos( $uri, 'calculator' ) ? '계산기' : ( 0 === strpos( $uri, 'guide' ) ? '가이드' : '안내' );
		}
		$data[] = array(
			't' => html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' ),
			'u' => get_permalink( $p ),
			'l' => $label,
		);
	}
	// 2026-10-09 개선안 5번: 용어사전(13-7) + 복지로 중앙부처 서비스(54번)도 추천에(복지로는 새 창)
	if ( function_exists( 'eb_glossary' ) ) {
		foreach ( eb_glossary() as $term => $desc ) {
			$data[] = array( 't' => $term, 'u' => home_url( '/glossary/#term-' . md5( $term ) ), 'l' => '용어' );
		}
	}
	foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
		if ( ! empty( $s['name'] ) && ! empty( $s['link'] ) && 0 === strpos( (string) $s['link'], 'http' ) ) {
			$data[] = array( 't' => $s['name'], 'u' => $s['link'], 'l' => '복지로', 'o' => (string) $s['org'] );
		}
	}
	set_transient( 'eb_search_index_v2', $data, 12 * HOUR_IN_SECONDS );
	return $data;
}

add_action( 'save_post', function () {
	delete_transient( 'eb_search_index_v2' );
} );
add_action( 'update_option_eb_ws_synced', function () {
	delete_transient( 'eb_search_index_v2' );
} );
// 검색어 비교용: 띄어쓰기·가운뎃점·괄호 등을 빼고 소문자로 ('근로·자녀장려금' = '근로자녀장려금')
function eb_search_norm( $s ) {
	return mb_strtolower( preg_replace( '/[\s·ㆍ・.,\-_\/()\[\]\'"“”‘’]+/u', '', (string) $s ) );
}
// 검색어 + 비슷한 말(정규화)
function eb_search_alts( $q ) {
	$n   = eb_search_norm( $q );
	$out = array( $n );
	foreach ( eb_search_synonyms() as $k => $v ) {
		if ( eb_search_norm( $k ) === $n ) {
			$out = array_merge( $out, array_map( 'eb_search_norm', $v ) );
		}
	}
	return array_values( array_unique( array_filter( $out ) ) );
}
// 검색 결과: 복지로 중앙부처 서비스 중 이름이 맞는 것(최대 5개)
function eb_search_gov_html( $q ) {
	$alts = eb_search_alts( $q );
	if ( ! $alts || mb_strlen( $alts[0] ) < 2 ) {
		return '';
	}
	$hit = array();
	foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
		$n = eb_search_norm( isset( $s['name'] ) ? $s['name'] : '' );
		foreach ( $alts as $a ) {
			if ( '' !== $n && false !== mb_strpos( $n, $a ) ) {
				$hit[] = array( mb_strpos( $n, $a ), $s );
				break;
			}
		}
	}
	if ( ! $hit ) {
		return '';
	}
	usort( $hit, function ( $a, $b ) {
		return $a[0] - $b[0];
	} );
	$li = '';
	foreach ( array_slice( $hit, 0, 5 ) as $h ) {
		$s   = $h[1];
		$li .= '<li><a href="' . esc_url( $s['link'] ) . '" target="_blank" rel="noopener"><span class="eb-gov__t"><strong>' . esc_html( $s['name'] ) . '</strong><small>' . esc_html( $s['org'] ) . '</small></span>' . ( ! empty( $s['sum'] ) ? '<span class="eb-gov__s">' . esc_html( wp_trim_words( wp_strip_all_tags( $s['sum'] ), 22, '…' ) ) . '</span>' : '' ) . '<span class="eb-gov__go">복지로에서 자세히<span class="screen-reader-text">(새 창)</span> ↗</span></a></li>';
	}
	return '<section class="eb-gov"><p class="eb-boardtools__label">복지로 정부 서비스 <b>' . count( $hit ) . '</b></p><ul>' . $li . '</ul></section>';
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/search-index', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			return rest_ensure_response( eb_search_index() );
		},
	) );
} );

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}
	$ids = array();
	foreach ( eb_search_excluded_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$ids[] = $page->ID;
		}
	}
	if ( $ids ) {
		$query->set( 'post__not_in', $ids );
	}
	// 목록·글 수는 글만. 계산기·서식 같은 페이지는 34번 eb_search_tools_html()이 위에 따로 보여 줌
	$query->set( 'post_type', 'post' );
} );

/**
 * 검색 추천 상자의 '비슷한 말': 사람들이 흔히 쓰는 말(왼쪽) → 글 제목에 쓰는 말(오른쪽).
 * 왼쪽 말을 입력하면 오른쪽 말이 들어간 제목도 함께 보여 줌(띄어쓰기 무시). 추천 상자에만 적용, Enter 검색 결과는 그대로.
 */
function eb_search_synonyms() {
	return array(
		'실업수당'     => array( '실업급여' ),
		'구직급여'     => array( '실업급여' ),
		'노령연금'     => array( '기초연금', '국민연금' ),
		'노인연금'     => array( '기초연금' ),
		'기초수급'     => array( '기초생활' ),
		'생계비'       => array( '생계급여' ),
		'최저시급'     => array( '최저임금' ),
		'퇴직수당'     => array( '퇴직금' ),
		'건보'         => array( '건강보험' ),
		'의료보험'     => array( '건강보험' ),
		'사대보험'     => array( '4대보험' ),
		'산재'         => array( '산업재해' ),
		'육아휴직수당' => array( '육아휴직' ),
		'출산지원금'   => array( '출산', '첫만남', '부모급여' ),
		'출산장려금'   => array( '출산', '첫만남' ),
		'양육수당'     => array( '부모급여' ),
		'노인'         => array( '어르신' ),
		'어르신'       => array( '노인' ),
		'실비'         => array( '실손' ),
		'청년수당'     => array( '청년' ),
		'긴급생계'     => array( '긴급복지' ),
		'주민등록등본' => array( '등본' ),
		'가족관계증명서' => array( '가족관계' ),
		// 2026-10-09: '결과 없던 검색어' 상위(근로장려금·육아휴직·부모급여)와 자주 쓰는 줄임말
		'근로장려금'   => array( '근로·자녀장려금', '근로장려' ),
		'근로장려'     => array( '근로·자녀장려금' ),
		'자녀장려금'   => array( '근로·자녀장려금' ),
		'장려금'       => array( '근로·자녀장려금' ),
		'육아휴직'     => array( '육아휴직급여', '육아휴직등', '모성보호' ),
		'부모급여'     => array( '영아수당', '양육수당' ),
		'출산휴가'     => array( '출산휴가급여', '출산전후휴가' ),
		'중위소득'     => array( '기준 중위소득' ),
		'에너지바우처' => array( '에너지' ),
		'국민내일배움카드' => array( '내일배움' ),
		// 2026-10-15: 정부 공식 이름(복지로)으로도 찾게 - 실업급여=구직급여, 폐업지원금=희망리턴패키지
		'실업급여'     => array( '구직급여' ),
		'폐업지원금'   => array( '희망리턴', '폐업' ),
	);
}

add_action( 'wp_footer', function () {
	printf( "<script nowprocket>window.ebSearchIndex=%s;window.ebSearchSyn=%s;</script>\n", wp_json_encode( rest_url( 'eb/v1/search-index' ) ), wp_json_encode( eb_search_synonyms(), JSON_UNESCAPED_UNICODE ) );
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var index = null, loading = null, syn = window.ebSearchSyn || {}, RK = 'eb_q';
	function norm(s) { return String(s).toLowerCase().replace(/[\s·ㆍ・.,\-_\/()\[\]'"“”‘’]+/g, ''); } // 가운뎃점·괄호도 무시(2026-10-09)
	// 입력한 말 + 비슷한 말(위 eb_search_synonyms)
	function alts(w) { return [norm(w)].concat((syn[norm(w)] || []).map(norm)); }
	function pos(x, w) { var p = alts(w).map(function (a) { return x.n.indexOf(a); }).filter(function (i) { return i > -1; }); return p.length ? Math.min.apply(null, p) : -1; }
	// 최근 검색어: 이 기기(브라우저)에만 5개까지 저장, 하나씩 또는 전체 삭제 가능
	function getRecent() { try { return JSON.parse(localStorage.getItem(RK)) || []; } catch (e) { return []; } }
	function setRecent(a) { try { if (a.length) { localStorage.setItem(RK, JSON.stringify(a)); } else { localStorage.removeItem(RK); } } catch (e) {} }
	function remember(q) {
		q = String(q).trim();
		if (!q || q.length > 40) { return; }
		setRecent([q].concat(getRecent().filter(function (x) { return x !== q; })).slice(0, 5));
	}
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function load() {
		if (index) { return Promise.resolve(index); }
		if (!loading) {
			loading = fetch(window.ebSearchIndex).then(function (r) { return r.json(); }).then(function (d) {
				index = d.map(function (x) { return { t: x.t, u: x.u, l: x.l, o: x.o || '', n: norm(x.t) }; });
				return index;
			}).catch(function () { index = []; return index; });
		}
		return loading;
	}
	function mark(title, words) {
		var out = esc(title);
		words.forEach(function (w) {
			if (w.length < 1) { return; }
			var re = new RegExp('(' + esc(w).replace(/[.*+?^$(){}|[\]\\]/g, '\\$&') + ')', 'gi');
			out = out.replace(re, '<mark>$1</mark>');
		});
		return out;
	}
	function attach(input) {
		var form = input.form;
		if (!form || input.getAttribute('data-eb-suggest')) { return; }
		input.setAttribute('data-eb-suggest', '1');
		input.setAttribute('autocomplete', 'off');
		form.classList.add('eb-suggest-host');
		var box = document.createElement('div'), active = -1;
		box.className = 'eb-suggest';
		box.hidden = true;
		form.appendChild(box);
		function hide() { box.hidden = true; active = -1; }
		// (옛 휴대폰 옆 메뉴 검색칸의 ✕ 지우기 버튼은 2026-10-16 삭제 - 68번 전체 메뉴가 따로 가짐)
		var base = form.getAttribute('action') || '/';
		function searchUrl(q) { return base + '?s=' + encodeURIComponent(q); }
		// 검색칸이 비어 있을 때: 최근 검색어(없으면 상자 안 띄움)
		function showRecent() {
			if (input.closest('.ebt-s')) { hide(); return; } // 휴대폰 검색 창은 창 안에 최근 검색어 칩(2026-10-09)
			var a = getRecent();
			if (!a.length) { hide(); return; }
			box.innerHTML = '<div class="eb-suggest__head"><span>최근 검색어</span><button type="button" class="eb-suggest__clear-all">전체 삭제</button></div>'
				+ a.map(function (q) { return '<div class="eb-suggest__recent"><a class="eb-suggest__item eb-suggest__item--recent" href="' + esc(searchUrl(q)) + '"><span class="eb-suggest__ic eb-suggest__ic--clock" aria-hidden="true"></span><span class="eb-suggest__title">' + esc(q) + '</span></a><button type="button" class="eb-suggest__del" data-q="' + esc(q) + '" aria-label="최근 검색어 ' + esc(q) + ' 삭제"></button></div>'; }).join('');
			box.hidden = false;
			active = -1;
		}
		function render() {
			var q = input.value.trim();
			if (!q) { showRecent(); return; }
			var words = q.toLowerCase().split(/\s+/).filter(Boolean);
			// 종류 순서: 계산기 → 가이드 → 글·안내 → 용어 → 복지로(2026-10-09). 같은 종류 안에서는 앞쪽에 맞는 것 먼저
			var W = { '계산기': 0, '가이드': 1, '용어': 3, '복지로': 4 };
			var wt = function (x) { return x.l in W ? W[x.l] : 2; };
			var found = index.filter(function (x) { return words.every(function (w) { return pos(x, w) > -1; }); })
				.sort(function (a, b) { return ((pos(a, words[0]) === 0 ? 0 : 1) - (pos(b, words[0]) === 0 ? 0 : 1)) || (wt(a) - wt(b)) || (pos(a, words[0]) - pos(b, words[0])) || (a.t.length - b.t.length); });
			// 휴대폰 5개(전체 화면 검색 창은 8개)·PC 7개까지(나머지는 맨 아래 '검색 결과 모두 보기')
			var list = found.slice(0, input.closest('.ebt-s') ? 8 : (window.matchMedia('(max-width: 768px)').matches ? 5 : 7));
			var marks = [].concat.apply([], words.map(function (w) { return [w].concat(syn[norm(w)] || []); }));
			box.innerHTML = (list.length
				? '<div class="eb-suggest__head"><span>추천<b>' + found.length + '</b></span></div>'
					+ list.map(function (x) { var ext = x.l === '복지로'; return '<a class="eb-suggest__item' + (ext ? ' is-gov' : '') + '" href="' + esc(x.u) + '"' + (ext ? ' target="_blank" rel="noopener"' : '') + '><span class="eb-suggest__ic' + (x.l === '계산기' ? ' eb-suggest__ic--calc' : x.l === '가이드' ? ' eb-suggest__ic--guide' : x.l === '복지로' ? ' eb-suggest__ic--gov' : x.l === '용어' ? ' eb-suggest__ic--term' : '') + '" aria-hidden="true"></span><span class="eb-suggest__body"><span class="eb-suggest__label">' + esc(x.l) + (x.o ? ' · ' + esc(x.o) : '') + '</span><span class="eb-suggest__title">' + mark(x.t, marks) + (ext ? '<span class="screen-reader-text">(새 창)</span>' : '') + '</span></span></a>'; }).join('')
				: '<p class="eb-suggest__empty">제목이 맞는 글은 없어요. 글 내용까지 찾아볼게요.</p>')
				+ '<a class="eb-suggest__all" href="' + esc(searchUrl(q)) + '"><span>‘' + esc(q) + '’ 검색 결과 모두 보기</span><i aria-hidden="true"></i></a>';
			box.hidden = false;
			active = -1;
		}
		function itemQuery(a) { return a.classList.contains('eb-suggest__item--recent') ? a.textContent : input.value; }
		form.addEventListener('submit', function () { remember(input.value); });
		box.addEventListener('click', function (e) {
			var del = e.target.closest('.eb-suggest__del');
			if (del) {
				e.preventDefault();
				setRecent(getRecent().filter(function (x) { return x !== del.getAttribute('data-q'); }));
				showRecent();
				return;
			}
			if (e.target.closest('.eb-suggest__clear-all')) { e.preventDefault(); setRecent([]); hide(); return; }
			// 추천 글을 누를 땐 입력 중이던 글자('근' 등)를 남기지 않음(그 글은 '최근 본 글'에 남음). 최근 검색어·'검색 결과 모두 보기'만 기록
			var a = e.target.closest('a');
			if (a && (a.classList.contains('eb-suggest__item--recent') || a.classList.contains('eb-suggest__all'))) { remember(itemQuery(a)); }
		});
		input.addEventListener('focus', function () { load(); if (!input.value.trim()) { showRecent(); } });
		input.addEventListener('input', function () { load().then(render); });
		input.addEventListener('keydown', function (e) {
			if (box.hidden) { return; }
			var els = box.querySelectorAll('.eb-suggest__item');
			if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && els.length) {
				e.preventDefault();
				active = (active + (e.key === 'ArrowDown' ? 1 : -1) + els.length) % els.length;
				els.forEach(function (el, i) { el.classList.toggle('is-active', i === active); });
			} else if (e.key === 'Enter' && active > -1) {
				e.preventDefault();
				if (els[active].classList.contains('eb-suggest__item--recent')) { remember(itemQuery(els[active])); }
				location.href = els[active].href;
			} else if (e.key === 'Escape') {
				hide();
			}
		});
		// 상자 밖을 누르면 닫기 (최근 검색어 삭제로 방금 다시 그려져 문서에서 빠진 버튼은 상자 안으로 봄)
		document.addEventListener('click', function (e) { if (e.target.isConnected && !form.contains(e.target)) { hide(); } });
	}
	document.querySelectorAll('input[name="s"]').forEach(attach);
	document.addEventListener('focusin', function (e) { if (e.target.matches && e.target.matches('input[name="s"]')) { attach(e.target); load(); } });
})();
JS
	. "\n</script>\n";
}, 55 );

/* 17. 제안서 접수 폼 [eb_proposal_form] -------------------------------------------
 * 사이트가 직접 받음(2026-10-04, 예전 구글 폼 대신): 접수하면 ① 관리자 화면 '제안서' 메뉴에 저장 ② contact@로 메일(답장 = 보낸 분 주소).
 * 스팸 막기: 숨은 칸(사람은 못 봄) + 자바스크립트로만 보낼 수 있음 + 3초 안에 보내면 거절 + 같은 곳에서 10분에 3건까지 + 링크 4개 이상 거절.
 */
// 2026-10-16: 협업 페이지(71번) '어떤 협업을 생각하세요?' 4가지와 이름을 맞춤(예전 '비즈니스 광고' → '브랜디드·광고', 정책 홍보는 따로)
function eb_proposal_types() {
	return array(
		'공공 정책 홍보' => '지원사업 안내, 신청 기간 알림',
		'계산기·도구'   => '계산기 붙여 쓰기, 함께 만들기',
		'콘텐츠 제휴'   => '칼럼 기고, 연재, 자료 제공',
		'브랜디드·광고' => '서비스 소개, 배너 광고',
		'오류·개선 제안' => '내용 수정, 서비스 개선 의견',
		'기타 제안'     => '그 밖의 협업·프로젝트',
	);
}

// 콤팩트 폼(협업 페이지)에서 쓰는 짧은 이름
function eb_proposal_short( $type ) {
	$s = array( '공공 정책 홍보' => '공공 홍보', '계산기·도구' => '계산기', '콘텐츠 제휴' => '콘텐츠', '브랜디드·광고' => '광고', '오류·개선 제안' => '오류 제안', '기타 제안' => '기타' );
	return isset( $s[ $type ] ) ? $s[ $type ] : $type;
}

// 선택 항목(2026-10-04 추가): 희망 시작 시기·예산 범위. 비워 두면 '미정'
function eb_proposal_choices() {
	return array(
		'when'   => array( '가능한 빨리', '1개월 안', '1~3개월 안', '아직 미정' ),
		'budget' => array( '50만 원 미만', '50만~200만 원', '200만 원 이상', '협의 / 미정' ),
	);
}

add_action( 'init', function () {
	register_post_type( 'eb_proposal', array(
		'labels'          => array(
			'name'          => '제안서',
			'singular_name' => '제안서',
			'all_items'     => '받은 제안서',
			'edit_item'     => '제안서 보기',
			'search_items'  => '제안서 검색',
			'not_found'     => '받은 제안서가 없습니다.',
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => false,
		'menu_position'   => 26,
		'menu_icon'       => 'dashicons-email-alt',
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'page', // 편집자 이상만 봄
		'map_meta_cap'    => true,
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ), // 관리자 화면에서 새로 쓰기 없음
	) );
} );

add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/proposal', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'eb_proposal_receive',
	) );
} );

function eb_proposal_receive( WP_REST_Request $req ) {
	$no = function ( $msg ) {
		return new WP_REST_Response( array( 'ok' => false, 'msg' => $msg ), 400 );
	};
	// 숨은 칸에 무언가 있거나 너무 빨리 보낸 경우: 로봇으로 보고 조용히 성공처럼 응답
	if ( '' !== (string) $req->get_param( 'hp' ) || (int) $req->get_param( 'ms' ) < 3000 ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}
	$name  = sanitize_text_field( (string) $req->get_param( 'name' ) );
	$email = sanitize_email( (string) $req->get_param( 'email' ) );
	$type  = sanitize_text_field( (string) $req->get_param( 'type' ) );
	$body  = sanitize_textarea_field( (string) $req->get_param( 'body' ) );
	$site  = esc_url_raw( (string) $req->get_param( 'site' ), array( 'http', 'https' ) );
	$c     = eb_proposal_choices();
	$when  = in_array( (string) $req->get_param( 'when' ), $c['when'], true ) ? (string) $req->get_param( 'when' ) : '미정';
	$money = in_array( (string) $req->get_param( 'budget' ), $c['budget'], true ) ? (string) $req->get_param( 'budget' ) : '미정';
	if ( '' === $name || '' === $body || ! is_email( $email ) || ! array_key_exists( $type, eb_proposal_types() ) ) {
		return $no( '필수 항목을 다시 확인해 주세요.' );
	}
	if ( mb_strlen( $name ) > 100 || mb_strlen( $body ) > 5000 ) {
		return $no( '입력한 글자가 너무 깁니다.' );
	}
	if ( preg_match_all( '~https?://~i', $body ) >= 4 ) {
		return $no( '링크는 3개까지만 넣을 수 있어요.' );
	}
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : ''; // phpcs:ignore
	$key = 'eb_prop_' . md5( $ip );
	$cnt = (int) get_transient( $key );
	if ( $cnt >= 3 ) {
		return $no( '잠시 뒤 다시 보내 주세요.' );
	}
	set_transient( $key, $cnt + 1, 10 * MINUTE_IN_SECONDS );

	$info = "보낸 분: {$name}\n이메일: {$email}\n유형: {$type}\n웹사이트: " . ( $site ? $site : '-' ) . "\n희망 시작: {$when}\n예산: {$money}\n\n{$body}";
	$id   = wp_insert_post( array(
		'post_type'    => 'eb_proposal',
		'post_status'  => 'private',
		'post_title'   => '[' . $type . '] ' . $name,
		'post_content' => $info,
	) );
	if ( ! $id || is_wp_error( $id ) ) {
		return $no( '접수하지 못했습니다. 잠시 뒤 다시 시도해 주세요.' );
	}
	update_post_meta( $id, '_eb_email', $email );

	wp_mail(
		eb_contact_email(),
		'[이지복지닷컴 제안서] ' . $type . ' - ' . $name,
		$info . "\n\n---\n이 메일에 바로 답장하면 보낸 분에게 갑니다.\n관리자 화면: " . admin_url( 'post.php?post=' . $id . '&action=edit' ),
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);
	return new WP_REST_Response( array( 'ok' => true ), 200 );
}

function eb_proposal_select( $key, $label ) {
	$opts = '<option value="">선택 안 함</option>';
	foreach ( eb_proposal_choices()[ $key ] as $v ) {
		$opts .= '<option value="' . esc_attr( $v ) . '">' . esc_html( $v ) . '</option>';
	}
	return '<label class="eb-form__field"><span>' . esc_html( $label ) . ' <small>(선택)</small></span><select name="' . esc_attr( $key ) . '">' . $opts . '</select></label>';
}

// compact="1"(협업 페이지, 2026-10-16): 유형은 짧은 이름 칩 3×2, 웹사이트·시기·예산은 접어 두고, 동의 문구 전문은 '자세히'로
add_shortcode( 'eb_proposal_form', function ( $atts ) {
	$compact = ! empty( $atts['compact'] );
	$types   = '';
	foreach ( eb_proposal_types() as $value => $desc ) {
		$types .= $compact
			? sprintf( '<label class="eb-form__choice" title="%2$s"><input type="radio" name="type" value="%1$s" required><span><strong>%3$s</strong></span></label>', esc_attr( $value ), esc_attr( $desc ), esc_html( eb_proposal_short( $value ) ) )
			: sprintf( '<label class="eb-form__choice"><input type="radio" name="type" value="%1$s" required><span><strong>%1$s</strong><small>%2$s</small></span></label>', esc_attr( $value ), esc_html( $desc ) );
	}
	$GLOBALS['eb_form_used'] = true;
	$agree = '회신을 위해 이름(업체명)과 이메일을 수집하는 데 동의합니다. 접수 내용은 이지복지닷컴 관리 화면과 운영 메일함에 저장되며 문의 처리에만 사용하고, 처리 완료 후 6개월이 지나면 삭제합니다. <a href="/privacy-policy/">개인정보처리방침</a>';
	if ( $compact ) {
		return '<form class="eb-form is-compact" data-action="' . esc_url( rest_url( 'eb/v1/proposal' ) ) . '" novalidate>'
			. '<fieldset class="eb-form__field"><legend>문의 유형 <em>*</em></legend><div class="eb-form__choices">' . $types . '</div></fieldset>'
			. '<div class="eb-form__row"><label class="eb-form__field"><span>성함 또는 업체명 <em>*</em></span><input type="text" name="name" required maxlength="100" autocomplete="organization"></label>'
			. '<label class="eb-form__field"><span>회신받을 이메일 <em>*</em></span><input type="email" name="email" required maxlength="200" autocomplete="email" placeholder="name@company.com"></label></div>'
			. '<label class="eb-form__field"><span>제안 내용 <em>*</em></span><textarea name="body" rows="5" required maxlength="5000" placeholder="제안 내용과 원하시는 방식(글·계산기·배너 등)을 적어 주세요."></textarea></label>'
			. '<details class="eb-form__more"><summary>웹사이트·시작 시기·예산 <small>(선택)</small></summary><div class="eb-form__morein"><label class="eb-form__field"><span>회사·브랜드 웹사이트</span><input type="text" name="site" maxlength="200" inputmode="url" autocomplete="url" placeholder="https://"></label>'
			. '<div class="eb-form__row">' . eb_proposal_select( 'when', '희망 시작 시기' ) . eb_proposal_select( 'budget', '예산 범위' ) . '</div></div></details>'
			. '<input type="text" name="eb_hp" class="eb-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">'
			. '<div class="eb-form__agreebox"><label class="eb-form__agree"><input type="checkbox" required> <span>회신을 위한 이름·이메일 수집에 동의해요 <em>(필수)</em></span></label><details class="eb-form__why"><summary>자세히</summary><p>' . $agree . '</p></details></div>'
			. '<p class="eb-form__error" role="alert" hidden></p>'
			. '<button type="submit" class="eb-form__submit">제안서 보내기</button>'
			. '<div class="eb-form__done" role="status" hidden><strong>제안서가 접수되었습니다.</strong><span>운영자가 직접 확인한 뒤 영업일 2~3일 안에 적어 주신 이메일로 회신드리겠습니다.</span></div>'
			. '</form>';
	}
	return '<form class="eb-form" data-action="' . esc_url( rest_url( 'eb/v1/proposal' ) ) . '" novalidate>'
		. '<div class="eb-form__row"><label class="eb-form__field"><span>성함 또는 업체명 <em>*</em></span><input type="text" name="name" required maxlength="100" autocomplete="organization"></label>'
		. '<label class="eb-form__field"><span>회신받으실 이메일 <em>*</em></span><input type="email" name="email" required maxlength="200" autocomplete="email" placeholder="name@company.com"></label></div>'
		. '<fieldset class="eb-form__field"><legend>문의 유형 <em>*</em></legend><div class="eb-form__choices">' . $types . '</div></fieldset>'
		. '<label class="eb-form__field"><span>회사·브랜드 웹사이트 <small>(선택)</small></span><input type="text" name="site" maxlength="200" inputmode="url" autocomplete="url" placeholder="https://"></label>'
		. '<div class="eb-form__row">' . eb_proposal_select( 'when', '희망 시작 시기' ) . eb_proposal_select( 'budget', '예산 범위' ) . '</div>'
		. '<label class="eb-form__field"><span>문의 및 제안 내용 <em>*</em></span><textarea name="body" rows="7" required maxlength="5000" placeholder="제안 내용과 원하시는 지면(배너·포스팅·콘텐츠 제작 등), 진행 방식을 적어 주시면 더 빠르게 협의할 수 있습니다."></textarea></label>'
		. '<input type="text" name="eb_hp" class="eb-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">'
		. '<label class="eb-form__agree"><input type="checkbox" required> <span>회신을 위해 이름(업체명)과 이메일을 수집하는 데 동의합니다. 접수 내용은 이지복지닷컴 관리 화면과 운영 메일함에 저장되며 문의 처리에만 사용하고, 처리 완료 후 6개월이 지나면 삭제합니다. <a href="/privacy-policy/">개인정보처리방침</a></span></label>'
		. '<p class="eb-form__error" role="alert" hidden></p>'
		. '<button type="submit" class="eb-form__submit">제안서 보내기</button>'
		. '<div class="eb-form__done" role="status" hidden><strong>제안서가 접수되었습니다.</strong><span>운영자가 직접 확인한 뒤 영업일 2~3일 안에 적어 주신 이메일로 회신드리겠습니다.</span></div>'
		. '</form>';
} );

add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_form_used'] ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	document.querySelectorAll('.eb-form').forEach(function (form) {
		var err = form.querySelector('.eb-form__error'), btn = form.querySelector('.eb-form__submit'), start = Date.now();
		function fail(msg, el) { err.textContent = msg; err.hidden = false; if (el) { el.focus(); } }
		form.addEventListener('input', function () { err.hidden = true; });
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var need = form.querySelectorAll('[required]');
			for (var i = 0; i < need.length; i++) {
				var el = need[i];
				if (el.type === 'radio') {
					if (!form.querySelector('input[name="' + el.name + '"]:checked')) { return fail('문의 유형을 골라 주세요.', el); }
				} else if (el.type === 'checkbox') {
					if (!el.checked) { return fail('개인정보 수집에 동의해 주세요.', el); }
				} else if (!el.value.trim()) {
					return fail('필수 항목을 모두 입력해 주세요.', el);
				} else if (el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim())) {
					return fail('이메일 주소를 다시 확인해 주세요.', el);
				}
			}
			var picked = form.querySelector('input[name="type"]:checked');
			var f = form.elements; // form.name은 폼 자체 이름이라 elements로 읽음
			var data = { name: f['name'].value.trim(), email: f['email'].value.trim(), type: picked ? picked.value : '', body: f['body'].value.trim(), site: f['site'].value.trim(), when: f['when'].value, budget: f['budget'].value, hp: f['eb_hp'].value, ms: Date.now() - start };
			btn.disabled = true; btn.textContent = '보내는 중…';
			fetch(form.getAttribute('data-action'), { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) })
				.then(function (r) { return r.json().catch(function () { return { ok: false }; }); })
				.then(function (res) {
					if (!res.ok) { throw new Error(res.msg || ''); }
					form.classList.add('is-done');
					form.querySelector('.eb-form__done').hidden = false;
				}).catch(function (x) {
					btn.disabled = false; btn.textContent = '제안서 보내기';
					fail((x && x.message) || '전송하지 못했습니다. 잠시 뒤 다시 시도하시거나 이 페이지 위쪽의 이메일로 보내 주세요.');
				});
		});
	});
})();
JS
		. "\n</script>\n";
}, 60 );

/* 18. 홈 화면(포털형) [eb_home] ------------------------------------------------------
 * 지금 보면 좋은 정보(대표 글 + 최신·많이 본·신청 중 탭) · 자주 쓰는 계산기 · 분야별 게시판 2×2 · 상황별 가이드
 * 설정 > 읽기에서 정적 홈페이지로 지정한 "홈" 페이지(home) 본문에 [eb_home]이 들어 있습니다.
 */
function eb_short_cat( $post_id ) {
	$cats = get_the_category( $post_id );
	return $cats ? explode( '·', $cats[0]->name )[0] : '';
}

function eb_home_rows( $ids, $empty = '' ) {
	if ( ! $ids ) {
		return '<p class="eb-rows__empty">' . esc_html( $empty ) . '</p>';
	}
	$html = '';
	foreach ( $ids as $id ) {
		$html .= sprintf(
			'<li><a href="%1$s"><span class="eb-rows__tag">%2$s</span><span class="eb-rows__title">%3$s</span></a><time datetime="%4$s">%5$s</time></li>',
			esc_url( get_permalink( $id ) ),
			esc_html( eb_short_cat( $id ) ),
			esc_html( get_the_title( $id ) ),
			esc_attr( get_the_modified_date( 'c', $id ) ),
			esc_html( get_the_modified_date( 'm.d', $id ) )
		);
	}
	return '<ul class="eb-rows">' . $html . '</ul>';
}

function eb_home_html() {
	$base = array( 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'no_found_rows' => true, 'fields' => 'ids' );

	// 대표 글: 대표 이미지가 있는 가장 최근 수정 글
	$feature = get_posts( array_merge( $base, array( 'posts_per_page' => 1, 'orderby' => 'modified', 'meta_key' => '_thumbnail_id' ) ) );
	$fid     = $feature ? $feature[0] : 0;

	$latest   = get_posts( array_merge( $base, array( 'posts_per_page' => 6, 'orderby' => 'modified', 'post__not_in' => array( $fid ) ) ) );
	$popular  = array_slice( array_values( array_filter( eb_popular_ids(), function ( $id ) {
		return 'post' === get_post_type( $id ) && 'publish' === get_post_status( $id );
	} ) ), 0, 6 );
	$applying = get_posts( array_merge( $base, array( 'posts_per_page' => 6, 'orderby' => 'modified', 'tag' => 'applying' ) ) );

	$tabs = array(
		array( '최신', eb_home_rows( $latest ) ),
		array( '많이 본', eb_home_rows( $popular, '집계 중입니다.' ) ),
	);
	if ( $applying ) {
		$tabs[] = array( '신청 중', eb_home_rows( $applying ) );
	}
	$tab_btns   = '';
	$tab_panels = '';
	foreach ( $tabs as $i => $tab ) {
		$tab_btns   .= sprintf( '<button type="button" role="tab" id="eb-tab-%1$d" aria-controls="eb-panel-%1$d" aria-selected="%2$s">%3$s</button>', $i, 0 === $i ? 'true' : 'false', esc_html( $tab[0] ) );
		$tab_panels .= sprintf( '<div class="eb-tabs__panel" role="tabpanel" id="eb-panel-%1$d" aria-labelledby="eb-tab-%1$d"%2$s>%3$s</div>', $i, 0 === $i ? '' : ' hidden', $tab[1] );
	}

	$feature_html = '';
	if ( $fid ) {
		$feature_html = sprintf(
			'<a class="eb-home-feature" href="%1$s"><span class="eb-home-feature__img">%2$s</span><span class="eb-home-feature__meta">%3$s · %4$s</span><strong>%5$s</strong></a>',
			esc_url( get_permalink( $fid ) ),
			get_the_post_thumbnail( $fid, 'medium_large', array( 'loading' => 'eager' ) ),
			esc_html( eb_short_cat( $fid ) ),
			esc_html( get_the_modified_date( 'Y.m.d', $fid ) ),
			esc_html( get_the_title( $fid ) )
		);
	}

	$html  = '<div class="eb-home">';
	$html .= '<section class="eb-home-main" aria-labelledby="eb-home-main-title"><div class="eb-quickfind__head"><h2 id="eb-home-main-title" class="eb-quickfind__title">지금 보면 좋은 정보</h2><a class="eb-quickfind__more" href="' . esc_url( home_url( '/find/' ) ) . '">혜택 찾기 →</a></div>';
	$html .= '<div class="eb-home-main__grid">' . $feature_html . '<div class="eb-tabs"><div class="eb-tabs__list" role="tablist">' . $tab_btns . '</div>' . $tab_panels . '</div></div></section>';

	$html .= '<section class="eb-homecalc" aria-labelledby="eb-home-calc-title"><div class="eb-quickfind__head"><h2 id="eb-home-calc-title" class="eb-quickfind__title">자주 쓰는 계산기</h2><a class="eb-quickfind__more" href="' . esc_url( home_url( '/calculator/' ) ) . '">계산기 전체 보기 →</a></div>' . eb_calc_cards( array( 'severance', 'unemployment', 'median', 'insurance' ), 'eb-calcgrid--home' ) . '</section>';
	$html .= eb_ad_slot( 'home-mid', 'eb-ad-home' ); // 광고 ① (functions.php 26번)

	// 분야별 게시판: PC는 2×2, 휴대폰은 위 탭으로 한 분야씩 (style.css 35번)
	$board_tabs = '';
	$boards     = '';
	$n          = 0;
	foreach ( array( 215, 219, 223, 226 ) as $cat_id ) {
		$term = get_term( $cat_id, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$ids         = get_posts( array_merge( $base, array( 'posts_per_page' => 5, 'orderby' => 'modified', 'cat' => $cat_id ) ) );
		$board_tabs .= sprintf( '<button type="button" data-board="%1$d" aria-selected="%2$s">%3$s</button>', $n, 0 === $n ? 'true' : 'false', esc_html( explode( '·', $term->name )[0] ) );
		$boards     .= sprintf(
			'<div class="eb-board%4$s" data-board="%5$d"><div class="eb-board__head"><h3><a href="%1$s">%2$s</a></h3><a class="eb-board__more" href="%1$s" aria-label="%2$s 더보기">더보기 +</a></div>%3$s</div>',
			esc_url( get_category_link( $term ) ),
			esc_html( $term->name ),
			eb_home_rows( $ids ),
			0 === $n ? ' is-on' : '',
			$n
		);
		$n++;
	}
	$html .= '<section class="eb-boards" aria-labelledby="eb-boards-title"><div class="eb-quickfind__head"><h2 id="eb-boards-title" class="eb-quickfind__title">분야별 정보</h2></div>';
	$html .= '<div class="eb-tabs__list eb-boards__tabs">' . $board_tabs . '</div><div class="eb-boards__grid">' . $boards . '</div></section>';

	$guides = array(
		array( '/guide/after-quit/', '퇴사·실직했을 때', '퇴직금부터 실업급여까지' ),
		array( '/guide/parents-65/', '부모님이 65세가 되면', '기초연금·검진·안전' ),
		array( '/guide/raising-kids/', '아이를 키운다면', '매달 받는 돈·목돈' ),
		array( '/guide/closing-business/', '가게 문을 닫는다면', '폐업 신고·지원금' ),
	);
	$html .= eb_home_news();
	$html .= eb_ad_slot( 'home-bottom', 'eb-ad-home' ); // 광고 ②

	$html .= '<section class="eb-home-guides" aria-labelledby="eb-home-guides-title"><div class="eb-quickfind__head"><h2 id="eb-home-guides-title" class="eb-quickfind__title">상황별 가이드</h2><a class="eb-quickfind__more" href="' . esc_url( home_url( '/guide/' ) ) . '">가이드 전체 →</a></div><div class="eb-home-guides__grid">';
	foreach ( $guides as $g ) {
		$html .= sprintf( '<a href="%1$s"><strong>%2$s</strong><span>%3$s</span></a>', esc_url( home_url( $g[0] ) ), esc_html( $g[1] ), esc_html( $g[2] ) );
	}
	$html .= '</div></section></div>';

	$GLOBALS['eb_home_used'] = true;
	return $html;
}
add_shortcode( 'eb_home', 'eb_home_html' );

// 홈 페이지 제목("홈")은 숨김 - 홈의 대표 제목(H1)은 Elements "홈 상단 소개"가 담당
add_filter( 'generate_show_title', function ( $show ) {
	return is_front_page() ? false : $show;
} );

// 예전 글 목록 홈의 2쪽·3쪽 주소(/page/2/)는 홈으로 연결
add_action( 'template_redirect', function () {
	if ( is_front_page() && ( get_query_var( 'paged' ) > 1 || get_query_var( 'page' ) > 1 ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_home_used'] ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	document.querySelectorAll('.eb-tabs').forEach(function (box) {
		var btns = box.querySelectorAll('[role="tab"]');
		btns.forEach(function (b) {
			b.addEventListener('click', function () {
				btns.forEach(function (x) {
					var on = x === b;
					x.setAttribute('aria-selected', on ? 'true' : 'false');
					document.getElementById(x.getAttribute('aria-controls')).hidden = !on;
				});
			});
		});
	});
	// 휴대폰 분야별 정보 탭
	document.querySelectorAll('.eb-boards__tabs').forEach(function (bar) {
		var sec = bar.closest('.eb-boards'), btns = bar.querySelectorAll('button');
		btns.forEach(function (b) {
			b.addEventListener('click', function () {
				btns.forEach(function (x) { x.setAttribute('aria-selected', x === b ? 'true' : 'false'); });
				sec.querySelectorAll('.eb-board').forEach(function (bd) {
					bd.classList.toggle('is-on', bd.getAttribute('data-board') === b.getAttribute('data-board'));
				});
			});
		});
	});
})();
JS
	. "\n</script>\n";
}, 65 );

/* 19. 글 도구 · 404 · 검색어 분석 -------------------------------------------------------
 * 19-1 글 도구(글 위 날짜 줄 오른쪽): ☆ 저장(나중에 볼 글) · 글자 크기 [가 가+ 가++]
 *      저장 목록과 글자 크기는 방문자 브라우저에만 저장(서버 저장 없음)
 *      [eb_saved] 사이드바용 / [eb_saved mode="page"] 저장한 글 페이지(/saved/)
 * 19-2 404 페이지: 문구 정리 + 분야별 찾기·많이 찾는 정보·계산기
 * 19-3 검색어 분석(관리자 알림판): 방문자 검색어와 결과가 없던 검색어 기록(로그인 사용자·검색 로봇 제외)
 */
add_action( 'wp_head', function () {
	echo "<script nowprocket>try{var f=localStorage.getItem('eb_fs');if(f&&f!=='1'){document.documentElement.setAttribute('data-eb-fs',f);}}catch(e){}</script>\n";
}, 1 );

add_action( 'generate_after_entry_header', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	printf(
		'<div class="eb-tools" hidden data-url="%1$s" data-title="%2$s"><button type="button" class="eb-tools__save" aria-pressed="false"><svg viewBox="0 0 24 24" width="15" height="15" aria-hidden="true"><path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.9l-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/></svg><span>저장</span></button><div class="eb-tools__size" role="group" aria-label="글자 크기"><button type="button" data-fs="1" aria-label="기본 글자">가</button><button type="button" data-fs="2" aria-label="큰 글자">가+</button><button type="button" data-fs="3" aria-label="아주 큰 글자">가++</button></div></div>',
		esc_url( get_permalink() ),
		esc_attr( get_the_title() )
	);
}, 1 );

add_shortcode( 'eb_saved', function ( $atts ) {
	$atts = shortcode_atts( array( 'mode' => 'side' ), $atts );
	if ( 'page' === $atts['mode'] ) {
		return '<div class="eb-saved" data-mode="page"><ul class="eb-saved__list"></ul><div class="eb-saved__empty" hidden><strong>아직 저장한 글이 없어요</strong><span>글 위쪽의 ☆ 저장 버튼을 누르면 이곳에 모여요.</span><span class="eb-saved__cta"><a class="is-main" href="' . esc_url( home_url( '/find/#finder' ) ) . '">내게 맞는 혜택 찾기</a><a href="' . esc_url( home_url( '/calculator/' ) ) . '">복지 계산기</a></span></div></div>'; // 빈 화면: 안내 + 바로 가기 2개 (style.css 112번, 2026-10-09)
	}
	return '<div class="eb-saved" data-mode="side" hidden><h2 class="widget-title">저장한 글</h2><ul class="eb-saved__list"></ul><p class="eb-saved__more"><a href="' . esc_url( home_url( '/saved/' ) ) . '">저장한 글 전체 보기 →</a></p></div>';
} );

add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var KEY = 'eb_saved';
	function get() { try { return JSON.parse(localStorage.getItem(KEY) || '[]'); } catch (e) { return []; } }
	// 저장 목록이 바뀌면 알림 → 휴대폰 메뉴(20번)의 '저장한 글' 배지·목록이 바로 바뀜
	function set(v) { try { localStorage.setItem(KEY, JSON.stringify(v)); } catch (e) {} document.dispatchEvent(new CustomEvent('eb:saved')); }
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

	// 저장·취소 알림 (2026-10-15, 계산기와 같은 .eb-toast)
	function savedToast(msg) {
		var t = document.querySelector('.eb-toast');
		if (!t) { t = document.createElement('div'); t.className = 'eb-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
		t.textContent = msg;
		t.hidden = false;
		t.classList.add('is-on');
		clearTimeout(t._h);
		t._h = setTimeout(function () { t.classList.remove('is-on'); }, 2600);
	}
	function ymd(ms) { var d = new Date(ms); return (d.getMonth() + 1) + '.' + d.getDate(); }

	// /saved/ 목록: 계산기(타일) · 상황별 가이드 · 글(한 줄 목록)로 묶음 (2026-10-16, css/90-tools.css 끝 .eb-sv)
	var SV_IC = {
		calc: '<rect x="5" y="3" width="14" height="18" rx="2.5"/><path d="M8.5 7h7M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15h.01M8.5 18h7"/>',
		guide: '<path d="M12 3v18M12 5h6l2 2.5L18 10h-6M12 12H6l-2 2.5L6 17h6"/>',
		post: '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>'
	};
	function svIc(k) { return '<span class="eb-sv__ic"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + SV_IC[k] + '</svg></span>'; }
	function svKind(u) { var p = ''; try { p = new URL(u, location.origin).pathname; } catch (e) {} return /^\/calculator\/.+/.test(p) ? 'calc' : (/^\/guide\/.+/.test(p) ? 'guide' : 'post'); }
	function svDel(x) { return '<button type="button" class="eb-saved__del eb-sv__x" data-u="' + esc(x.u) + '" aria-label="' + esc(x.t) + ' 삭제" title="삭제"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>'; }
	function groups(list) {
		var by = { calc: [], guide: [], post: [] };
		list.forEach(function (x) { if (x && x.u) { by[svKind(x.u)].push(x); } });
		var head = function (t, n) { return '<h2 class="eb-sv__h">' + t + ' <b>' + n + '</b></h2>'; };
		var h = '';
		if (by.calc.length) {
			h += '<section class="eb-sv__g">' + head('계산기', by.calc.length) + '<ul class="eb-sv__tiles">' + by.calc.map(function (x) {
				return '<li class="eb-sv__tile"><a href="' + esc(x.u) + '">' + svIc('calc') + '<strong>' + esc(String(x.t).replace(/\s*\([^)]*\)\s*$/, '')) + '</strong><span class="eb-sv__go">계산하기 ›</span></a>' + svDel(x) + '</li>';
			}).join('') + '</ul></section>';
		}
		[['guide', '상황별 가이드'], ['post', '글']].forEach(function (g) {
			if (!by[g[0]].length) { return; }
			h += '<section class="eb-sv__g">' + head(g[1], by[g[0]].length) + '<ul class="eb-sv__rows">' + by[g[0]].map(function (x) {
				return '<li class="eb-sv__row is-' + g[0] + '"><a href="' + esc(x.u) + '">' + svIc(g[0]) + '<span class="eb-sv__tx"><strong>' + esc(x.t) + '</strong>' + (x.d ? '<small>' + ymd(x.d) + ' 저장</small>' : '') + '</span></a>' + svDel(x) + '</li>';
			}).join('') + '</ul></section>';
		});
		return h;
	}

	function renderLists() {
		var list = get();
		document.querySelectorAll('.eb-saved').forEach(function (box) {
			var page = box.getAttribute('data-mode') === 'page', items = page ? list : list.slice(0, 5);
			box.querySelector('.eb-saved__list').innerHTML = items.map(function (x) {
				return '<li><a href="' + esc(x.u) + '">' + esc(x.t) + (page && x.d ? '<small class="eb-saved__d">' + ymd(x.d) + ' 저장</small>' : '') + '</a>' + (page ? '<button type="button" class="eb-saved__del" data-u="' + esc(x.u) + '">삭제</button>' : '') + '</li>';
			}).join('');
			if (page) {
				box.querySelector('.eb-saved__list').hidden = true;
				var gw = box.querySelector('.eb-sv');
				if (!gw) { gw = document.createElement('div'); gw.className = 'eb-sv'; box.insertBefore(gw, box.firstChild); }
				gw.innerHTML = groups(list);
				box.querySelector('.eb-saved__empty').hidden = list.length > 0;
			} else {
				box.hidden = list.length === 0;
				var w = box.closest('.widget'); if (w) { w.classList.toggle('has-saved', list.length > 0); }
			}
		});
	}

	var tools = document.querySelector('.eb-tools'), paint = function () {};
	if (tools) {
		var meta = document.querySelector('.entry-header .entry-meta');
		if (meta) { meta.appendChild(tools); }
		tools.hidden = false;
		var url = tools.getAttribute('data-url'), title = tools.getAttribute('data-title'), save = tools.querySelector('.eb-tools__save');
		paint = function () {
			var on = get().some(function (x) { return x.u === url; });
			save.setAttribute('aria-pressed', on ? 'true' : 'false');
			save.querySelector('span').textContent = on ? '저장됨' : '저장';
		};
		save.addEventListener('click', function () {
			var list = get(), on = list.some(function (x) { return x.u === url; });
			list = on ? list.filter(function (x) { return x.u !== url; }) : [{ u: url, t: title, d: Date.now() }].concat(list).slice(0, 50);
			set(list); paint(); renderLists();
			savedToast(on ? '저장을 취소했어요' : '저장했어요 · 메뉴의 \'저장한 글\'에서 다시 볼 수 있어요');
		});
		paint();

		var btns = tools.querySelectorAll('[data-fs]');
		function size(n) {
			n = String(n);
			if (n === '1') { document.documentElement.removeAttribute('data-eb-fs'); } else { document.documentElement.setAttribute('data-eb-fs', n); }
			try { localStorage.setItem('eb_fs', n); } catch (e) {}
			btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-fs') === n ? 'true' : 'false'); });
		}
		size(document.documentElement.getAttribute('data-eb-fs') || '1');
		btns.forEach(function (b) { b.addEventListener('click', function () { size(b.getAttribute('data-fs')); }); });
	}

	document.addEventListener('click', function (e) {
		var d = e.target.closest && e.target.closest('.eb-saved__del');
		if (!d) { return; }
		var u = d.getAttribute('data-u');
		set(get().filter(function (x) { return x.u !== u; }));
		renderLists(); paint();
	});
	renderLists();
})();
JS
	. "\n</script>\n";
}, 70 );

// 19-2 404 페이지
add_filter( 'generate_404_title', function () {
	return '찾으시는 페이지가 없어요';
} );
add_filter( 'generate_404_text', function () {
	return '주소가 바뀌었거나 삭제된 페이지입니다. 아래 검색창에 찾는 내용을 입력하거나, 분야별 정보와 많이 찾는 정보에서 골라 보세요.';
} );
add_action( 'generate_after_main_content', function () {
	if ( ! is_404() ) {
		return;
	}
	$ids = array_slice( array_values( array_filter( eb_popular_ids(), function ( $id ) {
		return 'post' === get_post_type( $id ) && 'publish' === get_post_status( $id );
	} ) ), 0, 6 );
	if ( ! $ids ) {
		$ids = get_posts( array( 'posts_per_page' => 6, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	}
	$links = array(
		array( '/welfare/', '복지·지원금' ),
		array( '/life/', '건강·생활' ),
		array( '/finance/', '금융·사업자' ),
		array( '/work/', '노동·민원' ),
		array( '/find/', '맞춤 혜택 찾기' ),
		array( '/guide/', '상황별 가이드' ), // 2026-10-16
		array( '/calculator/', '복지 계산기' ),
		array( '/schedule/', '복지 캘린더' ),
		array( '/links/', '공식 기관 모음' ),
	);
	$chips = '';
	foreach ( $links as $l ) {
		$chips .= sprintf( '<a href="%1$s">%2$s</a>', esc_url( home_url( $l[0] ) ), esc_html( $l[1] ) );
	}
	echo '<div class="eb-404">'
		. '<section><div class="eb-quickfind__head"><h2 class="eb-quickfind__title">어디로 가 볼까요?</h2></div><div class="eb-404__chips">' . $chips . '</div></section>' // phpcs:ignore
		. '<section><div class="eb-quickfind__head"><h2 class="eb-quickfind__title">많이 찾는 정보</h2></div><div class="eb-board">' . eb_home_rows( $ids ) . '</div></section>' // phpcs:ignore
		. '<section><div class="eb-quickfind__head"><h2 class="eb-quickfind__title">자주 쓰는 계산기</h2></div>' . eb_calc_cards( array( 'severance', 'unemployment', 'median', 'insurance' ), 'eb-calcgrid--home' ) . '</section>' // phpcs:ignore
		. '</div>';
}, 5 );

// 19-3 검색어 분석
add_action( 'template_redirect', function () {
	if ( ! is_search() || is_paged() || is_user_logged_in() ) {
		return;
	}
	$ua = strtolower( isset( $_SERVER['HTTP_USER_AGENT'] ) ? (string) $_SERVER['HTTP_USER_AGENT'] : '' ); // phpcs:ignore
	if ( '' === $ua || preg_match( '/bot|crawl|spider|slurp|preview|fetch/', $ua ) ) {
		return;
	}
	$term = trim( preg_replace( '/\s+/u', ' ', mb_strtolower( get_search_query( false ) ) ) );
	if ( '' === $term || mb_strlen( $term ) > 40 ) {
		return;
	}
	// 테스트·의미 없는 검색어(zz…·테스트·test)는 기록하지 않음 - 40번 인기 검색어 제외 기준과 같게 (2026-10-08)
	if ( preg_match( '/zz|테스트|test/iu', $term ) ) {
		return;
	}
	// 숫자가 6자리 넘게 이어진 검색어(전화·주민·사업자번호일 수 있음)는 기록하지 않음 (2026-10-15)
	if ( preg_match( '/\d{6,}/', $term ) ) {
		return;
	}
	global $wp_query;
	$log          = get_option( 'eb_search_log', array() );
	$row          = isset( $log[ $term ] ) ? $log[ $term ] : array( 0, 0, 0 );
	$log[ $term ] = array( $row[0] + 1, (int) $wp_query->found_posts, time() );
	if ( count( $log ) > 400 ) {
		uasort( $log, function ( $a, $b ) {
			return $b[2] - $a[2];
		} );
		$log = array_slice( $log, 0, 300, true );
	}
	update_option( 'eb_search_log', $log, false );
	// 1시간 단위 검색 수 (홈 인기 검색어 40번이 최근 24시간 합계로 순위를 매김). 25시간 넘은 칸은 버림
	$hour   = (int) floor( time() / HOUR_IN_SECONDS );
	$hourly = (array) get_option( 'eb_search_hourly', array() );
	foreach ( array_keys( $hourly ) as $h ) {
		if ( $h < $hour - 24 ) {
			unset( $hourly[ $h ] );
		}
	}
	if ( ! isset( $hourly[ $hour ] ) ) {
		$hourly[ $hour ] = array();
	}
	if ( isset( $hourly[ $hour ][ $term ] ) || count( $hourly[ $hour ] ) < 300 ) {
		$hourly[ $hour ][ $term ] = ( isset( $hourly[ $hour ][ $term ] ) ? $hourly[ $hour ][ $term ] : 0 ) + 1;
	}
	update_option( 'eb_search_hourly', $hourly, false );
	if ( ! get_option( 'eb_search_log_since' ) ) {
		update_option( 'eb_search_log_since', current_time( 'Y-m-d' ), false );
	}
}, 20 );

// 19-4 이미 쌓인 테스트 검색어 한 번만 정리 (2026-10-08)
add_action( 'admin_init', function () {
	if ( get_option( 'eb_search_log_cleaned_v1' ) ) {
		return;
	}
	$junk = function ( $q ) {
		return (bool) preg_match( '/zz|테스트|test/iu', (string) $q );
	};
	$log = (array) get_option( 'eb_search_log', array() );
	foreach ( array_keys( $log ) as $q ) {
		if ( $junk( $q ) ) {
			unset( $log[ $q ] );
		}
	}
	update_option( 'eb_search_log', $log, false );
	$hourly = (array) get_option( 'eb_search_hourly', array() );
	foreach ( $hourly as $h => $bucket ) {
		foreach ( array_keys( (array) $bucket ) as $q ) {
			if ( $junk( $q ) ) {
				unset( $hourly[ $h ][ $q ] );
			}
		}
	}
	update_option( 'eb_search_hourly', $hourly, false );
	update_option( 'eb_search_log_cleaned_v1', 1, false );
} );

// 19-5 사이트 점검 중 로그인 없이 시험 검색한 기록 한 번만 빼기 (2026-10-15)
add_action( 'admin_init', function () {
	// v2(10-15 14시)에 시험 검색 9개, v3에 '실업급여' 1회를 뺐고, v4는 개인 번호일 수 있는 숫자 검색어를 지움, v5는 검색 점검 때 생긴 2개
	if ( get_option( 'eb_search_log_cleaned_v5' ) ) {
		return;
	}
	$minus = array(
		'임대주택' => 99,
		'퇴직금'   => 1,
	);
	$log = (array) get_option( 'eb_search_log', array() );
	foreach ( $minus as $q => $n ) {
		if ( isset( $log[ $q ] ) ) {
			$log[ $q ][0] = (int) $log[ $q ][0] - $n;
			if ( $log[ $q ][0] <= 0 ) {
				unset( $log[ $q ] );
			}
		}
	}
	update_option( 'eb_search_log', $log, false );
	$hourly = (array) get_option( 'eb_search_hourly', array() );
	krsort( $hourly ); // 최근 시간부터 뺌
	foreach ( $minus as $q => $n ) {
		foreach ( array_keys( $hourly ) as $h ) {
			if ( $n <= 0 ) {
				break;
			}
			if ( isset( $hourly[ $h ][ $q ] ) ) {
				$take               = min( $n, (int) $hourly[ $h ][ $q ] );
				$hourly[ $h ][ $q ] = (int) $hourly[ $h ][ $q ] - $take;
				$n                 -= $take;
				if ( $hourly[ $h ][ $q ] <= 0 ) {
					unset( $hourly[ $h ][ $q ] );
				}
			}
		}
	}
	update_option( 'eb_search_hourly', $hourly, false );
	update_option( 'eb_search_log_cleaned_v5', 1, false );
} );

add_action( 'wp_dashboard_setup', function () {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'eb_search_log', '이지복지닷컴 · 검색어 분석', function () {
		$log = get_option( 'eb_search_log', array() );
		if ( ! $log ) {
			echo '<p>아직 기록된 검색어가 없습니다. 방문자가 사이트에서 검색하면 이곳에 쌓입니다(관리자 본인 검색과 검색 로봇은 제외).</p>';
			return;
		}
		$table = function ( $rows, $draft = false ) {
			$html = '<table class="widefat striped" style="margin-bottom:12px"><thead><tr><th>검색어</th><th style="width:48px">횟수</th><th style="width:48px">글 수</th><th style="width:70px">마지막</th></tr></thead><tbody>';
			foreach ( $rows as $term => $r ) {
				$html .= sprintf(
					'<tr><td><a href="%1$s" target="_blank">%2$s</a>%6$s</td><td>%3$d</td><td>%4$d</td><td>%5$s</td></tr>',
					esc_url( home_url( '/?s=' . rawurlencode( $term ) ) ),
					esc_html( $term ),
					(int) $r[0],
					(int) $r[1],
					esc_html( wp_date( 'm.d', (int) $r[2] ) ),
					$draft ? ' · <a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=eb_term_draft&q=' . rawurlencode( $term ) ), 'eb_term_draft' ) ) . '">초안 만들기</a>' : ''
				);
			}
			return $html . '</tbody></table>';
		};
		$zero = array_filter( $log, function ( $r ) {
			return 0 === (int) $r[1];
		} );
		uasort( $zero, function ( $a, $b ) {
			return $b[0] - $a[0];
		} );
		$all = $log;
		uasort( $all, function ( $a, $b ) {
			return $b[0] - $a[0];
		} );
		printf( '<p style="color:#646970">%s부터 기록 · 관리자 본인 검색과 검색 로봇은 제외</p>', esc_html( get_option( 'eb_search_log_since', '' ) ) );
		// 두 표를 나란히, 8줄씩 (알림판 콤팩트, 2026-10-09 - 58번)
		echo '<div class="eb-dash-2"><div><p class="eb-dash-h">정리 글 없던 검색어 <small>새 글 주제 후보 · 계산기·정부 서비스는 따로 보여 줌</small></p>' . ( $zero ? $table( array_slice( $zero, 0, 8, true ), true ) : '<p>없습니다.</p>' ) . '</div>'; // phpcs:ignore
		echo '<div><p class="eb-dash-h">많이 검색한 검색어</p>' . $table( array_slice( $all, 0, 8, true ) ) . '</div></div>'; // phpcs:ignore
	} );
} );

// 19-6 '정리 글 없던 검색어' → 새 글 초안 (2026-10-15): 소제목 뼈대 + Rank Math 핵심 키워드. 같은 제목 초안이 있으면 그 글을 엶
add_action( 'admin_post_eb_term_draft', function () {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_term_draft' );
	$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
	if ( '' === $q ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
	$title = $q . ' 신청방법 총정리 (초안)';
	$old   = get_posts( array( 'post_type' => 'post', 'post_status' => array( 'draft', 'pending' ), 'title' => $title, 'posts_per_page' => 1, 'fields' => 'ids' ) );
	if ( $old ) {
		wp_safe_redirect( get_edit_post_link( $old[0], 'url' ) );
		exit;
	}
	$h  = function ( $t ) {
		return "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html( $t ) . "</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->\n\n";
	};
	$id = wp_insert_post( array(
		'post_type'    => 'post',
		'post_status'  => 'draft',
		'post_title'   => $title,
		'post_content' => $h( $q . '이란' ) . $h( '누가 받을 수 있나요' ) . $h( '얼마를 받나요' ) . $h( '신청 방법과 기간' ) . $h( '필요한 서류' ) . $h( '자주 묻는 질문' ),
		'meta_input'   => array( 'rank_math_focus_keyword' => $q ),
	) );
	wp_safe_redirect( is_wp_error( $id ) || ! $id ? admin_url() : get_edit_post_link( $id, 'url' ) );
	exit;
} );

// 19-7 알림판 '맞춤 찾기 점검' (2026-10-15): 혜택 찾기 상황 타일마다 맞는 정리 글 수(55번 맞춤 찾기와 같은 규칙). 0개면 어떤 태그가 필요한지
add_action( 'wp_dashboard_setup', function () {
	if ( ! current_user_can( 'edit_posts' ) || ! function_exists( 'eb_find_situations' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'eb_find_check', '이지복지닷컴 · 맞춤 찾기 점검', function () {
		$posts = eb_f2_posts();
		$rows  = '';
		foreach ( eb_find_situations() as $s ) {
			$p = $s[2];
			$n = 0;
			foreach ( $posts as $x ) {
				if ( $p['life'] && $x['l'] && ! in_array( $p['life'], $x['l'], true ) ) {
					continue;
				}
				if ( ( $p['life'] && in_array( $p['life'], $x['l'], true ) ) || array_intersect( $p['hh'], $x['h'] ) || array_intersect( $p['th'], $x['th'] ) ) {
					$n++;
				}
			}
			$need  = array_merge( $p['life'] ? array( '생애주기 ' . $p['life'] ) : array(), $p['hh'] ? array( '가구 상황 ' . implode( '·', $p['hh'] ) ) : array(), $p['th'] ? array( '관심 주제 ' . implode( '·', $p['th'] ) ) : array() );
			$rows .= sprintf(
				'<tr%1$s><td><a href="%2$s" target="_blank">%3$s</a></td><td>%4$d</td><td><small>%5$s</small></td></tr>',
				$n ? '' : ' style="background:#fff4f4"',
				esc_url( home_url( '/guide/' . $s[1] . '/' ) ),
				esc_html( $s[0] ),
				$n,
				esc_html( $n ? '' : '이 태그가 붙은 글이 없어요: ' . implode( ' 또는 ', $need ) )
			);
		}
		$none = count( array_filter( $posts, function ( $x ) {
			return ! $x['l'] && ! $x['h'] && ! $x['th'];
		} ) );
		echo '<p style="color:#646970">혜택 찾기 화면 상황 타일에 잡히는 정리 글 수예요. 0개인 상황은 관련 글에 맞춤 태그를 붙이거나 새 글이 필요해요(화면에는 \'정리 글 0\'을 감춤).</p>';
		echo '<table class="widefat striped"><thead><tr><th>상황</th><th style="width:40px">글</th><th>필요한 것</th></tr></thead><tbody>' . $rows . '</tbody></table>'; // phpcs:ignore
		if ( $none ) {
			echo '<p>맞춤 태그가 하나도 없는 글: <strong>' . (int) $none . '개</strong> (<a href="' . esc_url( admin_url( 'edit.php' ) ) . '">글 목록</a>의 생애주기·가구 상황·관심 주제 열)</p>';
		}
	} );
} );

/* 20. 모바일 옆 메뉴 묶음 제목 ------------------------------------------------------
 * 메뉴 항목에 CSS 클래스 eb-menu-heading을 주면 링크가 아닌 작은 제목으로 보여 줍니다.
 * (자주 쓰는 큰 버튼은 CSS 클래스 eb-tile — 모양은 style.css 24번)
 */
add_filter( 'walker_nav_menu_start_el', function ( $output, $item ) {
	if ( in_array( 'eb-menu-heading', (array) $item->classes, true ) ) {
		return '<span class="eb-menu-heading__label">' . esc_html( $item->title ) . '</span>';
	}
	return $output;
}, 10, 2 );

// (2026-10-16 삭제) 옛 휴대폰 옆 메뉴 스크립트(줄 전체 펼침·전체 보기·다가오는 일정 카드·최근 본 글/저장한 글/알림 탭·저장 개수·맨 위/맨 아래 줄) - 68번 전체 메뉴(#ebm)로 대체. 원본: 백업 임시글 15213

/* 21. 복지 캘린더 [eb_calendar] ------------------------------------------------------
 * 탭 3개: 월간 달력(#calendar) · 연간 신청 일정(#yearly) · 지금 신청 중(#applying)
 * 지급일은 eb_payday_date()로 주말·공휴일을 반영하고, 오늘 날짜·D-day는 방문자 기기에서 계산합니다.
 */
function eb_benefits() {
	return array(
		'living'     => array( '생계·주거급여', 20, 'a' ),
		'disability' => array( '장애인연금', 20, 'a' ),
		'basic'      => array( '기초연금', 25, 'b' ),
		'nps'        => array( '국민연금', 25, 'b' ),
		'child'      => array( '아동수당·부모급여', 25, 'b' ),
	);
}

// 연간 신청 일정: 월 => [분류, 내용]. 분류 = welfare(복지)·tax(세금)·health(건강)·edu(교육), 이름은 eb_yearly_tags().
// 해마다 바뀌는 날짜는 넣지 않고 매년 같은 법정 기간·시기만 적음 (2026-10-04 정리)
function eb_yearly_tags() {
	return array(
		'welfare' => '복지',
		'tax'     => '세금',
		'health'  => '건강',
		'edu'     => '교육',
	);
}

function eb_yearly_schedule() {
	return array(
		1  => array(
			array( 'welfare', '새해 복지 기준 적용 (기준 중위소득·최저임금·기초연금 등)' ),
			array( 'tax', '근로소득 연말정산 시작 (1~2월, 회사를 통해 진행)' ),
			array( 'tax', '연말정산 간소화 자료 조회 시작 (1월 15일 무렵, 홈택스)' ),
			array( 'tax', '부가가치세 2기 확정신고 (1월 1일~25일)' ),
			array( 'tax', '자동차세 연납 신청 (1월 16일~31일, 할인 가장 큼)' ),
		),
		2  => array(
			array( 'tax', '연말정산 서류 회사 제출 마무리' ),
			array( 'edu', '1학기 국가장학금 2차 신청 (2~3월)' ),
		),
		3  => array(
			array( 'welfare', '근로장려금 반기 신청 (전년도 하반기 소득분, 3월 1일~15일)' ),
			array( 'tax', '자동차세 연납 신청 (3월 16일~31일)' ),
		),
		4  => array(
			array( 'health', '직장가입자 건강보험료 정산 (4월분 보험료에 지난해 차액 반영)' ),
		),
		5  => array(
			array( 'welfare', '근로장려금·자녀장려금 정기 신청 (5월 1일~31일)' ),
			array( 'tax', '종합소득세 신고 (5월 1일~31일)' ),
			array( 'edu', '2학기 국가장학금 1차 신청 (5~6월)' ),
		),
		6  => array(
			array( 'welfare', '근로장려금 반기분 지급 (3월 신청분, 6월 말 무렵)' ),
			array( 'welfare', '근로장려금 기한 후 신청 시작 (11월 30일까지, 지급액 일부 감액)' ),
			array( 'welfare', '에너지바우처 신청 시작 (연말까지)' ),
			array( 'tax', '자동차세 1기분 납부 (6월 16일~30일)' ),
		),
		7  => array(
			array( 'welfare', '다음 해 기준 중위소득 결정 (중앙생활보장위원회, 7월 말)' ),
			array( 'welfare', '국민연금 기준소득월액 상한·하한 조정' ),
			array( 'tax', '부가가치세 1기 확정신고 (7월 1일~25일)' ),
			array( 'tax', '주택 재산세 1기분 납부 (7월 16일~31일)' ),
		),
		8  => array(
			array( 'welfare', '다음 해 기준 중위소득 고시 (보건복지부)' ),
			array( 'welfare', '다음 해 최저임금 확정 고시 (8월 5일까지)' ),
			array( 'welfare', '근로장려금·자녀장려금 정기분 지급 (8월 말 무렵)' ),
			array( 'edu', '2학기 국가장학금 2차 신청 (8~9월)' ),
		),
		9  => array(
			array( 'welfare', '근로장려금 반기 신청 (그해 상반기 소득분, 9월 1일~15일)' ),
			array( 'tax', '재산세 2기분 납부 (주택 나머지 절반·토지, 9월 16일~30일)' ),
			array( 'tax', '자동차세 연납 신청 (9월 16일~30일)' ),
			array( 'health', '독감 무료 예방접종 시작 (9월 말, 어린이·임신부부터)' ),
		),
		10 => array(
			array( 'health', '만 65세 이상 독감 무료 예방접종 (10월 중순부터, 나이순)' ),
		),
		11 => array(
			array( 'welfare', '근로장려금 기한 후 신청 마감 (11월 30일)' ),
			array( 'welfare', '다음 해 노인일자리 참여자 모집 (11월 말~12월, 지역마다 다름)' ),
			array( 'tax', '연말정산 미리보기 서비스 시작 (홈택스, 11월 무렵)' ),
			array( 'health', '지역가입자 건강보험료 조정 (11월분부터 지난해 소득 반영)' ),
			array( 'edu', '다음 해 1학기 국가장학금 1차 신청 (11~12월)' ),
		),
		12 => array(
			array( 'welfare', '근로장려금 반기분 지급 (9월 신청분, 12월 말 무렵)' ),
			array( 'tax', '종합부동산세 납부 (12월 1일~15일)' ),
			array( 'tax', '자동차세 2기분 납부 (12월 16일~31일)' ),
			array( 'health', '국가건강검진 올해 대상자 마감 (12월 31일)' ),
		),
	);
}

// 월간 달력의 신청·납부 기간(법정이라 매년 같음): [달력 칸 짧은 이름, 이름, 시작 월-일('' = 기간 시작 없음), 마감 월-일, 시작 표시 여부]
// 마감일이 토·일요일·공휴일이면 다음 평일(국세기본법·지방세기본법) — eb_due_date()가 공휴일 목록으로 자동 계산
function eb_deadline_rules() {
	return array(
		array( '부가세', '부가가치세 2기 확정신고', '01-01', '01-25', false ),
		array( '자동차세', '자동차세 연납 신청', '01-16', '01-31', true ),
		array( '근로장려금', '근로장려금 반기 신청', '03-01', '03-15', true ),
		array( '자동차세', '자동차세 연납 신청', '03-16', '03-31', true ),
		array( '근로장려금', '근로·자녀장려금 정기 신청', '05-01', '05-31', true ),
		array( '종소세', '종합소득세 신고', '05-01', '05-31', true ),
		array( '자동차세', '자동차세 1기분 납부·연납 신청', '06-16', '06-30', true ),
		array( '부가세', '부가가치세 1기 확정신고', '07-01', '07-25', false ),
		array( '재산세', '주택 재산세 1기분 납부', '07-16', '07-31', true ),
		array( '근로장려금', '근로장려금 반기 신청', '09-01', '09-15', true ),
		array( '재산세', '재산세 2기분 납부', '09-16', '09-30', true ),
		array( '자동차세', '자동차세 연납 신청', '09-16', '09-30', true ),
		array( '근로장려금', '근로장려금 기한 후 신청', '06-01', '11-30', false ),
		array( '종부세', '종합부동산세 납부', '12-01', '12-15', true ),
		array( '자동차세', '자동차세 2기분 납부', '12-16', '12-31', true ),
	);
}

function eb_due_date( $year, $md ) {
	$date     = new DateTimeImmutable( $year . '-' . $md, wp_timezone() );
	$holidays = eb_kr_holidays();
	while ( (int) $date->format( 'N' ) >= 6 || in_array( $date->format( 'Y-m-d' ), $holidays, true ) ) {
		$date = $date->modify( '+1 day' );
	}
	return $date;
}

add_shortcode( 'eb_calendar', function () {
	$today  = current_datetime()->setTime( 0, 0 );
	$start  = $today->modify( 'first day of this month' );
	$months = array();
	$events = array();
	for ( $i = 0; $i < 12; $i++ ) {
		$m        = $start->modify( "+{$i} month" );
		$months[] = array( (int) $m->format( 'Y' ), (int) $m->format( 'n' ) );
		foreach ( eb_benefits() as $key => $b ) {
			$date              = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $b[1] )->format( 'Y-m-d' );
			$events[ $date ][] = $key;
		}
	}
	// 신청·납부 기간: 날짜 => [['s'(시작)|'e'(마감), 이름, 마감일, 짧은 이름, 기간 글자], ...]
	$dues = array();
	foreach ( array_unique( array_column( $months, 0 ) ) as $y ) {
		foreach ( eb_deadline_rules() as $r ) {
			$end    = eb_due_date( $y, $r[3] );
			$period = ( '' !== $r[2] ? ( new DateTimeImmutable( $y . '-' . $r[2] ) )->format( 'n.j' ) : '' ) . '~' . $end->format( 'n.j' );
			$end    = $end->format( 'Y-m-d' );
			if ( $r[4] ) {
				$dues[ $y . '-' . $r[2] ][] = array( 's', $r[1], $end, $r[0], $period );
			}
			$dues[ $end ][] = array( 'e', $r[1], $end, $r[0], $period );
		}
	}
	$data = array(
		'months'   => $months,
		'events'   => $events,
		'dues'     => $dues,
		'holidays' => eb_kr_holiday_names(),
		'benefits' => eb_benefits(),
	);
	// 복지 일정 플러그인(eb-schedule)이 정부24·직접 추가 일정의 시작·마감, '이달 내내 접수 중' 목록을 더함 (2026-10-10)
	$data = apply_filters( 'eb_calendar_data', $data );

	$chips = '<button type="button" data-key="" aria-pressed="true">전체</button>';
	foreach ( eb_benefits() as $key => $b ) {
		$chips .= sprintf( '<button type="button" data-key="%1$s" aria-pressed="false">%2$s</button>', esc_attr( $key ), esc_html( $b[0] ) );
	}
	$chips .= '<button type="button" data-key="due" aria-pressed="false">신청·마감</button>';

	// 이번 달(일정이 없으면 다음으로 일정이 있는 달)을 강조
	$now      = (int) $today->format( 'n' );
	$yearly   = eb_yearly_schedule();
	$next     = 0;
	foreach ( array_keys( $yearly ) as $month ) {
		if ( $month >= $now ) {
			$next = $month;
			break;
		}
	}
	$next     = $next ? $next : (int) array_key_first( $yearly );
	$timeline = '';
	foreach ( $yearly as $month => $items ) {
		$timeline .= sprintf(
			'<li class="%1$s"><strong>%2$d월</strong>%4$s<ul>%3$s</ul></li>',
			$month === $next ? 'is-now' : '',
			$month,
			implode( '', array_map( function ( $t ) {
				$tags = eb_yearly_tags();
				return '<li><span class="eb-cal__tag is-' . esc_attr( $t[0] ) . '">' . esc_html( $tags[ $t[0] ] ) . '</span><span>' . esc_html( $t[1] ) . '</span></li>';
			}, $items ) ),
			$month === $next ? '<em>' . ( $month === $now ? '이번 달' : '다가오는 일정' ) . '</em>' : ''
		);
	}

	$applying = eb_applying_html_or_fallback();


	$GLOBALS['eb_calendar_used'] = true;
	return '<div class="eb-cal" id="eb-cal" data-set="' . esc_attr( wp_json_encode( $data ) ) . '">'
		. '<div class="eb-tabs__list eb-cal__tabs" role="tablist">'
		. '<button type="button" role="tab" data-tab="calendar" aria-selected="true">월간 달력</button>'
		. '<button type="button" role="tab" data-tab="yearly" aria-selected="false">연간 신청 일정</button>'
		. '<button type="button" role="tab" data-tab="applying" aria-selected="false">지금 신청 중</button>'
		. '</div>'
		. '<div class="eb-cal__panel" data-panel="calendar">'
		. '<div class="eb-cal__chips" aria-label="급여 골라 보기">' . $chips . '</div>'
		. '<div class="eb-cal__head"><button type="button" class="eb-cal__nav" data-step="-1" aria-label="이전 달">‹</button><strong class="eb-cal__title"></strong><button type="button" class="eb-cal__nav" data-step="1" aria-label="다음 달">›</button></div>'
		. '<div class="eb-cal__grid" role="grid"></div>'
		. '<div class="eb-cal__legend"><span><i class="is-a"></i>20일 지급</span><span><i class="is-b"></i>25일 지급</span><span><i class="is-start"></i>신청·납부 시작</span><span><i class="is-due"></i>신청·납부 마감</span><span><i class="is-hol"></i>공휴일</span><span><i class="is-today"></i>오늘</span></div>'
		. '<ul class="eb-cal__list"></ul>'
		. '<p class="eb-cal__note">정해진 지급일이 토·일요일이나 공휴일이면 그 전 평일에 지급됩니다. 신청·납부 마감일이 토·일요일이나 공휴일이면 다음 평일까지로 늘어납니다. 지자체·기관 사정에 따라 달라질 수 있으니 정확한 날짜는 담당 기관에서 확인하세요.</p>'
		. '</div>'
		. '<div class="eb-cal__panel" data-panel="yearly" hidden><ol class="eb-cal__timeline">' . $timeline . '</ol><p class="eb-cal__note">해마다 같은 시기에 반복되는 일정입니다. 정확한 날짜는 그해 국세청·보건복지부 공고를 확인하세요.</p></div>'
		. '<div class="eb-cal__panel" data-panel="applying" hidden>' . $applying . '</div>'
		. '</div>';
} );

// '지금 신청 중' 탭: ① 지금 접수 기간인 법정 신청·신고(eb_deadline_rules, 자동) ② "신청 중" 태그 글(12번) ③ 둘 다 없으면 최근 글
function eb_applying_html_or_fallback() {
	// 복지 일정 플러그인(eb-schedule)이 켜져 있으면 정부24·법정·직접 추가 일정 전체 보드 + '신청 중' 태그 글 (2026-10-10)
	if ( function_exists( 'ebs_board_html' ) ) {
		$list = do_shortcode( '[eb_applying title="" limit="20"]' );
		return ebs_board_html( array( 'view' => 'full', 'title' => '' ) ) . ( '' !== $list ? '<p class="eb-cal__sub">신청 중인 지원사업 안내</p>' . $list : '' );
	}
	$today = current_datetime()->setTime( 0, 0 );
	$y     = (int) $today->format( 'Y' );
	$open  = array();
	foreach ( eb_deadline_rules() as $r ) {
		$start = new DateTimeImmutable( $y . '-' . $r[2], wp_timezone() );
		$end   = eb_due_date( $y, $r[3] );
		if ( $start <= $today && $today <= $end ) {
			$open[ $r[1] ] = array( $start, $end );
		}
	}
	uasort( $open, function ( $a, $b ) {
		return $a[1] <=> $b[1];
	} );
	$html = '';
	if ( $open ) {
		$html .= '<p class="eb-cal__sub">지금 접수 중인 신청·신고 <small>해마다 같은 시기</small></p><ul class="eb-applying eb-applying--due">';
		foreach ( $open as $name => $p ) {
			$diff  = (int) $today->diff( $p[1] )->days;
			$html .= sprintf(
				'<li data-e="%1$s"><span class="eb-applying__badge">접수 중</span><span class="eb-applying__what">%2$s<small>%3$s~%4$s 마감</small></span><b class="eb-applying__dday">%5$s</b></li>',
				esc_attr( $p[1]->format( 'Y-m-d' ) ),
				esc_html( $name ),
				esc_html( $p[0]->format( 'n.j' ) ),
				esc_html( eb_payday_label( $p[1] ) ),
				0 === $diff ? '오늘 마감' : 'D-' . $diff
			);
		}
		$html .= '</ul>';
		// 캐시된 페이지여도 방문자 날짜로 D-day를 다시 계산하고, 마감이 지난 줄은 숨김
		$html .= "<script nowprocket>(function(){var n=new Date(),t=new Date(n.getFullYear(),n.getMonth(),n.getDate());document.querySelectorAll('.eb-applying--due li[data-e]').forEach(function(li){var v=Math.round((new Date(li.getAttribute('data-e')+'T00:00:00')-t)/864e5);if(v<0){li.hidden=true;return;}li.querySelector('.eb-applying__dday').textContent=v?'D-'+v:'오늘 마감';});})();</script>";
	}
	$list = do_shortcode( '[eb_applying title="" limit="20"]' );
	if ( '' !== $list ) {
		return $html . ( $open ? '<p class="eb-cal__sub">신청 중인 지원사업 안내</p>' : '' ) . $list;
	}
	$ids = get_posts( array( 'posts_per_page' => 5, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	return $html . '<p class="eb-applying__empty">' . ( $open ? '새 지원사업 공고가 나오면 이곳에 함께 표시됩니다.' : '지금 신청을 받고 있는 지원사업이 새로 올라오면 이곳에 바로 표시됩니다.' ) . '</p>'
		. '<p class="eb-cal__sub">최근 업데이트된 지원 정보</p><div class="eb-board">' . eb_home_rows( $ids ) . '</div>';
}

add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_calendar_used'] ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.getElementById('eb-cal');
	if (!box) { return; }
	var d = JSON.parse(box.getAttribute('data-set')), W = ['일', '월', '화', '수', '목', '금', '토'];
	var idx = 0, key = '';
	try { key = localStorage.getItem('eb_cal_key') || ''; } catch (e) {}
	if (key && key !== 'due' && !d.benefits[key]) { key = ''; }
	var now = new Date(), today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
	function pad(n) { return (n < 10 ? '0' : '') + n; }
	function ymd(y, m, day) { return y + '-' + pad(m) + '-' + pad(day); }
	function keysOn(s) { return key === 'due' ? [] : (d.events[s] || []).filter(function (k) { return !key || k === key; }); }
	// 신청·납부 기간: 칩 '전체'·'신청·마감'에서만 보임
	function duesOn(s) { return !key || key === 'due' ? (d.dues[s] || []).filter(function (x) { return !x[5] || (window.ebsRegionOk && window.ebsRegionOk(x[5])); }) : []; } // [5] = 지역 사업('시도|시군구'): 우리 지역일 때만 (eb-schedule, 2026-10-10)
	function daysTo(s) { var p = s.split('-'); return Math.round((new Date(+p[0], p[1] - 1, +p[2]) - today) / 86400000); }
	// 오늘이 속한 달부터 보이기 (캐시된 페이지여도 방문자 날짜 기준)
	d.months.forEach(function (m, i) { if (m[0] === today.getFullYear() && m[1] === today.getMonth() + 1) { idx = i; } });
	var cur = {}, grid = box.querySelector('.eb-cal__grid'), list = box.querySelector('.eb-cal__list');
	var tip = document.createElement('div');
	tip.className = 'eb-cal__tip';
	tip.hidden = true;
	box.appendChild(tip);

	function render() {
		var y = d.months[idx][0], m = d.months[idx][1];
		box.querySelector('.eb-cal__title').textContent = y + '년 ' + m + '월';
		box.querySelectorAll('.eb-cal__nav').forEach(function (b) {
			var t = idx + Number(b.getAttribute('data-step'));
			b.disabled = t < 0 || t >= d.months.length;
		});
		var first = new Date(y, m - 1, 1).getDay(), last = new Date(y, m, 0).getDate(), h = '', rows = [];
		cur = {};
		tip.hidden = true;
		W.forEach(function (w, i) { h += '<div class="eb-cal__w' + (i === 0 ? ' is-sun' : i === 6 ? ' is-sat' : '') + '">' + w + '</div>'; });
		for (var i = 0; i < first; i++) { h += '<div class="eb-cal__d is-empty"></div>'; }
		for (var day = 1; day <= last; day++) {
			var s = ymd(y, m, day), wd = (first + day - 1) % 7, ks = keysOn(s), ds = duesOn(s), hol = d.holidays[s];
			var cls = 'eb-cal__d' + (wd === 0 ? ' is-sun' : wd === 6 ? ' is-sat' : '') + (hol ? ' is-hol' : '');
			if (new Date(y, m - 1, day).getTime() === today.getTime()) { cls += ' is-today'; }
			var pills = '', groups = {}, seen = {}, dp = [];
			ks.forEach(function (k) { groups[d.benefits[k][2]] = true; });
			Object.keys(groups).forEach(function (g) {
				var label = key ? d.benefits[key][0] : (g === 'a' ? '20일 지급' : '25일 지급');
				pills += '<span class="eb-cal__pill is-' + g + '">' + label + '</span>';
			});
			// 신청·납부: '자동차세 마감'처럼 짧은 이름으로, 한 칸에 2개까지 + 나머지는 +N
			ds.forEach(function (x) {
				var t = x[3] + ' ' + (x[0] === 'e' ? '마감' : '시작');
				if (!seen[t]) { seen[t] = true; dp.push('<span class="eb-cal__pill is-' + (x[0] === 'e' ? 'due' : 'start') + (x[5] ? ' is-local' : '') + '">' + t + '</span>'); }
			});
			pills += dp.slice(0, 2).join('') + (dp.length > 2 ? '<span class="eb-cal__pill is-more">+' + (dp.length - 2) + '</span>' : '');
			var ev = ks.length || ds.length;
			if (ev) { rows.push({ s: s, day: day, wd: wd, ks: ks, ds: ds }); cur[s] = rows[rows.length - 1]; }
			h += '<div class="' + cls + (ev ? ' has-ev" data-s="' + s + '" tabindex="0' : '') + '"><span class="eb-cal__num">' + day + '</span>' + (hol ? '<span class="eb-cal__hol">' + hol + '</span>' : '') + pills + '</div>';
		}
		box.querySelector('.eb-cal__grid').innerHTML = h;
		box.querySelector('.eb-cal__list').innerHTML = rows.length ? rows.map(function (r) {
			var date = '<span class="eb-cal__date">' + m + '.' + r.day + '(' + W[r.wd] + ')</span>';
			return lines(r).map(function (l) {
				return '<li data-s="' + r.s + '" class="' + l.cls + '">' + date + '<span class="eb-cal__what">' + l.text + (l.sub ? '<small>' + l.sub + '</small>' : '') + '</span><b>' + l.tag + '</b></li>';
			}).join('');
		}).join('') : '<li>' + (key === 'due' ? '이번 달에는 신청·납부 마감 일정이 없습니다.' : key ? '이번 달에는 선택한 급여의 지급일이 없습니다.' : '이번 달에는 표시할 일정이 없습니다.') + '</li>';
		box.querySelectorAll('.eb-cal__chips button').forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-key') === key ? 'true' : 'false'); });
	}

	// 하루 일정 줄: 아래 목록과 마우스 말풍선이 같이 씀 {mark: 색, cls, text, sub: 기간, tag: D-day}
	function lines(r) {
		var diff = daysTo(r.s), out = [];
		if (r.ks.length) {
			out.push({ mark: d.benefits[r.ks[0]][2], cls: diff < 0 ? 'is-past' : '', text: r.ks.map(function (k) { return d.benefits[k][0]; }).join(' · ') + ' 지급', sub: '', tag: diff > 0 ? 'D-' + diff : diff === 0 ? '오늘' : '지급 완료' });
		}
		r.ds.forEach(function (x) {
			var left = daysTo(x[2]), past = left < 0, tag;
			if (x[0] === 'e') { tag = left > 0 ? 'D-' + left : left === 0 ? '오늘 마감' : '마감'; }
			else { tag = diff > 0 ? 'D-' + diff : past ? '마감' : '진행 중'; }
			out.push({ mark: x[0] === 'e' ? 'due' : 'start', cls: 'is-' + x[0] + (past ? ' is-past' : ''), text: x[1] + (x[0] === 'e' ? ' 마감' : ' 시작'), sub: '기간 ' + x[4], tag: tag });
		});
		return out;
	}

	box.querySelectorAll('.eb-cal__nav').forEach(function (b) {
		b.addEventListener('click', function () { idx += Number(b.getAttribute('data-step')); render(); });
	});
	box.querySelectorAll('.eb-cal__chips button').forEach(function (b) {
		b.addEventListener('click', function () {
			key = b.getAttribute('data-key');
			try { localStorage.setItem('eb_cal_key', key); } catch (e) {}
			render();
		});
	});

	// 우리 지역을 바꾸면(eb-schedule 보드) 다시 그림
	document.addEventListener('ebs:region', function () { render(); });

	// PC(마우스): 일정 있는 날짜 칸에 올리면 그날 일정 전체를 말풍선으로
	if (window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
		grid.addEventListener('mouseover', function (e) {
			var c = e.target.closest('.has-ev');
			if (!c) { tip.hidden = true; return; }
			var r = cur[c.getAttribute('data-s')];
			if (!r || (!tip.hidden && tip.getAttribute('data-s') === r.s)) { return; }
			tip.innerHTML = '<strong>' + d.months[idx][1] + '월 ' + r.day + '일(' + W[r.wd] + ')</strong><ul>' + lines(r).map(function (l) {
				return '<li><i class="is-' + l.mark + '"></i><span>' + l.text + '<small>' + (l.sub ? l.sub + ' · ' : '') + l.tag + '</small></span></li>';
			}).join('') + '</ul>';
			tip.setAttribute('data-s', r.s);
			tip.hidden = false;
			var b = box.getBoundingClientRect(), cr = c.getBoundingClientRect();
			tip.style.top = (cr.bottom - b.top + 6) + 'px';
			tip.style.left = Math.max(0, Math.min(cr.left - b.left, b.width - tip.offsetWidth)) + 'px';
		});
		grid.addEventListener('mouseleave', function () { tip.hidden = true; });
	}
	// 날짜 칸을 누르면(휴대폰 포함) 아래 목록의 그날 줄로 이동해 잠깐 강조
	function jump(c) {
		var rowsOf = list.querySelectorAll('li[data-s="' + c.getAttribute('data-s') + '"]');
		if (!rowsOf.length) { return; }
		tip.hidden = true;
		rowsOf[0].scrollIntoView({ block: 'center', behavior: 'smooth' });
		rowsOf.forEach(function (li) {
			li.classList.remove('is-flash');
			li.offsetWidth;
			li.classList.add('is-flash');
		});
	}
	grid.addEventListener('click', function (e) { var c = e.target.closest('.has-ev'); if (c) { jump(c); } });
	grid.addEventListener('keydown', function (e) {
		var c = e.target.closest('.has-ev');
		if (c && (e.key === 'Enter' || e.key === ' ')) { e.preventDefault(); jump(c); }
	});

	// 탭: 메뉴의 #calendar · #yearly · #applying 주소로 바로 열림
	var tabs = box.querySelectorAll('[data-tab]');
	function show(name, scroll) {
		var ok = false;
		tabs.forEach(function (t) { if (t.getAttribute('data-tab') === name) { ok = true; } });
		if (!ok) { return; }
		tabs.forEach(function (t) { t.setAttribute('aria-selected', t.getAttribute('data-tab') === name ? 'true' : 'false'); });
		box.querySelectorAll('[data-panel]').forEach(function (p) { p.hidden = p.getAttribute('data-panel') !== name; });
		if (scroll) { box.scrollIntoView({ block: 'start' }); }
	}
	tabs.forEach(function (t) {
		t.addEventListener('click', function () {
			var name = t.getAttribute('data-tab');
			show(name);
			if (history.replaceState) { history.replaceState(null, '', '#' + name); }
		});
	});
	// 날짜로 바로 열기: /schedule/#d-2026-11-30 → 그달 달력 + 아래 목록의 그날 줄 강조 (휴대폰 메뉴 '다가오는 일정', 20·46번)
	function fromHash(scroll) {
		var hsh = location.hash.replace('#', ''), dm = hsh.match(/^d-(\d{4})-(\d{2})-(\d{2})$/);
		if (dm) {
			d.months.forEach(function (m, i) { if (m[0] === +dm[1] && m[1] === +dm[2]) { idx = i; } });
			key = '';
			render();
			show('calendar');
			// 페이지를 불러오는 중에 스크롤하면 브라우저가 취소하므로 다 불러온 뒤 이동
			var go = function () {
				var c = grid.querySelector('[data-s="' + dm[1] + '-' + dm[2] + '-' + dm[3] + '"]');
				if (c) { jump(c); } else if (scroll) { box.scrollIntoView({ block: 'start' }); }
			};
			if (document.readyState === 'complete') { go(); } else { window.addEventListener('load', function () { setTimeout(go, 50); }); }
			return;
		}
		if (hsh === 'monthly') { hsh = 'calendar'; }
		if (hsh) { show(hsh, scroll); }
	}
	window.addEventListener('hashchange', function () { fromHash(true); });
	render();
	fromHash(true);
})();
JS
	. "\n</script>\n";
}, 75 );

/* 22. 바탕색 - 홈·카테고리·검색 결과에 body.eb-bg (style.css 26번). 글 본문 페이지는 흰 바탕 유지 ---------- */
add_filter( 'body_class', function ( $classes ) {
	if ( is_front_page() || is_archive() || is_search() ) {
		$classes[] = 'eb-bg';
	}
	return $classes;
} );

/* 23. 콤팩트 푸터 - GP 푸터 위젯 4칸·저작권 줄 대신 출력 (style.css 27번) ------------------------ */
add_action( 'wp', function () {
	remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
	remove_action( 'generate_footer', 'generate_construct_footer' );
	add_action( 'generate_footer', 'eb_footer' );
} );

function eb_footer() {
	// 2026-10-08 개편: 흰 바탕·헤더와 같은 로고, PC 로고+상담 전화 4개+링크 5열 / 휴대폰은 묶음별 한 줄 목록 (추가 CSS '푸터' 블록)
	$cols = array(
		'분야별 정보'   => array(
			'/welfare/' => '복지·지원금',
			'/life/'    => '건강·생활',
			'/finance/' => '금융·사업자',
			'/work/'    => '노동·민원',
			'/guide/'   => '상황별 가이드',
		),
		'바로 쓰는 도구' => array(
			'/find/'       => '맞춤 혜택 찾기',
			'/calculator/' => '복지 계산기',
			'/schedule/'   => '복지 캘린더',
			'/standards/'  => '2026 기준표',
			'/forms/'      => '공식 서식 모음',
			'/address/'    => '주소·영문주소 찾기',
		),
		'도움 받기'     => array(
			'/nearby/'   => '우리 동네 복지 기관',
			'/hotline/'  => '긴급·상담 전화',
			'/glossary/' => '복지 용어사전',
			'/links/'    => '공식 기관 모음',
			'/senior-equipment/' => '어르신 복지용구',
		),
		'이지복지닷컴'   => array(
			'/about/'         => '사이트 소개',
			'/contact/'       => '문의하기',
			'/faq/'           => '자주 묻는 질문', // 76번(2026-10-17)
			'/partners/'      => '협업·제휴',
			'/support/#topic' => '주제 제안',
			'/support/'       => '후원·돕는 방법',
		),
	);
	// 휴대폰에서는 숨김(홈 '공식 기관 바로가기'와 겹침). 목록은 eb_org_list() 앞 6곳 - 홈·사이드바와 같은 순서(2026-10-16)
	$orgs = array();
	foreach ( array_slice( eb_org_list(), 0, 6 ) as $o ) {
		$orgs[ $o[0] ] = $o[1];
	}
	// 긴급·상담 전화(/hotline/, 43번)에 있는 번호 중 자주 찾는 4개
	$tels = array(
		'129'  => '보건복지상담',
		'110'  => '정부민원안내',
		'1350' => '고용노동부',
		'109'  => '자살예방',
	);
	$info = array(
		'/privacy-policy/'   => '개인정보처리방침',
		'/terms-of-service/' => '이용약관',
		'/disclaimer/'       => '면책공고',
	);
	$last = get_posts( array( 'posts_per_page' => 1, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	$meta = '정보 ' . number_format_i18n( (int) wp_count_posts( 'post' )->publish ) . '건' . ( $last ? ' · ' . get_the_modified_date( 'Y.m.d', $last[0] ) . ' 업데이트' : '' ) . ' · © 2023–' . wp_date( 'Y' ) . ' 이지복지닷컴';

	// 푸터 위 '찾는 정보가 없나요?' 띠 - 콘텐츠와 푸터 사이 빈 공간 대신 주제 제안·오류 제보로 연결 (문의하기·돕는 방법 페이지에서는 뺌, style.css 81번, 2026-10-09)
	$cta = '';
	if ( ! is_page( array( 13883, 14928, 14851, 15223 ) ) ) { // 혜택 찾기(14851)는 페이지 안에 '찾는 게 없나요?' 줄이 있어 뺌(2026-10-09), 협업(15223)은 바로 위가 제안서 폼이라 뺌(2026-10-17)
		$cta = '<section class="ebf-cta" aria-label="찾는 정보가 없을 때"><div class="ebf__in"><div class="ebf-cta__box"><div class="ebf-cta__t"><i class="ebf-cta__ic">' . eb_x_ic( 'search' ) . '</i><div><strong>찾는 정보가 없나요?</strong><span>다뤄 줬으면 하는 제도를 알려 주시면 공식 자료를 확인해 차례로 정리해요.</span></div></div>'
			. '<div class="ebf-cta__b"><a class="is-main" href="' . esc_url( home_url( '/support/#topic' ) ) . '">주제 제안하기</a><a href="' . esc_url( home_url( '/contact/' ) ) . '">오류 제보</a><a href="' . esc_url( home_url( '/find/#finder' ) ) . '">맞춤 찾기</a></div></div></div></section>';
	}
	$html  = $cta . '<footer class="ebf" aria-label="사이트 정보" itemtype="https://schema.org/WPFooter" itemscope><div class="ebf__in"><div class="ebf__top">';
	$html .= '<div class="ebf__brand"><a class="ebf__logo" href="' . esc_url( home_url( '/' ) ) . '">' . eb_wordmark() . '<span class="screen-reader-text">이지복지닷컴</span></a>';
	$html .= '<p class="ebf__desc">정부 지원금·복지 혜택·민원 서류 발급 방법을 공식 자료 기준으로 쉽게 정리합니다.</p><div class="ebf__tel" role="list" aria-label="자주 찾는 상담 전화">';
	foreach ( $tels as $num => $label ) {
		$html .= '<a role="listitem" href="tel:' . esc_attr( $num ) . '"><b>' . esc_html( $num ) . '</b>' . esc_html( $label ) . '</a>';
	}
	$html .= '</div></div>';
	foreach ( $cols as $title => $links ) {
		$html .= '<nav class="ebf__col" aria-label="' . esc_attr( $title ) . '"><h2>' . esc_html( $title ) . '</h2><ul>';
		foreach ( $links as $url => $label ) {
			$html .= '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		}
		$html .= '</ul></nav>';
	}
	$html .= '<nav class="ebf__col ebf__col--org" aria-label="자주 찾는 공식 기관"><h2>자주 찾는 공식 기관</h2><ul>';
	foreach ( $orgs as $url => $label ) {
		$html .= '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( $label ) . '</a></li>';
	}
	$html .= '</ul></nav></div><div class="ebf__bot"><div class="ebf__legal">';
	foreach ( $info as $url => $label ) {
		$html .= '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
	}
	$html .= '</div><span>' . esc_html( $meta ) . '</span><p class="ebf__note">공식 기관이 아닌 민간 정보 사이트예요. 신청 전에는 담당 기관에서 한 번 더 확인해 주세요. 콘텐츠를 공유할 때는 출처를 밝혀 주세요.</p></div>';
	// 지급일 데이터만 숨겨서 둠 - 휴대폰 옆 메뉴 '다가오는 일정' 카드(20번 스크립트)가 .eb-foot__pay[data-pay]를 읽음
	$html .= '<div hidden>' . eb_footer_pay() . '</div></div></footer>';
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
}

// 휴대폰 하단 탭 바: 홈·검색·맞춤 찾기(가운데 강조)·계산기·메뉴(옆 메뉴 열기) - 화면 폭 768px 미만에서만 보임, 입력칸을 누르면 잠시 숨김 (style.css 81·84번, 2026-10-09 개편)
// '검색'은 68-2번 검색 화면(#ebsr), '메뉴'는 68번 전체 메뉴(#ebm)를 엶
add_action( 'wp_footer', function () {
	$path  = (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/', PHP_URL_PATH ); // phpcs:ignore
	$items = array(
		array( '/', 'home', '홈', '' ),
		'search',
		array( '/find/', 'compass', '맞춤 찾기', 'ebt__main' ),
		array( '/calculator/', 'calc', '계산기', '' ),
	);
	$html  = '<nav class="ebt" aria-label="빠른 메뉴">';
	foreach ( $items as $it ) {
		if ( 'search' === $it ) {
			$html .= '<button type="button" class="ebt__search' . ( is_search() ? ' is-on' : '' ) . '" aria-label="검색 열기" aria-haspopup="dialog" aria-expanded="false">' . eb_x_ic( 'search' ) . '<span>검색</span></button>';
			continue;
		}
		$on    = '/' === $it[0] ? ( '/' === $path && ! is_search() ) : ( 0 === strpos( $path, $it[0] ) ); // 검색 결과(/?s=)는 홈이 아니라 검색 탭이 켜짐(2026-10-16)
		$cls   = trim( $it[3] . ( $on ? ' is-on' : '' ) );
		$icon  = $it[3] ? '<i>' . eb_x_ic( $it[1] ) . '</i>' : eb_x_ic( $it[1] );
		$html .= '<a href="' . esc_url( home_url( $it[0] ) ) . '"' . ( $cls ? ' class="' . esc_attr( $cls ) . '"' : '' ) . ( $on ? ' aria-current="page"' : '' ) . '>' . $icon . '<span>' . esc_html( $it[2] ) . '</span></a>';
	}
	$html .= '<button type="button" class="ebt__menu" aria-label="전체 메뉴 열기"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg><span>메뉴</span></button></nav>';
	// 검색 창은 68-2번 검색 화면(#ebsr)이 맡음 - 하단 탭 '검색'·전체 메뉴 검색 막대가 같은 화면을 엶(2026-10-16, 예전 위에서 내려오던 .ebt-s 삭제). '메뉴'는 68번이 가로챔
	$html .= "<script nowprocket>(function(){var n=document.querySelector('.ebt');if(!n){return;}document.addEventListener('focusin',function(e){if(e.target.matches('input,textarea,select')){n.classList.add('is-hidden');}});document.addEventListener('focusout',function(){n.classList.remove('is-hidden');});})();</script>";
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
}, 30 );

// 푸터: 마지막 업데이트 날짜·공개 글 수
function eb_footer_meta() {
	$last = get_posts( array( 'posts_per_page' => 1, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	if ( ! $last ) {
		return '';
	}
	return sprintf(
		'<p class="eb-foot__meta">마지막 업데이트 <b>%1$s</b> · 정보 <b>%2$s</b>건</p>',
		esc_html( get_the_modified_date( 'Y.m.d', $last[0] ) ),
		esc_html( number_format_i18n( (int) wp_count_posts( 'post' )->publish ) )
	);
}

// 푸터: 다가오는 지급일 두 건 (화면에서 방문자 날짜 기준으로 다시 계산)
function eb_footer_pay() {
	$today = current_datetime()->setTime( 0, 0 );
	$items = array();
	for ( $i = 0; $i < 3; $i++ ) {
		$m = $today->modify( 'first day of this month' )->modify( "+{$i} month" );
		foreach ( eb_payday_groups() as $day => $what ) {
			$date    = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $day );
			$parts   = explode( '·', $what );
			$items[] = array(
				'd' => $date->format( 'Y-m-d' ),
				'l' => eb_payday_label( $date ),
				// '생계급여 외 2종'처럼 같은 날 함께 나오는 급여 수까지 (휴대폰 메뉴·PC 메뉴·푸터 공통)
				'w' => $parts[0] . ( count( $parts ) > 1 ? ' 외 ' . ( count( $parts ) - 1 ) . '종' : '' ),
			);
		}
	}
	usort( $items, function ( $a, $b ) {
		return strcmp( $a['d'], $b['d'] );
	} );
	$list = '';
	$n    = 0;
	foreach ( $items as $item ) {
		$date = new DateTimeImmutable( $item['d'], wp_timezone() );
		if ( $date < $today || $n >= 2 ) {
			continue;
		}
		$diff  = (int) $today->diff( $date )->days;
		$list .= '<li><span>' . esc_html( $item['l'] . ' ' . $item['w'] ) . '</span><b>' . ( $diff ? 'D-' . $diff : '오늘' ) . '</b></li>';
		$n++;
	}
	return '<div class="eb-foot__pay" data-pay="' . esc_attr( wp_json_encode( $items ) ) . '"><strong>다가오는 지급일</strong><ul>' . $list . '</ul><a href="/schedule/">복지 캘린더 보기 →</a></div>';
}

/* 24. 홈 '복지 정책 새 소식' - 보건복지부 보도자료 RSS(공식 제공)에서 제목·날짜·링크만 (style.css 28번) ------
 * 정책브리핑 RSS는 2026-07-01 저작권 보호를 이유로 중단되어 쓰지 않습니다. 본문은 가져오지 않고 원문 링크로 연결합니다.
 */
function eb_mohw_news() {
	$items = get_transient( 'eb_mohw_news' );
	if ( false !== $items ) {
		return $items;
	}
	$items = array();
	$res   = wp_remote_get( 'https://www.mohw.go.kr/rss/board.es?mid=a10503000000&bid=0027', array( 'timeout' => 8 ) );
	if ( ! is_wp_error( $res ) && 200 === wp_remote_retrieve_response_code( $res ) && function_exists( 'simplexml_load_string' ) ) {
		$xml = simplexml_load_string( wp_remote_retrieve_body( $res ), 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING );
		if ( $xml && isset( $xml->channel->item ) ) {
			foreach ( $xml->channel->item as $item ) {
				$link = (string) $item->link;
				if ( 0 !== strpos( $link, 'https://www.mohw.go.kr/' ) ) {
					continue;
				}
				$items[] = array(
					'title' => trim( wp_strip_all_tags( (string) $item->title ) ),
					'link'  => $link,
					'date'  => (int) strtotime( (string) $item->pubDate ),
				);
			}
		}
	}
	if ( $items ) {
		update_option( 'eb_mohw_news_last', $items, false );
		set_transient( 'eb_mohw_news', $items, 3 * HOUR_IN_SECONDS );
	} else {
		// 불러오지 못하면 마지막으로 받은 목록을 쓰고 1시간 뒤 다시 시도
		$items = get_option( 'eb_mohw_news_last', array() );
		set_transient( 'eb_mohw_news', $items, HOUR_IN_SECONDS );
	}
	return $items;
}

function eb_home_news() {
	$all = eb_mohw_news();
	if ( ! $all ) {
		return '';
	}
	// 복지·지원 관련 소식을 먼저, 인사·행사 소식은 뒤로
	$want = '/복지|급여|연금|수당|바우처|돌봄|아동|노인|어르신|고령|장애|청년|기초|생계|의료비|치료비|건강보험|간병|출산|부모|임신|주거|자립/u';
	$skip = '/취임|병원장|국립\S*병원|개교|포럼|인사|명단 공표/u';
	$pick = array();
	foreach ( array( true, false ) as $first ) {
		foreach ( $all as $item ) {
			if ( count( $pick ) >= 5 || in_array( $item, $pick, true ) ) {
				continue;
			}
			$good = preg_match( $want, $item['title'] ) && ! preg_match( $skip, $item['title'] );
			if ( $good === $first ) {
				$pick[] = $item;
			}
		}
	}
	$rows = '';
	foreach ( $pick as $item ) {
		$rows .= sprintf(
			'<li><a href="%1$s" target="_blank" rel="noopener"><span class="eb-rows__tag">보도자료</span><span class="eb-rows__title">%2$s</span></a><time datetime="%3$s">%4$s</time></li>',
			esc_url( $item['link'] ),
			esc_html( $item['title'] ),
			esc_attr( wp_date( 'c', $item['date'] ) ),
			esc_html( wp_date( 'm.d', $item['date'] ) )
		);
	}
	return '<section class="eb-home-news" aria-labelledby="eb-home-news-title"><div class="eb-quickfind__head"><h2 id="eb-home-news-title" class="eb-quickfind__title">복지 정책 새 소식</h2><a class="eb-quickfind__more" href="https://www.mohw.go.kr/board.es?mid=a10503000000&amp;bid=0027" target="_blank" rel="noopener">보건복지부 보도자료 →</a></div>'
		. '<ul class="eb-rows">' . $rows . '</ul><p class="eb-home-news__src">출처: 보건복지부 보도자료 · 제목을 누르면 보건복지부 누리집에서 원문을 볼 수 있습니다.</p></section>';
}

// 15-4 목차: 본문 목차 제목 "이 글의 순서 · N개", 긴 목차 "모두 보기", PC 사이드바 따라오는 목차(지금 읽는 위치 표시) (style.css 7번)
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var wrap = document.querySelector('.entry-content .tocer');
	if (!wrap) { return; }
	function curNav() { return wrap.querySelector('.tocer-toc:not(.tocer-hidden)') || wrap.querySelector('.tocer-toc'); }
	function topsOf(list) { return Array.prototype.filter.call(list.children, function (li) { return li.tagName === 'LI'; }); }

	var nav = curNav(), list = nav && nav.querySelector('.tocer-list.tocer-lvl1');
	if (!list) { return; }
	var tops = topsOf(list);

	// 본문 목차 꾸미기: Tocer가 관리하는 목차 안쪽은 건드리지 않음(플러그인 오류 방지).
	// 제목 "이 글의 순서 · N개 · 약 n분"은 CSS(--eb-toc-count), '모두 보기' 버튼은 목차 상자 바깥에 둠
	// 읽는 시간: 공백 뺀 본문 글자 수 ÷ 500자(1분)
	var body = wrap.closest('.entry-content');
	var mins = Math.max(1, Math.round((body.innerText || '').replace(/\s+/g, '').length / 500));
	wrap.style.setProperty('--eb-toc-count', '"' + tops.length + '개 · 약 ' + mins + '분"');
	wrap.classList.add('eb-toc-ready');
	if (list.querySelectorAll('a').length > 14) {
		wrap.classList.add('eb-toc-long');
		var more = document.createElement('button');
		more.type = 'button';
		more.className = 'eb-toc-more';
		more.textContent = '목차 모두 보기';
		more.addEventListener('click', function () {
			var open = wrap.classList.toggle('eb-toc-open');
			more.textContent = open ? '목차 접기' : '목차 모두 보기';
		});
		wrap.parentNode.insertBefore(more, wrap.nextSibling);
	}

	// PC 사이드바 따라오는 목차 (글 페이지는 38번 '이 글의 목차'(.eb-sticky)가 대신하므로 만들지 않음 — 두 개가 겹쳐 보이던 문제)
	var area = document.getElementById('right-sidebar');
	if (!area || tops.length < 2 || area.querySelector('.eb-sticky')) { return; }
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	var items = [], html = '';
	tops.forEach(function (li, i) {
		var a = li.querySelector(':scope > div > a');
		if (!a) { return; }
		var subs = Array.prototype.map.call(li.querySelectorAll('.tocer-sublist > li > div > a'), function (s) { return { h: s.getAttribute('href'), t: s.textContent.trim() }; });
		items.push({ h: a.getAttribute('href'), t: a.textContent.trim(), subs: subs });
		html += '<li><a href="' + esc(a.getAttribute('href')) + '">' + (i + 1) + ' ' + esc(a.textContent.trim()) + '</a>'
			+ (subs.length ? '<ul>' + subs.map(function (s) { return '<li><a href="' + esc(s.h) + '">' + esc(s.t) + '</a></li>'; }).join('') + '</ul>' : '') + '</li>';
	});
	var box = document.createElement('aside');
	box.className = 'eb-sidetoc';
	box.setAttribute('aria-label', '목차');
	box.innerHTML = '<div class="eb-sidetoc__head">목차<small><span>1</span> / ' + items.length + '</small></div><div class="eb-sidetoc__bar"><i></i></div><ol>' + html + '</ol>';
	area.appendChild(box);

	var links = box.querySelectorAll('a'), targets = [];
	links.forEach(function (a) {
		var id = decodeURIComponent((a.getAttribute('href') || '').replace(/^#/, ''));
		var el = id ? document.getElementById(id) : null;
		if (el) { targets.push({ a: a, el: el, top: a.parentNode.parentNode === box.querySelector('ol') }); }
	});
	var article = document.querySelector('.entry-content'), cur = box.querySelector('small span'), bar = box.querySelector('.eb-sidetoc__bar i');
	var ticking = false;
	function update() {
		ticking = false;
		box.classList.toggle('is-visible', wrap.getBoundingClientRect().bottom < 0);
		var active = null;
		targets.forEach(function (t) { if (t.el.getBoundingClientRect().top < 120) { active = t; } });
		links.forEach(function (a) { a.classList.remove('is-on'); });
		box.querySelectorAll('ol > li').forEach(function (li) { li.classList.remove('is-open'); });
		if (active) {
			active.a.classList.add('is-on');
			var topLi = active.a.closest('ol > li');
			topLi.classList.add('is-open');
			if (!active.top) { topLi.querySelector(':scope > a').classList.add('is-on'); }
			cur.textContent = Array.prototype.indexOf.call(topLi.parentNode.children, topLi) + 1;
			var onA = active.a, ol = box.querySelector('ol');
			if (onA.offsetTop < ol.scrollTop || onA.offsetTop > ol.scrollTop + ol.clientHeight - 30) { ol.scrollTop = onA.offsetTop - 40; }
		}
		var r = article.getBoundingClientRect();
		var done = Math.min(1, Math.max(0, -r.top / Math.max(1, r.height - window.innerHeight)));
		bar.style.width = Math.round(done * 100) + '%';
	}
	window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
	window.addEventListener('resize', update);
	update();
})();
JS
	. "\n</script>\n";
}, 50 );

/* 25. 광고 제외 페이지 - Advanced Ads(자동광고 코드 포함)가 아래 페이지에서는 광고를 내지 않음 ----------
 * 404는 Advanced Ads 설정(일반 > 광고 비활성화 > 404)에서 끔. 여기서는 내용이 거의 없는 페이지와 결과 없는 검색.
 * 문의하기 13883, 저장한 글 14937, 개인정보처리방침 13874, 이용약관 13913, 면책공고 13898, 응원하기 14928
 */
add_filter( 'advanced-ads-ad-display-check', function ( $checks ) {
	if ( ! is_array( $checks ) ) {
		return $checks;
	}
	$off = is_page( array( 13883, 14937, 13874, 13913, 13898, 14928 ) );
	if ( ! $off && is_search() ) {
		global $wp_query;
		$off = empty( $wp_query->found_posts );
	}
	$checks['eb_exclude'] = array(
		'check' => $off,
		'args'  => array( 'page' ),
	);
	return $checks;
} );

/* 26. 홈·목록 광고 칸 - Advanced Ads 수동 배치(home-mid · home-bottom · list-mid)를 정해진 자리에만 (style.css 31번) ----------
 * 홈: 계산기 아래 ①, 새 소식 아래 ② (18번 eb_home_html). 카테고리·태그 목록: 5번째 글 다음 한 칸.
 * 광고가 꺼진 페이지·관리자 로그인 땐 Advanced Ads가 빈 값을 주므로 칸도 안 생김.
 */
function eb_ad_slot( $slug, $class = '' ) {
	if ( ! function_exists( 'get_the_placement' ) ) {
		return '';
	}
	// 관리자: 광고를 부르지 않고 같은 자리에 '광고 자리' 상자 - 독자 화면 레이아웃 확인용 (38번 사이드바와 같은 방식, style.css 71번, 2026-10-08)
	if ( current_user_can( 'edit_posts' ) ) {
		return '<div class="eb-ad eb-ad--ph ' . esc_attr( $class ) . '" data-slot="' . esc_attr( $slug ) . '">광고 자리 · ' . esc_html( $slug ) . '<small>관리자에게만 보임</small></div>';
	}
	$ad = get_the_placement( $slug );
	// 멀티플렉스(autorelaxed) 레이아웃 - 애드센스 허용 매개변수(answer/7533385, 지원 중단 예정이라 안 먹으면 구글 기본 배치)
	// 휴대폰: 사진 왼쪽·제목 오른쪽 한 줄형 4개 / PC: 사진 위·제목 아래 2줄 × 4칸 8개
	if ( $ad && false !== strpos( $ad, 'data-ad-format="autorelaxed"' ) && false === strpos( $ad, 'data-matched-content-ui-type' ) ) {
		$ad = str_replace( 'data-ad-format="autorelaxed"', 'data-ad-format="autorelaxed" data-matched-content-ui-type="image_sidebyside,image_stacked" data-matched-content-rows-num="4,2" data-matched-content-columns-num="1,4"', $ad );
	}
	return $ad ? '<div class="eb-ad ' . esc_attr( $class ) . '">' . $ad . '</div>' : '';
}

add_action( 'generate_after_do_template_part', function () {
	static $n = 0;
	if ( ! ( is_category() || is_tag() ) || ! in_the_loop() ) {
		return;
	}
	if ( 5 === ++$n ) {
		echo eb_ad_slot( 'list-mid', 'eb-ad-row' ); // phpcs:ignore
	}
} );

/* 27. 글 속 이미지 갤러리 뷰어 - 이미지를 누르면 글 속 이미지를 좌우로 넘겨 보는 창(GLightbox, MIT) (style.css 32번) --------
 * 이미지가 2장 이상인 글에서만, 처음 누를 때 GLightbox를 불러옴(평소엔 추가 로딩 없음). 글 본문은 그대로.
 * 워드프레스 기본 '확대' 대신 열림. 다른 주소로 연결된 이미지는 제외. 불러오기 실패 시 원본 이미지를 새 탭으로.
 */
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var body = document.querySelector('.entry-content');
	if (!body) { return; }
	var figs = Array.prototype.filter.call(body.querySelectorAll('figure.wp-block-image'), function (f) {
		var img = f.querySelector('img'), a = f.querySelector('a[href]');
		return img && !(a && !/\.(jpe?g|png|gif|webp|avif)(\?|$)/i.test(a.getAttribute('href')));
	});
	if (figs.length < 2) { return; }
	var CDN = 'https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/';
	function full(img) {
		var best = img.currentSrc || img.src, bw = 0;
		(img.getAttribute('srcset') || '').split(',').forEach(function (s) {
			var p = s.trim().split(/\s+/), w = parseInt(p[1], 10) || 0;
			if (p[0] && w > bw) { bw = w; best = p[0]; }
		});
		return best;
	}
	var items = figs.map(function (f) {
		var img = f.querySelector('img'), cap = f.querySelector('figcaption');
		return { href: full(img), type: 'image', alt: img.alt || '', description: cap ? cap.textContent.trim() : '' };
	});
	var box = null, loading = null, count = null;
	function load() {
		if (!loading) {
			loading = new Promise(function (ok, fail) {
				var l = document.createElement('link');
				l.rel = 'stylesheet';
				l.href = CDN + 'css/glightbox.min.css';
				document.head.appendChild(l);
				var s = document.createElement('script');
				s.src = CDN + 'js/glightbox.min.js';
				s.onload = ok;
				s.onerror = fail;
				document.head.appendChild(s);
			});
		}
		return loading;
	}
	function setCount(i) {
		var wrap = document.querySelector('.glightbox-container');
		if (!wrap) { return; }
		if (!count || !wrap.contains(count)) {
			count = document.createElement('div');
			count.className = 'eb-gl-count';
			wrap.appendChild(count);
		}
		count.textContent = (i + 1) + ' / ' + items.length;
	}
	function open(i) {
		load().then(function () {
			if (!box) {
				box = GLightbox({ elements: items, loop: false, touchNavigation: true, zoomable: true, draggable: true, openEffect: 'fade', closeEffect: 'fade' });
				box.on('slide_changed', function (d) { if (d && d.current) { setCount(d.current.slideIndex); } });
			}
			box.openAt(i);
			setTimeout(function () { setCount(i); }, 0);
		}, function () {
			window.open(items[i].href, '_blank', 'noopener');
		});
	}
	figs.forEach(function (f, i) {
		f.classList.add('eb-gallery-item');
		f.addEventListener('click', function (e) {
			if (!e.target.closest('img, .lightbox-trigger')) { return; }
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			open(i);
		}, true);
	});
})();
JS
	. "\n</script>\n";
}, 52 );

/* 28. 돕는 방법 페이지 [eb_support] - 돕는 방법 4가지(공유·제보·주제 제안·쇼핑)·주제 제안·QR·쇼핑(쿠팡·알리익스프레스) (style.css 33번) ----------
 * 앱 설치(홈 화면 추가)는 2026-10-04 휴대폰 메뉴 '앱으로 설치하기'(#install, 35번)로 옮김
 * 주제 제안은 알림판 '주제 제안' 위젯에서 확인. (숫자로 보는 이지복지·약속은 2026-10-02 삭제 - 약속 내용은 사이트 소개 '이렇게 만듭니다'와 같음)
 */
function eb_support_html() {
	$coupang = 'https://link.coupang.com/a/htjIWXNfmS';
	$ali     = 'https://s.click.aliexpress.com/e/_c3iBrHkz'; // 알리익스프레스 제휴(추적 ID easybokji)
	$html    = '<div class="eb-support">';
	$html   .= '<p>이지복지닷컴을 찾아 주셔서 고맙습니다. 복잡한 정부 지원금과 복지 제도를 누구나 쉽게 찾아볼 수 있도록 공식 자료를 확인해 정리하고 있습니다. 모든 글과 계산기는 무료이며, 광고 수익으로 운영됩니다.</p>';

	$html .= '<h2 id="free">돕는 방법 4가지</h2><div class="eb-support-grid eb-support-grid--4">';
	$html .= '<div class="eb-support-card"><strong>필요한 분께 공유하기</strong><span>도움이 된 글을 가족·친구에게 보내 주세요. 글 맨 아래 "카톡·문자로 공유" 버튼을 누르면 됩니다.</span></div>';
	$html .= '<div class="eb-support-card"><strong>틀린 정보 알려 주기</strong><span>바뀐 제도나 틀린 내용을 발견하셨다면 알려 주세요. 확인해서 바로 고치겠습니다.</span><a href="' . esc_url( home_url( '/contact/' ) ) . '">문의하기 →</a></div>';
	$html .= '<div class="eb-support-card"><strong>다음 주제 제안하기</strong><span>정리해 줬으면 하는 지원금이나 서류가 있다면 한 줄로 남겨 주세요.</span><a href="#topic">제안하러 가기 →</a></div>';
	$html .= '<div class="eb-support-card"><strong>쇼핑하면서 돕기</strong><span>평소처럼 쿠팡·알리익스프레스에서 사면 가격은 같고, 이지복지닷컴에 약간의 수수료가 적립돼요.</span><a href="#coupang">쇼핑 링크 보기 →</a></div>';
	$html .= '</div>';
	$html .= eb_donate_html(); // 후원하기(설정 > 후원 링크에 링크가 있을 때만)

	$html .= '<h2 id="topic">다음에 정리할 주제 제안하기</h2>';
	$html .= '<form class="eb-topic" data-nonce="' . esc_attr( wp_create_nonce( 'eb_topic' ) ) . '"><label class="screen-reader-text" for="eb-topic-text">제안할 주제</label><input id="eb-topic-text" type="text" name="t" maxlength="80" placeholder="예: 에너지바우처 신청 방법" required><input type="text" name="w" class="eb-topic__hp" tabindex="-1" autocomplete="off" aria-hidden="true"><button type="submit">제안하기</button></form>';
	$html .= '<p class="eb-topic__note">이름·연락처 같은 개인정보는 적지 마세요. 남겨 주신 주제는 새 글을 정할 때 참고합니다.</p><p class="eb-topic__msg" role="status" hidden></p>';

	$html .= '<h2 id="share">부모님께 알려 드리기</h2><div class="eb-qrbox"><div class="eb-qrbox__code" id="eb-qr"><img src="' . esc_url( wp_get_attachment_url( 15049 ) ) . '" width="120" height="120" alt="이지복지닷컴 주소(easybokji.com) QR 코드" loading="lazy"></div><div class="eb-qrbox__text"><strong>휴대폰 카메라로 찍으면 바로 열려요</strong><span>화면을 보여 드리거나 인쇄해서 붙여 두세요.</span><div class="eb-qrbox__btns"><button type="button" data-share hidden>카톡·문자로 보내기</button><button type="button" data-copy>주소 복사</button></div></div></div>';

	// 2026-10-18 시안: 한 줄 안내 + 같은 크기 링크 버튼 2개 + 홈 '생활 특가'처럼 주제 탭·옆으로 넘기는 카드 (28-1번, css/85-common.css 끝 '쇼핑하면서 돕기')
	$html .= '<h2 id="coupang">쇼핑하면서 돕기</h2>' . eb_support_shop_html( $coupang, $ali );

	$links = eb_donate_links();
	$html .= '<p class="eb-page-note">' . ( $links['paypal'] || $links['kakao'] ? '' : '따로 후원금은 받지 않아요. ' ) . '공유와 제보만으로도 큰 힘이 됩니다. 고맙습니다.</p></div>';
	return $html;
}
add_shortcode( 'eb_support', 'eb_support_html' );

/* 28-1. 돕는 방법 '쇼핑하면서 돕기' (2026-10-18 시안, css/85-common.css 끝) -------------------------------------------
 * 상품은 홈 '생활 특가'(18번)와 같은 캐시(eb_cp_goldbox·eb_cp_best, 6시간)를 써서 쿠팡 API 호출이 늘지 않음. 주제 4개 × 최대 12개.
 * 휴대폰은 카드가 옆으로 넘어가고(오른쪽이 살짝 잘려 보여 넘길 수 있다는 표시), 768px 이상은 5개씩 + ‹ › 버튼. 상품을 하나도 못 받으면 안내·링크만.
 * 고지 문구(쿠팡 파트너스)는 지우면 안 됨
 */
function eb_support_shop_html( $coupang, $ali ) {
	$rel  = ' target="_blank" rel="sponsored nofollow noopener"';
	$svg  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%1$s</svg>';
	$chev = sprintf( $svg, '<path d="m9 6 6 6-6 6"/>', '2' );
	$h    = '<div class="eb-shop"><p class="eb-shop__intro">' . sprintf( $svg, '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>', '1.8' ) . '<span>아래 링크로 사도 <b>가격은 똑같고</b>, 이지복지닷컴에 약간의 수수료가 적립돼요.</span></p>'
		. '<div class="eb-shop__go"><a href="' . esc_url( $coupang ) . '"' . $rel . '>쿠팡 열기' . $chev . '</a><a href="' . esc_url( $ali ) . '"' . $rel . '>알리익스프레스' . $chev . '</a></div>';
	$sets = function_exists( 'eb_cp_goldbox' ) ? array(
		array( '오늘의 특가', eb_cp_goldbox() ),
		array( '생활용품', eb_cp_best( 1014 ) ),
		array( '장보기', eb_cp_best( 1024 ) ),
		array( '주방용품', eb_cp_best( 1013 ) ),
	) : array();
	$tabs = '';
	$rows = '';
	$n    = 0;
	foreach ( $sets as $set ) {
		$li = '';
		$c  = 0;
		foreach ( (array) $set[1] as $it ) {
			if ( $c >= 12 ) {
				break;
			}
			if ( empty( $it['productUrl'] ) || empty( $it['productName'] ) ) {
				continue;
			}
			$c++;
			$li .= '<a class="eb-shop__i" href="' . esc_url( $it['productUrl'] ) . '"' . $rel . '><span class="eb-shop__img"><img src="' . esc_url( $it['productImage'] ?? '' ) . '" alt="" loading="lazy" width="300" height="300">' . ( ! empty( $it['isRocket'] ) ? '<span class="eb-shop__rk">로켓배송</span>' : '' ) . '</span>'
				. '<span class="eb-shop__nm">' . esc_html( $it['productName'] ) . '</span><span class="eb-shop__pr">' . ( ! empty( $it['discountRate'] ) ? '<em>' . (int) $it['discountRate'] . '%</em>' : '' ) . esc_html( number_format_i18n( (float) ( $it['productPrice'] ?? 0 ) ) ) . '원</span></a>';
		}
		if ( ! $li ) {
			continue;
		}
		$tabs .= '<button type="button" role="tab" id="eb-shop-t' . $n . '" aria-controls="eb-shop-p' . $n . '" aria-selected="' . ( $n ? 'false' : 'true' ) . '"' . ( $n ? ' tabindex="-1"' : '' ) . '>' . esc_html( $set[0] ) . '</button>';
		$rows .= '<div class="eb-shop__row" id="eb-shop-p' . $n . '" role="tabpanel" aria-labelledby="eb-shop-t' . $n . '" aria-label="' . esc_attr( $set[0] ) . ' 상품, 옆으로 넘겨 보기" tabindex="0"' . ( $n ? ' hidden' : '' ) . '>' . $li . '</div>';
		$n++;
	}
	if ( $rows ) {
		$h .= '<section class="eb-shop__pan" aria-labelledby="eb-shop-h"><div class="eb-shop__h"><h3 id="eb-shop-h">오늘의 쿠팡 특가</h3><span class="eb-shop__ad">광고</span><div class="eb-shop__nav"><span class="eb-shop__cnt" aria-hidden="true"></span>'
			. '<button type="button" class="eb-shop__prev" aria-label="이전 상품" disabled>' . sprintf( $svg, '<path d="m15 6-6 6 6 6"/>', '2' ) . '</button><button type="button" class="eb-shop__next" aria-label="다음 상품">' . $chev . '</button></div></div>'
			. ( $n > 1 ? '<div class="eb-shop__tabs" role="tablist" aria-label="쇼핑 주제">' . $tabs . '</div>' : '' )
			. $rows
			. '<p class="eb-shop__note">' . sprintf( $svg, '<path d="M12 3 4.5 6v5.5c0 4.6 3.2 8.3 7.5 9.5 4.3-1.2 7.5-4.9 7.5-9.5V6z"/><path d="m9 12 2 2 4-4"/>', '2' ) . '<span>이 영역은 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받습니다. 알리익스프레스 링크도 제휴 링크이고, 가격·재고는 판매처 사정에 따라 바뀔 수 있어요.</span></p></section>';
		$h .= "<script nowprocket>\n" . <<<'JS'
(function () {
	var s = document.querySelector('.eb-shop__pan');
	if (!s) { return; }
	var tabs = [].slice.call(s.querySelectorAll('[role="tab"]')), prev = s.querySelector('.eb-shop__prev'), next = s.querySelector('.eb-shop__next'), cnt = s.querySelector('.eb-shop__cnt');
	var still = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
	function row() { return s.querySelector('.eb-shop__row:not([hidden])'); }
	function step(r) { var a = r.children[0], b = r.children[1]; return a ? (b ? b.offsetLeft - a.offsetLeft : a.offsetWidth) : 1; }
	function per(r) { return Math.max(1, Math.floor((r.clientWidth + 14) / step(r))); } // +14: 칸 사이 12px + 반올림 여유
	// '1–2 / 12' 표시와 ‹ › 끝 처리
	function upd() {
		var r = row();
		if (!r) { return; }
		var st = step(r), n = r.children.length, first = Math.min(n - 1, Math.round(r.scrollLeft / st)), last = Math.min(n, first + per(r));
		cnt.textContent = (first + 1) + (last > first + 1 ? '–' + last : '') + ' / ' + n;
		prev.disabled = r.scrollLeft < 4;
		next.disabled = r.scrollLeft + r.clientWidth >= r.scrollWidth - 4;
	}
	function go(d) { var r = row(); r.scrollBy({ left: d * per(r) * step(r), behavior: still ? 'auto' : 'smooth' }); }
	prev.addEventListener('click', function () { go(-1); });
	next.addEventListener('click', function () { go(1); });
	[].forEach.call(s.querySelectorAll('.eb-shop__row'), function (r) {
		var q = 0;
		r.addEventListener('scroll', function () { if (!q) { q = requestAnimationFrame(function () { q = 0; upd(); }); } }, { passive: true });
		r.addEventListener('keydown', function (e) {
			if (e.target !== r) { return; }
			if (e.key === 'ArrowRight') { e.preventDefault(); go(1); } else if (e.key === 'ArrowLeft') { e.preventDefault(); go(-1); }
		});
	});
	function pick(t, focus) {
		tabs.forEach(function (x) {
			var on = x === t;
			x.setAttribute('aria-selected', on ? 'true' : 'false');
			x.tabIndex = on ? 0 : -1;
			document.getElementById(x.getAttribute('aria-controls')).hidden = !on;
		});
		row().scrollLeft = 0;
		if (focus) { t.focus(); }
		upd();
	}
	tabs.forEach(function (t, i) {
		t.addEventListener('click', function () { pick(t); });
		t.addEventListener('keydown', function (e) {
			var k = e.key === 'ArrowRight' ? 1 : (e.key === 'ArrowLeft' ? -1 : 0);
			if (!k) { return; }
			e.preventDefault();
			pick(tabs[(i + k + tabs.length) % tabs.length], true);
		});
	});
	window.addEventListener('resize', upd);
	upd();
})();
JS
			. "\n</script>";
	}
	return $h . '</div>';
}

/* 28-2. 후원하기 - 페이팔·무통장입금(카톡 문의)·후원 후 한마디 (style.css 33번 .eb-donate) ----------------------------
 * 링크는 설정 > 후원 링크(옵션 eb_donate_paypal·eb_donate_kakao)에서 사용자가 넣음. 둘 다 비어 있으면 상자가 안 보임.
 * 한마디는 이름·연락처 없이 닉네임(선택)·방법·내용만 저장(옵션 eb_donate_msgs, 최근 300개, 1년 지난 것은 자동 삭제) → 알림판 '후원 메시지'.
 * 약관 제8조(후원)·개인정보처리방침 1번 표와 함께 바꿀 것.
 */
function eb_donate_links() {
	return array(
		'paypal' => (string) get_option( 'eb_donate_paypal', '' ),
		'kakao'  => (string) get_option( 'eb_donate_kakao', '' ),
	);
}

function eb_donate_html() {
	$l = eb_donate_links();
	if ( ! $l['paypal'] && ! $l['kakao'] ) {
		return '';
	}
	$heart = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7.5-4.6-9.6-9.2C.9 8.4 2.9 4.5 6.6 4.5c2.1 0 3.6 1.1 4.4 2.6.8-1.5 2.3-2.6 4.4-2.6 3.7 0 5.7 3.9 4.2 7.3C19.5 16.4 12 21 12 21z"/></svg>';
	$html  = '<h2 id="donate">후원하기</h2><div class="eb-donate">';
	$html .= '<div class="eb-donate__head"><span class="eb-donate__icon">' . $heart . '</span><div><strong class="eb-donate__title">이지복지닷컴과 함께해 주세요</strong>'
		. '<p class="eb-donate__lead">도움이 되셨다면 작은 후원으로 힘을 보태 주세요. 모든 글과 계산기는 지금처럼 무료로 유지됩니다.</p></div></div>';
	$html .= '<div class="eb-donate__use"><span>후원금은 이렇게 써요</span><ul><li>서버·도메인</li><li>공식 자료 확인</li><li>계산기 개선</li></ul></div>';
	$html .= '<div class="eb-donate__ways">';
	if ( $l['paypal'] ) {
		$html .= '<div class="eb-donate__way"><strong>페이팔로 후원</strong><span>해외 카드나 페이팔 계정으로 1분이면 보낼 수 있어요.</span>'
			. '<a class="eb-donate__btn eb-donate__btn--paypal" href="' . esc_url( $l['paypal'] ) . '" target="_blank" rel="noopener"><span class="eb-pp" aria-hidden="true"><b>Pay</b><i>Pal</i></span>로 후원하기</a></div>';
	}
	if ( $l['kakao'] ) {
		$html .= '<div class="eb-donate__way"><strong>계좌 이체(무통장입금)</strong><ol class="eb-donate__steps"><li>카톡 문의</li><li>계좌 안내</li><li>입금</li></ol><span>보안을 위해 계좌번호는 사이트에 올리지 않아요.</span>'
			. '<a class="eb-donate__btn eb-donate__btn--kakao" href="' . esc_url( $l['kakao'] ) . '" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5c-5.2 0-9.5 3.3-9.5 7.4 0 2.6 1.7 4.9 4.3 6.2l-1 3.6c-.1.4.3.6.6.4l4.2-2.8c.5.1 1 .1 1.4.1 5.2 0 9.5-3.3 9.5-7.4S17.2 3.5 12 3.5z"/></svg>카카오톡으로 문의하기</a></div>';
	}
	$html .= '</div><ul class="eb-donate__notes">';
	$html .= '<li>후원은 자발적이며 대가가 없어요. 후원하지 않아도 모든 글과 계산기를 똑같이 쓸 수 있어요.</li>';
	$html .= '<li>이지복지닷컴은 기부금 단체가 아니어서 <b>기부금 영수증(연말정산 공제)은 발급할 수 없어요.</b></li>';
	$html .= '<li>금액을 잘못 보내신 경우 7일 안에 알려 주시면 확인 후 돌려드려요. 자세한 내용은 <a href="' . esc_url( home_url( '/terms-of-service/' ) ) . '">이용약관</a>을 확인해 주세요.</li>';
	$html .= '</ul>';
	$html .= '<div class="eb-donate__card"><h3 class="eb-donate__formtitle">후원 후 한마디 남기기</h3><p class="eb-donate__formlead">보내 주신 뒤 남겨 주시면 감사히 읽겠습니다. 이름·연락처·계좌번호는 적지 마세요.</p>';
	$html .= '<form class="eb-donate-form" data-nonce="' . esc_attr( wp_create_nonce( 'eb_donate' ) ) . '">'
		. '<div class="eb-donate-form__row"><label class="eb-donate-form__field"><span>닉네임 <small>(선택)</small></span><input type="text" name="n" maxlength="20" placeholder="예: 부산 독자"></label>'
		. '<fieldset class="eb-donate-form__field"><legend>후원 방법</legend><div class="eb-donate-form__choices">'
		. ( $l['paypal'] ? '<label><input type="radio" name="m" value="페이팔" required> 페이팔</label>' : '' )
		. ( $l['kakao'] ? '<label><input type="radio" name="m" value="무통장입금" required> 계좌 이체</label>' : '' )
		. '<label><input type="radio" name="m" value="기타" required> 기타</label></div></fieldset></div>'
		. '<label class="eb-donate-form__field"><span>한마디</span><textarea name="t" maxlength="300" rows="3" placeholder="남기고 싶은 말을 적어 주세요" required></textarea></label>'
		. '<input type="text" name="w" class="eb-topic__hp" tabindex="-1" autocomplete="off" aria-hidden="true">'
		. '<button type="submit">보내기</button><p class="eb-donate-form__msg" role="status" hidden></p></form></div>';
	return $html . '</div>';
}

// 후원 한마디 저장(이름·연락처 없이, 같은 접속은 1분에 한 번, 1년 지난 것과 300개 넘는 것은 삭제)
function eb_donate_submit() {
	check_ajax_referer( 'eb_donate', 'nonce' );
	$nick = isset( $_POST['n'] ) ? mb_substr( trim( sanitize_text_field( wp_unslash( $_POST['n'] ) ) ), 0, 20 ) : '';
	$way  = isset( $_POST['m'] ) ? sanitize_text_field( wp_unslash( $_POST['m'] ) ) : '';
	$text = isset( $_POST['t'] ) ? mb_substr( trim( sanitize_textarea_field( wp_unslash( $_POST['t'] ) ) ), 0, 300 ) : '';
	$trap = isset( $_POST['w'] ) ? sanitize_text_field( wp_unslash( $_POST['w'] ) ) : '';
	if ( '' !== $trap || mb_strlen( $text ) < 2 || ! in_array( $way, array( '페이팔', '무통장입금', '기타' ), true ) ) {
		wp_send_json_error( array( 'msg' => '후원 방법을 고르고 한마디를 두 글자 이상 적어 주세요.' ) );
	}
	$key = 'eb_dn_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' ); // phpcs:ignore
	if ( get_transient( $key ) ) {
		wp_send_json_error( array( 'msg' => '잠시 후 다시 남겨 주세요.' ) );
	}
	set_transient( $key, 1, MINUTE_IN_SECONDS );
	$cut  = gmdate( 'Y-m-d', time() - YEAR_IN_SECONDS );
	$list = array_values( array_filter( (array) get_option( 'eb_donate_msgs', array() ), function ( $r ) use ( $cut ) {
		return substr( $r[0], 0, 10 ) >= $cut;
	} ) );
	$list[] = array( current_time( 'Y-m-d H:i' ), '' !== $nick ? $nick : '익명', $way, $text );
	update_option( 'eb_donate_msgs', array_slice( $list, -300 ), false );
	wp_send_json_success( array( 'msg' => '고맙습니다! 보내 주신 마음 잘 받았습니다.' ) );
}
add_action( 'wp_ajax_eb_donate', 'eb_donate_submit' );
add_action( 'wp_ajax_nopriv_eb_donate', 'eb_donate_submit' );

add_action( 'wp_dashboard_setup', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'eb_donate_msgs', '이지복지닷컴 · 후원 메시지', function () {
		$list = array_reverse( (array) get_option( 'eb_donate_msgs', array() ) );
		if ( ! $list ) {
			echo '<p>아직 들어온 메시지가 없습니다. 돕는 방법 페이지(/support/#donate)의 "후원 후 한마디 남기기"로 들어옵니다.</p>';
			return;
		}
		echo '<p>전체 ' . count( $list ) . '개 · 최근 순 · 1년 지나면 자동 삭제</p><ul style="margin:0">';
		foreach ( array_slice( $list, 0, 20 ) as $row ) {
			printf( '<li style="margin:6px 0"><span style="color:#646970">%1$s · %2$s · %3$s</span><br>%4$s</li>', esc_html( $row[0] ), esc_html( $row[1] ), esc_html( $row[2] ), esc_html( $row[3] ) );
		}
		echo '</ul>';
	} );
} );

// 설정 > 후원 링크: 페이팔(paypal.me·paypal.com)·카톡 오픈채팅(open.kakao.com·pf.kakao.com) 주소만 받음
add_action( 'admin_init', function () {
	$only = function ( $hosts ) {
		return function ( $v ) use ( $hosts ) {
			$v    = esc_url_raw( trim( (string) $v ), array( 'https' ) );
			$host = (string) wp_parse_url( $v, PHP_URL_HOST );
			if ( '' === $v ) {
				return '';
			}
			if ( ! preg_match( $hosts, $host ) ) {
				add_settings_error( 'eb_donate', 'eb_donate_host', '주소를 확인해 주세요: ' . $v );
				return '';
			}
			return $v;
		};
	};
	register_setting( 'eb_donate', 'eb_donate_paypal', array( 'sanitize_callback' => $only( '/^(www\.)?(paypal\.me|paypal\.com)$/' ) ) );
	register_setting( 'eb_donate', 'eb_donate_kakao', array( 'sanitize_callback' => $only( '/^(open|pf)\.kakao\.com$/' ) ) );
} );
add_action( 'admin_menu', function () {
	add_options_page( '후원 링크', '후원 링크', 'manage_options', 'eb-donate', function () {
		echo '<div class="wrap"><h1>후원 링크</h1><p>돕는 방법 페이지(/support/)의 "후원하기" 상자에 쓰는 주소입니다. 둘 다 비우면 상자가 사라집니다.</p><form method="post" action="options.php">';
		settings_fields( 'eb_donate' );
		echo '<table class="form-table"><tr><th><label for="eb_donate_paypal">페이팔 주소</label></th><td><input type="url" class="regular-text" id="eb_donate_paypal" name="eb_donate_paypal" value="' . esc_attr( get_option( 'eb_donate_paypal', '' ) ) . '" placeholder="https://www.paypal.me/아이디 또는 기부 버튼 링크"><p class="description">페이팔에서 만든 PayPal.me 링크나 기부(Donate) 버튼 링크. 후원자에게 보이는 이름(표시 이름)을 먼저 확인하세요.</p></td></tr>';
		echo '<tr><th><label for="eb_donate_kakao">카카오톡 오픈채팅 주소</label></th><td><input type="url" class="regular-text" id="eb_donate_kakao" name="eb_donate_kakao" value="' . esc_attr( get_option( 'eb_donate_kakao', '' ) ) . '" placeholder="https://open.kakao.com/o/..."><p class="description">무통장입금 문의용 1:1 오픈채팅(닉네임 프로필 권장). 계좌번호는 사이트에 넣지 마세요.</p></td></tr></table>';
		submit_button( '저장' );
		echo '</form></div>';
	} );
} );

// 주제 제안 저장(최근 300개, 같은 접속은 1분에 한 번)
function eb_topic_submit() {
	check_ajax_referer( 'eb_topic', 'nonce' );
	$text = isset( $_POST['t'] ) ? sanitize_text_field( wp_unslash( $_POST['t'] ) ) : '';
	$trap = isset( $_POST['w'] ) ? sanitize_text_field( wp_unslash( $_POST['w'] ) ) : '';
	$text = mb_substr( trim( $text ), 0, 80 );
	if ( '' !== $trap || mb_strlen( $text ) < 2 ) {
		wp_send_json_error( array( 'msg' => '주제를 두 글자 이상 적어 주세요.' ) );
	}
	$key = 'eb_tp_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' ); // phpcs:ignore
	if ( get_transient( $key ) ) {
		wp_send_json_error( array( 'msg' => '잠시 후 다시 남겨 주세요.' ) );
	}
	set_transient( $key, 1, MINUTE_IN_SECONDS );
	$list   = get_option( 'eb_topic_requests', array() );
	$list[] = array( current_time( 'Y-m-d H:i' ), $text );
	update_option( 'eb_topic_requests', array_slice( $list, -300 ), false );
	wp_send_json_success( array( 'msg' => '고맙습니다! 제안해 주신 주제를 참고하겠습니다.' ) );
}
add_action( 'wp_ajax_eb_topic', 'eb_topic_submit' );
add_action( 'wp_ajax_nopriv_eb_topic', 'eb_topic_submit' );

add_action( 'wp_dashboard_setup', function () {
	wp_add_dashboard_widget( 'eb_topic_requests', '이지복지닷컴 · 주제 제안', function () {
		$list = array_reverse( get_option( 'eb_topic_requests', array() ) );
		if ( ! $list ) {
			echo '<p>아직 들어온 제안이 없습니다. 돕는 방법 페이지(/support/)의 "주제 제안하기"로 들어옵니다.</p>';
			return;
		}
		echo '<p>전체 ' . count( $list ) . '개 · 최근 순</p><ul style="margin:0">';
		foreach ( array_slice( $list, 0, 15 ) as $row ) {
			printf( '<li style="margin:4px 0"><span style="color:#646970">%s</span> %s</li>', esc_html( $row[0] ), esc_html( $row[1] ) );
		}
		echo '</ul>';
	} );
} );

add_action( 'wp_footer', function () {
	if ( ! is_page( 14928 ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var site = 'https://easybokji.com/';
	// QR 코드는 이미지 파일(미디어 15049)로 고정 - 외부 스크립트가 막혀도 보이도록
	var share = document.querySelector('.eb-qrbox [data-share]'), copy = document.querySelector('.eb-qrbox [data-copy]');
	if (share && navigator.share) {
		share.hidden = false;
		share.addEventListener('click', function () { navigator.share({ title: '이지복지닷컴 - 복지의 모든 것', url: site }).catch(function () {}); });
	}
	if (copy) {
		copy.addEventListener('click', function () {
			var done = function () { copy.textContent = '복사했어요'; setTimeout(function () { copy.textContent = '주소 복사'; }, 2000); };
			if (navigator.clipboard) { navigator.clipboard.writeText(site).then(done, done); } else { done(); }
		});
	}
	var form = document.querySelector('.eb-topic'), msg = document.querySelector('.eb-topic__msg');
	if (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var fd = new FormData(form), btn = form.querySelector('button');
			fd.append('action', 'eb_topic');
			fd.append('nonce', form.getAttribute('data-nonce'));
			btn.disabled = true;
			fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: fd, credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (j) {
					msg.hidden = false;
					msg.textContent = (j && j.data && j.data.msg) || '잠시 후 다시 시도해 주세요.';
					if (j && j.success) { form.reset(); }
				})
				.catch(function () { msg.hidden = false; msg.textContent = '잠시 후 다시 시도해 주세요.'; })
				.then(function () { btn.disabled = false; });
		});
	}
	// 후원 후 한마디(28-2)
	var dform = document.querySelector('.eb-donate-form');
	if (dform) {
		var dmsg = dform.querySelector('.eb-donate-form__msg');
		dform.addEventListener('submit', function (e) {
			e.preventDefault();
			var fd = new FormData(dform), btn = dform.querySelector('button');
			fd.append('action', 'eb_donate');
			fd.append('nonce', dform.getAttribute('data-nonce'));
			btn.disabled = true;
			fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: fd, credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (j) {
					dmsg.hidden = false;
					dmsg.textContent = (j && j.data && j.data.msg) || '잠시 후 다시 시도해 주세요.';
					if (j && j.success) { dform.reset(); }
				})
				.catch(function () { dmsg.hidden = false; dmsg.textContent = '잠시 후 다시 시도해 주세요.'; })
				.then(function () { btn.disabled = false; });
		});
	}
})();
JS
	. "\n</script>\n";
}, 53 );


/* 29. 쿠팡 파트너스 API - 설정 > 쿠팡 파트너스(키 입력·연결 확인·링크 변환), 오늘의 특가, 알림판 실적 (style.css 33번) ----------
 * 키는 사용자가 직접 입력(화면에 다시 표시하지 않음). 상품은 6시간, 실적은 3시간마다 새로 받아 저장.
 */
function eb_cp_api( $method, $path, $query = '', $body = null ) {
	$ak = get_option( 'eb_cp_access' );
	$sk = get_option( 'eb_cp_secret' );
	if ( ! $ak || ! $sk ) {
		return new WP_Error( 'eb_cp_nokey', 'API 키가 없습니다.' );
	}
	$date = gmdate( 'ymd\THis\Z' );
	$sig  = hash_hmac( 'sha256', $date . $method . $path . $query, $sk );
	$args = array(
		'method'  => $method,
		'timeout' => 10,
		'headers' => array(
			'Authorization' => 'CEA algorithm=HmacSHA256, access-key=' . $ak . ', signed-date=' . $date . ', signature=' . $sig,
			'Content-Type'  => 'application/json;charset=UTF-8',
		),
	);
	if ( null !== $body ) {
		$args['body'] = wp_json_encode( $body );
	}
	$res = wp_remote_request( 'https://api-gateway.coupang.com' . $path . ( $query ? '?' . $query : '' ), $args );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$json = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( ! is_array( $json ) || ! array_key_exists( 'data', $json ) || ( isset( $json['rCode'] ) && '0' !== (string) $json['rCode'] ) ) {
		$msg = is_array( $json ) ? ( $json['rMessage'] ?? ( $json['message'] ?? '' ) ) : '';
		return new WP_Error( 'eb_cp_api', 'HTTP ' . wp_remote_retrieve_response_code( $res ) . ' ' . $msg );
	}
	return $json['data'];
}

function eb_cp_goldbox() {
	$items = get_transient( 'eb_cp_goldbox' );
	if ( false === $items ) {
		$data  = eb_cp_api( 'GET', '/v2/providers/affiliate_open_api/apis/openapi/v1/products/goldbox', 'imageSize=300x300' );
		$items = is_array( $data ) ? $data : get_option( 'eb_cp_goldbox_last', array() );
		if ( is_array( $data ) && $data ) {
			update_option( 'eb_cp_goldbox_last', $data, false );
		}
		set_transient( 'eb_cp_goldbox', $items, is_array( $data ) ? 6 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );
	}
	return is_array( $items ) ? $items : array();
}

// 카테고리별 베스트 상품(bestcategories) - 홈 '생활 특가' 주제 탭. 오늘의 특가와 같이 6시간마다 새로 받고, 실패하면 마지막으로 받은 목록 (2026-10-09)
// 1014 생활용품 · 1024 식품(신선식품·생수 위주로 옴) · 1013 주방용품 · 1011 출산/유아동 · 1016 가전디지털 (쿠팡 파트너스 카테고리 번호)
function eb_cp_best( $cat ) {
	$cat   = (int) $cat;
	$items = get_transient( 'eb_cp_best_' . $cat );
	if ( false === $items ) {
		$data  = eb_cp_api( 'GET', '/v2/providers/affiliate_open_api/apis/openapi/v1/products/bestcategories/' . $cat, 'limit=20&imageSize=300x300' );
		$items = is_array( $data ) ? $data : get_option( 'eb_cp_best_last_' . $cat, array() );
		if ( is_array( $data ) && $data ) {
			update_option( 'eb_cp_best_last_' . $cat, $data, false );
		}
		set_transient( 'eb_cp_best_' . $cat, $items, is_array( $data ) ? 6 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );
	}
	return is_array( $items ) ? $items : array();
}

function eb_cp_deals_html( $limit = 4 ) {
	$items = array_slice( eb_cp_goldbox(), 0, $limit );
	if ( ! $items ) {
		return '';
	}
	$html = '<div class="eb-deals"><div class="eb-deals__head"><strong>오늘의 쿠팡 특가</strong><span>매일 바뀌는 할인 상품</span></div><ul class="eb-deals__list">';
	foreach ( $items as $it ) {
		if ( empty( $it['productUrl'] ) || empty( $it['productName'] ) ) {
			continue;
		}
		$rate  = ! empty( $it['discountRate'] ) ? '<em>' . (int) $it['discountRate'] . '%</em> ' : '';
		$html .= sprintf(
			'<li><a href="%1$s" target="_blank" rel="sponsored nofollow noopener"><img src="%2$s" alt="" loading="lazy" width="150" height="150"><span class="eb-deals__name">%3$s</span><span class="eb-deals__price">%4$s%5$s원</span>%6$s</a></li>',
			esc_url( $it['productUrl'] ),
			esc_url( $it['productImage'] ?? '' ),
			esc_html( $it['productName'] ),
			$rate,
			esc_html( number_format_i18n( (float) ( $it['productPrice'] ?? 0 ) ) ),
			! empty( $it['isRocket'] ) ? '<span class="eb-deals__rocket">로켓배송</span>' : ''
		);
	}
	return $html . '</ul><p class="eb-deals__note">쿠팡 파트너스 활동으로 수수료를 받을 수 있으며, 가격은 쿠팡에서 바뀔 수 있습니다.</p></div>';
}

// 설정 > 쿠팡 파트너스
add_action( 'admin_menu', function () {
	add_options_page( '쿠팡 파트너스', '쿠팡 파트너스', 'manage_options', 'eb-coupang', 'eb_cp_admin_page' );
} );

function eb_cp_admin_page() {
	$has  = get_option( 'eb_cp_access' ) && get_option( 'eb_cp_secret' );
	$note = get_transient( 'eb_cp_admin_note' );
	delete_transient( 'eb_cp_admin_note' );
	echo '<div class="wrap"><h1>쿠팡 파트너스 연결</h1>';
	if ( $note ) {
		echo '<div class="notice notice-info"><p>' . wp_kses_post( $note ) . '</p></div>';
	}
	echo '<p>쿠팡 파트너스 → 추가 기능 → 파트너스 API의 Access Key와 Secret Key를 붙여 넣으세요. 저장한 키는 다시 표시하지 않습니다.</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_cp_save">' . wp_nonce_field( 'eb_cp_save', '_wpnonce', true, false );
	echo '<table class="form-table"><tr><th>상태</th><td>' . ( $has ? '<strong style="color:#00a32a">키 저장됨</strong>' : '<strong style="color:#d63638">키 없음</strong>' ) . '</td></tr>';
	echo '<tr><th><label for="eb-cp-ak">Access Key</label></th><td><input id="eb-cp-ak" name="ak" type="password" class="regular-text" autocomplete="off" placeholder="' . ( $has ? '바꿀 때만 입력' : '' ) . '"></td></tr>';
	echo '<tr><th><label for="eb-cp-sk">Secret Key</label></th><td><input id="eb-cp-sk" name="sk" type="password" class="regular-text" autocomplete="off" placeholder="' . ( $has ? '바꿀 때만 입력' : '' ) . '"></td></tr></table>';
	submit_button( '저장하고 연결 확인' );
	echo '</form>';
	if ( $has ) {
		echo '<hr><h2>쿠팡 링크 변환</h2><p>쿠팡 상품 주소를 넣으면 수수료가 붙는 짧은 링크로 바꿔 줍니다(글 쓸 때 사용).</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_cp_link">' . wp_nonce_field( 'eb_cp_link', '_wpnonce', true, false );
		echo '<input name="url" type="url" class="large-text" placeholder="https://www.coupang.com/vp/products/..." required> ';
		submit_button( '링크 만들기', 'secondary', 'submit', false );
		echo '</form>';
	}
	echo '</div>';
}

add_action( 'admin_post_eb_cp_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_cp_save' );
	$ak = isset( $_POST['ak'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['ak'] ) ) ) : '';
	$sk = isset( $_POST['sk'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['sk'] ) ) ) : '';
	if ( $ak ) {
		update_option( 'eb_cp_access', $ak, false );
	}
	if ( $sk ) {
		update_option( 'eb_cp_secret', $sk, false );
	}
	delete_transient( 'eb_cp_goldbox' );
	delete_transient( 'eb_cp_report' );
	$data = eb_cp_api( 'GET', '/v2/providers/affiliate_open_api/apis/openapi/v1/products/goldbox', 'imageSize=300x300' );
	$note = is_wp_error( $data ) ? '연결 실패: ' . esc_html( $data->get_error_message() ) : '연결 성공 · 오늘의 특가 상품 ' . count( (array) $data ) . '개를 받았습니다.';
	set_transient( 'eb_cp_admin_note', $note, MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-coupang' ) );
	exit;
} );

add_action( 'admin_post_eb_cp_link', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_cp_link' );
	$url  = isset( $_POST['url'] ) ? esc_url_raw( wp_unslash( $_POST['url'] ) ) : '';
	$data = eb_cp_api( 'POST', '/v2/providers/affiliate_open_api/apis/openapi/v1/deeplink', '', array( 'coupangUrls' => array( $url ) ) );
	if ( is_wp_error( $data ) || empty( $data[0]['shortenUrl'] ) ) {
		$note = '변환 실패: ' . ( is_wp_error( $data ) ? esc_html( $data->get_error_message() ) : '쿠팡 주소인지 확인해 주세요.' );
	} else {
		$note = '만든 링크: <code>' . esc_html( $data[0]['shortenUrl'] ) . '</code> (글에 넣을 땐 rel="sponsored nofollow"와 쿠팡 파트너스 안내 문구를 함께)';
	}
	set_transient( 'eb_cp_admin_note', $note, MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-coupang' ) );
	exit;
} );

// 알림판: 최근 7일 쿠팡 실적
function eb_cp_report() {
	$rep = get_transient( 'eb_cp_report' );
	if ( false === $rep ) {
		$q    = 'startDate=' . wp_date( 'Ymd', strtotime( '-6 days' ) ) . '&endDate=' . wp_date( 'Ymd' );
		$base = '/v2/providers/affiliate_open_api/apis/openapi/v1/reports/';
		$rep  = array();
		foreach ( array( 'clicks', 'orders', 'commission' ) as $type ) {
			$data         = eb_cp_api( 'GET', $base . $type, $q );
			$rep[ $type ] = is_wp_error( $data ) ? $data->get_error_message() : $data;
		}
		set_transient( 'eb_cp_report', $rep, 3 * HOUR_IN_SECONDS );
	}
	return $rep;
}

function eb_cp_sum( $rows, $field ) {
	if ( ! is_array( $rows ) ) {
		return null;
	}
	$sum = 0;
	foreach ( $rows as $row ) {
		$sum += isset( $row[ $field ] ) ? (float) $row[ $field ] : 0;
	}
	return $sum;
}

add_action( 'wp_dashboard_setup', function () {
	if ( ! get_option( 'eb_cp_access' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'eb_cp_report', '이지복지닷컴 · 쿠팡 파트너스 (최근 7일)', function () {
		$rep  = eb_cp_report();
		$cell = function ( $label, $value ) {
			return '<div style="flex:1;padding:8px;background:#f6f7f7;border-radius:6px;text-align:center"><div style="font-size:18px;font-weight:600">' . esc_html( $value ) . '</div><div style="color:#646970">' . esc_html( $label ) . '</div></div>';
		};
		$clicks = eb_cp_sum( $rep['clicks'] ?? null, 'click' );
		$orders = is_array( $rep['orders'] ?? null ) ? count( $rep['orders'] ) : null;
		$money  = eb_cp_sum( $rep['commission'] ?? null, 'commission' );
		echo '<div style="display:flex;gap:8px">';
		echo $cell( '클릭', null === $clicks ? '-' : number_format_i18n( $clicks ) ); // phpcs:ignore
		echo $cell( '주문', null === $orders ? '-' : number_format_i18n( $orders ) ); // phpcs:ignore
		echo $cell( '수익', null === $money ? '-' : number_format_i18n( $money ) . '원' ); // phpcs:ignore
		echo '</div>';
		foreach ( $rep as $type => $v ) {
			if ( is_string( $v ) ) {
				printf( '<p style="color:#d63638">%s: %s</p>', esc_html( $type ), esc_html( $v ) );
			}
		}
		echo '<p style="color:#646970">3시간마다 새로 받음 · <a href="https://partners.coupang.com/" target="_blank" rel="noopener">쿠팡 파트너스</a> · <a href="' . esc_url( admin_url( 'options-general.php?page=eb-coupang' ) ) . '">연결 설정</a></p>';
	} );
} );

/* 30. 구글 애널리틱스(GA4) - 관리자·편집자가 로그인해 볼 때는 넣지 않음(본인 방문이 통계에 섞이지 않게) ----------
 * 예전엔 WPCode 머리말에 있던 코드(사이트 인증 메타는 WPCode에 그대로).
 */
add_action( 'wp_head', function () {
	if ( current_user_can( 'edit_posts' ) ) {
		return;
	}
	?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E2CKYTVFMF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E2CKYTVFMF');
</script>
	<?php
}, 5 );

/* 31. 글 아래 순서 정리 (style.css 34번) ----------------------------------------------------------------
 * generate_after_entry_content 순서: 관련 글(Elements 14831, 2) → 도움·공유(15-2, 3) → 계산기(13-2, 4)
 * → 본문 끝 광고(여기, 5) → 글쓴이(Elements 14663, 6) → 안내·면책 한 줄(Elements 14647, 7)
 * 광고는 Advanced Ads 수동 배치 post-end(광고 15001, 멀티플렉스). 관련 글과 광고가 붙어 보이지 않게 사이에 둠.
 */
add_action( 'generate_after_entry_content', function () {
	if ( is_singular( 'post' ) ) {
		echo eb_ad_slot( 'post-end', 'eb-ad-post' ); // phpcs:ignore
	}
}, 5 );

/* 32. 홈에서만 사이드바 중복 위젯 빼기 - 홈 본문에 이미 있는 최근 업데이트(block-45)·많이 본 글(block-99) ----------
 * 지급일·최근 본 글·저장한 글·공식 기관·분야별 카테고리(block-47)는 그대로. 글·카테고리 페이지 사이드바는 바뀌지 않음.
 * 분야별 카테고리는 2026-10-02 PC 홈 사이드바 빈자리 때문에 되살림(휴대폰 홈에서는 style.css 40번이 숨김).
 */
add_filter( 'sidebars_widgets', function ( $widgets ) {
	if ( is_admin() || ! is_front_page() ) {
		return $widgets;
	}
	foreach ( $widgets as $area => $list ) {
		if ( is_array( $list ) && 'wp_inactive_widgets' !== $area ) {
			$widgets[ $area ] = array_values( array_diff( $list, array( 'block-45', 'block-99' ) ) );
		}
	}
	return $widgets;
} );

/* 33. 공식 서식 한글 파일(.hwp) 업로드 허용 (/forms/ 15016) ----------------------------------------------
 * 워드프레스 기본값은 .hwp를 막음. 글을 올릴 수 있는 사용자만 업로드 가능(기본 권한 그대로).
 */
add_filter( 'upload_mimes', function ( $mimes ) {
	$mimes['hwp'] = 'application/x-hwp';
	return $mimes;
} );
add_filter( 'wp_check_filetype_and_ext', function ( $data, $file, $filename ) {
	if ( 'hwp' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
		$data['ext']  = 'hwp';
		$data['type'] = 'application/x-hwp';
	}
	return $data;
}, 10, 3 );

/* 34. 카테고리·태그·검색 목록을 게시판형으로 (style.css 41번) ---------------------------------------------
 * 한 줄: [세부 분야] 제목 …… 수정일 (+ PC에서 요약 한 줄). 위 막대: 글 수 + 최신순/많이 본 순(카테고리).
 * 검색: 계산기·서식 같은 페이지 결과는 위 '바로 쓰는 도구·안내' 카드로 따로, 글만 목록으로. 검색어는 굵게.
 * 페이지 번호(GeneratePress), 5번째 글 다음 광고(26번), 카테고리 머리(13-4)는 그대로.
 */
function eb_is_board() {
	return ! is_admin() && ( is_category() || is_tag() || is_search() );
}

function eb_board_mark( $text ) {
	$text = esc_html( $text );
	if ( ! is_search() ) {
		return $text;
	}
	foreach ( array_filter( preg_split( '/\s+/u', get_search_query( false ) ) ) as $word ) {
		if ( mb_strlen( $word ) >= 2 ) {
			$text = preg_replace( '/(' . preg_quote( esc_html( $word ), '/' ) . ')/iu', '<b>$1</b>', $text );
		}
	}
	return $text;
}

// 검색: 제목·내용에 검색어가 있는 페이지(계산기·서식·가이드) 최대 4개. 글 결과가 없을 때도 보여 줌
function eb_search_tools_html() {
	$q = get_search_query( false );
	if ( '' === trim( $q ) ) {
		return '';
	}
	$skip = array( 15016, 14934 ); // 공식 서식 모음·공식 기관 모음: 본문에 제도 이름이 많아 거의 모든 검색에 걸려서 제외
	foreach ( eb_search_excluded_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$skip[] = $page->ID;
		}
	}
	// 2026-10-09: 제목이 맞는 페이지(가운뎃점·띄어쓰기 무시, 비슷한 말 포함)를 먼저, 계산기 → 가이드 → 안내 순. 모자라면 본문 검색으로 채움
	$alts  = eb_search_alts( $q );
	$first = array();
	foreach ( get_posts( array( 'post_type' => 'page', 'posts_per_page' => -1, 'post__not_in' => $skip, 'no_found_rows' => true ) ) as $p ) {
		$n = eb_search_norm( get_the_title( $p ) );
		foreach ( $alts as $a ) {
			if ( '' !== $a && false !== mb_strpos( $n, $a ) ) {
				$uri     = get_page_uri( $p );
				$first[] = array( 0 === strpos( $uri, 'calculator' ) ? 0 : ( 0 === strpos( $uri, 'guide' ) ? 1 : 2 ), $p );
				break;
			}
		}
	}
	usort( $first, function ( $a, $b ) {
		return $a[0] - $b[0];
	} );
	$pages = wp_list_pluck( $first, 1 );
	$ids   = wp_list_pluck( $pages, 'ID' );
	// 2026-10-15: 본문 검색으로 채울 때는 상황별 가이드(/guide/…)만 최대 2개. 본문에 단어만 있는 날짜·만 나이 계산기 같은 도구가 끼지 않게
	if ( count( $pages ) < 4 ) {
		$added = 0;
		foreach ( get_posts( array( 'post_type' => 'page', 's' => $q, 'orderby' => 'relevance', 'posts_per_page' => 8, 'post__not_in' => array_merge( $skip, $ids ), 'no_found_rows' => true ) ) as $p ) {
			if ( $added >= 2 || 0 !== strpos( get_page_uri( $p ), 'guide/' ) ) {
				continue;
			}
			$pages[] = $p;
			$added++;
		}
	}
	$pages = array_slice( $pages, 0, 4 );
	if ( ! $pages ) {
		return '';
	}
	$html = '<section class="eb-boardtools"><p class="eb-boardtools__label">바로 쓰는 도구·안내</p><div class="eb-calcgrid">';
	foreach ( $pages as $p ) {
		$uri   = get_page_uri( $p );
		$label = 0 === strpos( $uri, 'calculator' ) ? '계산기' : ( 0 === strpos( $uri, 'guide' ) ? '가이드' : '안내' );
		$html .= sprintf( '<a class="eb-calccard" href="%1$s"><strong>%2$s</strong><span>%3$s</span></a>', esc_url( get_permalink( $p ) ), eb_board_mark( get_the_title( $p ) ), esc_html( $label ) );
	}
	return $html . '</div></section>';
}

// 많이 본 순: 최근 30일 조회수 순(13-4 eb_popular_ids) → 나머지는 최신순
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_category() || 'popular' !== ( $_GET['sort'] ?? '' ) ) { // phpcs:ignore
		return;
	}
	$term = get_queried_object();
	if ( ! $term ) {
		return;
	}
	$ids = get_posts( array( 'cat' => $term->term_id, 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true ) );
	if ( $ids ) {
		$query->set( 'post__in', array_values( array_unique( array_merge( array_intersect( eb_popular_ids(), $ids ), $ids ) ) ) );
		$query->set( 'orderby', 'post__in' );
	}
} );

// 기본 글 카드 대신 한 줄 출력
add_filter( 'generate_do_template_part', function ( $do, $template ) {
	return ( eb_is_board() && in_the_loop() && in_array( $template, array( 'archive', 'search' ), true ) ) ? false : $do;
}, 10, 2 );

add_action( 'generate_before_loop', function () {
	if ( ! eb_is_board() ) {
		return;
	}
	global $wp_query;
	$html = '';
	if ( is_search() ) {
		$tools = is_paged() ? '' : eb_search_tools_html();
		$gov   = is_paged() ? '' : eb_search_gov_html( get_search_query( false ) );
		$html .= $tools . $gov; // 복지로 정부 서비스(2026-10-09). 글이 없을 때는 아래 'none' 자리에서
		$html .= '<div class="eb-list"><div class="eb-list__bar"><b>검색된 글</b></div>'; // 글 수는 제목 아래 '글 N건' (2026-10-16 '관련 글'·'총'에서 바꿈 - 위 도구·안내와 헷갈리지 않게)
	} else {
		$base  = remove_query_arg( 'sort', get_pagenum_link( 1 ) );
		$pop   = 'popular' === ( $_GET['sort'] ?? '' ); // phpcs:ignore
		$html .= '<div class="eb-list"><div class="eb-list__bar"><b>' . esc_html( single_term_title( '', false ) ) . ' 글 <span>' . esc_html( number_format_i18n( (int) $wp_query->found_posts ) ) . '</span>개</b>';
		if ( is_category() ) {
			$html .= sprintf(
				'<nav class="eb-list__sort" aria-label="정렬"><a href="%1$s"%2$s>최신순</a><a href="%3$s"%4$s rel="nofollow">많이 본 순</a></nav>',
				esc_url( $base ),
				$pop ? '' : ' aria-current="true"',
				esc_url( add_query_arg( 'sort', 'popular', $base ) ),
				$pop ? ' aria-current="true"' : ''
			);
		}
		$html .= '</div>';
	}
	echo $html; // phpcs:ignore
}, 30 ); // 검색 제목(GeneratePress) 다음

add_action( 'generate_before_do_template_part', function ( $template ) {
	if ( ! eb_is_board() || ! in_the_loop() || ! in_array( $template, array( 'archive', 'search' ), true ) ) {
		return;
	}
	$post = get_post();
	$current = is_category() ? get_queried_object_id() : 0;
	$badge   = '';
	foreach ( get_the_category( $post->ID ) as $cat ) {
		if ( $cat->term_id !== $current ) {
			$badge = $cat->name;
			break;
		}
	}
	$excerpt = wp_strip_all_tags( get_the_excerpt( $post ) );
	printf(
		'<a class="eb-row" href="%1$s">%2$s<span class="eb-row__t">%3$s</span><time class="eb-row__d" datetime="%4$s">%5$s</time><span class="eb-row__ex">%6$s</span></a>',
		esc_url( get_permalink( $post ) ),
		'' === $badge ? '' : '<span class="eb-row__cat">' . esc_html( $badge ) . '</span>',
		eb_board_mark( get_the_title( $post ) ),
		esc_attr( get_the_modified_date( 'c', $post ) ),
		esc_html( get_the_modified_date( 'Y.m.d', $post ) ),
		eb_board_mark( mb_substr( $excerpt, 0, 120 ) )
	);
} );

add_action( 'generate_after_loop', function () {
	if ( eb_is_board() ) {
		echo '</div>';
	}
}, 1 );

// 글 결과가 없어도 맞는 계산기·서식이 있으면 '결과 없음' 안내 위에 보여 줌
add_action( 'generate_before_do_template_part', function ( $template ) {
	if ( 'none' === $template && is_search() && ! is_admin() ) {
		// 정리한 글이 없을 때: '찾지 못함'(style.css 114번에서 숨김) 대신 안내 머리 + 도구 + 복지로 서비스 + 글 요청 (2026-10-09 개선안 5번)
		$q     = get_search_query( false );
		$tools = eb_search_tools_html();
		$gov   = eb_search_gov_html( $q );
		// 2026-10-15: 도구·정부 서비스를 찾았으면 '검색 결과'를 제목으로(실패처럼 보이지 않게), 아무것도 없을 때만 '정리 글은 아직 없어요'
		$found = $tools || $gov;
		echo '<div class="eb-nores"><p class="eb-nores__t">‘' . esc_html( $q ) . ( $found ? '’ 검색 결과' : '’ 정리 글은 아직 없어요' ) . '</p><p class="eb-nores__s">' . ( $found ? '정리 글은 아직 없지만, 바로 쓸 수 있는 도구와 정부 서비스를 찾았어요.' : '띄어쓰기를 바꾸거나 더 짧게 입력해 보세요.' ) . '</p>'
			. '<div class="eb-nores__b"><a class="is-main" href="' . esc_url( home_url( '/support/#topic' ) ) . '">이 주제로 글 요청하기</a><a href="' . esc_url( home_url( '/find/#finder' ) ) . '">맞춤 찾기로 찾기</a></div></div>' . $tools . $gov; // phpcs:ignore
	}
} );

/* 35. 홈 화면 설치(웹 앱, PWA) - /manifest.webmanifest · /sw.js 를 PHP로 제공 ----------------------------
 * - 서비스 워커는 아무것도 저장하지 않음(글은 항상 새로 받음). 인터넷이 끊겼을 때만 안내 화면을 보여 줌.
 * - display: minimal-ui → 안드로이드는 위에 얇은 막대(뒤로 가기)가 있는 앱 화면, 아이폰은 평소 사파리로 열림.
 * - 크롬의 자동 설치 안내는 막고, 휴대폰 메뉴(209)의 '앱으로 설치하기'(링크 #install)에서만 설치 / 안 되는 기기는 방법 안내 창(style.css .eb-install-help).
 * - 문제가 생기면: EB_PWA_OFF 를 true로 → sw.js가 스스로 등록을 지우고, 설치 안내·등록 코드도 빠짐.
 */
define( 'EB_PWA_OFF', false );

add_action( 'init', function () {
	$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH ); // phpcs:ignore
	if ( '/manifest.webmanifest' === $path ) {
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
		// 앱 아이콘: 남색 꽉 채운 정사각형(귀퉁이 투명 X) - 미디어 15055(512)·15056(192), 아이폰 15057(180)은 아래 site_icon_meta_tags
		$icon     = wp_get_attachment_url( 15055 );
		$icon_192 = wp_get_attachment_url( 15056 );
		header( 'Content-Type: application/manifest+json; charset=utf-8' );
		header( 'Cache-Control: public, max-age=86400' );
		echo wp_json_encode( array(
			// 앱 이름은 '이지복지닷컴' 하나로(2026-10-07). name은 안드로이드 앱을 열 때 로딩 화면 아이콘 아래에 크게 나오므로 짧게
			// (홈 화면 아이콘 아래 이름은 런처에 따라 '이지복지닷…'으로 잘릴 수 있음)
			'name'             => '이지복지닷컴',
			'short_name'       => '이지복지닷컴',
			'description'      => '내게 맞는 정부 지원금 찾기, 복지 계산기, 지급일·신청 마감 알림까지', // 2026-10-16 맞춤 찾기·캘린더 반영
			'lang'             => 'ko',
			'start_url'        => '/?utm_source=pwa&utm_medium=app',
			'scope'            => '/',
			'display'          => 'minimal-ui',
			'background_color' => '#ffffff',
			'theme_color'      => '#1d3c78',
			// 메뉴 '앱으로 설치하기'가 이미 설치됐는지 알아보는 데 씀(크롬 getInstalledRelatedApps)
			'related_applications' => array(
				array( 'platform' => 'webapp', 'url' => home_url( '/manifest.webmanifest' ) ),
			),
			// 앱 아이콘을 길게 누르면 나오는 바로가기 - 휴대폰 하단 탭과 같은 순서(2026-10-16)
			'shortcuts'        => array(
				array( 'name' => '맞춤 혜택 찾기', 'short_name' => '맞춤 찾기', 'url' => '/find/?utm_source=pwa#finder' ),
				array( 'name' => '복지 계산기', 'short_name' => '계산기', 'url' => '/calculator/?utm_source=pwa' ),
				array( 'name' => '복지 캘린더', 'short_name' => '캘린더', 'url' => '/schedule/?utm_source=pwa' ),
				array( 'name' => '저장한 글', 'short_name' => '저장한 글', 'url' => '/saved/?utm_source=pwa' ),
			),
			'icons'            => array(
				array( 'src' => $icon_192, 'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'any' ),
				array( 'src' => $icon, 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any' ),
				array( 'src' => $icon, 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'maskable' ),
			),
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		exit;
	}
	if ( '/sw.js' === $path ) {
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
		header( 'Content-Type: application/javascript; charset=utf-8' );
		header( 'Cache-Control: no-cache' );
		if ( EB_PWA_OFF ) {
			echo "self.addEventListener('install',function(){self.skipWaiting();});self.addEventListener('activate',function(){self.registration.unregister();});";
			exit;
		}
		echo <<<'JS'
// 이지복지 서비스 워커: 저장(캐시) 없음. 인터넷이 끊겼을 때만 안내 화면.
var OFFLINE = '<!doctype html><html lang="ko"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>연결 확인 - 이지복지닷컴</title></head>'
	+ '<body style="margin:0;font-family:sans-serif;background:#f5f7fb;color:#1b2433;display:flex;min-height:100vh;align-items:center;justify-content:center;text-align:center">'
	+ '<div style="padding:24px"><p style="font-size:20px;font-weight:700;margin:0 0 8px">인터넷 연결을 확인해 주세요</p>'
	+ '<p style="margin:0 0 20px;color:#5d6676">연결되면 이지복지닷컴을 다시 불러올 수 있어요.</p>'
	+ '<button onclick="location.reload()" style="padding:12px 22px;font-size:16px;font-weight:700;color:#fff;background:#1d3c78;border:0;border-radius:10px">다시 시도</button></div></body></html>';
self.addEventListener('install', function () { self.skipWaiting(); });
self.addEventListener('activate', function (e) { e.waitUntil(self.clients.claim()); });
self.addEventListener('fetch', function (e) {
	if (e.request.mode !== 'navigate') { return; }
	e.respondWith(fetch(e.request).catch(function () {
		return new Response(OFFLINE, { headers: { 'Content-Type': 'text/html; charset=utf-8' } });
	}));
});
// 마감 알림(웹 푸시, 2026-10-15): 내용 없는 신호가 오면 서버(eb-schedule)에서 문구를 받아 띄움. 눌리면 그 글·일정으로
var FALLBACK = { title: '신청·마감 일정을 확인해 보세요', body: '알림을 켠 일정이 곧 시작하거나 마감돼요', url: '/schedule/#applying', tag: 'ebs' };
self.addEventListener('push', function (e) {
	e.waitUntil(self.registration.pushManager.getSubscription().then(function (sub) {
		return fetch('/wp-json/ebs/v1/push-msg', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ endpoint: sub ? sub.endpoint : '' }), cache: 'no-store' }).then(function (r) { return r.json(); });
	}).catch(function () { return []; }).then(function (list) {
		list = list && list.length ? list.slice(-3) : [FALLBACK];
		return Promise.all(list.map(function (m) {
			return self.registration.showNotification(m.title, { body: m.body, tag: m.tag || 'ebs', icon: m.icon || undefined, data: { url: m.url || '/schedule/' } });
		}));
	}));
});
self.addEventListener('notificationclick', function (e) {
	e.notification.close();
	var url = (e.notification.data && e.notification.data.url) || '/schedule/';
	e.waitUntil(self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (wins) {
		for (var i = 0; i < wins.length; i++) {
			if (wins[i].url === url && 'focus' in wins[i]) { return wins[i].focus(); }
		}
		return self.clients.openWindow(url);
	}));
});
JS;
		exit;
	}
}, 0 );

add_action( 'wp_head', function () {
	echo '<link rel="manifest" href="/manifest.webmanifest">' . "\n" . '<meta name="theme-color" content="#1d3c78">' . "\n"
		. '<meta name="apple-mobile-web-app-title" content="이지복지닷컴">' . "\n" . '<meta name="application-name" content="이지복지닷컴">' . "\n";
}, 2 );

// 아이폰 홈 화면 아이콘: 사이트 아이콘(귀퉁이 투명 동그라미) 대신 남색 꽉 찬 앱 아이콘(미디어 15057, 180px). 탭 파비콘은 그대로
add_filter( 'site_icon_meta_tags', function ( $tags ) {
	$url = wp_get_attachment_url( 15057 );
	if ( ! $url ) {
		return $tags;
	}
	foreach ( $tags as $i => $tag ) {
		if ( false !== strpos( $tag, 'apple-touch-icon' ) ) {
			$tags[ $i ] = '<link rel="apple-touch-icon" href="' . esc_url( $url ) . '" />';
		}
	}
	return $tags;
} );

add_action( 'wp_footer', function () {
	if ( EB_PWA_OFF ) {
		echo "<script nowprocket>if('serviceWorker' in navigator){navigator.serviceWorker.getRegistrations().then(function(r){r.forEach(function(x){x.unregister();});});}</script>\n";
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	if ('serviceWorker' in navigator) {
		window.addEventListener('load', function () { navigator.serviceWorker.register('/sw.js'); });
	}
	// 크롬 자동 설치 안내 대신 휴대폰 메뉴 '앱으로 설치하기'(링크 #install)에서만.
	// 설치 창을 띄울 수 있으면(안드로이드 크롬·삼성 인터넷) 바로 설치, 아니면(아이폰·카톡 등) 기기별 방법 안내 창
	var deferred = null, ua = navigator.userAgent;
	function hideLinks() {
		document.querySelectorAll('a[href$="#install"]').forEach(function (a) { (a.closest('li') || a).hidden = true; });
	}
	var mm = window.matchMedia;
	if ((mm && (mm('(display-mode: standalone)').matches || mm('(display-mode: minimal-ui)').matches)) || navigator.standalone) { hideLinks(); }
	window.addEventListener('beforeinstallprompt', function (e) { e.preventDefault(); deferred = e; });
	// 안내 창: installed = 이 휴대폰에 이미 설치됨(크롬은 설치된 앱엔 설치 창을 다시 안 띄움)
	function help(installed) {
		var d = document.getElementById('eb-install-help'), how, lead = '홈 화면에 아이콘을 두면 필요할 때 바로 열 수 있어요.';
		if (installed) { lead = '이 휴대폰에는 이미 이지복지닷컴 앱이 설치돼 있어요.'; how = '홈 화면이나 앱 목록에서 <b>"이지복지닷컴"</b> 아이콘을 눌러 여세요.'; }
		else if (/KAKAOTALK|NAVER|Instagram|FBAN|FBAV|Line\//i.test(ua)) { how = '지금 화면은 앱 안 브라우저라 설치할 수 없어요. 메뉴(⋮ 또는 ···)에서 <b>"다른 브라우저로 열기"</b>를 누른 뒤, 이지복지닷컴 메뉴의 "앱으로 설치하기"를 다시 눌러 주세요.'; }
		else if (/iPhone|iPad|iPod/i.test(ua)) { how = '사파리 아래쪽 <b>공유 버튼(□↑)</b> → <b>"홈 화면에 추가"</b> → 오른쪽 위 <b>"추가"</b>를 누르세요.'; }
		else if (/SamsungBrowser/i.test(ua)) { how = '아래쪽 <b>메뉴(≡)</b> → <b>"현재 페이지 추가"</b> → <b>"홈 화면"</b>을 누르세요. 이미 설치돼 있으면 홈 화면의 "이지복지닷컴" 아이콘을 눌러 여세요.'; }
		else if (/Android/i.test(ua)) { how = '설치 창이 뜨지 않으면 오른쪽 위 <b>메뉴(⋮)</b> → <b>"앱 설치"</b> 또는 <b>"홈 화면에 추가"</b>를 누르세요. 이미 설치돼 있으면 설치 창이 뜨지 않으니 홈 화면의 "이지복지닷컴" 아이콘을 눌러 여세요.'; }
		else { how = '휴대폰에서 easybokji.com을 열고 메뉴의 "앱으로 설치하기"를 눌러 주세요. PC 크롬은 주소창 오른쪽의 설치 아이콘으로도 설치할 수 있어요.'; }
		if (!d) {
			d = document.createElement('dialog');
			d.id = 'eb-install-help';
			d.className = 'eb-install-help';
			document.body.appendChild(d);
			d.addEventListener('click', function (e) {
				if (e.target === d || e.target.closest('button')) { if (d.close) { d.close(); } else { d.removeAttribute('open'); } }
			});
		}
		d.innerHTML = '<strong>이지복지닷컴을 앱처럼 쓰기</strong><p>' + lead + '</p><p class="eb-install-help__how">' + how + '</p><button type="button">닫기</button>';
		if (d.showModal) { if (!d.open) { d.showModal(); } } else { d.setAttribute('open', ''); }
	}
	function isInstalled() {
		if (!navigator.getInstalledRelatedApps) { return Promise.resolve(false); }
		return navigator.getInstalledRelatedApps().then(function (r) { return r.length > 0; }, function () { return false; });
	}
	function install() {
		deferred.prompt();
		deferred.userChoice.then(function () { deferred = null; });
	}
	document.addEventListener('click', function (e) {
		var a = e.target.closest('a[href$="#install"]');
		if (!a) { return; }
		e.preventDefault();
		if (deferred) { install(); return; }
		// 페이지를 막 연 직후면 크롬 준비(beforeinstallprompt)를 1.5초까지 기다림 → 그래도 없으면 설치 여부 확인 후 안내
		var t0 = Date.now();
		(function wait() {
			if (deferred) { install(); return; }
			if (Date.now() - t0 < 1500) { setTimeout(wait, 250); return; }
			isInstalled().then(help);
		})();
	}, true);
	window.addEventListener('appinstalled', function () { deferred = null; hideLinks(); });
})();
JS
	. "\n</script>\n";
}, 40 );

/* 36. 도로명주소·우편번호·영문주소 찾기 [eb_juso] (style.css 45번) ------------------------------------------
 * 행정안전부 주소정보 '도로명주소 검색 API'(승인키는 설정 > 주소 API에 저장, 화면에 노출 안 함).
 * 방문자 → /wp-json/eb/v1/juso → 서버가 juso.go.kr 호출(같은 검색어는 하루 저장, 접속당 10분에 40회 제한).
 */
function eb_juso_search( $keyword, $page = 1 ) {
	$key = (string) get_option( 'eb_juso_key' );
	if ( '' === $key ) {
		return new WP_Error( 'nokey', '주소 검색을 준비하고 있습니다.' );
	}
	$keyword = trim( preg_replace( '/[%=><\[\]\'";\\\\]/u', ' ', $keyword ) );
	$keyword = preg_replace( '/\s+/u', ' ', $keyword );
	if ( mb_strlen( $keyword ) < 2 || mb_strlen( $keyword ) > 60 ) {
		return new WP_Error( 'short', '도로명, 건물명 또는 지번을 두 글자 이상 입력해 주세요.' );
	}
	$page  = max( 1, min( 50, (int) $page ) );
	$cache = 'eb_juso3_' . md5( $keyword . '|' . $page ); // 2 = 시도·시군구·동 항목 추가(44번 우리 동네 기관 찾기용)
	$hit   = get_transient( $cache );
	if ( false !== $hit ) {
		return $hit;
	}
	$res = wp_remote_get( 'https://business.juso.go.kr/addrlink/addrLinkApi.do?' . http_build_query( array(
		'confmKey'     => $key,
		'currentPage'  => $page,
		'countPerPage' => 10,
		'keyword'      => $keyword,
		'resultType'   => 'json',
		'addInfoYn'    => 'Y', // 행정동명(hemdNm) 받기
	) ), array( 'timeout' => 6 ) );
	if ( is_wp_error( $res ) ) {
		return new WP_Error( 'http', '주소 서버에 연결하지 못했습니다. 잠시 후 다시 시도해 주세요.' );
	}
	$body   = json_decode( wp_remote_retrieve_body( $res ), true );
	$common = isset( $body['results']['common'] ) ? $body['results']['common'] : array();
	if ( ! isset( $common['errorCode'] ) || '0' !== (string) $common['errorCode'] ) {
		return new WP_Error( 'api', isset( $common['errorMessage'] ) ? (string) $common['errorMessage'] : '검색하지 못했습니다.' );
	}
	$list = array();
	foreach ( (array) ( $body['results']['juso'] ?? array() ) as $j ) {
		$list[] = array(
			'road'  => (string) ( $j['roadAddr'] ?? '' ),
			'jibun' => (string) ( $j['jibunAddr'] ?? '' ),
			'eng'   => (string) ( $j['engAddr'] ?? '' ),
			'zip'   => (string) ( $j['zipNo'] ?? '' ),
			'bd'    => (string) ( $j['bdNm'] ?? '' ),
			'si'    => (string) ( $j['siNm'] ?? '' ),
			'sgg'   => (string) ( $j['sggNm'] ?? '' ),
			'emd'   => (string) ( $j['emdNm'] ?? '' ),  // 법정동
			'hemd'  => (string) ( $j['hemdNm'] ?? '' ), // 행정동(주민센터 이름 기준, 없으면 빈칸)
		);
	}
	$out = array( 'total' => (int) ( $common['totalCount'] ?? 0 ), 'page' => $page, 'list' => $list );
	set_transient( $cache, $out, DAY_IN_SECONDS );
	return $out;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/juso', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function ( $req ) {
			$ip   = 'eb_juso_ip_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '' ); // phpcs:ignore
			$used = (int) get_transient( $ip );
			if ( $used >= 40 ) {
				return new WP_REST_Response( array( 'error' => '검색이 너무 많습니다. 10분 뒤 다시 시도해 주세요.' ), 429 );
			}
			set_transient( $ip, $used + 1, 10 * MINUTE_IN_SECONDS );
			$data = eb_juso_search( (string) $req->get_param( 'q' ), (int) $req->get_param( 'page' ) );
			if ( is_wp_error( $data ) ) {
				return new WP_REST_Response( array( 'error' => $data->get_error_message() ), 200 );
			}
			return rest_ensure_response( $data );
		},
	) );
} );

add_shortcode( 'eb_juso', function () {
	$GLOBALS['eb_juso_used'] = true;
	return '<div class="eb-juso"><form class="eb-juso__form" role="search"><label class="screen-reader-text" for="eb-juso-q">주소 검색어</label>'
		. '<input id="eb-juso-q" type="search" name="q" maxlength="60" placeholder="예: 세종대로 110, 서울시청, 역삼동 737" autocomplete="off" required>'
		. '<button type="submit">검색</button></form>'
		. '<p class="eb-juso__tip">도로명+건물번호, 건물 이름, 동·리+지번으로 찾을 수 있어요.</p>'
		. '<div class="eb-juso__msg" role="status" aria-live="polite"></div><ol class="eb-juso__list"></ol>'
		. '<button type="button" class="eb-juso__more" hidden>결과 더 보기</button></div>';
} );

add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_juso_used'] ) ) {
		return;
	}
	printf( "<script nowprocket>window.ebJusoApi=%s;</script>\n", wp_json_encode( rest_url( 'eb/v1/juso' ) ) );
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-juso');
	if (!box) { return; }
	var form = box.querySelector('form'), msg = box.querySelector('.eb-juso__msg'), list = box.querySelector('.eb-juso__list'), more = box.querySelector('.eb-juso__more');
	var q = '', page = 1, total = 0;
	function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
	function toast(t) {
		var el = document.querySelector('.eb-toast');
		if (!el) { el = document.createElement('div'); el.className = 'eb-toast'; el.setAttribute('role', 'status'); document.body.appendChild(el); }
		el.textContent = t; el.classList.add('is-on'); clearTimeout(el._h);
		el._h = setTimeout(function () { el.classList.remove('is-on'); }, 2000);
	}
	function copy(text, label) {
		function ok() { toast(label + ' 복사했어요.'); }
		function legacy() {
			var ta = document.createElement('textarea'), done = false;
			ta.value = text; ta.setAttribute('readonly', ''); ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
			document.body.appendChild(ta); ta.select();
			try { done = document.execCommand('copy'); } catch (e) {}
			document.body.removeChild(ta);
			if (done) { ok(); } else { window.prompt('아래 내용을 복사하세요', text); }
		}
		if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(text).then(ok, legacy); } else { legacy(); }
	}
	function row(label, value) {
		return '<div class="eb-juso__row"><span>' + label + '</span><b>' + esc(value) + '</b><button type="button" data-copy="' + esc(value) + '" data-label="' + label + '">복사</button></div>';
	}
	// 해외 쇼핑몰 입력 칸: 영문주소 마지막 = 시·도(State), 그 앞 = 시·군·구(City), 나머지 = 도로·건물(Address)
	function split(eng) {
		var p = eng.split(', ');
		if (p.length < 3) { return null; }
		return { state: p[p.length - 1], city: p[p.length - 2], line: p.slice(0, p.length - 2).join(', ') };
	}
	function render(items) {
		list.insertAdjacentHTML('beforeend', items.map(function (j) {
			var s = split(j.eng);
			return '<li class="eb-juso__item"><p class="eb-juso__head"><em>우편번호 ' + esc(j.zip) + '</em>' + (j.bd ? ' ' + esc(j.bd) : '') + '</p>'
				+ row('도로명', j.road) + row('지번', j.jibun) + row('영문', j.eng) + row('우편번호', j.zip)
				+ (s ? '<details class="eb-juso__abroad"><summary>해외 쇼핑몰에 입력할 때</summary>'
					+ row('Address', s.line) + row('City', s.city) + row('State/Province', s.state) + row('ZIP', j.zip) + row('Country', 'South Korea')
					+ '<p>동·호수는 Address 2 칸에 "101-1203"(101동 1203호)처럼 적으면 됩니다.</p></details>' : '')
				+ '</li>';
		}).join(''));
	}
	function load() {
		msg.textContent = '찾는 중…';
		more.hidden = true;
		fetch(window.ebJusoApi + '?q=' + encodeURIComponent(q) + '&page=' + page).then(function (r) { return r.json(); }).then(function (d) {
			if (d.error) { msg.textContent = d.error; return; }
			total = d.total;
			if (!total) { msg.textContent = '검색 결과가 없습니다. 도로명과 건물번호를 띄어 써서(예: 세종대로 110) 다시 찾아보세요.'; return; }
			render(d.list);
			msg.textContent = '검색 결과 ' + total.toLocaleString('ko-KR') + '건';
			more.hidden = list.children.length >= total;
		}).catch(function () { msg.textContent = '검색하지 못했습니다. 잠시 후 다시 시도해 주세요.'; });
	}
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		q = form.q.value.trim(); page = 1; list.innerHTML = '';
		if (q.length < 2) { msg.textContent = '두 글자 이상 입력해 주세요.'; return; }
		load();
	});
	more.addEventListener('click', function () { page++; load(); });
	list.addEventListener('click', function (e) {
		var b = e.target.closest('[data-copy]');
		if (b) { copy(b.getAttribute('data-copy'), b.getAttribute('data-label')); }
	});
})();
JS
	. "\n</script>\n";
}, 30 );

// 설정 > 주소 API (승인키 저장·연결 확인)
add_action( 'admin_menu', function () {
	add_options_page( '주소 API', '주소 API', 'manage_options', 'eb-juso', function () {
		$has  = (bool) get_option( 'eb_juso_key' );
		$note = get_transient( 'eb_juso_admin_note' );
		delete_transient( 'eb_juso_admin_note' );
		echo '<div class="wrap"><h1>주소 API 연결</h1>';
		if ( $note ) {
			echo '<div class="notice notice-info"><p>' . wp_kses_post( $note ) . '</p></div>';
		}
		echo '<p>주소정보 개발자센터(business.juso.go.kr)에서 받은 <strong>도로명주소 검색 API 승인키</strong>를 붙여 넣으세요. 저장한 키는 다시 표시하지 않습니다.</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_juso_save">' . wp_nonce_field( 'eb_juso_save', '_wpnonce', true, false );
		echo '<table class="form-table"><tr><th>상태</th><td>' . ( $has ? '<strong style="color:#00a32a">키 저장됨</strong>' : '<strong style="color:#d63638">키 없음</strong>' ) . '</td></tr>';
		echo '<tr><th><label for="eb-juso-key">승인키</label></th><td><input id="eb-juso-key" name="key" type="password" class="regular-text" autocomplete="off" placeholder="' . ( $has ? '바꿀 때만 입력' : '' ) . '"></td></tr></table>';
		submit_button( '저장하고 연결 확인' );
		echo '</form></div>';
	} );
} );

add_action( 'admin_post_eb_juso_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_juso_save' );
	$key = isset( $_POST['key'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['key'] ) ) ) : '';
	if ( $key ) {
		update_option( 'eb_juso_key', $key, false );
	}
	$data = eb_juso_search( '세종대로 110' );
	$note = is_wp_error( $data ) ? '연결 실패: ' . esc_html( $data->get_error_message() ) : '연결 성공 · "세종대로 110" 검색 결과 ' . (int) $data['total'] . '건을 받았습니다.';
	set_transient( 'eb_juso_admin_note', $note, MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-juso' ) );
	exit;
} );

/* 37. 페이지스피드·접근성 (2026-10-02 측정: 휴대폰 성능 75~81, 접근성 88~92) -------------------------------
 * - Pretendard 글꼴 CSS는 화면 그리기를 막지 않게 늦게 불러옴(글꼴은 잠깐 기본 글꼴로 보였다가 바뀜)
 * - 글 속 이미지 확대 버튼(워드프레스 라이트박스)에 읽을 이름 붙이기
 */
add_filter( 'style_loader_tag', function ( $tag, $handle ) {
	if ( 'pretendard' === $handle && false === strpos( $tag, 'onload=' ) ) {
		$tag = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $tag ) . '<noscript>' . $tag . '</noscript>';
	}
	return $tag;
}, 10, 2 );

add_filter( 'render_block_core/image', function ( $html ) {
	// 워드프레스 인터랙티비티가 서버에서 빈 aria-label을 지우므로 연결(data-wp-bind--aria-label)을 고정 이름으로 바꿈
	return preg_replace( '/data-wp-bind--aria-label="[^"]*"/', 'aria-label="이미지 크게 보기"', $html );
}, 20 ); // 워드프레스가 확대 버튼을 붙이는 15번 다음

/* 38. PC 글 사이드바: 따라오는 '이 글의 목차' + 작은 광고(300×250) (style.css 49번) -----------------------------
 * 글 페이지·화면 폭 900px 이상에서만. 목차는 본문 소제목(H2·H3)으로 만들고 지금 읽는 곳을 강조.
 * 광고는 디스플레이 광고 단위 X1(2341098040)을 300×250 고정 크기로. 보일 때만 불러옴(휴대폰에선 안 부름).
 * 관리자에게는 광고 대신 같은 크기의 '광고 자리' 상자를 보여 줌(레이아웃 확인용).
 */
add_action( 'generate_after_right_sidebar_content', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	if ( current_user_can( 'edit_posts' ) ) {
		$ad = '<div class="eb-sticky__slot">광고 자리 (관리자에게만 보임)</div>';
	} else {
		$ad = '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-3072640033981066" data-ad-slot="2341098040"></ins>';
	}
	echo '<aside class="widget eb-sticky" hidden><nav class="eb-mtoc" aria-label="이 글의 목차"><div class="eb-mtoc__head"><h2 class="widget-title">이 글의 목차</h2><span class="eb-mtoc__count"></span></div><span class="eb-mtoc__bar" aria-hidden="true"><i></i></span><ol></ol><a class="eb-mtoc__top" href="#">↑ 맨 위로</a></nav>'
		. '<div class="eb-sticky__ad"><span>광고</span>' . $ad . '</div></aside>'; // phpcs:ignore
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-sticky'), mq = window.matchMedia('(min-width: 900px)');
	if (!box) { return; }
	// 2026-10-10: 처음 열 때 900px 미만이었다가(태블릿 세로) 돌리거나 창을 넓혀 900px 이상이 되면 그때 만듦
	if (mq.matches) { start(); return; }
	var later = function (e) {
		if (!e.matches) { return; }
		if (mq.removeEventListener) { mq.removeEventListener('change', later); } else if (mq.removeListener) { mq.removeListener(later); }
		start();
	};
	if (mq.addEventListener) { mq.addEventListener('change', later); } else if (mq.addListener) { mq.addListener(later); }

	function start() {
		var hs = [].filter.call(document.querySelectorAll('.entry-content h2, .entry-content h3'), function (h) {
			return h.textContent.trim() && h.textContent.trim() !== '목차' && !h.closest('.tocer-toc, aside, .eb-postcalc');
		});
		var ol = box.querySelector('ol'), nav = box.querySelector('.eb-mtoc');
		if (hs.length < 2) { nav.hidden = true; }
		hs.forEach(function (h, i) {
			if (!h.id) { h.id = 'eb-h-' + (i + 1); }
			var li = document.createElement('li'), a = document.createElement('a');
			a.href = '#' + h.id; a.textContent = h.textContent.trim().replace(/\s+/g, ' ');
			if (h.tagName === 'H3') { li.className = 'is-sub'; }
			li.appendChild(a); ol.appendChild(li);
		});
		box.hidden = false;
		var links = ol.querySelectorAll('a'), cur = -1, tick = false;
		// 2026-10-10: 머리 '3 / 7'(큰 소제목 H2 기준) + 읽은 만큼 막대 (style.css 131번 ⑦)
		var isTop = [].map.call(links, function (a) { return !a.parentNode.classList.contains('is-sub'); });
		var total = isTop.filter(Boolean).length, cnt = box.querySelector('.eb-mtoc__count'), bar = box.querySelector('.eb-mtoc__bar i'), body = document.querySelector('.entry-content');
		function update() {
			tick = false;
			if (bar && body) {
				var r = body.getBoundingClientRect(), all = r.height - window.innerHeight * 0.6;
				bar.style.transform = 'scaleX(' + (all > 0 ? Math.min(1, Math.max(0, -r.top / all)) : 1) + ')';
			}
			var n = 0;
			hs.forEach(function (h, i) { if (h.getBoundingClientRect().top < 120) { n = i; } });
			if (n === cur) { return; }
			cur = n;
			if (cnt) {
				var k = 0;
				for (var j = 0; j <= n; j++) { if (isTop[j]) { k++; } }
				cnt.textContent = Math.max(1, k) + ' / ' + total;
			}
			[].forEach.call(links, function (a, i) { a.classList.toggle('is-on', i === n); });
			var on = links[n];
			if (on) { ol.scrollTop = Math.max(0, on.offsetTop - ol.offsetTop - 60); }
		}
		window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(update); } }, { passive: true });
		update();
		box.querySelector('.eb-mtoc__top').addEventListener('click', function (e) { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); });
		if (box.querySelector('ins.adsbygoogle')) { (window.adsbygoogle = window.adsbygoogle || []).push({}); }
	}
})();
JS
	. "\n</script>\n";
} );

/* 39. 사이드바 검색창 아래 '많이 찾는' 검색어 + 알림판 정리 (style.css 50번) --------------------------------
 * 검색어는 19-3 검색어 기록에서 결과가 있었고 3번 이상 찾은 것(시험 검색어 제외), 6개가 안 되면 기본 목록으로 채움.
 */
function eb_popular_terms( $limit = 6 ) {
	$terms = get_transient( 'eb_popular_terms' );
	if ( false === $terms ) {
		$terms = array();
		$log   = (array) get_option( 'eb_search_log', array() );
		uasort( $log, function ( $a, $b ) {
			return $b[0] - $a[0];
		} );
		foreach ( $log as $q => $row ) {
			if ( $row[0] >= 3 && $row[1] > 0 && mb_strlen( $q ) <= 12 && ! preg_match( '/zz|테스트|test/iu', $q ) ) {
				$terms[] = $q;
			}
		}
		foreach ( array( '기초연금', '실업급여', '퇴직금', '근로장려금', '육아휴직', '건강검진' ) as $q ) {
			if ( count( $terms ) >= 8 ) {
				break;
			}
			if ( ! in_array( $q, $terms, true ) ) {
				$terms[] = $q;
			}
		}
		set_transient( 'eb_popular_terms', $terms, 6 * HOUR_IN_SECONDS );
	}
	return array_slice( $terms, 0, $limit );
}

// 사이드바 맨 위 검색 위젯(block-97)에만 붙임(모바일 메뉴 안 검색창 block-108은 그대로)
add_filter( 'widget_block_content', function ( $content, $instance, $widget ) {
	if ( is_admin() || ! is_object( $widget ) || 'block-97' !== $widget->id ) {
		return $content;
	}
	$chips = '';
	// 2026-10-16: PC 헤더·홈·휴대폰 메뉴·검색 창과 같은 순위(40번 최근 24시간 eb_trend_terms)로 - 예전엔 누적 기록이라 순서가 달랐음
	$terms = function_exists( 'eb_trend_terms' ) ? array_slice( (array) eb_trend_terms()['terms'], 0, 6 ) : array();
	foreach ( $terms ? $terms : eb_popular_terms() as $q ) {
		$chips .= '<a href="' . esc_url( home_url( '/?s=' . rawurlencode( $q ) ) ) . '">' . esc_html( $q ) . '</a>';
	}
	return '<div class="eb-findbox">' . $content . '<div class="eb-findbox__chips"><span>많이 찾는</span>' . $chips . '</div></div>';
}, 10, 3 );

// 알림판: 자주 보는 것만 남김(WP Statistics 세부 위젯·워드프레스 소식·빠른 임시글 등은 각 메뉴에서 보기)
add_action( 'wp_dashboard_setup', function () {
	foreach ( array( 'dashboard_quick_press', 'dashboard_primary', 'advads-dashboard-widget', 'wp-statistics-countries-widget', 'wp-statistics-useronline-widget', 'wp-statistics-hitsmap-widget', 'wp-statistics-top-visitors-widget', 'wp-statistics-search-widget', 'wp-statistics-browsers-widget', 'wp-statistics-models-widget', 'wp-statistics-platforms-widget', 'wp-statistics-devices-widget', 'wp-statistics-hits-widget', 'wp-statistics-recent-widget', 'wp-statistics-referring-widget' ) as $id ) {
		remove_meta_box( $id, 'dashboard', 'normal' );
		remove_meta_box( $id, 'dashboard', 'side' );
		remove_meta_box( $id, 'dashboard', 'column3' );
		remove_meta_box( $id, 'dashboard', 'column4' );
	}
}, 999 );

/* 40. 홈 '많이 찾는 검색어 TOP 10' [eb_trend] (Elements 14814 홈 상단 소개 안, style.css 51번) ---------------------
 * 사이트 검색 기록(19-3)의 1시간 단위 기록에서 최근 24시간 동안 2번 이상 찾았고 결과가 있었던 검색어를 횟수 순으로,
 * 부족하면 기본 목록으로 10개를 채움. 1시간마다 다시 집계하고 직전 집계와 순위를 비교.
 * 한 줄 막대에서 1위부터 3초마다 넘어가고, 'TOP 10 전체'를 누르면 1~10위 2단 패널.
 */
function eb_trend_terms() {
	$data = get_transient( 'eb_trend_v5' );
	if ( false === $data ) {
		$since = (int) floor( time() / HOUR_IN_SECONDS ) - 24;
		$count = array();
		foreach ( (array) get_option( 'eb_search_hourly', array() ) as $h => $bucket ) {
			if ( $h > $since ) {
				foreach ( (array) $bucket as $q => $n ) {
					$count[ $q ] = ( isset( $count[ $q ] ) ? $count[ $q ] : 0 ) + (int) $n;
				}
			}
		}
		$main = (array) get_option( 'eb_search_log', array() );
		$log  = array();
		foreach ( $count as $q => $n ) {
			$q   = (string) $q;
			$row = isset( $main[ $q ] ) ? $main[ $q ] : array( 0, 0, 0 );
			if ( $n >= 2 && $row[1] > 0 && mb_strlen( $q ) >= 2 && mb_strlen( $q ) <= 12 && ! preg_match( '/zz|테스트|test/iu', $q ) ) {
				$log[ $q ] = array( $n, (int) $row[2] );
			}
		}
		uasort( $log, function ( $a, $b ) {
			return $b[0] === $a[0] ? $b[1] - $a[1] : $b[0] - $a[0];
		} );
		$terms = array_slice( array_keys( $log ), 0, 10 );
		$h24   = count( $terms ); // 최근 24시간 검색만으로 뽑힌 수 - 10개가 되면 홈에 '최근 24시간', 모자라면 '최근 검색 기준'으로 표시
		// 24시간 검색이 모자라면 그동안 쌓인 실제 검색어(결과가 있는 것, 많이 찾은 순)로 채움 - 기본 단어는 그래도 모자랄 때만 (2026-10-08)
		if ( count( $terms ) < 10 ) {
			$all = $main;
			uasort( $all, function ( $a, $b ) {
				return $b[0] - $a[0];
			} );
			foreach ( $all as $q => $row ) {
				if ( count( $terms ) >= 10 ) {
					break;
				}
				$q = (string) $q;
				if ( $row[1] > 0 && mb_strlen( $q ) >= 2 && mb_strlen( $q ) <= 12 && ! preg_match( '/zz|테스트|test/iu', $q ) && ! in_array( $q, $terms, true ) ) {
					$terms[] = $q;
				}
			}
		}
		foreach ( array( '기초연금', '실업급여', '퇴직금', '근로장려금', '육아휴직', '최저임금', '건강검진', '기준 중위소득', '부모급여', '에너지바우처' ) as $q ) {
			if ( count( $terms ) >= 10 ) {
				break;
			}
			if ( ! in_array( $q, $terms, true ) ) {
				$terms[] = $q;
			}
		}
		// 직전 집계와 순위 비교: 양수 = 오름, 음수 = 내림, 'new' = 새로 들어옴 (첫 집계는 모두 0)
		$prev  = (array) get_option( 'eb_trend_prev24', array() );
		$moves = array();
		foreach ( $terms as $i => $q ) {
			$j       = array_search( $q, $prev, true );
			$moves[] = false === $j ? ( $prev ? 'new' : 0 ) : $j - $i;
		}
		update_option( 'eb_trend_prev24', $terms, false );
		$data = array( 'terms' => $terms, 'moves' => $moves, 'h24' => $h24, 'at' => current_time( 'm.d H:00' ) );
		set_transient( 'eb_trend_v5', $data, HOUR_IN_SECONDS );
	}
	return $data;
}

add_shortcode( 'eb_trend', function () {
	$data = eb_trend_terms();
	$roll = '';
	$list = '';
	foreach ( $data['terms'] as $i => $q ) {
		$mv = isset( $data['moves'][ $i ] ) ? $data['moves'][ $i ] : 0;
		if ( 'new' === $mv ) {
			$mv = '<em class="eb-trend__mv is-new">NEW</em>';
		} elseif ( $mv > 0 ) {
			$mv = '<em class="eb-trend__mv is-up"><span class="screen-reader-text">상승 </span>' . $mv . '</em>';
		} elseif ( $mv < 0 ) {
			$mv = '<em class="eb-trend__mv is-down"><span class="screen-reader-text">하락 </span>' . abs( $mv ) . '</em>';
		} else {
			$mv = '<em class="eb-trend__mv is-same"><span class="screen-reader-text">변동 없음</span></em>';
		}
		$link  = '<a href="' . esc_url( home_url( '/?s=' . rawurlencode( $q ) ) ) . '"><b>' . ( $i + 1 ) . '</b><span>' . esc_html( $q ) . '</span>' . $mv . '</a>';
		$roll .= '<li>' . $link . '</li>';
		$list .= '<li' . ( $i < 3 ? ' class="is-top"' : '' ) . '>' . $link . '</li>';
	}
	return '<div class="eb-trend"><div class="eb-trend__bar"><span class="eb-trend__lab">인기 검색어</span><div class="eb-trend__win"><ol class="eb-trend__roll">' . $roll . '</ol></div>'
		. '<button type="button" class="eb-trend__btn" aria-expanded="false" aria-controls="eb-trend-panel"><span class="eb-trend__more">TOP 10 전체</span><i aria-hidden="true"></i></button></div>'
		. '<div class="eb-trend__panel" id="eb-trend-panel" hidden><div class="eb-trend__head"><strong>많이 찾는 검색어 TOP 10</strong>'
		. '<button type="button" class="eb-trend__info" aria-expanded="false" aria-controls="eb-trend-note" aria-label="집계 기준 안내">!</button>'
		. '<span>' . esc_html( $data['at'] ) . ' 기준<i class="eb-trend__vs"> · 직전 집계 대비</i></span>'
		. '<p class="eb-trend__note" id="eb-trend-note" hidden>인기 검색어는 베타 서비스로 운영하고 있습니다. 최근 24시간 동안 이지복지닷컴에서 실제로 검색된 횟수를 1시간마다 집계하며, 순위 옆 표시는 직전 집계와 비교한 오름·내림입니다. 검색 기록이 적을 때는 많이 찾는 복지 키워드로 순위를 채웁니다.</p></div>'
		. '<ol class="eb-trend__list">' . $list . '</ol></div>'
		. "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-trend');
	if (!box) { return; }
	var roll = box.querySelector('.eb-trend__roll'), btn = box.querySelector('.eb-trend__btn'), panel = box.querySelector('.eb-trend__panel');
	var n = roll.children.length, i = 0, stop = false;
	var still = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (n > 1 && !still) {
		// 1위 복제본을 끝에 붙여 10위→1위도 위로 이어서 넘어가게 함
		var twin = roll.firstElementChild.cloneNode(true);
		twin.setAttribute('aria-hidden', 'true');
		twin.firstElementChild.tabIndex = -1;
		roll.appendChild(twin);
		roll.addEventListener('transitionend', function () {
			if (i === n) {
				roll.style.transition = 'none';
				i = 0;
				roll.style.transform = 'translateY(0)';
				roll.offsetHeight;
				roll.style.transition = '';
			}
		});
		setInterval(function () {
			if (stop || !panel.hidden) { return; }
			i += 1;
			roll.style.transform = 'translateY(' + (-i * 100 / (n + 1)) + '%)';
		}, 3000);
	}
	// 마우스 기기: 0.15초 올려 두면 펼치고 벗어나면 0.3초 뒤 접음(바→패널 사이 틈 통과용). 클릭으로 열면 고정(pinned)
	var hover = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	var pinned = false, tipPinned = false, tOpen, tClose, tTip;
	var info = box.querySelector('.eb-trend__info'), note = box.querySelector('.eb-trend__note');
	function tip(on) {
		if (on) { note.style.setProperty('--eb-arrow', (info.offsetLeft + info.offsetWidth / 2 - 6) + 'px'); } else { tipPinned = false; }
		note.hidden = !on;
		info.setAttribute('aria-expanded', on ? 'true' : 'false');
	}
	function open(on) { panel.hidden = !on; btn.setAttribute('aria-expanded', on ? 'true' : 'false'); box.classList.toggle('is-open', on); if (!on) { pinned = false; tip(false); } }
	box.addEventListener('mouseenter', function () {
		stop = true;
		clearTimeout(tClose);
		if (hover && panel.hidden) { tOpen = setTimeout(function () { open(true); }, 150); }
	});
	box.addEventListener('mouseleave', function () {
		stop = false;
		clearTimeout(tOpen);
		if (hover && !pinned && !panel.hidden) { tClose = setTimeout(function () { open(false); }, 300); }
	});
	box.addEventListener('focusin', function () { stop = true; });
	box.addEventListener('focusout', function () { stop = false; });
	btn.addEventListener('click', function () {
		clearTimeout(tOpen);
		if (panel.hidden) { open(true); pinned = true; } else if (!pinned) { pinned = true; } else { open(false); }
	});
	info.addEventListener('click', function () { if (note.hidden || !tipPinned) { tip(true); tipPinned = true; } else { tip(false); } });
	if (hover) {
		[info, note].forEach(function (el) {
			el.addEventListener('mouseenter', function () { clearTimeout(tTip); if (note.hidden) { tip(true); } });
			el.addEventListener('mouseleave', function () { if (!tipPinned) { tTip = setTimeout(function () { tip(false); }, 200); } });
		});
	}
	document.addEventListener('click', function (e) {
		if (!note.hidden && e.target !== info) { tip(false); }
		if (!panel.hidden && !box.contains(e.target)) { open(false); }
	});
	document.addEventListener('keydown', function (e) {
		if (e.key !== 'Escape') { return; }
		if (!note.hidden) { tip(false); info.focus(); } else if (!panel.hidden) { open(false); btn.focus(); }
	});
})();
JS
		. "\n</script>";
} );

/* 41. 연락 이메일 [eb_email] - 누르면 메일 쓰기 화면, 주소는 스팸 수집기가 읽기 어렵게(antispambot) (style.css 61번) ----------
 * 문의하기·개인정보처리방침·사이트 소개 본문에 [eb_email]. 주소를 바꿀 때는 eb_contact_email() 한 곳만 고치면 됨.
 * (17번 제안서 폼 실패 문구는 주소를 직접 쓰지 않고 '이 페이지 위쪽의 이메일'로 안내)
 */
function eb_contact_email() {
	return 'contact@easybokji.com';
}

add_shortcode( 'eb_email', function () {
	return '<a class="eb-email" href="mailto:' . antispambot( eb_contact_email() ) . '">' . antispambot( eb_contact_email() ) . '</a>';
} );

// 검색엔진용 사이트 정보(Rank Math, 로컬 SEO '조직')에 공식 연락 창구 = 문의하기 페이지.
// 이메일 주소를 그대로 넣으면 모든 페이지 소스에 노출돼 스팸 수집기가 가져가므로 넣지 않음.
add_filter( 'rank_math/json_ld', function ( $data ) {
	foreach ( $data as $key => $entity ) {
		if ( is_array( $entity ) && isset( $entity['@type'] ) && in_array( 'Organization', (array) $entity['@type'], true ) ) {
			$data[ $key ]['contactPoint'] = array(
				'@type'             => 'ContactPoint',
				'contactType'       => 'customer support',
				'url'               => home_url( '/contact/' ),
				'availableLanguage' => 'Korean',
			);
		}
	}
	return $data;
}, 99 );

/* 42. 사이트 메일 발송 - 구글 워크스페이스 SMTP 릴레이(smtp-relay.gmail.com) 경유 ----------------------------------
 * 서버에서 바로 보내면 도착하지 않아(2026-10-04 확인) 구글을 거쳐 보냄. 비밀번호 없음: 워크스페이스 관리 콘솔
 * > Gmail > 라우팅 > SMTP 릴레이 서비스에서 이 서버 IP(158.247.237.11)만 허용, TLS 필수.
 * 서버 IP가 바뀌면(서버 이전 등) 관리 콘솔의 허용 IP도 바꿔야 메일이 나감.
 */
add_action( 'phpmailer_init', function ( $mail ) {
	$mail->isSMTP();
	$mail->Host        = 'smtp-relay.gmail.com';
	$mail->Port        = 587;
	$mail->SMTPSecure  = 'tls';
	$mail->SMTPAuth    = false;
	$mail->SMTPAutoTLS = true;
	$mail->Helo        = 'easybokji.com'; // 구글 릴레이는 'localhost' 인사를 거절함
	$mail->Hostname    = 'easybokji.com';
} );

add_filter( 'wp_mail_from', function ( $from ) {
	return 0 === strpos( (string) $from, 'wordpress@' ) ? 'noreply@easybokji.com' : $from;
} );

add_filter( 'wp_mail_from_name', function ( $name ) {
	return 'WordPress' === $name ? '이지복지닷컴' : $name; // contact@ 보낸 사람 이름과 같게
} );

/* 43. 긴급·상담 전화 모음 [eb_hotlines] (페이지 /hotline/, style.css 63번) ------------------------------------------
 * 번호는 2026-10-04 공식 자료로 확인. '24시간' 표시는 확인된 곳만. 번호가 바뀌면 아래 목록만 고치면 됨.
 * 보호시설(쉼터) 주소는 법으로 공개하지 않으므로 목록 대신 1366 연결 안내.
 */
function eb_hotline_groups() {
	return array(
		array( 'urgent', '지금 위험하거나 급해요', array(
			array( '112', '경찰', '범죄 피해, 실종, 아동학대 신고', true ),
			array( '119', '소방·구급', '화재, 응급 환자, 구조', true ),
			array( '109', '자살예방 상담', '죽고 싶은 마음이 들 때, 주변 사람이 걱정될 때', true ),
		) ),
		array( 'abuse', '폭력·학대 상담과 신고', array(
			array( '1366', '여성긴급전화', '가정폭력·성폭력 상담, 보호시설(쉼터) 연결', true ),
			array( '1577-1389', '노인학대 신고', '노인보호전문기관 연결', false ),
			array( '1644-8295', '장애인학대 신고', '장애인권익옹호기관 연결', false ),
			array( '1388', '청소년 상담', '9~24세 청소년과 부모, 가출·위기 상담', true ),
		) ),
		array( 'mind', '마음과 건강', array(
			array( '1577-0199', '정신건강 위기상담', '불안·우울 등 마음이 힘들 때', true ),
			array( '1899-9988', '치매상담콜센터', '치매 증상, 돌봄, 지원 제도 안내', false ),
		) ),
		array( 'life', '복지·생활 도움', array(
			array( '129', '보건복지상담센터', '기초생활·긴급복지 등 복지 제도 상담', false ),
			array( '110', '정부민원안내', '어느 기관에 물어야 할지 모를 때', false ),
			array( '1577-1366', '다누리콜센터', '다문화가족·이주민 상담(여러 언어)', true ),
		) ),
		array( 'work', '일·돈·법률', array(
			array( '1350', '고용노동부', '임금체불, 해고, 실업급여', false ),
			array( '1588-0075', '근로복지공단', '산재보험, 근로자 대부', false ),
			array( '132', '대한법률구조공단', '무료 법률 상담', false ),
			array( '1397', '서민금융콜센터', '서민 대출, 채무 조정 상담', false ),
			array( '1332', '금융감독원', '보이스피싱 피해, 금융 민원', false ),
		) ),
		array( 'insure', '연금·건강보험', array(
			array( '1355', '국민연금공단', '연금 수령, 보험료 납부 예외', false ),
			array( '1577-1000', '국민건강보험공단', '건강보험료, 장기요양보험', false ),
		) ),
	);
}

add_shortcode( 'eb_hotlines', function () {
	$html = '<div class="eb-hot">';
	foreach ( eb_hotline_groups() as $g ) {
		$html .= '<section class="eb-hot__group eb-hot__group--' . esc_attr( $g[0] ) . '"><h2 class="eb-hot__title">' . esc_html( $g[1] ) . '</h2><div class="eb-hot__list">';
		foreach ( $g[2] as $l ) {
			$html .= '<a class="eb-hot__item" href="tel:' . esc_attr( str_replace( '-', '', $l[0] ) ) . '">'
				. '<span class="eb-hot__num">' . esc_html( $l[0] ) . '</span>'
				. '<span class="eb-hot__body"><strong>' . esc_html( $l[1] ) . ( $l[3] ? ' <em class="eb-hot__24">24시간</em>' : '' ) . '</strong><span>' . esc_html( $l[2] ) . '</span></span>'
				. '<span class="eb-hot__call" aria-hidden="true"></span></a>';
		}
		$html .= '</div></section>';
	}
	$html .= '<p class="eb-hot__note"><strong>쉼터(보호시설) 주소는 안전을 위해 공개되지 않아요.</strong> 1366에 전화하면 가까운 쉼터로 바로 연결해 줘요. 휴대폰에서는 번호를 누르면 바로 전화가 걸려요. 24시간 표시가 없는 곳은 보통 평일 낮에 운영해요. 번호는 2026년 10월 기준이며 바뀔 수 있어요.</p>';
	return $html . '</div>';
} );

/* 44. 우리 동네 복지 기관 찾기 [eb_nearby] (페이지 /nearby/, style.css 65번) -----------------------------------------
 * 주소 하나로 관할 행정복지센터·보건소·고용센터·건강보험·국민연금 지사·무인민원발급기를 한 화면에.
 * 주소 검색은 36번(/wp-json/eb/v1/juso, 행정동 포함)을 그대로 씀. 기관 위치·전화번호는 네이버 지도(기본)·카카오맵(작은 링크) 검색으로 연결(따로 관리할 목록 없음).
 */
add_shortcode( 'eb_nearby', function () {
	$GLOBALS['eb_nearby_used'] = true;
	return '<div class="eb-near"><form class="eb-juso__form eb-near__form" role="search"><label class="screen-reader-text" for="eb-near-q">사는 곳 주소</label>'
		. '<input id="eb-near-q" type="search" name="q" maxlength="60" placeholder="예: 역삼동 737, 세종대로 110, 아파트 이름" autocomplete="off" required>'
		. '<button type="submit">찾기</button></form>'
		. '<p class="eb-juso__tip">사는 곳(또는 주민등록 주소)을 입력하고 목록에서 고르세요. 주소는 저장하지 않아요.</p>'
		. '<div class="eb-near__msg" role="status" aria-live="polite"></div><ul class="eb-near__pick"></ul><div class="eb-near__result"></div>'
		. '<div class="eb-near__intro"><p class="eb-near__il">주소를 넣으면 이 기관들을 한 번에 찾아 드려요</p><ul><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V9l8-5.5L20 9v12M9.5 21v-5.5h5V21M3 21h18"/></svg></i><strong>행정복지센터(주민센터)</strong><span>전입신고·복지 신청·증명서</span></li><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="4"/><path d="M12 8v8M8 12h8"/></svg></i><strong>보건소</strong><span>예방접종·건강검진·치매 상담</span></li><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7M3 13h18"/></svg></i><strong>고용센터</strong><span>실업급여·국민취업지원제도</span></li><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7.5 3v5.5c0 4.6-3.2 7.8-7.5 9.5-4.3-1.7-7.5-4.9-7.5-9.5V6z"/><path d="M9 12l2 2 4-4"/></svg></i><strong>건강보험공단 지사</strong><span>보험료 조정·자격 확인</span></li><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M7.5 9l1.8 6 2.7-5 2.7 5 1.8-6M7 12h10"/></svg></i><strong>국민연금공단 지사</strong><span>연금 신청·납부 예외</span></li><li><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="3" width="14" height="11" rx="2"/><path d="M9 7.5h6M8 18h8M7 21h10"/></svg></i><strong>무인민원발급기</strong><span>주민등록등본 등 바로 발급</span></li></ul></div></div>'; // 처음 화면: 찾아 주는 기관 6종 미리 보기(주소를 고르면 숨김, style.css 112번, 2026-10-09)
} );

add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_nearby_used'] ) ) {
		return;
	}
	printf( "<script nowprocket>window.ebNearApi=%s;</script>\n", wp_json_encode( rest_url( 'eb/v1/juso' ) ) );
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-near');
	if (!box) { return; }
	var form = box.querySelector('form'), msg = box.querySelector('.eb-near__msg'), pick = box.querySelector('.eb-near__pick'), out = box.querySelector('.eb-near__result'), items = [];
	function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
	function map(q) { return 'https://map.naver.com/p/search/' + encodeURIComponent(q); }
	function kmap(q) { return 'https://map.kakao.com/?q=' + encodeURIComponent(q); }
	function show(j) {
		var dong = (j.hemd || '').split(' ').pop() || j.emd;
		var area = [j.si, j.sgg].filter(Boolean).join(' ');
		var gu = j.sgg || j.si;
		var list = [
			['center', '행정복지센터(주민센터)', dong + ' 행정복지센터', '전입신고, 복지 신청(기초생활·긴급지원·바우처), 각종 증명서 발급', area + ' ' + dong + ' 행정복지센터', '129'],
			['health', '보건소', gu + ' 보건소', '예방접종, 건강검진, 치매안심센터, 정신건강 상담', area + ' 보건소', ''],
			['job', '고용센터', '가까운 고용센터', '실업급여, 국민취업지원제도, 내일배움카드', area + ' 고용센터', '1350'],
			['nhis', '국민건강보험공단 지사', '가까운 건강보험 지사', '건강보험료 조정, 자격 확인, 장기요양 신청', area + ' 국민건강보험공단', '1577-1000'],
			['nps', '국민연금공단 지사', '가까운 국민연금 지사', '연금 신청·수령, 납부 예외, 장애 심사', area + ' 국민연금공단', '1355'],
			['kiosk', '무인민원발급기', dong + ' 근처 발급기', '주민등록등본·가족관계증명서 등을 바로 발급', area + ' ' + dong + ' 무인민원발급기', '']
		];
		out.innerHTML = '<div class="eb-near__head"><span>선택한 주소</span><strong>' + esc(j.road) + '</strong><small>' + esc(area + ' ' + dong) + ' 기준</small></div>'
			+ '<ul class="eb-near__cards">' + list.map(function (c) {
				return '<li class="eb-near__card eb-near__card--' + c[0] + '"><div class="eb-near__info"><strong>' + c[1] + '</strong><span class="eb-near__name">' + esc(c[2]) + '</span><span class="eb-near__desc">' + c[3] + '</span></div>'
					+ '<div class="eb-near__btns"><a class="eb-near__map" href="' + esc(map(c[4])) + '" target="_blank" rel="noopener">네이버 지도</a>'
					+ (c[5] ? '<a class="eb-near__tel" href="tel:' + c[5].replace(/-/g, '') + '">대표 ' + c[5] + '</a>' : '')
					+ '<a class="eb-near__kakao" href="' + esc(kmap(c[4])) + '" target="_blank" rel="noopener">카카오맵</a></div></li>';
			}).join('') + '</ul>'
			+ '<p class="eb-near__note">지도(네이버 지도·카카오맵)에서 가장 가까운 곳의 위치·전화번호·운영 시간을 확인하세요. 고용센터와 공단 지사는 여러 시·군·구를 함께 맡는 경우가 많아, 방문 전에 대표번호로 관할 지사를 물어보면 헛걸음을 줄일 수 있어요. 긴급한 상담은 <a href="/hotline/">긴급·상담 전화 모음</a>을 보세요.</p>';
		pick.innerHTML = '';
		msg.textContent = '';
		out.scrollIntoView({ behavior: 'smooth', block: 'start' });
	}
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var q = form.elements['q'].value.trim();
		out.innerHTML = ''; pick.innerHTML = '';
		if (q.length < 2) { msg.textContent = '두 글자 이상 입력해 주세요.'; return; }
		msg.textContent = '찾는 중…';
		fetch(window.ebNearApi + '?q=' + encodeURIComponent(q) + '&page=1').then(function (r) { return r.json(); }).then(function (d) {
			if (d.error) { msg.textContent = d.error; return; }
			items = d.list || [];
			if (!items.length) { msg.textContent = '주소를 찾지 못했어요. 도로명과 건물번호를 띄어 쓰거나(예: 세종대로 110) 동 이름과 번지로 찾아보세요.'; return; }
			if (items.length === 1) { show(items[0]); return; }
			msg.textContent = '해당하는 주소를 골라 주세요.';
			pick.innerHTML = items.map(function (j, i) { return '<li><button type="button" data-i="' + i + '"><strong>' + esc(j.road) + '</strong>' + (j.bd ? '<span>' + esc(j.bd) + '</span>' : '') + '</button></li>'; }).join('');
		}).catch(function () { msg.textContent = '찾지 못했습니다. 잠시 후 다시 시도해 주세요.'; });
	});
	pick.addEventListener('click', function (e) {
		var b = e.target.closest('[data-i]');
		if (b) { show(items[+b.getAttribute('data-i')]); }
	});
})();
JS
		. "\n</script>\n";
}, 30 );

/* 45. 글 아래 '함께 쓰면 좋은 도구' - 긴급·상담 전화(/hotline/)·동네 기관 찾기(/nearby/) 카드 (13-2 상자에 계산기와 함께) ----------
 * 동네 기관: 본문에 행정복지센터·주민센터가 나오거나 제목에 보건소·무인민원이 있는 글(직접 찾아가야 하는 글).
 * 긴급·상담: 제목이 임금체불·해고·응급·수급·스팸전화처럼 전화 상담이 바로 도움이 되는 글.
 */
function eb_tool_catalog() {
	return array(
		'hotline' => array( '/hotline/', '긴급·상담 전화 모음', '노동·법률·복지 상담 번호를 눌러서 바로 전화', '임금체불|대지급금|미지급|해고|응급|안심콜|수급자|수급비|압류|두낫콜|스팸전화|보이스피싱|학대|폭력|자살|긴급' ),
		'nearby'  => array( '/nearby/', '우리 동네 복지 기관 찾기', '주소로 관할 주민센터·보건소·고용센터 찾기', '보건소|무인민원|행정복지센터|주민센터' ),
		// 아래는 계산기·도구 카드가 2개가 안 되는 글에만 채움(eb_tools_fill_for_post, 2026-10-15) - 제목 단어는 그때만 봄
		'address' => array( '/address/', '주소·영문주소 찾기', '도로명·우편번호·영문주소 바로 복사', '전입|이사|주소|우편|영문|해외|이심|eSIM|여행', 'fill' ),
		'forms'   => array( '/forms/', '공식 서식 모음', '근로계약서·진정서 등 공식 양식 받기', '서식|양식|계약서|진정서|신청서', 'fill' ),
		'finder'  => array( '/find/#finder', '맞춤 혜택 찾기', '나이·상황으로 받을 수 있는 지원 모아 보기', '', 'fill' ),
		'links'   => array( '/links/', '공식 기관 모음', '신청·조회하는 공식 사이트 바로가기', '', 'fill' ),
	);
}

// 분야별로 채울 도구(계산기·도구 카드가 2개 미만일 때) - 건강·생활 분야 글은 맞는 계산기가 없어 상자가 비던 것 (2026-10-15)
function eb_tools_by_category() {
	return array(
		221 => array( 'nearby', 'links' ),  // 건강·의료: 보건소 등 직접 가는 곳
		220 => array( 'links', 'finder' ),  // 교통·자동차
		230 => array( 'finder', 'links' ),  // 반려동물
		222 => array( 'links', 'finder' ),  // 생활·소비자
		219 => array( 'links', 'finder' ),  // 건강·생활(상위)
	);
}

function eb_tools_fill_for_post( $post, $have, $need = 2 ) {
	$keys  = array();
	$title = get_the_title( $post );
	foreach ( eb_tool_catalog() as $key => $tool ) {
		if ( ! empty( $tool[4] ) && '' !== $tool[3] && preg_match( '/' . $tool[3] . '/u', $title ) ) {
			$keys[] = $key;
		}
	}
	$map = eb_tools_by_category();
	foreach ( wp_get_post_categories( $post->ID ) as $cat_id ) {
		foreach ( array( $cat_id, (int) get_category( $cat_id )->parent ) as $id ) {
			if ( isset( $map[ $id ] ) ) {
				$keys = array_merge( $keys, $map[ $id ] );
			}
		}
	}
	$keys = array_values( array_diff( array_unique( $keys ), $have ) );
	return array_slice( $keys, 0, max( 0, $need - count( $have ) ) );
}

function eb_tools_for_post( $post ) {
	$keys  = array();
	$title = get_the_title( $post );
	foreach ( eb_tool_catalog() as $key => $tool ) {
		if ( empty( $tool[4] ) && preg_match( '/' . $tool[3] . '/u', $title ) ) {
			$keys[] = $key;
		}
	}
	if ( ! in_array( 'nearby', $keys, true ) && preg_match( '/행정복지센터|주민센터/u', $post->post_content ) ) {
		$keys[] = 'nearby';
	}
	return $keys;
}

function eb_tool_cards( $keys ) {
	$catalog = eb_tool_catalog();
	$html    = '';
	foreach ( $keys as $key ) {
		$html .= sprintf(
			'<a class="eb-calccard eb-calccard--tool" href="%1$s"><strong>%2$s</strong><span>%3$s</span></a>',
			esc_url( $catalog[ $key ][0] ),
			esc_html( $catalog[ $key ][1] ),
			esc_html( $catalog[ $key ][2] )
		);
	}
	return $html;
}
/* 46. (2026-10-16 삭제) 휴대폰 옆 메뉴 보완 - 68번 전체 메뉴(#ebm)로 바뀌어 옛 옆 메뉴용 데이터(ebMenuData)·스크립트를 지움. 원본: 백업 임시글 15213 */


/* 48. 새 PC 헤더·메가메뉴(정돈형) + 새 홈 [eb_home] (style.css 69번, 2026-10-07) -------------------------------
 * - PC(1024px 이상): 기존 GP 메뉴 대신 .xh 헤더. 메뉴 4개(주 메뉴 위치의 맨 위 항목)마다 아래 패널, 오른쪽 칸(인기 검색어·다가오는 일정·바로가기 4개)은 공통
 *   메뉴 내용은 '외모 > 메뉴'의 주 메뉴를 그대로 읽으므로 메뉴를 고치면 패널도 따라 바뀜
 * - 태블릿·휴대폰은 기존 헤더 + 옆 메뉴(46번) 그대로
 * - 홈: 하늘색 배너(검색·인기·다가오는 일정) → 서비스 8개 → 많이 보는 정보·인기 검색어·광고① → 계산기·가이드·신청 마감 → 광고② → 분야별 → 새 소식·기관
 * - 날짜(D-day)는 캐시된 페이지에서도 맞도록 화면에서 방문자 날짜로 다시 계산(data-dd)
 */
function eb_x_ic( $name, $class = '' ) {
	static $p = array(
		'search'  => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'down'    => '<path d="m6 9 6 6 6-6"/>',
		'chev'    => '<path d="m9 6 6 6-6 6"/>',
		'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'compass' => '<path d="M11 3.5l1.9 4.9 4.9 1.9-4.9 1.9L11 17.1l-1.9-4.9-4.9-1.9 4.9-1.9z"/><path d="M18.2 15.2l.8 1.9 1.9.8-1.9.8-.8 1.9-.8-1.9-1.9-.8 1.9-.8z"/>', // 맞춤 찾기: 나침반 → 반짝이(나에게 맞춰 골라 줌, 2026-10-09 탭바 A안)
		'cal'     => '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18"/>',
		'calc'    => '<rect x="5" y="3" width="14" height="18" rx="2.5"/><path d="M8.5 7h7M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15h.01M8.5 18h7"/>',
		'table'   => '<rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9.5h18M3 14.5h18M9 9.5V20"/>',
		'doc'     => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
		'bank'    => '<path d="M3 20h18M5 20v-8.5M9.5 20v-8.5M14.5 20v-8.5M19 20v-8.5M12 3.5 3 8.5h18z"/>',
		'pin'     => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		'home'    => '<path d="M4 10.5 12 4l8 6.5V20H4z"/><path d="M10 20v-5.5h4V20"/>',
		'phone'   => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1A16 16 0 0 1 4 5a1 1 0 0 1 1-1z"/>',
		'book'    => '<path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H11v16H5.5A1.5 1.5 0 0 1 4 18.5zM20 5.5A1.5 1.5 0 0 0 18.5 4H13v16h5.5a1.5 1.5 0 0 0 1.5-1.5z"/>',
		'map'     => '<path d="M9 4 3 6.5v13L9 17l6 2.5 6-2.5v-13L15 6.5 9 4zM9 4v13M15 6.5v13"/>',
		'heart'   => '<path d="M12 20s-7-4.3-7-9.6A3.9 3.9 0 0 1 12 8a3.9 3.9 0 0 1 7 2.4C19 15.7 12 20 12 20z"/>',
		'pulse'   => '<path d="M3 12h4l2.5-6 5 12 2.5-6h4"/>',
		'card'    => '<rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 10h18M7 15h4"/>',
		'brief'   => '<rect x="3" y="7" width="18" height="13" rx="2.5"/><path d="M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M3 12.5h18"/>',
		'clock'   => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'star'    => '<path d="m12 3.5 2.6 5.3 5.9.9-4.3 4.1 1 5.8-5.2-2.7-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/>',
		'user'    => '<circle cx="12" cy="8" r="3.5"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/>',
		// 모바일 메뉴(46번)와 같은 분야 아이콘 - PC 메가메뉴 분야별 정보에서 씀
		'm-care'  => '<path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/>',
		'm-pulse' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
		'm-card'  => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/>',
		'm-brief' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
		'ext'     => '<path d="M14 4h6v6M20 4l-9 9M18 14v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4"/>',
		'news'    => '<path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h10A1.5 1.5 0 0 1 17 5.5V19a1 1 0 0 0 1 1H6a2 2 0 0 1-2-2z"/><path d="M17 9h2.5a.5.5 0 0 1 .5.5V18a2 2 0 0 1-2 2M7.5 8h6M7.5 11.5h6M7.5 15h4"/>',
	);
	return '<svg class="ic ' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ( isset( $p[ $name ] ) ? $p[ $name ] : '' ) . '</svg>';
}

// 주 메뉴를 나무 모양으로: [ [item, children=[ [item, children], ... ]], ... ]
function eb_x_menu_tree() {
	static $tree = null;
	if ( null !== $tree ) {
		return $tree;
	}
	$tree      = array();
	$locations = get_nav_menu_locations();
	if ( empty( $locations['primary'] ) ) {
		return $tree;
	}
	$items = wp_get_nav_menu_items( $locations['primary'] );
	if ( ! $items ) {
		return $tree;
	}
	$by = array();
	foreach ( $items as $it ) {
		$by[ (int) $it->menu_item_parent ][] = $it;
	}
	$build = function ( $parent ) use ( &$build, $by ) {
		$out = array();
		foreach ( isset( $by[ $parent ] ) ? $by[ $parent ] : array() as $it ) {
			$out[] = array( 'item' => $it, 'children' => $build( (int) $it->ID ) );
		}
		return $out;
	};
	$tree = $build( 0 );
	return $tree;
}

// 지급일 목록(이번 달부터 3개월, 주말·공휴일 반영) - 10번 함수 사용
function eb_x_paydays() {
	$today = current_datetime()->setTime( 0, 0 );
	$out   = array();
	for ( $i = 0; $i < 3; $i++ ) {
		$m = $today->modify( 'first day of this month' )->modify( "+{$i} month" );
		foreach ( eb_payday_groups() as $day => $what ) {
			$d     = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $day );
			$out[] = array( 'd' => $d->format( 'Y-m-d' ), 'l' => eb_payday_label( $d ), 'w' => $what );
		}
	}
	usort( $out, function ( $a, $b ) {
		return strcmp( $a['d'], $b['d'] );
	} );
	$ymd = $today->format( 'Y-m-d' );
	return array_values( array_filter( $out, function ( $x ) use ( $ymd ) {
		return $x['d'] >= $ymd;
	} ) );
}

function eb_x_dday( $ymd ) {
	$today = current_datetime()->setTime( 0, 0 );
	$diff  = (int) round( ( strtotime( $ymd ) - strtotime( $today->format( 'Y-m-d' ) ) ) / DAY_IN_SECONDS );
	return '<span class="dd" data-dd="' . esc_attr( $ymd ) . '">' . ( $diff > 0 ? 'D-' . $diff : '오늘' ) . '</span>';
}

function eb_x_dues( $limit = 4 ) {
	$today = current_datetime()->setTime( 0, 0 );
	$out   = array();
	foreach ( eb_upcoming_dues( $today, $limit ) as $x ) {
		$x['open'] = '' === $x['s'] || $x['s'] <= $today->format( 'Y-m-d' );
		$out[]     = $x;
	}
	return $out;
}

// 다가오는 일정 카드 줄(지급일 2개 + 신청·마감 1개) - 홈 배너와 메가메뉴 오른쪽 칸이 함께 씀
// $only_pay: 홈 '다가오는 지급일' 카드는 지급일만 3개(신청·마감은 아래 '신청·납부 마감' 칸에 있으니 빼서 두 칸 역할 구분, 2026-10-09)
function eb_x_pay_rows( $row_class, $only_pay = false ) {
	$html = '';
	foreach ( array_slice( eb_x_paydays(), 0, $only_pay ? 3 : 2 ) as $p ) {
		$html .= '<div class="' . $row_class . '"><span class="d">' . esc_html( $p['l'] ) . '</span><span class="wh">' . esc_html( $p['w'] ) . '</span>' . eb_x_dday( $p['d'] ) . '</div>';
	}
	$due = $only_pay ? array() : eb_x_dues( 1 );
	if ( $due ) {
		$x     = $due[0];
		$html .= '<div class="' . $row_class . '"><span class="d g">' . esc_html( $x['el'] ) . '</span><span class="wh"><i></i>' . esc_html( $x['n'] ) . '</span>' . str_replace( 'class="dd"', 'class="dd g"', eb_x_dday( $x['e'] ) ) . '</div>';
	}
	return $html;
}

function eb_x_trend() {
	$data = function_exists( 'eb_trend_terms' ) ? eb_trend_terms() : array( 'terms' => eb_popular_terms( 10 ), 'moves' => array() );
	$out  = array();
	foreach ( $data['terms'] as $i => $q ) {
		$m     = isset( $data['moves'][ $i ] ) ? $data['moves'][ $i ] : 0;
		$out[] = array(
			'q'  => $q,
			'n'  => $i + 1,
			'h'  => home_url( '/?s=' . rawurlencode( $q ) ),
			'mv' => 'new' === $m ? '<span class="mv u">NEW</span>' : ( $m > 0 ? '<span class="mv u">▲' . (int) $m . '</span>' : ( $m < 0 ? '<span class="mv d">▼' . abs( (int) $m ) . '</span>' : '<span class="mv e">-</span>' ) ),
		);
	}
	return $out;
}

// 분야(카테고리)에서 가장 많이 본 글 1개 → 없으면 최근 수정 글
function eb_x_top_post( $term_id ) {
	foreach ( eb_popular_ids() as $id ) {
		if ( 'post' === get_post_type( $id ) && 'publish' === get_post_status( $id ) && has_term( (int) $term_id, 'category', $id ) ) {
			return $id;
		}
	}
	$ids = get_posts( array( 'cat' => (int) $term_id, 'posts_per_page' => 1, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	return $ids ? $ids[0] : 0;
}

// 메가메뉴 보조: 분야(하위 분야 포함)에서 많이 본 글 n개, 모자라면 최근 수정 글로 채움
function eb_x_top_posts( $term_id, $n = 3 ) {
	$terms = array_merge( array( (int) $term_id ), array_map( 'intval', (array) get_term_children( (int) $term_id, 'category' ) ) );
	$out   = array();
	foreach ( eb_popular_ids() as $id ) {
		if ( count( $out ) >= $n ) {
			break;
		}
		if ( 'post' === get_post_type( $id ) && 'publish' === get_post_status( $id ) && has_term( $terms, 'category', $id ) ) {
			$out[] = (int) $id;
		}
	}
	if ( count( $out ) < $n ) {
		$more = get_posts( array( 'category__in' => $terms, 'posts_per_page' => $n + 3, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true, 'post__not_in' => $out ) );
		$out  = array_slice( array_merge( $out, array_map( 'intval', $more ) ), 0, $n );
	}
	return $out;
}

// 메뉴용 짧은 글 제목: ' – ', ' | ' 앞까지, 끝의 ' (…)' 설명은 뺌 (원래 제목은 title 속성으로)
function eb_x_short_title( $title ) {
	$parts = preg_split( '/\s+[–—|]\s+|\s+-\s+/u', $title );
	$short = trim( $parts[0] );
	$noparen = trim( preg_replace( '/\s+\([^)]*\)$/u', '', $short ) );
	return mb_strlen( $noparen ) >= 6 ? $noparen : $short;
}

// 계산기 페이지(/calculator/ 아래) 최근 30일 조회수 상위 n개 - 메가메뉴 '인기' 표시용, 6시간 캐시
function eb_x_hot_calcs( $n = 4 ) {
	$ids = get_transient( 'eb_hot_calcs_v2' );
	if ( false !== $ids ) {
		return $ids;
	}
	global $wpdb;
	$ids    = array();
	$table  = $wpdb->prefix . 'statistics_pages';
	$parent = get_page_by_path( 'calculator' );
	if ( $parent && $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
		$kids = get_posts( array( 'post_type' => 'page', 'post_parent' => $parent->ID, 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true ) );
		if ( $kids ) {
			$in  = implode( ',', array_map( 'intval', $kids ) );
			$ids = array_map( 'intval', (array) $wpdb->get_col( $wpdb->prepare( "SELECT id FROM {$table} WHERE id IN ({$in}) AND date >= %s GROUP BY id HAVING SUM(count) >= 30 ORDER BY SUM(count) DESC LIMIT %d", gmdate( 'Y-m-d', strtotime( '-30 days' ) ), $n ) ) );
		}
	}
	if ( count( $ids ) < 3 ) {
		$ids = array(); // 조회 기록이 적을 때는 '인기' 표시를 붙이지 않음(30일 30회 이상인 계산기가 3개 미만)
	}
	set_transient( 'eb_hot_calcs_v2', $ids, 6 * HOUR_IN_SECONDS );
	return $ids;
}

// 메가메뉴 패널 4개 (2026-10-08 개편: 열 머리 + 목록, 오른쪽 칸 없이 아래 띠는 eb_x_header_html에서)
function eb_x_mega_panes() {
	$tree = eb_x_menu_tree();
	if ( count( $tree ) < 4 ) {
		return array();
	}
	$t    = function ( $node ) {
		return esc_html( $node['item']->title );
	};
	$u    = function ( $node ) {
		return esc_url( $node['item']->url );
	};
	$d    = function ( $node ) {
		return esc_html( wp_strip_all_tags( $node['item']->description ) );
	};
	$all  = function ( $href, $label = '전체' ) {
		return '<a class="m-all" href="' . esc_url( $href ) . '">' . $label . ' ' . eb_x_ic( 'chev', 'xs' ) . '</a>';
	};
	$head = function ( $href, $ic, $title, $right = '' ) {
		return '<div class="m-head"><a href="' . esc_url( $href ) . '">' . ( $ic ? '<span class="m-ci">' . eb_x_ic( $ic ) . '</span>' : '' ) . '<strong>' . $title . '</strong></a>' . $right . '</div>';
	};

	// ① 분야별 정보: 분야 머리 + 하위 분야 칩 + 많이 보는 글 3개 (아이콘은 모바일 메뉴와 같게)
	$cat_ic = array( 'm-care', 'm-pulse', 'm-card', 'm-brief' );
	$p0     = '';
	foreach ( array_slice( $tree[0]['children'], 0, 4 ) as $i => $c ) {
		$chips = '';
		foreach ( $c['children'] as $s ) {
			$chips .= '<a class="m-chip" href="' . $u( $s ) . '">' . $t( $s ) . '</a>';
		}
		$reads = '';
		if ( 'taxonomy' === $c['item']->type ) {
			foreach ( eb_x_top_posts( $c['item']->object_id, 3 ) as $k => $pid ) {
				$full   = wp_strip_all_tags( html_entity_decode( get_the_title( $pid ), ENT_QUOTES, 'UTF-8' ) );
				$reads .= '<a class="m-row" href="' . esc_url( get_permalink( $pid ) ) . '" title="' . esc_attr( $full ) . '"><b>' . ( $k + 1 ) . '</b><span class="t">' . esc_html( eb_x_short_title( $full ) ) . '</span></a>';
			}
		}
		$p0 .= '<div class="m-col">' . $head( $c['item']->url, $cat_ic[ $i ], $t( $c ), $all( $c['item']->url ) ) . ( $chips ? '<div class="m-chips">' . $chips . '</div>' : '' ) . ( $reads ? '<div class="m-reads">' . $reads . '</div>' : '' ) . '</div>';
	}
	$p0 = '<div class="m-cols m-p0">' . $p0 . '</div>';

	// ② 바로 쓰는 도구: 왼쪽 도구(주 메뉴 항목, 상황별 가이드 제외) + 저장한 글 2칸×4줄, 오른쪽 연한 상자에 상황별 가이드 8개(짧은 이름) 2칸×4줄
	//    (2026-10-16 가이드 8개로 늘며 세로로 길어져 계산기 패널처럼 옆 상자로 정리. 짧은 이름은 홈 상단 칩과 같음, 전체 이름은 title)
	$guides = eb_guide_list();
	$tool  = function ( $href, $ic, $name, $desc, $pick = false ) {
		return '<a class="m-row m-tool' . ( $pick ? ' is-pick' : '' ) . '" href="' . esc_url( $href ) . '"><span class="m-mini">' . eb_x_ic( $ic ) . '</span><span class="m-tx"><strong>' . $name . ( $pick ? '<em class="m-badge">추천</em>' : '' ) . '</strong><small>' . $desc . '</small></span></a>';
	};
	$g_html = '';
	foreach ( $guides as $g ) {
		$g_html .= '<a class="m-gc" href="' . esc_url( home_url( $g[0] ) ) . '" title="' . esc_attr( $g[2] ) . '" aria-label="' . esc_attr( $g[2] ) . '"><span class="m-gc__i">' . eb_x_ic( $g[1] ) . '</span><span class="m-gc__t">' . esc_html( $g[4] ) . '</span></a>';
	}
	$tool_ic = array( '맞춤 혜택 찾기' => 'compass', '30초 맞춤 찾기' => 'compass', '복지 용어사전' => 'book', '공식 기관 모음' => 'bank', '공식 서식 모음' => 'doc', '주소·영문주소 찾기' => 'home', '우리 동네 복지 기관' => 'pin', '긴급·상담 전화' => 'phone' );
	$tools   = '';
	foreach ( $tree[1]['children'] as $s ) {
		$name = $s['item']->title;
		if ( false !== strpos( $name, '상황별' ) ) {
			continue;
		}
		$tools .= $tool( $s['item']->url, isset( $tool_ic[ $name ] ) ? $tool_ic[ $name ] : 'compass', $t( $s ), $d( $s ), false !== strpos( $name, '맞춤' ) );
	}
	$tools .= $tool( home_url( '/senior-equipment/' ), 'heart', '어르신 복지용구', '연 160만원, 15%만 내기' ); // 2026-10-16
	$tools .= $tool( home_url( '/saved/' ), 'star', '저장한 글', '저장해 둔 글 모아 보기' );
	// 2026-10-16: 도구 9개를 3칸×3줄로(예전 2칸×4줄보다 낮음) + 아래 사이트 안내 한 줄(협업·제휴 제안은 도구가 아니라 여기)
	// 2026-10-17 A안: 왼쪽 '이지복지닷컴' 이름표 + 작은 아이콘 링크 한 줄(연한 상자) - 도구가 아니라 사이트 정보라는 게 보이게
	$sv     = function ( $d ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
	};
	$site   = '<p class="m-site"><span class="m-site__lb">' . $sv( '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>' ) . '이지복지닷컴</span>'
		. '<a href="' . esc_url( home_url( '/about/' ) ) . '">' . $sv( '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>' ) . '사이트 안내</a>'
		. '<a href="' . esc_url( home_url( '/partners/' ) ) . '">' . $sv( '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M21.5 20a6.5 6.5 0 0 0-4-6"/>' ) . '협업·제휴</a>'
		. '<a href="' . esc_url( home_url( '/support/' ) ) . '">' . $sv( '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>' ) . '후원</a>'
		. '<a href="' . esc_url( home_url( '/faq/' ) ) . '">' . $sv( '<circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 1 1 3.5 2.3c-.6.3-1 .9-1 1.6v.4M12 17h.01"/>' ) . '자주 묻는 질문</a>'
		. '<a href="' . esc_url( home_url( '/contact/' ) ) . '">' . $sv( '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6.5 8.5-6.5"/>' ) . '문의</a></p>';
	$p1     = '<div class="m-cols m-p1"><div class="m-col">' . $head( $tree[1]['item']->url, '', '도구', $all( $tree[1]['item']->url ) ) . '<div class="m-grid2 m-grid3">' . $tools . '</div>' . $site . '</div>'
		. '<div class="m-col m-col--gbox"><div class="m-gbox">' . $head( home_url( '/guide/' ), '', '상황별 가이드', $all( home_url( '/guide/' ) ) ) . '<div class="m-gb">' . $g_html . '</div></div></div></div>';

	// ③ 복지 캘린더: 미니 달력(방문자 날짜로 화면에서 그림) + 다가오는 지급일 5개 + 신청·마감 4개
	$today = current_datetime()->setTime( 0, 0 );
	$marks = array();
	for ( $i = -1; $i < 3; $i++ ) {
		$m = $today->modify( 'first day of this month' )->modify( ( $i < 0 ? '' : '+' ) . $i . ' month' );
		foreach ( array_keys( eb_payday_groups() ) as $day ) {
			$marks[] = eb_payday_date( (int) $m->format( 'Y' ), (int) $m->format( 'n' ), $day )->format( 'Y-m-d' );
		}
	}
	$cal  = '<div class="m-cal" data-pay="' . esc_attr( implode( ',', $marks ) ) . '" data-hol="' . esc_attr( implode( ',', function_exists( 'eb_kr_holidays' ) ? eb_kr_holidays() : array() ) ) . '" data-due="' . esc_attr( implode( ',', function_exists( 'ebs_due_marks' ) ? ebs_due_marks() : array() ) ) . '"><div class="m-cal__h"><strong class="m-cal__m">' . esc_html( $today->format( 'n' ) ) . '월</strong><span><i></i>지급일</span><span class="is-due"><i></i>신청·마감</span><a href="' . esc_url( home_url( '/schedule/#calendar' ) ) . '">달력 ' . eb_x_ic( 'chev', 'xs' ) . '</a></div><div class="m-dow"><span>일</span><span>월</span><span>화</span><span>수</span><span>목</span><span>금</span><span>토</span></div><div class="m-days"></div></div>';
	$pays = '';
	foreach ( array_slice( eb_x_paydays(), 0, 5 ) as $p ) {
		$pays .= '<a class="m-li" href="' . esc_url( home_url( '/schedule/#d-' . $p['d'] ) ) . '"><span class="d">' . esc_html( $p['l'] ) . '</span><span class="w">' . esc_html( $p['w'] ) . '</span>' . eb_x_dday( $p['d'] ) . '</a>';
	}
	$dues = '';
	foreach ( eb_x_dues( 4 ) as $x ) {
		$dues .= '<a class="m-li" href="' . esc_url( home_url( '/schedule/' . ( ( $x['open'] ? $x['e'] : $x['s'] ) ? '#d-' . ( $x['open'] ? $x['e'] : $x['s'] ) : '#applying' ) ) ) . '"><span class="tag' . ( $x['open'] ? ' on' : '' ) . '">' . ( $x['open'] ? '접수 중' : '예정' ) . '</span><span class="w">' . esc_html( $x['n'] ) . '<small>~' . esc_html( $x['el'] ) . '</small></span>' . str_replace( 'class="dd"', 'class="dd' . ( $x['open'] ? ' on' : '' ) . '"', eb_x_dday( $x['e'] ) ) . '</a>';
	}
	$dues .= '<a class="m-li m-li--more" href="' . esc_url( home_url( '/schedule/#applying' ) ) . '">지금 신청할 수 있는 지원 모두 보기 ' . eb_x_ic( 'chev', 'xs' ) . '</a>';
	$p2    = '<div class="m-cols m-p2"><div class="m-col">' . $cal . '</div><div class="m-col"><div class="m-head"><strong>다가오는 지급일</strong><small>주말·공휴일 반영</small>' . $all( home_url( '/schedule/' ) ) . '</div>' . $pays . '</div><div class="m-col"><div class="m-head"><strong>신청·마감 일정</strong>' . $all( home_url( '/schedule/#yearly' ), '연간 일정' ) . '</div>' . $dues . '</div></div>';

	// ④ 계산기·기준표: 묶음 4개(주 메뉴, '기준표' 묶음 제외) + 올해 기준 금액(eb_median_income·eb_rates 값)
	$hot_urls = array_map( function ( $id ) {
		return untrailingslashit( get_permalink( $id ) );
	}, eb_x_hot_calcs( 4 ) );
	$calc_ic  = array( 'm-care', 'm-brief', 'm-card', 'user' );
	$p3       = '';
	$k        = 0;
	foreach ( $tree[3]['children'] as $g ) {
		if ( ! $g['children'] || false !== strpos( $g['item']->title, '기준표' ) ) {
			continue;
		}
		$links = '';
		foreach ( $g['children'] as $s ) {
			$hot    = in_array( untrailingslashit( $s['item']->url ), $hot_urls, true );
			$links .= '<a class="m-row" href="' . $u( $s ) . '"><span class="t">' . esc_html( preg_replace( '/ (모의)?계산기$/u', '', $s['item']->title ) ) . '</span>' . ( $hot ? '<em class="m-pop">인기</em>' : '' ) . '</a>';
		}
		$p3 .= '<div class="m-col">' . $head( $g['item']->url, $calc_ic[ $k % 4 ], $t( $g ) ) . $links . '</div>';
		$k++;
	}
	// 2026-10-17 시안: 오른쪽 연한 상자 = '입력 한 번에 다 계산' 4개(바로 쓰는 도구 판의 가이드 상자와 같은 모양) + 올해 기준 금액 한 줄
	$qa   = '';
	$cat  = function_exists( 'eb_calc_catalog' ) ? eb_calc_catalog() : array();
	$qdes = array( 'quitall' => '퇴직금·실업급여', 'baby' => '두 살까지 달력', 'pay' => '4대보험·세금', 'closing' => '철거비·노란우산' );
	foreach ( $qdes as $key => $desc ) {
		if ( isset( $cat[ $key ] ) ) {
			$qa .= '<a class="m-qa" href="' . esc_url( home_url( $cat[ $key ][0] ) ) . '"><strong>' . esc_html( preg_replace( '/\s*계산기$/u', '', $cat[ $key ][1] ) ) . '</strong><small>' . esc_html( $desc ) . '</small></a>';
		}
	}
	$mi  = function_exists( 'eb_median_income' ) ? eb_median_income() : array();
	$rt  = function_exists( 'eb_rates' ) ? eb_rates() : array();
	$kv  = '';
	if ( isset( $rt['min_wage'] ) ) {
		$kv .= '<span>최저시급 <b>' . number_format_i18n( $rt['min_wage'] ) . '</b></span>';
	}
	if ( isset( $mi['median'][4] ) ) {
		$kv .= '<span>중위 4인 <b>' . number_format_i18n( floor( $mi['median'][4] / 10000 ) ) . '만</b></span>';
	}
	$kv .= '<a href="' . esc_url( home_url( '/standards/' ) ) . '">' . ( isset( $mi['year'] ) ? (int) $mi['year'] : (int) current_time( 'Y' ) ) . ' 기준표 ' . eb_x_ic( 'chev', 'xs' ) . '</a>';
	$p3 .= '<div class="m-col m-col--gbox"><div class="m-gbox m-qbox">' . $head( home_url( '/calculator/#all-in-one' ), '', '입력 한 번에 다 계산', $all( home_url( '/calculator/' ), '전체 ' . count( $cat ) . '개' ) ) . '<div class="m-qg">' . $qa . '</div><p class="m-qkv">' . $kv . '</p></div></div>';
	$p3  = '<div class="m-cols m-p3">' . $p3 . '</div>';

	return array( $p0, $p1, $p2, $p3 );
}

function eb_x_header_html() {
	$tree  = eb_x_menu_tree();
	$panes = eb_x_mega_panes();
	if ( ! $panes ) {
		return '';
	}
	$nav = '';
	foreach ( array_slice( $tree, 0, 4 ) as $i => $n ) {
		$nav .= '<li><a href="' . esc_url( $n['item']->url ) . '" class="xh__top" data-i="' . $i . '" aria-expanded="false" aria-haspopup="true">' . esc_html( $n['item']->title ) . eb_x_ic( 'down', 'xs' ) . '</a></li>';
	}
	$hot = '';
	foreach ( array_slice( eb_x_trend(), 0, 6 ) as $x ) {
		$hot .= '<a href="' . esc_url( $x['h'] ) . '"><b>' . $x['n'] . '</b>' . esc_html( $x['q'] ) . '</a>';
	}
	// 패널 아래 한 줄 띠: 인기 검색어 10개(순위 변동·집계 시각)를 한 줄로 옆으로 밀기 + 긴급·상담 전화 (2026-10-08, 10개·밀기 2026-10-09 - style.css 85번)
	$s_hot = '';
	foreach ( array_slice( eb_x_trend(), 0, 10 ) as $x ) {
		$s_hot .= '<a href="' . esc_url( $x['h'] ) . '"><b>' . $x['n'] . '</b>' . esc_html( $x['q'] ) . ( false === strpos( $x['mv'], 'mv e' ) ? str_replace( array( '▲', '▼' ), array( '<span class="screen-reader-text">상승 </span><span aria-hidden="true">▲</span>', '<span class="screen-reader-text">하락 </span><span aria-hidden="true">▼</span>' ), $x['mv'] ) : '' ) . '</a>';
	}
	$s_at = '';
	if ( function_exists( 'eb_trend_terms' ) ) {
		$s_tr = eb_trend_terms();
		$s_at = isset( $s_tr['at'] ) ? $s_tr['at'] : '';
		if ( preg_match( '/(\d{1,2}):\d{2}$/', $s_at, $s_mm ) ) {
			$s_at = (int) $s_mm[1] . '시'; // 오늘 날짜는 빼고 시각만
		}
	}
	$right = '<div class="mx-strip"><span class="m-hot-lab"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/></svg>인기 검색어' . ( $s_at ? '<small>' . esc_html( $s_at ) . ' 기준</small>' : '' ) . '</span><div class="m-hotw"><button type="button" class="m-hot__nav m-hot__prev" aria-label="인기 검색어 앞으로"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 6-6 6 6 6"/></svg></button><div class="m-hot">' . $s_hot . '</div><button type="button" class="m-hot__nav m-hot__next" aria-label="인기 검색어 더 보기"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg></button></div><div class="mx-strip__go"><a href="' . esc_url( home_url( '/hotline/' ) ) . '">' . eb_x_ic( 'phone', 'xs' ) . '긴급·상담 전화</a></div></div>';
	$left  = '';
	foreach ( $panes as $i => $p ) {
		$left .= '<div class="mx-pane" data-i="' . $i . '" hidden>' . $p . '</div>';
	}
	$brand = '<div class="xh__brand navigation-branding"><p class="main-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><span class="eb-brand"><span class="eb-brand__name" aria-hidden="true">' . eb_wordmark() . '</span></span><span class="screen-reader-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span></a></p></div>';
	return '<header id="xh" class="xh">'
		. '<div class="xh__in">' . $brand . '<nav class="xh__nav" aria-label="주 메뉴"><ul>' . $nav . '</ul></nav>'
		. '<div class="xh__act"><form class="xh__sf" action="' . esc_url( home_url( '/' ) ) . '" role="search">' . eb_x_ic( 'search' ) . '<input name="s" type="search" placeholder="지원금·서류 검색" aria-label="사이트 검색" autocomplete="off"></form><div class="xh__fs"><button type="button" class="xh__fsb" aria-haspopup="true" aria-expanded="false" aria-label="글자 크기 바꾸기"><span class="s" aria-hidden="true">가</span><span class="l" aria-hidden="true">가</span></button><div class="xh__fsp" hidden><p>글자 크기<small>이 기기에 기억돼요</small></p><div class="eb-fsseg" role="group" aria-label="글자 크기"><button type="button" data-fs="1" aria-pressed="true" aria-label="기본 글자">가</button><button type="button" data-fs="2" aria-pressed="false" aria-label="큰 글자">가+</button><button type="button" data-fs="3" aria-pressed="false" aria-label="아주 큰 글자">가++</button></div></div></div><a class="xh__cta" href="' . esc_url( home_url( '/find/#finder' ) ) . '">' . eb_x_ic( 'compass', 'sm xh__cta-ic' ) . '<span>맞춤 찾기</span>' . eb_x_ic( 'arrow', 'xs xh__cta-go' ) . '</a></div></div>'
		. '<div class="mx" hidden><div class="mx-in"><div class="mx-left">' . $left . '</div>' . $right . '</div></div><div class="xh__dim"></div></header>';
}

add_action( 'wp_body_open', function () {
	if ( is_admin() ) {
		return;
	}
	echo eb_x_header_html(); // phpcs:ignore
}, 5 );

add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	// D-day: 캐시된 페이지에서도 방문자 날짜로 다시 계산
	var n = new Date(), t = new Date(n.getFullYear(), n.getMonth(), n.getDate());
	document.querySelectorAll('[data-dd]').forEach(function (el) {
		var d = new Date(el.getAttribute('data-dd') + 'T00:00:00'), v = Math.round((d - t) / 864e5);
		el.textContent = v > 0 ? 'D-' + v : (v === 0 ? '오늘' : '');
	});
	// PC 메가메뉴
	var xh = document.getElementById('xh');
	if (xh) {
		var mx = xh.querySelector('.mx'), cur = null, tm = null;
		var open = function (i) {
			clearTimeout(tm);
			xh.querySelectorAll('.mx-pane').forEach(function (p) { p.hidden = p.getAttribute('data-i') !== String(i); });
			xh.querySelectorAll('.xh__top').forEach(function (b) { b.setAttribute('aria-expanded', b.getAttribute('data-i') === String(i) ? 'true' : 'false'); });
			mx.hidden = false; cur = String(i);
		};
		var close = function () {
			mx.hidden = true; cur = null;
			xh.querySelectorAll('.xh__top').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
		};
		xh.querySelectorAll('.xh__top').forEach(function (a) {
			a.addEventListener('mouseenter', function () { clearTimeout(tm); tm = setTimeout(function () { open(a.getAttribute('data-i')); }, cur === null ? 110 : 0); });
			a.addEventListener('click', function (e) { if (cur !== a.getAttribute('data-i')) { e.preventDefault(); open(a.getAttribute('data-i')); } });
			a.addEventListener('focus', function () { open(a.getAttribute('data-i')); });
		});
		xh.addEventListener('mouseleave', function () { clearTimeout(tm); tm = setTimeout(close, 220); });
		xh.addEventListener('mouseenter', function () { clearTimeout(tm); });
		// 어둡게 덮는 막(.xh__dim)도 #xh 안에 있어서 메뉴 밖으로 나가도 mouseleave가 안 생김 → 막 위로 나가면 닫고, 메뉴·헤더로 돌아오면 취소 (2026-10-09)
		var dim = xh.querySelector('.xh__dim');
		dim.addEventListener('click', close);
		dim.addEventListener('mouseenter', function () { clearTimeout(tm); tm = setTimeout(close, 220); });
		[mx, xh.querySelector('.xh__in')].forEach(function (el) { if (el) { el.addEventListener('mouseenter', function () { clearTimeout(tm); }); } });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && cur !== null) { close(); } });
	}
	// 홈 탭(많이 보는 정보 · 휴대폰 분야별)
	var R = document.getElementById('ebc');
	if (R) {
		var bind = function (sel, attr, targets, mode) {
			var btns = R.querySelectorAll(sel);
			btns.forEach(function (b) {
				b.addEventListener('click', function () {
					btns.forEach(function (x) { x.setAttribute('aria-selected', x === b ? 'true' : 'false'); });
					R.querySelectorAll(targets).forEach(function (u) {
						if (mode === 'hidden') { u.hidden = u.getAttribute(attr) !== b.getAttribute(attr); } else { u.classList.toggle('on', u.getAttribute(attr) === b.getAttribute(attr)); }
					});
				});
			});
		};
		bind('.c-grid--1 .c-tab button', 'data-p', '.c-rows', 'hidden');
		bind('.c-tab--m button', 'data-b', '.c-board', 'on');
	}
})();
JS
	. "\n</script>\n";
}, 66 );

// 공식 기관 모음(/links/ 14934)에 실린 기관 수 - 본문의 바깥 링크 중 지도처럼 '↗'가 붙은 링크는 빼고 셈, 글을 고치면 다시 셈 (2026-10-08)
function eb_links_count() {
	$page = get_post( 14934 );
	if ( ! $page ) {
		return 33;
	}
	$key = 'eb_links_n_' . md5( $page->post_modified_gmt );
	$n   = get_transient( $key );
	if ( false === $n ) {
		preg_match_all( '#<a\s[^>]*href="https?://[^"]+"[^>]*>(.*?)</a>#su', $page->post_content, $m );
		$n = 0;
		foreach ( $m[1] as $label ) {
			if ( false === strpos( $label, '↗' ) ) {
				$n++;
			}
		}
		set_transient( $key, $n, WEEK_IN_SECONDS );
	}
	return (int) $n;
}

// 홈 'ⓘ 안내': 자동으로 바뀌는 칸의 계산 기준을 제목 옆 작은 설명 창으로 (style.css 79번, 2026-10-09)
// $right: 칸 오른쪽에 있어 설명 창을 왼쪽으로 펼칠 때
// $label: 제목 옆 회색 기준 글씨('최근 30일 기준' 등)를 ⓘ와 한 버튼으로 (2026-10-09)
function eb_x_info( $title, $body, $items = array(), $right = false, $label = '' ) {
	$list = '';
	foreach ( $items as $it ) {
		$list .= '<li>' . esc_html( $it ) . '</li>';
	}
	return '<span class="c-info' . ( $right ? ' c-info--r' : '' ) . ( $label ? ' c-info--t' : '' ) . '"><button type="button" aria-expanded="false" aria-label="' . esc_attr( ( $label ? $label . ' - ' : '' ) . $title ) . ' 안내 보기">' . ( $label ? '<span class="c-info__t">' . esc_html( $label ) . '</span>' : '' )
		. '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></svg></button>'
		. '<span class="c-info__pop" role="note" hidden><b>' . esc_html( $title ) . '</b>' . ( $body ? esc_html( $body ) : '' ) . ( $list ? '<ul>' . $list . '</ul>' : '' ) . '</span></span>';
}

// 많이 보는 정보 기간별(오늘·최근 7일) - WP Statistics 페이지 조회 기록, 오늘은 1시간·7일은 3시간마다 다시 셈 (2026-10-09)
function eb_popular_ids_days( $days ) {
	$key = 'eb_popular_d' . (int) $days;
	$ids = get_transient( $key );
	if ( false !== $ids ) {
		return $ids;
	}
	global $wpdb;
	$table = $wpdb->prefix . 'statistics_pages';
	$ids   = array();
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
		$ids = array_map( 'intval', (array) $wpdb->get_col(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE type = 'post' AND date >= %s GROUP BY id ORDER BY SUM(count) DESC LIMIT 40",
				wp_date( 'Y-m-d', strtotime( '-' . max( 0, (int) $days - 1 ) . ' days' ) )
			)
		) );
	}
	set_transient( $key, $ids, ( 1 === (int) $days ? 1 : 3 ) * HOUR_IN_SECONDS );
	return $ids;
}


// 2026-10-09 개선안 2번 C안: 홈 배너 '복지로 데이터 갱신 배지 + 오늘의 한 줄'
// 한 줄 = ① (다시 온 방문자) 지난번 맞춤 찾기 조건 - 스크립트가 맨 앞에 넣음 ② 접수 중(없으면 가장 가까운) 신청·마감 ③ 이번 주 새로 생긴 복지서비스(있을 때만, 누르면 목록)
function eb_home_live_html( $inf ) {
	$at  = max( (int) get_option( 'eb_ws_synced' ), (int) get_option( 'eb_ws_local_synced' ) );
	$n   = count( (array) get_option( 'eb_ws_all', array() ) ) + count( (array) get_option( 'eb_ws_local', array() ) );
	$chv = '<svg class="c-tick__go" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>';
	$h   = '<div class="c-live">';
	if ( $at ) {
		$h .= '<p class="c-live__b"><span class="c-live__dot" aria-hidden="true"></span><span class="c-live__t" data-at="' . esc_attr( $at ) . '">' . esc_html( wp_date( 'm.d H:i', $at ) ) . ' 갱신</span><span class="c-live__s">· 복지로 공식 데이터 ' . esc_html( number_format_i18n( $n ) ) . '개</span></p>';
	}
	$items = '';
	$dues  = function_exists( 'eb_x_dues' ) ? eb_x_dues( 5 ) : array();
	$due   = null;
	foreach ( $dues as $x ) {
		if ( $x['open'] ) {
			$due = $x;
			break;
		}
	}
	if ( ! $due && $dues ) {
		$due = $dues[0];
	}
	if ( $due ) {
		$items .= '<li><a class="c-tick__i" href="' . esc_url( home_url( '/schedule/' ) ) . '"><span class="c-tick__tg ' . ( $due['open'] ? 'is-open' : 'is-soon' ) . '">' . ( $due['open'] ? '접수 중' : '접수 예정' ) . '</span><span class="c-tick__m">' . esc_html( $due['n'] ) . '</span>' . eb_x_dday( $due['open'] || ! $due['s'] ? $due['e'] : $due['s'] ) . $chv . '</a></li>';
	}
	$new = (array) get_option( 'eb_ws_new', array() );
	if ( $new ) {
		arsort( $new );
		$byid = array();
		foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
			if ( ! empty( $s['id'] ) && isset( $new[ $s['id'] ] ) ) {
				$byid[ $s['id'] ] = $s;
			}
		}
		$li = '';
		foreach ( array_slice( array_keys( $new ), 0, 8 ) as $id ) {
			if ( isset( $byid[ $id ] ) ) {
				$li .= '<a href="' . esc_url( $byid[ $id ]['link'] ) . '" target="_blank" rel="noopener"><strong>' . esc_html( $byid[ $id ]['name'] ) . '</strong><small>' . esc_html( $byid[ $id ]['org'] ) . '</small><span class="screen-reader-text">(새 창)</span></a>';
			}
		}
		if ( $li ) {
			$items .= '<li><button type="button" class="c-tick__i" aria-expanded="false" aria-controls="c-newsvc"><span class="c-tick__tg is-new">NEW</span><span class="c-tick__m">이번 주 새로 생긴 복지서비스 <b>' . count( $byid ) . '개</b></span>' . $chv . '</button></li>';
			$pop    = '<div class="c-newsvc" id="c-newsvc" hidden><p>복지로에 이번 주 새로 올라온 정부 서비스예요</p>' . $li . '</div>';
		}
	}
	if ( ! $items ) {
		$items = '<li><a class="c-tick__i" href="' . esc_url( home_url( '/find/#finder' ) ) . '"><span class="c-tick__tg is-new">30초</span><span class="c-tick__m">내게 맞는 혜택 찾기</span>' . $chv . '</a></li>';
	}
	$h .= '<div class="c-tick" aria-roledescription="소식 넘기기" aria-label="오늘의 소식"><ul class="c-tick__list">' . $items . '</ul><div class="c-tick__dots" aria-hidden="true"></div></div>' . ( isset( $pop ) ? $pop : '' );
	$h .= '<p class="c-live__note">' . $inf . '공식 기관이 아닌 민간 정보 사이트예요</p></div>';
	return $h;
}
add_action( 'wp_footer', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$find = esc_js( home_url( '/find/' ) );
	echo "<script nowprocket>\n" . str_replace( '%FIND%', $find, <<<'JS'
(function () {
	var R = document.querySelector('#ebc .c-live');
	if (!R) { return; }
	// 갱신 시각: 보고 있는 기기 날짜 기준 '오늘 16:20' · '어제 16:20' · '10.07 16:20'
	var T = R.querySelector('.c-live__t');
	if (T) {
		var d = new Date(+T.getAttribute('data-at') * 1000), now = new Date(), p = function (n) { return (n < 10 ? '0' : '') + n; };
		var day = Math.round((new Date(now.getFullYear(), now.getMonth(), now.getDate()) - new Date(d.getFullYear(), d.getMonth(), d.getDate())) / 864e5);
		T.textContent = (day === 0 ? '오늘 ' : day === 1 ? '어제 ' : p(d.getMonth() + 1) + '.' + p(d.getDate()) + ' ') + p(d.getHours()) + ':' + p(d.getMinutes()) + ' 갱신';
	}
	var list = R.querySelector('.c-tick__list'), dots = R.querySelector('.c-tick__dots'), tick = R.querySelector('.c-tick');
	var esc = function (s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
	// 다시 온 방문자: 지난번 맞춤 찾기 조건(55번 eb_finder_last)
	try {
		var L = JSON.parse(localStorage.getItem('eb_finder_last') || 'null');
		if (L && L.v === 2 && L.l && L.l.length) {
			var q = new URLSearchParams();
			if (L.life) { q.set('life', L.life); }
			if (L.hh && L.hh.length) { q.set('hh', L.hh.join(',')); }
			if (L.th && L.th.length) { q.set('th', L.th.join(',')); }
			if (L.sd) { q.set('sd', L.sd); }
			if (L.sg) { q.set('sg', L.sg); }
			var li = document.createElement('li');
			li.innerHTML = '<a class="c-tick__i is-again" href="%FIND%?' + esc(q.toString()) + '#finder"><span class="c-tick__tg is-again">다시 찾기</span><span class="c-tick__m">' + esc(L.l.slice(0, 3).join(' · ')) + ' 조건으로</span>' + R.querySelector('.c-tick__go').outerHTML + '</a>';
			list.insertBefore(li, list.firstChild);
		}
	} catch (e) {}
	var items = [].slice.call(list.children), i = 0, timer = null, n = items.length;
	var show = function (k) {
		i = (k + n) % n;
		list.style.transform = 'translateY(' + (-100 * i) + '%)';
		items.forEach(function (el, j) { el.setAttribute('aria-hidden', j === i ? 'false' : 'true'); el.querySelectorAll('a,button').forEach(function (b) { b.tabIndex = j === i ? 0 : -1; }); });
		[].forEach.call(dots.children, function (b, j) { b.classList.toggle('is-on', j === i); });
	};
	if (n > 1) {
		dots.innerHTML = items.map(function (_, j) { return '<button type="button" tabindex="-1" aria-label="' + (j + 1) + '번째 소식"></button>'; }).join('');
		dots.removeAttribute('aria-hidden');
		dots.addEventListener('click', function (e) { var b = e.target.closest('button'); if (b) { show([].indexOf.call(dots.children, b)); } });
		var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var play = function () { if (!reduce && !timer) { timer = setInterval(function () { show(i + 1); }, 4000); } };
		var stop = function () { clearInterval(timer); timer = null; };
		tick.addEventListener('mouseenter', stop); tick.addEventListener('mouseleave', play);
		tick.addEventListener('focusin', stop); tick.addEventListener('focusout', play);
		document.addEventListener('visibilitychange', function () { if (document.hidden) { stop(); } else { play(); } });
		play();
	}
	show(0);
	// 새로 생긴 복지서비스 목록 열기·닫기
	var nb = R.querySelector('button.c-tick__i'), pop = R.querySelector('.c-newsvc');
	if (nb && pop) {
		nb.addEventListener('click', function () { var o = pop.hidden; pop.hidden = !o; nb.setAttribute('aria-expanded', o ? 'true' : 'false'); });
		document.addEventListener('click', function (e) { if (!pop.hidden && !e.target.closest('.c-newsvc') && !e.target.closest('button.c-tick__i')) { pop.hidden = true; nb.setAttribute('aria-expanded', 'false'); } });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !pop.hidden) { pop.hidden = true; nb.setAttribute('aria-expanded', 'false'); nb.focus(); } });
	}
})();
JS
	) . "\n</script>\n";
}, 99 );

// 2026-10-09 홈 상단 전면 개편(시안 4차): 한 문장 찾기 카드(조건으로 / 검색어로) + 앞으로 2주 복지 일정 (style.css 116번, 아래 스크립트 hx)
// 예전 배너(신뢰 줄·소식 한 줄·상황 칩·내 맞춤 줄·다가오는 지급일 카드)를 대신함. 검색 탭의 form.c-search는 기존 홈 스크립트(인기 검색어 돌리기)가 그대로 씀
function eb_hero_v3_html( $trend, $roll ) {
	$svg   = function ( $d, $w = '2' ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $w . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
	};
	$down  = $svg( '<path d="m6 9 6 6 6-6"/>', '2.4' );
	$chev  = $svg( '<path d="m9 6 6 6-6 6"/>', '2.2' );
	$terms = function_exists( 'eb_tax_terms' ) ? eb_tax_terms() : array();
	$regs  = function_exists( 'eb_ws_regions' ) ? eb_ws_regions() : array();
	$at    = max( (int) get_option( 'eb_ws_synced' ), (int) get_option( 'eb_ws_local_synced' ) );
	$nsvc  = count( (array) get_option( 'eb_ws_all', array() ) ) + count( (array) get_option( 'eb_ws_local', array() ) );
	// 머리: 제목(H1, 검색어용 보조 문구 포함) + 오른쪽 갱신 상태
	$h  = '<section class="hx"><div class="w hx__in"><div class="hx__hd"><div class="hx__ht"><p class="hx__eb"><i aria-hidden="true"></i><span class="hx__date">' . esc_html( wp_date( 'n월 j일 l' ) ) . '</span><span class="hx__ebs">· 오늘의 복지 혜택</span></p><h1 class="hx__h1"><span class="screen-reader-text">정부 지원금·복지 혜택 내 상황에 맞게 찾기 - </span>받을 수 있는 지원금, <br><em>30초</em>면 알 수 있어요</h1>';
	// 2026-10-09 손질: '오늘 16:44 갱신'(방문자에겐 의미 적음) 대신 찾는 범위(정부·지자체 n개 + 가이드)를 설명으로
	// 머리 A안(2026-10-09): 날짜 머리말 + 쓰는 법 설명 + 오른쪽 신뢰 상자(체크 3줄 + 민간 사이트 안내)
	$ok = $svg( '<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/>', '2.2' );
	$h .= '<p class="hx__sub">나이와 사는 곳만 고르면 <span class="hx__long">받을 수 있는 혜택을 </span>바로 알려 드려요</p></div>'
		. '<div class="hx__trust"><ul><li>' . $ok . '<span>복지서비스 <b>' . esc_html( number_format_i18n( $nsvc ) ) . '개</b></span></li><li>' . $ok . '<span>공식 데이터 매일 반영</span></li><li>' . $ok . '<span>조건은 이 기기에만 저장</span></li></ul></div>'; // 2026-10-18 A안: 세로 상자 → 알약 3개(css/50-home.css 끝). '민간 정보 사이트' 안내는 바닥글에 있음
	$h .= '</div><div class="hx__grid">';
	// ── 찾기 카드
	$life = '';
	if ( $terms ) {
		$ic = function_exists( 'eb_f2_life_icons' ) ? eb_f2_life_icons() : array();
		foreach ( $terms['eb_life'][1] as $slug => $name ) {
			$life .= '<button type="button" class="hx__opt" data-g="life" data-v="' . esc_attr( $name ) . '" aria-pressed="false">' . ( isset( $ic[ $slug ] ) ? eb_f2_icon( $ic[ $slug ] ) : '' ) . esc_html( $name ) . '</button>';
		}
	}
	$chips = function ( $g, $list ) {
		$o = '';
		foreach ( $list as $name ) {
			$o .= '<button type="button" class="hx__chip" data-g="' . $g . '" data-v="' . esc_attr( $name ) . '" aria-pressed="false">' . esc_html( $name ) . '</button>';
		}
		return $o;
	};
	$hh = $terms ? array_values( $terms['eb_hh'][1] ) : array();
	$th = $terms && function_exists( 'eb_f2_themes' ) ? call_user_func_array( 'array_merge', eb_f2_themes( $terms ) ) : array();
	$sd = '';
	foreach ( array_keys( $regs ) as $s ) {
		$sd .= '<option value="' . esc_attr( $s ) . '">' . esc_html( $s ) . '</option>';
	}
	$sit = array_map( function ( $g ) { return array( $g[0], $g[4] ); }, eb_guide_list() ); // 상황별 가이드 칩(eb_guide_list)
	$sh  = '';
	foreach ( $sit as $x ) {
		$sh .= '<a href="' . esc_url( home_url( $x[0] ) ) . '">' . esc_html( $x[1] ) . $svg( '<path d="M7 17 17 7M9 7h8v8"/>', '2.2' ) . '</a>';
	}
	$t_data = function_exists( 'eb_trend_terms' ) ? eb_trend_terms() : array();
	$t_when = isset( $t_data['at'] ) ? preg_replace_callback( '/ (\d{1,2}):00$/', function ( $m ) {
		return ' ' . (int) $m[1] . '시';
	}, $t_data['at'] ) . ' 기준' : '최근 24시간';
	$hot = '';
	foreach ( array_slice( (array) $trend, 0, 10 ) as $x ) {
		$hot .= '<a href="' . esc_url( $x['h'] ) . '"><b>' . (int) $x['n'] . '</b><span>' . esc_html( $x['q'] ) . '</span>' . $x['mv'] . '</a>';
	}
	$data = array( 'data' => rest_url( 'eb/v1/finder-data' ), 'api' => rest_url( 'eb/v1/services' ), 'lapi' => rest_url( 'eb/v1/local' ), 'find' => home_url( '/find/' ), 'regions' => array_map( function ( $sgs ) { return array_values( array_filter( array_keys( $sgs ) ) ); }, $regs ) );
	$h .= '<div class="hx__fc" data-set="' . esc_attr( wp_json_encode( $data ) ) . '">'
		. '<div class="hx__tabs" role="tablist" aria-label="찾는 방법"><button type="button" role="tab" id="hx-t1" aria-controls="hx-p1" aria-selected="true" data-tab="find">' . eb_x_ic( 'compass' ) . '조건으로 찾기</button><button type="button" role="tab" id="hx-t2" aria-controls="hx-p2" aria-selected="false" data-tab="search" tabindex="-1">' . eb_x_ic( 'search' ) . '검색어로 찾기</button></div>'
		// 조건으로
		. '<div class="hx__pane" id="hx-p1" role="tabpanel" aria-labelledby="hx-t1" data-pane="find">'
		. '<p class="hx__again" hidden>' . $svg( '<path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/>', '2.2' ) . '지난번 조건을 불러왔어요<button type="button" class="hx__reset">새로 고르기</button></p>'
		. '<p class="hx__sent">저는 <button type="button" class="hx__pick is-empty" data-k="life" aria-haspopup="true" aria-expanded="false"><span>나이·시기</span>' . $down . '</button>이고,<br class="hx__br"> '
		. '<button type="button" class="hx__pick is-empty" data-k="rg" aria-haspopup="true" aria-expanded="false"><span>사는 곳</span>' . $down . '</button>에 살아요. '
		. '<button type="button" class="hx__pick is-more" data-k="more" aria-haspopup="true" aria-expanded="false">' . $svg( '<path d="M12 5v14M5 12h14"/>', '2.4' ) . '<span>가구·필요한 도움 더하기</span></button></p>'
		// 고르는 창 3개
		. '<div class="hx__pop" data-for="life" hidden><p class="hx__pt">지금 어느 시기인가요?</p><div class="hx__opts">' . $life . '</div></div>'
		. '<div class="hx__pop" data-for="rg" hidden><p class="hx__pt">어디에 사세요? <small>지역 복지서비스까지 찾아요</small></p><div class="hx__rg"><label><span class="screen-reader-text">시·도</span><select class="hx__sd"><option value="">시·도 선택</option>' . $sd . '</select></label><label><span class="screen-reader-text">시·군·구</span><select class="hx__sg" disabled><option value="">시·군·구</option></select></label></div><div class="hx__pf"><button type="button" class="hx__clr" data-clr="rg">지우기</button><button type="button" class="hx__ok">확인</button></div></div>'
		. '<div class="hx__pop is-wide" data-for="more" hidden><p class="hx__pt">가구 상황 <small>해당하면 모두</small></p><div class="hx__chips">' . $chips( 'hh', $hh ) . '</div><p class="hx__pt">필요한 도움 <small>여러 개</small></p><div class="hx__chips">' . $chips( 'th', $th ) . '</div><div class="hx__pf"><button type="button" class="hx__clr" data-clr="more">지우기</button><button type="button" class="hx__ok">확인</button></div></div>'
		. '<div class="hx__chosen" hidden></div>'
		. '<nav class="hx__sit" aria-label="상황별 가이드"><span>상황별 가이드</span>' . $sh . '</nav>'
		. '<div class="hx__pv" aria-live="polite" hidden></div>'
		. '<div class="hx__res"><p class="hx__num"><small>받을 수 있는 혜택</small><strong hidden></strong><span class="hx__hint">조건을 고르면 바로 세어 드려요</span></p><p class="hx__brk" hidden></p><a class="hx__go" href="' . esc_url( home_url( '/find/#finder' ) ) . '">결과 보기' . $svg( '<path d="M5 12h14M13 6l6 6-6 6"/>', '2.4' ) . '</a></div>'
		. '</div>'
		// 검색어로
		. '<div class="hx__pane" id="hx-p2" role="tabpanel" aria-labelledby="hx-t2" data-pane="search" hidden>'
		. '<form class="c-search hx__sb" action="' . esc_url( home_url( '/' ) ) . '" role="search" data-roll="' . esc_attr( $roll ) . '">' . eb_x_ic( 'search' ) . '<input name="s" type="search" placeholder="지원금·서류·계산기 검색" aria-label="검색어"><button type="submit">검색</button></form>'
		. ( $hot ? '<div class="hx__hh"><p class="hx__hl">' . $svg( '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>', '2.4' ) . '지금 많이 찾는 검색어</p><span class="hx__hw">' . esc_html( $t_when ) . '</span></div><div class="hx__hot">' . $hot . '</div>' : '' )
		. '</div></div>';
	// ── 앞으로 2주 복지 일정
	$today = current_datetime()->setTime( 0, 0 );
	$pays  = function_exists( 'eb_x_paydays' ) ? eb_x_paydays() : array();
	$dues  = function_exists( 'eb_x_dues' ) ? eb_x_dues( 5 ) : array();
	$hol   = function_exists( 'eb_kr_holidays' ) ? array_flip( eb_kr_holidays() ) : array();
	$pmap  = array();
	foreach ( $pays as $p ) {
		$pmap[ $p['d'] ] = $p['w'];
	}
	$dmap = array();
	foreach ( $dues as $x ) {
		$dmap[ $x['e'] ] = $x['n'];
	}
	$wk = array( '일', '월', '화', '수', '목', '금', '토' );
	$g  = '';
	for ( $i = 0; $i < 7; $i++ ) {
		$n  = (int) $today->modify( "+{$i} day" )->format( 'w' );
		$g .= '<span class="wd' . ( 0 === $n ? ' sun' : ( 6 === $n ? ' sat' : '' ) ) . '">' . $wk[ $n ] . '</span>'; // .w는 사이트 틀 클래스라 wd
	}
	for ( $i = 0; $i < 14; $i++ ) {
		$d   = $today->modify( "+{$i} day" );
		$ymd = $d->format( 'Y-m-d' );
		$n   = (int) $d->format( 'w' );
		$c   = array();
		if ( 0 === $i ) {
			$c[] = 'today';
		}
		if ( 0 === $n || isset( $hol[ $ymd ] ) ) {
			$c[] = 'sun';
		} elseif ( 6 === $n ) {
			$c[] = 'sat';
		}
		$tip = '';
		if ( isset( $pmap[ $ymd ] ) ) {
			$c[] = $pays && $pmap[ $ymd ] === $pays[0]['w'] ? 'pay' : 'pay pay2'; // 지급 묶음별 색(남색·노랑)
			$tip = $pmap[ $ymd ] . ' 지급';
		} elseif ( isset( $dmap[ $ymd ] ) ) {
			$c[] = 'due';
			$tip = $dmap[ $ymd ] . ' 마감';
		}
		$lab = $d->format( 'n월 j일' ) . ( 0 === $i ? '(오늘)' : '' ) . ( $tip ? ' ' . $tip : '' );
		$g  .= '<span class="' . esc_attr( implode( ' ', $c ) ) . '" data-d="' . esc_attr( $ymd ) . '" title="' . esc_attr( $lab ) . '"><span class="screen-reader-text">' . esc_html( $lab ) . '</span><span aria-hidden="true">' . (int) $d->format( 'j' ) . '</span></span>';
	}
	// PC는 이번 달 달력(한눈에 익숙한 모양, 카드 높이도 찾기 카드와 맞음), 휴대폰은 위의 2주 두 줄(짧게) - style.css 119번
	$first = $today->modify( 'first day of this month' );
	$days  = (int) $first->format( 't' );
	$lead  = (int) $first->format( 'w' );
	$mo    = '';
	foreach ( $wk as $i => $w ) {
		$mo .= '<span class="wd' . ( 0 === $i ? ' sun' : ( 6 === $i ? ' sat' : '' ) ) . '">' . $w . '</span>';
	}
	$mo .= str_repeat( '<span class="x" aria-hidden="true"></span>', $lead );
	for ( $i = 1; $i <= $days; $i++ ) {
		$d   = $first->modify( '+' . ( $i - 1 ) . ' day' );
		$ymd = $d->format( 'Y-m-d' );
		$n   = (int) $d->format( 'w' );
		$c   = array();
		if ( $ymd === $today->format( 'Y-m-d' ) ) {
			$c[] = 'today';
		} elseif ( $ymd < $today->format( 'Y-m-d' ) ) {
			$c[] = 'past';
		}
		if ( 0 === $n || isset( $hol[ $ymd ] ) ) {
			$c[] = 'sun';
		} elseif ( 6 === $n ) {
			$c[] = 'sat';
		}
		$tip = '';
		if ( isset( $pmap[ $ymd ] ) ) {
			$c[] = $pays && $pmap[ $ymd ] === $pays[0]['w'] ? 'pay' : 'pay pay2'; // 지급 묶음별 색(남색·노랑)
			$tip = $pmap[ $ymd ] . ' 지급';
		} elseif ( isset( $dmap[ $ymd ] ) ) {
			$c[] = 'due';
			$tip = $dmap[ $ymd ] . ' 마감';
		}
		$lab = $d->format( 'n월 j일' ) . ( in_array( 'today', $c, true ) ? '(오늘)' : '' ) . ( $tip ? ' ' . $tip : '' );
		$mo .= '<span class="' . esc_attr( implode( ' ', $c ) ) . '" data-d="' . esc_attr( $ymd ) . '" title="' . esc_attr( $lab ) . '"><span class="screen-reader-text">' . esc_html( $lab ) . '</span><span aria-hidden="true">' . $i . '</span></span>';
	}
	// 일정 줄(2026-10-09 손질): 왼쪽 날짜 칸(월·일, 종류별 색) + 이름·설명 + 오른쪽 D-day 알약
	$wkn  = array( '일', '월', '화', '수', '목', '금', '토' );
	$tile = function ( $ymd, $cls ) use ( $wkn ) {
		$t = strtotime( $ymd );
		return '<span class="dt ' . $cls . '" aria-hidden="true"><small>' . (int) gmdate( 'n', $t ) . '월</small><b>' . (int) gmdate( 'j', $t ) . '</b></span>';
	};
	$ev = '';
	foreach ( array_slice( $pays, 0, 2 ) as $k => $p ) {
		$cls = $p['w'] === $pays[0]['w'] ? 'c1' : 'c2';
		$ev .= '<li class="' . $cls . '">' . $tile( $p['d'], $cls ) . '<span class="t"><strong>' . esc_html( $p['w'] ) . '</strong><small>' . esc_html( $wkn[ (int) gmdate( 'w', strtotime( $p['d'] ) ) ] ) . '요일 지급</small></span>' . eb_x_dday( $p['d'] ) . '</li>';
	}
	$due = null;
	foreach ( $dues as $x ) {
		if ( $x['open'] ) {
			$due = $x;
			break;
		}
	}
	if ( ! $due && $dues ) {
		$due = $dues[0];
	}
	if ( $due ) {
		$dd  = $due['open'] || ! $due['s'] ? $due['e'] : $due['s'];
		$ev .= '<li class="c3">' . $tile( $dd, 'c3' ) . '<span class="t"><strong>' . esc_html( $due['n'] ) . '</strong><small>' . ( $due['open'] ? '접수 중 · 이날 마감' : '이날 접수 시작' ) . '</small></span>' . eb_x_dday( $dd ) . '</li>';
	}
	$newl = '';
	$new  = (array) get_option( 'eb_ws_new', array() );
	if ( $new ) {
		arsort( $new );
		$by = array();
		foreach ( (array) get_option( 'eb_ws_all', array() ) as $s ) {
			if ( ! empty( $s['id'] ) && isset( $new[ $s['id'] ] ) ) {
				$by[ $s['id'] ] = $s;
			}
		}
		$li = '';
		foreach ( array_slice( array_keys( $new ), 0, 8 ) as $id ) {
			if ( isset( $by[ $id ] ) ) {
				$li .= '<a href="' . esc_url( $by[ $id ]['link'] ) . '" target="_blank" rel="noopener"><strong>' . esc_html( $by[ $id ]['name'] ) . '</strong><small>' . esc_html( $by[ $id ]['org'] ) . '</small><span class="screen-reader-text">(새 창)</span></a>';
			}
		}
		if ( $li ) {
			$newl = '<button type="button" class="hx__new" aria-expanded="false" aria-controls="hx-new"><b>NEW</b><span>이번 주 새로 생긴 복지서비스 <em>' . count( $by ) . '개</em></span>' . $chev . '</button><div class="hx__newl" id="hx-new" hidden><p>복지로에 이번 주 새로 올라온 정부 서비스예요</p>' . $li . '</div>';
		}
	}
	// 달력 카드 전면 개편(2026-10-09, style.css 129번): ① 다음 지급일 큰 칸(D-day) ② 달력(PC 이번 달 / 휴대폰 2주) - 표시된 날을 누르면 ①이 그날 일정으로 ③ 접수 중 마감 한 줄
	$lab_of = function ( $ymd ) use ( $wkn ) {
		$t = strtotime( $ymd );
		return (int) gmdate( 'n', $t ) . '월 ' . (int) gmdate( 'j', $t ) . '일 ' . $wkn[ (int) gmdate( 'w', $t ) ] . '요일';
	};
	$evmap = array();
	foreach ( $pmap as $ymd => $w ) {
		$evmap[ $ymd ] = array( $pays && $w === $pays[0]['w'] ? 'pay' : 'pay2', $w, '지급' );
	}
	foreach ( $dues as $x ) {
		if ( ! isset( $evmap[ $x['e'] ] ) ) {
			$evmap[ $x['e'] ] = array( 'due', $x['n'], '마감' );
		}
		if ( $x['s'] && ! isset( $evmap[ $x['s'] ] ) ) {
			$evmap[ $x['s'] ] = array( 'due', $x['n'], '접수 시작' );
		}
	}
	$nx = $pays ? '<div class="hx__nx is-pay" aria-live="polite"><span class="hx__nxd">' . eb_x_dday( $pays[0]['d'] ) . '</span><span class="hx__nxt"><small>다음 지급일 · ' . esc_html( $lab_of( $pays[0]['d'] ) ) . '</small><strong>' . esc_html( $pays[0]['w'] ) . '</strong></span></div>' : '';
	$dueh = '';
	if ( $due ) {
		$dd   = $due['open'] || ! $due['s'] ? $due['e'] : $due['s'];
		$dueh = '<a class="hx__due' . ( $due['open'] ? ' is-open' : '' ) . '" href="' . esc_url( home_url( '/schedule/' ) ) . '"><span class="k">' . ( $due['open'] ? '접수 중' : '곧 접수' ) . '</span><span class="t"><strong>' . esc_html( $due['n'] ) . '</strong><small>' . esc_html( $due['open'] ? '~ ' . $due['el'] . ' 마감' : $due['sl'] . ' 접수 시작' ) . '</small></span>' . eb_x_dday( $dd ) . '</a>';
	}
	$h .= '<aside class="hx__cal" aria-label="복지 일정" data-ev="' . esc_attr( wp_json_encode( $evmap, JSON_UNESCAPED_UNICODE ) ) . '"><div class="hx__ch"><h2><span class="hx__t-pc">복지 달력 <em>' . (int) $today->format( 'n' ) . '월</em></span><span class="hx__t-m">앞으로 <em>2주</em> 복지 일정</span></h2><a href="' . esc_url( home_url( '/schedule/' ) ) . '">전체 일정 ›</a></div>'
		. $nx . '<div class="hx__mo">' . $mo . '</div><div class="hx__wk">' . $g . '</div>' . $dueh . $newl . '</aside>';
	$h .= '</div></div></section>';
	return $h;
}

add_action( 'wp_footer', function () {
	if ( ! is_front_page() ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var R = document.querySelector('.hx');
	if (!R) { return; }
	var fc = R.querySelector('.hx__fc'), D = {};
	try { D = JSON.parse(fc.getAttribute('data-set')) || {}; } catch (e) {}
	var esc = function (s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
	var has = function (a, v) { return a && a.indexOf(v) > -1; };
	var p2 = function (n) { return (n < 10 ? '0' : '') + n; };
	var DT = R.querySelector('.hx__date');
	if (DT) { var td = new Date(); DT.textContent = (td.getMonth() + 1) + '월 ' + td.getDate() + '일 ' + ['일', '월', '화', '수', '목', '금', '토'][td.getDay()] + '요일'; }
	// 갱신 시각: 보고 있는 기기 날짜 기준 '오늘 16:44'·'어제 16:44'·'10.07 16:44'
	var T = R.querySelector('[data-at]');
	if (T) {
		var d = new Date(+T.getAttribute('data-at') * 1000), now = new Date();
		var day = Math.round((new Date(now.getFullYear(), now.getMonth(), now.getDate()) - new Date(d.getFullYear(), d.getMonth(), d.getDate())) / 864e5);
		T.textContent = (day === 0 ? '오늘 ' : day === 1 ? '어제 ' : p2(d.getMonth() + 1) + '.' + p2(d.getDate()) + ' ') + p2(d.getHours()) + ':' + p2(d.getMinutes()) + ' 갱신';
	}
	// ── 탭(조건으로 / 검색어로) - 마지막으로 쓴 탭은 이 기기에 기억
	var tabs = [].slice.call(R.querySelectorAll('.hx__tabs [role="tab"]'));
	var setTab = function (k, focus) {
		tabs.forEach(function (b) { var on = b.getAttribute('data-tab') === k; b.setAttribute('aria-selected', on ? 'true' : 'false'); b.tabIndex = on ? 0 : -1; if (on && focus) { b.focus(); } });
		R.querySelectorAll('.hx__pane').forEach(function (p) { p.hidden = p.getAttribute('data-pane') !== k; });
		try { localStorage.setItem('eb_hx_tab', k); } catch (e) {}
	};
	tabs.forEach(function (b, i) {
		b.addEventListener('click', function () { setTab(b.getAttribute('data-tab')); if (b.getAttribute('data-tab') === 'search') { var q = R.querySelector('.hx__sb input'); if (q && window.innerWidth >= 768) { q.focus(); } } });
		b.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') { e.preventDefault(); setTab(tabs[(i + (e.key === 'ArrowRight' ? 1 : tabs.length - 1)) % tabs.length].getAttribute('data-tab'), true); } });
	});
	try { if (localStorage.getItem('eb_hx_tab') === 'search' || location.hash === '#search') { setTab('search'); } } catch (e) {} // #search: 검색 탭으로 바로 열기
	// ── 조건
	var S = { life: '', hh: [], th: [], sd: '', sg: '' }, posts = null, svc = null, loc = {}, locKey = '', busy = false, n = 0;
	var sdSel = R.querySelector('.hx__sd'), sgSel = R.querySelector('.hx__sg'), again = R.querySelector('.hx__again');
	var anyC = function () { return !!(S.life || S.hh.length || S.th.length); };
	var any = function () { return anyC() || !!S.sd; };
	var short = function (sd) { return sd.replace(/(특별자치시|특별자치도|특별시|광역시)$/, '').replace(/^(충청|전라|경상)(남|북)도$/, function (m, a, b) { return a.charAt(0) + b; }).replace(/^경기도$/, '경기'); };
	var rlab = function () { return S.sd ? short(S.sd) + (S.sg ? ' ' + S.sg : '') : ''; };
	var labels = function () { return (S.life ? [S.life] : []).concat(S.hh, S.th, S.sd ? [rlab()] : []); };
	try { var L = JSON.parse(localStorage.getItem('eb_finder_last') || 'null'); if (L && L.v === 2 && (L.life || (L.hh && L.hh.length) || (L.th && L.th.length) || L.sd)) { S.life = L.life || ''; S.hh = L.hh || []; S.th = L.th || []; S.sd = L.sd || ''; S.sg = L.sg || ''; again.hidden = false; } } catch (e) {}
	// 주소에 조건이 있으면(?life=&hh=&th=&sd=&sg=, 혜택 찾기와 같은 형식) 그 조건으로 - 공유 링크
	var Q = new URLSearchParams(location.search);
	if (Q.get('life') || Q.get('hh') || Q.get('th') || Q.get('sd')) { S = { life: Q.get('life') || '', hh: (Q.get('hh') || '').split(',').filter(Boolean), th: (Q.get('th') || '').split(',').filter(Boolean), sd: Q.get('sd') || '', sg: Q.get('sg') || '' }; again.hidden = true; }
	if (S.sd && !(D.regions || {})[S.sd]) { S.sd = ''; S.sg = ''; }
	var fillSg = function () {
		var sgs = S.sd && D.regions && D.regions[S.sd] ? D.regions[S.sd] : [];
		sgSel.innerHTML = '<option value="">' + (S.sd ? '시·군·구 전체' : '시·군·구') + '</option>' + sgs.map(function (g) { return '<option value="' + esc(g) + '">' + esc(g) + '</option>'; }).join('');
		sgSel.disabled = !sgs.length; sgSel.value = S.sg; sdSel.value = S.sd;
	};
	var match = function (l, h, t) {
		if (S.life && l.length && !has(l, S.life)) { return null; }
		var why = [];
		if (S.life && has(l, S.life)) { why.push(S.life); }
		S.hh.forEach(function (v) { if (has(h, v)) { why.push(v); } });
		S.th.forEach(function (v) { if (has(t, v)) { why.push(v); } });
		return why.length ? why : null;
	};
	var rank = function (list) { return list.sort(function (a, b) { return ((a.pr || 0) - (b.pr || 0)) || (b.why.length - a.why.length) || ((b.x.p || 0) - (a.x.p || 0)) || (((a.x.l || []).length || 9) - ((b.x.l || []).length || 9)) || a.k.localeCompare(b.k, 'ko'); }); };
	var load = function () {
		if (busy) { return; }
		busy = true;
		fetch(D.data, { credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (j) { posts = (j && j.posts) || []; calc(); }).catch(function () { posts = []; calc(); });
		fetch(D.api, { credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (j) { svc = (j && j.items) || []; calc(); }).catch(function () { svc = []; calc(); });
	};
	var loadLocal = function () {
		if (!S.sd) { return; }
		var k = S.sd + '|' + S.sg;
		if (loc[k] || locKey === k) { return; }
		locKey = k;
		fetch(D.lapi + (D.lapi.indexOf('?') > -1 ? '&' : '?') + 'sd=' + encodeURIComponent(S.sd) + '&sg=' + encodeURIComponent(S.sg), { credentials: 'same-origin' })
			.then(function (r) { return r.json(); }).then(function (j) { loc[k] = (j && j.items) || []; calc(); }).catch(function () { loc[k] = []; calc(); });
	};
	var url = function () {
		var p = new URLSearchParams();
		if (S.life) { p.set('life', S.life); }
		if (S.hh.length) { p.set('hh', S.hh.join(',')); }
		if (S.th.length) { p.set('th', S.th.join(',')); }
		if (S.sd) { p.set('sd', S.sd); }
		if (S.sg) { p.set('sg', S.sg); }
		var qs = p.toString();
		return D.find + (qs ? '?' + qs : '') + '#finder';
	};
	var PRE = [['청년', '청년 · 일자리', '취업·월세·목돈 지원', 'c1', { life: '청년', th: ['일자리'] }], ['노년', '어르신 · 저소득', '기초연금·생활지원', 'c2', { life: '노년', hh: ['저소득'] }], ['임신·출산', '아이를 기다려요', '임신·출산·보육 지원', 'c3', { life: '임신·출산', th: ['임신·출산'] }]];
	var numEl = R.querySelector('.hx__num strong'), hint = R.querySelector('.hx__hint'), brk = R.querySelector('.hx__brk'), go = R.querySelector('.hx__go'), pv = R.querySelector('.hx__pv');
	var calc = function () {
		go.href = url();
		// 고른 조건 칩(× 하나씩 빼기 · 모두 지우기) - 상황별 가이드 자리에
		var ch = R.querySelector('.hx__chosen'), cl = [];
		if (S.life) { cl.push(['life', S.life, S.life]); }
		if (S.sd) { cl.push(['rg', '', rlab()]); }
		S.hh.forEach(function (v) { cl.push(['hh', v, v]); });
		S.th.forEach(function (v) { cl.push(['th', v, v]); });
		ch.hidden = !cl.length;
		ch.innerHTML = cl.length ? '<span class="l">고른 조건</span>' + cl.map(function (c) { return '<button type="button" data-rm="' + c[0] + '" data-v="' + esc(c[1]) + '" aria-label="' + esc(c[2]) + ' 빼기">' + esc(c[2]) + '<i aria-hidden="true">×</i></button>'; }).join('') + '<button type="button" class="all" data-rm="all">모두 지우기</button>' : '';
		fc.classList.toggle('is-set', any()); // 조건을 고르기 시작하면 '상황별 가이드'(다른 페이지 링크)는 숨김 - 고르다 잘못 눌러 페이지가 바뀌던 문제
		if (!any()) {
			numEl.hidden = true; hint.hidden = false; brk.hidden = true; brk.innerHTML = '';
			// 아직 안 골랐을 때: 많이 찾는 조합 3개(누르면 바로 그 조건으로)
			pv.hidden = false; pv.classList.add('is-preset');
			pv.innerHTML = '<p class="hx__pvh">많이 찾는 조합<span>누르면 바로 골라져요</span></p><div class="hx__pvl">' + PRE.map(function (p, i) { return '<button type="button" class="' + p[3] + '" data-pre="' + i + '"><span class="k">' + esc(p[0]) + '</span><strong>' + esc(p[1]) + '</strong><span class="o">' + esc(p[2]) + '</span></button>'; }).join('') + '</div>';
			return;
		}
		pv.classList.remove('is-preset');
		numEl.hidden = false; hint.hidden = true;
		var LA = S.sd ? loc[S.sd + '|' + S.sg] : [], P = [], G = [], LM = [];
		if (anyC()) {
			(posts || []).forEach(function (x) { var w = match(x.l || [], x.h || [], x.th || []), rg = x.r || []; if (!w || (rg.length && S.sd && rg.indexOf(S.sd) < 0)) { return; } P.push({ x: x, why: w, k: x.t, pr: rg.length ? (S.sd ? -1 : 1) : 0 }); });
			(svc || []).forEach(function (x) { var w = match(x.l || [], x.h || [], x.t || []); if (w) { G.push({ x: x, why: w, k: x.n }); } });
		}
		(LA || []).forEach(function (x) { var w = anyC() ? match(x.l || [], x.h || [], x.t || []) : []; if (w) { LM.push({ x: x, why: w, k: x.n }); } });
		rank(P); rank(G); rank(LM);
		var ready = !!(posts && svc && (!S.sd || LA));
		n = P.length + G.length + LM.length;
		numEl.innerHTML = ready ? n + '<span>개</span>' : '<i class="hx__ld" aria-label="세는 중"></i>';
		brk.hidden = !ready;
		brk.innerHTML = ready ? '<i class="c1">정부 <b>' + G.length + '</b></i>' + (S.sd ? '<i class="c2">우리 지역 <b>' + LM.length + '</b></i>' : '') + '<i class="c3">정리 글 <b>' + P.length + '</b></i>' : '';
		// 미리 보기: [색, 종류, 이름, 주소, 새 창, 아래 작은 글]
		var pick = [LM[0] && ['c2', '우리 지역', LM[0].x.n, LM[0].x.u, 1, (LM[0].x.sg && LM[0].x.sg !== '교육청' ? LM[0].x.sg : short(S.sd) + (LM[0].x.sg === '교육청' ? ' 교육청' : ' 전체')) + ' · 복지로'], G[0] && ['c1', '정부', G[0].x.n, G[0].x.u, 1, G[0].x.o + ' · 복지로'], P[0] && ['c3', '에디터 정리', P[0].x.t, P[0].x.u, 0, '쉽게 정리한 글']].filter(Boolean);
		var rest = G.slice(1, 3).map(function (o) { return ['c1', '정부', o.x.n, o.x.u, 1, o.x.o + ' · 복지로']; });
		while (pick.length < 3 && rest.length) { pick.push(rest.shift()); }
		pv.hidden = !ready || !pick.length;
		pv.innerHTML = '<p class="hx__pvh">이런 혜택이 있어요<span>조건이 많이 겹치는 순</span></p><div class="hx__pvl">' + pick.map(function (c) { return '<a class="' + c[0] + '" href="' + esc(c[3]) + '"' + (c[4] ? ' target="_blank" rel="noopener"' : '') + '><span class="k">' + esc(c[1]) + '</span><strong>' + esc(c[2]) + '</strong><span class="o">' + esc(c[5]) + (c[4] ? ' <i aria-hidden="true">↗</i><span class="screen-reader-text">(새 창)</span>' : ' <i aria-hidden="true">→</i>') + '</span></a>'; }).join('') + '</div>';
		if (ready) {
			try { localStorage.setItem('eb_finder_last', JSON.stringify({ v: 2, life: S.life, hh: S.hh, th: S.th, sd: S.sd, sg: S.sg, l: labels(), n: n, at: Date.now() })); } catch (e) {}
		}
	};
	// 문장 칸 표시
	var picks = {};
	R.querySelectorAll('.hx__pick').forEach(function (b) { picks[b.getAttribute('data-k')] = b; });
	var paint = function () {
		var set = function (b, txt, ph) { b.querySelector('span').textContent = txt || ph; b.classList.toggle('is-empty', !txt); };
		set(picks.life, S.life, '나이·시기');
		set(picks.rg, rlab(), '사는 곳');
		var m = S.hh.concat(S.th);
		picks.more.querySelector('span').textContent = m.length ? m.slice(0, 2).join(' · ') + (m.length > 2 ? ' 외 ' + (m.length - 2) : '') : '가구·필요한 도움 더하기';
		picks.more.classList.toggle('is-set', !!m.length);
		R.querySelectorAll('[data-g]').forEach(function (b) { var g = b.getAttribute('data-g'), v = b.getAttribute('data-v'); b.setAttribute('aria-pressed', (g === 'life' ? S.life === v : has(S[g], v)) ? 'true' : 'false'); });
	};
	// 고르는 창
	var openK = '';
	var pop = function (k) { return R.querySelector('.hx__pop[data-for="' + k + '"]'); };
	var close = function (back) {
		if (!openK) { return; }
		pop(openK).hidden = true; picks[openK].setAttribute('aria-expanded', 'false');
		if (back) { picks[openK].focus(); }
		openK = '';
	};
	var open = function (k) {
		if (openK === k) { close(); return; }
		close(); openK = k;
		var p = pop(k), b = picks[k];
		p.hidden = false; b.setAttribute('aria-expanded', 'true');
		// 위치: 누른 칸 바로 아래(카드 안에서 넘치지 않게)
		var pr = p.offsetParent.getBoundingClientRect(), br = b.getBoundingClientRect();
		p.style.top = (br.bottom - pr.top + 8) + 'px';
		var left = Math.max(12, Math.min(br.left - pr.left, pr.width - p.offsetWidth - 12));
		p.style.left = left + 'px';
		load();
		var f = p.querySelector('[aria-pressed="true"], select, button'); if (f) { f.focus(); }
	};
	Object.keys(picks).forEach(function (k) { picks[k].addEventListener('click', function (e) { e.stopPropagation(); open(k); }); });
	R.addEventListener('click', function (e) {
		var b = e.target.closest('[data-g]');
		if (b) {
			var g = b.getAttribute('data-g'), v = b.getAttribute('data-v');
			if (g === 'life') { S.life = S.life === v ? '' : v; close(true); }
			else { S[g] = has(S[g], v) ? S[g].filter(function (x) { return x !== v; }) : S[g].concat(v); }
			again.hidden = true; paint(); calc(); return;
		}
		var rm = e.target.closest('[data-rm]');
		if (rm) {
			var g = rm.getAttribute('data-rm'), v = rm.getAttribute('data-v');
			if (g === 'all') { S = { life: '', hh: [], th: [], sd: '', sg: '' }; }
			else if (g === 'life') { S.life = ''; }
			else if (g === 'rg') { S.sd = ''; S.sg = ''; }
			else { S[g] = S[g].filter(function (x) { return x !== v; }); }
			fillSg(); again.hidden = true; paint(); calc();
			if (!any()) { try { localStorage.removeItem('eb_finder_last'); } catch (x) {} }
			return;
		}
		var pr = e.target.closest('[data-pre]');
		if (pr) { var o = PRE[+pr.getAttribute('data-pre')][4]; S.life = o.life || ''; S.hh = o.hh || []; S.th = o.th || []; paint(); load(); loadLocal(); calc(); return; }
		if (e.target.closest('.hx__ok')) { close(true); return; }
		var c = e.target.closest('.hx__clr');
		if (c) { if (c.getAttribute('data-clr') === 'rg') { S.sd = ''; S.sg = ''; fillSg(); } else { S.hh = []; S.th = []; } paint(); calc(); return; }
		if (e.target.closest('.hx__reset')) { S = { life: '', hh: [], th: [], sd: '', sg: '' }; fillSg(); again.hidden = true; try { localStorage.removeItem('eb_finder_last'); } catch (x) {} paint(); calc(); return; }
	});
	document.addEventListener('click', function (e) { if (openK && !e.target.closest('.hx__pop') && !e.target.closest('.hx__pick')) { close(); } });
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && openK) { close(true); } });
	sdSel.addEventListener('change', function () { S.sd = sdSel.value; S.sg = ''; fillSg(); again.hidden = true; paint(); loadLocal(); calc(); });
	sgSel.addEventListener('change', function () { S.sg = sgSel.value; paint(); loadLocal(); calc(); });
	fillSg(); paint();
	if (any()) { load(); loadLocal(); }
	calc();
	// ── 달력: 표시된 날(지급·마감)을 누르면 위 큰 칸이 그날 일정으로, 같은 날을 다시 누르면 처음(다음 지급일)으로
	var cal = R.querySelector('.hx__cal'), nx = R.querySelector('.hx__nx');
	if (cal && nx) {
		var EV = {}; try { EV = JSON.parse(cal.getAttribute('data-ev')) || {}; } catch (e) {}
		var first = nx.innerHTML, firstCls = nx.className, sel = null;
		var WK = ['일', '월', '화', '수', '목', '금', '토'];
		cal.querySelectorAll('[data-d]').forEach(function (c) {
			if (!EV[c.getAttribute('data-d')]) { return; }
			c.classList.add('is-ev'); c.setAttribute('role', 'button'); c.tabIndex = 0; c.setAttribute('aria-pressed', 'false');
		});
		var pick = function (c) {
			var d = c.getAttribute('data-d'), e = EV[d];
			cal.querySelectorAll('.is-ev[aria-pressed="true"]').forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
			if (sel === d) { sel = null; nx.innerHTML = first; nx.className = firstCls; return; }
			sel = d;
			cal.querySelectorAll('[data-d="' + d + '"]').forEach(function (x) { x.setAttribute('aria-pressed', 'true'); });
			var p = d.split('-'), dt = new Date(+p[0], +p[1] - 1, +p[2]), now = new Date(), t0 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
			var n = Math.round((dt - t0) / 864e5);
			nx.className = 'hx__nx is-' + e[0];
			nx.innerHTML = '<span class="hx__nxd"><span class="dd">' + (n > 0 ? 'D-' + n : (n === 0 ? '오늘' : '지남')) + '</span></span><span class="hx__nxt"><small>' + (+p[1]) + '월 ' + (+p[2]) + '일 ' + WK[dt.getDay()] + '요일 · ' + esc(e[2]) + '</small><strong>' + esc(e[1]) + '</strong></span>';
		};
		cal.addEventListener('click', function (ev) { var c = ev.target.closest('.is-ev'); if (c) { pick(c); } });
		cal.addEventListener('keydown', function (ev) { var c = ev.target.closest && ev.target.closest('.is-ev'); if (c && (ev.key === 'Enter' || ev.key === ' ')) { ev.preventDefault(); pick(c); } });
	}
	// ── 새로 생긴 복지서비스 목록
	var nb = R.querySelector('.hx__new'), nl = R.querySelector('.hx__newl');
	if (nb && nl) {
		nb.addEventListener('click', function () { var o = nl.hidden; nl.hidden = !o; nb.setAttribute('aria-expanded', o ? 'true' : 'false'); });
	}
})();
JS
	. "\n</script>\n";
}, 99 );

// 2026-10-09: 홈 '새로 정리한 정보'(6초)·'생활 특가'(7초) 자동 넘기기 - 화면에 보일 때만, 마우스를 올리거나 누르면 12초 쉼, 끝이면 처음으로, 움직임 줄이기 설정이면 안 함
add_action( 'wp_footer', function () {
	if ( ! is_front_page() ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }
	var auto = function (box, getScroller, ms) {
		if (!box) { return; }
		var seen = false, rest = 0;
		var pause = function () { rest = Date.now() + 12000; };
		['pointerenter', 'pointerdown', 'focusin', 'touchstart', 'wheel'].forEach(function (ev) { box.addEventListener(ev, pause, { passive: true }); });
		box.addEventListener('pointerleave', function () { rest = Date.now() + 3000; });
		if ('IntersectionObserver' in window) { new IntersectionObserver(function (e) { seen = e[0].isIntersecting; }, { threshold: 0.4 }).observe(box); } else { seen = true; }
		setInterval(function () {
			if (!seen || document.hidden || Date.now() < rest) { return; }
			var sc = getScroller();
			if (!sc || sc.children.length < 2) { return; }
			var step = sc.children[1].offsetLeft - sc.children[0].offsetLeft || sc.clientWidth;
			var per = Math.max(1, Math.floor(sc.clientWidth / step + 0.05));
			var max = sc.scrollWidth - sc.clientWidth - 2;
			if (sc.scrollLeft >= max) { sc.scrollTo({ left: 0, behavior: 'smooth' }); } else { sc.scrollBy({ left: per * step, behavior: 'smooth' }); }
		}, ms);
	};
	var nw = document.querySelector('#ebc .c-new');
	auto(nw, function () { return nw.querySelector('.c-cards'); }, 6000);
	var dl = document.querySelector('#ebc .c-deal');
	auto(dl, function () { return [].slice.call(dl.querySelectorAll('.c-deal__grid')).filter(function (g) { return !g.hidden; })[0]; }, 7000);
})();
JS
	. "\n</script>\n";
}, 99 );

// 새 홈 [eb_home]
function eb_home_v2_html() {
	$base   = array( 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'no_found_rows' => true, 'fields' => 'ids' );
	$trend  = eb_x_trend();
	$t_data = function_exists( 'eb_trend_terms' ) ? eb_trend_terms() : array();
	$t_fill = isset( $t_data['h24'] ) && $t_data['h24'] < 10; // 24시간 검색이 모자라 그동안의 검색어로 채웠는지
	// 제목 옆 작은 글씨: 집계 시각 '10.09 14시 기준' (자세한 기준은 ⓘ 안내)
	$t_when = isset( $t_data['at'] ) ? preg_replace_callback( '/ (\d{1,2}):00$/', function ( $m ) {
		return ' ' . (int) $m[1] . '시';
	}, $t_data['at'] ) . ' 기준' : '최근 24시간';
	$chev   = eb_x_ic( 'chev', 'xs' );
	$count  = (int) wp_count_posts()->publish;
	$last     = get_posts( array( 'posts_per_page' => 1, 'orderby' => 'modified', 'fields' => 'ids', 'no_found_rows' => true ) );
	$last_upd = $last ? get_the_modified_date( 'm.d', $last[0] ) : '';
	$chk      = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/></svg>';
	$inf      = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></svg>';
	$n_calc  = count( eb_calc_catalog() ); // 계산기·기관 수는 목록에서 자동으로 셈 (2026-10-08)
	$n_links = eb_links_count();
	// 분류 배지 색: 글이 속한 4개 분야(복지·건강·금융·노동) 색 f0~f3 (추가 CSS, 2026-10-08)
	$fields = array( 215, 219, 223, 226 );
	$tag    = function ( $id ) use ( $fields ) {
		$f = '';
		foreach ( wp_get_post_categories( $id ) as $c ) {
			foreach ( $fields as $n => $r ) {
				if ( (int) $c === $r || cat_is_ancestor_of( $r, (int) $c ) ) {
					$f = ' f' . $n;
					break 2;
				}
			}
		}
		return '<span class="tg' . $f . '">' . esc_html( eb_short_cat( $id ) ) . '</span>';
	};
	// 배너: 검색창 안에서 인기 검색어 1~10위가 돌아가며 보임(data-roll, 아래 스크립트) - 배너 아래 '인기' 칩 줄 대신 (2026-10-09)
	$roll = wp_json_encode( array_values( array_map( function ( $x ) {
		return $x['q'];
	}, array_slice( $trend, 0, 10 ) ) ) );
	$pay  = '<div class="c-pay__h"><strong class="c-hx"><i class="c-hx__ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m7.5 8.5 1.8 7 2.7-5 2.7 5 1.8-7M7 12h10"/></svg></i>다가오는 지급일</strong>' . eb_x_info( '일정은 이렇게 계산해요', '', array( '지급일이 주말·공휴일이면 그 앞 평일로 계산해요', 'D-day는 보고 계신 기기의 날짜로 계산해요', '실제 지급일은 기관 사정에 따라 달라질 수 있어요. 담당 기관에서 꼭 확인해 주세요' ), false, '계산 기준' ) . '<a href="' . esc_url( home_url( '/schedule/' ) ) . '">복지 캘린더 ' . $chev . '</a></div>' . eb_x_pay_rows( 'c-pay__r', true ); // 10번: 제목 '다가오는 지급일'(아이콘) + 지급일만 3개 - 옆 설명 글자는 링크처럼 보여 뺌 (style.css 95번)
	// PC 배너 오른쪽 일정 카드 아래 빈칸 - 맞춤 찾기 바로가기 (휴대폰 일정 카드 .c-pay--m에는 넣지 않음, 2026-10-08)
	$cta  = '<a class="c-pay__cta" href="' . esc_url( home_url( '/find/#finder' ) ) . '"><span class="si">' . eb_x_ic( 'compass' ) . '</span><span class="st"><strong>내게 맞는 혜택 30초 찾기</strong><small>나이·상황만 고르면 골라 드려요</small></span>' . $chev . '</a>';
	// 홈 상단(2026-10-09 전면 개편): eb_hero_v3_html() - 예전 배너·휴대폰 지급일 카드(.c-pay--m) 대신
	$html = '<div id="ebc">' . eb_hero_v3_html( $trend, $roll );
	// 서비스 8개
	$svc = array( array( '/find/#finder', 'compass', '맞춤 찾기', '30초 혜택 찾기' ), array( '/schedule/', 'cal', '복지 캘린더', '지급일·신청 일정' ), array( '/calculator/', 'calc', '복지 계산기', $n_calc . '종 바로 계산' ), array( '/standards/', 'table', '2026 기준표', '중위소득·최저임금' ), array( '/forms/', 'doc', '공식 서식', '근로계약서 등 7종' ), array( '/nearby/', 'pin', '우리 동네 기관', '주민센터·보건소' ), array( '/glossary/', 'book', '복지 용어사전', '어려운 용어 쉽게' ), array( '/hotline/', 'phone', '긴급·상담 전화', '112·1366 등' ) );
	$html .= '<div class="w c-svc">';
	foreach ( $svc as $s ) {
		$html .= '<a href="' . esc_url( home_url( $s[0] ) ) . '"><span class="si">' . eb_x_ic( $s[1] ) . '</span><span class="st"><strong>' . $s[2] . '</strong><small>' . $s[3] . '</small></span></a>';
	}
	$html .= '</div>';
	// 새로 정리한 정보: 최근 수정한 글 4개를 대표 이미지 카드로 - 글자 목록뿐이던 홈에 시선이 머무는 곳 (style.css 80번, 2026-10-09)
	$cards = '';
	$n_cards = 0;
	foreach ( get_posts( array_merge( $base, array( 'posts_per_page' => 10, 'orderby' => 'modified' ) ) ) as $id ) {
		$n_cards++;
		$cards .= '<a class="c-card" href="' . esc_url( get_permalink( $id ) ) . '"><span class="c-card__img">' . ( has_post_thumbnail( $id ) ? get_the_post_thumbnail( $id, 'medium_large', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 767px) 72vw, 230px' ) ) : '' ) . '</span>' . $tag( $id ) . '<strong>' . esc_html( get_the_title( $id ) ) . '</strong><time datetime="' . esc_attr( get_the_modified_date( 'c', $id ) ) . '">' . esc_html( get_the_modified_date( 'm.d', $id ) ) . ' 업데이트</time></a>';
	}
	if ( $cards ) {
		// 10장을 옆으로 넘기기(PC 5장·태블릿 3장·휴대폰 1장씩 보임), ‹ › 버튼과 '1 / 8' (아래 홈 스크립트, style.css 81번)
		$arr   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="%s"/></svg>';
		$html .= '<div class="w"><section class="c-pan c-new"><div class="c-pan__h"><h2>새로 정리한 정보</h2>' . eb_x_info( '새로 정리한 정보는', '공식 자료를 다시 확인해 내용을 고친 날짜 순서예요.', array( '새로 쓴 글과 최근에 고친 글이 먼저 나와요', '옆으로 넘기면 ' . $n_cards . '개까지 볼 수 있어요' ), false, '업데이트 순' )
			. '<div class="c-new__nav"><span class="c-new__cnt" aria-hidden="true"><b>1</b> / ' . $n_cards . '</span><button type="button" class="c-new__prev" aria-label="이전 카드" disabled>' . sprintf( $arr, 'm15 6-6 6 6 6' ) . '</button><button type="button" class="c-new__next" aria-label="다음 카드">' . sprintf( $arr, 'm9 6 6 6-6 6' ) . '</button></div></div>'
			. '<div class="c-cards" tabindex="0" role="region" aria-label="새로 정리한 정보, 옆으로 넘겨 보기">' . $cards . '</div></section></div>';
	}
	// 많이 보는 정보(최근 30일 조회수) - '최신'은 위 사진 카드, '신청 중'은 아래 신청·마감 일정이 맡아서 탭 없앰 (2026-10-09)
	// 기간: 오늘·최근 7일(기본)·최근 30일, 각각 복지·지원금과 노동·민원 글을 먼저(기간 안에서는 조회수 순), 반려동물·여행 같은 나머지는 그 뒤 (2026-10-09)
	$roots = array_filter( array_map( function ( $s ) {
		$t = get_category_by_slug( $s );
		return $t ? (int) $t->term_id : 0;
	}, array( 'welfare', 'work' ) ) );
	$order = function ( $ids ) use ( $roots ) {
		$core = array();
		$rest = array();
		foreach ( $ids as $id ) {
			if ( 'post' !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) ) {
				continue;
			}
			$hit = false;
			foreach ( wp_get_post_categories( $id ) as $c ) {
				foreach ( $roots as $r ) {
					if ( (int) $c === $r || cat_is_ancestor_of( $r, (int) $c ) ) {
						$hit = true;
						break 2;
					}
				}
			}
			if ( $hit ) {
				$core[] = $id;
			} else {
				$rest[] = $id;
			}
		}
		return array_slice( array_merge( $core, $rest ), 0, 6 );
	};
	$sets = array(
		'd1'  => $order( eb_popular_ids_days( 1 ) ),
		'd7'  => $order( eb_popular_ids_days( 7 ) ),
		'd30' => $order( eb_popular_ids() ),
	);
	$popular = $sets['d30'];
	$latest  = get_posts( array_merge( $base, array( 'posts_per_page' => 6, 'orderby' => 'modified' ) ) );
	$r_row = function ( $ids ) use ( $tag ) {
		$out = '';
		foreach ( $ids as $i => $id ) {
			$out .= '<li><a href="' . esc_url( get_permalink( $id ) ) . '"><b class="n' . ( $i < 3 ? ' top' : '' ) . '">' . ( $i + 1 ) . '</b>' . $tag( $id ) . '<span class="t">' . esc_html( get_the_title( $id ) ) . '</span></a></li>';
		}
		return $out;
	};
	$r_pop = $r_row( $popular );
	$r_new = '';
	foreach ( $latest as $id ) {
		$r_new .= '<li><a href="' . esc_url( get_permalink( $id ) ) . '">' . $tag( $id ) . '<span class="t">' . esc_html( get_the_title( $id ) ) . '</span><time datetime="' . esc_attr( get_the_modified_date( 'c', $id ) ) . '">' . esc_html( get_the_modified_date( 'm.d', $id ) ) . '</time></a></li>';
	}
	$r_tr = '';
	foreach ( $trend as $x ) {
		$r_tr .= '<li><a href="' . esc_url( $x['h'] ) . '"><b class="n' . ( $x['n'] <= 3 ? ' top' : '' ) . '">' . $x['n'] . '</b><span class="t">' . esc_html( $x['q'] ) . '</span>' . $x['mv'] . '</a></li>';
	}
	// 광고 ①: 오른쪽 칸(휴대폰은 '많이 보는 정보' 아래) - 자동 크기면 300×600까지 커지므로 사각형으로 고정
	$ad1   = str_replace( array( 'data-ad-format="auto"', ' data-full-width-responsive="true"' ), array( 'data-ad-format="rectangle"', '' ), eb_ad_slot( 'home-mid', 'c-ad-slot' ) );
	$html .= '<div class="w c-grid c-grid--1"><section class="c-pan"><div class="c-pan__h"><h2>지금 많이 보는 정보</h2>' . eb_x_info( '많이 보는 정보는 이렇게 정해요', '고른 기간 동안 많이 읽힌 글 순서예요. 오늘은 1시간, 7일은 3시간, 30일은 6시간마다 다시 계산해요.', array( '복지·지원금, 노동·민원 글을 먼저 보여 드려요', '오늘 조회가 아직 적으면 최근 7일 기준으로 보여 드려요', '최근에 새로 정리한 글은 위 \'새로 정리한 정보\'에서 볼 수 있어요' ), false, '조회수 기준' )
		. '<div class="c-tab" role="tablist" aria-label="기간"><button type="button" role="tab" aria-selected="false" data-p="d1">오늘</button><button type="button" role="tab" aria-selected="true" data-p="d7">7일</button><button type="button" role="tab" aria-selected="false" data-p="d30">30일</button></div></div>'
		. '<ol class="c-rows" role="tabpanel" data-p="d1" hidden>' . ( count( $sets['d1'] ) >= 6 ? $r_row( $sets['d1'] ) : '<li class="c-rows__note">오늘은 아직 집계 중이에요. 최근 7일 기준으로 보여 드려요.</li>' . $r_row( $sets['d7'] ? $sets['d7'] : $popular ) ) . '</ol>'
		. '<ol class="c-rows" role="tabpanel" data-p="d7">' . ( $sets['d7'] ? $r_row( $sets['d7'] ) : ( $r_pop ? $r_pop : $r_new ) ) . '</ol>'
		. '<ol class="c-rows" role="tabpanel" data-p="d30" hidden>' . ( $r_pop ? $r_pop : $r_new ) . '</ol></section>'
		. '<section class="c-pan"><div class="c-pan__h"><h2>인기 검색어</h2>' . eb_x_info( '인기 검색어는 이렇게 정해요', '이지복지닷컴에서 검색된 단어를 1시간마다 모아 순위를 매겨요.', array( '최근 24시간 검색이 적을 땐 그동안 많이 찾은 검색어로 채워요' . ( $t_fill ? '(지금은 이 방식)' : '' ), '결과가 없는 검색어, 관리자·검색 로봇의 검색은 빼요', '▲▼는 직전 집계와 비교한 순위 변화, NEW는 새로 들어온 검색어예요' ), true, $t_when ) . '</div><ol class="c-trend">' . $r_tr . '</ol></section>'
		. '<aside class="c-rail">' . ( $ad1 ? '<div class="c-adpan"><p class="adl">광고</p>' . $ad1 . '</div>' : '' ) . '</aside></div>';
	// 계산기 · 가이드 · 신청 마감
	// 신청·마감 일정 + 자주 쓰는 계산기 + 상황별 가이드 (2026-10-09 개편, style.css 80번)
	// - 신청·마감: 넓은 칸(PC 2/3) - 기간·진행 막대·D-day(접수 중은 마감까지, 예정은 시작까지)·신청하는 곳(공식 사이트)·내 캘린더에 추가
	// - 계산기: 8개를 이름만 2칸으로(전체 16개는 '전체') / 상황별 가이드: 아래 한 줄 4칸
	$where    = array(
		'근로장려금' => array( '홈택스', 'https://www.hometax.go.kr/' ),
		'종소세'     => array( '홈택스', 'https://www.hometax.go.kr/' ),
		'부가세'     => array( '홈택스', 'https://www.hometax.go.kr/' ),
		'종부세'     => array( '홈택스', 'https://www.hometax.go.kr/' ),
		'자동차세'   => array( '위택스', 'https://www.wetax.go.kr/' ),
		'재산세'     => array( '위택스', 'https://www.wetax.go.kr/' ),
	);
	$cal_ic   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18M12 13v5M9.5 15.5h5"/></svg>';
	$all_dues = eb_x_dues( 5 );
	$n_open   = 0;
	$du       = '';
	foreach ( $all_dues as $x ) {
		$n_open += $x['open'] ? 1 : 0;
		$w       = ( isset( $x['k'] ) && isset( $where[ $x['k'] ] ) ) ? $where[ $x['k'] ] : null;
		$ymd     = str_replace( '-', '', $x['e'] );
		$gcal    = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . rawurlencode( $x['n'] . ' 마감' ) . '&dates=' . $ymd . '/' . gmdate( 'Ymd', strtotime( $x['e'] . ' +1 day' ) ) . '&details=' . rawurlencode( '이지복지닷컴 신청·마감 일정 ' . home_url( '/schedule/' ) . ' - 기간은 공고에 따라 바뀔 수 있으니 담당 기관에서 확인해 주세요.' );
		$dt_ymd  = $x['open'] || ! $x['s'] ? $x['e'] : $x['s']; // 휴대폰 날짜 칸: 접수 중은 마감일, 예정은 시작일 (style.css 124번, 2026-10-09)
		$du     .= '<li class="' . ( $x['open'] ? 'is-open' : 'is-soon' ) . '"><span class="c-due2__dt" aria-hidden="true"><small>' . (int) gmdate( 'n', strtotime( $dt_ymd ) ) . '월</small><b>' . (int) gmdate( 'j', strtotime( $dt_ymd ) ) . '</b></span><span class="tg' . ( $x['open'] ? ' on' : '' ) . '">' . ( $x['open'] ? '접수 중' : '예정' ) . '</span>'
			. '<span class="c-due2__m"><strong>' . esc_html( $x['n'] ) . '</strong><span class="c-due2__p">' . esc_html( ( $x['sl'] ? $x['sl'] . ' ~ ' : '~ ' ) . $x['el'] ) . '</span></span>'
			. '<span class="c-due2__bar" data-s="' . esc_attr( $x['s'] ) . '" data-e="' . esc_attr( $x['e'] ) . '" aria-hidden="true"><i></i>' . ( ! $x['open'] && $x['sl'] ? '<em>' . esc_html( $x['sl'] ) . ' 접수 시작</em>' : '' ) . '</span>' // 예정은 빈 막대 대신 시작일 (style.css 89번, 2026-10-09)
			. '<span class="c-due2__dd"><small>' . ( $x['open'] || ! $x['s'] ? '마감까지' : '시작까지' ) . '</small>' . eb_x_dday( $x['open'] || ! $x['s'] ? $x['e'] : $x['s'] ) . '</span>'
			. '<span class="c-due2__act">' . ( $w ? '<a href="' . esc_url( $w[1] ) . '" target="_blank" rel="noopener">' . esc_html( $w[0] ) . eb_x_ic( 'ext', 'xs ext' ) . '<span class="screen-reader-text">에서 신청·납부(새 창)</span></a>' : '' )
			. '<span class="c-info c-info--r c-cal"><button type="button" aria-expanded="false" aria-label="' . esc_attr( $x['n'] ) . ' 마감일 캘린더에 추가·공유">' . $cal_ic . '</button><span class="c-info__pop" role="menu" hidden><b>' . esc_html( $x['ej'] ) . ' 마감일</b>'
			. '<a role="menuitem" href="' . esc_url( $gcal ) . '" target="_blank" rel="noopener">구글 캘린더에 추가</a><button type="button" role="menuitem" data-ics="1" data-t="' . esc_attr( $x['n'] ) . '" data-d="' . esc_attr( $ymd ) . '">휴대폰·PC 캘린더 파일(.ics) 받기</button>'
			// 16번: 가족에게 공유(휴대폰은 기본 공유창 → 카카오톡·문자, PC는 문구 복사, 2026-10-09)
			. '<span class="c-cal__sep" role="separator"></span><button type="button" role="menuitem" data-share="' . esc_attr( '[이지복지닷컴] ' . $x['n'] . ' ' . ( $x['sl'] ? $x['sl'] . ' ~ ' : '~ ' ) . $x['el'] ) . '">가족에게 공유하기</button></span></span></span></li>';
	}
	$calc    = '';
	$catalog = eb_calc_catalog();
	foreach ( array( 'severance', 'unemployment', 'median', 'insurance', 'eitc', 'parental', 'pension', 'weekly' ) as $key ) {
		if ( empty( $catalog[ $key ] ) ) {
			continue;
		}
		$c     = $catalog[ $key ];
		$calc .= '<li><a href="' . esc_url( home_url( $c[0] ) ) . '" title="' . esc_attr( $c[2] ) . '"><span class="si sm">' . eb_x_ic( 'calc' ) . '</span><strong>' . esc_html( preg_replace( '/\s*(모의)?계산기$/u', '', $c[1] ) ) . '</strong><small>' . esc_html( $c[2] ) . '</small></a></li>'; // 한 줄 설명은 PC 목록형에서만 보임(eb-schedule board.css, 2026-10-10)
	}
	// 상황별 가이드 8개(2026-10-09 4개 추가: 생활이 어려울 때·청년·아플 때·이사) - PC 4칸×2줄, 휴대폰 2칸
	$guides = eb_guide_list(); // 상황별 가이드 8개 - 목록은 eb_guide_list() 한 곳에서
	$gd     = '';
	foreach ( $guides as $g ) {
		$gd .= '<li><a href="' . esc_url( home_url( $g[0] ) ) . '"><span class="si sm">' . eb_x_ic( $g[1] ) . '</span><span class="st"><strong>' . $g[2] . '</strong><small>' . $g[3] . '</small></span></a></li>';
	}
	// 신청·마감 칸: 복지 일정 플러그인이 켜져 있으면 새 보드(상태 탭·대상 칩·정부24 일정, 2026-10-10), 꺼지면 아래 기존 칸
	$html .= '<div class="w c-grid c-grid--b">' . ( function_exists( 'ebs_board_html' ) ? ebs_board_html() : '<section class="c-pan c-dues"><div class="c-pan__h"><h2 class="c-hx"><i class="c-hx__ic is-due"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/></svg></i>신청·납부 마감</h2>' . eb_x_info( '신청·마감 일정 안내', '', array( 'D-day는 보고 계신 기기의 날짜로 계산해요. 접수 중은 마감까지, 예정은 시작까지예요', '마감일이 주말·공휴일이면 다음 평일로 계산해요', '신청하는 곳 버튼은 공식 사이트(홈택스·위택스)로 연결돼요', '캘린더 버튼으로 마감일을 내 캘린더에 넣을 수 있어요', '기간은 공고에 따라 바뀔 수 있어요. 신청 전 담당 기관 공고를 꼭 확인해 주세요' ), true, '접수 중 ' . $n_open . ' · 예정 ' . ( count( $all_dues ) - $n_open ) ) . '<a class="more" href="' . esc_url( home_url( '/schedule/' ) ) . '">복지 캘린더 ' . $chev . '</a></div><ul class="c-due2">' . $du . '</ul></section>' )
		. '<section class="c-pan c-tools"><div class="c-pan__h"><h2>자주 쓰는 계산기</h2><a class="more" href="' . esc_url( home_url( '/calculator/' ) ) . '">' . $n_calc . '개 전체 ' . $chev . '</a></div><ul class="c-tool">' . $calc . '</ul></section></div>'
		. '<div class="w"><section class="c-pan c-guides"><div class="c-pan__h"><h2>상황별 가이드</h2><a class="more" href="' . esc_url( home_url( '/guide/' ) ) . '">전체 ' . $chev . '</a></div><ul class="c-calc c-calc--row">' . $gd . '</ul></section></div>';
	// 분야별 정보
	$tabs   = '';
	$boards = '';
	$cat_ic = array( 'm-care', 'm-pulse', 'm-card', 'm-brief' ); // 휴대폰 메뉴·PC 메가메뉴와 같은 분야 아이콘 (2026-10-08)
	foreach ( array( 215, 219, 223, 226 ) as $n => $cat_id ) {
		$term = get_term( $cat_id, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$ids  = get_posts( array_merge( $base, array( 'posts_per_page' => 5, 'orderby' => 'modified', 'cat' => $cat_id ) ) );
		$list = '';
		foreach ( $ids as $id ) {
			// 새 글(14일 안)에만 NEW + 수정일 (2026-10-08) - '업데이트' 표시는 한 글에만 튀어 보여 뺌, 오른쪽 날짜로 충분 (2026-10-09)
			$badge = '';
			if ( time() - (int) get_post_time( 'U', true, $id ) < 14 * DAY_IN_SECONDS ) {
				$badge = '<em class="nw">NEW</em>';
			}
			$list .= '<li><a href="' . esc_url( get_permalink( $id ) ) . '">' . $badge . esc_html( get_the_title( $id ) ) . '</a><time datetime="' . esc_attr( get_the_modified_date( 'c', $id ) ) . '">' . esc_html( get_the_modified_date( 'm.d', $id ) ) . '</time></li>';
		}
		$tabs   .= '<button type="button" role="tab" aria-selected="' . ( 0 === $n ? 'true' : 'false' ) . '" data-b="' . $n . '">' . esc_html( explode( '·', $term->name )[0] ) . '</button>';
		$boards .= '<section class="c-board' . ( 0 === $n ? ' on' : '' ) . '" data-b="' . $n . '"><a class="c-board__h" href="' . esc_url( get_category_link( $term ) ) . '"><span class="ci">' . eb_x_ic( $cat_ic[ $n ] ) . '</span><h3>' . esc_html( $term->name ) . '</h3><span class="more">전체 ' . $chev . '</span></a><ul>' . $list . '</ul></section>';
	}
	// 다른 칸처럼 제목을 흰 카드 안에: 카드 하나에 분야 4칸(PC)·탭(휴대폰) (style.css 75번, 2026-10-08)
	$html .= '<div class="w"><section class="c-pan c-fields"><div class="c-pan__h"><h2>분야별 정보</h2><div class="c-tab c-tab--m" role="tablist" aria-label="분야 고르기">' . $tabs . '</div></div><div class="c-boards">' . $boards . '</div></section></div>';
	// 광고 ②(분야별 정보 아래로 옮김 - 계산기·가이드 줄과 분야별 정보 사이 흐름이 끊기지 않게, 2026-10-08): 추천형(멀티플렉스)을 PC 1줄 4칸·휴대폰 3줄로 낮게 (26번 eb_ad_slot의 4,2줄 설정을 홈에서만 바꿈)
	$ad2 = str_replace( 'data-matched-content-rows-num="4,2"', 'data-matched-content-rows-num="3,1"', eb_ad_slot( 'home-bottom', 'c-ad-slot' ) );
	// PC(1080px~)는 멀티플렉스 대신 가로형 디스플레이 '홈-아래-PC' 1개 (2026-10-09, 구글이 멀티플렉스 줄 수 지정을 안 따라 PC에서 2×4로 커져서)
	// 두 광고를 다 그려 놓고 한쪽을 숨기면 애드센스 정책 위반 → <template>에 넣어 두고 화면 폭에 맞는 것 하나만 꺼내서 push (style.css 87번)
	if ( $ad2 && false !== strpos( $ad2, '<ins' ) ) {
		$ad2_m  = preg_replace( '#<script>\s*\(adsbygoogle[^<]*</script>#', '', $ad2 );
		$ad2_pc = '<div class="eb-ad c-ad-slot"><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3072640033981066" data-ad-slot="9911900569" data-ad-format="horizontal" data-full-width-responsive="false"></ins></div>';
		$ad2    = '<template data-m="m">' . $ad2_m . '</template><template data-m="pc">' . $ad2_pc . '</template>'
			. "<script nowprocket>(function(){var w=document.getElementById('c-ad-hb');if(!w){return;}var pc=window.matchMedia('(min-width:1080px)').matches,t=w.querySelector('template[data-m=\"'+(pc?'pc':'m')+'\"]');if(!t){return;}w.appendChild(t.content.cloneNode(true));w.parentNode.parentNode.classList.add(pc?'is-pc':'is-m');(window.adsbygoogle=window.adsbygoogle||[]).push({});})();</script>";
		$ad2    = '<div id="c-ad-hb">' . $ad2 . '</div>';
	}
	if ( $ad2 ) {
		$html .= '<div class="w c-adw c-adw--hb"><div class="c-adpan c-adpan--wide"><p class="adl">광고</p>' . $ad2 . '</div></div>'; // 광고도 다른 칸과 같은 흰 카드 틀 + '광고' 표시 (style.css 78번, 2026-10-08)
	}
	// 새 소식 · 기관
	$news = '';
	// 8개: 옆 공식 기관 2칸 목록(6줄, 두 줄씩)과 높이 맞춤(남는 높이는 줄 간격으로, style.css 82번), 휴대폰은 5개만 보임 (2026-10-09, 3→5개 style.css 85번)
	foreach ( array_slice( (array) eb_mohw_news(), 0, 8 ) as $it ) {
		$news .= '<li><a href="' . esc_url( $it['link'] ) . '" target="_blank" rel="noopener" title="보건복지부 누리집에서 원문 보기(새 창)"><span class="t">' . esc_html( preg_replace( '/(?<=\S)？(?=\S)/u', '·', $it['title'] ) ) . '</span>' . eb_x_ic( 'ext', 'xs ext' ) . '<span class="screen-reader-text">(보건복지부 누리집, 새 창)</span><time>' . esc_html( wp_date( 'm.d', (int) $it['date'] ) ) . '</time></a></li>';
	}
	$links = '';
	// 공식 기관 12곳(/links/ 목록에서 자주 찾는 곳) - 이름 + 하는 일 한 줄, 2칸 목록 (2026-10-09, 알약 칩 대신). 목록은 eb_org_list()
	foreach ( eb_org_list() as $l ) {
		$links .= '<li><a href="' . esc_url( $l[0] ) . '" target="_blank" rel="noopener"><strong>' . $l[1] . '</strong><small>' . $l[2] . '</small>' . eb_x_ic( 'ext', 'xs ext' ) . '<span class="screen-reader-text">(새 창)</span></a></li>';
	}
	// 생활 특가: 쿠팡 파트너스 주제 탭 4개(오늘의 특가 eb_cp_goldbox + 카테고리 베스트 eb_cp_best, 29번) × 최대 12개씩 옆으로 넘기기, '광고' 표시·쿠팡 파트너스 고지 (style.css 84번, 2026-10-09 개편 - 알리 칸은 뺌)
	// 애드센스 광고 칸과 헷갈리지 않게 콘텐츠 맨 끝에 두고, 링크는 모두 sponsored nofollow. 상품을 못 받은 탭은 빼고, 전부 못 받으면 칸 자체를 안 그림
	$deal_html = '';
	$deal_sets = array(
		array( '오늘의 특가', eb_cp_goldbox() ),
		array( '생활용품', eb_cp_best( 1014 ) ),
		array( '장보기', eb_cp_best( 1024 ) ), // 1024는 실제로 신선식품·생수 위주로 와서 '장보기'
		array( '주방용품', eb_cp_best( 1013 ) ),
		array( '출산·유아동', eb_cp_best( 1011 ) ),
		array( '가전디지털', eb_cp_best( 1016 ) ),
	);
	$deal_tabs = '';
	$deal_grid = '';
	$n_tab     = 0;
	$n_first   = 0;
	foreach ( $deal_sets as $set ) {
		$deal_li = '';
		$n_deal  = 0;
		foreach ( (array) $set[1] as $it ) {
			if ( $n_deal >= 12 ) {
				break;
			}
			if ( empty( $it['productUrl'] ) || empty( $it['productName'] ) ) {
				continue;
			}
			$n_deal++;
			$deal_li .= '<a class="c-deal__i" href="' . esc_url( $it['productUrl'] ) . '" target="_blank" rel="sponsored nofollow noopener"><span class="c-deal__img"><img src="' . esc_url( isset( $it['productImage'] ) ? $it['productImage'] : '' ) . '" alt="" loading="lazy" width="300" height="300"></span>'
				. ( ! empty( $it['isRocket'] ) ? '<span class="c-deal__tag">로켓배송</span>' : '' )
				. '<span class="c-deal__name">' . esc_html( $it['productName'] ) . '</span><span class="c-deal__price">' . ( ! empty( $it['discountRate'] ) ? '<em>' . (int) $it['discountRate'] . '%</em>' : '' ) . esc_html( number_format_i18n( (float) ( isset( $it['productPrice'] ) ? $it['productPrice'] : 0 ) ) ) . '원</span></a>';
		}
		if ( ! $deal_li ) {
			continue;
		}
		if ( ! $n_tab ) {
			$n_first = $n_deal;
		}
		$deal_tabs .= '<button type="button" role="tab" id="c-deal-t' . $n_tab . '" aria-controls="c-deal-p' . $n_tab . '" aria-selected="' . ( $n_tab ? 'false' : 'true' ) . '"' . ( $n_tab ? ' tabindex="-1"' : '' ) . '>' . esc_html( $set[0] ) . '</button>';
		$deal_grid .= '<div class="c-deal__grid" id="c-deal-p' . $n_tab . '" role="tabpanel" aria-labelledby="c-deal-t' . $n_tab . '" aria-label="' . esc_attr( $set[0] ) . ' 상품, 옆으로 넘겨 보기" tabindex="0"' . ( $n_tab ? ' hidden' : '' ) . '>' . $deal_li . '</div>';
		$n_tab++;
	}
	// 알리익스프레스 고정 칸(2026-10-09 시안): PC는 쿠팡 넘기기 오른쪽 세로 칸, 1079px 이하는 상품 아래 띠 (style.css 86번)
	// 쿠팡 탭과 섞지 않고 따로 둬서 어느 제휴인지 분명하게. 링크는 모두 알리 어필리에이트 제휴 링크(sponsored nofollow)
	$ali_main  = 'https://s.click.aliexpress.com/e/_c3iBrHkz';
	$ali_links = array(
		array( '알뜰마트', 'https://s.click.aliexpress.com/e/_c35uRZEv' ), // 500~1,500원 상품 모음(KR Bundle Deals)
		array( '생활·주방', 'https://s.click.aliexpress.com/e/_c32vUJQ1' ), // 카테고리 15 Home & Garden
		array( '전자기기', 'https://s.click.aliexpress.com/e/_c3xEhZpJ' ), // 카테고리 44 Consumer Electronics
	);
	// 링크는 알리 어필리에이트 > Link Generator(배송지 한국)에서 만든 것 (2026-10-09)
	$ali_rel   = ' target="_blank" rel="sponsored nofollow noopener"';
	$ali_li    = '';
	foreach ( $ali_links as $l ) {
		$ali_li .= '<li><a href="' . esc_url( $l[1] ) . '"' . $ali_rel . '>' . esc_html( $l[0] ) . eb_x_ic( 'chev', 'xs' ) . '</a></li>';
	}
	$ali_html = '<aside class="c-ali" aria-label="알리익스프레스 특가(제휴 링크)"><a class="c-ali__top" href="' . esc_url( $ali_main ) . '"' . $ali_rel . '><b>AliExpress</b><span>해외 직구 할인 모아 보기</span>' . eb_x_ic( 'chev', 'xs c-ali__chev' ) . '</a>'
		. '<ul class="c-ali__q">' . $ali_li . '</ul><a class="c-ali__go" href="' . esc_url( $ali_main ) . '"' . $ali_rel . '>알리 특가 보러 가기' . eb_x_ic( 'arrow', 'xs' ) . '</a></aside>';
	if ( $deal_grid ) {
		$arr2      = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="%s"/></svg>';
		$deal_html = '<div class="w"><section class="c-pan c-deal"><div class="c-pan__h"><h2>생활 특가</h2><span class="c-deal__ad">광고</span><small>쿠팡에서 매일 바뀌는 할인 상품</small>'
			. '<div class="c-new__nav"><a class="c-deal__more" href="https://link.coupang.com/a/htjIWXNfmS" target="_blank" rel="sponsored nofollow noopener">쿠팡 특가 더보기 ›</a><span class="c-new__cnt" aria-hidden="true"><b>1</b> / ' . $n_first . '</span><button type="button" class="c-new__prev" aria-label="이전 상품" disabled>' . sprintf( $arr2, 'm15 6-6 6 6 6' ) . '</button><button type="button" class="c-new__next" aria-label="다음 상품">' . sprintf( $arr2, 'm9 6 6 6-6 6' ) . '</button></div></div>'
			. ( $n_tab > 1 ? '<div class="c-deal__tabs" role="tablist" aria-label="생활 특가 주제">' . $deal_tabs . '</div>' : '' )
			. '<div class="c-deal__body"><div class="c-deal__main">' . $deal_grid . '</div>' . $ali_html . '</div>'
			. '<p class="c-deal__note"><span class="c-deal__nl"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 4.5 6v5.5c0 4.6 3.2 8.3 7.5 9.5 4.3-1.2 7.5-4.9 7.5-9.5V6z"/><path d="m9 12 2 2 4-4"/></svg>제휴 안내</span><span class="c-deal__nt"><b>이 영역은 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받습니다.</b> 알리익스프레스 링크도 제휴 링크이며, 가격·재고는 판매처 사정에 따라 바뀔 수 있어요. 구매 가격은 똑같아요.</span></p></section></div>'; // 고지 문구 알약 라벨 + 연한 상자 (style.css 88번, 2026-10-09)
	}
	$html .= '<div class="w c-grid c-grid--3"><section class="c-pan"><div class="c-pan__h"><h2>복지 정책 새 소식</h2>' . eb_x_info( '새 소식은 이렇게 가져와요', '보건복지부가 공식 제공하는 보도자료 목록에서 제목과 날짜만 3시간마다 가져와요.', array( '복지·지원 관련 소식을 먼저 보여 드려요', '제목을 누르면 보건복지부 누리집에서 원문이 새 창으로 열려요' ), false, '보건복지부 보도자료' ) . '<a class="more" href="https://www.mohw.go.kr/board.es?mid=a10503000000&amp;bid=0027" target="_blank" rel="noopener">보도자료 전체<span class="screen-reader-text">(새 창)</span> ' . $chev . '</a></div><ul class="c-news">' . $news . '</ul></section>'
		. '<section class="c-pan c-links"><div class="c-pan__h"><h2>공식 기관 바로가기</h2><a class="more" href="' . esc_url( home_url( '/links/' ) ) . '">' . $n_links . '곳 전체 ' . $chev . '</a></div><ul class="c-orgs">' . $links . '</ul></section></div>' . $deal_html . '</div>';
	// 홈 스크립트 (2026-10-09): 검색창 안 인기 검색어 돌리기·최근 본 글·신청 기간 진행 막대·캘린더 파일(.ics) 받기
	$html .= "<script nowprocket>\n" . <<<'JS'
(function () {
	var R = document.getElementById('ebc');
	if (!R) { return; }
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	// 검색창 안 인기 검색어: 3초마다 다음 순위, 비어 있는 채로 검색하면 지금 보이는 검색어로 검색
	var f = R.querySelector('.c-search[data-roll]'), inp = f && f.querySelector('input'), terms = [];
	try { terms = JSON.parse(f.getAttribute('data-roll') || '[]'); } catch (e) {}
	if (f && inp && terms.length) {
		var box = document.createElement('div'), sp, k = 0, cur = '', still = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		box.className = 'c-roll';
		box.setAttribute('aria-hidden', 'true');
		box.innerHTML = '<span></span>';
		f.appendChild(box);
		sp = box.firstChild;
		var ph = inp.getAttribute('placeholder') || '';
		inp.setAttribute('placeholder', '');
		var put = function () { cur = terms[k]; sp.innerHTML = '<b>' + (k + 1) + '</b><em>' + esc(cur) + '</em><small>검색해 보세요</small>'; k = (k + 1) % terms.length; };
		var next = function () {
			if (still || document.hidden) { put(); return; }
			sp.classList.add('out');
			setTimeout(function () { put(); sp.classList.remove('out'); sp.classList.add('in'); requestAnimationFrame(function () { requestAnimationFrame(function () { sp.classList.remove('in'); }); }); }, 300);
		};
		put();
		setInterval(next, 3000);
		var sync = function () { f.classList.toggle('is-typing', !!inp.value); };
		inp.addEventListener('input', sync);
		inp.addEventListener('focus', function () { inp.setAttribute('placeholder', ph); });
		inp.addEventListener('blur', function () { if (!inp.value) { inp.setAttribute('placeholder', ''); } });
		f.addEventListener('submit', function () { if (!inp.value.trim() && cur) { inp.value = cur; } });
		sync();
	}
	// 옆으로 넘기기(새로 정리한 정보·생활 특가) - ‹ › 버튼(한 화면씩), '1–5 / 10' 표시, 끝이 아니면 오른쪽 흐림(can-next), 키보드 ← →
	var car = function (nw, cs) {
		if (!nw || !cs) { return; }
		var cards = cs.children, prev = nw.querySelector('.c-new__prev'), nxt = nw.querySelector('.c-new__next'), cnt = nw.querySelector('.c-new__cnt b');
		var step = function () { return cards.length > 1 ? cards[1].offsetLeft - cards[0].offsetLeft : cs.clientWidth; };
		var per = function () { var st = getComputedStyle(cs); return Math.max(1, Math.floor((cs.clientWidth - parseFloat(st.paddingLeft) - parseFloat(st.paddingRight) + (parseFloat(st.columnGap) || 0)) / step() + 0.05)); };
		var upd = function () {
			var max = cs.scrollWidth - cs.clientWidth - 2, x = cs.scrollLeft, first = Math.min(cards.length, Math.round(x / step()) + 1), p = per();
			if (prev) { prev.disabled = x <= 2; }
			if (nxt) { nxt.disabled = x >= max; }
			nw.classList.toggle('can-next', x < max);
			if (cnt) { cnt.textContent = p > 1 ? first + '–' + Math.min(cards.length, first + p - 1) : first; }
		};
		var go = function (d) { cs.scrollBy({ left: d * per() * step(), behavior: 'smooth' }); };
		if (prev) { prev.addEventListener('click', function () { go(-1); }); }
		if (nxt) { nxt.addEventListener('click', function () { go(1); }); }
		cs.addEventListener('scroll', function () { window.requestAnimationFrame(upd); }, { passive: true });
		cs.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') { e.preventDefault(); go(1); } else if (e.key === 'ArrowLeft') { e.preventDefault(); go(-1); } });
		window.addEventListener('resize', upd);
		upd();
	};
	car(R.querySelector('.c-new'), R.querySelector('.c-new .c-cards'));
	// 생활 특가: 주제 탭(← → 키로도 이동) + 보이는 탭만 ‹ › 넘기기·'1–5 / 12' 표시, 탭을 바꾸면 처음으로 (2026-10-09)
	var dl = R.querySelector('.c-deal');
	if (dl) {
		var dg = [].slice.call(dl.querySelectorAll('.c-deal__grid')), dt = [].slice.call(dl.querySelectorAll('.c-deal__tabs [role="tab"]'));
		var dp = dl.querySelector('.c-new__prev'), dn = dl.querySelector('.c-new__next'), dc = dl.querySelector('.c-new__cnt');
		var dcur = function () { return dg.filter(function (g) { return !g.hidden; })[0] || dg[0]; };
		var dstep = function (g) { var c = g.children; return c.length > 1 ? c[1].offsetLeft - c[0].offsetLeft : g.clientWidth; };
		var dper = function (g) { var st = getComputedStyle(g); return Math.max(1, Math.floor((g.clientWidth - parseFloat(st.paddingLeft) - parseFloat(st.paddingRight) + (parseFloat(st.columnGap) || 0)) / dstep(g) + 0.05)); };
		var dupd = function () {
			var g = dcur();
			if (!g) { return; }
			var n = g.children.length, max = g.scrollWidth - g.clientWidth - 2, x = g.scrollLeft, first = Math.min(n, Math.round(x / dstep(g)) + 1), p = dper(g);
			if (dp) { dp.disabled = x <= 2; }
			if (dn) { dn.disabled = x >= max; }
			dl.classList.toggle('can-next', x < max);
			if (dc) { dc.innerHTML = '<b>' + (p > 1 ? first + '–' + Math.min(n, first + p - 1) : first) + '</b> / ' + n; }
		};
		var dgo = function (d) { var g = dcur(); if (g) { g.scrollBy({ left: d * dper(g) * dstep(g), behavior: 'smooth' }); } };
		if (dp) { dp.addEventListener('click', function () { dgo(-1); }); }
		if (dn) { dn.addEventListener('click', function () { dgo(1); }); }
		dg.forEach(function (g) {
			g.addEventListener('scroll', function () { window.requestAnimationFrame(dupd); }, { passive: true });
			g.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') { e.preventDefault(); dgo(1); } else if (e.key === 'ArrowLeft') { e.preventDefault(); dgo(-1); } });
		});
		var dsel = function (b, focus) {
			dt.forEach(function (x) { var on = x === b; x.setAttribute('aria-selected', on ? 'true' : 'false'); x.tabIndex = on ? 0 : -1; });
			dg.forEach(function (g) { g.hidden = g.id !== b.getAttribute('aria-controls'); if (!g.hidden) { g.scrollLeft = 0; } });
			if (focus) { b.focus(); }
			dupd();
		};
		dt.forEach(function (b, i) {
			b.addEventListener('click', function () { dsel(b); });
			b.addEventListener('keydown', function (e) {
				var k = e.key === 'ArrowRight' ? 1 : (e.key === 'ArrowLeft' ? -1 : 0);
				if (k) { e.preventDefault(); dsel(dt[(i + k + dt.length) % dt.length], true); }
			});
		});
		window.addEventListener('resize', dupd);
		dupd();
		// 상품 사진: 불러오는 동안 반짝임 → 다 뜨면(또는 실패해도) 서서히 보이게 (style.css 89번, 2026-10-09)
		dl.classList.add('js-ld');
		dl.querySelectorAll('.c-deal__img img').forEach(function (im) {
			var ok = function () { im.parentNode.classList.add('is-ld'); };
			if (im.complete && im.naturalWidth && (im.currentSrc || im.src).indexOf('data:') !== 0) { ok(); } else { im.addEventListener('load', function () { if ((im.currentSrc || im.src).indexOf('data:') !== 0) { ok(); } }); im.addEventListener('error', ok); } // 지연 로딩 자리표시(data:) 그림은 건너뜀
		});
	}
	// 최근 본 글(이 기기 브라우저 기록 eb_recent, 13번) - 기록이 있을 때만 검색창 아래 한 줄
	// 검색창 아래 다시 온 사람용 두 줄(2026-10-09 개편, style.css 96번): '내 맞춤'(맞춤 찾기에서 고른 조건 eb_finder_last) + '이어서 보기'(마지막으로 본 글 eb_recent) - 기록이 없으면 안 보임
	var rc = R.querySelector('.c-recent');
	if (rc) {
		var list = [], fdl = null, ch = '';
		try { list = JSON.parse(localStorage.getItem('eb_recent') || '[]') || []; } catch (e) {}
		try { fdl = JSON.parse(localStorage.getItem('eb_finder_last') || 'null'); } catch (e) {}
		list = list.filter(function (x) { return x && x.u && x.t; });
		if (fdl && fdl.l && fdl.l.length && fdl.n) {
			ch += '<a class="c-cont c-cont--fd" href="' + location.origin + '/find/#finder"><span class="c-cont__l"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m15.5 8.5-2 5-5 2 2-5z"/></svg>내 맞춤</span><span class="c-cont__t">'
				+ fdl.l.slice(0, 3).map(function (l) { return '<i>' + esc(l) + '</i>'; }).join('') + '관련 정보 ' + (+fdl.n) + '개</span><span class="c-cont__go">다시 보기<span aria-hidden="true"> ›</span></span></a>';
		}
		if (list.length) {
			ch += '<a class="c-cont" href="' + esc(list[0].u) + '"><span class="c-cont__l"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>이어서 보기</span><span class="c-cont__t">' + esc(list[0].t) + '</span><span class="c-cont__go" aria-hidden="true">›</span></a>';
		}
		if (ch) { rc.innerHTML = ch; rc.hidden = false; }
	}
	// 신청 기간 진행 막대: 방문자 기기 날짜 기준(시작~마감 중 지난 비율)
	var t0 = new Date(); t0.setHours(0, 0, 0, 0);
	R.querySelectorAll('.c-due2__bar').forEach(function (b) {
		var s = b.getAttribute('data-s'), e = b.getAttribute('data-e');
		if (!s || !e) { b.firstChild.style.width = '100%'; return; }
		var a = new Date(s + 'T00:00:00'), z = new Date(e + 'T00:00:00');
		b.firstChild.style.width = Math.round(Math.max(0, Math.min(1, (t0 - a) / Math.max(1, z - a))) * 100) + '%';
	});
	// 마감 일정 공유: 휴대폰은 기본 공유창, 안 되면 문구+링크 복사 (2026-10-09)
	R.addEventListener('click', function (ev) {
		var b = ev.target.closest('[data-share]');
		if (!b) { return; }
		ev.preventDefault();
		var txt = b.getAttribute('data-share'), url = location.origin + '/schedule/', all = txt + '\n' + url;
		if (!desk && navigator.share) { navigator.share({ title: txt, text: txt, url: url }).catch(function () {}); return; }
		var ok = function () { var o = b.textContent; b.textContent = '복사했어요 ✓'; setTimeout(function () { b.textContent = o; }, 1800); };
		var old = function () { // 클립보드 권한이 막힌 환경: 숨긴 입력칸으로 복사, 그것도 안 되면 문구를 보여 줘서 직접 복사
			var ta = document.createElement('textarea'); ta.value = all; ta.setAttribute('readonly', ''); ta.style.cssText = 'position:fixed;top:-99px;opacity:0'; document.body.appendChild(ta); ta.select();
			var done = false; try { done = document.execCommand('copy'); } catch (e) {}
			ta.remove(); if (done) { ok(); } else { window.prompt('아래 문구를 복사해 주세요 (Ctrl+C)', all); }
		};
		if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(all).then(ok, old); } else { old(); }
	});
	// PC(마우스 쓰는 큰 화면)에서는 공유창 대신 '안내 문구 복사하기' - 브라우저마다 공유창이 달라 헷갈려서 (2026-10-09)
	var desk = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine) and (min-width: 768px)').matches;
	if (desk) { R.querySelectorAll('[data-share]').forEach(function (b) { b.textContent = '안내 문구 복사하기'; }); }
	// 캘린더 파일(.ics): 마감일 하루 종일 일정 + 3일 전 알림
	R.addEventListener('click', function (ev) {
		var b = ev.target.closest('[data-ics]');
		if (!b) { return; }
		ev.preventDefault();
		var d = b.getAttribute('data-d'), n = b.getAttribute('data-t'), pad = function (v) { return (v < 10 ? '0' : '') + v; };
		var nx = new Date(+d.slice(0, 4), +d.slice(4, 6) - 1, +d.slice(6, 8) + 1);
		var ics = ['BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//easybokji.com//KO', 'CALSCALE:GREGORIAN', 'BEGIN:VEVENT',
			'UID:' + d + '-' + Math.random().toString(36).slice(2) + '@easybokji.com',
			'DTSTAMP:' + new Date().toISOString().replace(/[-:]/g, '').slice(0, 15) + 'Z',
			'DTSTART;VALUE=DATE:' + d, 'DTEND;VALUE=DATE:' + nx.getFullYear() + pad(nx.getMonth() + 1) + pad(nx.getDate()),
			'SUMMARY:' + n + ' 마감', 'DESCRIPTION:이지복지닷컴 신청·마감 일정. 기간은 공고에 따라 바뀔 수 있으니 담당 기관에서 확인해 주세요.',
			'BEGIN:VALARM', 'ACTION:DISPLAY', 'DESCRIPTION:' + n + ' 마감 3일 전', 'TRIGGER:-P3D', 'END:VALARM', 'END:VEVENT', 'END:VCALENDAR'].join('\r\n');
		var a = document.createElement('a');
		a.href = URL.createObjectURL(new Blob([ics], { type: 'text/calendar;charset=utf-8' }));
		a.download = n.replace(/[\\/:*?"<>|]/g, '') + ' 마감.ics';
		document.body.appendChild(a);
		a.click();
		setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 1000);
	});
})();
JS
		. "\n</script>\n";
	// ⓘ 안내 열고 닫기: 누르면 열림(다른 창은 닫힘), 바깥을 누르거나 Esc로 닫힘 (2026-10-09)
	$html .= "<script nowprocket>(function(){var R=document.getElementById('ebc');if(!R){return;}function closeAll(x){R.querySelectorAll('.c-info > button[aria-expanded=\"true\"]').forEach(function(b){if(b!==x){b.setAttribute('aria-expanded','false');b.nextElementSibling.hidden=true;}});}R.addEventListener('click',function(e){var b=e.target.closest('.c-info > button');if(!b){if(!e.target.closest('.c-info__pop')){closeAll();}return;}e.preventDefault();var open=b.getAttribute('aria-expanded')!=='true';closeAll(b);b.setAttribute('aria-expanded',String(open));b.nextElementSibling.hidden=!open;});document.addEventListener('click',function(e){if(!R.contains(e.target)){closeAll();}});document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeAll();}});})();</script>";
	// PC: 배너 검색창이 화면에 보이는 동안 헤더 검색창을 숨김(검색창 두 개가 겹쳐 보이지 않게), 배너를 지나면 다시 보임 (style.css 74번, 2026-10-08)
	$html .= "<script nowprocket>(function(){var s=document.querySelector('#ebc .c-search'),b=document.body;if(!s||!('IntersectionObserver' in window)){b.classList.remove('eb-hero-in');return;}new IntersectionObserver(function(e){b.classList.toggle('eb-hero-in',e[0].isIntersecting);},{rootMargin:'-60px 0px 0px 0px'}).observe(s);})();</script>";
	$GLOBALS['eb_home_used'] = true;
	return $html;
}
add_action( 'init', function () {
	remove_shortcode( 'eb_home' );
	add_shortcode( 'eb_home', 'eb_home_v2_html' );
}, 20 );

// 홈: 처음엔 배너 검색창이 보이므로 헤더 검색창을 숨긴 상태로 시작(위 스크립트가 스크롤에 따라 바꿈, 2026-10-08)
add_filter( 'body_class', function ( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'eb-hero-in';
	}
	return $classes;
} );

// 홈: 사이드바 없이 전체 폭, 예전 '홈 상단 소개'(Elements 14814)는 새 배너가 대신함
add_filter( 'generate_sidebar_layout', function ( $layout ) {
	return is_front_page() ? 'no-sidebar' : $layout;
} );
add_filter( 'generate_element_display', function ( $display, $element_id ) {
	return ( 14814 === (int) $element_id && is_front_page() ) ? false : $display;
}, 10, 2 );

// 관리자 막대 정리(관리자에게만 보임): 자주 쓰는 것만 남김
// 플러그인들이 늦게 붙이는 항목(Ad Health·검색 등)까지 빼려고 막대를 그리기 직전에 정리
add_action( 'wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	foreach ( array( 'wp-logo', 'customize', 'updates', 'comments', 'wp-statistic-menu', 'google-site-kit', 'gp_elements-menu', 'rank-math', 'advanced_ads_ad_health', 'search' ) as $id ) {
		$wp_admin_bar->remove_node( $id );
	}
}, 999 );

/* 49. PC 메가메뉴 키보드 이동 (48번 메뉴 스크립트 보충) ----------------------------------------------------
 * - 맨 위 메뉴에서 Tab·↓ → 열린 패널의 첫 링크로, 패널 마지막 링크에서 Tab → 다음 맨 위 메뉴(마지막이면 검색칸)
 * - 패널 첫 링크에서 Shift+Tab → 그 맨 위 메뉴로
 * - 포커스가 메뉴·패널 밖으로 나가면 패널 닫기(48번의 Esc 닫기를 그대로 씀)
 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var xh = document.getElementById('xh');
	if (!xh) { return; }
	var mx = xh.querySelector('.mx'), nav = xh.querySelector('.xh__nav');
	var tops = [].slice.call(xh.querySelectorAll('.xh__top'));
	var links = function (i) {
		var p = xh.querySelector('.mx-pane[data-i="' + i + '"]'), r = xh.querySelector('.mx-strip');
		return [].slice.call(p ? p.querySelectorAll('a') : []).concat([].slice.call(r ? r.querySelectorAll('a') : []));
	};
	var shut = function () { document.dispatchEvent(new KeyboardEvent('keydown', { key: 'Escape' })); };
	tops.forEach(function (a) {
		a.addEventListener('keydown', function (e) {
			if ((e.key === 'Tab' && !e.shiftKey) || e.key === 'ArrowDown') {
				var l = links(a.getAttribute('data-i'));
				if (l.length && !mx.hidden) { e.preventDefault(); l[0].focus(); }
			}
		});
	});
	mx.addEventListener('keydown', function (e) {
		if (e.key !== 'Tab') { return; }
		var cur = xh.querySelector('.xh__top[aria-expanded="true"]');
		if (!cur) { return; }
		var l = links(cur.getAttribute('data-i')), k = tops.indexOf(cur);
		if (!e.shiftKey && document.activeElement === l[l.length - 1]) {
			e.preventDefault();
			if (tops[k + 1]) { tops[k + 1].focus(); } else { shut(); var s = xh.querySelector('.xh__sf input'); if (s) { s.focus(); } }
		} else if (e.shiftKey && document.activeElement === l[0]) {
			e.preventDefault(); cur.focus();
		}
	});
	document.addEventListener('focusin', function (e) {
		if (!mx.hidden && !nav.contains(e.target) && !mx.contains(e.target)) { shut(); }
	});
	// 인기 검색어 한 줄 옆으로 밀기(2026-10-09) - 넘칠 때만 ‹ › 버튼·양 끝 흐림(can-prev·can-next), 마우스 휠 세로 → 가로(끝에선 페이지로 넘김)
	// 메뉴가 닫혀 있을 땐 폭이 0이라 ResizeObserver로 열릴 때 다시 계산
	var hw = xh.querySelector('.m-hotw'), ht = hw && hw.querySelector('.m-hot');
	if (ht) {
		var hupd = function () {
			var max = ht.scrollWidth - ht.clientWidth - 1, x = ht.scrollLeft;
			hw.classList.toggle('can-prev', x > 1);
			hw.classList.toggle('can-next', x < max);
		};
		var hgo = function (d) { ht.scrollBy({ left: d * Math.max(160, ht.clientWidth * 0.7), behavior: 'smooth' }); };
		hw.querySelector('.m-hot__prev').addEventListener('click', function () { hgo(-1); });
		hw.querySelector('.m-hot__next').addEventListener('click', function () { hgo(1); });
		ht.addEventListener('scroll', function () { window.requestAnimationFrame(hupd); }, { passive: true });
		ht.addEventListener('wheel', function (e) {
			var max = ht.scrollWidth - ht.clientWidth - 1;
			if (Math.abs(e.deltaY) <= Math.abs(e.deltaX) || max <= 0 || (e.deltaY > 0 && ht.scrollLeft >= max) || (e.deltaY < 0 && ht.scrollLeft <= 1)) { return; }
			e.preventDefault();
			ht.scrollLeft += e.deltaY;
		}, { passive: false });
		if (window.ResizeObserver) { new ResizeObserver(hupd).observe(ht); }
		window.addEventListener('resize', hupd);
		hupd();
	}
})();
JS
	. "\n</script>\n";
}, 67 );

/* 50. 메가메뉴 미니 달력 (48번 복지 캘린더 패널) ------------------------------------------------------
 * 캐시된 페이지에서도 맞도록 방문자 날짜로 이번 달을 그리고, data-pay의 지급일(전달~다다음 달)에 점 표시
 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var pad = function (v) { return (v < 10 ? '0' : '') + v; };
	document.querySelectorAll('.m-cal').forEach(function (c) {
		var n = new Date(), y = n.getFullYear(), m = n.getMonth(), t = n.getDate();
		var pay = (c.getAttribute('data-pay') || '').split(','), hol = (c.getAttribute('data-hol') || '').split(','), due = (c.getAttribute('data-due') || '').split(',');
		var first = new Date(y, m, 1).getDay(), last = new Date(y, m + 1, 0).getDate(), h = '';
		c.querySelector('.m-cal__m').textContent = (m + 1) + '월';
		for (var i = 0; i < first; i++) { h += '<span></span>'; }
		for (var d = 1; d <= last; d++) {
			var key = y + '-' + pad(m + 1) + '-' + pad(d), cls = [], isPay = pay.indexOf(key) > -1, isDue = d >= t && due.indexOf(key) > -1;
			if ((first + d - 1) % 7 === 0) { cls.push('sun'); }
			if (d < t) { cls.push('past'); }
			if (hol.indexOf(key) > -1) { cls.push('hol'); }
			if (isPay) { cls.push('pay'); }
			if (isDue) { cls.push('due'); } // 신청 시작·마감 일정(eb-schedule, 2026-10-10) - 누르면 복지 캘린더 그날로
			if (d === t) { cls = ['today'].concat(isPay ? ['pay'] : [], isDue ? ['due'] : []); } // 오늘이 지급일이어도 점을 남김
			// 지급일은 복지 캘린더의 그날 위치로 연결
			h += (isPay || isDue) ? '<a class="' + cls.join(' ') + '" href="/schedule/#d-' + key + '" title="' + (m + 1) + '월 ' + d + '일 ' + (isPay ? '지급일' : '신청 일정') + '">' + d + '</a>' : '<span class="' + cls.join(' ') + '">' + d + '</span>';
		}
		c.querySelector('.m-days').innerHTML = h;
	});
})();
JS
	. "\n</script>\n";
}, 68 );

/* 51. 사이트 전체 글자 크기 (2026-10-09, style.css 92번) -------------------------------------------------
 * 글 도구(19-1)의 '가 / 가+ / 가++'와 같은 설정(localStorage eb_fs, html[data-eb-fs])을 PC 헤더 '가' 버튼·휴대폰 옆 메뉴에서도 바꿈
 * 홈·목록은 내용 영역을 1.1배·1.2배(zoom), 글 본문은 19-1 그대로(본문 글자만) - 두 번 커지지 않게 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var H = document.documentElement;
	var cur = function () { return H.getAttribute('data-eb-fs') || '1'; };
	var paint = function () {
		var n = cur();
		document.querySelectorAll('[data-fs]').forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-fs') === n ? 'true' : 'false'); });
	};
	var set = function (n) {
		n = String(n);
		if (n === '1') { H.removeAttribute('data-eb-fs'); } else { H.setAttribute('data-eb-fs', n); }
		try { localStorage.setItem('eb_fs', n); } catch (e) {}
		paint();
	};
	// PC 헤더 '가' 버튼 → 작은 창
	var fb = document.querySelector('.xh__fsb'), fp = document.querySelector('.xh__fsp');
	if (fb && fp) {
		var close = function () { fp.hidden = true; fb.setAttribute('aria-expanded', 'false'); };
		fb.addEventListener('click', function () { var o = fp.hidden; fp.hidden = !o; fb.setAttribute('aria-expanded', o ? 'true' : 'false'); if (o) { paint(); } });
		document.addEventListener('click', function (e) { if (!fp.hidden && !e.target.closest('.xh__fs')) { close(); } });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !fp.hidden) { close(); fb.focus(); } });
	}
	// 헤더·옆 메뉴 버튼 (글 도구 버튼은 19-1이 처리하고, 아래 감시로 표시만 맞춤)
	document.addEventListener('click', function (e) {
		var b = e.target.closest && e.target.closest('.eb-fsseg [data-fs]');
		if (b) { set(b.getAttribute('data-fs')); }
	});
	if (window.MutationObserver) { new MutationObserver(paint).observe(H, { attributes: true, attributeFilter: ['data-eb-fs'] }); }
	paint();
})();
JS
	. "\n</script>\n";
}, 99 );

/* 52. 휴대폰 '홈 화면에 추가' 안내 (2026-10-09, style.css 96번) ---------------------------------------------
 * 두 번째 방문부터 한 번: 안드로이드 크롬은 설치 창(beforeinstallprompt), 아이폰 사파리는 '공유 → 홈 화면에 추가' 방법 안내
 * 이미 설치해 연 경우·닫은 뒤 30일·PC에서는 안 보임. 앱 정보 파일(/manifest.webmanifest)은 이미 있음 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	if (!window.matchMedia || !window.matchMedia('(max-width: 767px)').matches) { return; }
	if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) { return; }
	var ls = function (k, v) { try { if (v === undefined) { return localStorage.getItem(k); } localStorage.setItem(k, v); } catch (e) { return null; } };
	try { if (!sessionStorage.getItem('eb_vs')) { sessionStorage.setItem('eb_vs', '1'); ls('eb_visits', String((+ls('eb_visits') || 0) + 1)); } } catch (e) {}
	if ((+ls('eb_visits') || 0) < 2) { return; }
	if (Date.now() - (+ls('eb_a2hs_off') || 0) < 30 * 864e5) { return; }
	var ios = /iphone|ipad|ipod/i.test(navigator.userAgent) && /safari/i.test(navigator.userAgent) && !/crios|fxios|edgios|kakaotalk|naver|instagram|fban/i.test(navigator.userAgent);
	var deferred = null, shown = false;
	var show = function (mode) {
		if (shown) { return; }
		shown = true;
		var el = document.createElement('div');
		el.className = 'eb-a2hs';
		el.setAttribute('role', 'dialog');
		el.setAttribute('aria-label', '홈 화면에 추가 안내');
		el.innerHTML = '<span class="eb-a2hs__ic"><img src="' + (document.querySelector('link[rel="apple-touch-icon"]') || {}).href + '" alt="" width="36" height="36"></span>'
			+ '<p><b>홈 화면에 추가할까요?</b>' + (mode === 'ios' ? '아래 <span class="eb-a2hs__sh" aria-label="공유">공유</span> 버튼 → \'홈 화면에 추가\'' : '앱처럼 바로 열려요') + '</p>'
			+ (mode === 'ios' ? '' : '<button type="button" class="eb-a2hs__add">추가</button>')
			+ '<button type="button" class="eb-a2hs__x" aria-label="닫기"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>';
		document.body.appendChild(el);
		var off = function () { ls('eb_a2hs_off', String(Date.now())); el.classList.add('is-out'); setTimeout(function () { el.remove(); }, 250); };
		el.querySelector('.eb-a2hs__x').addEventListener('click', off);
		var add = el.querySelector('.eb-a2hs__add');
		if (add) { add.addEventListener('click', function () { if (deferred) { deferred.prompt(); deferred.userChoice.then(off, off); deferred = null; } else { off(); } }); }
	};
	window.addEventListener('beforeinstallprompt', function (e) { e.preventDefault(); deferred = e; setTimeout(function () { show('android'); }, 2500); });
	window.addEventListener('appinstalled', function () { ls('eb_a2hs_off', String(Date.now() + 3650 * 864e5)); var el = document.querySelector('.eb-a2hs'); if (el) { el.remove(); } });
	if (ios) { setTimeout(function () { show('ios'); }, 2500); }
})();
JS
	. "\n</script>\n";
}, 99 );

/* 53. 맞춤 찾기용 전용 태그 3종 (2026-10-09) ---------------------------------------------------------------
 * 복지로 '서비스 찾기'·공공데이터포털 복지서비스 API와 같은 분류: 생애주기(eb_life) · 가구 상황(eb_hh) · 관심 주제(eb_theme)
 * 일반 태그와 달리 정해진 목록만 고르고, 태그별 공개 목록 페이지는 만들지 않음(빈약한 페이지 방지). 글 편집 화면 오른쪽에서 체크
 * 관심 주제 중 교통·자동차/반려동물/사업·창업/생활 정보는 이 사이트 전용(복지로에는 없음) */
function eb_tax_terms() {
	return array(
		'eb_life'  => array( '생애주기', array( 'pregnancy' => '임신·출산', 'infant' => '영유아', 'child' => '아동', 'teen' => '청소년', 'youth' => '청년', 'middle' => '중장년', 'senior' => '노년' ) ),
		'eb_hh'    => array( '가구 상황', array( 'low' => '저소득', 'disabled' => '장애인', 'single' => '한부모·조손', 'multi' => '다자녀', 'multicultural' => '다문화·탈북민', 'veteran' => '보훈대상자' ) ),
		'eb_theme' => array( '관심 주제', array( 'health' => '신체건강', 'mental' => '정신건강', 'living' => '생활지원', 'housing' => '주거', 'job' => '일자리', 'culture' => '문화·여가', 'safety' => '안전·위기', 'birth' => '임신·출산', 'childcare' => '보육', 'edu' => '교육', 'adopt' => '입양·위탁', 'care' => '보호·돌봄', 'finance' => '서민금융', 'law' => '법률', 'car' => '교통·자동차', 'pet' => '반려동물', 'biz' => '사업·창업', 'tips' => '생활 정보' ) ),
	);
}
add_action( 'init', function () {
	foreach ( eb_tax_terms() as $tax => $d ) {
		register_taxonomy( $tax, 'post', array(
			'label'              => $d[0],
			'hierarchical'       => true, // 편집 화면에서 체크 상자로
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'show_admin_column'  => true,
			'show_tagcloud'      => false,
			'rewrite'            => false,
		) );
	}
}, 5 );
// 처음 한 번: 용어 만들기 + 글 59개에 초안 붙이기(wp_set_object_terms라 글 수정 날짜는 안 바뀜). 다시 하려면 옵션 eb_tax_seed_v1 삭제
add_action( 'admin_init', function () {
	if ( get_option( 'eb_tax_seed_v1' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	foreach ( eb_tax_terms() as $tax => $d ) {
		foreach ( $d[1] as $slug => $name ) {
			if ( ! term_exists( $slug, $tax ) ) {
				wp_insert_term( $name, $tax, array( 'slug' => $slug ) );
			}
		}
	}
	$map = array(
		923 => array( array( 'middle' ), array(  ), array( 'job' ) ),
		1056 => array( array( 'middle' ), array(  ), array( 'job' ) ),
		1193 => array( array(  ), array( 'low' ), array( 'living' ) ),
		1276 => array( array(  ), array( 'low' ), array( 'pet' ) ),
		1431 => array( array(  ), array( 'low' ), array( 'pet' ) ),
		1547 => array( array(  ), array(  ), array( 'pet' ) ),
		1814 => array( array(  ), array(  ), array( 'pet' ) ),
		1979 => array( array(  ), array(  ), array( 'pet' ) ),
		2196 => array( array( 'youth' ), array(  ), array( 'job', 'finance' ) ),
		2204 => array( array( 'youth' ), array(  ), array( 'job', 'living' ) ),
		2336 => array( array( 'youth' ), array(  ), array( 'finance' ) ),
		2405 => array( array( 'youth' ), array(  ), array( 'biz', 'finance' ) ),
		2620 => array( array( 'youth', 'pregnancy' ), array(  ), array( 'birth' ) ),
		2805 => array( array(  ), array( 'low' ), array( 'finance', 'living' ) ),
		2930 => array( array( 'child', 'teen' ), array( 'low' ), array( 'finance', 'living' ) ),
		3144 => array( array(  ), array(  ), array( 'tips' ) ),
		3253 => array( array( 'middle' ), array(  ), array( 'health' ) ),
		3342 => array( array( 'child', 'teen' ), array(  ), array( 'tips' ) ),
		3371 => array( array( 'senior' ), array( 'disabled' ), array( 'safety' ) ),
		3437 => array( array( 'senior' ), array( 'disabled' ), array( 'safety', 'care' ) ),
		3542 => array( array( 'senior' ), array(  ), array( 'health' ) ),
		3605 => array( array(  ), array( 'low', 'multi', 'disabled' ), array( 'housing' ) ),
		3722 => array( array( 'senior' ), array(  ), array( 'health' ) ),
		3933 => array( array( 'senior' ), array(  ), array( 'health' ) ),
		4040 => array( array(  ), array(  ), array( 'tips' ) ),
		4807 => array( array( 'youth', 'middle' ), array(  ), array( 'edu', 'job' ) ),
		4972 => array( array( 'middle' ), array(  ), array( 'edu', 'job' ) ),
		5215 => array( array( 'middle' ), array(  ), array( 'edu', 'car' ) ),
		5226 => array( array( 'middle' ), array(  ), array( 'edu', 'job' ) ),
		5393 => array( array( 'middle' ), array(  ), array( 'job' ) ),
		5478 => array( array( 'middle' ), array(  ), array( 'edu', 'job' ) ),
		5714 => array( array( 'senior' ), array(  ), array( 'car', 'edu' ) ),
		6545 => array( array( 'senior' ), array(  ), array( 'car', 'living' ) ),
		6583 => array( array(  ), array(  ), array( 'car' ) ),
		6641 => array( array(  ), array(  ), array( 'car' ) ),
		6721 => array( array(  ), array(  ), array( 'pet' ) ),
		6944 => array( array( 'middle' ), array(  ), array( 'biz' ) ),
		7100 => array( array(  ), array(  ), array( 'finance' ) ),
		7232 => array( array( 'youth' ), array(  ), array( 'finance' ) ),
		7388 => array( array(  ), array(  ), array( 'car' ) ),
		7721 => array( array( 'youth' ), array(  ), array( 'job', 'law' ) ),
		8108 => array( array( 'youth' ), array(  ), array( 'job', 'law' ) ),
		8185 => array( array( 'youth', 'middle' ), array(  ), array( 'job', 'law' ) ),
		8194 => array( array( 'youth', 'middle' ), array(  ), array( 'job', 'law' ) ),
		8406 => array( array( 'middle' ), array(  ), array( 'job' ) ),
		8513 => array( array( 'youth' ), array( 'low' ), array( 'finance' ) ),
		8540 => array( array( 'middle' ), array(  ), array( 'biz', 'living' ) ),
		8678 => array( array(  ), array(  ), array( 'tips' ) ),
		8770 => array( array(  ), array(  ), array( 'tips' ) ),
		8780 => array( array(  ), array(  ), array( 'car' ) ),
		8785 => array( array(  ), array(  ), array( 'tips' ) ),
		10656 => array( array( 'middle' ), array(  ), array( 'biz' ) ),
		11178 => array( array( 'youth', 'middle' ), array(  ), array( 'job', 'law' ) ),
		11359 => array( array(  ), array(  ), array( 'health' ) ),
		11363 => array( array(  ), array(  ), array( 'tips' ) ),
		11367 => array( array(  ), array(  ), array( 'car' ) ),
		11687 => array( array(  ), array(  ), array( 'health' ) ),
		11696 => array( array( 'senior' ), array( 'low' ), array( 'living' ) ),
	);
	$n = 0;
	foreach ( $map as $id => $v ) {
		if ( 'post' !== get_post_type( $id ) ) {
			continue;
		}
		wp_set_object_terms( $id, $v[0], 'eb_life' );
		wp_set_object_terms( $id, $v[1], 'eb_hh' );
		wp_set_object_terms( $id, $v[2], 'eb_theme' );
		$n++;
	}
	update_option( 'eb_tax_seed_v1', $n, false );
} );

/* 53-2. 대상 지역 태그 eb_region (2026-10-09, 개선안 3번) ------------------------------------------------------------
 * 특정 시·도 주민만 받을 수 있는 글에만 체크(전국 대상이면 비워 둠). 이름은 복지로 지역 데이터(56번 sd)와 같은 정식 이름
 * 맞춤 찾기(55번)·빠른 찾기(59번): 사는 곳을 골랐으면 다른 지역 글은 빼고 같은 지역 글은 앞으로, 안 골랐으면 'OO 한정' 표시 + 뒤로
 * 태그가 없으면 제목의 시·도 이름으로 보조 판단(eb_region_guess). 알림판 '글' 칸에 '지역 태그 확인' 경고 */
function eb_region_names() {
	return array( '서울특별시' => '서울', '부산광역시' => '부산', '대구광역시' => '대구', '인천광역시' => '인천', '광주광역시' => '광주', '대전광역시' => '대전', '울산광역시' => '울산', '세종특별자치시' => '세종', '경기도' => '경기', '강원특별자치도' => '강원', '충청북도' => '충북', '충청남도' => '충남', '전북특별자치도' => '전북', '전라남도' => '전남', '경상북도' => '경북', '경상남도' => '경남', '제주특별자치도' => '제주' );
}
// 제목 → 정식 시·도 이름(없으면 ''). '서울대'·'대전사랑'처럼 붙은 말은 지역으로 보지 않음(태그로 지정)
function eb_region_guess( $title ) {
	$alias = array( '서울' => '서울특별시', '부산' => '부산광역시', '대구' => '대구광역시', '인천' => '인천광역시', '광주' => '광주광역시', '대전' => '대전광역시', '울산' => '울산광역시', '세종' => '세종특별자치시', '경기도' => '경기도', '강원' => '강원특별자치도', '충북' => '충청북도', '충청북도' => '충청북도', '충남' => '충청남도', '충청남도' => '충청남도', '전북' => '전북특별자치도', '전라북도' => '전북특별자치도', '전남' => '전라남도', '전라남도' => '전라남도', '경북' => '경상북도', '경상북도' => '경상북도', '경남' => '경상남도', '경상남도' => '경상남도', '제주' => '제주특별자치도' );
	if ( preg_match( '/(?<![가-힣])(' . implode( '|', array_keys( $alias ) ) . ')(?:특별자치시|특별자치도|특별시|광역시|시|도)?(?![가-힣])/u', (string) $title, $m ) ) {
		return $alias[ $m[1] ];
	}
	return '';
}
// 글의 대상 지역(정식 이름 배열). 태그 우선, 없으면 제목으로
function eb_post_regions( $id ) {
	$t = get_the_terms( $id, 'eb_region' );
	if ( $t && ! is_wp_error( $t ) ) {
		return array_values( wp_list_pluck( $t, 'name' ) );
	}
	$g = eb_region_guess( html_entity_decode( get_the_title( $id ), ENT_QUOTES, 'UTF-8' ) );
	return $g ? array( $g ) : array();
}
add_action( 'init', function () {
	register_taxonomy( 'eb_region', 'post', array(
		'label'              => '대상 지역',
		'description'        => '특정 시·도 주민만 받을 수 있는 글에만 체크하세요. 전국 대상이면 비워 둡니다.',
		'hierarchical'       => true,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'show_admin_column'  => true,
		'show_tagcloud'      => false,
		'rewrite'            => false,
	) );
}, 5 );
// 처음 한 번: 시·도 17개 만들기 + 지역 글 5개에 붙이기(글 수정 날짜는 안 바뀜). 다시 하려면 옵션 eb_region_seed_v1 삭제
add_action( 'admin_init', function () {
	if ( get_option( 'eb_region_seed_v1' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	foreach ( array_keys( eb_region_names() ) as $name ) {
		if ( ! term_exists( $name, 'eb_region' ) ) {
			wp_insert_term( $name, 'eb_region' );
		}
	}
	$n = 0;
	foreach ( array( 2204 => '대전광역시', 3144 => '대전광역시', 2620 => '서울특별시', 1276 => '서울특별시', 1431 => '경기도' ) as $id => $name ) {
		$term = get_term_by( 'name', $name, 'eb_region' );
		if ( $term && 'post' === get_post_type( $id ) ) {
			wp_set_object_terms( $id, array( (int) $term->term_id ), 'eb_region' );
			$n++;
		}
	}
	delete_transient( 'eb_f2_posts' );
	update_option( 'eb_region_seed_v1', $n, false );
} );

/* 54. 복지서비스 API 연결 - 설정 > 복지서비스 API (2026-10-09) ------------------------------------------------
 * 공공데이터포털 '한국사회보장정보원_중앙부처복지서비스'(복지로 정부 복지서비스 목록). 인증키는 사용자가 직접 입력(화면에 다시 표시 안 함)
 * 맞춤 찾기에서 쓸 목록은 하루 1회 받아 저장할 예정(개발 계정 하루 100회 한도). 출처 표시: 한국사회보장정보원(복지로) */
function eb_ws_key() {
	return (string) get_option( 'eb_ws_key', '' );
}
// 목록 조회 한 번: 성공하면 array( 'total' => n, 'items' => array( array( 'id','name','org','sum','link' ) ) ), 실패하면 WP_Error
function eb_ws_list( $page = 1, $rows = 10 ) {
	$key = eb_ws_key();
	if ( ! $key ) {
		return new WP_Error( 'eb_ws_nokey', '인증키가 없습니다.' );
	}
	$url = 'https://apis.data.go.kr/B554287/NationalWelfareInformationsV001/NationalWelfarelistV001?serviceKey=' . rawurlencode( $key )
		. '&callTp=L&pageNo=' . (int) $page . '&numOfRows=' . (int) $rows . '&srchKeyCode=003';
	$res = wp_remote_get( $url, array( 'timeout' => 15 ) );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$body = (string) wp_remote_retrieve_body( $res );
	$code = (int) wp_remote_retrieve_response_code( $res );
	$prev = libxml_use_internal_errors( true );
	$xml  = simplexml_load_string( $body );
	libxml_use_internal_errors( $prev );
	if ( ! $xml ) {
		return new WP_Error( 'eb_ws_bad', 'HTTP ' . $code . ' · 응답을 읽지 못했습니다: ' . wp_strip_all_tags( mb_substr( $body, 0, 160 ) ) );
	}
	$pick = function ( $q ) use ( $xml ) {
		$r = $xml->xpath( $q );
		return $r ? trim( (string) $r[0] ) : '';
	};
	$rc  = $pick( '//resultCode|//returnReasonCode' );
	$msg = $pick( '//resultMessage|//resultMsg|//returnAuthMsg|//errMsg' );
	if ( '' !== $rc && '0' !== $rc && '00' !== $rc ) {
		return new WP_Error( 'eb_ws_api', '결과 코드 ' . $rc . ' · ' . $msg );
	}
	$items = array();
	foreach ( $xml->xpath( '//servList' ) ?: array() as $s ) {
		$items[] = array(
			'id'   => (string) $s->servId,
			'name' => (string) $s->servNm,
			'org'  => (string) $s->jurMnofNm,
			'sum'  => (string) $s->servDgst,
			'link' => (string) $s->servDtlLink,
			'life' => (string) $s->lifeArray,
			'hh'   => (string) $s->trgterIndvdlArray,
			'them' => (string) $s->intrsThemaArray,
		);
	}
	return array( 'total' => (int) $pick( '//totalCount' ), 'items' => $items );
}

// 전체 목록 받기(500개씩) → 옵션 eb_ws_all에 저장. 하루 1회(wp-cron) + 설정 화면 '지금 받기'. 실패하면 이전 목록 유지
function eb_ws_sync() {
	$all  = array();
	$page = 1;
	do {
		$d = eb_ws_list( $page, 500 );
		if ( is_wp_error( $d ) ) {
			update_option( 'eb_ws_sync_err', $d->get_error_message(), false );
			return $d;
		}
		$all = array_merge( $all, $d['items'] );
		$page++;
	} while ( $d['items'] && count( $all ) < $d['total'] && $page <= 5 );
	if ( $all ) {
		// 새로 생긴 서비스 기록(어제 목록에 없던 servId → 처음 본 시각, 7일 지나면 지움) - 홈 '오늘의 한 줄'(2026-10-09 개선안 2번)
		$old = array_flip( array_filter( wp_list_pluck( (array) get_option( 'eb_ws_all', array() ), 'id' ) ) );
		if ( $old ) {
			$new = (array) get_option( 'eb_ws_new', array() );
			$now = array_flip( array_filter( wp_list_pluck( $all, 'id' ) ) );
			foreach ( $all as $s ) {
				if ( ! empty( $s['id'] ) && ! isset( $old[ $s['id'] ] ) && ! isset( $new[ $s['id'] ] ) ) {
					$new[ $s['id'] ] = time();
				}
			}
			foreach ( $new as $id => $t ) {
				if ( $t < time() - 7 * DAY_IN_SECONDS || ! isset( $now[ $id ] ) ) {
					unset( $new[ $id ] );
				}
			}
			update_option( 'eb_ws_new', $new, false );
		}
		update_option( 'eb_ws_all', $all, false );
		update_option( 'eb_ws_synced', time(), false );
		if ( function_exists( 'rocket_clean_home' ) ) {
			rocket_clean_home(); // 홈 캐시도 새로(갱신 시각·새 서비스 수)
		}
		delete_option( 'eb_ws_sync_err' );
	}
	return count( $all );
}
add_action( 'eb_ws_daily', 'eb_ws_sync' );
add_action( 'init', function () {
	if ( eb_ws_key() && ! wp_next_scheduled( 'eb_ws_daily' ) ) {
		wp_schedule_event( strtotime( 'tomorrow 04:30' ) - (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ), 'daily', 'eb_ws_daily' );
	}
} );
add_action( 'admin_post_eb_ws_sync', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_ws_sync' );
	$n = eb_ws_sync();
	set_transient( 'eb_ws_admin_note', is_wp_error( $n ) ? '받기 실패: ' . esc_html( $n->get_error_message() ) : '전체 목록 ' . (int) $n . '개를 받아 저장했습니다.', MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-welfare-api' ) );
	exit;
} );

add_action( 'admin_menu', function () {
	add_options_page( '복지서비스 API', '복지서비스 API', 'manage_options', 'eb-welfare-api', 'eb_ws_admin_page' );
} );

function eb_ws_admin_page() {
	$has  = (bool) eb_ws_key();
	$note = get_transient( 'eb_ws_admin_note' );
	delete_transient( 'eb_ws_admin_note' );
	echo '<div class="wrap"><h1>복지서비스 API 연결</h1>';
	if ( $note ) {
		echo '<div class="notice notice-info"><p>' . wp_kses_post( $note ) . '</p></div>';
	}
	echo '<p>공공데이터포털 → 마이페이지 → 데이터 활용 → Open API → 활용신청 현황 → <b>한국사회보장정보원_중앙부처복지서비스</b>의 <b>일반 인증키(Decoding)</b>를 붙여 넣으세요. Encoding 키를 넣어도 자동으로 맞춥니다. 저장한 키는 다시 표시하지 않습니다.</p>';
	echo '<p style="color:#646970">승인 직후에는 키가 퍼지는 데 최대 1시간쯤 걸려 \'등록되지 않은 키\' 오류가 날 수 있어요. 잠시 뒤 다시 저장해 보세요.</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_ws_save">' . wp_nonce_field( 'eb_ws_save', '_wpnonce', true, false );
	echo '<table class="form-table"><tr><th>상태</th><td>' . ( $has ? '<strong style="color:#00a32a">키 저장됨</strong>' : '<strong style="color:#d63638">키 없음</strong>' ) . '</td></tr>';
	echo '<tr><th><label for="eb-ws-key">일반 인증키</label></th><td><input id="eb-ws-key" name="key" type="password" class="large-text" autocomplete="off" placeholder="' . ( $has ? '바꿀 때만 입력' : '' ) . '"></td></tr></table>';
	submit_button( $has ? '다시 연결 확인 (키를 비워 두면 저장된 키로)' : '저장하고 연결 확인' );
	echo '</form>';
	if ( $has ) {
		$all = (array) get_option( 'eb_ws_all', array() );
		$at  = (int) get_option( 'eb_ws_synced' );
		$err = get_option( 'eb_ws_sync_err' );
		echo '<hr><h2>저장된 정부 복지서비스 목록</h2><p>' . ( $all ? '<b>' . count( $all ) . '개</b> · 마지막으로 받은 때 ' . esc_html( wp_date( 'Y.m.d H:i', $at ) ) : '아직 받지 않았습니다.' ) . ' · 매일 새벽 4시 30분쯤 자동으로 새로 받습니다.' . ( $err ? '<br><span style="color:#d63638">최근 실패: ' . esc_html( $err ) . '</span>' : '' ) . '</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_ws_sync">' . wp_nonce_field( 'eb_ws_sync', '_wpnonce', true, false );
		submit_button( '지금 전체 목록 받기', 'secondary', 'submit', false );
		echo '</form>';
		if ( $all ) {
			echo '<table class="widefat striped" style="margin-top:12px;max-width:1100px"><thead><tr><th>서비스</th><th>부처</th><th>생애주기</th><th>가구 상황</th><th>관심 주제</th></tr></thead><tbody>';
			foreach ( array_slice( $all, 0, 8 ) as $s ) {
				echo '<tr><td>' . esc_html( $s['name'] ) . '</td><td>' . esc_html( $s['org'] ) . '</td><td>' . esc_html( $s['life'] ) . '</td><td>' . esc_html( $s['hh'] ) . '</td><td>' . esc_html( $s['them'] ) . '</td></tr>';
			}
			echo '</tbody></table><p style="color:#646970">처음 8개 미리보기 · 출처: 한국사회보장정보원(복지로)</p>';
		}
	}
	echo '</div>';
}

add_action( 'admin_post_eb_ws_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_ws_save' );
	$key = isset( $_POST['key'] ) ? trim( wp_unslash( $_POST['key'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$key = preg_replace( '/\s+/', '', $key );
	if ( $key ) {
		if ( false !== strpos( $key, '%' ) ) {
			$key = rawurldecode( $key ); // Encoding 키를 넣은 경우
		}
		update_option( 'eb_ws_key', sanitize_text_field( $key ), false );
	}
	$data = eb_ws_list( 1, 10 );
	if ( is_wp_error( $data ) ) {
		$note = '연결 실패: ' . esc_html( $data->get_error_message() );
	} else {
		$names = array_slice( wp_list_pluck( $data['items'], 'name' ), 0, 5 );
		$note  = '연결 성공 · 정부 복지서비스 <b>' . number_format_i18n( $data['total'] ) . '개</b> 확인. 예: ' . esc_html( implode( ', ', $names ) );
	}
	set_transient( 'eb_ws_admin_note', $note, MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-welfare-api' ) );
	exit;
} );

/* 55. 맞춤 혜택 찾기 화면 스크립트 (2026-10-09, 13-6 [eb_finder]가 그려졌을 때만) ------------------------------------
 * 고를 때마다 결과 다시 그림 · 조건은 이 기기(eb_finder_last v2)와 주소(?life=&hh=&th=, 공유용)에 · 홈 '내 맞춤' 줄은 l(이름)·n(개수)을 읽음 */
add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_f2_used'] ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var R = document.getElementById('finder');
	if (!R || !R.classList.contains('f2')) { return; }
	var D = {};
	try { D = JSON.parse(R.getAttribute('data-set')) || {}; } catch (e) {}
	var posts = D.posts || [], calcs = D.calcs || {}, svc = null, failed = false;
	var strict = false; // '조건 모두 맞는 것만': 고른 묶음(시기·가구 상황·필요한 도움)마다 하나 이상 맞아야(묶음 안은 하나만 맞아도) - 2026-10-09
	var S = { life: '', hh: [], th: [], sd: '', sg: '' }, sort = 'score', nP = 4, nS = 8, nL = 8, allL = false, loc = {}, locKey = '', locFail = false;
	var sdSel = R.querySelector('.f2__sd'), sgSel = R.querySelector('.f2__sg'), regions = D.regions || {};
	var body = R.querySelector('.f2__body'), jump = R.querySelector('.f2__jump');
	body.id = 'f2-res';
	var esc = function (s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
	var has = function (a, v) { return a && a.indexOf(v) > -1; };
	var anyC = function () { return !!(S.life || S.hh.length || S.th.length); };
	var any = function () { return anyC() || !!S.sd; };
	var rlab = function () { return S.sd ? S.sd.replace(/(특별자치시|특별자치도|특별시|광역시)$/, '').replace(/도$/, function (m, i, s) { return s.length > 3 ? '' : m; }) + (S.sg ? ' ' + S.sg : '') : ''; };
	var labels = function () { return (S.life ? [S.life] : []).concat(S.hh, S.th); };
	var chipsAll = function () { return labels().concat(S.sd ? [rlab()] : []); };
	// 지난번 조건(이 기기) → 주소에 조건이 있으면 그걸 우선(공유 링크)
	try { var L = JSON.parse(localStorage.getItem('eb_finder_last') || 'null'); if (L && L.v === 2) { S.life = L.life || ''; S.hh = L.hh || []; S.th = L.th || []; S.sd = L.sd || ''; S.sg = L.sg || ''; } } catch (e) {}
	var Q = new URLSearchParams(location.search);
	if (Q.get('life') || Q.get('hh') || Q.get('th') || Q.get('sd')) {
		S.life = Q.get('life') || '';
		S.hh = (Q.get('hh') || '').split(',').filter(Boolean);
		S.th = (Q.get('th') || '').split(',').filter(Boolean);
		S.sd = Q.get('sd') || '';
		S.sg = Q.get('sg') || '';
	}
	if (Q.get('m') === 'all') { strict = true; }
	if (S.sd && !regions[S.sd]) { S.sd = ''; S.sg = ''; }
	// ④ 사는 곳: 시·도 → 시·군·구 목록, 고르면 그 지역 서비스만 받아 옴(1시간 캐시)
	var fillSg = function () {
		if (!sgSel) { return; }
		var sgs = S.sd && regions[S.sd] ? Object.keys(regions[S.sd]).filter(Boolean) : [];
		sgSel.innerHTML = '<option value="">' + (S.sd ? '시·군·구 전체' : '시·군·구') + '</option>' + sgs.map(function (g) { return '<option value="' + esc(g) + '">' + esc(g) + '</option>'; }).join('');
		sgSel.disabled = !sgs.length;
		sgSel.value = S.sg;
		if (sdSel) { sdSel.value = S.sd; }
	};
	var loadLocal = function () {
		if (!S.sd) { return; }
		var k = S.sd + '|' + S.sg;
		if (loc[k] || locKey === k) { return; }
		locKey = k; locFail = false;
		fetch(D.lapi + (D.lapi.indexOf('?') > -1 ? '&' : '?') + 'sd=' + encodeURIComponent(S.sd) + '&sg=' + encodeURIComponent(S.sg), { credentials: 'same-origin' })
			.then(function (r) { return r.json(); }).then(function (j) { loc[k] = (j && j.items) || []; render(); })
			.catch(function () { locFail = true; render(); });
	};
	if (sdSel) { sdSel.addEventListener('change', function () { S.sd = sdSel.value; S.sg = ''; allL = false; nL = 8; fillSg(); loadLocal(); render(); }); }
	if (sgSel) { sgSel.addEventListener('change', function () { S.sg = sgSel.value; allL = false; nL = 8; loadLocal(); render(); if (S.sg && isAcc()) { openStep(nextOf('rg')); } }); }
	fillSg(); loadLocal();
	// 맞는 정도: 고른 시기와 다른 시기만 대상이면 빼고, 고른 조건이 겹칠수록 위로
	var match = function (l, h, t, st) {
		var strictOn = strict && !st;
		st = st || S;
		if (st.life && l.length && !has(l, st.life)) { return null; }
		if (strictOn) {
			if (st.life && !has(l, st.life)) { return null; }
			if (st.hh.length && !st.hh.some(function (v) { return has(h, v); })) { return null; }
			if (st.th.length && !st.th.some(function (v) { return has(t, v); })) { return null; }
		}
		var why = [];
		if (st.life && has(l, st.life)) { why.push(st.life); }
		st.hh.forEach(function (v) { if (has(h, v)) { why.push(v); } });
		st.th.forEach(function (v) { if (has(t, v)) { why.push(v); } });
		return why.length ? why : null;
	};
	var rank = function (list) {
		// 많이 겹치는 순 → 대상 생애주기가 적은 것(그 시기 '전용' 서비스) 먼저 → 가나다 (59번 빠른 찾기와 같은 기준, 2026-10-09)
		return list.sort(function (a, b) { return ((a.pr || 0) - (b.pr || 0)) || (sort === 'name' ? a.k.localeCompare(b.k, 'ko') : (b.why.length - a.why.length) || (((a.x.l || []).length || 9) - ((b.x.l || []).length || 9)) || a.k.localeCompare(b.k, 'ko')); });
	};
	var pills = function (why) { return '<span class="f2__why">' + why.map(function (w) { return '<i>' + esc(w) + '</i>'; }).join('') + '</span>'; };
	var presets = [
		['어르신 · 생활이 어려워요', { life: '노년', hh: ['저소득'], th: [] }],
		['청년 · 일자리', { life: '청년', hh: [], th: ['일자리'] }],
		['아이를 키워요', { life: '영유아', hh: [], th: ['보육'] }],
		['장애가 있어요', { life: '', hh: ['장애인'], th: [] }],
		['일을 쉬고 있어요', { life: '중장년', hh: [], th: ['일자리', '생활지원'] }],
		['임신·출산을 준비해요', { life: '임신·출산', hh: [], th: ['임신·출산'] }]
	];
	var save = function (n) {
		try {
			if (any()) { localStorage.setItem('eb_finder_last', JSON.stringify({ v: 2, life: S.life, hh: S.hh, th: S.th, sd: S.sd, sg: S.sg, l: chipsAll(), n: n, at: Date.now() })); } else { localStorage.removeItem('eb_finder_last'); }
		} catch (e) {}
		if (window.history && history.replaceState) {
			var p = new URLSearchParams();
			if (S.life) { p.set('life', S.life); }
			if (S.hh.length) { p.set('hh', S.hh.join(',')); }
			if (S.th.length) { p.set('th', S.th.join(',')); }
			if (S.sd) { p.set('sd', S.sd); }
			if (S.sg) { p.set('sg', S.sg); }
			if (strict && anyC()) { p.set('m', 'all'); }
			var qs = p.toString();
			// 주소의 #은 들어올 때 것 그대로(처음 열 때 #finder를 붙이면 제목을 건너뛰고 아래로 내려가서, 2026-10-15)
			history.replaceState(null, '', location.pathname + (qs ? '?' + qs : '') + location.hash);
		}
	};
	var paint = function () {
		R.querySelectorAll('[data-g]').forEach(function (b) {
			var g = b.getAttribute('data-g'), v = b.getAttribute('data-v');
			b.setAttribute('aria-pressed', (g === 'life' ? S.life === v : has(S[g], v)) ? 'true' : 'false');
		});
		// 숨은 '필요한 도움' 칩을 골라 두었으면 펼친 채로
		var thx = R.querySelector('.f2__thx'), thm = R.querySelector('.f2__thmore');
		if (thx && thm && thx.hidden && thx.querySelector('[aria-pressed="true"]')) { thx.hidden = false; thm.setAttribute('aria-expanded', 'true'); thm.textContent = '접기'; }
		// 휴대폰 접힌 단계 오른쪽에 고른 값
		steps.forEach(function (s) {
			var k = s.getAttribute('data-k'), v = k === 'life' ? S.life : (k === 'rg' ? rlab() : S[k].join(', '));
			var e = s.querySelector('.f2__hv');
			if (e) { e.textContent = v || ''; }
		});
	};
	// ── 단계(1~4) 표시 · 휴대폰에선 한 번에 한 단계만 펼침(접기), 하나 고르면 다음 단계 자동으로
	var steps = [].slice.call(R.querySelectorAll('.f2__step'));
	steps.forEach(function (s) { s.setAttribute('data-k', s.querySelector('.f2__life') ? 'life' : (s.querySelector('.f2__region') ? 'rg' : (s.querySelector('[data-g="hh"]') ? 'hh' : 'th'))); });
	var isAcc = function () { return R.classList.contains('is-acc'); };
	var openStep = function (k) {
		steps.forEach(function (s) {
			var on = s.getAttribute('data-k') === k, h = s.querySelector('.f2__h');
			s.classList.toggle('is-open', on);
			if (isAcc() && h) { h.setAttribute('aria-expanded', on ? 'true' : 'false'); }
		});
	};
	var nextOf = function (k) { var i = steps.map(function (s) { return s.getAttribute('data-k'); }).indexOf(k); return steps[i + 1] ? steps[i + 1].getAttribute('data-k') : ''; };
	var acc = function () {
		var on = window.innerWidth < 768, was = isAcc();
		R.classList.toggle('is-acc', on);
		steps.forEach(function (s) {
			var h = s.querySelector('.f2__h');
			if (!h) { return; }
			if (on) { h.setAttribute('role', 'button'); h.tabIndex = 0; h.setAttribute('aria-expanded', s.classList.contains('is-open') ? 'true' : 'false'); } else { h.removeAttribute('role'); h.removeAttribute('tabindex'); h.removeAttribute('aria-expanded'); }
		});
		if (on && !was) {
			var first = steps.filter(function (s) { var k = s.getAttribute('data-k'); return !(k === 'life' ? S.life : (k === 'rg' ? S.sd : S[k].length)); })[0];
			openStep(first ? first.getAttribute('data-k') : '');
		}
	};
	R.addEventListener('click', function (e) {
		var h = e.target.closest('.f2__h');
		if (!h || !isAcc()) { return; }
		var s = h.closest('.f2__step');
		openStep(s.classList.contains('is-open') ? '' : s.getAttribute('data-k'));
	});
	R.addEventListener('keydown', function (e) {
		var h = e.target.closest && e.target.closest('.f2__h');
		if (h && isAcc() && (e.key === 'Enter' || e.key === ' ')) { e.preventDefault(); h.click(); }
	});
	// ── PC: 조건 패널이 화면 안에 다 들어갈 때만 따라 내려오게(넘치면 페이지와 함께 스크롤)
	var stick = function () {
		var p = R.querySelector('.f2__panel-in');
		if (!p) { return; }
		var top = document.body.classList.contains('admin-bar') ? 116 : 84;
		R.classList.toggle('is-stick', window.innerWidth >= 1080 && p.offsetHeight + top + 16 <= window.innerHeight);
	};
	var render = function () {
		paint();
		if (!any()) {
			body.innerHTML = '<div class="f2__empty"><p class="f2__lead"><b>' + (window.innerWidth >= 1080 ? '왼쪽' : '위') + '에서 조건을 고르면</b><br>정부·우리 지역 복지서비스와 에디터가 쉽게 정리한 글 가운데<br>해당하는 것을 바로 모아 드려요.</p><p class="f2__plab">이렇게 시작해 보세요</p><div class="f2__presets">'
				+ presets.map(function (p, i) { return '<button type="button" data-preset="' + i + '">' + esc(p[0]) + '</button>'; }).join('') + '</div></div>';
			jump.hidden = true;
			save(0);
			return;
		}
		var P = [], G = [];
		// 대상 지역 글(53-2번): 사는 곳을 골랐으면 다른 지역 글은 빼고 같은 지역 글은 앞으로, 안 골랐으면 'OO 한정' 표시 + 뒤로 (2026-10-09)
		posts.forEach(function (x) { var w = match(x.l || [], x.h || [], x.th || []), rg = x.r || []; if (!w) { return; } if (rg.length && S.sd && rg.indexOf(S.sd) < 0) { return; } P.push({ x: x, why: w, k: x.t, pr: rg.length ? (S.sd ? -1 : 1) : 0, far: rg.length && !S.sd ? (x.rs || rg[0]) : '', mine: !!(rg.length && S.sd) }); });
		if (svc) { svc.forEach(function (x) { var w = match(x.l || [], x.h || [], x.t || []); if (w) { G.push({ x: x, why: w, k: x.n }); } }); }
		var LK = S.sd + '|' + S.sg, LA = loc[LK], LM = [];
		if (LA) { LA.forEach(function (x) { var w = anyC() ? match(x.l || [], x.h || [], x.t || []) : []; if (w) { LM.push({ x: x, why: w, k: x.n }); } }); }
		if (!anyC()) { G = []; P = []; }
		rank(P); rank(G); rank(LM);
		var total = P.length + G.length + LM.length;
		var ready = (svc || failed || !anyC()) && (!S.sd || LA || locFail);
		var h = '<div class="f2__bar"><p class="f2__cnt"><b>' + (ready ? total : P.length + '+') + '</b>개 찾았어요</p><div class="f2__sel">'
			+ chipsAll().map(function (v) { return '<button type="button" data-x="' + esc(v) + '" aria-label="' + esc(v) + ' 조건 빼기">' + esc(v) + '<span aria-hidden="true">✕</span></button>'; }).join('')
			+ '</div>' + (((S.life ? 1 : 0) + (S.hh.length ? 1 : 0) + (S.th.length ? 1 : 0)) >= 2 ? '<button type="button" class="f2__strict" role="switch" aria-checked="' + strict + '"><i aria-hidden="true"></i>조건 모두 맞는 것만</button>' : '') + '<button type="button" class="f2__edit">조건 바꾸기</button>' + (anyC() ? '<button type="button" class="f2__share">결과 공유</button>' : '') + '</div>'; // 정렬 버튼(많이 겹치는 순/가나다순)은 뺌 - 항상 많이 겹치는 순(2026-10-09)
		// 함께 쓰면 좋은 계산기
		var cs = [], seen = {};
		labels().forEach(function (v) { (calcs[v] || []).forEach(function (c) { if (!seen[c[0]] && cs.length < 4) { seen[c[0]] = 1; cs.push(c); } }); });
		if (cs.length) {
			h += '<div class="f2__calc"><span>바로 계산해 보기</span>' + cs.map(function (c) { return '<a href="' + esc(c[0]) + '">' + esc(c[1]) + '</a>'; }).join('') + '</div>';
		}
		// ① 이지복지가 정리한 글
		if (anyC()) {
		h += '<div class="f2__sec"><h3 class="f2__st"><span class="f2__badge is-ours">에디터 정리</span>쉽게 정리한 글 <em>' + P.length + '</em></h3>';
		if (P.length) {
			h += '<ul class="f2__posts">' + P.slice(0, nP).map(function (o) {
				var x = o.x;
				return '<li><a href="' + esc(x.u) + '"><span class="f2__pc">' + esc(x.c) + (x.p ? '<b>많이 봄</b>' : '') + (o.mine ? '<b class="is-rg is-me">우리 지역</b>' : (o.far ? '<b class="is-rg">' + esc(o.far) + ' 한정</b>' : '')) + '</span><strong>' + esc(x.t) + '</strong>' + pills(o.why) + '<span class="f2__pd">' + esc(x.d) + ' 업데이트<span class="f2__go" aria-hidden="true">글 보기 →</span></span></a></li>';
			}).join('') + '</ul>';
			if (P.length > nP) { h += '<button type="button" class="f2__more" data-more="p">정리 글 더 보기 <span>' + (P.length - nP) + '개</span></button>'; }
		} else {
			h += '<p class="f2__none">아직 이 조건으로 정리한 글이 없어요. 아래 정부 서비스를 확인해 보세요.</p>';
		}
		h += '</div>';
		}
		// ② 우리 지역(시·도·시·군·구) 서비스 - 조건이 있으면 맞는 것 먼저, '전체 보기'로 지역 전부
		if (S.sd) {
			h += '<div class="f2__sec"><h3 class="f2__st"><span class="f2__badge is-loc">우리 지역</span>' + esc(rlab()) + ' <em>' + (LA ? LM.length : (locFail ? 0 : '…')) + '</em></h3>';
			if (!LA && !locFail) {
				h += '<ul class="f2__svc is-loading">' + [1, 2].map(function () { return '<li><i></i><i></i><i></i></li>'; }).join('') + '</ul>';
			} else if (locFail) {
				h += '<p class="f2__none">지역 서비스를 불러오지 못했어요. 잠시 뒤 다시 시도해 주세요.</p>';
			} else {
				var LS = allL ? rank(LA.map(function (x) { var w = anyC() ? match(x.l || [], x.h || [], x.t || []) : null; return { x: x, why: w || [], k: x.n }; })) : LM;
				if (LS.length) {
					h += '<ul class="f2__svc is-loc">' + LS.slice(0, nL).map(function (o) {
						var x = o.x;
						return '<li><div class="f2__sm"><strong>' + esc(x.n) + '</strong><span class="f2__org">' + esc(x.sg ? x.sg : S.sd + ' 전체') + '</span></div>' + (x.s ? '<p>' + esc(x.s) + '</p>' : '') + '<div class="f2__sf">' + (o.why.length ? pills(o.why) : '<span class="f2__dept">' + esc(x.o) + '</span>') + '<a href="' + esc(x.u) + '" target="_blank" rel="noopener">복지로에서 자세히<span class="screen-reader-text">(새 창)</span> <span aria-hidden="true">↗</span></a></div></li>';
					}).join('') + '</ul>';
					if (LS.length > nL) { h += '<button type="button" class="f2__more" data-more="l">지역 서비스 더 보기 <span>' + (LS.length - nL) + '개</span></button>'; }
				} else {
					h += '<p class="f2__none">고른 조건에 딱 맞는 ' + esc(rlab()) + ' 서비스는 없어요.</p>';
				}
				if (anyC() && LA.length > LM.length) { h += '<button type="button" class="f2__all" data-alll="1">' + (allL ? '조건에 맞는 것만 보기' : esc(rlab()) + ' 서비스 전체 ' + LA.length + '개 보기') + '</button>'; }
			}
			h += '</div>';
		}
		// ③ 정부 복지서비스 전체
		if (anyC()) {
		h += '<div class="f2__sec"><h3 class="f2__st"><span class="f2__badge is-gov">정부 서비스</span>복지로 중앙부처 <em>' + (svc ? G.length : (failed ? 0 : '…')) + '</em></h3>';
		if (!svc && !failed) {
			h += '<ul class="f2__svc is-loading">' + [1, 2, 3].map(function () { return '<li><i></i><i></i><i></i></li>'; }).join('') + '</ul>';
		} else if (failed) {
			h += '<p class="f2__none">정부 서비스 목록을 불러오지 못했어요. 잠시 뒤 새로고침하거나 <a href="https://www.bokjiro.go.kr/" target="_blank" rel="noopener">복지로<span class="screen-reader-text">(새 창)</span></a>를 이용해 주세요.</p>';
		} else if (G.length) {
			h += '<ul class="f2__svc">' + G.slice(0, nS).map(function (o) {
				var x = o.x;
				return '<li><div class="f2__sm"><strong>' + esc(x.n) + '</strong><span class="f2__org">' + esc(x.o) + '</span></div>' + (x.s ? '<p>' + esc(x.s) + '</p>' : '') + '<div class="f2__sf">' + pills(o.why) + '<a href="' + esc(x.u) + '" target="_blank" rel="noopener">복지로에서 자세히<span class="screen-reader-text">(새 창)</span> <span aria-hidden="true">↗</span></a></div></li>';
			}).join('') + '</ul>';
			if (G.length > nS) { h += '<button type="button" class="f2__more" data-more="s">정부 서비스 더 보기 <span>' + (G.length - nS) + '개</span></button>'; }
		} else {
			h += '<p class="f2__none">이 조건에 딱 맞는 중앙부처 서비스는 없어요. 조건을 하나 줄여 보거나, 사는 지역의 서비스는 <a href="https://www.bokjiro.go.kr/" target="_blank" rel="noopener">복지로<span class="screen-reader-text">(새 창)</span></a>에서 찾아보세요.</p>';
		}
		h += '</div>';
		}
		body.innerHTML = h;
		jump.setAttribute('data-n', ready ? total : P.length + '+');
		save(ready ? total : P.length);
		vis();
		stick();
	};
	// 휴대폰·태블릿 아래 떠 있는 버튼: 결과가 아래 있으면 '결과 n개 보기 ↓', 결과를 보는 중이면 '조건 바꾸기 ↑'
	var vis = function () {
		if (!any() || window.innerWidth >= 1080) { jump.hidden = true; return; }
		var r = body.getBoundingClientRect(), down = r.top > window.innerHeight - 80, past = r.bottom < 120;
		jump.hidden = past;
		var mode = down ? 'res' : 'edit';
		if (jump.getAttribute('data-mode') !== mode || jump.getAttribute('data-shown') !== jump.getAttribute('data-n')) {
			jump.setAttribute('data-mode', mode);
			jump.setAttribute('data-shown', jump.getAttribute('data-n'));
			jump.classList.toggle('is-edit', !down);
			jump.innerHTML = down
				? '결과 <b>' + esc(jump.getAttribute('data-n')) + '</b>개 보기<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M6 13l6 6 6-6"/></svg>'
				: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h10M18 7h2M4 17h4M12 17h8"/><circle cx="16" cy="7" r="2"/><circle cx="10" cy="17" r="2"/></svg>조건 바꾸기'; // 조건 바꾸기: 흰 반투명 알약(덜 튀게), 결과 보기: 남색(2026-10-09)
		}
	};
	window.addEventListener('scroll', function () { window.requestAnimationFrame(vis); }, { passive: true });
	window.addEventListener('resize', function () { vis(); stick(); acc(); });
	R.addEventListener('click', function (e) {
		var b = e.target.closest('button, a.f2__jump');
		if (!b || !R.contains(b)) { return; }
		var g = b.getAttribute('data-g');
		if (g) {
			var v = b.getAttribute('data-v');
			if (g === 'life') { S.life = S.life === v ? '' : v; } else { var i = S[g].indexOf(v); if (i > -1) { S[g].splice(i, 1); } else { S[g].push(v); } }
			nP = 4; nS = 8; render();
			if (g === 'life' && S.life && isAcc()) { openStep(nextOf('life')); }
			return;
		}
		if (b.hasAttribute('data-x')) {
			var x = b.getAttribute('data-x');
			if (S.sd && x === rlab()) { S.sd = ''; S.sg = ''; fillSg(); }
			if (S.life === x) { S.life = ''; }
			S.hh = S.hh.filter(function (v) { return v !== x; });
			S.th = S.th.filter(function (v) { return v !== x; });
			render(); return;
		}
		if (b.hasAttribute('data-preset')) {
			var p = presets[+b.getAttribute('data-preset')][1];
			S = { life: p.life, hh: p.hh.slice(), th: p.th.slice(), sd: S.sd, sg: S.sg };
			render(); return;
		}
		if (b.hasAttribute('data-sort')) { sort = b.getAttribute('data-sort'); render(); return; }
		if (b.hasAttribute('data-more')) { var mm = b.getAttribute('data-more'); if (mm === 'p') { nP += 8; } else if (mm === 'l') { nL += 12; } else { nS += 12; } render(); return; }
		if (b.hasAttribute('data-alll')) { allL = !allL; nL = 8; render(); return; }
		if (b.classList.contains('f2__strict')) { strict = !strict; nP = 4; nS = 8; nL = 8; render(); return; }
		if (b.classList.contains('f2__thmore')) {
			var x2 = R.querySelector('.f2__thx'), open = x2.hidden;
			x2.hidden = !open; b.setAttribute('aria-expanded', open ? 'true' : 'false');
			b.textContent = open ? '접기' : '+' + x2.querySelectorAll('[data-g]').length + '개 더 보기';
			stick(); return;
		}
		if (b.classList.contains('f2__edit')) { R.querySelector('.f2__panel').scrollIntoView({ behavior: 'smooth', block: 'start' }); return; }
		// 결과 공유: 지금 조건이 담긴 주소(가족에게 보내면 같은 결과가 열림, 2026-10-15)
		if (b.classList.contains('f2__share')) {
			var su = location.origin + location.pathname + location.search + '#finder', st = '이지복지닷컴 맞춤 찾기 · ' + chipsAll().join(' · ');
			var copied = function () { b.textContent = '✓ 링크 복사됨'; setTimeout(function () { b.textContent = '결과 공유'; }, 2400); };
			var manual = function () { window.prompt('이 주소를 복사해 보내 주세요', su); };
			// 클립보드가 막힌 앱 안 브라우저(카톡 등)는 예전 방식으로, 그래도 안 되면 주소 창
			var legacy = function () {
				var ta = document.createElement('textarea'), ok = false;
				ta.value = su; ta.setAttribute('readonly', ''); ta.style.position = 'fixed'; ta.style.opacity = '0';
				document.body.appendChild(ta); ta.select();
				try { ok = document.execCommand('copy'); } catch (er) {}
				document.body.removeChild(ta);
				if (ok) { copied(); } else { manual(); }
			};
			if (navigator.share) { navigator.share({ title: st, text: st, url: su }).catch(function () {}); }
			else if (navigator.clipboard) { navigator.clipboard.writeText(su).then(copied, legacy); }
			else { legacy(); }
			return;
		}
		if (b.classList.contains('f2__reset')) { S = { life: '', hh: [], th: [], sd: '', sg: '' }; fillSg(); render(); return; }
		if (b.classList.contains('f2__jump')) { e.preventDefault(); (b.getAttribute('data-mode') === 'edit' ? R.querySelector('.f2__panel') : body).scrollIntoView({ behavior: 'smooth', block: 'start' }); }
	});
	// ── 아래 [eb_find_more]: 상황 타일(누르면 위 조건에 적용·숫자는 실제 데이터) + 상황별/분야별 탭
	var F = document.querySelector('.f3');
	var f3count = function () {
		if (!F) { return; }
		F.querySelectorAll('[data-preset]').forEach(function (b) {
			var p = {}; try { p = JSON.parse(b.getAttribute('data-preset')); } catch (e) {}
			p.hh = p.hh || []; p.th = p.th || [];
			var np = posts.filter(function (x) { return match(x.l || [], x.h || [], x.th || [], p); }).length;
			var ng = svc ? svc.filter(function (x) { return match(x.l || [], x.h || [], x.t || [], p); }).length : null;
			var n = b.querySelector('.f3__n');
			// 정리 글 0개는 감춤(2026-10-15) - 알림판 '맞춤 찾기 점검'에서 빈 상황을 확인
			if (n) { n.innerHTML = [ng === null ? (failed ? '' : '<span>정부 <em>…</em></span>') : '<span>정부 <em>' + ng + '</em></span>', np ? '<span>정리 글 ' + np + '</span>' : ''].filter(Boolean).join(' · '); }
		});
	};
	if (F) {
		F.addEventListener('click', function (e) {
			var b = e.target.closest('.f3__sib');
			if (b) {
				var p = {}; try { p = JSON.parse(b.getAttribute('data-preset')); } catch (er) {}
				S = { life: p.life || '', hh: (p.hh || []).slice(), th: (p.th || []).slice(), sd: S.sd, sg: S.sg };
				nP = 4; nS = 8; render();
				if (isAcc()) { openStep(''); }
				body.scrollIntoView({ behavior: 'smooth', block: 'start' });
				return;
			}
			var tb = e.target.closest('[role="tab"]');
			if (tb) { f3tab(tb); }
		});
		F.addEventListener('keydown', function (e) {
			var tb = e.target.closest && e.target.closest('[role="tab"]');
			if (!tb || (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft')) { return; }
			var all = [].slice.call(F.querySelectorAll('[role="tab"]')), i = all.indexOf(tb);
			e.preventDefault(); f3tab(all[(i + (e.key === 'ArrowRight' ? 1 : -1) + all.length) % all.length], true);
		});
	}
	var f3tab = function (tb, focus) {
		F.querySelectorAll('[role="tab"]').forEach(function (x, i) {
			var on = x === tb;
			x.setAttribute('aria-selected', on ? 'true' : 'false'); x.tabIndex = on ? 0 : -1;
			var pn = document.getElementById(x.getAttribute('aria-controls')); if (pn) { pn.hidden = !on; }
			if (on) { var hn = F.querySelector('.f3__hint'); if (hn) { hn.textContent = hn.getAttribute('data-h' + (i + 1)); } }
		});
		if (focus) { tb.focus(); }
	};
	// 혜택 찾기 페이지에서 하단 탭 가운데 '맞춤 찾기'를 누르면 같은 페이지를 다시 불러오지 않고 조건으로 올라감(2026-10-09)
	var tabMain = document.querySelector('.ebt .ebt__main');
	if (tabMain) {
		tabMain.addEventListener('click', function (e) {
			e.preventDefault();
			var first = steps.filter(function (s) { var k = s.getAttribute('data-k'); return !(k === 'life' ? S.life : (k === 'rg' ? S.sd : S[k].length)); })[0];
			if (isAcc()) { openStep(first ? first.getAttribute('data-k') : 'life'); }
			R.querySelector('.f2__panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	}
	// 메뉴 '분야별 정보'(/find/#categories)로 오면 아래 '분야별로' 탭을 열고 그 자리로(2026-10-15, 57번에서 탭으로 합친 뒤 끊겼던 주소)
	var f3hash = function () {
		if (!F || location.hash !== '#categories') { return false; }
		var tb = F.querySelector('#f3-t2');
		if (tb) { f3tab(tb); }
		F.scrollIntoView({ block: 'start' });
		return true;
	};
	var f3moved = false;
	['wheel', 'touchstart', 'keydown'].forEach(function (ev) { window.addEventListener(ev, function () { f3moved = true; }, { once: true, passive: true }); });
	window.addEventListener('hashchange', f3hash);
	acc();
	render();
	f3count();
	var f3jump = f3hash();
	// 패널 높이는 글꼴·스타일이 다 적용된 뒤에 다시 잼(처음엔 덜 그려진 높이로 재서 안 따라오던 문제)
	window.addEventListener('load', stick);
	if (document.fonts && document.fonts.ready) { document.fonts.ready.then(stick); }
	setTimeout(stick, 600);
	// 정부 서비스 목록은 화면이 뜬 뒤 따로(1시간 브라우저 캐시)
	fetch(D.api, { credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (j) { svc = (j && j.items) || []; render(); f3count(); if (f3jump && !f3moved) { f3hash(); } }).catch(function () { failed = true; render(); f3count(); });
})();
JS
	. "\n</script>\n";
}, 60 );

/* 56. 지자체 복지서비스(사는 곳) - 같은 인증키, 공공데이터포털 '한국사회보장정보원_지자체복지서비스' (2026-10-09) -------------------------
 * 목록 전체를 500개씩 받아 옵션 eb_ws_local에 저장(하루 1회, 개발 계정 하루 1,000회 한도). 응답 항목 이름이 문서에 없어 모든 항목을 그대로 받아 두고
 * eb_ws_local_pick()이 이름 후보 중 있는 것을 골라 씀. 설정 화면에 첫 항목의 원본 항목 목록을 보여 줌(맞추기용) */
function eb_ws_local_fetch( $page, $rows ) {
	$key = eb_ws_key();
	if ( ! $key ) {
		return new WP_Error( 'eb_ws_nokey', '인증키가 없습니다.' );
	}
	$url = 'https://apis.data.go.kr/B554287/LocalGovernmentWelfareInformations/LcgvWelfarelist?serviceKey=' . rawurlencode( $key ) . '&pageNo=' . (int) $page . '&numOfRows=' . (int) $rows;
	$res = wp_remote_get( $url, array( 'timeout' => 25 ) );
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$body = (string) wp_remote_retrieve_body( $res );
	$prev = libxml_use_internal_errors( true );
	$xml  = simplexml_load_string( $body );
	libxml_use_internal_errors( $prev );
	if ( ! $xml ) {
		return new WP_Error( 'eb_ws_bad', 'HTTP ' . wp_remote_retrieve_response_code( $res ) . ' · ' . wp_strip_all_tags( mb_substr( $body, 0, 200 ) ) );
	}
	$pick = function ( $q ) use ( $xml ) {
		$r = $xml->xpath( $q );
		return $r ? trim( (string) $r[0] ) : '';
	};
	$rc = $pick( '//resultCode|//returnReasonCode' );
	if ( '' !== $rc && '0' !== $rc && '00' !== $rc ) {
		return new WP_Error( 'eb_ws_api', '결과 코드 ' . $rc . ' · ' . $pick( '//resultMessage|//resultMsg|//returnAuthMsg|//errMsg' ) );
	}
	$items = array();
	foreach ( $xml->xpath( '//servList' ) ?: array() as $s ) {
		$row = array();
		foreach ( $s->children() as $k => $v ) {
			$row[ (string) $k ] = trim( (string) $v );
		}
		$items[] = $row;
	}
	return array( 'total' => (int) $pick( '//totalCount' ), 'items' => $items );
}
function eb_ws_local_pick( $row, $keys ) {
	foreach ( $keys as $k ) {
		if ( isset( $row[ $k ] ) && '' !== $row[ $k ] ) {
			return $row[ $k ];
		}
	}
	return '';
}
function eb_ws_local_sync() {
	$all  = array();
	$raw1 = array();
	$page = 1;
	do {
		$d = eb_ws_local_fetch( $page, 500 );
		if ( is_wp_error( $d ) ) {
			update_option( 'eb_ws_local_err', $d->get_error_message(), false );
			return $d;
		}
		foreach ( $d['items'] as $r ) {
			if ( ! $raw1 ) {
				$raw1 = $r;
			}
			$all[] = array(
				'n'  => eb_ws_local_pick( $r, array( 'servNm' ) ),
				'o'  => eb_ws_local_pick( $r, array( 'bizChrDeptNm', 'jurOrgNm', 'jurMnofNm' ) ),
				's'  => eb_ws_local_pick( $r, array( 'servDgst' ) ),
				'u'  => eb_ws_local_pick( $r, array( 'servDtlLink' ) ),
				'sd' => eb_ws_local_pick( $r, array( 'ctpvNm', 'ctpvNmArray', 'sidoNm' ) ),
				'sg' => eb_ws_local_pick( $r, array( 'sggNm', 'sggNmArray', 'sigunguNm' ) ),
				'l'  => eb_ws_local_pick( $r, array( 'lifeArray', 'lifeNmArray' ) ),
				'h'  => eb_ws_local_pick( $r, array( 'trgterIndvdlArray', 'trgterIndvdlNmArray' ) ),
				't'  => eb_ws_local_pick( $r, array( 'intrsThemaArray', 'intrsThemaNmArray' ) ),
			);
		}
		$page++;
	} while ( $d['items'] && count( $all ) < $d['total'] && $page <= 30 );
	if ( $all ) {
		update_option( 'eb_ws_local', $all, false );
		update_option( 'eb_ws_local_raw1', $raw1, false );
		update_option( 'eb_ws_local_synced', time(), false );
		delete_option( 'eb_ws_local_err' );
	}
	return count( $all );
}
add_action( 'eb_ws_daily', 'eb_ws_local_sync', 20 );
add_action( 'admin_post_eb_ws_local_sync', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_ws_local_sync' );
	$n = eb_ws_local_sync();
	set_transient( 'eb_ws_admin_note', is_wp_error( $n ) ? '지역 서비스 받기 실패: ' . esc_html( $n->get_error_message() ) : '지역 서비스 ' . (int) $n . '개를 받아 저장했습니다.', MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'options-general.php?page=eb-welfare-api' ) );
	exit;
} );
// 설정 화면 아래: 지역 서비스 상태·받기 버튼·원본 항목(맞추기용)
add_action( 'admin_footer-settings_page_eb-welfare-api', function () {
	if ( ! eb_ws_key() ) {
		return;
	}
	$all = (array) get_option( 'eb_ws_local', array() );
	$err = get_option( 'eb_ws_local_err' );
	$raw = (array) get_option( 'eb_ws_local_raw1', array() );
	$h   = '<hr><h2>지역(지자체) 복지서비스</h2><p>' . ( $all ? '<b>' . count( $all ) . '개</b> · 마지막으로 받은 때 ' . esc_html( wp_date( 'Y.m.d H:i', (int) get_option( 'eb_ws_local_synced' ) ) ) : '아직 받지 않았습니다. 공공데이터포털에서 <b>한국사회보장정보원_지자체복지서비스</b> 활용신청이 승인된 뒤 눌러 주세요.' ) . ( $err ? '<br><span style="color:#d63638">최근 실패: ' . esc_html( $err ) . '</span>' : '' ) . '</p>'
		. '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="eb_ws_local_sync">' . wp_nonce_field( 'eb_ws_local_sync', '_wpnonce', true, false ) . '<button class="button">지금 지역 서비스 받기</button></form>';
	if ( $raw ) {
		$h .= '<details style="margin-top:10px"><summary>첫 항목 원본(응답 항목 이름 확인용)</summary><pre style="white-space:pre-wrap;max-width:1100px;background:#fff;padding:10px;border:1px solid #dcdcde">' . esc_html( print_r( $raw, true ) ) . '</pre></details>';
	}
	echo '<div id="eb-ws-local" hidden>' . $h . '</div><script>(function(){var s=document.getElementById("eb-ws-local"),w=document.querySelector(".wrap");if(s&&w){w.appendChild(s);s.hidden=false;}})();</script>'; // phpcs:ignore
} );

// 56-2. 지역 목록(시·도 → 시·군·구 → 서비스 수)과 지역별 서비스 - 혜택 찾기 ④ 사는 곳 (2026-10-09)
// 시·군·구 칸 정리: '-'·'OO교육청'은 시·도 전체 대상이라 빈칸으로 봄(사는 곳 목록에 '서울특별시교육청'이 뜨던 문제, 2026-10-09)
function eb_ws_norm_sg( $sg ) {
	$sg = trim( (string) $sg );
	return ( '-' === $sg || preg_match( '/교육청$/u', $sg ) ) ? '' : $sg;
}
function eb_ws_regions() {
	$at  = (int) get_option( 'eb_ws_local_synced' );
	$key = 'eb_ws_regions2_' . $at;
	$out = get_transient( $key );
	if ( is_array( $out ) ) {
		return $out;
	}
	$out = array();
	foreach ( (array) get_option( 'eb_ws_local', array() ) as $s ) {
		$sd = isset( $s['sd'] ) ? trim( $s['sd'] ) : '';
		if ( '' === $sd ) {
			continue;
		}
		$sg = eb_ws_norm_sg( isset( $s['sg'] ) ? $s['sg'] : '' );
		if ( ! isset( $out[ $sd ] ) ) {
			$out[ $sd ] = array( '' => 0 );
		}
		$out[ $sd ][ $sg ] = ( isset( $out[ $sd ][ $sg ] ) ? $out[ $sd ][ $sg ] : 0 ) + 1;
	}
	$order = array( '서울특별시', '부산광역시', '대구광역시', '인천광역시', '광주광역시', '대전광역시', '울산광역시', '세종특별자치시', '경기도', '강원특별자치도', '충청북도', '충청남도', '전북특별자치도', '전라남도', '경상북도', '경상남도', '제주특별자치도' );
	uksort( $out, function ( $a, $b ) use ( $order ) {
		$x = array_search( $a, $order, true );
		$y = array_search( $b, $order, true );
		return ( false === $x ? 99 : $x ) - ( false === $y ? 99 : $y ) ?: strcmp( $a, $b );
	} );
	foreach ( $out as $sd => $sgs ) {
		ksort( $sgs );
		$out[ $sd ] = $sgs;
	}
	set_transient( $key, $out, DAY_IN_SECONDS );
	return $out;
}
add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/local', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'args'                => array( 'sd' => array( 'required' => true ), 'sg' => array( 'default' => '' ) ),
		'callback'            => function ( $req ) {
			$sd  = sanitize_text_field( (string) $req['sd'] );
			$sg  = sanitize_text_field( (string) $req['sg'] );
			$sp  = function ( $s ) {
				return array_values( array_filter( array_map( function ( $v ) { return preg_replace( '/\s*·\s*/u', '·', trim( $v ) ); }, explode( ',', (string) $s ) ) ) ); // '임신 · 출산' → '임신·출산'
			};
			$out = array();
			foreach ( (array) get_option( 'eb_ws_local', array() ) as $s ) {
				if ( empty( $s['n'] ) || $sd !== trim( (string) $s['sd'] ) ) {
					continue;
				}
				$ssg = eb_ws_norm_sg( $s['sg'] );
				if ( '' !== $sg && '' !== $ssg && $sg !== $ssg ) {
					continue; // 다른 시·군·구 것은 빼고, 시·도 전체 대상(시·군·구 빈칸)은 함께
				}
				$out[] = array(
					'n'  => $s['n'],
					'o'  => $s['o'],
					's'  => wp_strip_all_tags( $s['s'] ),
					'u'  => 0 === strpos( (string) $s['u'], 'http' ) ? $s['u'] : 'https://www.bokjiro.go.kr/',
					'sg' => '' === $ssg && preg_match( '/교육청$/u', trim( (string) $s['sg'] ) ) ? '교육청' : $ssg,
					'l'  => $sp( $s['l'] ),
					'h'  => $sp( $s['h'] ),
					't'  => $sp( $s['t'] ),
				);
			}
			$res = new WP_REST_Response( array( 'items' => $out ) );
			$res->header( 'Cache-Control', 'public, max-age=3600' );
			return $res;
		},
	) );
} );

/* 57. 혜택 찾기 아래 [eb_find_more] - 상황별·분야별을 탭 카드 하나로 + '찾는 게 없나요?' 한 줄 (2026-10-09, style.css 100번)
 * 상황 타일을 누르면 위 맞춤 찾기에 조건이 들어가고 결과로 올라감(55번 스크립트가 data-preset 처리, 숫자도 55번이 실제 데이터로 셈) */
// 상황 타일 목록(이름, 가이드 주소, 맞춤 찾기 조건, 아이콘) - [eb_find_more]와 알림판 '맞춤 찾기 점검'(19-7)이 함께 씀 (2026-10-15)
// 상황별 가이드 목록 - 여기 한 곳만 고치면 PC 메가메뉴·홈(상단 칩·가이드 칸)에 함께 반영 (2026-10-15)
// 주소, 아이콘(eb_x_ic), 이름, 짧은 설명, 홈 상단 칩 이름. 혜택 찾기 상황 타일(조건 포함)은 아래 eb_find_situations()
// 자주 찾는 공식 기관 - 중요한 순서. 홈 '공식 기관 바로가기'는 12곳 전부, 푸터·사이드바([eb_orgs])는 앞 6곳 (2026-10-16)
function eb_org_list() {
	return array(
		array( 'https://www.bokjiro.go.kr/', '복지로', '복지서비스 신청·조회' ),
		array( 'https://www.gov.kr/', '정부24', '민원서류 발급' ),
		array( 'https://www.gov.kr/portal/rcvfvrSvc/main', '보조금24', '받을 수 있는 혜택 조회' ),
		array( 'https://www.work24.go.kr/', '고용24', '실업급여·일자리' ),
		array( 'https://www.nhis.or.kr/', '국민건강보험', '보험료·건강검진' ),
		array( 'https://www.nps.or.kr/', '국민연금', '연금 조회·신청' ),
		array( 'https://www.comwel.or.kr/', '근로복지공단', '산재보험·대지급금' ),
		array( 'https://www.kinfa.or.kr/', '서민금융진흥원', '서민 대출·금융 상담' ),
		array( 'https://www.hometax.go.kr/', '홈택스', '세금·근로장려금' ),
		array( 'https://www.myhome.go.kr/', '마이홈포털', '공공임대·주거 지원' ),
		array( 'https://www.youthcenter.go.kr/', '온통청년', '청년 정책 찾기' ),
		array( 'https://www.korea.kr/', '정책브리핑', '정부 정책 소식' ),
	);
}

// 사이드바 '공식 기관 바로가기'(위젯 block-58) - 예전 위젯 목록과 같은 꾸밈(.eb-org-links)
add_shortcode( 'eb_orgs', function ( $atts ) {
	$atts = shortcode_atts( array( 'n' => 6 ), $atts );
	$li   = '';
	foreach ( array_slice( eb_org_list(), 0, max( 1, (int) $atts['n'] ) ) as $o ) {
		$li .= '<li><a href="' . esc_url( $o[0] ) . '" target="_blank" rel="noreferrer noopener">' . esc_html( $o[1] ) . '</a> <span class="eb-org-desc">' . esc_html( $o[2] ) . '</span></li>';
	}
	return '<ul class="wp-block-list eb-org-links">' . $li . '</ul>';
} );

// 분야 순서를 메뉴·푸터·홈과 같게(복지 → 건강 → 금융 → 노동, 세부 분야도 메뉴 순서) - 사이드바 '분야별 카테고리', 분야 목록 위 '세부 분야' 등 (2026-10-16)
function eb_cat_order() {
	return array( 215, 216, 218, 219, 221, 220, 230, 222, 223, 225, 224, 231, 226, 228, 217, 227 );
}
add_filter( 'get_terms', function ( $terms, $taxonomies, $args ) {
	if ( is_admin() || ! in_array( 'category', (array) $taxonomies, true ) || ! empty( $args['fields'] ) && 'all' !== $args['fields'] || empty( $terms ) || ! ( reset( $terms ) instanceof WP_Term ) ) {
		return $terms;
	}
	if ( ! empty( $args['orderby'] ) && ! in_array( $args['orderby'], array( 'name', 'term_order', 'none' ), true ) ) {
		return $terms; // 글 수·ID 순 등 일부러 정한 순서는 그대로
	}
	$pos = array_flip( eb_cat_order() );
	usort( $terms, function ( $a, $b ) use ( $pos ) {
		$x = isset( $pos[ $a->term_id ] ) ? $pos[ $a->term_id ] : 999;
		$y = isset( $pos[ $b->term_id ] ) ? $pos[ $b->term_id ] : 999;
		return $x === $y ? strcmp( $a->name, $b->name ) : $x - $y;
	} );
	return $terms;
}, 10, 3 );

function eb_guide_list() {
	return array(
		array( '/guide/after-quit/', 'brief', '퇴사·실직했을 때', '퇴직금부터 실업급여까지', '퇴사·실직' ),
		array( '/guide/parents-65/', 'user', '부모님이 65세가 되면', '기초연금·검진·안전', '부모님 65세' ),
		array( '/guide/raising-kids/', 'heart', '아이를 키운다면', '매달 받는 돈·목돈', '아이 키우기' ),
		array( '/guide/closing-business/', 'home', '가게 문을 닫는다면', '폐업 신고·지원금', '가게 폐업' ),
		array( '/guide/hard-times/', 'phone', '생활이 갑자기 어려워졌다면', '긴급복지·기초생활·냉난방비', '생활이 어려울 때' ),
		array( '/guide/youth/', 'star', '청년이라면', '일자리·월세·목돈', '청년' ),
		array( '/guide/sick-or-injured/', 'pulse', '아프거나 다쳤다면', '산재·병원비·마음 상담', '아플 때' ),
		array( '/guide/moving-house/', 'pin', '집을 구하거나 이사한다면', '전월세 대출·전입신고', '이사할 때' ),
	);
}

function eb_find_situations() {
	return array(
		array( '부모님이 65세가 되면', 'parents-65', array( 'life' => '노년', 'hh' => array(), 'th' => array() ), '<circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 20.5a6.5 6.5 0 0 1 13 0"/>' ),
		array( '퇴사·실직했을 때', 'after-quit', array( 'life' => '', 'hh' => array(), 'th' => array( '일자리' ) ), '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7"/>' ),
		array( '아이를 키운다면', 'raising-kids', array( 'life' => '영유아', 'hh' => array(), 'th' => array( '보육' ) ), '<circle cx="8" cy="19" r="1.8"/><circle cx="17" cy="19" r="1.8"/><path d="M3 5h2.2l2 10h11l1.6-7H6.2"/>' ),
		array( '생활이 어려울 때', 'hard-times', array( 'life' => '', 'hh' => array( '저소득' ), 'th' => array( '생활지원' ) ), '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="3.5"/><path d="m14.5 9.5 3.5-3.5M9.5 14.5 6 18M14.5 14.5 18 18M9.5 9.5 6 6"/>' ),
		array( '청년이라면', 'youth', array( 'life' => '청년', 'hh' => array(), 'th' => array() ), '<path d="m12 3.5 2.6 5.3 5.8.8-4.2 4.1 1 5.8L12 16.8l-5.2 2.7 1-5.8-4.2-4.1 5.8-.8z"/>' ),
		array( '가게 문을 닫는다면', 'closing-business', array( 'life' => '', 'hh' => array(), 'th' => array( '사업·창업', '서민금융' ) ), '<path d="M3.5 9 5 4h14l1.5 5M4.5 9v11h15V9M3.5 9h17"/><path d="M9.5 20v-5.5h5V20"/>' ),
		array( '아프거나 다쳤다면', 'sick-or-injured', array( 'life' => '', 'hh' => array(), 'th' => array( '신체건강', '정신건강' ) ), '<path d="M3 12h4l2-5 4 10 2-5h6"/>' ),
		array( '집을 구하거나 이사할 때', 'moving-house', array( 'life' => '', 'hh' => array(), 'th' => array( '주거' ) ), '<path d="M3.5 11 12 4l8.5 7"/><path d="M5.5 9.5V20h13V9.5"/>' ),
	);
}

add_shortcode( 'eb_find_more', function () {
	$ic = function ( $p ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
	};
	$sits = eb_find_situations();
	$sh = '';
	foreach ( $sits as $s ) {
		$sh .= '<li class="f3__si"><button type="button" class="f3__sib" data-preset="' . esc_attr( wp_json_encode( $s[2] ) ) . '"><span class="f3__ic">' . $ic( $s[3] ) . '</span><span class="f3__st"><strong>' . esc_html( $s[0] ) . '</strong><small class="f3__n" aria-live="off"><em>…</em></small></span></button>'
			. '<a class="f3__guide" href="' . esc_url( home_url( '/guide/' . $s[1] . '/' ) ) . '">가이드<span class="screen-reader-text"> - ' . esc_html( $s[0] ) . '</span></a></li>';
	}
	$fields = array(
		array( 215, array( 216, 218 ), '<path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><circle cx="16" cy="9" r="2.9"/>' ),
		array( 219, array( 221, 220, 230, 222 ), '<path d="M3 12h4l2-5 4 10 2-5h6"/>' ),
		array( 223, array( 225, 224, 231 ), '<rect x="3" y="5.5" width="18" height="13" rx="2.5"/><path d="M3 10h18M7 15h3"/>' ),
		array( 226, array( 228, 217, 227 ), '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7M3 13h18"/>' ),
	);
	$fh = '';
	foreach ( $fields as $f ) {
		$term = get_term( $f[0], 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$n     = 0;
		$chips = '';
		foreach ( $f[1] as $cid ) {
			$c = get_term( $cid, 'category' );
			if ( ! $c || is_wp_error( $c ) || ! $c->count ) {
				continue;
			}
			$n     += (int) $c->count;
			$chips .= '<a href="' . esc_url( get_category_link( $c ) ) . '">' . esc_html( $c->name ) . '<span>' . (int) $c->count . '</span></a>';
		}
		$top = function_exists( 'eb_x_top_post' ) ? eb_x_top_post( $f[0] ) : 0;
		$fh .= '<li class="f3__ft"><a class="f3__fh" href="' . esc_url( get_category_link( $term ) ) . '"><span class="f3__ic">' . $ic( $f[2] ) . '</span><strong>' . esc_html( $term->name ) . '</strong><em>' . $n . '</em></a><div class="f3__fc">' . $chips . '</div>'
			. ( $top ? '<a class="f3__top" href="' . esc_url( get_permalink( $top ) ) . '"><b>많이 봄</b>' . esc_html( wp_trim_words( html_entity_decode( get_the_title( $top ), ENT_QUOTES, 'UTF-8' ), 6, '…' ) ) . '</a>' : '' ) . '</li>';
	}
	$search = '<form class="f3__q" action="' . esc_url( home_url( '/' ) ) . '" role="search"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input name="s" type="search" placeholder="제도·서류 이름으로 검색" aria-label="제도·서류 이름으로 검색"><button type="submit">검색</button></form>';
	return '<section class="f3" id="categories" aria-label="다른 방법으로 찾기"><div class="f3__card">'
		. '<div class="f3__head"><div class="f3__tabs" role="tablist" aria-label="찾는 방법"><button type="button" role="tab" id="f3-t1" aria-controls="f3-p1" aria-selected="true">상황별로</button><button type="button" role="tab" id="f3-t2" aria-controls="f3-p2" aria-selected="false" tabindex="-1">분야별로</button></div><p class="f3__hint" data-h1="누르면 위 조건에 바로 적용돼요" data-h2="분야별 정리 글 목록으로 이동해요">누르면 위 조건에 바로 적용돼요</p></div>'
		. '<div class="f3__pane" id="f3-p1" role="tabpanel" aria-labelledby="f3-t1"><ul class="f3__sit">' . $sh . '</ul></div>'
		. '<div class="f3__pane" id="f3-p2" role="tabpanel" aria-labelledby="f3-t2" hidden><ul class="f3__fld">' . $fh . '</ul></div>'
		. '</div><div class="f3__help"><strong>찾는 게 없나요?</strong>' . $search . '<div class="f3__links"><a href="tel:129"><b>129</b> <span class="f3__lg">보건복지</span>상담</a><a href="https://www.bokjiro.go.kr/" target="_blank" rel="noopener">복지로<span class="f3__lg"> 전체 서비스</span><span class="screen-reader-text">(새 창)</span> ↗</a><a href="' . esc_url( home_url( '/support/#topic' ) ) . '">주제 제안<span class="f3__lg">하기</span></a></div></div></section>';
} );

/* 58. 관리자 화면 콤팩트 (2026-10-09) -------------------------------------------------------------------------
 * 알림판: 맨 위 '한눈에 보기' 요약 줄 + 위젯 여백·글자 정리 / 글 목록: 전용 태그 3칸 → 알약 한 칸('태그 없음'은 빨강), 광고 칸 뺌, 제목 넓게 */
add_action( 'admin_notices', function () {
	$sc = get_current_screen();
	if ( ! $sc || 'dashboard' !== $sc->id || ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	$log  = (array) get_option( 'eb_search_log', array() );
	$zero = array();
	foreach ( $log as $q => $r ) {
		if ( 0 === (int) $r[1] && (int) $r[2] >= time() - 7 * DAY_IN_SECONDS ) {
			$zero[ $q ] = (int) $r[0];
		}
	}
	arsort( $zero );
	$cnt   = wp_count_posts( 'post' );
	$untag = get_posts( array( 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true, 'tax_query' => array( array( 'taxonomy' => 'eb_theme', 'operator' => 'NOT EXISTS' ) ) ) );
	// 제목에 시·도 이름이 있는데 '대상 지역' 태그가 없는 글(53-2번) - 전국 대상이면 그대로 두어도 됨
	$noreg = function_exists( 'eb_region_guess' ) ? array_values( array_filter( get_posts( array( 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true, 'tax_query' => array( array( 'taxonomy' => 'eb_region', 'operator' => 'NOT EXISTS' ) ) ) ), function ( $id ) {
		return '' !== eb_region_guess( html_entity_decode( get_the_title( $id ), ENT_QUOTES, 'UTF-8' ) );
	} ) ) : array();
	$nsvc  = count( (array) get_option( 'eb_ws_all', array() ) );
	$nloc  = count( (array) get_option( 'eb_ws_local', array() ) );
	$wat   = (int) get_option( 'eb_ws_synced' );
	$werr  = get_option( 'eb_ws_sync_err' ) || get_option( 'eb_ws_local_err' );
	$don   = count( (array) get_option( 'eb_donate_msgs', array() ) );
	$top   = count( (array) get_option( 'eb_topic_requests', array() ) );
	$cp    = '';
	if ( get_option( 'eb_cp_access' ) && function_exists( 'eb_cp_report' ) ) {
		$rep   = get_transient( 'eb_cp_report' );
		$money = is_array( $rep ) ? eb_cp_sum( isset( $rep['commission'] ) ? $rep['commission'] : null, 'commission' ) : null;
		$cp    = null === $money ? '-' : number_format_i18n( $money ) . '원';
	}
	$card = function ( $href, $label, $big, $sub, $warn = false ) {
		return '<a class="eb-sum__c' . ( $warn ? ' is-warn' : '' ) . '" href="' . esc_url( $href ) . '"><span class="eb-sum__l">' . esc_html( $label ) . '</span><b>' . wp_kses_post( $big ) . '</b><span class="eb-sum__s">' . wp_kses_post( $sub ) . '</span></a>';
	};
	$h  = '<div class="eb-sum" role="region" aria-label="한눈에 보기">';
	$h .= $card( '#eb_search_log', '정리 글 없던 검색어 · 7일', count( $zero ) . '<small>개</small>', $zero ? esc_html( implode( ', ', array_slice( array_keys( $zero ), 0, 3 ) ) ) : '없어요', (bool) $zero );
	$h .= $card( admin_url( 'edit.php' ), '글', (int) $cnt->publish . '<small>공개</small>', '임시 ' . (int) $cnt->draft . ' · <span class="' . ( $untag ? 'is-red' : '' ) . '">맞춤 태그 없음 ' . count( $untag ) . '</span>' . ( $noreg ? ' · <span class="is-red" title="제목에 지역 이름이 있는데 대상 지역 태그가 없는 글">지역 태그 확인 ' . count( $noreg ) . '</span>' : '' ), (bool) ( $untag || $noreg ) );
	$h .= $card( admin_url( 'options-general.php?page=eb-welfare-api' ), '복지서비스 데이터', number_format_i18n( $nsvc + $nloc ) . '<small>개</small>', $werr ? '<span class="is-red">최근 받기 실패</span>' : '중앙 ' . number_format_i18n( $nsvc ) . ' · 지역 ' . number_format_i18n( $nloc ) . ( $wat ? ' · ' . esc_html( wp_date( 'm.d H:i', $wat ) ) : '' ), (bool) $werr );
	$h .= $card( '#eb_topic_requests', '받은 메시지', ( $don + $top ) . '<small>개</small>', '후원 ' . $don . ' · 주제 제안 ' . $top );
	if ( $cp ) {
		$h .= $card( '#eb_cp_report', '쿠팡 수익 · 7일', esc_html( $cp ), '파트너스 실적' );
	}
	// 알림 자리(제목 위)에 찍히므로 제목 아래·위젯 바로 위로 옮김
	echo $h . '</div><script>document.addEventListener("DOMContentLoaded",function(){var s=document.querySelector(".eb-sum"),w=document.getElementById("dashboard-widgets-wrap");if(s&&w){w.parentNode.insertBefore(s,w);}});</script>'; // phpcs:ignore
} );

add_filter( 'manage_edit-post_columns', function ( $cols ) {
	$out = array();
	foreach ( $cols as $k => $v ) {
		if ( in_array( $k, array( 'taxonomy-eb_life', 'taxonomy-eb_hh', 'taxonomy-eb_theme', 'ad-status' ), true ) ) {
			continue;
		}
		$out[ $k ] = $v;
		if ( 'categories' === $k ) {
			$out['eb_tags'] = '맞춤 태그';
		}
	}
	return $out;
}, 99 );
add_action( 'manage_post_posts_custom_column', function ( $col, $id ) {
	if ( 'eb_tags' !== $col ) {
		return;
	}
	$h = '';
	foreach ( array( 'eb_life' => 'is-l', 'eb_hh' => 'is-h', 'eb_theme' => 'is-t' ) as $tax => $cls ) {
		$terms = get_the_terms( $id, $tax );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $tm ) {
				$h .= '<span class="eb-tagp ' . $cls . '">' . esc_html( $tm->name ) . '</span>';
			}
		}
	}
	echo $h ? $h : '<span class="eb-tagp is-none">태그 없음</span>'; // phpcs:ignore
}, 10, 2 );

add_action( 'admin_head', function () {
	$sc = get_current_screen();
	if ( ! $sc || ! in_array( $sc->id, array( 'dashboard', 'edit-post' ), true ) ) {
		return;
	}
	echo '<style id="eb-admin-compact">' . <<<'CSS'
.eb-sum{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px;margin:14px 0 6px}
.eb-sum__c{display:flex;flex-direction:column;gap:2px;min-width:0;padding:12px 14px;border:1px solid #dcdcde;border-radius:10px;background:#fff;color:#1d2327;text-decoration:none;transition:border-color .15s,box-shadow .15s}
.eb-sum__c:hover{border-color:#2271b1;box-shadow:0 2px 8px -4px rgba(0,0,0,.2);color:#1d2327}
.eb-sum__c.is-warn{border-left:3px solid #dba617}
.eb-sum__l{font-size:12px;color:#646970}
.eb-sum__c b{font-size:22px;font-weight:700;line-height:1.3;font-variant-numeric:tabular-nums}
.eb-sum__c b small{margin-left:3px;font-size:12px;font-weight:500;color:#646970}
.eb-sum__s{overflow:hidden;font-size:12px;color:#50575e;white-space:nowrap;text-overflow:ellipsis}
.eb-sum .is-red{color:#d63638;font-weight:600}
#dashboard-widgets .postbox .inside{margin-top:8px;padding:0 12px 12px}
#dashboard-widgets .postbox-header h2{font-size:13.5px}
#dashboard-widgets .inside p{margin:6px 0}
#dashboard-widgets .widefat td,#dashboard-widgets .widefat th{padding:5px 8px;font-size:12.5px;line-height:1.45}
.eb-dash-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.eb-dash-2 table{margin-bottom:0!important}
.eb-dash-h{margin:4px 0 6px!important;font-weight:600}
.eb-dash-h small{font-weight:400;color:#646970}
.eb-dash-2 th:nth-child(4),.eb-dash-2 td:nth-child(4){display:none}
.eb-dash-2 th:nth-child(2),.eb-dash-2 th:nth-child(3){width:40px!important}
.edit-php .column-rank_math_seo_details>label,.edit-php .column-rank_math_seo_details .schema-type,.edit-php .column-rank_math_seo_details .rank-math-link-count{display:none!important}
.edit-php .column-rank_math_seo_details .rank-math-column-display{display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.edit-php .column-rank_math_seo_details .rank-math-column-display>strong[title]{display:none}
.edit-php .column-rank_math_seo_details .seo-score strong{font-size:11.5px}
.edit-php .wp-list-table .column-wp-statistics-post-hits,.edit-php .wp-list-table .column-eb_fb{text-align:center}
.edit-php .wp-list-table .row-actions{font-size:12px}
#eb_donate_msgs .inside,#eb_topic_requests .inside{color:#646970}
.edit-php .wp-list-table td,.edit-php .wp-list-table th{padding:8px 10px;font-size:13px;line-height:1.5}
.edit-php .wp-list-table .column-title{width:36%}
.edit-php .wp-list-table .column-title strong{font-size:13.5px}
.edit-php .wp-list-table .column-categories{width:120px}
.edit-php .wp-list-table .column-eb_tags{width:200px}
.edit-php .wp-list-table .column-date{width:110px;font-size:12px;color:#50575e}
.edit-php .wp-list-table .column-wp-statistics-post-hits{width:64px}
.edit-php .wp-list-table .column-eb_fb{width:84px}
.edit-php .wp-list-table .column-rank_math_seo_details{width:140px;font-size:11.5px}
.edit-php .column-rank_math_seo_details .rank-math-column-display{margin:0 0 2px}
.eb-tagp{display:inline-block;margin:0 3px 3px 0;padding:1px 7px;border-radius:999px;font-size:11px;line-height:1.6;white-space:nowrap}
.eb-tagp.is-l{background:#eef3fb;color:#1d3c78}
.eb-tagp.is-h{background:#fff3e6;color:#b4570b}
.eb-tagp.is-t{background:#e4f6ef;color:#0b7a5a}
.eb-tagp.is-none{background:#fcf0f1;color:#d63638;font-weight:600}
@media (max-width:1400px){.eb-sum{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media (max-width:782px){.eb-sum{grid-template-columns:repeat(2,minmax(0,1fr))}.eb-dash-2{grid-template-columns:1fr}}
CSS
	. '</style>';
} );

/* 59. 휴대폰 빠른 맞춤 찾기 창 (2026-10-09, style.css 106번) ------------------------------------------------------------
 * 하단 탭 가운데 '맞춤 찾기'를 누르면(혜택 찾기 페이지 밖, 폭 768px 미만) 페이지 이동 없이 아래에서 올라오는 3단계 창: 시기 → 사는 곳 → 필요한 도움
 * 글·지역 목록은 창을 처음 열 때 /eb/v1/finder-data로 받아 옴(페이지 무게 그대로) · 결과 수와 맞추는 규칙은 55번과 같음
 * 고른 조건은 eb_finder_last(v2)에 저장(가구 상황은 건드리지 않음) → '결과 n개 모두 보기'는 혜택 찾기를 같은 조건으로 엶. 지난 조건이 있으면 3단계(미리보기)부터 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'eb/v1', '/finder-data', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			$res = new WP_REST_Response( array( 'posts' => eb_f2_posts(), 'regions' => function_exists( 'eb_ws_regions' ) ? eb_ws_regions() : array() ) );
			$res->header( 'Cache-Control', 'public, max-age=3600' );
			return $res;
		},
	) );
} );

add_action( 'wp_footer', function () {
	if ( is_page( 14851 ) || ! empty( $GLOBALS['eb_f2_used'] ) || ! function_exists( 'eb_tax_terms' ) ) {
		return;
	}
	$terms = eb_tax_terms();
	$ic    = eb_f2_life_icons();
	$life  = '';
	foreach ( $terms['eb_life'][1] as $slug => $name ) {
		$life .= '<button type="button" class="ebq__tile" data-v="' . esc_attr( $name ) . '" aria-pressed="false"><i>' . eb_f2_icon( isset( $ic[ $slug ] ) ? $ic[ $slug ] : '' ) . '</i><span>' . esc_html( $name ) . '</span></button>';
	}
	$chips = function ( $list ) {
		$h = '';
		foreach ( $list as $name ) {
			$h .= '<button type="button" class="ebq__chip" data-v="' . esc_attr( $name ) . '" aria-pressed="false">' . esc_html( $name ) . '</button>';
		}
		return $h;
	};
	list( $th_top, $th_rest ) = eb_f2_themes( $terms );
	$sd_opts = '';
	foreach ( array_keys( function_exists( 'eb_ws_regions' ) ? eb_ws_regions() : array() ) as $sd ) {
		$sd_opts .= '<option value="' . esc_attr( $sd ) . '">' . esc_html( $sd ) . '</option>';
	}
	$data = array( 'data' => rest_url( 'eb/v1/finder-data' ), 'api' => rest_url( 'eb/v1/services' ), 'lapi' => rest_url( 'eb/v1/local' ), 'find' => home_url( '/find/' ) );
	$svg  = function ( $d, $w = '2' ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $w . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' . $d . '"/></svg>';
	};
	echo '<div class="ebq" data-set="' . esc_attr( wp_json_encode( $data ) ) . '" hidden><div class="ebq__dim"></div>'
		. '<div class="ebq__sh" role="dialog" aria-modal="true" aria-labelledby="ebq-t" tabindex="-1">'
		. '<div class="ebq__top"><span class="ebq__grab" aria-hidden="true"></span><div class="ebq__hd">'
		. '<button type="button" class="ebq__back" aria-label="이전 단계" hidden>' . $svg( 'M15 5l-7 7 7 7' ) . '</button>'
		. '<i class="ebq__ic">' . eb_x_ic( 'compass' ) . '</i><strong id="ebq-t">내게 맞는 혜택 찾기</strong>'
		. '<button type="button" class="ebq__x" aria-label="닫기">' . $svg( 'M6 6l12 12M18 6 6 18' ) . '</button></div>'
		. '<div class="ebq__prog" aria-hidden="true"><i></i><i></i><i></i></div></div>'
		. '<div class="ebq__body">'
		. '<section class="ebq__st" data-s="1"><h3 class="ebq__q">지금 어느 시기인가요?<small>하나만</small></h3><div class="ebq__life" role="group" aria-label="생애주기">' . $life . '</div></section>'
		. '<section class="ebq__st" data-s="2" hidden><h3 class="ebq__q">어디에 사세요?<small>지역 서비스까지 찾아요</small></h3><div class="ebq__rg">'
		. '<label><span class="screen-reader-text">시·도</span><select class="ebq__sd"><option value="">시·도 선택</option>' . $sd_opts . '</select></label>'
		. '<label><span class="screen-reader-text">시·군·구</span><select class="ebq__sg" disabled><option value="">시·군·구</option></select></label></div>'
		. '<p class="ebq__hint">한 번 고르면 다음에도 기억해요</p></section>'
		. '<section class="ebq__st" data-s="3" hidden><h3 class="ebq__q">어떤 도움이 필요하세요?<small>여러 개</small></h3><div class="ebq__chips" role="group" aria-label="필요한 도움">' . $chips( $th_top )
		. '<span class="ebq__thx" hidden>' . $chips( $th_rest ) . '</span><button type="button" class="ebq__more" aria-expanded="false">+' . count( $th_rest ) . '개 더 보기</button></div>'
		. '<div class="ebq__peek" aria-live="polite"></div></section>'
		. '</div>'
		. '<div class="ebq__ft"><p class="ebq__n"><span>지금까지</span><b>—</b></p><button type="button" class="ebq__skip">건너뛰기</button>'
		. '<button type="button" class="ebq__next">다음' . $svg( 'M5 12h14M13 6l6 6-6 6', '2.2' ) . '</button><a class="ebq__go" href="' . esc_url( home_url( '/find/#finder' ) ) . '" hidden>혜택 찾기에서 보기</a></div>'
		. '</div></div>';
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var Q = document.querySelector('.ebq'), tab = document.querySelector('.ebt .ebt__main');
	if (!Q || !tab) { return; }
	var D = {};
	try { D = JSON.parse(Q.getAttribute('data-set')) || {}; } catch (e) {}
	var sh = Q.querySelector('.ebq__sh'), nb = Q.querySelector('.ebq__n b'), nl = Q.querySelector('.ebq__n span');
	var next = Q.querySelector('.ebq__next'), skip = Q.querySelector('.ebq__skip'), go = Q.querySelector('.ebq__go'), back = Q.querySelector('.ebq__back');
	var sdSel = Q.querySelector('.ebq__sd'), sgSel = Q.querySelector('.ebq__sg'), peek = Q.querySelector('.ebq__peek'), body = Q.querySelector('.ebq__body');
	var S = { life: '', hh: [], th: [], sd: '', sg: '' }, step = 1, posts = null, regions = null, svc = null, loc = {}, locKey = '', locFail = false, busy = false, dirty = false, pushed = false;
	var esc = function (s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
	var has = function (a, v) { return a && a.indexOf(v) > -1; };
	var anyC = function () { return !!(S.life || S.hh.length || S.th.length); };
	var any = function () { return anyC() || !!S.sd; };
	var rlab = function () { return S.sd ? S.sd.replace(/(특별자치시|특별자치도|특별시|광역시)$/, '').replace(/도$/, function (m, i, s) { return s.length > 3 ? '' : m; }) + (S.sg ? ' ' + S.sg : '') : ''; };
	// 55번 match()와 같은 규칙(기본: 고른 시기와 다른 시기만 대상이면 빼고, 겹칠수록 위로)
	var match = function (l, h, t) {
		if (S.life && l.length && !has(l, S.life)) { return null; }
		var why = [];
		if (S.life && has(l, S.life)) { why.push(S.life); }
		S.hh.forEach(function (v) { if (has(h, v)) { why.push(v); } });
		S.th.forEach(function (v) { if (has(t, v)) { why.push(v); } });
		return why.length ? why : null;
	};
	// 미리보기 순서: 겹치는 조건 수 → 많이 본 글 → 대상 시기가 좁은 것(고른 시기 전용 서비스가 먼저) → 이름
	var rank = function (list) { return list.sort(function (a, b) { return ((a.pr || 0) - (b.pr || 0)) || (b.why.length - a.why.length) || ((b.x.p || 0) - (a.x.p || 0)) || (((a.x.l || []).length || 9) - ((b.x.l || []).length || 9)) || a.k.localeCompare(b.k, 'ko'); }); };
	var fillSg = function () {
		var sgs = S.sd && regions && regions[S.sd] ? Object.keys(regions[S.sd]).filter(Boolean) : [];
		sgSel.innerHTML = '<option value="">' + (S.sd ? '시·군·구 전체' : '시·군·구') + '</option>' + sgs.map(function (g) { return '<option value="' + esc(g) + '">' + esc(g) + '</option>'; }).join('');
		sgSel.disabled = !sgs.length;
		sgSel.value = S.sg;
		sdSel.value = S.sd;
	};
	var loadLocal = function () {
		if (!S.sd) { return; }
		var k = S.sd + '|' + S.sg;
		if (loc[k] || locKey === k) { return; }
		locKey = k; locFail = false;
		fetch(D.lapi + (D.lapi.indexOf('?') > -1 ? '&' : '?') + 'sd=' + encodeURIComponent(S.sd) + '&sg=' + encodeURIComponent(S.sg), { credentials: 'same-origin' })
			.then(function (r) { return r.json(); }).then(function (j) { loc[k] = (j && j.items) || []; calc(); })
			.catch(function () { locFail = true; calc(); });
	};
	var load = function () {
		if (busy) { return; }
		busy = true;
		fetch(D.data, { credentials: 'same-origin' }).then(function (r) { return r.json(); })
			.then(function (j) { posts = (j && j.posts) || []; regions = (j && j.regions) || {}; fillSg(); calc(); })
			.catch(function () { posts = []; regions = {}; calc(); });
		fetch(D.api, { credentials: 'same-origin' }).then(function (r) { return r.json(); })
			.then(function (j) { svc = (j && j.items) || []; calc(); })
			.catch(function () { svc = []; calc(); });
	};
	var url = function () {
		var p = new URLSearchParams();
		if (S.life) { p.set('life', S.life); }
		if (S.hh.length) { p.set('hh', S.hh.join(',')); }
		if (S.th.length) { p.set('th', S.th.join(',')); }
		if (S.sd) { p.set('sd', S.sd); }
		if (S.sg) { p.set('sg', S.sg); }
		var qs = p.toString();
		return D.find + (qs ? '?' + qs : '') + '#finder';
	};
	var calc = function () {
		var P = [], G = [], LM = [], LA = S.sd ? loc[S.sd + '|' + S.sg] : null;
		if (anyC()) {
			(posts || []).forEach(function (x) { var w = match(x.l || [], x.h || [], x.th || []), rg = x.r || []; if (!w || (rg.length && S.sd && rg.indexOf(S.sd) < 0)) { return; } P.push({ x: x, why: w, k: x.t, b: 'p', pr: rg.length ? (S.sd ? -1 : 1) : 0 }); }); // 대상 지역(53-2번)
			(svc || []).forEach(function (x) { var w = match(x.l || [], x.h || [], x.t || []); if (w) { G.push({ x: x, why: w, k: x.n, b: 'g' }); } });
		}
		(LA || []).forEach(function (x) { var w = anyC() ? match(x.l || [], x.h || [], x.t || []) : []; if (w) { LM.push({ x: x, why: w, k: x.n, b: 'l' }); } });
		rank(P); rank(G); rank(LM);
		var total = P.length + G.length + LM.length, ready = !!(posts && svc && (!S.sd || LA || locFail));
		nb.innerHTML = !any() ? '—' : (ready ? total + '<small>개</small>' : (posts ? total + '<small>개+</small>' : '…'));
		nl.textContent = step === 3 ? '모두' : '지금까지';
		go.textContent = any() && ready && total ? '결과 ' + total + '개 모두 보기' : '혜택 찾기에서 보기';
		go.href = url();
		// 미리보기: 우리 지역 · 정부 · 정리 글 하나씩 먼저, 모자라면 나머지에서
		if (step === 3) {
			var pick = [LM[0], G[0], P[0]].filter(Boolean), rest = LM.slice(1, 3).concat(G.slice(1, 3), P.slice(1, 3));
			while (pick.length < 3 && rest.length) { pick.push(rest.shift()); }
			var lab = { l: ['is-l', '우리 지역'], g: ['is-g', '정부'], p: ['is-p', '정리 글'] };
			if (!any()) {
				peek.innerHTML = '';
			} else if (!ready && !pick.length) {
				peek.innerHTML = '<p class="ebq__pl">미리 보기</p>' + [1, 2, 3].map(function () { return '<div class="ebq__sk"><i></i><i></i></div>'; }).join('');
			} else if (!pick.length) {
				peek.innerHTML = '<p class="ebq__none">이 조건에 딱 맞는 결과가 아직 없어요. 조건을 하나 줄여 보세요.</p>';
			} else {
				peek.innerHTML = '<p class="ebq__pl">미리 보기</p>' + pick.map(function (o) {
					var ext = o.b !== 'p';
					return '<a class="ebq__pi" href="' + esc(o.x.u) + '"' + (ext ? ' target="_blank" rel="noopener"' : '') + '><span class="ebq__b ' + lab[o.b][0] + '">' + lab[o.b][1] + '</span><span class="ebq__pt">' + esc(o.k) + '</span>' + (ext ? '<span class="screen-reader-text">(새 창)</span>' : '') + '</a>';
				}).join('');
			}
		}
		if (dirty && ready) {
			dirty = false;
			try {
				if (any()) { localStorage.setItem('eb_finder_last', JSON.stringify({ v: 2, life: S.life, hh: S.hh, th: S.th, sd: S.sd, sg: S.sg, l: (S.life ? [S.life] : []).concat(S.hh, S.th, S.sd ? [rlab()] : []), n: total, at: Date.now() })); } else { localStorage.removeItem('eb_finder_last'); }
			} catch (e) {}
		}
	};
	var paint = function () {
		Q.querySelectorAll('.ebq__tile').forEach(function (b) { b.setAttribute('aria-pressed', S.life === b.getAttribute('data-v') ? 'true' : 'false'); });
		Q.querySelectorAll('.ebq__chip').forEach(function (b) { b.setAttribute('aria-pressed', has(S.th, b.getAttribute('data-v')) ? 'true' : 'false'); });
		var thx = Q.querySelector('.ebq__thx'), more = Q.querySelector('.ebq__more');
		if (thx.hidden && thx.querySelector('[aria-pressed="true"]')) { thx.hidden = false; more.setAttribute('aria-expanded', 'true'); more.textContent = '접기'; }
		skip.hidden = step === 3 || (step === 1 ? !!S.life : !!S.sd);
	};
	var show = function (s) {
		step = s;
		Q.querySelectorAll('.ebq__st').forEach(function (x) { x.hidden = +x.getAttribute('data-s') !== s; });
		Q.querySelectorAll('.ebq__prog i').forEach(function (x, i) { x.classList.toggle('on', i < s); });
		back.hidden = s === 1;
		next.hidden = s === 3;
		go.hidden = s !== 3;
		body.scrollTop = 0;
		paint(); calc();
	};
	var change = function () { dirty = true; paint(); calc(); };
	var open = function () {
		try { var L = JSON.parse(localStorage.getItem('eb_finder_last') || 'null'); if (L && L.v === 2) { S = { life: L.life || '', hh: L.hh || [], th: L.th || [], sd: L.sd || '', sg: L.sg || '' }; } } catch (e) {}
		load(); fillSg(); loadLocal();
		show(S.life || S.th.length || S.sd ? 3 : 1);
		Q.hidden = false;
		sh.style.transform = '';
		window.requestAnimationFrame(function () { window.requestAnimationFrame(function () { Q.classList.add('is-in'); }); });
		document.documentElement.classList.add('ebq-open');
		sh.focus({ preventScroll: true });
		if (window.history && history.pushState && !pushed) { history.pushState({ ebq: 1 }, ''); pushed = true; }
	};
	var close = function (fromPop) {
		if (Q.hidden) { return; }
		Q.classList.remove('is-in');
		sh.style.transform = '';
		document.documentElement.classList.remove('ebq-open');
		setTimeout(function () { if (!Q.classList.contains('is-in')) { Q.hidden = true; } }, 260);
		if (pushed && !fromPop) { pushed = false; history.back(); }
		pushed = false;
		tab.focus({ preventScroll: true });
	};
	window.addEventListener('popstate', function () { if (!Q.hidden) { pushed = false; close(true); } });
	tab.addEventListener('touchstart', load, { passive: true }); // 손가락이 닿을 때 미리 받기 시작
	tab.addEventListener('click', function (e) {
		if (window.innerWidth >= 768 || e.ctrlKey || e.metaKey || e.shiftKey) { return; }
		e.preventDefault();
		open();
	});
	Q.addEventListener('click', function (e) {
		if (e.target.classList.contains('ebq__dim')) { close(); return; }
		var b = e.target.closest('button');
		if (!b) { return; }
		if (b.classList.contains('ebq__x')) { close(); return; }
		if (b.classList.contains('ebq__back')) { show(step - 1); return; }
		if (b.classList.contains('ebq__next') || b.classList.contains('ebq__skip')) { show(Math.min(3, step + 1)); return; }
		if (b.classList.contains('ebq__tile')) {
			var v = b.getAttribute('data-v');
			S.life = S.life === v ? '' : v;
			change();
			if (S.life) { setTimeout(function () { if (step === 1) { show(2); } }, 220); }
			return;
		}
		if (b.classList.contains('ebq__chip')) {
			var c = b.getAttribute('data-v'), i = S.th.indexOf(c);
			if (i > -1) { S.th.splice(i, 1); } else { S.th.push(c); }
			change(); return;
		}
		if (b.classList.contains('ebq__more')) {
			var x = Q.querySelector('.ebq__thx'), o = x.hidden;
			x.hidden = !o; b.setAttribute('aria-expanded', o ? 'true' : 'false');
			b.textContent = o ? '접기' : '+' + x.querySelectorAll('.ebq__chip').length + '개 더 보기';
		}
	});
	sdSel.addEventListener('change', function () { S.sd = sdSel.value; S.sg = ''; fillSg(); loadLocal(); change(); });
	sgSel.addEventListener('change', function () { S.sg = sgSel.value; loadLocal(); change(); if (S.sg) { setTimeout(function () { if (step === 2) { show(3); } }, 220); } });
	go.addEventListener('click', function () { dirty = true; calc(); });
	// Esc로 닫기 · Tab은 창 안에서만 돎
	document.addEventListener('keydown', function (e) {
		if (Q.hidden) { return; }
		if (e.key === 'Escape') { close(); return; }
		if (e.key !== 'Tab') { return; }
		var f = [].slice.call(sh.querySelectorAll('button, a[href], select')).filter(function (el) { return !el.disabled && el.offsetParent !== null; });
		if (!f.length) { return; }
		if (e.shiftKey && (document.activeElement === f[0] || document.activeElement === sh)) { e.preventDefault(); f[f.length - 1].focus(); } else if (!e.shiftKey && document.activeElement === f[f.length - 1]) { e.preventDefault(); f[0].focus(); }
	});
	// 위쪽 손잡이를 아래로 끌어내리면 닫힘
	var top = Q.querySelector('.ebq__top'), y0 = null, dy = 0;
	top.addEventListener('touchstart', function (e) { if (e.target.closest('button')) { return; } y0 = e.touches[0].clientY; dy = 0; sh.style.transition = 'none'; }, { passive: true });
	top.addEventListener('touchmove', function (e) { if (y0 === null) { return; } dy = Math.max(0, e.touches[0].clientY - y0); sh.style.transform = 'translateY(' + dy + 'px)'; }, { passive: true });
	top.addEventListener('touchend', function () {
		if (y0 === null) { return; }
		y0 = null; sh.style.transition = '';
		if (dy > 80) { close(); } else { sh.style.transform = ''; }
	});
})();
JS
	. "\n</script>\n";
}, 31 );

/* 60. 글 페이지 손질 (2026-10-10, style.css 131번) ---------------------------------------------------------
 * 휴대폰 하단 탭바: 글 페이지에서 아래로 읽는 동안 숨기고(html.eb-tabhide), 위로 올리거나 맨 위·글 끝에선 다시 보임.
 * 검색 창·옆 메뉴가 열려 있을 땐 건드리지 않음.
 */
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var H = document.documentElement, mq = window.matchMedia('(max-width: 767px)'), last = window.scrollY, tick = false;
	function busy() {
		return H.classList.contains('ebt-s-open') || H.classList.contains('ebm-open'); // 검색 창·전체 메뉴(68번)가 열려 있을 때
	}
	function update() {
		tick = false;
		var y = window.scrollY, d = y - last, end = y + window.innerHeight >= H.scrollHeight - 80;
		if (!mq.matches || busy() || y < 120 || end) { H.classList.remove('eb-tabhide'); }
		else if (d > 6) { H.classList.add('eb-tabhide'); }
		else if (d < -6) { H.classList.remove('eb-tabhide'); }
		if (Math.abs(d) > 6) { last = y; }
	}
	window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(update); } }, { passive: true });
	document.addEventListener('focusin', function (e) { if (e.target.closest && e.target.closest('.ebt')) { H.classList.remove('eb-tabhide'); } });
})();
JS
	. "\n</script>\n";
}, 99 );

/* 61. 글 페이지 2차 - 시안 확정분 (2026-10-10, style.css 132번) ---------------------------------------------
 * ① 글 아래 순서: 안내 카드(글쓴이 한 줄 + 면책 접기) → 도움·공유 → 도구 → 관련 글 → 광고.
 *    Elements(관련 글·글쓴이·안내)·15-2·13-2·31번이 따로 내보내는 상자를 화면에서 한 번 옮김
 * ② 댓글이 아직 없으면 입력창을 '댓글 남기기' 버튼 하나로 접음
 * ③ PC(900px 이상) 본문 목차 A안: 한 줄로 접고 '펼치기'
 * ④ PC 사이드바 따라오는 목차(38번) 아래 맨 위로 · 저장 · 링크 복사
 * ⑤ 휴대폰·작은 태블릿 미니 헤더 + 목차 창 (저장은 19번 글 도구 버튼을 대신 누름, 공유는 기본 공유창 → 안 되면 링크 복사)
 */
add_action( 'wp_footer', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var H = document.documentElement, art = document.querySelector('body.single-post article .inside-article');
	var body = art && art.querySelector('.entry-content');
	if (!body) { return; }
	var IC = {
		list: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13M3.5 6h.01M3.5 12h.01M3.5 18h.01"/></svg>',
		x: '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>',
		up: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>',
		star: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.9l-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/></svg>',
		share: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M16 6l-4-4-4 4M12 2v13"/></svg>',
		down: '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>',
		cmt: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h16v11H9l-5 4z"/></svg>'
	};
	var calm = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
	var url = (document.querySelector('link[rel=canonical]') || {}).href || location.origin + location.pathname;
	var h1 = document.querySelector('.entry-title'), title = h1 ? h1.textContent.trim() : document.title;

	// 저장(19번 글 도구 버튼을 대신 누름) · 공유(휴대폰 기본 공유창, 안 되면 링크 복사)
	var saveSrc = document.querySelector('.eb-tools__save');
	function bindSave(b) {
		if (!saveSrc) { b.hidden = true; return; }
		var lab = b.querySelector('span');
		var paint = function () { var on = saveSrc.getAttribute('aria-pressed') === 'true'; b.setAttribute('aria-pressed', on ? 'true' : 'false'); if (lab) { lab.textContent = on ? '저장됨' : '저장'; } };
		b.addEventListener('click', function () { saveSrc.click(); setTimeout(paint, 30); });
		new MutationObserver(paint).observe(saveSrc, { attributes: true, attributeFilter: ['aria-pressed'] });
		paint();
	}
	function flash(b, text) {
		var lab = b.querySelector('span') || b, old = lab.textContent;
		lab.textContent = text;
		setTimeout(function () { lab.textContent = old; }, 1800);
	}
	var toastEl = null, toastTm = null;
	function toast(text) {
		if (!toastEl) { toastEl = document.createElement('div'); toastEl.className = 'eb-toast'; toastEl.setAttribute('role', 'status'); document.body.appendChild(toastEl); }
		toastEl.textContent = text;
		toastEl.hidden = false;
		clearTimeout(toastTm);
		toastTm = setTimeout(function () { toastEl.hidden = true; }, 1800);
	}
	function copy(b) {
		var ok = function () { flash(b, '복사했어요'); toast('링크를 복사했어요'); };
		if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(url).then(ok, function () { prompt('이 주소를 복사해 주세요', url); }); }
		else { prompt('이 주소를 복사해 주세요', url); }
	}
	function share(b) {
		if (navigator.share) { navigator.share({ title: title, url: url }).catch(function () {}); } else { copy(b); }
	}

	// 소제목 목록(미니 헤더·목차 창 공용). 38번 사이드바 목차와 같은 규칙
	var hs = [].filter.call(body.querySelectorAll('h2, h3'), function (h) {
		return h.textContent.trim() && h.textContent.trim() !== '목차' && !h.closest('.tocer-toc, aside, .eb-postcalc');
	});
	hs.forEach(function (h, i) { if (!h.id) { h.id = 'eb-h-' + (i + 1); } });
	var isTop = hs.map(function (h) { return h.tagName === 'H2'; }), total = isTop.filter(Boolean).length;
	var mins = Math.max(1, Math.round((body.innerText || '').replace(/\s+/g, '').length / 500));

	/* ① 글 아래 순서: 안내 카드(글쓴이 한 줄 + 면책) → 도움·공유 → 도구 → 관련 글 → 광고 (댓글은 그다음) */
	(function () {
		var au = art.querySelector('.eb-author'), no = art.querySelector('.eb-notice');
		var trust = document.createElement('section');
		trust.className = 'eb-trust';
		trust.setAttribute('aria-label', '글 정보와 안내');
		if (au) {
			var facts = [].map.call(au.querySelectorAll('.eb-author__facts li'), function (li) { return li.textContent.trim(); });
			var t = document.querySelector('.entry-meta time.updated') || document.querySelector('.entry-meta time');
			var date = t ? (t.getAttribute('datetime') || '').slice(0, 10).replace(/-/g, '.') : '';
			var line = document.createElement('p');
			line.className = 'eb-author__line';
			line.innerHTML = (date ? '<span class="eb-author__date">' + date + ' 수정</span>' : '') + '<span class="eb-author__facts2">' + facts.join(' · ').replace(/[<>&]/g, '') + '</span>';
			var head = au.querySelector('.eb-author__head');
			if (head) { head.insertAdjacentElement('afterend', line); }
			var more = au.querySelector('.eb-author__more');
			if (more) { more.innerHTML = '소개<span class="eb-author__more-l"> 보기</span> ›'; }
			trust.appendChild(au);
		}
		if (no) {
			var ps = [].slice.call(no.querySelectorAll('p'), 1);
			if (ps.length) {
				ps.forEach(function (p) { p.hidden = true; });
				var tg = document.createElement('button');
				tg.type = 'button';
				tg.className = 'eb-notice__tg';
				tg.setAttribute('aria-expanded', 'false');
				tg.textContent = '면책 안내 전체 보기';
				tg.addEventListener('click', function () {
					var open = tg.getAttribute('aria-expanded') !== 'true';
					ps.forEach(function (p) { p.hidden = !open; });
					tg.setAttribute('aria-expanded', open ? 'true' : 'false');
					tg.textContent = open ? '면책 안내 접기' : '면책 안내 전체 보기';
				});
				no.appendChild(tg);
			}
			trust.appendChild(no);
		}
		var at = body;
		[trust.children.length ? trust : null, art.querySelector('.eb-feedback'), art.querySelector('.eb-postcalc'), art.querySelector('.eb-related'), art.querySelector('.eb-ad-post')].forEach(function (el) {
			if (el) { at.insertAdjacentElement('afterend', el); at = el; }
		});
	})();

	/* ② 댓글 입력창은 모든 화면에서 열어 둠 (2026-10-10 요청, 접는 버튼 뺌) */

	/* ③ PC 본문 목차 A안: 한 줄로 접어 두고 '펼치기' (900px 이상에서만 보이는 버튼, style.css 132번 ③)
	 * Tocer가 불러온 뒤·화면 폭이 바뀔 때 목차를 다시 그리므로, 버튼이 없어지면 다시 붙임 */
	(function () {
		var wrap = body.querySelector('.tocer');
		if (!wrap) { return; }
		var label = function (b) {
			var open = wrap.classList.contains('eb-toc-unfold');
			b.setAttribute('aria-expanded', open ? 'true' : 'false');
			b.innerHTML = (open ? '접기' : '펼치기') + IC.down;
		};
		var deco = function () {
			[].forEach.call(wrap.querySelectorAll('.tocer-toc'), function (nav, k) {
				var head = nav.querySelector('.tocer-header'), list = nav.querySelector('.tocer-list.tocer-lvl1');
				if (!head || !list || head.querySelector('.eb-toc-tg')) { return; }
				var tops = [].filter.call(list.children, function (li) { return li.tagName === 'LI'; }).map(function (li) { var a = li.querySelector('a'); return a ? a.textContent.trim() : ''; });
				var peek = document.createElement('span');
				peek.className = 'eb-toc-peek';
				peek.setAttribute('aria-hidden', 'true');
				peek.textContent = tops.join(' · ');
				if (!list.id) { list.id = 'eb-toc-list-' + (k + 1); }
				var b = document.createElement('button');
				b.type = 'button';
				b.className = 'eb-toc-tg';
				b.setAttribute('aria-controls', list.id);
				label(b);
				b.addEventListener('click', function () {
					wrap.classList.toggle('eb-toc-unfold');
					[].forEach.call(wrap.querySelectorAll('.eb-toc-tg'), label);
				});
				head.appendChild(peek);
				head.appendChild(b);
			});
		};
		wrap.classList.add('eb-toc-fold');
		deco();
		new MutationObserver(deco).observe(wrap, { childList: true, subtree: true });
	})();

	/* ⑥ 제목 아래 메타 한 줄: '약 n분' + 저장 옆 공유 아이콘 (style.css 133번 ⑦) */
	(function () {
		var meta = document.querySelector('.entry-header .entry-meta');
		if (!meta) { return; }
		var tools = meta.querySelector('.eb-tools'), rt = document.createElement('span');
		rt.className = 'eb-readtime';
		rt.textContent = '약 ' + mins + '분';
		meta.insertBefore(rt, tools || null);
		if (!tools) { return; }
		if (saveSrc) { saveSrc.title = '저장'; }
		var sb = document.createElement('button');
		sb.type = 'button';
		sb.className = 'eb-tools__share';
		sb.title = '공유';
		sb.innerHTML = IC.share + '<span>공유</span>';
		sb.addEventListener('click', function () { share(sb); });
		tools.appendChild(sb);
	})();

	/* ④ PC 사이드바 따라오는 목차 아래: 맨 위로 · 저장 · 링크 복사 */
	(function () {
		var top = document.querySelector('.eb-mtoc__top');
		if (!top) { return; }
		var foot = document.createElement('div');
		foot.className = 'eb-mtoc__foot';
		top.parentNode.insertBefore(foot, top);
		top.innerHTML = '<span>↑ 맨 위로</span>';
		foot.appendChild(top);
		var sv = document.createElement('button');
		sv.type = 'button';
		sv.innerHTML = '<span>저장</span>';
		foot.appendChild(sv);
		bindSave(sv);
		var cp = document.createElement('button');
		cp.type = 'button';
		cp.innerHTML = '<span>링크 복사</span>';
		cp.addEventListener('click', function () { copy(cp); });
		foot.appendChild(cp);
	})();

	/* ⑦ 가로로 넘치는 표 아래 '옆으로 밀어서 보기 →' (style.css 135번), 한 번 밀면 사라짐 */
	[].forEach.call(body.querySelectorAll('.eb-tscroll, .wp-block-table'), function (box) {
		if (box.querySelector('.eb-tscroll') || getComputedStyle(box).overflowX === 'visible') { return; }
		var hint = document.createElement('p');
		hint.className = 'eb-tscroll-hint';
		hint.setAttribute('aria-hidden', 'true');
		hint.textContent = '옆으로 밀어서 보기 →';
		box.insertAdjacentElement('afterend', hint);
		var check = function () { hint.hidden = box.scrollWidth <= box.clientWidth + 2 || box.scrollLeft > 8; };
		box.addEventListener('scroll', check, { passive: true });
		window.addEventListener('resize', check);
		check();
	});

	/* ⑤ 휴대폰·작은 태블릿(899px 이하) 미니 헤더 + 목차 창 */
	if (hs.length < 2) { return; }
	var mq = window.matchMedia('(max-width: 899px)');
	var mini = document.createElement('div');
	mini.className = 'eb-mini';
	mini.innerHTML = '<span class="eb-mini__n"></span><span class="eb-mini__t"></span>'
		+ '<button type="button" class="eb-mini__btn" aria-haspopup="dialog" aria-expanded="false" aria-label="이 글의 목차 열기">' + IC.list + '<span>목차</span></button>'
		+ '<span class="eb-mini__bar" aria-hidden="true"><i></i></span>';
	document.body.appendChild(mini);
	var mN = mini.querySelector('.eb-mini__n'), mT = mini.querySelector('.eb-mini__t'), mB = mini.querySelector('.eb-mini__bar i'), open = mini.querySelector('.eb-mini__btn');

	var sh = document.createElement('div');
	sh.className = 'eb-tsheet';
	sh.hidden = true;
	sh.setAttribute('role', 'dialog');
	sh.setAttribute('aria-modal', 'true');
	sh.setAttribute('aria-labelledby', 'eb-tsheet-t');
	var n2 = 0;
	sh.innerHTML = '<div class="eb-tsheet__dim"></div><section class="eb-tsheet__box"><div class="eb-tsheet__grip" aria-hidden="true"></div>'
		+ '<div class="eb-tsheet__head"><strong id="eb-tsheet-t">이 글의 순서</strong><span>' + total + '개 · 약 ' + mins + '분</span><button type="button" class="eb-tsheet__x" aria-label="목차 닫기">' + IC.x + '</button></div>'
		+ '<ol class="eb-tsheet__list">' + hs.map(function (h) {
			var top = h.tagName === 'H2';
			if (top) { n2++; }
			return '<li class="' + (top ? '' : 'is-sub') + '"><a href="#' + h.id + '">' + (top ? '<b>' + n2 + '</b>' : '') + '<span></span></a></li>';
		}).join('') + '</ol>'
		+ '<div class="eb-tsheet__foot"><button type="button" data-act="top">' + IC.up + '<span>맨 위로</span></button><button type="button" data-act="save">' + IC.star + '<span>저장</span></button><button type="button" data-act="share" class="is-pri">' + IC.share + '<span>공유</span></button></div></section>';
	document.body.appendChild(sh);
	var items = sh.querySelectorAll('.eb-tsheet__list li');
	[].forEach.call(items, function (li, i) { li.querySelector('span').textContent = hs[i].textContent.trim().replace(/\s+/g, ' '); });
	bindSave(sh.querySelector('[data-act=save]'));
	sh.querySelector('[data-act=share]').addEventListener('click', function () { share(this); });
	sh.querySelector('[data-act=top]').addEventListener('click', function () { close(); window.scrollTo({ top: 0, behavior: calm }); });

	var cur = -1, tick = false;
	function update() {
		tick = false;
		var on = mq.matches && h1 && h1.getBoundingClientRect().bottom < 0;
		mini.classList.toggle('is-on', !!on);
		H.classList.toggle('eb-mini-on', !!on);
		var r = body.getBoundingClientRect(), all = r.height - window.innerHeight * 0.6;
		mB.style.transform = 'scaleX(' + (all > 0 ? Math.min(1, Math.max(0, -r.top / all)) : 1) + ')';
		var n = 0;
		hs.forEach(function (h, i) { if (h.getBoundingClientRect().top < 90) { n = i; } });
		if (n === cur) { return; }
		cur = n;
		var k = 0, t = n;
		for (var j = 0; j <= n; j++) { if (isTop[j]) { k++; } }
		while (t > 0 && !isTop[t]) { t--; }
		mN.textContent = Math.max(1, k) + ' / ' + total;
		mT.textContent = hs[t].textContent.trim().replace(/\s+/g, ' ');
		[].forEach.call(items, function (li, i) { li.classList.toggle('is-on', i === n); li.classList.toggle('is-past', i < n); });
	}
	window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(update); } }, { passive: true });
	if (mq.addEventListener) { mq.addEventListener('change', update); }
	update();

	function show() {
		sh.hidden = false;
		H.classList.add('eb-tsheet-open');
		open.setAttribute('aria-expanded', 'true');
		var a = sh.querySelector('li.is-on a') || sh.querySelector('li a');
		if (a) { var L = sh.querySelector('.eb-tsheet__list'); L.scrollTop = Math.max(0, a.offsetTop - L.clientHeight / 2); a.focus({ preventScroll: true }); }
	}
	function close() {
		if (sh.hidden) { return; }
		sh.hidden = true;
		H.classList.remove('eb-tsheet-open');
		open.setAttribute('aria-expanded', 'false');
	}
	open.addEventListener('click', show);
	sh.querySelector('.eb-tsheet__x').addEventListener('click', function () { close(); open.focus(); });
	sh.querySelector('.eb-tsheet__dim').addEventListener('click', close);
	sh.querySelector('.eb-tsheet__list').addEventListener('click', function (e) {
		var a = e.target.closest('a');
		if (!a) { return; }
		e.preventDefault();
		close();
		var h = document.getElementById(a.getAttribute('href').slice(1));
		if (h) { h.scrollIntoView({ behavior: calm }); }
	});
	document.addEventListener('keydown', function (e) {
		if (sh.hidden) { return; }
		if (e.key === 'Escape') { close(); open.focus(); }
		if (e.key === 'Tab') {
			var f = sh.querySelectorAll('a, button:not([hidden])'), a = f[0], z = f[f.length - 1];
			if (e.shiftKey && document.activeElement === a) { e.preventDefault(); z.focus(); }
			else if (!e.shiftKey && document.activeElement === z) { e.preventDefault(); a.focus(); }
		}
	});
})();
JS
	. "\n</script>\n";
}, 100 );

/* 62. 휴대폰·태블릿 손보기 (2026-10-15, style.css 끝 '휴대폰·태블릿 손보기') ------------------------------------
 * ① 화면 폭 1079px 이하에서 아래로 스크롤하는 동안 html.eb-fabhide → 떠 있는 '맨 위로'·'조건 바꾸기' 버튼을 숨김(카드 버튼을 가리지 않게).
 *    위로 올리거나 맨 위 근처면 다시 보임. 60번 탭바 숨김과 같은 방식
 * ② 옆으로 넘치는 표(.wp-block-table)에 .eb-wide → 첫 칸 고정 + '옆으로 밀어서 더 보기' 안내
 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var H = document.documentElement, last = window.scrollY, tick = false;
	function update() {
		tick = false;
		var y = window.scrollY, d = y - last;
		if (y < 200 || window.innerWidth >= 1080) { H.classList.remove('eb-fabhide'); }
		else if (d > 6) { H.classList.add('eb-fabhide'); }
		else if (d < -6) { H.classList.remove('eb-fabhide'); }
		if (Math.abs(d) > 6) { last = y; }
	}
	window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(update); } }, { passive: true });
	function wide() {
		document.querySelectorAll('.wp-block-table').forEach(function (f) {
			var t = f.querySelector('table');
			f.classList.toggle('eb-wide', !!t && t.scrollWidth > f.clientWidth + 2);
		});
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', wide); } else { wide(); }
	window.addEventListener('load', wide);
	window.addEventListener('resize', wide);
})();
JS
	. "\n</script>\n";
}, 99 );

/* 63. 경로·대표 이미지 손보기 (2026-10-15) --------------------------------------------------------------
 * ① 글 경로에 상위 분야도: 홈 › 노동·민원 › 노동·임금·퇴직금 › 글 (메뉴의 분야 이름과 이어지게, 구조화 데이터도 같이)
 * ② 글 페이지 대표 이미지 alt가 비어 있으면 글 제목으로(이미지 검색·화면 읽기). 목록 카드 썸네일은 바로 옆 제목과 겹치니 그대로 비워 둠
 */
add_filter( 'rank_math/frontend/breadcrumb/items', function ( $crumbs ) {
	if ( ! is_single() ) {
		return $crumbs;
	}
	foreach ( get_the_category() as $cat ) {
		if ( ! $cat->parent ) {
			continue;
		}
		$link = get_category_link( $cat->term_id );
		foreach ( $crumbs as $i => $c ) {
			if ( isset( $c[1] ) && untrailingslashit( $c[1] ) === untrailingslashit( $link ) ) {
				$parent = get_category( $cat->parent );
				if ( $parent && ! is_wp_error( $parent ) ) {
					array_splice( $crumbs, $i, 0, array( array( $parent->name, get_category_link( $parent->term_id ), 'hide_in_schema' => false ) ) );
				}
				return $crumbs;
			}
		}
	}
	return $crumbs;
} );

add_filter( 'post_thumbnail_html', function ( $html, $post_id ) {
	if ( ! is_singular() || (int) $post_id !== get_queried_object_id() || ! preg_match( '/\salt=""/', $html ) ) {
		return $html;
	}
	return preg_replace( '/\salt=""/', ' alt="' . esc_attr( wp_strip_all_tags( get_the_title( $post_id ) ) ) . '"', $html, 1 );
}, 10, 2 );

/* 64. CSS 만들기 (2026-10-15) ------------------------------------------------------------------------------
 * 디자인 원본은 자식 테마 css/ 폴더의 분야별 파일(00-base.css … 95-calendar.css)입니다. style.css에는 테마 정보만 있어요. 안내: css/README.txt
 * 파일 이름 순서대로 이어 붙여 wp-content/uploads/eb-css/에 아래 파일을 자동으로 만듭니다(주석·공백만 정리, 규칙 순서 그대로).
 *  - all.css: 전체 - 안전장치, 종류를 정하지 않은 페이지(날짜·작성자 목록 등), 나누기를 껐을 때
 *  - home.css · post.css · list.css · page.css: 그 종류에서 쓰지 않는 꾸밈 묶음(클래스 이름의 __·-- 앞부분)과
 *    그 종류에선 생길 수 없는 body 꾸밈(예: 글 페이지의 page-id-…)에만 걸리는 규칙을 뺀 것
 * 다시 만드는 때: 테마 편집기에서 파일을 저장한 직후, 그리고 css/ 파일이나 이 파일이 바뀐 것을 처음 알아챈 페이지 열기.
 * 다시 만들면 WP Rocket 캐시도 비움(따로 비울 필요 없음).
 * 빼는 목록은 2026-10-15 전체 글 59·페이지 43·분야 11·태그·검색·404를 관리자·방문자 화면으로 조사해 만든 것(그때 어디에도 안 쓰인 묶음은 빼지 않음).
 * 안전장치(아래 스크립트): 뺀 꾸밈이 화면에 나타나면(새 글에 처음 쓰는 상자, 스크립트가 나중에 붙인 것 포함) 그 자리에 all.css를 붙여 원래와 똑같이 보이게 함.
 * 끄기: eb_css_split_live()가 false → 모든 페이지가 all.css. 파일 만들기가 실패하면 css/ 파일을 순서대로 하나씩 직접 불러옴.
 */
function eb_css_split_live() {
	return true;
}

// 종류 => array( 생길 수 없는 body 꾸밈(정규식), 쓰지 않는 꾸밈 묶음 )
// 주의: 홈 분류 배지 'tg f0~f3'(18번 $tag)은 맞춤 찾기 f2·f3과 이름이 같아 홈 목록에서는 f2·f3을 빼지 않음
function eb_css_split_groups() {
	return array(
		'home' => array(
			'single|single-post|archive|search|page-id-(?!14932(?!\d))\d+',
			'eb-404 eb-ad-calc eb-ad-row eb-author eb-boardtools eb-calc-example eb-calc-related eb-calc-tabs eb-calccard eb-calcgrid eb-cat-tree eb-cathead eb-cc-ic eb-cta-p eb-deals eb-disclosure eb-donate eb-donate-form eb-email eb-feedback eb-findbox eb-form eb-formfile eb-formfiles eb-forms eb-gallery-item eb-gl-count eb-glossary eb-gov eb-head eb-juso eb-linklist eb-list eb-mini eb-mini-on eb-mtoc eb-near eb-nores eb-noresult eb-notice eb-org eb-org-desc eb-org-links eb-org-more eb-orgs eb-page-note eb-paydays eb-popular eb-pp eb-print-target eb-printing eb-progress eb-qrbox eb-quickfind eb-rc eb-readtime eb-recent eb-related eb-row eb-rows eb-scroll-table eb-search-count eb-search-head eb-secnav eb-share eb-sidetoc eb-steps eb-sticky eb-support eb-support-card eb-support-grid eb-tabhide eb-toc-fold eb-toc-long eb-toc-more eb-toc-peek eb-toc-ready eb-toc-tg eb-toc-unfold eb-topic eb-trust eb-tscroll-hint eb-tsheet eb-tsheet-open',
		),
		'post' => array(
			'page-id-\d+|parent-pageid-\d+|archive|search|search-results|search-no-results|error404|home|blog|page-template[\w-]*',
			'c-ad-slot c-adpan c-adw c-ali c-boards c-calc c-card c-cards c-cont c-deal c-due2 c-fields c-guides c-info c-links c-live c-new c-news c-newsvc c-orgs c-pan c-rail c-recent c-roll c-search c-svc c-tick c-tool c-tools c-trend eb-404 eb-ad-calc eb-ad-row eb-bg eb-board eb-boards eb-boardtools eb-calc-example eb-calc-related eb-calc-tabs eb-cathead eb-cc-ic eb-deals eb-disclosure eb-donate eb-donate-form eb-email eb-form eb-formfile eb-formfiles eb-forms eb-glossary eb-gov eb-head eb-hero-in eb-juso eb-list eb-near eb-nores eb-noresult eb-org eb-orgs eb-page-note eb-pp eb-print-target eb-printing eb-qrbox eb-quickfind eb-rc eb-row eb-rows eb-scroll-table eb-search-count eb-search-head eb-secnav eb-steps eb-support eb-support-card eb-support-grid eb-tabs eb-topic f2 f3 hx',
		),
		'list' => array(
			'page-id-\d+|parent-pageid-\d+|single|single-post|postid-\d+|home|page-template[\w-]*',
			'c-ad-slot c-adpan c-adw c-ali c-boards c-calc c-card c-cards c-cont c-deal c-due2 c-fields c-guides c-info c-links c-live c-new c-news c-newsvc c-orgs c-pan c-rail c-recent c-roll c-search c-svc c-tick c-tool c-tools c-trend eb-ad-calc eb-author eb-boards eb-calc-example eb-calc-related eb-calc-tabs eb-cc-ic eb-cta-p eb-deals eb-disclosure eb-donate eb-donate-form eb-email eb-feedback eb-form eb-formfile eb-formfiles eb-forms eb-gallery-item eb-gl-count eb-glossary eb-has-span eb-hero-in eb-juso eb-linklist eb-mini eb-mini-on eb-mtoc eb-near eb-notice eb-num eb-org eb-orgs eb-page-note eb-pp eb-print-target eb-printing eb-progress eb-qrbox eb-rc eb-readtime eb-related eb-scroll-table eb-secnav eb-share eb-sidetoc eb-steps eb-sticky eb-support eb-support-card eb-support-grid eb-tabhide eb-tabs eb-toc-fold eb-toc-long eb-toc-more eb-toc-peek eb-toc-ready eb-toc-tg eb-toc-unfold eb-topic eb-trust eb-tscroll eb-tscroll-hint eb-tsearch eb-tsheet eb-tsheet-open f2 f3 hx',
		),
		'page' => array(
			'single|single-post|postid-\d+|archive|search|search-results|search-no-results|error404|home|blog',
			'c-ad-slot c-adpan c-adw c-ali c-boards c-calc c-card c-cards c-cont c-deal c-due2 c-fields c-guides c-info c-links c-live c-new c-news c-newsvc c-orgs c-pan c-rail c-recent c-roll c-search c-svc c-tick c-tools c-trend eb-404 eb-author eb-bg eb-board eb-boards eb-boardtools eb-cathead eb-cta-p eb-feedback eb-gallery-item eb-gl-count eb-gov eb-hero-in eb-linklist eb-list eb-mini eb-mini-on eb-mtoc eb-nores eb-noresult eb-notice eb-progress eb-quickfind eb-readtime eb-related eb-row eb-rows eb-search-count eb-search-head eb-share eb-sidetoc eb-sticky eb-tabhide eb-toc-fold eb-toc-long eb-toc-more eb-toc-peek eb-toc-ready eb-toc-tg eb-toc-unfold eb-trust eb-tscroll-hint eb-tsheet eb-tsheet-open',
		),
	);
}

function eb_css_split_group() {
	if ( is_front_page() ) {
		return 14932 === (int) get_queried_object_id() ? 'home' : '';
	}
	if ( is_singular( 'post' ) ) {
		return 'post';
	}
	if ( is_category() || is_tag() || is_search() || is_404() ) {
		return 'list';
	}
	return is_page() ? 'page' : '';
}

// 선택자 목록을 쉼표로 나눔(괄호·대괄호 안 쉼표는 그대로)
function eb_css_split_selectors( $head ) {
	$out = array();
	$cur = '';
	$d   = 0;
	$len = strlen( $head );
	for ( $i = 0; $i < $len; $i++ ) {
		$c = $head[ $i ];
		if ( '(' === $c || '[' === $c ) {
			$d++;
		} elseif ( ')' === $c || ']' === $c ) {
			$d--;
		}
		if ( ',' === $c && 0 === $d ) {
			$out[] = trim( $cur );
			$cur   = '';
			continue;
		}
		$cur .= $c;
	}
	$out[] = trim( $cur );
	return $out;
}

// 선택자 하나가 이 종류에서 맞을 수 없으면 true. :not() :is() :where() :has() :nth-*() 안의 클래스는 꼭 있어야 하는 게 아니라서 보지 않음
function eb_css_split_needs( $sel, $fam, $body_re ) {
	if ( preg_match( $body_re, $sel ) ) {
		return true;
	}
	$s     = preg_replace( '/\[[^\]]*\]/', '', $sel );
	$plain = '';
	$len   = strlen( $s );
	for ( $i = 0; $i < $len; $i++ ) {
		if ( ':' === $s[ $i ] && preg_match( '/\G:(?:not|is|where|has|nth-[a-z-]+)\(/', $s, $m, 0, $i ) ) {
			$j = $i + strlen( $m[0] );
			$d = 1;
			while ( $j < $len && $d ) {
				if ( '(' === $s[ $j ] ) {
					$d++;
				} elseif ( ')' === $s[ $j ] ) {
					$d--;
				}
				$j++;
			}
			$i = $j - 1;
			continue;
		}
		$plain .= $s[ $i ];
	}
	if ( preg_match_all( '/\.(-?[A-Za-z_][\w-]*)/', $plain, $m ) ) {
		foreach ( $m[1] as $c ) {
			$parts = preg_split( '/__|--/', $c );
			if ( isset( $fam[ $parts[0] ] ) ) {
				return true;
			}
		}
	}
	return false;
}

// CSS를 규칙 단위로 읽어(문자열·괄호·@media 안까지) 선택자가 모두 맞을 수 없는 규칙만 뺌
function eb_css_split_rules( $text, $fam, $body_re ) {
	$out        = '';
	$start      = 0;
	$body_start = 0;
	$head       = '';
	$quote      = '';
	$depth      = 0;
	$paren      = 0;
	$length     = strlen( $text );
	for ( $i = 0; $i < $length; $i++ ) {
		$c = $text[ $i ];
		if ( '' !== $quote ) {
			if ( '\\' === $c ) {
				$i++;
				continue;
			}
			if ( $c === $quote ) {
				$quote = '';
			}
			continue;
		}
		if ( '\\' === $c ) {
			$i++;
			continue;
		}
		if ( '"' === $c || "'" === $c ) {
			$quote = $c;
			continue;
		}
		if ( '(' === $c ) {
			$paren++;
			continue;
		}
		if ( ')' === $c ) {
			$paren--;
			continue;
		}
		if ( 0 !== $paren ) {
			continue;
		}
		if ( '{' === $c ) {
			if ( 0 === $depth ) {
				$head       = substr( $text, $start, $i - $start );
				$body_start = $i + 1;
			}
			$depth++;
		} elseif ( '}' === $c ) {
			$depth--;
			if ( $depth < 0 ) {
				return false;
			}
			if ( 0 === $depth ) {
				$h    = trim( $head );
				$body = substr( $text, $body_start, $i - $body_start );
				$keep = true;
				if ( preg_match( '/^@(media|supports|container)\b/', $h ) ) {
					$body = eb_css_split_rules( $body, $fam, $body_re );
					if ( false === $body ) {
						return false;
					}
					$keep = '' !== trim( $body );
				} elseif ( '@' !== substr( $h, 0, 1 ) ) {
					$keep = false;
					foreach ( eb_css_split_selectors( $h ) as $sel ) {
						if ( '' !== $sel && ! eb_css_split_needs( $sel, $fam, $body_re ) ) {
							$keep = true;
							break;
						}
					}
				}
				if ( $keep ) {
					$out .= $head . '{' . $body . '}';
				}
				$start = $i + 1;
			}
		} elseif ( ';' === $c && 0 === $depth ) {
			$out  .= substr( $text, $start, $i + 1 - $start );
			$start = $i + 1;
		}
	}
	if ( 0 !== $depth || 0 !== $paren || '' !== $quote ) {
		return false;
	}
	return $out . substr( $text, $start );
}

// css/ 폴더의 원본 파일(이름 순서 = 불러오는 순서)
function eb_css_files() {
	$files = glob( get_stylesheet_directory() . '/css/*.css' );
	if ( ! $files ) {
		return array();
	}
	sort( $files, SORT_STRING );
	return $files;
}

// 원본이 바뀌었는지 알아보는 값: css/ 파일 이름·크기·수정 시각 + 이 파일(빼는 목록) 수정 시각
function eb_css_signature() {
	$sig = '';
	foreach ( eb_css_files() as $f ) {
		$sig .= basename( $f ) . ':' . filesize( $f ) . ':' . filemtime( $f ) . ';';
	}
	return md5( $sig . filemtime( __FILE__ ) );
}

// 만든 파일을 두는 곳: wp-content/uploads/eb-css (테마 편집기 목록에 안 보이게)
function eb_css_dir() {
	$up = wp_upload_dir( null, false );
	return array( trailingslashit( $up['basedir'] ) . 'eb-css', set_url_scheme( trailingslashit( $up['baseurl'] ) . 'eb-css' ) );
}

// $group: 'all' 또는 eb_css_split_groups()의 이름. 성공하면 array( 주소, 버전 ), 실패하면 false. 새로 만들었으면 $changed = true
function eb_css_build( $group, &$changed = null ) {
	$changed = false;
	$groups  = eb_css_split_groups();
	if ( 'all' !== $group && ! isset( $groups[ $group ] ) ) {
		return false;
	}
	list( $dir, $url ) = eb_css_dir();
	$ver    = substr( md5( eb_css_signature() . $group . ( 'all' === $group ? '' : implode( "\n", $groups[ $group ] ) ) ), 0, 12 );
	$marker = '/* EasyBokji CSS ' . $group . ': ' . $ver . " */\n";
	$target = $dir . '/' . $group . '.css';
	if ( is_readable( $target ) ) {
		$fh = fopen( $target, 'rb' ); // phpcs:ignore
		if ( $fh ) {
			$same = fgets( $fh ) === $marker;
			fclose( $fh ); // phpcs:ignore
			if ( $same ) {
				return array( $url . '/' . $group . '.css', $ver );
			}
		}
	}
	if ( ! wp_mkdir_p( $dir ) ) {
		return false;
	}
	$source = '';
	foreach ( eb_css_files() as $f ) {
		$t = @file_get_contents( $f ); // phpcs:ignore
		if ( ! is_string( $t ) ) {
			return false;
		}
		$source .= $t . "\n";
	}
	if ( '' === trim( $source ) ) {
		return false;
	}
	// Preserve quoted strings, including SVG data URLs, while removing comments.
	$tokens = '~("(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\')|/\*.*?\*/~s';
	$clean = preg_replace_callback( $tokens, function ( $m ) { return isset( $m[1] ) && $m[1] !== '' ? $m[1] : ' '; }, $source );
	if ( ! is_string( $clean ) ) {
		return false;
	}
	if ( 'all' === $group ) {
		$out = $clean;
	} else {
		list( $body_pat, $fams ) = $groups[ $group ];
		$out = eb_css_split_rules( $clean, array_fill_keys( preg_split( '/\s+/', trim( $fams ) ), true ), '/^(?:body)?\.(?:' . $body_pat . ')(?![\w-])/' );
		if ( false === $out ) {
			return false;
		}
	}
	$out = preg_replace_callback( '~("(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\')|(\s+)~', function ( $m ) { return isset( $m[1] ) && $m[1] !== '' ? $m[1] : ' '; }, $out );
	if ( ! is_string( $out ) || '' === trim( $out ) ) {
		return false;
	}
	$content   = $marker . trim( $out ) . "\n";
	$temporary = @tempnam( $dir, 'eb-css-' ); // phpcs:ignore
	if ( false === $temporary ) {
		return false;
	}
	$written = @file_put_contents( $temporary, $content, LOCK_EX ); // phpcs:ignore
	if ( strlen( $content ) !== $written || ! @rename( $temporary, $target ) ) { // phpcs:ignore
		@unlink( $temporary ); // phpcs:ignore
		return false;
	}
	@chmod( $target, 0644 ); // phpcs:ignore
	$changed = true;
	return array( $url . '/' . $group . '.css', $ver );
}

// 전부 다시 만들고, 바뀐 게 있으면 WP Rocket 캐시 비우기
function eb_css_rebuild_all() {
	clearstatcache();
	$any = false;
	foreach ( array_merge( array( 'all' ), array_keys( eb_css_split_groups() ) ) as $g ) {
		eb_css_build( $g, $changed );
		$any = $any || $changed;
	}
	update_option( 'eb_css_sig', eb_css_signature(), true );
	foreach ( (array) glob( get_stylesheet_directory() . '/style-*.generated.css' ) as $old ) { // 예전 방식(테마 폴더)에 만들던 파일 정리
		@unlink( $old ); // phpcs:ignore
	}
	if ( $any && function_exists( 'rocket_clean_minify' ) ) {
		rocket_clean_minify( 'css' );
	}
	if ( $any && function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
}

// 만든 파일은 이미 공백을 정리했으니 WP Rocket이 다시 줄이지 않게(주소의 ?ver= 그대로 → 새로 만들면 바로 새 파일)
add_filter( 'rocket_exclude_css', function ( $excluded ) {
	$excluded[] = '/wp-content/uploads/eb-css/(.*).css';
	return $excluded;
} );

// 테마 편집기에서 저장한 직후(저장이 끝난 뒤 실행)
add_action( 'wp_ajax_edit-theme-plugin-file', function () {
	register_shutdown_function( 'eb_css_rebuild_all' );
}, 0 );

// 페이지에 붙이기: 테마의 style.css 자리에 만든 파일을 넣음(불러오는 위치는 그대로)
add_action( 'wp_enqueue_scripts', function () {
	if ( 'generatepress_child' !== get_stylesheet() ) {
		return;
	}
	$uri    = get_stylesheet_directory_uri();
	$style  = null;
	$handle = '';
	foreach ( wp_styles()->registered as $h => $s ) {
		if ( $s->src && explode( '?', $s->src )[0] === $uri . '/style.css' ) {
			$style  = $s;
			$handle = $h;
			break;
		}
	}
	if ( ! $style ) {
		return;
	}
	if ( get_option( 'eb_css_sig' ) !== eb_css_signature() ) {
		eb_css_rebuild_all();
	}
	$all = eb_css_build( 'all', $new_all );
	if ( ! $all ) {
		$prev = $handle; // 만들기 실패: css/ 파일을 순서대로 직접
		foreach ( eb_css_files() as $i => $f ) {
			wp_enqueue_style( 'eb-css-' . $i, $uri . '/css/' . basename( $f ), array( $prev ), (string) filemtime( $f ) );
			$prev = 'eb-css-' . $i;
		}
		return;
	}
	$use   = $all;
	$group = eb_css_split_live() ? eb_css_split_group() : '';
	if ( '' !== $group ) {
		$part = eb_css_build( $group, $new_part );
		if ( $part ) {
			$use    = $part;
			$groups = eb_css_split_groups();
			$GLOBALS['eb_css_split'] = array(
				'id'   => $handle . '-css',
				'full' => $all[0] . '?ver=' . $all[1],
				're'   => '(?:^|\s)(?:' . str_replace( ' ', '|', trim( $groups[ $group ][1] ) ) . '|' . $groups[ $group ][0] . ')(?:__|--|\s|$)',
			);
		}
	}
	$style->src = $use[0];
	$style->ver = $use[1];
	if ( ( ! empty( $new_all ) || ! empty( $new_part ) ) && function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain(); // 페이지를 열다가 새로 만들었으면 예전 주소를 담은 캐시도 비움
	}
}, 99 );

// 안전장치: 뺀 꾸밈이 붙은 요소가 있거나 나중에 생기면 전체(all.css)를 같은 자리(바로 뒤)에 붙이고, 다 받으면 나눈 파일은 끔
add_action( 'wp_footer', function () {
	if ( empty( $GLOBALS['eb_css_split'] ) ) {
		return;
	}
	$x = $GLOBALS['eb_css_split'];
	printf( "<script nowprocket>(function(){var L=document.getElementById(%s),re=new RegExp(%s),full=%s,done=0,mo;if(!L){return;}function hit(e){var c=e.getAttribute&&e.getAttribute('class');return !!c&&re.test(c);}function scan(n){if(hit(n)){return n;}var a=n.querySelectorAll?n.querySelectorAll('[class]'):[];for(var i=0;i<a.length;i++){if(hit(a[i])){return a[i];}}return null;}function swap(e){if(done){return;}done=1;if(mo){mo.disconnect();}window.ebCssFull=String(e.getAttribute('class'));var n=document.createElement('link');n.rel='stylesheet';n.href=full;n.onload=function(){L.disabled=true;};L.parentNode.insertBefore(n,L.nextSibling);}var f=scan(document.documentElement);if(f){swap(f);return;}mo=new MutationObserver(function(ms){for(var i=0;i<ms.length;i++){var m=ms[i],t;if(m.type==='attributes'){if(hit(m.target)){return swap(m.target);}}else{for(var j=0;j<m.addedNodes.length;j++){if(m.addedNodes[j].nodeType===1&&(t=scan(m.addedNodes[j]))){return swap(t);}}}}});mo.observe(document.documentElement,{subtree:true,childList:true,attributes:true,attributeFilter:['class']});document.addEventListener('DOMContentLoaded',function(){var t=scan(document.documentElement);if(t){swap(t);}});})();</script>\n", wp_json_encode( $x['id'] ), wp_json_encode( $x['re'] ), wp_json_encode( $x['full'] ) );
}, 0 );

/* 65. 상황별 가이드 아래 '이 상황으로 혜택 찾기' + 가이드 8개 이어 보기 (2026-10-15, css/90-tools.css 끝 .eb-gx) ---------------
 * 가이드 페이지(/guide/ 하위)에서 본문 바로 아래(페이지 틀은 generate_after_content 훅). 목록은 eb_guide_list(), 혜택 찾기 조건은 eb_find_situations()의 같은 상황 것을 씀
 * → 혜택 찾기(/find/?life=…&hh=…&th=…)가 그 조건으로 열림. 지금 보는 가이드는 '보는 중'으로 표시(8칸이 2칸×4줄로 딱 맞게)
 */
add_action( 'generate_after_content', function () {
	if ( ! is_page() || 14907 !== (int) wp_get_post_parent_id( get_the_ID() ) || ! function_exists( 'eb_guide_list' ) ) {
		return;
	}
	$here = '/' . trim( (string) wp_parse_url( get_permalink(), PHP_URL_PATH ), '/' ) . '/';
	$find = '';
	foreach ( eb_find_situations() as $s ) {
		if ( '/guide/' . $s[1] . '/' !== rawurldecode( $here ) ) {
			continue;
		}
		$q = array_filter( array(
			'life' => $s[2]['life'],
			'hh'   => implode( ',', $s[2]['hh'] ),
			'th'   => implode( ',', $s[2]['th'] ),
		) );
		if ( $q ) {
			$find = '<a class="eb-gx__find" href="' . esc_url( add_query_arg( array_map( 'rawurlencode', $q ), home_url( '/find/' ) ) . '#finder' ) . '">'
				. '<span class="eb-gx__fi">' . eb_x_ic( 'compass' ) . '</span>'
				. '<span class="eb-gx__ft"><strong>이 상황에 맞는 혜택 찾기</strong><small>정부·지자체 복지서비스와 정리 글을 이 조건으로 모아 봐요</small></span>'
				. eb_x_ic( 'chev' ) . '</a>';
		}
		break;
	}
	$li = '';
	foreach ( eb_guide_list() as $g ) {
		$on  = rawurldecode( $here ) === $g[0];
		$li .= '<li><a href="' . esc_url( home_url( $g[0] ) ) . '"' . ( $on ? ' aria-current="page"' : '' ) . '>'
			. '<span class="eb-gx__mi">' . eb_x_ic( $g[1] ) . '</span>'
			. '<span class="eb-gx__tx"><strong>' . esc_html( $g[2] ) . '</strong><small>' . ( $on ? '지금 보는 가이드' : esc_html( $g[3] ) ) . '</small></span></a></li>';
	}
	echo '<section class="eb-gx" aria-labelledby="eb-gx-h">' . $find // phpcs:ignore
		. '<h2 class="eb-gx__h" id="eb-gx-h">다른 상황별 가이드</h2><ul class="eb-gx__list">' . $li . '</ul></section>'; // phpcs:ignore
}, 6 );

/* 66. 계산기·가이드 페이지에도 저장·공유·최근 본 글 + '저장한 글'에 알림 켠 일정 (2026-10-16, css/90-tools.css 끝 .eb-pact·.eb-alerts) ---
 * 저장·최근 본 글은 글(19번 eb_saved, 13-5 eb_recent)과 같은 목록에 들어감(이 기기 브라우저에만).
 * 알림 켠 일정: 복지 일정 플러그인 종 버튼이 저장하는 ebs_push(키)·ebs_push_meta(이름·기간·주소, board.js) → /saved/ 맨 위와 휴대폰 메뉴 '알림' 탭(20번).
 * /saved/에서는 종 버튼으로 바로 끌 수 있게 플러그인 스크립트(board.js)를 함께 불러옴.
 */
function eb_pact_page() {
	if ( ! is_page() ) {
		return false;
	}
	$parent = (int) wp_get_post_parent_id( get_the_ID() );
	return 14866 === $parent || 14907 === $parent; // 계산기 17개(2026-10-17 퇴사 한 번에 추가), 상황별 가이드 8개
}

add_filter( 'body_class', function ( $c ) {
	if ( eb_pact_page() ) {
		$c[] = 'eb-pact-on';
	}
	return $c;
} );

add_action( 'generate_after_page_title', function () {
	if ( ! eb_pact_page() ) {
		return;
	}
	$star  = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.9l-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/></svg>';
	$share = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M12 15V3.5M7.5 8 12 3.5 16.5 8M5 12.5V19a1.5 1.5 0 0 0 1.5 1.5h11A1.5 1.5 0 0 0 19 19v-6.5"/></svg>';
	printf(
		'<div class="eb-pact" data-url="%1$s" data-title="%2$s"><button type="button" class="eb-pact__save" aria-pressed="false" aria-label="이 페이지 저장" title="저장">%3$s</button><button type="button" class="eb-pact__share" aria-label="이 페이지 공유" title="공유">%4$s</button></div>',
		esc_url( get_permalink() ),
		esc_attr( wp_strip_all_tags( get_the_title() ) ),
		$star, // phpcs:ignore
		$share // phpcs:ignore
	);
} );

// /saved/: 알림 켠 일정 칸(종 버튼으로 끄기 → 플러그인 board.js) + 빈 화면 안내 문구를 계산기·가이드까지
add_filter( 'do_shortcode_tag', function ( $out, $tag, $attr ) {
	if ( 'eb_saved' !== $tag || empty( $attr['mode'] ) || 'page' !== $attr['mode'] ) {
		return $out;
	}
	$out = str_replace( '글 위쪽의 ☆ 저장 버튼을 누르면 이곳에 모여요.', '글·계산기·상황별 가이드 위쪽의 ☆ 저장 버튼을 누르면 이곳에 모여요.', $out );
	$box = '<section class="eb-alerts" id="alerts" aria-labelledby="eb-alerts-h" hidden><div class="eb-alerts__head"><h2 class="eb-alerts__h" id="eb-alerts-h">알림 켠 일정 <b></b></h2><a class="eb-alerts__more" href="' . esc_url( home_url( '/schedule/#applying' ) ) . '">일정 더 보기 ›</a></div>'
		. '<p class="eb-alerts__note">신청 시작일·마감 3일 전·마감일 아침 9시에 이 기기로 알려 드려요. 종을 누르면 꺼져요.</p><ul class="eb-alerts__list"></ul></section>';
	$js = function_exists( 'ebs_assets_once' ) && ! get_option( 'ebs_push_off' ) ? ebs_assets_once() : '';
	return $box . $out . $js;
}, 10, 3 );

add_action( 'wp_footer', function () {
	if ( ! eb_pact_page() && ! is_page( 14937 ) ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	function esc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function get(k, d) { try { return JSON.parse(localStorage.getItem(k) || d); } catch (e) { return JSON.parse(d); } }
	function put(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) {} }
	function toast(msg) {
		var t = document.querySelector('.eb-toast');
		if (!t) { t = document.createElement('div'); t.className = 'eb-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
		t.textContent = msg; t.hidden = false; t.classList.add('is-on');
		clearTimeout(t._h); t._h = setTimeout(function () { t.classList.remove('is-on'); }, 2600);
	}

	// ① 계산기·가이드: 저장·공유 + 최근 본 글에 남김
	var box = document.querySelector('.eb-pact');
	if (box) {
		var url = box.getAttribute('data-url'), title = box.getAttribute('data-title'), save = box.querySelector('.eb-pact__save');
		var paint = function () {
			var on = get('eb_saved', '[]').some(function (x) { return x && x.u === url; });
			save.setAttribute('aria-pressed', on ? 'true' : 'false');
			save.setAttribute('aria-label', on ? '저장됨 · 누르면 저장 취소' : '이 페이지 저장');
			save.title = on ? '저장됨' : '저장';
		};
		save.addEventListener('click', function () {
			var list = get('eb_saved', '[]'), on = list.some(function (x) { return x && x.u === url; });
			list = on ? list.filter(function (x) { return x.u !== url; }) : [{ u: url, t: title, d: Date.now() }].concat(list).slice(0, 50);
			put('eb_saved', list);
			document.dispatchEvent(new CustomEvent('eb:saved'));
			paint();
			toast(on ? '저장을 취소했어요' : '저장했어요 · 메뉴의 \'저장한 글\'에서 다시 볼 수 있어요');
		});
		document.addEventListener('eb:saved', paint);
		paint();
		box.querySelector('.eb-pact__share').addEventListener('click', function () {
			if (navigator.share) { navigator.share({ title: title, url: url }).catch(function () {}); return; }
			var done = function () { toast('링크를 복사했어요'); };
			if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(url).then(done, function () { prompt('이 주소를 복사해 주세요', url); }); }
			else { prompt('이 주소를 복사해 주세요', url); }
		});
		var rec = get('eb_recent', '[]').filter(function (x) { return x && x.u !== url; });
		rec.unshift({ u: url, t: title });
		put('eb_recent', rec.slice(0, 8));
	}

	// ② /saved/: 알림 켠 일정 (키는 ebs_push, 이름·기간은 ebs_push_meta - 플러그인 board.js가 종을 켤 때 남김)
	var al = document.querySelector('.eb-alerts');
	if (!al) { return; }
	var DAY = 864e5, now = new Date(), today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
	function d0(s) { var p = String(s).split('-'); return new Date(+p[0], p[1] - 1, +p[2]); }
	function nj(s) { var d = d0(s); return (d.getMonth() + 1) + '.' + d.getDate(); }
	var bell = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9a6 6 0 0 1 12 0c0 6.5 2.5 8.5 2.5 8.5h-17S6 15.5 6 9"/><path d="M10.3 21a2 2 0 0 0 3.4 0"/></svg>';
	var keys = get('ebs_push', '[]'), meta = get('ebs_push_meta', '{}');
	var rows = keys.map(function (k) {
		var m = meta[k] || {};
		var open = !m.s || d0(m.s) <= today, ref = m.e ? d0(open ? m.e : m.s) : null;
		return { k: k, n: m.n || '', u: m.u || '/schedule/#applying', x: !!m.x, e: m.e || '', s: m.s || '', open: open, left: ref ? Math.round((ref - today) / DAY) : 9999 };
	}).filter(function (r) { return !r.e || d0(r.e) >= today; }).sort(function (a, b) { return a.left - b.left; });
	if (!rows.length) { return; }
	al.querySelector('.eb-alerts__list').innerHTML = rows.map(function (r) {
		var dd = r.left === 9999 ? '' : (r.left === 0 ? (r.open ? '오늘 마감' : '오늘 시작') : 'D-' + r.left);
		var when = r.e ? (r.open ? '~' + nj(r.e) + ' 마감' : nj(r.s) + ' 시작 · ~' + nj(r.e) + ' 마감') : '복지 캘린더에서 기간 확인';
		var name = r.n || '알림을 켠 일정';
		return '<li class="eb-alerts__r' + (r.open ? '' : ' is-soon') + '"><span class="eb-alerts__dd' + (r.left <= 3 ? ' is-near' : '') + '">' + esc(dd || '일정') + '</span>'
			+ '<span class="eb-alerts__m"><a href="' + esc(r.u) + '"' + (r.x ? ' target="_blank" rel="noopener"' : '') + '>' + esc(name) + '</a><small>' + esc(when) + '</small></span>'
			+ '<button type="button" class="eb-alerts__bell" data-push="' + esc(r.k) + '" data-n="' + esc(r.n) + '" aria-pressed="true" aria-label="' + esc(name + ' 알림 끄기') + '" title="알림 켜짐 · 누르면 꺼요">' + bell + '</button></li>';
	}).join('');
	var count = function () {
		al.querySelectorAll('.eb-alerts__bell').forEach(function (b) { var on = b.getAttribute('aria-pressed') === 'true', nm = b.getAttribute('data-n') || '이 일정'; b.setAttribute('aria-label', nm + (on ? ' 알림 끄기' : ' 알림 다시 켜기')); b.title = on ? '알림 켜짐 · 누르면 꺼요' : '알림 꺼짐 · 누르면 다시 켜요'; });
		var n = al.querySelectorAll('.eb-alerts__bell[aria-pressed="true"]').length;
		al.querySelector('.eb-alerts__h b').textContent = n;
	};
	count();
	al.hidden = false;
	document.addEventListener('ebs:push', function () { setTimeout(count, 0); });
	new MutationObserver(count).observe(al, { attributes: true, subtree: true, attributeFilter: ['aria-pressed'] });
	if (location.hash === '#alerts') { al.scrollIntoView({ block: 'start' }); }
})();
JS
	. "\n</script>\n";
}, 72 );

/* 67. 사이드바 통일 (2026-10-16, css/85-common.css 끝 '사이드바 통일') ------------------------------------------
 * 글 페이지 사이드바 모양(테두리 카드)과 구성을 계산기·가이드·안내·도구·분야·검색·404 사이드바에도 똑같이.
 *  - 모든 사이드바에서 뺌: 최근 업데이트된 정보(block-45, 링크만 고친 글이 맨 위로 올라옴) · 공식 기관 바로가기(block-58, 푸터·/links/에 있음)
 *    (글 페이지·휴대폰에서는 원래 CSS로 숨기던 것. 위젯 설정은 그대로라 아래 함수를 false로 하면 원래대로)
 *  - 분야 목록에서 뺌: 많이 본 글(block-99, 본문 위 '이 분야 많이 본 글'과 겹침)
 *  - 상황별 가이드: 사이드바 맨 위 '다른 상황별 가이드' 칩(.eb-sg, 목록은 eb_guide_list)
 *  - 따라오는 상자(.eb-sf, PC 900px 이상): 계산기 '맞춤 혜택 찾기' · 가이드 단계 바로가기 + '이 상황으로 혜택 찾기'
 *    · 그 밖의 페이지는 본문 소제목(H2)이 3개 이상일 때 '이 페이지 목차'
 *  - 사이드바 전체를 붙여 두던 것(85-common.css .inside-right-sidebar sticky)은 끄고 따라오는 상자만 붙임
 *    → 사이드바가 화면보다 길어 아래 위젯이 안 보이던 문제
 * 되돌리기: eb_side_unify_live()를 false로 (CSS는 css/85-common.css 끝 '사이드바 통일' 블록)
 */
function eb_side_unify_live() {
	return true;
}

add_filter( 'sidebars_widgets', function ( $widgets ) {
	// 관리자·위젯 편집기(REST)에서는 손대지 않음 - 위젯 설정이 지워지지 않게
	if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || wp_doing_ajax() || ! eb_side_unify_live() ) {
		return $widgets;
	}
	if ( empty( $widgets['sidebar-1'] ) || ! is_array( $widgets['sidebar-1'] ) ) {
		return $widgets;
	}
	$drop = array( 'block-45', 'block-58' );
	if ( is_category() ) {
		$drop[] = 'block-99';
	}
	$widgets['sidebar-1'] = array_values( array_diff( $widgets['sidebar-1'], $drop ) );
	return $widgets;
}, 20 );

// 상황별 가이드(14907 하위)인지 + 그 가이드의 맞춤 찾기 주소(65번과 같은 조건)
function eb_side_guide_find_url() {
	if ( ! is_page() || 14907 !== (int) wp_get_post_parent_id( get_queried_object_id() ) || ! function_exists( 'eb_find_situations' ) ) {
		return '';
	}
	$here = rawurldecode( '/' . trim( (string) wp_parse_url( get_permalink( get_queried_object_id() ), PHP_URL_PATH ), '/' ) . '/' );
	foreach ( eb_find_situations() as $s ) {
		if ( '/guide/' . $s[1] . '/' !== $here ) {
			continue;
		}
		$q = array_filter( array(
			'life' => $s[2]['life'],
			'hh'   => implode( ',', $s[2]['hh'] ),
			'th'   => implode( ',', $s[2]['th'] ),
		) );
		return $q ? add_query_arg( array_map( 'rawurlencode', $q ), home_url( '/find/' ) ) . '#finder' : home_url( '/find/' );
	}
	return home_url( '/find/' );
}

// 가이드 사이드바 맨 위(검색창 다음): 다른 상황별 가이드 칩 - 계산기 '관련 계산기'(13번 .eb-rc)와 같은 자리
add_action( 'dynamic_sidebar', function ( $w ) {
	static $done = false;
	if ( $done || is_admin() || ! eb_side_unify_live() || ! is_page() || 14907 !== (int) wp_get_post_parent_id( get_queried_object_id() ) || ! function_exists( 'eb_guide_list' ) || ( isset( $w['id'] ) && 'block-97' === $w['id'] ) ) {
		return;
	}
	$done = true;
	$here = rawurldecode( '/' . trim( (string) wp_parse_url( get_permalink( get_queried_object_id() ), PHP_URL_PATH ), '/' ) . '/' );
	$li   = '';
	foreach ( eb_guide_list() as $g ) {
		if ( $here === $g[0] ) {
			continue;
		}
		$li .= '<li><a href="' . esc_url( home_url( $g[0] ) ) . '" title="' . esc_attr( $g[2] ) . '">' . esc_html( $g[4] ) . '</a></li>';
	}
	echo '<aside class="widget inner-padding eb-sg"><h2 class="widget-title">다른 상황별 가이드</h2><ul class="eb-sg__list">' . $li . '</ul></aside>'; // phpcs:ignore
} );

// 따라오는 상자 (글 페이지는 38번 .eb-sticky가 따로 있음)
add_action( 'generate_after_right_sidebar_content', function () {
	if ( ! eb_side_unify_live() || is_singular( 'post' ) || is_front_page() ) {
		return;
	}
	$parent = is_page() ? (int) wp_get_post_parent_id( get_queried_object_id() ) : 0;
	if ( 14866 === $parent ) {
		echo '<aside class="widget eb-sf" aria-label="계산 다음 단계"><h2 class="widget-title">계산이 끝났다면</h2>'
			. '<p class="eb-sf__txt">이 조건으로 받을 수 있는 정부·지자체 혜택도 함께 확인해 보세요.</p>'
			. '<a class="eb-sf__btn" href="' . esc_url( home_url( '/find/' ) ) . '">맞춤 혜택 찾기</a></aside>'; // phpcs:ignore
	} elseif ( 14907 === $parent ) {
		echo '<aside class="widget eb-sf" data-h=".eb-steps__title" data-min="2" aria-label="단계 바로가기"><h2 class="widget-title">단계</h2><ol></ol>'
			. '<a class="eb-sf__btn" href="' . esc_url( eb_side_guide_find_url() ) . '">이 상황으로 혜택 찾기</a></aside>'; // phpcs:ignore
	} elseif ( is_page() ) {
		echo '<aside class="widget eb-sf" data-h="h2" data-min="3" data-only-toc hidden aria-label="이 페이지 목차"><h2 class="widget-title">이 페이지 목차</h2><ol></ol></aside>'; // phpcs:ignore
	} else {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-sf');
	if (!box) { return; }
	var ol = box.querySelector('ol');
	if (!ol) { return; }
	var sel = box.getAttribute('data-h') || 'h2', min = +box.getAttribute('data-min') || 1;
	var hs = [].filter.call(document.querySelectorAll('.entry-content ' + sel), function (h) {
		return h.textContent.trim() && !h.closest('aside, .eb-gx, .tocer-toc, .eb-pact, .eb-calc-related');
	});
	if (hs.length < min) {
		if (box.hasAttribute('data-only-toc')) { box.remove(); } else { ol.remove(); }
		return;
	}
	var targets = hs.map(function (h, i) {
		var t = sel === 'h2' ? h : (h.closest('li') || h);
		if (!t.id) { t.id = 'eb-s-' + (i + 1); }
		t.style.scrollMarginTop = '96px';
		var li = document.createElement('li'), a = document.createElement('a'), b = document.createElement('b');
		a.href = '#' + t.id;
		b.textContent = i + 1;
		a.appendChild(b);
		a.appendChild(document.createTextNode(h.textContent.trim().replace(/\s+/g, ' ').replace(/^\d+\s*[.)]\s*/, ''))); // 소제목에 이미 있는 '1.' 번호는 빼고 앞 숫자만
		li.appendChild(a);
		ol.appendChild(li);
		return t;
	});
	box.hidden = false;
	var links = ol.querySelectorAll('a'), cur = -2, tick = false;
	function update() {
		tick = false;
		var n = -1;
		targets.forEach(function (t, i) { if (t.getBoundingClientRect().top < 130) { n = i; } });
		if (n === cur) { return; }
		cur = n;
		[].forEach.call(links, function (a, i) { a.classList.toggle('is-on', i === n); });
	}
	window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(update); } }, { passive: true });
	update();
})();
JS
	. "\n</script>\n";
} );

/* 68. 휴대폰 전체 메뉴 (2026-10-16 3차 시안, css/60-mobile-bar.css 끝 '전체 메뉴') -----------------------------------
 * 하단 탭 '메뉴'·휴대폰 머리 '메뉴'를 누르면 테마 옆 메뉴(#generate-slideout-menu) 대신 전체 화면 메뉴(#ebm)가 열림.
 * 순서: 제목·닫기(따라옴) · 검색 막대(68-2번 검색 화면을 엶)·인기 검색어 4 · 최근 본 것/저장한 글/알림 아이콘 줄 · 맞춤 혜택 찾기
 *       · [상황|분야|계산기|캘린더|도구] 탭(따라옴, 누르면 그 칸으로) · 칸 5개 · 글자 크기·앱 설치·사이트 안내 · 약관
 * 검색은 68-2번 검색 화면(#ebsr)이 맡음(2026-10-16 검색 시안 3장)
 * 기록: 최근 본 글 eb_recent(13-5·66번) · 저장 eb_saved(19번) · 알림 ebs_push(복지 일정 플러그인) - 이 기기 브라우저에만
 * 계산기 8칸: 최근 30일 조회수 많은 순 7개(WP Statistics, 6시간 캐시, 기록이 없으면 기본 순서) + 2026 기준표
 * 일정: 지급일(eb_x_paydays)·신청·마감(eb_upcoming_dues) 3달치를 넣어 두고 방문자 날짜로 고름(캐시된 페이지 대비)
 * 글자 크기 버튼은 51번(.eb-fsseg [data-fs]), 앱 설치는 35번(a[href$="#install"])이 그대로 처리
 * 끄기: eb_mmenu_live() false → 예전 옆 메뉴(20·46·51번)가 그대로 열림
 */
function eb_mmenu_live() {
	return true;
}

// 계산기 목록(조회수 많은 순) - [ u 주소, s 슬러그, n 짧은 이름 ]
function eb_mmenu_calcs() {
	$cached = get_transient( 'eb_mmenu_calcs2' );
	if ( false !== $cached ) {
		return $cached;
	}
	$parent = get_page_by_path( 'calculator' );
	$kids   = $parent ? get_posts( array( 'post_type' => 'page', 'post_parent' => $parent->ID, 'post_status' => 'publish', 'posts_per_page' => -1, 'no_found_rows' => true ) ) : array();
	$views  = array();
	global $wpdb;
	$table = $wpdb->prefix . 'statistics_pages';
	if ( $kids && $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
		$in   = implode( ',', array_map( function ( $p ) {
			return (int) $p->ID;
		}, $kids ) );
		$rows = $wpdb->get_results( $wpdb->prepare( "SELECT id, SUM(count) AS n FROM {$table} WHERE id IN ({$in}) AND date >= %s GROUP BY id", gmdate( 'Y-m-d', strtotime( '-30 days' ) ) ) );
		foreach ( (array) $rows as $r ) {
			$views[ (int) $r->id ] = (int) $r->n;
		}
	}
	$base = array( 'unemployment-benefit', 'severance-pay', 'basic-pension', 'minimum-wage', 'weekly-holiday-pay', 'social-insurance', 'median-income' );
	$out  = array();
	foreach ( $kids as $p ) {
		$slug = $p->post_name;
		$name = trim( preg_replace( '/\s*\([^)]*\)\s*$/u', '', get_the_title( $p ) ) );
		$bare = trim( preg_replace( '/\s*(모의)?계산기$/u', '', $name ) );
		$pos  = array_search( $slug, $base, true );
		$out[] = array(
			'u' => get_permalink( $p ),
			's' => $slug,
			'n' => mb_strlen( $bare ) >= 3 ? $bare : $name, // '날짜'처럼 너무 짧으면 '날짜 계산기'
			'v' => isset( $views[ $p->ID ] ) ? $views[ $p->ID ] : 0,
			'b' => false === $pos ? 99 : $pos,
		);
	}
	usort( $out, function ( $a, $b ) {
		return ( $b['v'] - $a['v'] ) ?: ( $a['b'] - $b['b'] );
	} );
	set_transient( 'eb_mmenu_calcs2', $out, 6 * HOUR_IN_SECONDS );
	return $out;
}

add_action( 'wp_footer', function () {
	if ( ! eb_mmenu_live() || ! function_exists( 'eb_x_ic' ) ) {
		return;
	}
	$svg = function ( $d ) {
		return '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
	};
	$chev  = eb_x_ic( 'chev', 'ebm__go' );
	$bell  = $svg( '<path d="M6 9a6 6 0 0 1 12 0c0 6 2.5 7.5 2.5 7.5h-17S6 15 6 9"/><path d="M10 19.5a2 2 0 0 0 4 0"/>' );
	$tools = function_exists( 'eb_tool_icons' ) ? eb_tool_icons() : array();
	$u     = function ( $p ) {
		return esc_url( home_url( $p ) );
	};

	$h  = '<div class="ebm" id="ebm" role="dialog" aria-modal="true" aria-labelledby="ebm-t" hidden><div class="ebm__sheet">';
	$h .= '<div class="ebm__hd"><h2 class="ebm__t" id="ebm-t">전체 메뉴</h2><button type="button" class="ebm__x" aria-label="메뉴 닫기">' . $svg( '<path d="M6 6l12 12M18 6 6 18"/>' ) . '</button></div>' . ( function_exists( 'eb_notice_menu_html' ) ? eb_notice_menu_html() : '' );
	$h .= '<button type="button" class="ebm__sbox" aria-haspopup="dialog">' . eb_x_ic( 'search' ) . '<span>지원금·계산기·서류 검색</span><i>' . eb_x_ic( 'arrow' ) . '</i></button>';
	$hot4 = function_exists( 'eb_trend_terms' ) ? array_slice( (array) eb_trend_terms()['terms'], 0, 4 ) : array();
	if ( $hot4 ) {
		$h .= '<div class="ebm__hot" aria-label="인기 검색어">';
		foreach ( $hot4 as $w ) {
			$h .= '<a href="' . esc_url( home_url( '/?s=' . rawurlencode( $w ) ) ) . '" data-q="' . esc_attr( $w ) . '">' . esc_html( $w ) . '</a>';
		}
		$h .= '</div>';
	}
	$h .= '<div class="ebm__home">';

	// 최근 본 것(스크립트가 앞에 채움) · 저장한 글 · 알림
	$h .= '<div class="ebm__rec">'
		. '<a class="ebm__ri ebm__ri--s" href="' . $u( '/saved/' ) . '"><i>' . eb_x_ic( 'star' ) . '<b hidden></b></i><span>저장한 글</span></a>'
		. '<a class="ebm__ri ebm__ri--a" href="' . $u( '/saved/#alerts' ) . '"><i>' . $bell . '<b hidden></b></i><span>알림</span></a></div>';
	$h .= '<span class="ebm__ics" hidden><i data-k="calc">' . eb_x_ic( 'calc' ) . '</i><i data-k="guide">' . eb_x_ic( 'map' ) . '</i><i data-k="doc">' . eb_x_ic( 'doc' ) . '</i></span>';
	$h .= '<a class="ebm__cta" href="' . $u( '/find/' ) . '" data-k="맞춤 찾기"><i>' . eb_x_ic( 'compass' ) . '</i><span><strong>맞춤 혜택 찾기</strong><small>나이·사는 곳만 고르면 받을 수 있는 혜택</small></span>' . $chev . '</a>';

	$tabs = array( '상황', '분야', '계산기', '캘린더', '도구' );
	$h   .= '<nav class="ebm__tabs" aria-label="메뉴 칸 바로 가기">';
	foreach ( $tabs as $i => $t ) {
		$h .= '<button type="button" data-to="ebm-s' . ( $i + 1 ) . '"' . ( 0 === $i ? ' aria-current="true"' : '' ) . '>' . $t . '</button>';
	}
	$h .= '</nav>';

	// 1. 상황
	$h .= '<section class="ebm__sec" id="ebm-s1" aria-labelledby="ebm-h1"><div class="ebm__sh"><h3 id="ebm-h1">어떤 상황이세요?</h3><a href="' . $u( '/guide/' ) . '">가이드 전체 ›</a></div><ul class="ebm__g4 ebm__g4--sit">';
	foreach ( function_exists( 'eb_guide_list' ) ? eb_guide_list() : array() as $g ) {
		$h .= '<li><a href="' . $u( $g[0] ) . '" data-k="상황별 가이드" data-n="' . esc_attr( $g[2] ) . '"><i>' . eb_x_ic( $g[1] ) . '</i><span>' . esc_html( $g[4] ) . '</span></a></li>';
	}
	$h .= '</ul></section>';

	// 2. 분야 (메뉴 순서 eb_cat_order, 글 수는 하위 분야 합)
	$icons = array( 'welfare' => 'm-care', 'life' => 'm-pulse', 'finance' => 'm-card', 'work' => 'm-brief' );
	$h    .= '<section class="ebm__sec" id="ebm-s2" aria-labelledby="ebm-h2"><div class="ebm__sh"><h3 id="ebm-h2">분야별 정보</h3></div><div class="ebm__cats">';
	foreach ( get_terms( array( 'taxonomy' => 'category', 'parent' => 0, 'hide_empty' => false, 'exclude' => array( 1 ) ) ) as $top ) {
		$kids = get_terms( array( 'taxonomy' => 'category', 'parent' => $top->term_id, 'hide_empty' => true ) );
		$n    = (int) $top->count;
		foreach ( $kids as $k ) {
			$n += (int) $k->count;
		}
		if ( ! $n ) {
			continue;
		}
		$h .= '<div class="ebm__cat"><a class="ebm__ct" href="' . esc_url( get_term_link( $top ) ) . '" data-k="분야"><i>' . eb_x_ic( isset( $icons[ $top->slug ] ) ? $icons[ $top->slug ] : 'doc' ) . '</i><span>' . esc_html( $top->name ) . '</span><small>글 ' . $n . '개</small>' . $chev . '</a><div class="ebm__subs">';
		foreach ( $kids as $k ) {
			$h .= '<a href="' . esc_url( get_term_link( $k ) ) . '" data-k="' . esc_attr( $top->name ) . '">' . esc_html( $k->name ) . '</a>';
		}
		$h .= '</div></div>';
	}
	$h .= '</div></section>';

	// 3. 계산기
	$h .= '<section class="ebm__sec" id="ebm-s3" aria-labelledby="ebm-h3"><div class="ebm__sh"><h3 id="ebm-h3">계산기</h3><a href="' . $u( '/calculator/' ) . '">' . count( eb_calc_catalog() ) . '개 모두 ›</a></div><ul class="ebm__g4">';
	$all = eb_mmenu_calcs();
	foreach ( $all as $i => $c ) {
		$ic  = isset( $tools[ $c['s'] ] ) ? $svg( $tools[ $c['s'] ] ) : eb_x_ic( 'calc' );
		$h  .= '<li' . ( $i >= 7 ? ' class="ebm__more" hidden' : '' ) . '><a href="' . esc_url( $c['u'] ) . '" data-k="계산기" data-n="' . esc_attr( preg_match( '/계산기$/u', $c['n'] ) ? $c['n'] : $c['n'] . ' 계산기' ) . '"><i>' . $ic . '</i><span>' . esc_html( $c['n'] ) . '</span></a></li>';
	}
	$h .= '<li><a href="' . $u( '/standards/' ) . '" data-k="계산기·기준표" data-n="2026 복지 기준표"><i>' . eb_x_ic( 'table' ) . '</i><span>2026 기준표</span></a></li></ul></section>';

	// 4. 캘린더
	$pays = array();
	foreach ( function_exists( 'eb_x_paydays' ) ? eb_x_paydays() : array() as $p ) {
		$parts  = explode( '·', $p['w'] );
		$pays[] = array( 'd' => $p['d'], 'l' => $p['l'], 'w' => $parts[0] . ( count( $parts ) > 1 ? ' 외 ' . ( count( $parts ) - 1 ) . '종' : '' ) );
	}
	$dues = array();
	foreach ( function_exists( 'eb_upcoming_dues' ) ? eb_upcoming_dues( current_datetime()->setTime( 0, 0 ), 80 ) : array() as $x ) {
		$dues[] = array( 'n' => $x['n'], 'e' => $x['e'], 'el' => $x['el'], 's' => $x['s'], 'sl' => $x['sl'] );
	}
	$h .= '<section class="ebm__sec" id="ebm-s4" aria-labelledby="ebm-h4"><div class="ebm__sh"><h3 id="ebm-h4">복지 캘린더</h3><a href="' . $u( '/schedule/' ) . '">전체 ›</a></div>'
		. '<div class="ebm__cal" data-pay="' . esc_attr( wp_json_encode( $pays ) ) . '" data-due="' . esc_attr( wp_json_encode( $dues ) ) . '"><a class="ebm__tk" href="' . $u( '/schedule/' ) . '"><span class="ebm__dd">일정</span><span class="ebm__tw">다가오는 지급일·신청 일정<small>복지 캘린더</small></span>' . $chev . '</a></div>'
		. '<div class="ebm__c3"><a href="' . $u( '/schedule/#calendar' ) . '" data-k="복지 캘린더" data-n="이번 달 지급일 달력">이번 달 지급일</a><a href="' . $u( '/schedule/#yearly' ) . '" data-k="복지 캘린더" data-n="연간 신청 일정">연간 일정</a><a href="' . $u( '/schedule/#applying' ) . '" data-k="복지 캘린더" data-n="지금 신청할 수 있는 지원">접수 중 <em class="ebm__n" hidden></em></a></div></section>';

	// 5. 도구
	$tl = array(
		array( '/forms/', 'doc', '공식 서식 모음' ),
		array( '/links/', 'bank', '공식 기관 모음' ),
		array( '/nearby/', 'map', '우리 동네 복지 기관' ),
		array( '/hotline/', 'phone', '긴급·상담 전화' ),
		array( '/address/', 'pin', '주소·영문주소 찾기' ),
		array( '/glossary/', 'book', '복지 용어사전' ),
		array( '/senior-equipment/', 'user', '어르신 복지용구' ),
	);
	$h .= '<section class="ebm__sec" id="ebm-s5" aria-labelledby="ebm-h5"><div class="ebm__sh"><h3 id="ebm-h5">바로 쓰는 도구</h3></div><div class="ebm__rows">';
	foreach ( $tl as $t ) {
		$h .= '<a href="' . $u( $t[0] ) . '" data-k="도구"><i>' . eb_x_ic( $t[1] ) . '</i><span>' . esc_html( $t[2] ) . '</span>' . $chev . '</a>';
	}
	$h .= '</div></section>';

	// 설정·안내
	$h .= '<section class="ebm__sec ebm__sec--set" aria-label="설정과 사이트 안내"><div class="ebm__set"><span>글자 크기</span><div class="eb-fsseg ebm__fs" role="group" aria-label="글자 크기">'
		. '<button type="button" data-fs="1" aria-pressed="true" aria-label="기본 글자">가</button><button type="button" data-fs="2" aria-pressed="false" aria-label="큰 글자">가+</button><button type="button" data-fs="3" aria-pressed="false" aria-label="아주 큰 글자">가++</button></div></div>'
		. '<a class="ebm__set" href="#install">앱으로 설치하기' . $chev . '</a>'
		. '<div class="ebm__info"><a href="' . $u( '/about/' ) . '">사이트 소개</a><a href="' . $u( '/contact/' ) . '">문의하기</a><a href="' . $u( '/support/' ) . '">후원·돕는 방법</a><a href="' . $u( '/partners/' ) . '">협업·제휴</a></div></section>';
	$h .= '<div class="ebm__foot"><p>공식 기관이 아닌 민간 정보 사이트예요. 신청 전에는 담당 기관에서 한 번 더 확인해 주세요.</p><div><a href="' . $u( '/privacy-policy/' ) . '">개인정보처리방침</a><a href="' . $u( '/terms-of-service/' ) . '">이용약관</a><a href="' . $u( '/disclaimer/' ) . '">면책공고</a></div><small>© 2023–' . esc_html( wp_date( 'Y' ) ) . ' 이지복지닷컴</small></div>';
	$h .= '</div></div></div>';

	$hot = array();
	foreach ( array_slice( function_exists( 'eb_x_trend' ) ? (array) eb_x_trend() : array(), 0, 8 ) as $x ) {
		$hot[] = $x['q'];
	}
	echo $h; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<script nowprocket>window.ebMmenu=' . wp_json_encode( array( 'hot' => $hot, 'home' => home_url( '/' ), 'idx' => rest_url( 'eb/v1/search-index' ) ) ) . ";</script>\n";
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var M = document.getElementById('ebm');
	if (!M) { return; }
	var D = window.ebMmenu || {}, H = document.documentElement, opener = null, pushed = false;
	var home = M.querySelector('.ebm__home');
	var hd = M.querySelector('.ebm__hd'), tabs = M.querySelector('.ebm__tabs'), tabBtns = [].slice.call(tabs.querySelectorAll('button'));
	var secs = tabBtns.map(function (b) { return document.getElementById(b.getAttribute('data-to')); });
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function get(k, d) { try { return JSON.parse(localStorage.getItem(k) || d) || JSON.parse(d); } catch (e) { return JSON.parse(d); } }
	function ic(k) { var i = M.querySelector('.ebm__ics [data-k="' + k + '"]'); return i ? i.innerHTML : ''; }
	function ymd(d) { return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2); }
	var now = new Date(), T0 = new Date(now.getFullYear(), now.getMonth(), now.getDate()), T = ymd(T0);
	function days(s) { var p = s.split('-'); return Math.round((new Date(+p[0], p[1] - 1, +p[2]) - T0) / 864e5); }

	// 기록 줄: 최근 본 것 3개 + 저장한 글·알림 숫자
	function badge(sel, n) { var b = M.querySelector(sel + ' b'); if (b) { b.hidden = !n; b.textContent = n > 99 ? '99+' : n; } }
	function paintRec() {
		var row = M.querySelector('.ebm__rec'), here = location.origin + location.pathname;
		row.querySelectorAll('.ebm__ri--r').forEach(function (x) { x.remove(); });
		var rec = get('eb_recent', '[]').filter(function (x) { return x && x.u && x.t && x.u !== here; }).slice(0, 3);
		var first = row.firstChild;
		rec.forEach(function (x) {
			var a = document.createElement('a'), k = /\/calculator\//.test(x.u) ? 'calc' : (/\/guide\//.test(x.u) ? 'guide' : 'doc');
			a.className = 'ebm__ri ebm__ri--r';
			a.href = x.u;
			a.setAttribute('aria-label', '최근 본 글: ' + x.t);
			a.innerHTML = '<i>' + ic(k) + '</i><span>' + esc(x.t) + '</span>';
			row.insertBefore(a, first);
		});
		badge('.ebm__ri--s', get('eb_saved', '[]').filter(function (x) { return x && x.u; }).length);
		badge('.ebm__ri--a', get('ebs_push', '[]').length);
	}

	// 캘린더: 가장 가까운 일정 한 줄 + 이번 주 개수, '접수 중' 숫자
	function paintCal() {
		var c = M.querySelector('.ebm__cal');
		if (!c) { return; }
		var pays = JSON.parse(c.getAttribute('data-pay') || '[]'), dues = JSON.parse(c.getAttribute('data-due') || '[]'), items = [];
		pays.forEach(function (x) { if (x.d >= T) { items.push({ d: x.d, l: x.l, w: x.w + ' 지급' }); } });
		var open = 0;
		dues.forEach(function (x) {
			var on = !x.s || x.s <= T;
			if (x.e < T) { return; }
			if (on) { open++; }
			items.push({ d: on ? x.e : x.s, l: on ? x.el : x.sl, w: x.n + (on ? ' 마감' : ' 접수 시작') });
		});
		items.sort(function (a, b) { return a.d < b.d ? -1 : (a.d > b.d ? 1 : 0); });
		var n = M.querySelector('.ebm__n');
		if (n) { n.hidden = !open; n.textContent = open; }
		var f = items[0];
		if (!f) { return; }
		var g = days(f.d), more = items.filter(function (x) { return days(x.d) <= 7; }).length - 1;
		var a = c.querySelector('.ebm__tk');
		a.href = '/schedule/#d-' + f.d;
		a.querySelector('.ebm__dd').textContent = g ? 'D-' + g : '오늘';
		a.querySelector('.ebm__tw').innerHTML = esc(f.l + ' ' + f.w) + '<small>' + (more > 0 ? '이번 주 일정 ' + more + '개 더' : '다음 일정') + '</small>';
	}

	// 열기·닫기 (뒤로 가기로도 닫힘)
	function focusables() { return [].filter.call(M.querySelectorAll('a[href], button, input'), function (e) { return !e.disabled && e.offsetParent !== null; }); }
	function open(from) {
		if (!M.hidden) { return; }
		opener = from || document.activeElement;
		paintRec();
		paintCal();
		M.hidden = false;
		M.scrollTop = 0;
		H.classList.add('ebm-open');
		requestAnimationFrame(function () { requestAnimationFrame(function () { M.classList.add('is-in'); }); });
		document.querySelectorAll('.ebt__menu, .menu-toggle').forEach(function (b) { b.setAttribute('aria-expanded', 'true'); });
		try { history.pushState({ ebm: 1 }, ''); pushed = true; } catch (e) {}
		setTimeout(function () { M.querySelector('.ebm__x').focus({ preventScroll: true }); }, 40);
		spy();
	}
	function shut() {
		if (M.hidden) { return; }
		M.classList.remove('is-in');
		H.classList.remove('ebm-open');
		document.querySelectorAll('.ebt__menu, .menu-toggle').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
		setTimeout(function () { M.hidden = true; }, reduce ? 0 : 200);
		if (opener && opener.focus && opener.offsetParent !== null) { opener.focus({ preventScroll: true }); }
	}
	function close() {
		if (M.hidden) { return; }
		if (pushed) { pushed = false; history.back(); } else { shut(); }
	}
	// 메뉴에서 다른 페이지로 갈 때는 메뉴를 열며 만든 기록을 먼저 지움 → 뒤로 가기 한 번에 이전 페이지로
	var go = null;
	function nav(u) {
		if (!pushed) { location.href = u; return; }
		go = u;
		pushed = false;
		history.back();
		setTimeout(function () { if (go) { var g = go; go = null; location.href = g; } }, 400);
	}
	window.addEventListener('popstate', function () { if (go) { var g = go; go = null; location.href = g; return; } if (!M.hidden) { pushed = false; shut(); } });
	window.addEventListener('pageshow', function (e) { if (e.persisted && !M.hidden) { M.classList.remove('is-in'); M.hidden = true; H.classList.remove('ebm-open'); } });
	document.addEventListener('click', function (e) {
		var t = e.target.closest && e.target.closest('.ebt__menu, #mobile-header .menu-toggle, .main-navigation .menu-toggle');
		if (!t) { return; }
		e.preventDefault();
		e.stopImmediatePropagation();
		open(t.closest('.ebt__menu') || t);
	}, true);
	M.querySelector('.ebm__x').addEventListener('click', close);
	M.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') { e.preventDefault(); close(); return; }
		if (e.key !== 'Tab') { return; }
		var f = focusables();
		if (!f.length) { return; }
		if (e.shiftKey && document.activeElement === f[0]) { e.preventDefault(); f[f.length - 1].focus(); }
		else if (!e.shiftKey && document.activeElement === f[f.length - 1]) { e.preventDefault(); f[0].focus(); }
	});
	// 같은 페이지 안 주소(#…)로 가는 링크는 메뉴를 닫고 이동
	M.addEventListener('click', function (e) {
		var a = e.target.closest('a[href]');
		if (!a || a.getAttribute('href') === '#install') { return; }
		var url = new URL(a.href, location.href);
		if (url.pathname === location.pathname && url.hash) { e.preventDefault(); pushed = false; shut(); try { history.replaceState(null, '', url.hash); } catch (x) {} setTimeout(function () { window.dispatchEvent(new HashChangeEvent('hashchange')); var el = document.getElementById(decodeURIComponent(url.hash.slice(1))); if (el) { el.scrollIntoView({ block: 'start' }); } }, 220); return; }
		if (e.button === 0 && !e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey && a.target !== '_blank' && url.origin === location.origin) { e.preventDefault(); nav(a.href); }
	});

	// 탭: 누르면 그 칸으로, 내리면 지금 칸 표시
	function stick() { return hd.offsetHeight + tabs.offsetHeight; }
	tabBtns.forEach(function (b, i) {
		b.addEventListener('click', function () {
			var s = secs[i];
			if (!s) { return; }
			M.scrollTo({ top: M.scrollTop + s.getBoundingClientRect().top - M.getBoundingClientRect().top - stick() + 1, behavior: reduce ? 'auto' : 'smooth' });
		});
	});
	var tick = false;
	function spy() {
		tick = false;
		var top = M.getBoundingClientRect().top + stick() + 40, k = 0;
		secs.forEach(function (s, i) { if (s && s.getBoundingClientRect().top <= top) { k = i; } });
		if (M.scrollTop + M.clientHeight >= M.scrollHeight - 4) { k = secs.length - 1; }
		tabBtns.forEach(function (b, i) { if (i === k) { b.setAttribute('aria-current', 'true'); } else { b.removeAttribute('aria-current'); } });
		tabs.classList.toggle('is-stuck', tabs.getBoundingClientRect().top <= M.getBoundingClientRect().top + hd.offsetHeight + 1);
	}
	M.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(spy); } }, { passive: true });

	// 지금 보고 있는 페이지 표시
	home.querySelectorAll('a[href]').forEach(function (a) { if (a.pathname === location.pathname && !a.hash && a.pathname !== '/') { a.setAttribute('aria-current', 'page'); } });
	// 검색 막대 → 68-2번 검색 화면. 검색 화면이 메뉴를 잠시 숨겼다가 ←로 다시 보여 줄 때 씀
	window.ebmApi = {
		hide: function () { pushed = false; M.classList.remove('is-in'); M.hidden = true; H.classList.remove('ebm-open'); },
		show: function () { M.hidden = false; M.classList.add('is-in'); H.classList.add('ebm-open'); pushed = true; var b = M.querySelector('.ebm__sbox'); if (b) { b.focus({ preventScroll: true }); } }
	};
	M.querySelector('.ebm__sbox').addEventListener('click', function (e) { if (window.ebsrOpen) { window.ebsrOpen({ menu: true, from: e.currentTarget }); } });
	// 인기 검색어 칩을 누르면 최근 검색어에도 남김
	M.addEventListener('click', function (e) { var a = e.target.closest('a[data-q]'); if (!a) { return; } try { var v = a.getAttribute('data-q'), r = JSON.parse(localStorage.getItem('eb_q')) || []; localStorage.setItem('eb_q', JSON.stringify([v].concat(r.filter(function (w) { return w !== v; })).slice(0, 5))); } catch (x) {} }, true);
})();
JS
	. "\n</script>\n";
}, 85 );

/* 68-2. 휴대폰 검색 화면 #ebsr (2026-10-16 검색 시안 3장, css/60-mobile-bar.css 끝 '검색 화면') ------------------------
 * 하단 탭 '검색'과 전체 메뉴 맨 위 검색칸이 같은 화면을 엶. (예전 위에서 내려오던 검색 창 .ebt-s는 삭제)
 * 빈 상태: 최근 검색어(eb_q, ✕로 하나씩·전체 삭제) · 상황으로 찾기(가이드 8개) · 인기 검색어 10(40번 eb_trend_terms, 순위 변동) · 캘린더·서식·용어사전
 * 입력하면: 바로가기(메뉴·계산기·가이드·안내·용어) · 이지복지닷컴 글 · 정부 복지서비스(복지로, 새 창) - 16번 검색 색인(/wp-json/eb/v1/search-index)
 * Enter·'검색'·'전체 검색 결과 보기'는 사이트 검색(/?s=). 메뉴에서 열었으면 ←는 메뉴로, 휴대폰 뒤로 가기는 페이지로
 */
add_action( 'wp_footer', function () {
	if ( ! eb_mmenu_live() || ! function_exists( 'eb_x_ic' ) ) {
		return;
	}
	$svg = function ( $d ) {
		return '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
	};
	$u = function ( $p ) {
		return esc_url( home_url( $p ) );
	};
	$h  = '<div class="ebsr" id="ebsr" role="dialog" aria-modal="true" aria-label="검색" hidden><div class="ebsr__in">';
	$h .= '<form class="ebsr__bar" role="search" action="' . $u( '/' ) . '"><button type="button" class="ebsr__back" aria-label="검색 닫기">' . $svg( '<path d="M15 5l-7 7 7 7"/>' ) . '</button>'
		. '<div class="ebsr__f">' . eb_x_ic( 'search' ) . '<input type="search" class="ebsr__q" placeholder="지원금·계산기·서류 검색" aria-label="검색어" autocomplete="off" enterkeyhint="search">'
		. '<button type="button" class="ebsr__x" aria-label="검색어 지우기" hidden>' . $svg( '<circle cx="12" cy="12" r="9"/><path d="m9.5 9.5 5 5M14.5 9.5l-5 5"/>' ) . '</button></div>'
		. '<button type="submit" class="ebsr__go" hidden>검색</button></form>';
	$h .= '<div class="ebsr__idle">';
	$h .= '<section class="ebsr__sec ebsr__rec" aria-labelledby="ebsr-h1" hidden><div class="ebsr__h"><h2 id="ebsr-h1">최근 검색어</h2><button type="button" class="ebsr__clr">전체 삭제</button></div><div class="ebsr__chips"></div></section>';
	$h .= '<section class="ebsr__sec" aria-labelledby="ebsr-h2"><div class="ebsr__h"><h2 id="ebsr-h2">상황으로 찾기</h2><a href="' . $u( '/guide/' ) . '">가이드 8개 ›</a></div><div class="ebsr__sit">';
	foreach ( function_exists( 'eb_guide_list' ) ? eb_guide_list() : array() as $g ) {
		$h .= '<a href="' . $u( $g[0] ) . '" title="' . esc_attr( $g[2] ) . '">' . eb_x_ic( $g[1] ) . '<span>' . esc_html( $g[4] ) . '</span></a>';
	}
	$h .= '</div></section>';
	$tr = function_exists( 'eb_trend_terms' ) ? (array) eb_trend_terms() : array();
	$terms = array_slice( isset( $tr['terms'] ) ? (array) $tr['terms'] : array(), 0, 10 );
	if ( $terms ) {
		$h .= '<section class="ebsr__sec" aria-labelledby="ebsr-h3"><div class="ebsr__h"><h2 id="ebsr-h3">인기 검색어</h2><small>최근 24시간</small></div><ol class="ebsr__rank">';
		foreach ( $terms as $i => $w ) {
			$m = isset( $tr['moves'][ $i ] ) ? $tr['moves'][ $i ] : 0;
			if ( 'new' === $m ) {
				$mv = '<em class="is-new" aria-label="새로 오름">NEW</em>';
			} elseif ( (int) $m > 0 ) {
				$mv = '<em class="is-up" aria-label="' . (int) $m . '계단 오름">▲' . (int) $m . '</em>';
			} elseif ( (int) $m < 0 ) {
				$mv = '<em class="is-down" aria-label="' . abs( (int) $m ) . '계단 내림">▼' . abs( (int) $m ) . '</em>';
			} else {
				$mv = '<em aria-label="순위 그대로">–</em>';
			}
			$h .= '<li><a href="' . esc_url( home_url( '/?s=' . rawurlencode( $w ) ) ) . '" data-q="' . esc_attr( $w ) . '"><b>' . ( $i + 1 ) . '</b><span>' . esc_html( $w ) . '</span>' . $mv . '</a></li>';
		}
		$h .= '</ol></section>';
	}
	$h .= '<section class="ebsr__sec" aria-label="자주 쓰는 곳"><div class="ebsr__qk"><a href="' . $u( '/schedule/' ) . '">' . eb_x_ic( 'cal' ) . '복지 캘린더</a><a href="' . $u( '/forms/' ) . '">' . eb_x_ic( 'doc' ) . '공식 서식</a><a href="' . $u( '/glossary/' ) . '">' . eb_x_ic( 'book' ) . '용어사전</a></div></section>';
	$h .= '</div><div class="ebsr__res" aria-live="polite" hidden></div>';
	$h .= '<span class="ebsr__ics" hidden><i data-k="calc">' . eb_x_ic( 'calc' ) . '</i><i data-k="guide">' . eb_x_ic( 'map' ) . '</i><i data-k="doc">' . eb_x_ic( 'doc' ) . '</i><i data-k="book">' . eb_x_ic( 'book' ) . '</i><i data-k="bank">' . eb_x_ic( 'bank' ) . '</i><i data-k="ext">' . eb_x_ic( 'ext' ) . '</i><i data-k="search">' . eb_x_ic( 'search' ) . '</i><i data-k="del">' . $svg( '<path d="M7 7l10 10M17 7 7 17"/>' ) . '</i></span>';
	$h .= '</div></div>';
	echo $h; // phpcs:ignore WordPress.Security.EscapeOutput
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var S = document.getElementById('ebsr');
	if (!S) { return; }
	var D = window.ebMmenu || {}, H = document.documentElement, SYN = window.ebSearchSyn || {};
	var q = S.querySelector('.ebsr__q'), x = S.querySelector('.ebsr__x'), go = S.querySelector('.ebsr__go'), idle = S.querySelector('.ebsr__idle'), res = S.querySelector('.ebsr__res');
	var recBox = S.querySelector('.ebsr__rec'), chips = S.querySelector('.ebsr__chips');
	var pushed = false, fromMenu = false, opener = null, pend = null, idx = null, loading = false;
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function ic(k) { var i = S.querySelector('.ebsr__ics [data-k="' + k + '"]'); return i ? i.innerHTML : ''; }
	function getQ() { try { return JSON.parse(localStorage.getItem('eb_q')) || []; } catch (e) { return []; } }
	function setQ(a) { try { if (a.length) { localStorage.setItem('eb_q', JSON.stringify(a)); } else { localStorage.removeItem('eb_q'); } } catch (e) {} }
	function remember(v) { v = String(v).trim(); if (!v) { return; } setQ([v].concat(getQ().filter(function (w) { return w !== v; })).slice(0, 5)); }
	function surl(v) { return (D.home || '/') + '?s=' + encodeURIComponent(v); }
	function paintRec() {
		var a = getQ();
		recBox.hidden = !a.length;
		chips.innerHTML = a.map(function (w) { return '<span class="ebsr__chip"><a href="' + esc(surl(w)) + '" data-q="' + esc(w) + '">' + esc(w) + '</a><button type="button" data-del="' + esc(w) + '" aria-label="최근 검색어 ' + esc(w) + ' 지우기">' + ic('del') + '</button></span>'; }).join('');
	}
	function loadIdx() {
		if (idx || loading) { return; }
		loading = true;
		fetch(D.idx || '/wp-json/eb/v1/search-index').then(function (r) { return r.json(); }).then(function (j) { idx = Array.isArray(j) ? j : []; if (q.value.trim()) { run(); } }, function () { loading = false; });
	}

	// 열기·닫기
	function open(o) {
		o = o || {};
		if (!S.hidden) { return; }
		fromMenu = !!(o.menu && window.ebmApi);
		opener = o.from || document.activeElement;
		paintRec();
		q.value = o.q || '';
		sync();
		S.hidden = false;
		S.scrollTop = 0;
		H.classList.add('ebt-s-open');
		q.focus({ preventScroll: true }); // 누른 그 순간에 포커스해야 휴대폰 키보드가 바로 올라옴
		requestAnimationFrame(function () { requestAnimationFrame(function () { S.classList.add('is-in'); }); });
		if (fromMenu) {
			window.ebmApi.hide();
			try { history.replaceState({ ebsr: 1 }, ''); } catch (e) {}
		} else {
			try { history.pushState({ ebsr: 1 }, ''); } catch (e) {}
		}
		pushed = true;
		document.querySelectorAll('.ebt__search').forEach(function (b) { b.setAttribute('aria-expanded', 'true'); });
		loadIdx();
	}
	function shut(keepFocus) {
		if (S.hidden) { return; }
		S.classList.remove('is-in');
		H.classList.remove('ebt-s-open');
		document.querySelectorAll('.ebt__search').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
		var hide = function () { S.hidden = true; q.value = ''; sync(); };
		if (reduce || keepFocus) { hide(); } else { setTimeout(hide, 180); }
		if (!keepFocus && opener && opener.focus && opener.offsetParent !== null) { opener.focus({ preventScroll: true }); }
	}
	function close() {
		if (S.hidden) { return; }
		if (pushed) { pushed = false; history.back(); } else { shut(); }
	}
	// ←: 메뉴에서 열었으면 메뉴로 돌아감
	S.querySelector('.ebsr__back').addEventListener('click', function () {
		if (fromMenu && window.ebmApi) {
			try { history.replaceState({ ebm: 1 }, ''); } catch (e) {}
			pushed = false;
			shut(true);
			window.ebmApi.show();
			return;
		}
		close();
	});
	function nav(u) {
		if (!pushed) { location.href = u; return; }
		pend = u;
		pushed = false;
		history.back();
		setTimeout(function () { if (pend) { var g = pend; pend = null; location.href = g; } }, 400);
	}
	window.addEventListener('popstate', function () {
		if (pend) { var g = pend; pend = null; location.href = g; return; }
		if (!S.hidden) { pushed = false; shut(); }
	});
	window.addEventListener('pageshow', function (e) { if (e.persisted && !S.hidden) { S.classList.remove('is-in'); S.hidden = true; H.classList.remove('ebt-s-open'); } });
	document.addEventListener('click', function (e) {
		var t = e.target.closest && e.target.closest('.ebt__search');
		if (!t) { return; }
		e.preventDefault();
		e.stopImmediatePropagation();
		open({ from: t });
	}, true);
	window.ebsrOpen = open;

	// 검색 결과 페이지(/?s=, 휴대폰·태블릿): 제목 아래에 지금 검색어가 든 검색 막대 → 누르면 이 검색 화면이 검색어를 채운 채로 열림
	var sh = document.querySelector('.search .eb-search-head');
	if (sh) {
		var cq = new URLSearchParams(location.search).get('s') || '';
		var again = document.createElement('button');
		again.type = 'button';
		again.className = 'ebsr-again';
		again.setAttribute('aria-label', '검색어 바꾸기, 지금 검색어 ' + cq);
		again.innerHTML = ic('search') + '<span>' + esc(cq) + '</span><small>바꾸기</small>';
		sh.appendChild(again);
		again.addEventListener('click', function () { open({ from: again, q: cq }); try { q.setSelectionRange(q.value.length, q.value.length); } catch (x) {} });
	}

	// 화면 안 누르기: 최근 검색어 지우기 · 링크(검색어는 최근 검색어에 남김, 새 창 링크는 그대로)
	S.addEventListener('click', function (e) {
		var del = e.target.closest('[data-del]');
		if (del) { var w = del.getAttribute('data-del'); setQ(getQ().filter(function (v) { return v !== w; })); paintRec(); var nx = chips.querySelector('[data-del]'); if (nx) { nx.focus({ preventScroll: true }); } return; } // 지운 뒤 키보드가 갑자기 올라오지 않게 입력칸 대신 다음 ✕로
		if (e.target.closest('.ebsr__clr')) { setQ([]); paintRec(); S.querySelector('.ebsr__back').focus({ preventScroll: true }); return; }
		var a = e.target.closest('a[href]');
		if (!a || a.target === '_blank' || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) { return; }
		if (a.hasAttribute('data-q')) { remember(a.getAttribute('data-q')); }
		var url = new URL(a.href, location.href);
		if (url.origin !== location.origin) { return; }
		e.preventDefault();
		nav(a.href);
	});
	S.querySelector('.ebsr__bar').addEventListener('submit', function (e) {
		e.preventDefault();
		var v = q.value.trim();
		if (!v) { q.focus(); return; }
		remember(v);
		nav(surl(v));
	});
	x.addEventListener('click', function () { q.value = ''; sync(); q.focus(); });
	q.addEventListener('input', sync);
	S.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') { e.preventDefault(); if (q.value) { q.value = ''; sync(); } else { close(); } return; }
		if (e.key !== 'Tab') { return; }
		var f = [].filter.call(S.querySelectorAll('a[href], button, input'), function (el) { return !el.disabled && el.offsetParent !== null; });
		if (!f.length) { return; }
		if (e.shiftKey && document.activeElement === f[0]) { e.preventDefault(); f[f.length - 1].focus(); }
		else if (!e.shiftKey && document.activeElement === f[f.length - 1]) { e.preventDefault(); f[0].focus(); }
	});

	// 입력할 때마다 걸러 보여 주기
	function sync() {
		var v = q.value.trim();
		x.hidden = !q.value;
		go.hidden = !v;
		idle.hidden = !!v;
		res.hidden = !v;
		S.classList.toggle('is-typing', !!v);
		if (v) { loadIdx(); run(); }
	}
	function norm(s) { return String(s).toLowerCase().replace(/\s+/g, ''); }
	function terms(v) {
		var n = norm(v), out = [n];
		Object.keys(SYN).forEach(function (k) { if (n.indexOf(norm(k)) > -1) { (SYN[k] || []).forEach(function (w) { out.push(norm(w)); }); } });
		return out;
	}
	var words = [];
	function score(t, ts) {
		var n = norm(t), best = -1;
		ts.forEach(function (w, i) { var p = n.indexOf(w); if (p > -1) { var s = (p === 0 ? 0 : 1) + (i ? 2 : 0); if (best < 0 || s < best) { best = s; } } });
		// 띄어 쓴 여러 단어('근로장려금 신청')는 단어가 모두 들어 있으면 맞음(동의어도 단어별로)
		if (best < 0 && words.length > 1 && words.every(function (ws) { return ws.some(function (w) { return n.indexOf(w) > -1; }); })) { best = 3; }
		return best;
	}
	function mark(t, v) {
		var p = norm(t).indexOf(norm(v));
		if (p < 0 || !v.trim()) { return esc(t); }
		var i = 0, c = 0, s = -1, e = -1, L = norm(v).length;
		for (; i < t.length; i++) { if (/\s/.test(t[i])) { continue; } if (c === p) { s = i; } if (c === p + L - 1) { e = i + 1; break; } c++; }
		return s < 0 || e < 0 ? esc(t) : esc(t.slice(0, s)) + '<mark>' + esc(t.slice(s, e)) + '</mark>' + esc(t.slice(e));
	}
	function row(o, v) {
		return '<a class="ebsr__hit' + (o.ext ? ' is-gov' : '') + '" href="' + esc(o.u) + '"' + (o.ext ? ' target="_blank" rel="noopener"' : '') + '><i>' + ic(o.i) + '</i><span>' + mark(o.t, v) + '<small>' + esc(o.s) + '</small></span>' + (o.ext ? '<b class="ebsr__ext">' + ic('ext') + '</b>' : '') + '</a>';
	}
	var KIND = { '가이드': 'guide', '상황별 가이드': 'guide', '계산기': 'calc', '계산기·기준표': 'calc', '용어': 'book' };
	function run() {
		var v = q.value.trim(), ts = terms(v), used = {}, quick = [], posts = [], gov = [], nPost = 0, nGov = 0;
		words = v.split(/\s+/).filter(Boolean).map(terms);
		var menu = [], seen = {};
		document.querySelectorAll('#ebm .ebm__home a[data-k]').forEach(function (a) {
			if (seen[a.href]) { return; }
			seen[a.href] = 1;
			menu.push({ t: a.getAttribute('data-n') || a.textContent.trim().replace(/\s+/g, ' '), u: a.href, k: a.getAttribute('data-k') });
		});
		menu.map(function (m) { var s = score(m.t, ts), g = s < 0 ? score(m.k || '', ts) : -1; return { m: m, s: s > -1 ? s : (g > -1 ? g + 4 : -1) }; })
			.filter(function (o) { return o.s > -1; }).sort(function (a, b) { return a.s - b.s; })
			.forEach(function (o) { if (quick.length < 5 && !used[o.m.u]) { used[o.m.u] = 1; quick.push({ t: o.m.t, u: o.m.u, s: o.m.k, i: KIND[o.m.k] || 'doc' }); } });
		if (idx) {
			var tool = { '가이드': 1, '계산기': 1, '안내': 1, '용어': 1 };
			idx.map(function (it) { return { it: it, s: score(it.t, ts) }; }).filter(function (o) { return o.s > -1; }).sort(function (a, b) { return a.s - b.s; }).forEach(function (o) {
				var it = o.it;
				if (it.l === '복지로') { nGov++; if (gov.length < 3) { gov.push({ t: it.t, u: it.u, s: (it.o ? it.o + ' · ' : '') + '새 창', i: 'bank', ext: 1 }); } return; }
				var u = String(it.u).replace(/^https?:\/\/[^/]+/, location.origin);
				if (used[u]) { return; }
				if (tool[it.l]) { if (quick.length < 5) { used[u] = 1; quick.push({ t: it.t, u: u, s: it.l === '용어' ? '복지 용어' : it.l, i: KIND[it.l] || 'doc' }); } return; }
				nPost++;
				if (posts.length < 5) { used[u] = 1; posts.push({ t: it.t, u: u, s: it.l, i: 'doc' }); }
			});
		}
		var h = '';
		if (quick.length) { h += '<p class="ebsr__gl"><span>바로가기</span></p>' + quick.map(function (o) { return row(o, v); }).join(''); }
		if (posts.length) { h += '<p class="ebsr__gl"><span>이지복지닷컴 글</span><span>' + nPost + '</span></p>' + posts.map(function (o) { return row(o, v); }).join(''); }
		else if (!idx) { h += '<p class="ebsr__gl"><span>글 찾는 중…</span></p>'; }
		if (gov.length) { h += '<p class="ebsr__gl"><span>정부 복지서비스 (복지로)</span><span>' + nGov + '</span></p>' + gov.map(function (o) { return row(o, v); }).join(''); }
		if (idx && !quick.length && !posts.length && !gov.length) { h += '<p class="ebsr__none">\'' + esc(v) + '\'에 맞는 메뉴·글을 바로 찾지 못했어요. 아래 버튼으로 사이트 전체에서 찾아보세요.</p>'; }
		h += '<a class="ebsr__all" href="' + esc(surl(v)) + '" data-q="' + esc(v) + '">\'' + esc(v) + '\' 전체 검색 결과 보기</a>';
		res.innerHTML = h;
	}
})();
JS
	. "\n</script>\n";
}, 86 );

/* 69. 글 속 관련 영상 손질 (2026-10-16, css/20-post.css 끝 '관련 영상 출처') -------------------------------------------
 * 글 본문은 고치지 않고(최종 수정일 그대로) 화면에 보여 줄 때만:
 *  ① 재생 안 되거나 개인 채널이던 영상 중 주제가 같은 공식 채널 영상이 있는 7개를 바꿔 끼움(eb_vid_swap)
 *  ② 소제목 '관련영상' → '관련 영상'(띄어쓰기 통일, 목차에도 같게)
 *  ③ 영상 바로 아래 출처 줄: 채널 이름 + 공식 기관/언론/참고 영상 표시 + 영상 제목 + 'YouTube에서 보기'
 *     채널 이름·제목은 유튜브 oEmbed에서 받아 옵션 eb_yt_meta에 30일 저장(실패하면 7일 뒤 다시)
 * 끄기: eb_vid_live() false
 */
function eb_vid_live() {
	return true;
}

// 옛 영상 ID => 새 영상 ID (2026-10-16 확인, 모두 퍼가기 허용)
function eb_vid_swap() {
	return array(
		'-yC_tBf1X2o' => 'F0mtBWH23X8', // 7721 알바 퇴직금 지급기준: 재생 안 됨 → 1350 고용노동부 고객상담센터 '퇴직금 지급 기준 한방 정리'
		'5qPV6jMe6lI' => 'R9BXB4FlGq4', // 5215 화물운전자 보수교육: 재생 안 됨 → 경기도교통연수원 '2026년 화물 동영상(VOD)교육 수강 방법'
		'I1qdm-jPwIQ' => '-G50StfdHds', // 2930 디딤씨앗통장: 개인 채널 → 국가아동권리보장원
		'K-D8haOcuoo' => 'zNIV-Hd2hhI', // 3253 손목닥터 9988: 개인 채널 → 서울시
		'9PIIkxdJt1Y' => 'fz-33v3nhE4', // 6583 경차 유류세 환급: 개인 채널 → 국세청
		'CZXay4kJlpM' => 'EdQxXOvmIqs', // 8194 간이대지급금: 노무사 채널 → KTV 국민방송
		'8Trj_LLHwKA' => 'Xgb2btcKyr4', // 11363 고향사랑기부제: 개인 채널 → 행정안전부
	);
}

// 채널 이름 → 공식 기관(off) / 언론(press) / 참고 영상(ref)
function eb_vid_kind( $author ) {
	if ( preg_match( '/(부$|부TV|청$|청TV|공단|공사|공제회|위원회|보장원|연수원|정부|광역시|특별시|서울시|경기도|KTV|국민방송|질병관리청|심사평가원|보훈부|국방뉴스|건설기계안전|고객상담센터|행정안전부|국세청)/u', $author ) ) {
		return 'off';
	}
	if ( preg_match( '/(뉴스|NEWS|News|tv 수원)/u', $author ) ) {
		return 'press';
	}
	return 'ref';
}

function eb_vid_meta( $id ) {
	$all = get_option( 'eb_yt_meta', array() );
	$all = is_array( $all ) ? $all : array();
	$m   = isset( $all[ $id ] ) ? $all[ $id ] : null;
	$ttl = $m && ! empty( $m['a'] ) ? 30 * DAY_IN_SECONDS : 7 * DAY_IN_SECONDS;
	if ( $m && ( time() - (int) $m['at'] ) < $ttl ) {
		return $m;
	}
	$r = wp_remote_get( 'https://www.youtube.com/oembed?format=json&url=' . rawurlencode( 'https://www.youtube.com/watch?v=' . $id ), array( 'timeout' => 3 ) );
	$j = ! is_wp_error( $r ) && 200 === (int) wp_remote_retrieve_response_code( $r ) ? json_decode( wp_remote_retrieve_body( $r ), true ) : null;
	$m = array(
		'a'  => $j && ! empty( $j['author_name'] ) ? (string) $j['author_name'] : '',
		't'  => $j && ! empty( $j['title'] ) ? (string) $j['title'] : '',
		'at' => time(),
	);
	$all[ $id ] = $m;
	update_option( 'eb_yt_meta', $all, false );
	return $m;
}

function eb_vid_caption( $id ) {
	$m = eb_vid_meta( $id );
	if ( '' === $m['a'] ) {
		return '';
	}
	$k     = eb_vid_kind( $m['a'] );
	$label = array( 'off' => '공식 기관', 'press' => '언론', 'ref' => '참고 영상' );
	$play  = '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15V9l5.2 3z"/></svg>';
	$h     = '<div class="eb-vsrc eb-vsrc--' . $k . '"><span class="eb-vsrc__ic">' . $play . '</span><span class="eb-vsrc__m">'
		. '<span class="eb-vsrc__ch">' . esc_html( $m['a'] ) . '<em>' . $label[ $k ] . '</em></span>'
		. ( '' !== $m['t'] ? '<span class="eb-vsrc__t">' . esc_html( $m['t'] ) . '</span>' : '' )
		. ( 'ref' === $k ? '<span class="eb-vsrc__note">공식 기관이 아닌 채널의 영상이에요. 금액·조건은 본문과 담당 기관 안내를 기준으로 확인하세요.</span>' : '' )
		. '</span><a class="eb-vsrc__go" href="' . esc_url( 'https://www.youtube.com/watch?v=' . $id ) . '" target="_blank" rel="noopener">YouTube에서 보기</a></div>';
	return $h;
}

// ② 소제목 띄어쓰기 - 목차(Tocer)가 읽기 전에
add_filter( 'the_content', function ( $html ) {
	if ( ! eb_vid_live() || ! is_singular( 'post' ) ) {
		return $html;
	}
	return preg_replace( '#(<h[23][^>]*>)\s*관련\s*영상\s*(</h[23]>)#u', '$1관련 영상$2', $html );
}, 1 );

// ① 영상 바꿔 끼우기 + ③ 출처 줄 - 블록·임베드가 다 그려진 뒤
add_filter( 'the_content', function ( $html ) {
	if ( ! eb_vid_live() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $html;
	}
	foreach ( eb_vid_swap() as $old => $new ) {
		$html = str_replace( $old, $new, $html );
	}
	return preg_replace_callback(
		'#<figure[^>]*wp-block-embed[^>]*>.*?</figure>|<iframe[^>]+youtube(?:-nocookie)?\.com/embed/[^>]*>\s*</iframe>(?:\s*</p>)?#is',
		function ( $m ) {
			$out = $m[0];
			// 원래 영상이 죽어 주소 글자만 남은 임베드(유튜브가 정보를 안 줌)는 영상 창을 직접 만들어 넣음
			if ( false === stripos( $out, '<iframe' ) && preg_match( '#(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]{11})#', $out, $w ) ) {
				$out = preg_replace( '#(<div class="wp-block-embed__wrapper">).*?(</div>)#s', '$1<iframe title="YouTube 영상" width="1200" height="675" src="https://www.youtube.com/embed/' . $w[1] . '?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>$2', $out );
			}
			if ( ! preg_match( '#youtube(?:-nocookie)?\.com/embed/([\w-]{11})#', $out, $id ) ) {
				return $out;
			}
			return $out . eb_vid_caption( $id[1] );
		},
		$html
	);
}, 99 );

/* 70. 어르신 복지용구 안내 [eb_equip] (페이지 /senior-equipment/, 2026-10-16, css/90-tools.css 끝 '복지용구·협업') ----------
 * 노인장기요양보험 복지용구 급여(보건복지부 고시 '복지용구 급여범위 및 급여기준 등에 관한 고시', 연 160만원·본인부담 15/9/6/0%)
 * 2차(2026-10-16 시안 확정, 백업 임시글 15228·15229): 받을 수 있는지 3단 확인 · 본인부담률마다 대상 설명 + 한도 넘는 몫 계산
 *   · 품목 쓰는 곳별 거르기·한 줄 설명(휴대폰은 8개 뒤 '모두 보기') · 조심할 점 · 자주 묻는 질문
 *   · 직접 사는 안전용품은 홈 '생활 특가'처럼 주제 탭 + 옆으로 넘기는 카드, 복지용구 지원 품목이면 '지원 품목' 표시, 주제마다 고르는 요령
 * 3차(2026-10-17 시안 확정, 백업 임시글 15247·15248): 품목을 「복지용구 품목별 제품목록 및 급여비용 등에 관한 고시」 제2026-180호(2026.9.1 시행)
 *   기준 26개(구입 15·대여 6·구입·대여 5)로 바꾸고 사용 가능 햇수·'제품 등록 전' 표시, 거르기는 구입·대여 방식으로
 *   · 본인부담률 4칸 한 줄 + 고른 비율 설명 한 줄 · '올해 이미 쓴 금액'으로 남은 한도 계산
 *   · 연 한도 적용 기간 = 최초 장기요양인정 유효기간 개시일부터 매 1년(급여범위 고시 제3조②) · 받는 순서는 한 줄로
 *   품목·제품 수는 고시가 바뀌면 eb_equip_items()만 고치면 됨(제품 수 0 = '제품 등록 전')
 * 4차(2026-10-17 시안 확정): 생활 안전용품을 쇼핑몰처럼 - 쓰는 곳 4 × 검색어 3 × 상품 2 = 24개, '처음이라면 기본 3가지' 묶음, 추천순·낮은 가격순, 휴대폰 4개·PC 8개 뒤 더 보기. FAQ는 eb_faq_item() 공통 모양
 * 감경 근거: 국민건강보험공단 '재원조달 및 급여비용' - 의료급여법 3조1항1호(기초생활 수급) 면제, 2~9호 60% 감경, 소득·재산 기준 40·60% 감경
 * 쿠팡 검색 API는 1시간 호출 수 제한이 있어 키워드마다 하루 1번만 받고, 실패하면 마지막으로 받은 상품을 씀
 */
function eb_equip_shop_tabs() {
	// 쓰는 곳 => [ 이름, 고르는 요령, [ [ 검색어, 복지용구 지원 품목이면 그 이름, '처음이라면 기본 3가지'에 넣으면 1 ], ... ] ] - 검색어마다 상품 2개
	return array(
		'bath'  => array( '욕실', '몸무게를 싣는 손잡이는 흡착식보다 나사로 고정하는 형태가 안전해요. 매트는 뒷면 흡착판이 촘촘한 것을 고르세요.', array(
			array( '욕실 안전손잡이', '안전손잡이', 1 ),
			array( '욕실 미끄럼방지 매트', '미끄럼방지용품', 1 ),
			array( '목욕의자', '목욕의자', 0 ),
		) ),
		'move'  => array( '걷기·이동', '지팡이 손잡이는 팔을 편하게 내렸을 때 손목 높이가 알맞아요. 혼자 균형 잡기 어렵다면 4발 지팡이나 보행기를 보세요.', array(
			array( '노인 지팡이 4발', '지팡이', 0 ),
			array( '성인용 보행기', '성인용 보행기', 0 ),
			array( '실내 문턱 경사로', '경사로', 0 ),
		) ),
		'night' => array( '침실·밤길', '침대에서 화장실까지 가는 길 발밑에 센서등을 두면 밤에 넘어지는 일을 줄일 수 있어요.', array(
			array( '센서등 동작감지', '', 1 ),
			array( '침대 안전 손잡이', '', 0 ),
			array( '미끄럼방지 양말 노인', '미끄럼방지용품', 0 ),
		) ),
		'life'  => array( '생활·건강', '약을 자주 거르신다면 요일·시간 칸이 나뉜 약통이, 혼자 계신다면 누르면 가족에게 울리는 호출벨이 도움이 돼요.', array(
			array( '요일별 약통', '', 0 ),
			array( '무선 호출벨 노인', '', 0 ),
			array( '손목 혈압계', '', 0 ),
		) ),
	);
}

// 검색어 하나로 상품 여러 개(쿠팡 검색 API). 검색 API는 1시간 호출 수 제한이 있어
// 검색어마다 하루 1번만 새로 받고, 1시간에 6번까지만 부름(넘으면 마지막으로 받은 상품). 예전 한 개짜리 저장분(eb_cp_s_)도 비상용으로 씀
// 지원 품목 중 쿠팡에서 직접 살 수 있는 것 => 검색어. 등급이 '없어요'·'신청 중'일 때만 품목 옆에 가격 칩(5차, 2026-10-17)
function eb_equip_item_kw() {
	return array(
		'안전손잡이'       => '욕실 안전손잡이',
		'미끄럼방지용품'   => '욕실 미끄럼방지 매트',
		'성인용 보행기'    => '성인용 보행기',
		'지팡이'           => '노인 지팡이 4발',
		'목욕의자'         => '목욕의자',
		'경사로(실내용)'   => '실내 문턱 경사로',
		'이동변기'         => '이동변기 노인',
		'요실금 팬티'      => '요실금 팬티',
		'욕창예방방석'     => '욕창방지 방석',
		'욕창예방매트리스' => '욕창방지 매트리스',
		'간이변기'         => '간이변기 소변기',
		'수동휠체어'       => '접이식 휠체어',
		'전동침대'         => '전동침대 환자용',
	);
}

function eb_equip_products( $kw, $n = 2 ) {
	$key  = 'eb_cp_l_' . md5( $kw );
	$pack = get_transient( $key );
	if ( false === $pack ) {
		$pack  = get_option( $key . '_last', array() );
		$calls = (int) get_transient( 'eb_cp_calls_h' );
		if ( $calls < 6 && function_exists( 'eb_cp_api' ) ) {
			set_transient( 'eb_cp_calls_h', $calls + 1, HOUR_IN_SECONDS );
			$data  = eb_cp_api( 'GET', '/v2/providers/affiliate_open_api/apis/openapi/v1/products/search', 'keyword=' . rawurlencode( $kw ) . '&limit=10&imageSize=300x300' );
			$items = array();
			if ( is_array( $data ) && ! empty( $data['productData'] ) ) {
				foreach ( $data['productData'] as $p ) {
					if ( ! empty( $p['productUrl'] ) && ! empty( $p['productImage'] ) && ! empty( $p['productPrice'] ) ) {
						$items[] = array_intersect_key( $p, array_flip( array( 'productId', 'productName', 'productPrice', 'productImage', 'productUrl', 'isRocket' ) ) );
					}
				}
				// 로켓배송을 앞으로(받기 쉬움), 나머지는 쿠팡 검색 순서 그대로
				usort( $items, function ( $a, $b ) {
					return (int) ! empty( $b['isRocket'] ) - (int) ! empty( $a['isRocket'] );
				} );
			}
			if ( $items ) {
				$pack = array( 't' => time(), 'items' => $items );
				update_option( $key . '_last', $pack, false );
			}
		}
		set_transient( $key, $pack, $pack && ! empty( $pack['items'] ) ? DAY_IN_SECONDS : 2 * HOUR_IN_SECONDS );
	}
	if ( empty( $pack['items'] ) ) {
		$old = get_option( 'eb_cp_s_' . md5( $kw ) . '_last', array() );
		$pack = $old ? array( 't' => 0, 'items' => array( $old ) ) : array( 't' => 0, 'items' => array() );
	}
	return array( (int) ( $pack['t'] ?? 0 ), array_slice( (array) $pack['items'], 0, $n ) );
}

// 지원 품목: [ 이름, 구입 b·대여 r·둘 다 x, 사용 가능 햇수(대여·둘 다), 한 줄 설명, 등록 제품 수 ] - 많이 찾는 순(휴대폰은 8개 뒤 접음)
// 근거: 「복지용구 품목별 제품목록 및 급여비용 등에 관한 고시」 제2026-180호(2026.9.1 시행)
function eb_equip_items() {
	return array(
		array( '안전손잡이', 'b', 0, '욕실·화장실·현관 벽에 다는 손잡이', 119 ),
		array( '미끄럼방지용품', 'b', 0, '미끄럼방지 매트·양말·바닥에 바르는 액', 105 ),
		array( '성인용 보행기', 'b', 0, '바퀴와 손잡이로 걷기를 돕는 기구', 63 ),
		array( '지팡이', 'b', 0, '1발·4발 지팡이', 58 ),
		array( '전동침대', 'r', 10, '등·다리 높이를 버튼으로 조절하는 침대', 85 ),
		array( '수동휠체어', 'r', 5, '접어서 싣고 다니는 휠체어', 47 ),
		array( '욕창예방매트리스', 'x', 3, '오래 누워 있을 때 욕창을 막는 매트리스', 28 ),
		array( '목욕의자', 'b', 0, '앉아서 씻을 수 있는 의자', 25 ),
		array( '이동변기', 'b', 0, '침대 옆에 두고 쓰는 의자형 변기', 21 ),
		array( '요실금 팬티', 'b', 0, '빨아서 다시 쓰는 요실금 팬티', 67 ),
		array( '경사로(실내용)', 'x', 2, '방·화장실 문턱을 넘게 해 주는 판', 18 ),
		array( '경사로(실외용)', 'x', 8, '현관·계단 턱을 넘게 해 주는 판', 5 ),
		array( '욕창예방방석', 'b', 0, '오래 앉을 때 엉덩이 압력을 줄이는 방석', 25 ),
		array( '자세변환용구', 'b', 0, '누운 자세를 바꾸고 받쳐 주는 쿠션', 25 ),
		array( '간이변기', 'b', 0, '누운 채 쓰는 변기·소변기', 8 ),
		array( '수동침대', 'r', 10, '손잡이를 돌려 높이를 조절하는 침대', 13 ),
		array( '이동욕조', 'r', 5, '방에서 쓰는 접이식 욕조', 4 ),
		array( '배회감지기', 'r', 5, '치매 어르신이 집 밖으로 나가면 보호자에게 알림', 5 ),
		array( '배회감지기(태그형)', 'b', 0, '몸에 지니는 태그로 위치를 보호자에게 알림', 1 ),
		array( '기저귀센서', 'b', 0, '기저귀가 젖으면 보호자에게 알림', 1 ),
		array( '구강세척기(마우스피스형)', 'b', 0, '입에 무는 형태로 이를 닦아 주는 기기', 1 ),
		array( '목욕리프트', 'r', 3, '욕조에 들어가고 나오게 돕는 기구', 0 ),
		array( '이승보조기기', 'x', 5, '침대·휠체어 사이로 옮겨 앉기를 돕는 기구', 0 ),
		array( '대화형 정서지원기기', 'x', 5, '말벗·약 먹을 시간 알림을 해 주는 기기', 0 ),
		array( '고관절보호대', 'b', 0, '넘어질 때 엉덩이뼈 충격을 줄이는 보호대', 0 ),
		array( '낙상알림시스템', 'b', 0, '넘어지면 보호자에게 알림', 0 ),
	);
}

add_shortcode( 'eb_equip', function () {
	$items = eb_equip_items();
	$h     = '<div class="eb-eq">';
	$h    .= '<ul class="eb-eq__sum"><li><b>160만원</b><span>1년 한도</span></li><li><b>0~15%</b><span>내가 내는 몫</span></li><li><b>' . count( $items ) . '개</b><span>지원 품목</span></li></ul>';

	// 받을 수 있는지
	$h .= '<h2 id="eq-who">우리 부모님은 받을 수 있을까?</h2><div class="eb-eq__chk" data-eq-chk>'
		. '<div class="eb-eq__seg is-3" role="group" aria-label="장기요양 등급이 있으세요?"><button type="button" data-k="y" aria-pressed="true">등급 있어요</button><button type="button" data-k="w" aria-pressed="false">신청 중</button><button type="button" data-k="n" aria-pressed="false">없어요</button></div>'
		. '<div class="eb-eq__ans" data-a="y" role="status"><b>받을 수 있어요.</b> 1~5등급과 인지지원등급 모두 복지용구를 쓸 수 있어요. 아래에서 본인부담률을 골라 내가 낼 돈을 계산해 보세요.<small>노인요양시설(요양원)에 들어가 계신 동안에는 쓸 수 없어요.</small></div>'
		. '<div class="eb-eq__ans" data-a="w" role="status" hidden><b>판정 결과가 나오면 바로 쓸 수 있어요.</b> 등급 판정은 보통 신청한 날부터 30일 안에 나와요. 장기요양인정서와 복지용구 급여확인서를 받으면 복지용구 사업소에 가져가세요.</div>'
		. '<div class="eb-eq__ans" data-a="n" role="status" hidden><b>먼저 장기요양 인정을 신청하세요.</b> 65세 이상이거나, 65세 미만이라도 치매·뇌혈관성 질환 같은 노인성 질병이 있으면 신청할 수 있어요. <a href="tel:15771000">국민건강보험공단 1577-1000</a><small>등급이 나오기 전이라면 아래 <a href="#eq-shop">직접 사는 생활 안전용품</a>도 참고하세요.</small></div></div>';

	// 본인부담 계산: 4칸 한 줄 + 고른 비율 설명, 올해 이미 쓴 금액으로 남은 한도
	$rates = array( array( 15, '일반', '대부분의 어르신이 15%예요.' ), array( 9, '감경', '소득·재산이 일정 기준 이하인 분이에요.' ), array( 6, '감경', '의료급여 수급자, 소득·재산이 더 낮은 분이에요.' ), array( 0, '면제', '기초생활 수급자는 내는 돈이 없어요.' ) );
	$rb    = '';
	foreach ( $rates as $r ) {
		$rb .= '<button type="button" data-r="' . $r[0] . '" data-d="' . esc_attr( $r[2] ) . '" aria-pressed="' . ( 15 === $r[0] ? 'true' : 'false' ) . '"><b>' . $r[0] . '%</b><small>' . esc_html( $r[1] ) . '</small></button>';
	}
	$h .= '<h2 id="eq-calc">내가 내는 돈 바로 계산</h2><div class="eb-eq__calc" data-eq-calc>'
		. '<label class="eb-eq__f"><span>제품 가격 <small>공단 고시가</small></span><span class="eb-eq__in"><input type="text" inputmode="numeric" value="100,000" data-eq-price aria-label="제품 가격"><em>원</em></span></label>'
		. '<p class="eb-eq__f2">본인부담률 <small>인정서·감경 안내문에 있어요</small></p><div class="eb-eq__rates" role="group" aria-label="본인부담률">' . $rb . '</div><p class="eb-eq__rd" data-eq-rd aria-live="polite">' . esc_html( $rates[0][2] ) . '</p>'
		. '<label class="eb-eq__f is-sub"><span>올해 이미 쓴 금액 <small>선택 · 공단 몫 포함 합계</small></span><span class="eb-eq__in"><input type="text" inputmode="numeric" value="" placeholder="0" data-eq-used aria-label="올해 이미 쓴 금액"><em>원</em></span></label>'
		. '<div class="eb-eq__out" aria-live="polite"><span>내가 내는 돈<b data-eq-me>15,000원</b></span><small><span data-eq-gov>공단 85,000원</span><span data-eq-left>남는 한도 1,500,000원</span></small></div>'
		. '<p class="eb-eq__hint is-cap" data-eq-over hidden></p>'
		. '<p class="eb-eq__hint"><b>1년은 1~12월이 아니에요.</b> 처음 장기요양 등급을 받은 날(유효기간 시작일)부터 1년씩 세요. 대여 품목은 매달 대여료에 같은 비율을 적용해요.</p></div>';

	// 품목: 구입·대여 방식으로 거르기
	$kinds = array( 'b' => '구입', 'r' => '대여', 'x' => '구입·대여' );
	$cnt   = array_count_values( wp_list_pluck( $items, 1 ) );
	$fb    = '<button type="button" data-f="" aria-pressed="true">전체 <i>' . count( $items ) . '</i></button>';
	foreach ( array( 'b' => '구입', 'r' => '대여', 'x' => '둘 다' ) as $k => $v ) {
		$fb .= '<button type="button" data-f="' . $k . '" aria-pressed="false">' . esc_html( $v ) . ' <i>' . (int) ( $cnt[ $k ] ?? 0 ) . '</i></button>';
	}
	$li  = '';
	$ikw = eb_equip_item_kw();
	foreach ( $items as $it ) {
		$meta = ( $it[2] ? '<span class="eb-eq__yr">' . (int) $it[2] . '년</span>' : '' ) . ( $it[4] ? '' : '<span class="eb-eq__wait">제품 등록 전</span>' );
		// 등급 있음: '사업소에서 15% 이하' / 등급 없음·신청 중: 쿠팡 가격 칩(받아 둔 상품 중 가장 싼 것, 없으면 칩 없음)
		$act = $it[4] ? '<span class="eb-eq__ok">' . ( 'r' === $it[1] ? '매달 대여료의 15% 이하' : '사업소에서 15% 이하' ) . '</span>' : '';
		if ( isset( $ikw[ $it[0] ] ) ) {
			list( , $ps ) = eb_equip_products( $ikw[ $it[0] ], 5 );
			$low = null;
			foreach ( $ps as $p ) {
				if ( ! $low || (int) $p['productPrice'] < (int) $low['productPrice'] ) {
					$low = $p;
				}
			}
			if ( $low ) {
				$pr   = (int) $low['productPrice'];
				$act .= '<a class="eb-eq__cp" href="' . esc_url( $low['productUrl'] ) . '" target="_blank" rel="sponsored nofollow noopener" aria-label="' . esc_attr( $it[0] ) . ' 쿠팡에서 보기(광고)">쿠팡 <b>' . esc_html( $pr >= 10000 ? rtrim( rtrim( number_format( $pr / 10000, 1 ), '0' ), '.' ) . '만원~' : number_format_i18n( $pr ) . '원~' ) . '</b></a>';
			}
		}
		$li .= '<li data-p="' . $it[1] . '"' . ( $it[4] ? '' : ' class="is-wait"' ) . '><span class="eb-eq__iname"><b>' . esc_html( $it[0] ) . $meta . '</b><em class="is-' . $it[1] . '">' . esc_html( $kinds[ $it[1] ] ) . '</em></span><span class="eb-eq__idesc">' . esc_html( $it[3] ) . '</span>' . ( $act ? '<span class="eb-eq__iact">' . $act . '</span>' : '' ) . '</li>';
	}
	$h .= '<h2 id="eq-items">지원되는 품목</h2><div class="eb-eq__list" data-eq-list><p class="eb-eq__buyban">등급이 나오기 전엔 직접 사야 해요. 쿠팡에서 파는 품목엔 가격을 붙였어요(광고).</p><div class="eb-eq__fbar"><div class="eb-eq__filter" role="group" aria-label="구입·대여로 거르기">' . $fb . '</div><span class="eb-eq__asof">2026.9.1 고시 기준</span></div>'
		. '<ul class="eb-eq__items is-fold">' . $li . '</ul><button type="button" class="eb-eq__more" aria-expanded="false">' . count( $items ) . '개 모두 보기</button></div>'
		. '<p class="eb-eq__tip2"><b>년</b>은 고시에 정한 사용 가능 햇수예요(지나야 다시 받을 수 있어요). <b>제품 등록 전</b> 품목은 고시에 올랐지만 아직 고를 제품이 없어요. 어떤 품목을 쓸 수 있는지는 어르신 몸 상태(장기요양 인정조사)에 따라 공단이 정해요.</p>';

	// 받는 순서: 한 줄
	$steps = array( '등급 받기', '사업소 찾기', '품목 고르기', '본인부담만 결제' );
	$sl    = '';
	foreach ( $steps as $i => $s ) {
		$sl .= '<li><b>' . ( $i + 1 ) . '</b>' . esc_html( $s ) . '</li>';
	}
	$h .= '<h2 id="eq-steps">받는 순서</h2><ol class="eb-eq__flow">' . $sl . '</ol>'
		. '<p class="eb-eq__hint is-flow">공단에서 등급을 받은 뒤 노인장기요양보험 누리집 \'장기요양기관 찾기\'로 가까운 복지용구 사업소를 찾아, <b>장기요양인정서·복지용구 급여확인서</b>를 가져가세요. 구입은 본인부담금만, 대여는 매달 대여료의 본인부담분만 내요.</p>'
		. '<div class="eb-eq__links"><a href="https://www.longtermcare.or.kr/" target="_blank" rel="noopener">노인장기요양보험 누리집</a><a href="tel:15771000">공단 1577-1000</a></div>';

	// 조심할 점
	$h .= '<h2 id="eq-care">이것만은 조심하세요</h2><ul class="eb-eq__care">'
		. '<li><b>"본인부담금 안 받아요"는 거절하세요.</b> 장기요양기관이 본인부담금을 면제하거나 깎아 주는 것은 법으로 금지된 행위예요.</li>'
		. '<li><b>필요 없는 품목까지 권하면 거절해도 돼요.</b> 한도를 채우자는 권유에 넘어가면 쓰지 않을 물건에도 본인부담금이 나가요.</li>'
		. '<li><b>한 번 받은 품목은 바로 다시 못 받아요.</b> 품목마다 정해진 사용 기간(내구연한)이 지나야 다시 받을 수 있어요.</li>'
		. '<li><b>1년 160만원을 넘는 돈은 모두 본인 부담이에요.</b> 비싼 품목을 고르기 전에 남은 한도를 사업소에 먼저 물어보세요.</li></ul>';

	// 자주 묻는 질문
	// 자주 묻는 질문: 76번 eb_faq_data() 한 곳에서 가져옴(/faq/와 같음)
	$faq = eb_faq_data()['equip'][2];
	$h .= '<h2 id="eq-faq">자주 묻는 질문</h2><div class="eb-eq__faq">';
	foreach ( $faq as $k => $f ) {
		$h .= eb_faq_item( $f[0], wp_kses_post( $f[1] ), 0 === $k );
	}
	$h .= '</div>';

	// 직접 사는 생활 안전용품 (쿠팡) - 쇼핑몰처럼: 기본 3가지 묶음 · 쓰는 곳 칩 · 추천순/낮은 가격순 · 2칸(PC 4칸) 카드 · 더 보기 (2026-10-17 4차)
	$cards = '';
	$chips = '';
	$tips  = '';
	$set   = array();
	$seen  = array();
	$when  = 0;
	$i     = 0;
	foreach ( eb_equip_shop_tabs() as $ck => $cat ) {
		$cn = 0;
		foreach ( $cat[2] as $kw ) {
			list( $t, $list ) = eb_equip_products( $kw[0], 2 );
			if ( $t && ( ! $when || $t < $when ) ) {
				$when = $t;
			}
			// '기본 3가지'에는 그 검색어 상품 중 더 싼 것
			$cheap = -1;
			foreach ( $list as $k => $p ) {
				if ( $cheap < 0 || (int) $p['productPrice'] < (int) $list[ $cheap ]['productPrice'] ) {
					$cheap = $k;
				}
			}
			foreach ( $list as $k => $p ) {
				$pid = (string) ( $p['productId'] ?? $p['productUrl'] );
				if ( isset( $seen[ $pid ] ) ) {
					continue;
				}
				$seen[ $pid ] = 1;
				$price        = (int) ( $p['productPrice'] ?? 0 );
				$in_set       = $kw[2] && $cheap === $k && count( $set ) < 3;
				if ( $in_set ) {
					$set[] = array( $p, $price, $kw[0] );
				}
				$tags   = ( $kw[1] ? '<em class="is-sup" title="장기요양 등급이 있으면 복지용구 ' . esc_attr( $kw[1] ) . '(으)로 15% 이하에 살 수 있어요">지원 품목</em>' : '' ) . ( ! empty( $p['isRocket'] ) ? '<em class="is-rk">로켓배송</em>' : '' );
				$cards .= '<a class="eb-eq__card" href="' . esc_url( $p['productUrl'] ) . '" target="_blank" rel="sponsored nofollow noopener" data-c="' . $ck . '" data-p="' . $price . '" data-o="' . $i . '"' . ( $in_set ? ' data-set="1"' : '' ) . '>'
					. '<span class="eb-eq__img"><b class="eb-eq__rank" aria-hidden="true"></b><img src="' . esc_url( $p['productImage'] ) . '" alt="" loading="lazy" width="300" height="300"></span>'
					. ( $tags ? '<span class="eb-eq__tags">' . $tags . '</span>' : '' )
					. '<span class="eb-eq__pname">' . esc_html( $p['productName'] ) . '</span>'
					. '<span class="eb-eq__price">' . esc_html( number_format_i18n( $price ) ) . '원</span></a>';
				$i++;
				$cn++;
			}
		}
		if ( $cn ) {
			$chips .= '<button type="button" data-c="' . $ck . '" aria-pressed="false">' . esc_html( $cat[0] ) . '</button>';
			$tips  .= '<p class="eb-eq__tip" data-c="' . $ck . '" hidden><b>고르는 요령</b>' . esc_html( $cat[1] ) . '</p>';
		}
	}
	if ( $cards ) {
		$setb = '';
		if ( 3 === count( $set ) ) {
			$names = array( '욕실 손잡이', '미끄럼방지 매트', '센서등' );
			$sum   = 0;
			$mini  = '';
			foreach ( $set as $k => $s ) {
				$sum  += $s[1];
				$mini .= '<a href="' . esc_url( $s[0]['productUrl'] ) . '" target="_blank" rel="sponsored nofollow noopener"><img src="' . esc_url( $s[0]['productImage'] ) . '" alt="" loading="lazy" width="300" height="300"><span>' . esc_html( $names[ $k ] ) . '</span></a>';
			}
			$setb = '<div class="eb-eq__set"><p class="eb-eq__sett"><b>처음이라면 기본 3가지</b><span>욕실·밤길 낙상 예방</span></p><div class="eb-eq__setr">' . $mini . '</div>'
				. '<div class="eb-eq__setf"><span>3개 합계 약 <b>' . esc_html( number_format_i18n( $sum ) ) . '원</b></span><button type="button" data-set-show>하나씩 보기</button></div></div>';
		}
		$h .= '<section class="eb-eq__shop" aria-labelledby="eq-shop" data-eq-shop><div class="eb-eq__shead"><h2 id="eq-shop">등급이 없어도, 집 안 낙상 대비</h2><span class="eb-eq__ad">광고</span></div>'
			. '<p class="eb-eq__lead">어르신 댁에 많이 두는 생활 안전용품을 모았어요.</p>' . $setb
			. '<div class="eb-eq__tabs" role="group" aria-label="쓰는 곳"><button type="button" data-c="" aria-pressed="true">전체 <i>' . $i . '</i></button>' . $chips . '</div>'
			. '<div class="eb-eq__sbar"><span>쿠팡 기준' . ( $when ? ' · ' . esc_html( wp_date( 'n.j H:i', $when ) ) . ' 가격' : '' ) . '</span><span class="eb-eq__sort" role="group" aria-label="정렬"><button type="button" data-s="o" aria-pressed="true">추천순</button><button type="button" data-s="p" aria-pressed="false">낮은 가격순</button></span></div>'
			. $tips . '<div class="eb-eq__cards">' . $cards . '</div><button type="button" class="eb-eq__smore" hidden></button>'
			. '<p class="eb-eq__disc"><b>제휴 안내</b>이 영역의 상품 링크는 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받습니다. 가격·배송은 쿠팡에서 바뀔 수 있어요. <em class="is-sup">지원 품목</em>은 장기요양 등급이 있으면 복지용구로 15% 이하에 살 수 있어요.</p></section>';
	}

	$h .= '<p class="eb-eq__src">근거: 보건복지부 고시 「복지용구 급여범위 및 급여기준 등에 관한 고시」(제2026-13호), 「복지용구 품목별 제품목록 및 급여비용 등에 관한 고시」(제2026-180호, 2026.9.1 시행), 국민건강보험공단 「재원조달 및 급여비용」 · 확인일 2026.10.17. 제도는 바뀔 수 있으니 신청 전 공단에 한 번 더 확인하세요.</p></div>';
	$h .= "<script nowprocket>\n" . <<<'JS'
(function () {
	var root = document.querySelector('.eb-eq');
	if (!root) { return; }
	function f(n) { return Math.round(n).toLocaleString('ko-KR'); }
	function num(v) { return parseInt(String(v).replace(/[^0-9]/g, ''), 10) || 0; }
	function press(group, b) { group.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); }); }
	// 받을 수 있는지
	var chk = root.querySelector('[data-eq-chk]');
	if (chk) {
		chk.querySelectorAll('[data-k]').forEach(function (b) {
			b.addEventListener('click', function () {
				press(b.parentNode, b);
				chk.querySelectorAll('[data-a]').forEach(function (a) { a.hidden = a.getAttribute('data-a') !== b.getAttribute('data-k'); });
				root.classList.toggle('is-buy', b.getAttribute('data-k') !== 'y'); // 품목 목록: 등급 없음·신청 중이면 쿠팡 가격
			});
		});
	}
	// 본인부담 계산: 남은 한도(160만원 - 올해 쓴 금액) 안은 비율만큼, 넘는 몫은 모두 본인 부담
	var c = root.querySelector('[data-eq-calc]');
	if (c) {
		var ip = c.querySelector('[data-eq-price]'), iu = c.querySelector('[data-eq-used]'), r = 15, CAP = 1600000;
		var me = c.querySelector('[data-eq-me]'), gov = c.querySelector('[data-eq-gov]'), left = c.querySelector('[data-eq-left]'), over = c.querySelector('[data-eq-over]'), rd = c.querySelector('[data-eq-rd]');
		var run = function () {
			var v = num(ip.value), u = Math.min(num(iu.value), CAP);
			ip.value = v ? f(v) : '';
			iu.value = num(iu.value) ? f(num(iu.value)) : '';
			var room = CAP - u, in_ = Math.min(v, room), ov = v - in_, m = Math.floor(in_ * r / 100 / 10) * 10;
			me.textContent = f(m + ov) + '원';
			gov.textContent = '공단 ' + f(in_ - m) + '원';
			left.textContent = '남는 한도 ' + f(room - in_) + '원';
			over.hidden = !ov;
			over.textContent = ov ? '한도를 넘는 ' + f(ov) + '원은 모두 내가 내요.' : '';
		};
		ip.addEventListener('input', run);
		iu.addEventListener('input', run);
		c.querySelectorAll('[data-r]').forEach(function (b) {
			b.addEventListener('click', function () { r = +b.getAttribute('data-r'); press(b.parentNode, b); rd.textContent = b.getAttribute('data-d'); run(); });
		});
		run();
	}
	// 품목 거르기·모두 보기
	var l = root.querySelector('[data-eq-list]');
	if (l) {
		var ul = l.querySelector('ul'), more = l.querySelector('.eb-eq__more');
		l.querySelectorAll('[data-f]').forEach(function (b) {
			b.addEventListener('click', function () {
				var k = b.getAttribute('data-f');
				press(b.parentNode, b);
				ul.querySelectorAll('li').forEach(function (li) { li.hidden = !!k && li.getAttribute('data-p') !== k; });
				ul.classList.toggle('is-fold', !k && more.getAttribute('aria-expanded') !== 'true');
				more.hidden = !!k || more.getAttribute('aria-expanded') === 'true';
			});
		});
		more.addEventListener('click', function () { more.setAttribute('aria-expanded', 'true'); ul.classList.remove('is-fold'); more.hidden = true; });
	}
	// 생활 안전용품: 쓰는 곳 칩 · 정렬 · 휴대폰 4개/PC 8개 뒤 더 보기 · 기본 3가지만 보기
	var sh = root.querySelector('[data-eq-shop]');
	if (sh) {
		var grid = sh.querySelector('.eb-eq__cards'), cards = [].slice.call(grid.children), sm = sh.querySelector('.eb-eq__smore');
		var st = { c: '', s: 'o', set: false, all: false };
		var draw = function () {
			var list = cards.filter(function (a) { return st.set ? a.hasAttribute('data-set') : (!st.c || a.getAttribute('data-c') === st.c); });
			list.sort(function (a, b) { return st.s === 'p' ? (+a.getAttribute('data-p') - +b.getAttribute('data-p')) : (+a.getAttribute('data-o') - +b.getAttribute('data-o')); });
			var cap = st.all || st.set ? 99 : (window.matchMedia('(min-width: 768px)').matches ? 8 : 4);
			cards.forEach(function (a) { a.hidden = true; });
			list.forEach(function (a, k) { grid.appendChild(a); a.hidden = k >= cap; a.querySelector('.eb-eq__rank').textContent = k + 1; });
			sm.hidden = list.length <= cap;
			sm.textContent = (list.length - cap) + '개 더 보기';
			sh.querySelectorAll('.eb-eq__tip').forEach(function (p) { p.hidden = st.set || p.getAttribute('data-c') !== st.c; });
		};
		sh.querySelectorAll('.eb-eq__tabs button').forEach(function (b) {
			b.addEventListener('click', function () { st.c = b.getAttribute('data-c'); st.set = false; st.all = false; press(b.parentNode, b); draw(); });
		});
		sh.querySelectorAll('.eb-eq__sort button').forEach(function (b) {
			b.addEventListener('click', function () { st.s = b.getAttribute('data-s'); press(b.parentNode, b); draw(); });
		});
		sm.addEventListener('click', function () { st.all = true; draw(); });
		var ss = sh.querySelector('[data-set-show]');
		if (ss) {
			ss.addEventListener('click', function () {
				st.set = true; st.c = '';
				sh.querySelectorAll('.eb-eq__tabs button').forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
				draw();
				grid.scrollIntoView({ behavior: 'smooth', block: 'center' });
			});
		}
		draw();
	}
})();
JS
		. "\n</script>";
	return $h;
} );

// 자주 묻는 질문 한 줄(복지용구·협업 공통, 4차 시안: Q/A 표시 + 펼침 화살표, 첫 질문은 펼친 채). $answer는 이미 걸러진 HTML
function eb_faq_item( $q, $answer, $open = false ) {
	return '<details' . ( $open ? ' open' : '' ) . '><summary><span class="eb-faq__q" aria-hidden="true">Q</span><span class="eb-faq__t">' . esc_html( $q ) . '</span></summary><div class="eb-faq__a"><span class="eb-faq__q is-a" aria-hidden="true">A</span><p>' . $answer . '</p></div></details>';
}

/* 71. 협업·제휴 안내 [eb_partners] (페이지 /partners/, 2026-10-16, css/90-tools.css 끝 '복지용구·협업') ----------------------
 * 문의하기(/contact/)에 있던 비즈니스 협업 설명을 따로 키운 페이지
 * 2차(2026-10-16 시안 확정, 백업 임시글 15228·15229): 숫자 한 줄 띠 · 협업 4가지를 누르는 줄로(누르면 아래 폼 문의 유형이 골라진 채 이동)
 *   · 독자 2×2 · 진행 순서 가로 한 줄 · 원칙 상자 하나 + 받지 않는 광고 칩 · 자주 묻는 질문 · 콤팩트 폼(17번 [eb_proposal_form compact="1"])
 * 3차(2026-10-17 시안 확정, 백업 임시글 15247·15248): 맨 위에 '제안서 쓰기·메일 보내기' 버튼, 협업 4가지는 2칸 타일(PC 4칸),
 *   독자는 칩 한 줄, 진행 순서는 › 로 잇는 한 줄, 원칙은 회색 상자. 푸터 위 '찾는 정보가 없나요?' 띠는 이 페이지에서 뺌(eb_footer 쪽 15223)
 */
add_shortcode( 'eb_partners', function () {
	$posts = (int) wp_count_posts( 'post' )->publish;
	$calc  = get_page_by_path( 'calculator' );
	$ncalc = $calc ? count( get_pages( array( 'child_of' => $calc->ID, 'post_status' => 'publish' ) ) ) : 17;
	$nsvc  = count( (array) get_option( 'eb_ws_all', array() ) ) + count( (array) get_option( 'eb_ws_local', array() ) );
	$ic    = function ( $d ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
	};
	$h  = '<div class="eb-pt">';
	$h .= '<p class="eb-pt__intro">정부 지원금·복지 제도를 <b>공식 자료 기준으로 쉽게</b> 풀어 쓰는 사이트예요. 독자에게 도움이 되는 일이라면 기관·기업·창작자 모두 환영해요.</p>';
	$h .= '<ul class="eb-pt__nums"><li><b>' . number_format_i18n( $posts ) . '</b><span>정리 글</span></li><li><b>' . (int) $ncalc . '</b><span>계산기</span></li><li><b>8</b><span>가이드</span></li><li><b>' . ( $nsvc ? number_format_i18n( $nsvc ) : '5,000+' ) . '</b><span>복지서비스</span></li></ul>';
	$h .= '<div class="eb-pt__cta"><a class="is-main" href="#pt-form">제안서 쓰기</a><a href="mailto:' . antispambot( eb_contact_email() ) . '">메일 보내기</a></div>';

	// 협업 4가지: 4번째 값 = 아래 폼 문의 유형(17번 eb_proposal_types)
	$ways = array(
		array( '<path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M12 3 3 8h18z"/>', '공공 정책 홍보', '지원사업·신청 기간 알림', '공공 정책 홍보', '무료' ),
		array( '<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8.5 7h7M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15h.01"/>', '계산기 붙여 쓰기', '코드 복사·맞춤 제작', '계산기·도구', '' ),
		array( '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/>', '콘텐츠 제휴', '기고·연재·자료 제공', '콘텐츠 제휴', '' ),
		array( '<path d="M3 11v2a1 1 0 0 0 1 1h2l5 4V6L6 10H4a1 1 0 0 0-1 1z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M18.5 5.5a9 9 0 0 1 0 13"/>', '브랜디드 콘텐츠', '\'광고\' 표시하고 소개', '브랜디드·광고', '' ),
	);
	$h .= '<h2 id="pt-ways">어떤 협업을 생각하세요?</h2><div class="eb-pt__ways">';
	foreach ( $ways as $w ) {
		$h .= '<a href="#pt-form" data-pt-type="' . esc_attr( $w[3] ) . '"><i>' . $ic( $w[0] ) . '</i><b>' . esc_html( $w[1] ) . ( $w[4] ? ' <em>' . esc_html( $w[4] ) . '</em>' : '' ) . '</b><small>' . esc_html( $w[2] ) . '</small></a>';
	}
	$h .= '</div>';

	$who = array( array( '부모님 돌보는 자녀', '기초연금' ), array( '퇴사·실직', '실업급여' ), array( '소상공인', '폐업 지원' ), array( '아이 키우는 가족', '부모급여' ) );
	$h  .= '<h2 id="pt-who">찾아오는 독자</h2><ul class="eb-pt__who">';
	foreach ( $who as $x ) {
		$h .= '<li>' . esc_html( $x[0] ) . ' <span>· ' . esc_html( $x[1] ) . '</span></li>';
	}
	$h .= '</ul>';

	// 진행 순서: 아이콘 4칸을 선으로 잇기(4차 시안)
	$steps = array(
		array( '<path d="M21 3 10.5 13.5M21 3l-6.5 18-4-8.5L2 9z"/>', '제안', '폼·메일' ),
		array( '<path d="M3 9.5 12 4l9 5.5V19a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="m3 9.5 9 6 9-6"/>', '회신', '영업일 2~3일' ),
		array( '<path d="M21 14a2 2 0 0 1-2 2H8l-4 4V6a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/><path d="M8 9h9M8 12.5h6"/>', '협의', '내용·일정' ),
		array( '<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/>', '게시', '결과 공유' ),
	);
	$h .= '<h2 id="pt-steps">진행 순서</h2><ol class="eb-pt__stp">';
	foreach ( $steps as $s ) {
		$h .= '<li><i>' . $ic( $s[0] ) . '</i><b>' . esc_html( $s[1] ) . '</b><span>' . esc_html( $s[2] ) . '</span></li>';
	}
	$h .= '</ol>';

	$no = array( '대출 중개·고금리 대출', '도박·성인', '다단계·투자 권유', '가상자산 투자', '과장된 건강식품', '공공기관 사칭', '개인정보 수집 목적' );
	$nc = '';
	foreach ( $no as $x ) {
		$nc .= '<li>' . esc_html( $x ) . '</li>';
	}
	$h .= '<h2 id="pt-rule">지키는 원칙</h2><div class="eb-pt__rule"><ul class="eb-pt__ok"><li>광고·협찬 글은 공정위 지침대로 첫머리에 \'광고\' 표시</li><li>제도 설명은 광고와 관계없이 공식 자료 기준</li><li>독자 개인정보는 광고주에게 주지 않음</li></ul>'
		. '<p class="eb-pt__noh">받지 않는 광고</p><ul class="eb-pt__no">' . $nc . '</ul><p class="eb-pt__note">금융 상품은 관련 법에 맞는 안내 문구를 갖춘 경우에만 검토해요.</p></div>';

	// 자주 묻는 질문: 76번 eb_faq_data() 한 곳에서 가져옴(/faq/와 같음)
	$faq = eb_faq_data()['partner'][2];
	$h .= '<h2 id="pt-faq">자주 묻는 질문</h2><div class="eb-pt__faq">';
	foreach ( $faq as $k => $f ) {
		$h .= eb_faq_item( $f[0], wp_kses_post( $f[1] ), 0 === $k );
	}
	$h .= '</div>';

	$h .= '<section class="eb-pt__box" aria-labelledby="pt-form"><h2 id="pt-form">제안서 보내기</h2><p class="eb-pt__lead">운영자가 직접 읽고 영업일 2~3일 안에 답해요. 사이트 성격과 맞지 않는 제안이나 단순 홍보 메일에는 답하지 않을 수 있어요.</p>'
		. do_shortcode( '[eb_proposal_form compact="1"]' ) . '<p class="eb-page-note">폼이 열리지 않으면 ' . do_shortcode( '[eb_email]' ) . '으로 보내 주세요.</p></section></div>';
	// 협업 타일·'제안서 쓰기'를 누르면 폼의 문의 유형을 그 항목으로 골라 둠(이동은 #pt-form 링크 그대로)
	$h .= "<script nowprocket>(function(){var r=document.querySelector('.eb-pt');if(!r){return;}r.querySelectorAll('[data-pt-type]').forEach(function(a){a.addEventListener('click',function(){var v=a.getAttribute('data-pt-type');r.querySelectorAll('.eb-form input[name=\"type\"]').forEach(function(x){if(x.value===v){x.checked=true;x.dispatchEvent(new Event('change',{bubbles:true}));}});});});})();</script>";
	return $h;
} );

/* 72. 퇴사 한 번에 계산 [eb_quit] (페이지 /calculator/quit-all/, 2026-10-17 시안 확정, css/90-tools.css 끝 '퇴사 한 번에') ---------------
 * 입사일·마지막 근무일·3개월 임금·못 쓴 연차·나이·그만두는 이유만으로 퇴직금·연차수당·해고예고수당·실업급여를 한 번에 + 퇴사 뒤 할 일 날짜
 * 공식은 11번 계산기와 같음(퇴직금 평균임금×30×재직일/365, 실업급여 평균임금 60%·상하한 eb_rates(), 받는 기간 표, 해고예고 30일분 통상임금)
 * 실업급여 가입 요건(이직 전 18개월 중 피보험단위기간 180일)은 근무 210일 이상으로 어림. '자세히 고치기'에서 통상임금·가입 기간·근로시간을 바꿀 수 있음
 * 결과 공유: 주소에 입력값(?qs=…)을 붙여 열면 바로 계산된 화면
 * 붙여 쓰기: /embed/quit/ 는 이 계산기만 있는 가벼운 화면(검색 제외, 출처 링크). CSS는 css/90-tools.css의 '퇴사 한 번에' 묶음을 그대로 잘라 씀
 * 끄기: eb_quit_embed_live() false → /embed/quit/ 는 원래 페이지로 넘어가고 붙여 쓰기 상자도 숨김
 */
function eb_quit_embed_live() {
	return true;
}

function eb_quit_html( $embed = false ) {
	$r    = eb_rates();
	$set  = array( 'min' => (int) $r['min_wage'], 'max' => (int) $r['unemp_max'], 'year' => (int) $r['year'], 'url' => home_url( '/calculator/quit-all/' ), 'guide' => home_url( '/guide/after-quit/' ), 'embed' => $embed );
	$seg  = function ( $name, $label, $opts, $on, $cls = '' ) {
		$b = '';
		foreach ( $opts as $v => $t ) {
			$b .= '<button type="button" data-v="' . esc_attr( $v ) . '" aria-pressed="' . ( $v === $on ? 'true' : 'false' ) . '">' . esc_html( $t ) . '</button>';
		}
		return '<div class="eb-qa__f"><span class="eb-qa__l" id="qa-' . $name . '">' . esc_html( $label ) . '</span><div class="eb-qa__seg' . $cls . '" role="group" aria-labelledby="qa-' . $name . '" data-qa-name="' . $name . '">' . $b . '</div></div>';
	};
	$in   = function ( $name, $label, $unit, $ph, $hint = '', $val = '' ) {
		$ph = '' !== $ph && '' === (string) $val ? '예: ' . $ph : $ph; // 빈 칸이면 '예: …' (2026-10-18)
		return '<label class="eb-qa__f"><span class="eb-qa__l">' . esc_html( $label ) . ( $hint ? ' <small>' . esc_html( $hint ) . '</small>' : '' ) . '</span><span class="eb-qa__in"><input type="text" inputmode="numeric" name="' . $name . '" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $ph ) . '" autocomplete="off"><em>' . esc_html( $unit ) . '</em></span>' . ( 'w' === $name ? '<small class="eb-qa__kr" data-qa-kr aria-live="polite"></small>' : '' ) . '</label>';
	};
	$per  = '<option value="">이 회사 근무 기간대로</option><option value="0">1년 미만</option><option value="1">1년 이상 ~ 3년 미만</option><option value="2">3년 이상 ~ 5년 미만</option><option value="3">5년 이상 ~ 10년 미만</option><option value="4">10년 이상</option>';
	$h    = '<div class="eb-qa' . ( $embed ? ' is-embed' : '' ) . '" data-qa="' . esc_attr( wp_json_encode( $set ) ) . '"><form class="eb-qa__form" novalidate>'
		. '<div class="eb-qa__g2"><label class="eb-qa__f"><span class="eb-qa__l">입사일</span><input type="date" name="sd"></label><label class="eb-qa__f"><span class="eb-qa__l">마지막 근무일</span><input type="date" name="l"></label></div>'
		. $in( 'w', '퇴사 전 3개월 임금 총액', '원', '9,000,000', '세전' )
		. '<div class="eb-qa__g2">' . $in( 'd', '못 쓴 연차', '일', '5' ) . $seg( 'a', '퇴사 때 나이', array( 'u' => '50 미만', 'o' => '50 이상' ), 'u' ) . '</div>'
		. $seg( 'r', '어떻게 그만두나요?', array( 'self' => '스스로', 'adv' => '권고사직·계약만료', 'fire' => '해고' ), 'adv', ' is-3' )
		. '<div data-qa-notice hidden>' . $seg( 'n', '30일 전에 해고 예고를 받았나요?', array( 'no' => '못 받았어요', 'yes' => '받았어요' ), 'no' ) . '</div>'
		. '<details class="eb-qa__more"><summary>자세히 고치기 <small>통상임금·가입 기간·근로시간</small></summary><div class="eb-qa__morein">'
		. $in( 'o', '월 통상임금', '원', '3,000,000', '비우면 3개월 임금 ÷ 3' )
		. '<label class="eb-qa__f"><span class="eb-qa__l">고용보험 가입 기간 <small>전 직장 포함</small></span><select name="p">' . $per . '</select></label>'
		. $in( 'h', '하루 소정근로시간', '시간', '8', '', '8' )
		. '</div></details>'
		. '<p class="eb-qa__err" data-qa-err role="alert" hidden></p>'
		. '<button type="submit" class="eb-qa__go">한 번에 계산하기</button></form>'
		. '<div class="eb-qa__res" data-qa-res aria-live="polite" hidden></div>'
		. ( $embed ? '' : '<p class="eb-qa__solo"><span>하나씩 자세히</span><a href="' . esc_url( home_url( '/calculator/severance-pay/' ) ) . '">퇴직금</a><a href="' . esc_url( home_url( '/calculator/unemployment-benefit/' ) ) . '">실업급여</a><a href="' . esc_url( home_url( '/calculator/dismissal-notice-pay/' ) ) . '">해고예고수당</a><a href="' . esc_url( home_url( '/calculator/annual-leave-pay/' ) ) . '">연차수당</a></p>' )
		. '</div>';
	return $h . "<script nowprocket>\n" . eb_quit_js() . "\n</script>";
}

function eb_quit_js() {
	return <<<'JS'
(function () {
	var root = document.querySelector('.eb-qa');
	if (!root || root.getAttribute('data-ready')) { return; }
	root.setAttribute('data-ready', '1');
	var S = JSON.parse(root.getAttribute('data-qa')), DAY = 86400000;
	var form = root.querySelector('form'), res = root.querySelector('[data-qa-res]'), err = root.querySelector('[data-qa-err]'), done = false;
	function num(v) { return parseInt(String(v == null ? '' : v).replace(/[^0-9]/g, ''), 10) || 0; }
	function won(n) { return Math.floor(n).toLocaleString('ko-KR') + '원'; }
	function day(v) { if (!v || !/^\d{4}-\d{2}-\d{2}$/.test(v)) { return null; } var p = v.split('-'); return Date.UTC(+p[0], +p[1] - 1, +p[2]); }
	function md(t) { var d = new Date(t); return (d.getUTCMonth() + 1) + '.' + d.getUTCDate() + '(' + '일월화수목금토'.charAt(d.getUTCDay()) + ')'; }
	function ymd(t) { var d = new Date(t); return String(d.getUTCFullYear()).slice(2) + '.' + (d.getUTCMonth() + 1) + '.' + d.getUTCDate(); }
	function kr(n) { var e = Math.floor(n / 1e8), m = Math.floor(n % 1e8 / 1e4); return n < 1e4 ? '' : (e ? e + '억 ' : '') + (m ? m.toLocaleString('ko-KR') + '만' : '') + '원'; }
	function threeMonthDays(l) {
		var quit = new Date(l + DAY), y = quit.getUTCFullYear(), mo = quit.getUTCMonth() - 3;
		var last = new Date(Date.UTC(y, mo + 1, 0)).getUTCDate();
		return Math.round((l + DAY - Date.UTC(y, mo, Math.min(quit.getUTCDate(), last))) / DAY);
	}
	function fullMonths(s, e) {
		var a = new Date(s), b = new Date(e);
		var m = (b.getUTCFullYear() - a.getUTCFullYear()) * 12 + b.getUTCMonth() - a.getUTCMonth();
		if (b.getUTCDate() < a.getUTCDate()) { m--; }
		return Math.max(0, m);
	}
	function addMonths(t, n) { var d = new Date(t), y = d.getUTCFullYear(), m = d.getUTCMonth() + n, last = new Date(Date.UTC(y, m + 1, 0)).getUTCDate(); return Date.UTC(y, m, Math.min(d.getUTCDate(), last)); }
	function seg(name) { var b = root.querySelector('[data-qa-name="' + name + '"] [aria-pressed="true"]'); return b ? b.getAttribute('data-v') : ''; }
	function setSeg(name, v) { root.querySelectorAll('[data-qa-name="' + name + '"] button').forEach(function (x) { x.setAttribute('aria-pressed', x.getAttribute('data-v') === v ? 'true' : 'false'); }); }
	function val() {
		return { s: form.sd.value, l: form.l.value, w: num(form.w.value), d: num(form.d.value), a: seg('a'), r: seg('r'), n: seg('n'), o: num(form.o.value), p: form.p.value, h: Math.min(24, num(form.h.value) || 8) };
	}
	function money(i) { var v = num(i.value); i.value = v ? v.toLocaleString('ko-KR') : ''; }
	function row(name, sub, v, on) { return '<li' + (on ? '' : ' class="is-off"') + '><div><b>' + name + '</b><small>' + sub + '</small></div><span>' + (on ? won(v) : '해당 없음') + '</span></li>'; }
	function calc() {
		var x = val(), s = day(x.s), l = day(x.l);
		err.hidden = true;
		if (s === null || l === null || !x.w) { err.textContent = '입사일, 마지막 근무일, 3개월 임금 총액을 넣어 주세요.'; err.hidden = false; res.hidden = true; return; }
		if (l < s) { err.textContent = '마지막 근무일이 입사일보다 빨라요. 날짜를 확인해 주세요.'; err.hidden = false; res.hidden = true; return; }
		var work = Math.round((l - s) / DAY) + 1, d3 = threeMonthDays(l), avg = x.w / d3;
		var sev = work >= 365 ? avg * 30 * work / 365 : 0;
		var ord = x.o || x.w / 3, mh = Math.round(x.h * 6 * 365 / 7 / 12), dOrd = ord / mh * x.h;
		var leave = dOrd * x.d;
		var months = fullMonths(s, l + DAY), notice = 0, nSub;
		if (x.r !== 'fire') { nSub = '해고일 때만 (30일 전 예고를 못 받으면)'; }
		else if (x.n === 'yes') { nSub = '30일 전에 예고를 받았으면 없어요'; }
		else if (months < 3) { nSub = '근무 3개월 미만은 받지 못해요'; }
		else { notice = dOrd * 30; nSub = '30일 × 1일 통상임금 ' + won(dOrd); }
		var per = x.p !== '' ? +x.p : (work < 365 ? 0 : work < 365 * 3 ? 1 : work < 365 * 5 ? 2 : work < 365 * 10 ? 3 : 4);
		var low = Math.floor(S.min * 0.8 * Math.min(8, x.h)), raw = avg * 0.6, daily = Math.floor(Math.min(Math.max(raw, low), S.max)), cap = raw > S.max ? '상한액' : raw < low ? '하한액' : '';
		var period = (x.a === 'o' ? [120, 180, 210, 240, 270] : [120, 150, 180, 210, 240])[per];
		var uOk = x.r !== 'self' && (x.p !== '' || work >= 210), unemp = uOk ? daily * period : 0, uSub;
		if (x.r === 'self') { uSub = '스스로 그만두면 원칙적으로 대상이 아니에요'; }
		else if (!uOk) { uSub = '고용보험 가입(보수 받은 날) 180일 이상이 필요해요'; }
		else { uSub = '하루 ' + won(daily) + (cap ? '(' + cap + ')' : '') + ' × ' + period + '일'; }
		var tot = sev + leave + notice + unemp, cnt = (sev > 0) + (leave > 0) + (notice > 0) + (unemp > 0);
		var h = '<div class="eb-qa__tot"><small>받을 수 있는 돈 (세전 예상)</small><b>' + (tot >= 1e4 ? '약 ' + kr(Math.round(tot / 1e4) * 1e4) : won(tot)) + '</b><small>4가지 중 ' + cnt + '가지 해당 · ' + won(tot) + '</small></div><ul class="eb-qa__rows">'
			+ row('퇴직금', work >= 365 ? work.toLocaleString('ko-KR') + '일 근무 · 1일 평균임금 ' + won(avg) : '근무 1년 미만이라 대상이 아니에요', sev, sev > 0)
			+ row('연차수당', x.d ? x.d + '일 × 1일 통상임금 ' + won(dOrd) : '못 쓴 연차가 없어요', leave, leave > 0)
			+ row('해고예고수당', nSub, notice, notice > 0)
			+ row('실업급여', uSub, unemp, unemp > 0) + '</ul>';
		var quit = l + DAY, todo = [[md(quit + 14 * DAY), (sev || leave || notice ? '퇴직금·연차수당 받는 기한' : '마지막 월급 받는 기한') + ' (퇴사 후 14일)']];
		if (uOk) {
			todo.push(['퇴사 직후', '회사에 이직확인서 제출 요청']);
			todo.push(['되도록 빨리', '고용24 구직 등록 → 고용센터 실업급여 신청']);
			todo.push([ymd(addMonths(quit, 12) - DAY), '실업급여 받을 수 있는 마지막 날 (퇴사 다음 날부터 1년)']);
		}
		h += '<p class="eb-qa__h">퇴사 뒤 할 일</p><ul class="eb-qa__todo">' + todo.map(function (t) { return '<li><time>' + t[0] + '</time><span>' + t[1] + '</span></li>'; }).join('') + '</ul>';
		h += '<div class="eb-qa__act"><button type="button" data-qa-share>결과 공유</button><button type="button" data-qa-how aria-expanded="false">계산 과정</button></div>';
		h += '<ol class="eb-qa__how" hidden>'
			+ '<li>재직 일수 = 마지막 근무일 − 입사일 + 1 = <b>' + work.toLocaleString('ko-KR') + '일</b></li>'
			+ '<li>1일 평균임금 = 3개월 임금 ' + won(x.w) + ' ÷ ' + d3 + '일 = <b>' + won(avg) + '</b></li>'
			+ '<li>퇴직금 = ' + won(avg) + ' × 30일 × (' + work.toLocaleString('ko-KR') + '일 ÷ 365일) = <b>' + won(sev) + '</b>' + (work < 365 ? ' (1년 미만 → 0원)' : '') + '</li>'
			+ '<li>1일 통상임금 = 월 통상임금 ' + won(ord) + ' ÷ 월 ' + mh + '시간 × ' + x.h + '시간 = <b>' + won(dOrd) + '</b></li>'
			+ '<li>연차수당 = ' + won(dOrd) + ' × ' + x.d + '일 = <b>' + won(leave) + '</b></li>'
			+ '<li>해고예고수당 = ' + (notice ? won(dOrd) + ' × 30일 = <b>' + won(notice) + '</b>' : '<b>0원</b> (' + nSub + ')') + '</li>'
			+ '<li>실업급여 하루 = 평균임금 ' + won(avg) + ' × 60% = ' + won(raw) + ' → ' + S.year + '년 하한 ' + won(low) + '·상한 ' + won(S.max) + ' 적용 <b>' + won(daily) + '</b>, 받는 기간 <b>' + period + '일</b></li></ol>';
		h += '<p class="eb-qa__note">세전 예상 금액이에요. 상시 5인 미만 사업장은 연차 규정이 적용되지 않고, 주 15시간 미만으로 일했다면 퇴직금이 없어요. 실업급여 가입 요건은 근무 일수로 어림했으니 고용센터에서 확인하세요.' + (S.embed ? '' : ' <a href="' + S.guide + '">퇴사 뒤 챙길 것 모두 보기</a>') + '</p>';
		res.innerHTML = h;
		res.hidden = false;
		done = true;
		res.querySelector('[data-qa-how]').addEventListener('click', function () {
			var o = this.getAttribute('aria-expanded') !== 'true';
			this.setAttribute('aria-expanded', o ? 'true' : 'false');
			res.querySelector('.eb-qa__how').hidden = !o;
		});
		res.querySelector('[data-qa-share]').addEventListener('click', function () {
			var b = this, x2 = val(), q = [];
			['s', 'l', 'w', 'd', 'a', 'r', 'n', 'o', 'p', 'h'].forEach(function (k) { if (x2[k] !== '' && x2[k] !== 0) { q.push('q' + k + '=' + encodeURIComponent(x2[k])); } });
			var url = S.url + '?' + q.join('&');
			if (navigator.share) { navigator.share({ title: '퇴사 한 번에 계산 결과', url: url }).catch(function () {}); return; }
			(navigator.clipboard ? navigator.clipboard.writeText(url) : Promise.reject()).then(function () { b.textContent = '주소 복사됨'; setTimeout(function () { b.textContent = '결과 공유'; }, 2000); }, function () { window.prompt('이 주소를 복사하세요', url); });
		});
	}
	root.querySelectorAll('.eb-qa__seg').forEach(function (g) {
		g.querySelectorAll('button').forEach(function (b) {
			b.addEventListener('click', function () {
				setSeg(g.getAttribute('data-qa-name'), b.getAttribute('data-v'));
				if (g.getAttribute('data-qa-name') === 'r') { root.querySelector('[data-qa-notice]').hidden = b.getAttribute('data-v') !== 'fire'; }
				if (done) { calc(); }
			});
		});
	});
	['w', 'o'].forEach(function (k) {
		form[k].addEventListener('input', function () {
			money(form[k]);
			if (k === 'w') { root.querySelector('[data-qa-kr]').textContent = kr(num(form.w.value)); }
		});
	});
	form.addEventListener('change', function () { if (done) { calc(); } });
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		calc();
		if (done && !S.embed) { var t = res.getBoundingClientRect().top + window.pageYOffset - 90; window.scrollTo({ top: t, behavior: 'smooth' }); }
	});
	// 공유 주소로 열었을 때: 입력값을 채우고 바로 계산
	var q = new URLSearchParams(location.search);
	if (q.get('qs') && q.get('ql') && q.get('qw')) {
		form.sd.value = q.get('qs'); form.l.value = q.get('ql');
		form.w.value = q.get('qw'); money(form.w);
		root.querySelector('[data-qa-kr]').textContent = kr(num(form.w.value));
		if (q.get('qd')) { form.d.value = num(q.get('qd')); }
		if (q.get('qo')) { form.o.value = q.get('qo'); money(form.o); }
		if (q.get('qh')) { form.h.value = num(q.get('qh')); }
		if (/^[0-4]$/.test(q.get('qp') || '')) { form.p.value = q.get('qp'); }
		if (q.get('qa') === 'o') { setSeg('a', 'o'); }
		if (/^(self|adv|fire)$/.test(q.get('qr') || '')) { setSeg('r', q.get('qr')); root.querySelector('[data-qa-notice]').hidden = q.get('qr') !== 'fire'; }
		if (q.get('qn') === 'yes') { setSeg('n', 'yes'); }
		if (q.get('qo') || q.get('qp') || q.get('qh')) { root.querySelector('.eb-qa__more').open = true; }
		calc();
	}
	// 붙여 쓴 화면: 높이를 부모 창에 알려 줌(받는 쪽에서 쓰고 싶을 때)
	if (S.embed && window.parent !== window && window.ResizeObserver) {
		new ResizeObserver(function () { window.parent.postMessage({ ebQuitHeight: document.documentElement.scrollHeight }, '*'); }).observe(document.body);
	}
})();
JS;
}

// 붙여 쓰기: '한 번에' 계산기 4개 (2026-10-17 6차에 퇴사 → 4개로 넓힘). 키 => [ /embed/키/, 원래 페이지, 이름, 한 줄 설명, iframe 높이, 그리는 함수 ]
// 다른 계산기 16개는 넣지 않음 - 흔한 단일 계산기라 붙여 쓰는 쪽 이득이 작고, 화면 계산 스크립트(11번)가 페이지 전체에 걸려 있어 따로 떼기 무거움
function eb_qa_embeds() {
	return array(
		'quit'  => array( '/embed/quit/', '/calculator/quit-all/', '퇴사 한 번에 계산', '퇴직금·연차수당·해고예고수당·실업급여', 760, function () { return eb_quit_html( true ); } ),
		'baby'  => array( '/embed/baby/', '/calculator/baby-all/', '출산·육아 한 번에 계산', '두 살까지 달마다 받는 지원금', 820, function () { return do_shortcode( '[eb_baby]' ); } ),
		'pay'   => array( '/embed/pay/', '/calculator/take-home-pay/', '연봉 실수령액 계산', '4대보험·세금 빼고 받는 월급', 780, function () { return do_shortcode( '[eb_pay]' ); } ),
		'close' => array( '/embed/close/', '/calculator/closing-all/', '폐업 한 번에 계산', '철거비·노란우산·자영업자 실업급여', 860, function () { return do_shortcode( '[eb_close]' ); } ),
	);
}

// 붙여 쓰기 상자(계산기 아래). 붙여 쓴 화면 안(전역 eb_qa_embed)에서는 그리지 않음
function eb_qa_embed_box( $key ) {
	$e = eb_qa_embeds();
	if ( ! eb_quit_embed_live() || empty( $e[ $key ] ) || ! empty( $GLOBALS['eb_qa_embed'] ) ) {
		return '';
	}
	$e    = $e[ $key ];
	$page = home_url( $e[1] );
	$code = '<iframe src="' . home_url( $e[0] ) . '" width="100%" height="' . (int) $e[4] . '" style="border:0;max-width:640px" loading="lazy" title="' . esc_attr( $e[2] ) . '"></iframe>' . "\n" . '<p>출처: <a href="' . $page . '">이지복지닷컴 ' . esc_html( $e[2] ) . '기</a></p>';
	return '<details class="eb-emb" id="qa-embed" open><summary class="eb-emb__t">내 블로그에 이 계산기 넣기</summary><div class="eb-emb__in"><p class="eb-emb__d">무료예요. 출처 링크만 지워지지 않게 해 주세요.</p>'
		. '<div class="eb-qa__seg" role="group" aria-label="블로그 종류" data-emb-tab><button type="button" data-v="code" aria-pressed="true">티스토리·워드프레스</button><button type="button" data-v="link" aria-pressed="false">네이버 블로그</button></div>'
		. '<div class="eb-emb__pan" data-emb="code"><textarea class="eb-emb__code" readonly rows="6" aria-label="붙여 쓰는 코드">' . esc_textarea( $code ) . '</textarea><button type="button" class="eb-emb__copy">코드 복사</button><p class="eb-emb__d">티스토리는 글쓰기 화면 오른쪽 위 \'기본모드\'를 \'HTML\'로 바꾼 뒤 붙여 넣으세요.</p></div>'
		. '<div class="eb-emb__pan" data-emb="link" hidden><textarea class="eb-emb__code" readonly rows="1" aria-label="계산기 주소">' . esc_textarea( $page ) . '</textarea><button type="button" class="eb-emb__copy">주소 복사</button><p class="eb-emb__d">네이버 블로그는 코드를 넣을 수 없어요. 글에 주소를 붙여 넣으면 생기는 링크 카드로 안내해 주세요.</p></div></div></details>'
		. "<script nowprocket>(function(){var b=document.querySelector('.eb-emb');if(!b){return;}var t=b.querySelector('[data-emb-tab]');t.querySelectorAll('button').forEach(function(x){x.addEventListener('click',function(){t.querySelectorAll('button').forEach(function(y){y.setAttribute('aria-pressed',y===x?'true':'false');});b.querySelectorAll('[data-emb]').forEach(function(p){p.hidden=p.getAttribute('data-emb')!==x.getAttribute('data-v');});});});b.querySelectorAll('.eb-emb__copy').forEach(function(c){var l=c.textContent;c.addEventListener('click',function(){var a=c.previousElementSibling;a.select();var ok=function(){c.textContent='복사됨';setTimeout(function(){c.textContent=l;},2000);};if(navigator.clipboard){navigator.clipboard.writeText(a.value).then(ok,function(){document.execCommand('copy');ok();});}else{document.execCommand('copy');ok();}});});})();</script>";
}
// 예전 이름(다른 곳에서 부르면)
function eb_quit_embed_box() {
	return eb_qa_embed_box( 'quit' );
}

add_shortcode( 'eb_quit', function () {
	return eb_quit_html( false ) . eb_qa_embed_box( 'quit' );
} );

// /embed/{quit|baby|pay|close}/ : 다른 블로그 iframe 안에 들어갈 계산기만 있는 화면. 검색 제외 + 원래 페이지를 canonical로
// CSS는 css/90-tools.css의 '퇴사 한 번에'(끝 표시 줄까지)와 '한 번에 계산기 더'(끝 표시 줄까지) 두 묶음을 잘라 씀
add_action( 'template_redirect', function () {
	$path = untrailingslashit( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ) );
	if ( ! preg_match( '#^/embed/(quit|baby|pay|close)$#', $path, $m ) ) {
		return;
	}
	$e = eb_qa_embeds()[ $m[1] ];
	if ( ! eb_quit_embed_live() ) {
		wp_safe_redirect( home_url( $e[1] ), 302 );
		exit;
	}
	$file = get_stylesheet_directory() . '/css/90-tools.css';
	$key  = 'eb_qa_css_' . ( file_exists( $file ) ? filemtime( $file ) : 0 );
	$css  = get_transient( $key );
	if ( false === $css ) {
		$all = file_exists( $file ) ? (string) file_get_contents( $file ) : '';
		$css = '';
		foreach ( array( array( '/* ===== 퇴사 한 번에', '/* ===== /퇴사 한 번에' ), array( '/* ===== 한 번에 계산기 더', '/* ===== /한 번에 계산기 더' ) ) as $mk ) {
			$a = strpos( $all, $mk[0] );
			$b = false !== $a ? strpos( $all, $mk[1], $a ) : false;
			if ( false !== $a && false !== $b ) {
				$css .= substr( $all, $a, $b - $a );
			}
		}
		$css = trim( preg_replace( '/\s+/', ' ', preg_replace( '#/\*.*?\*/#s', '', $css ) ) );
		set_transient( $key, $css, WEEK_IN_SECONDS );
	}
	$GLOBALS['eb_qa_embed'] = true;
	$body = call_user_func( $e[5] );
	status_header( 200 );
	nocache_headers();
	header( 'Content-Type: text/html; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex, follow' );
	$page = home_url( $e[1] );
	echo '<!doctype html><html lang="ko"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,follow"><title>' . esc_html( $e[2] ) . ' - 이지복지닷컴</title><link rel="canonical" href="' . esc_url( $page ) . '">'
		. '<style>*,*::before,*::after{box-sizing:border-box}html{-webkit-text-size-adjust:100%}body{margin:0;padding:12px;font-family:Pretendard,-apple-system,BlinkMacSystemFont,system-ui,"Apple SD Gothic Neo","Noto Sans KR","Malgun Gothic",sans-serif;color:#1b2433;background:#fff;line-height:1.6}a{color:#1d3c78}.eb-qa__by{margin:12px 0 0;font-size:12.5px;text-align:center;color:#6b7684}.eb-qa__cmp th,.eb-qa__cmp td{padding:8px 12px;text-align:right;border-top:1px solid #eef1f5}.eb-qa__cmp th{font-size:12px;color:#6b7684;background:#f6f8fb;border-top:0}.eb-qa__cmp :is(th,td):first-child{text-align:left}.eb-qa__cmp tr.is-on td{font-weight:800;color:#1d3c78;background:#f3f6fb}.eb-qa__tl li{list-style:none}' . $css . '</style></head><body>'
		. '<p class="eb-qa__by" style="margin:0 0 10px;font-size:15px;font-weight:800;color:#1b2433;text-align:left">' . esc_html( $e[2] ) . ' <span style="font-weight:400;font-size:12.5px;color:#6b7684">' . esc_html( $e[3] ) . '</span></p>'
		. $body
		. '<p class="eb-qa__by">' . (int) eb_rates()['year'] . '년 기준 · 만든 곳 <a href="' . esc_url( $page ) . '" target="_blank" rel="noopener">이지복지닷컴</a></p></body></html>';
	exit;
}, 0 );

/* 73. '한 번에' 계산기 더 - 출산·육아 [eb_baby] · 연봉 실수령액 [eb_pay] · 폐업 [eb_close] (2026-10-17, 72번 퇴사 계산기와 같은 부품 .eb-qa, css/90-tools.css '한 번에 계산기 더') ------
 * 공통: eb_qa_seg()·eb_qa_in() 입력 부품, eb_qa_lib_js() 화면 계산 도우미(window.ebQa). 링크는 회색 칩(.eb-qa__solo)으로 눈에 덜 띄게
 * 출산·육아(/calculator/baby-all/): 첫만남이용권(첫째 200만·둘째 이상 300만), 부모급여(0세 100만·1세 50만, 어린이집이면 보육료 0세반 58.4만·1세반 51.5만을 뺀 차액만 현금),
 *   아동수당(만 9세 미만, 수도권 10만·비수도권 10.5만·인구감소 우대 11만·특별 12만 - 보건복지부 2026.4~), 출산휴가급여(11번 maternity와 같은 식), 육아휴직급여(eb_parental(), 6+6)
 *   → 두 살까지 달마다 받는 돈을 같은 구성끼리 묶어서 보여 줌. 엄마 출산휴가는 출생 달부터 3개월, 엄마 휴직은 그 뒤, 아빠 휴직은 엄마 휴직이 끝난 뒤로 가정
 * 연봉 실수령액(/calculator/take-home-pay/): 4대보험은 11번 insurance와 같은 식, 소득세는 소득세법 시행령 별표2 간이세액표 산식
 *   (근로소득공제·기본공제 150만×가족 수·연금보험료공제·'특별소득공제 등' 310/360/500만 산식·세율·근로소득세액공제와 한도, 8~20세 자녀 월 20,830/45,830/+33,330원) → 원천징수 근사치
 * 폐업(/calculator/closing-all/): 희망리턴패키지 점포철거비(3.3㎡당 20만, 최대 600만, 실비) · 전직장려수당(최대 100만) · 노란우산 폐업공제금(낸 돈 + 연복리 이자, 이율은 고칠 수 있음)
 *   · 자영업자 실업급여(기준보수 1~7등급 182만~338만의 60%, 가입 1~3년 120일·3~5년 150일·5~10년 180일·10년 이상 210일, 고용보험법 제69조의5·6)
 */
function eb_qa_seg( $name, $label, $opts, $on, $cls = '' ) {
	$b = '';
	foreach ( $opts as $v => $t ) {
		$b .= '<button type="button" data-v="' . esc_attr( $v ) . '" aria-pressed="' . ( (string) $v === (string) $on ? 'true' : 'false' ) . '">' . esc_html( $t ) . '</button>';
	}
	return '<div class="eb-qa__f"><span class="eb-qa__l" id="qa-' . $name . '">' . esc_html( $label ) . '</span><div class="eb-qa__seg' . $cls . '" role="group" aria-labelledby="qa-' . $name . '" data-qa-name="' . $name . '">' . $b . '</div></div>';
}
function eb_qa_in( $name, $label, $unit, $ph = '', $hint = '', $val = '', $kr = false ) {
	$ph = '' !== $ph && '' === (string) $val ? '예: ' . $ph : $ph; // 빈 칸이면 '예: …' (2026-10-18)
	return '<label class="eb-qa__f"><span class="eb-qa__l">' . esc_html( $label ) . ( $hint ? ' <small>' . esc_html( $hint ) . '</small>' : '' ) . '</span><span class="eb-qa__in"><input type="text" inputmode="numeric" name="' . $name . '" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $ph ) . '" autocomplete="off"' . ( $kr ? ' data-money' : '' ) . '><em>' . esc_html( $unit ) . '</em></span>' . ( $kr ? '<small class="eb-qa__kr" aria-live="polite"></small>' : '' ) . '</label>';
}
// 계산기 아래 '하나씩 자세히' 칩 줄
function eb_qa_solo( $links ) {
	if ( ! empty( $GLOBALS['eb_qa_embed'] ) ) {
		return '';
	}
	$h = '<p class="eb-qa__solo"><span>하나씩 자세히</span>';
	foreach ( $links as $path => $name ) {
		$h .= '<a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $name ) . '</a>';
	}
	return $h . '</p>';
}
function eb_qa_lib_js() {
	return <<<'JS'
window.ebQa = window.ebQa || (function () {
	var DAY = 86400000;
	function num(v) { return parseInt(String(v == null ? '' : v).replace(/[^0-9]/g, ''), 10) || 0; }
	function won(n) { return Math.floor(n).toLocaleString('ko-KR') + '원'; }
	function man(n) { var v = Math.round(n / 1000) / 10; return (v % 1 ? v.toLocaleString('ko-KR', { maximumFractionDigits: 1 }) : v.toLocaleString('ko-KR')) + '만'; }
	function kr(n) { var e = Math.floor(n / 1e8), m = Math.floor(n % 1e8 / 1e4); return n < 1e4 ? '' : (e ? e + '억 ' : '') + (m ? m.toLocaleString('ko-KR') + '만' : '') + '원'; }
	function day(v) { if (!v || !/^\d{4}-\d{2}-\d{2}$/.test(v)) { return null; } var p = v.split('-'); return Date.UTC(+p[0], +p[1] - 1, +p[2]); }
	function addMonths(t, n) { var d = new Date(t), y = d.getUTCFullYear(), m = d.getUTCMonth() + n, last = new Date(Date.UTC(y, m + 1, 0)).getUTCDate(); return Date.UTC(y, m, Math.min(d.getUTCDate(), last)); }
	function md(t) { var d = new Date(t); return (d.getUTCMonth() + 1) + '.' + d.getUTCDate() + '(' + '일월화수목금토'.charAt(d.getUTCDay()) + ')'; }
	function ymd(t) { var d = new Date(t); return String(d.getUTCFullYear()).slice(2) + '.' + (d.getUTCMonth() + 1) + '.' + d.getUTCDate(); }
	function seg(root, name) { var b = root.querySelector('[data-qa-name="' + name + '"] [aria-pressed="true"]'); return b ? b.getAttribute('data-v') : ''; }
	function setSeg(root, name, v) { root.querySelectorAll('[data-qa-name="' + name + '"] button').forEach(function (x) { x.setAttribute('aria-pressed', x.getAttribute('data-v') === String(v) ? 'true' : 'false'); }); }
	function row(name, sub, v, on, txt) { return '<li' + (on ? '' : ' class="is-off"') + '><div><b>' + name + '</b><small>' + sub + '</small></div><span>' + (on ? (txt || won(v)) : '해당 없음') + '</span></li>'; }
	function how(list) { return '<ol class="eb-qa__how" hidden>' + list.map(function (x) { return '<li>' + x + '</li>'; }).join('') + '</ol>'; }
	function todo(list) { return '<p class="eb-qa__h">할 일</p><ul class="eb-qa__todo">' + list.map(function (t) { return '<li><time>' + t[0] + '</time><span>' + t[1] + '</span></li>'; }).join('') + '</ul>'; }
	// 입력·고르기·계산 버튼·결과 공유·계산 과정을 묶어 줌. calc(root)는 결과 HTML 또는 { err: '…' }
	function setup(root, calc, keys) {
		var form = root.querySelector('form'), res = root.querySelector('[data-qa-res]'), err = root.querySelector('[data-qa-err]'), done = false, S = JSON.parse(root.getAttribute('data-qa'));
		function run(scroll) {
			var out = calc(root, S);
			if (out && out.err) { err.textContent = out.err; err.hidden = false; res.hidden = true; return; }
			err.hidden = true;
			res.innerHTML = out + '<div class="eb-qa__act"><button type="button" data-qa-share>결과 공유</button><button type="button" data-qa-how aria-expanded="false">계산 과정</button></div>';
			res.hidden = false;
			done = true;
			res.querySelector('[data-qa-how]').addEventListener('click', function () {
				var o = this.getAttribute('aria-expanded') !== 'true', h = res.querySelector('.eb-qa__how');
				this.setAttribute('aria-expanded', o ? 'true' : 'false');
				if (h) { h.hidden = !o; }
			});
			res.querySelector('[data-qa-share]').addEventListener('click', function () {
				var b = this, q = [];
				keys.forEach(function (k) {
					var v = form[k] ? form[k].value : seg(root, k);
					if (v !== '' && v != null) { q.push('q' + k + '=' + encodeURIComponent(String(v).replace(/,/g, ''))); }
				});
				var url = S.url + '?' + q.join('&');
				if (navigator.share) { navigator.share({ title: document.title, url: url }).catch(function () {}); return; }
				(navigator.clipboard ? navigator.clipboard.writeText(url) : Promise.reject()).then(function () { b.textContent = '주소 복사됨'; setTimeout(function () { b.textContent = '결과 공유'; }, 2000); }, function () { window.prompt('이 주소를 복사하세요', url); });
			});
			if (scroll) { window.scrollTo({ top: res.getBoundingClientRect().top + window.pageYOffset - 90, behavior: 'smooth' }); }
		}
		root.querySelectorAll('.eb-qa__seg').forEach(function (g) {
			g.querySelectorAll('button').forEach(function (b) {
				b.addEventListener('click', function () {
					setSeg(root, g.getAttribute('data-qa-name'), b.getAttribute('data-v'));
					root.dispatchEvent(new CustomEvent('qa:seg', { detail: g.getAttribute('data-qa-name') }));
					if (done) { run(); }
				});
			});
		});
		root.querySelectorAll('input[data-money]').forEach(function (i) {
			var k = i.closest('label').querySelector('.eb-qa__kr');
			i.addEventListener('input', function () { var v = num(i.value); i.value = v ? v.toLocaleString('ko-KR') : ''; if (k) { k.textContent = kr(v); } });
		});
		form.addEventListener('change', function () { if (done) { run(); } });
		form.addEventListener('submit', function (e) { e.preventDefault(); run(true); });
		var q = new URLSearchParams(location.search), any = false;
		keys.forEach(function (k) {
			var v = q.get('q' + k);
			if (v === null) { return; }
			any = true;
			if (form[k]) { form[k].value = v; form[k].dispatchEvent(new Event('input')); } else { setSeg(root, k, v); root.dispatchEvent(new CustomEvent('qa:seg', { detail: k })); }
		});
		if (any) { run(); }
	}
	return { DAY: DAY, num: num, won: won, man: man, kr: kr, day: day, addMonths: addMonths, md: md, ymd: ymd, seg: seg, setSeg: setSeg, row: row, how: how, todo: todo, setup: setup };
})();
JS;
}

// 출산·육아 한 번에 기준값(2026). 바뀌면 여기만
function eb_baby_rates() {
	return array(
		'first'  => array( 1 => 2000000, 2 => 3000000 ), // 첫만남이용권: 첫째 / 둘째 이상
		'parent' => array( 1000000, 500000 ),            // 부모급여: 0세(0~11개월) / 1세(12~23개월)
		'fee'    => array( 584000, 515000 ),             // 어린이집 보육료(기본보육) 0세반 / 1세반, 2026.1~
		'child'  => array( 'cap' => 100000, 'non' => 105000, 'pop' => 110000, 'sp' => 120000 ), // 아동수당 월액(2026.4~ 지역별)
	);
}

add_shortcode( 'eb_baby', function () {
	$r   = eb_rates();
	$set = array( 'url' => home_url( '/calculator/baby-all/' ), 'min' => (int) $r['min_wage'], 'matcap' => (int) $r['mat_cap'], 'pl' => eb_parental(), 'b' => eb_baby_rates() );
	$reg = '<label class="eb-qa__f"><span class="eb-qa__l">사는 곳 <small>아동수당 금액</small></span><select name="r"><option value="cap">수도권 (월 10만원)</option><option value="non">비수도권 (월 10.5만원)</option><option value="pop">인구감소지역 우대 (월 11만원)</option><option value="sp">인구감소지역 특별 (월 12만원)</option></select></label>';
	$h   = '<div class="eb-qa" data-calc="baby" data-qa="' . esc_attr( wp_json_encode( $set ) ) . '"><form class="eb-qa__form" novalidate>'
		. '<div class="eb-qa__g2"><label class="eb-qa__f"><span class="eb-qa__l">출생(예정)일</span><input type="date" name="b"></label>' . eb_qa_seg( 'k', '몇째 아이', array( 1 => '첫째', 2 => '둘째 이상' ), 1 ) . '</div>'
		. eb_qa_seg( 'c', '아이 돌봄', array( 'home' => '집에서', 'one' => '돌부터 어린이집', 'all' => '처음부터 어린이집' ), 'home', ' is-3' )
		. '<div class="eb-qa__g2">' . eb_qa_in( 'mw', '엄마 월 통상임금', '원', '3,000,000', '비우면 휴직 없음', '', true ) . eb_qa_in( 'ml', '엄마 육아휴직', '개월', '12', '', '12' ) . '</div>'
		. '<div class="eb-qa__g2">' . eb_qa_in( 'fw', '아빠 월 통상임금', '원', '3,000,000', '비우면 휴직 없음', '', true ) . eb_qa_in( 'fl', '아빠 육아휴직', '개월', '0', '', '0' ) . '</div>'
		. '<details class="eb-qa__more"><summary>자세히 고치기 <small>사는 곳·회사 규모</small></summary><div class="eb-qa__morein">' . $reg
		. eb_qa_seg( 'z', '엄마 회사 규모', array( 'small' => '중소기업 등', 'big' => '대기업' ), 'small' ) . '</div></details>'
		. '<p class="eb-qa__err" data-qa-err role="alert" hidden></p><button type="submit" class="eb-qa__go">한 번에 계산하기</button></form>'
		. '<div class="eb-qa__res" data-qa-res aria-live="polite" hidden></div>'
		. eb_qa_solo( array( '/calculator/maternity-leave-pay/' => '출산휴가급여', '/calculator/parental-leave-pay/' => '육아휴직급여', '/guide/raising-kids/' => '아이 키우기 가이드' ) ) . '</div>' . eb_qa_embed_box( 'baby' );
	return $h . "<script nowprocket>\n" . eb_qa_lib_js() . "\n" . <<<'JS'
(function () {
	var Q = window.ebQa, root = document.querySelector('[data-calc="baby"]');
	if (!root) { return; }
	function leave(S, wage, i, six) {
		var p = S.pl, pay;
		if (six && i <= 6) { pay = Math.min(wage, p.six[i - 1]); } else { var s = p.steps.filter(function (x) { return i <= x[0]; })[0] || p.steps[p.steps.length - 1]; pay = Math.min(wage * s[1] / 100, s[2]); }
		return Math.floor(Math.max(pay, p.floor));
	}
	function calc(root, S) {
		var f = root.querySelector('form'), B = S.b, b = Q.day(f.b.value);
		if (b === null) { return { err: '출생(예정)일을 넣어 주세요.' }; }
		var kid = +Q.seg(root, 'k'), care = Q.seg(root, 'c'), mw = Q.num(f.mw.value), fw = Q.num(f.fw.value);
		var ml = mw ? Math.min(18, Q.num(f.ml.value)) : 0, fl = fw ? Math.min(18, Q.num(f.fl.value)) : 0, big = Q.seg(root, 'z') === 'big';
		var M = [], k, cash = 0, vouch = 0, warn = '';
		for (k = 0; k < 24; k++) { M.push({ v: {}, t: 0, c: [0, 0, 0] }); }
		function add(k, name, amt, cat, isV) { if (k < 0 || k > 23 || amt <= 0) { return; } M[k].v[name] = (M[k].v[name] || 0) + amt; M[k].t += amt; if (cat >= 0) { M[k].c[cat] += amt; } if (isV) { vouch += amt; } else { cash += amt; } }
		add(0, '첫만남이용권', B.first[kid >= 2 ? 2 : 1], -1, true);
		for (k = 0; k < 24; k++) {
			var pg = B.parent[k < 12 ? 0 : 1], fee = B.fee[k < 12 ? 0 : 1], dc = care === 'all' || (care === 'one' && k >= 12);
			if (dc) { add(k, '부모급여', Math.max(0, pg - fee), 1); add(k, '보육료 바우처', Math.min(pg, fee), -1, true); } else { add(k, '부모급여', pg, 1); }
			add(k, '아동수당', B.child[f.r.value] || B.child.cap, 2);
		}
		// 엄마 출산휴가 90일 = 출생 달부터 3개월(30일씩). 중소기업은 고용보험이 90일 모두(상한), 대기업은 앞 60일 회사·뒤 30일 고용보험
		var mat = 0;
		if (mw) {
			var gm = Math.min(Math.max(mw, S.min * 209), S.matcap);
			for (k = 0; k < 3; k++) {
				var pay = big ? (k < 2 ? mw : gm) : gm + (k < 2 ? Math.max(0, mw - gm) : 0);
				add(k, '출산휴가', Math.floor(pay), 0);
				mat += Math.floor(pay);
			}
		}
		// 육아휴직: 엄마는 출산휴가 뒤(4번째 달)부터, 아빠는 엄마 휴직이 끝난 뒤(엄마가 안 쉬면 출생 달)부터. 6+6은 둘 다 생후 18개월 안에 쉬면
		var ms = 3, fs = ml ? ms + ml : 0, six = ml > 0 && fl > 0 && fs < 18, mtot = 0, ftot = 0, i;
		for (i = 1; i <= ml; i++) { var a = leave(S, mw, i, six); if (ms + i - 1 < 24) { add(ms + i - 1, '엄마 육아휴직', a, 0); } mtot += a; }
		for (i = 1; i <= fl; i++) { var c = leave(S, fw, i, six); if (fs + i - 1 < 24) { add(fs + i - 1, '아빠 육아휴직', c, 0); } ftot += c; }
		if ((ml > 12 || fl > 12) && (ml < 3 || fl < 3)) { warn = '1년을 넘는 육아휴직(최대 1년 6개월)은 부모가 각각 3개월 이상 쉬어야 해요.'; }
		// 같은 구성끼리 묶기
		var G = [], sig = function (x) { return Object.keys(x.v).map(function (n) { return n + x.v[n]; }).join('|'); };
		for (k = 0; k < 24; k++) { var l = G[G.length - 1]; if (l && k > 0 && l.s === sig(M[k]) && l.from > 0) { l.to = k; } else { G.push({ from: k, to: k, s: sig(M[k]), m: M[k] }); } }
		function lab(g) { var a = new Date(Q.addMonths(b, g.from)), z = new Date(Q.addMonths(b, g.to)), y = function (d) { return String(d.getUTCFullYear()).slice(2) + '.' + (d.getUTCMonth() + 1); }; return g.from === g.to ? y(a) + '월' : y(a) + '~' + (a.getUTCFullYear() === z.getUTCFullYear() ? (z.getUTCMonth() + 1) : y(z)) + '월'; }
		function sub(g) { if (g.from === 0) { return '출생 달'; } var n = g.to - g.from + 1; return '생후 ' + g.from + (n > 1 ? '~' + g.to : '') + '개월'; }
		var tot = cash + vouch, rows = G.map(function (g) {
			var t = g.m.t, c = g.m.c, sum = c[0] + c[1] + c[2] || 1;
			var tags = Object.keys(g.m.v).map(function (n) { return '<em' + (/바우처|첫만남/.test(n) ? ' class="is-v"' : '') + '>' + n + ' <b>' + Q.man(g.m.v[n]) + '</b></em>'; }).join('');
			return '<li><div class="eb-qa__tlh"><b>' + lab(g) + '<small>' + sub(g) + '</small></b><span>' + (g.to > g.from ? '월 ' : '') + Q.man(t) + '</span></div><div class="eb-qa__tags">' + tags + '</div>'
				+ '<div class="eb-qa__bar" aria-hidden="true"><i class="k1" style="width:' + (c[0] / sum * 100) + '%"></i><i class="k2" style="width:' + (c[1] / sum * 100) + '%"></i><i class="k3" style="width:' + (c[2] / sum * 100) + '%"></i></div></li>';
		}).join('');
		var h = '<div class="eb-qa__tot"><small>두 살까지 받는 돈 (예상)</small><b>약 ' + Q.kr(Math.round(tot / 1e4) * 1e4) + '</b><small>현금 ' + Q.man(cash) + (vouch ? ' + 바우처 ' + Q.man(vouch) : '') + ' · 24개월 합계</small></div>'
			+ '<ul class="eb-qa__tl">' + rows + '</ul><p class="eb-qa__lg"><span><i class="k1"></i>휴가·휴직 급여</span><span><i class="k2"></i>부모급여</span><span><i class="k3"></i>아동수당</span></p>'
			+ (warn ? '<p class="eb-qa__err">' + warn + '</p>' : '');
		var t60 = b + 59 * Q.DAY, list = [[Q.md(t60), '부모급여·아동수당 신청 마감 — 출생일부터 60일 안에 신청해야 출생 달부터 받아요(행복출산 원스톱)']];
		if (mw) { list.push(['휴가 끝나고', '고용24에서 출산휴가급여 신청']); }
		if (ml || fl) { list.push(['휴직 1개월 뒤', '육아휴직급여 매달 신청 (휴직이 끝난 뒤 12개월 안에)']); }
		if (fw) { list.push(['출산 후 120일 안', '아빠 배우자 출산휴가 20일(나눠 쓰기 가능)']); }
		h += Q.todo(list) + Q.how([
			'첫만남이용권 ' + Q.won(B.first[kid >= 2 ? 2 : 1]) + ' (국민행복카드 바우처)',
			'부모급여 0세 월 ' + Q.won(B.parent[0]) + ', 1세 월 ' + Q.won(B.parent[1]) + (care !== 'home' ? ' — 어린이집을 다니는 달은 보육료(0세반 ' + Q.won(B.fee[0]) + '·1세반 ' + Q.won(B.fee[1]) + ')를 뺀 차액만 현금' : ''),
			'아동수당 월 ' + Q.won(B.child[f.r.value] || B.child.cap) + ' × 24개월',
			mw ? '출산휴가 90일 합계(고용보험 급여 + 회사 차액) ' + Q.won(mat) + (big ? ' (앞 60일 회사, 뒤 30일 고용보험 상한 ' + Q.won(S.matcap) + ')' : ' (고용보험 30일 상한 ' + Q.won(S.matcap) + ' + 앞 60일 차액은 회사)') : '출산휴가급여: 엄마 월급을 비워 계산하지 않음',
			ml ? '엄마 육아휴직 ' + ml + '개월 ' + Q.won(mtot) + (six ? ' (6+6 첫 6개월 상한 적용)' : '') : '엄마 육아휴직 없음',
			fl ? '아빠 육아휴직 ' + fl + '개월 ' + Q.won(ftot) + (six ? ' (6+6 첫 6개월 상한 적용)' : '') + ', 엄마 휴직이 끝난 뒤로 가정' : '아빠 육아휴직 없음',
			'육아휴직급여: 1~3개월 100%(상한 250만) · 4~6개월 100%(상한 200만) · 7개월부터 80%(상한 160만), 하한 월 70만'
		]) + '<p class="eb-qa__note">세금 없는 급여 기준 예상이에요. 24개월이 넘는 휴직 급여는 합계에 넣지 않았어요. 한부모·쌍둥이 등은 기준이 달라요.</p>';
		return h;
	}
	Q.setup(root, calc, ['b', 'k', 'c', 'mw', 'ml', 'fw', 'fl', 'r', 'z']);
})();
JS
		. "\n</script>";
} );

add_shortcode( 'eb_pay', function () {
	$r   = eb_rates();
	$set = array( 'url' => home_url( '/calculator/take-home-pay/' ), 'rates' => $r );
	$h   = '<div class="eb-qa" data-calc="pay" data-qa="' . esc_attr( wp_json_encode( $set ) ) . '"><form class="eb-qa__form" novalidate>'
		. eb_qa_seg( 'm', '어떤 금액을 넣을까요?', array( 'y' => '연봉', 'mo' => '월급' ), 'y' )
		. eb_qa_in( 'a', '세전 연봉', '원', '40,000,000', '퇴직금 빼고', '', true )
		. '<div class="eb-qa__g2">' . eb_qa_in( 't', '비과세 (월)', '원', '200,000', '식대 등', '200,000', true ) . eb_qa_in( 'fm', '부양가족 수', '명', '1', '본인 포함', '1' ) . '</div>'
		. eb_qa_in( 'kd', '8~20세 자녀 수', '명', '0', '부양가족 중', '0' )
		. '<p class="eb-qa__err" data-qa-err role="alert" hidden></p><button type="submit" class="eb-qa__go">실수령액 계산하기</button></form>'
		. '<div class="eb-qa__res" data-qa-res aria-live="polite" hidden></div>'
		. eb_qa_solo( array( '/calculator/social-insurance/' => '4대보험', '/calculator/minimum-wage/' => '최저임금 월급', '/calculator/weekly-holiday-pay/' => '주휴수당·월급' ) ) . '</div>' . eb_qa_embed_box( 'pay' );
	return $h . "<script nowprocket>\n" . eb_qa_lib_js() . "\n" . <<<'JS'
(function () {
	var Q = window.ebQa, root = document.querySelector('[data-calc="pay"]');
	if (!root) { return; }
	var f10 = function (n) { return Math.floor((n + 1e-7) / 10) * 10; };
	// 한 달 세전 급여 → 공제 항목(근로소득 간이세액표 산식 근사)
	function net(gross, nontax, fam, kids, r, hi) {
		var tx = Math.max(0, gross - nontax), base = Math.min(r.pension_cap, Math.max(r.pension_floor, Math.floor(tx / 1000) * 1000));
		var pen = f10(base * r.pension_rate / 100), hea = f10(tx * r.health_rate / 100), care = f10(hea * r.care_total / r.health_total), emp = f10(tx * r.employ_rate / 100);
		var T = tx * 12, wd;
		if (T <= 5e6) { wd = T * 0.7; } else if (T <= 15e6) { wd = 35e5 + (T - 5e6) * 0.4; } else if (T <= 45e6) { wd = 75e5 + (T - 15e6) * 0.15; } else if (T <= 1e8) { wd = 12e6 + (T - 45e6) * 0.05; } else { wd = 1475e4 + (T - 1e8) * 0.02; }
		wd = Math.min(wd, 2e7);
		var n = Math.max(1, fam), sp;
		var bA = n === 1 ? 31e5 : n === 2 ? 36e5 : 5e6, rL = n >= 3 ? 0.07 : 0.04, rM = n === 1 ? 0.015 : n === 2 ? 0.02 : 0.05, rH = n === 1 ? 0.005 : n === 2 ? 0.01 : 0.03;
		if (T <= 3e7) { sp = bA + T * rL; } else if (T <= 45e6) { sp = bA + T * rL - (T - 3e7) * 0.05; } else if (T <= 7e7) { sp = bA + T * rM; } else { sp = bA + T * rH; }
		if (n >= 3 && T > 4e7) { sp += (T - 4e7) * 0.04; }
		var tb = Math.max(0, T - wd - 15e5 * n - pen * 12 - sp), br = [[14e6, 0.06, 0], [5e7, 0.15, 126e4], [88e6, 0.24, 576e4], [15e7, 0.35, 1544e4], [3e8, 0.38, 1994e4], [5e8, 0.4, 2594e4], [1e9, 0.42, 3594e4], [1e99, 0.45, 6594e4]];
		var b = br.filter(function (x) { return tb <= x[0]; })[0], calc = Math.max(0, tb * b[1] - b[2]);
		var cr = calc <= 13e5 ? calc * 0.55 : 715e3 + (calc - 13e5) * 0.3, lim;
		if (T <= 33e6) { lim = 74e4; } else if (T <= 7e7) { lim = Math.max(66e4, 74e4 - (T - 33e6) * 0.008); } else if (T <= 12e7) { lim = Math.max(5e5, 66e4 - (T - 7e7) * 0.5); } else { lim = Math.max(2e5, 5e5 - (T - 12e7) * 0.5); }
		var year = Math.max(0, calc - Math.min(cr, lim)), kd = kids <= 0 ? 0 : kids === 1 ? 20830 : kids === 2 ? 45830 : 45830 + 33330 * (kids - 2);
		var mon = f10(year / 12);
		// 간이세액표: 월 1,000만원 초과는 '1,000만원일 때 세액 + 초과분 가산' 식(소득세법 시행령 별표2)
		if (tx > 1e7 && !hi) {
			var t10 = net(1e7, 0, fam, 0, r, true).mon, o = tx;
			mon = o <= 14e6 ? t10 + (o - 1e7) * 0.98 * 0.35 + 25000 : o <= 28e6 ? t10 + 1397000 + (o - 14e6) * 0.98 * 0.38 : o <= 3e7 ? t10 + 6610600 + (o - 28e6) * 0.98 * 0.4 : o <= 45e6 ? t10 + 7394600 + (o - 3e7) * 0.4 : o <= 87e6 ? t10 + 13394600 + (o - 45e6) * 0.42 : t10 + 31034600 + (o - 87e6) * 0.45;
			mon = f10(mon);
		}
		var inc = Math.max(0, mon - kd);
		inc = inc < 1000 ? 0 : f10(inc);
		var loc = f10(inc * 0.1), ded = pen + hea + care + emp + inc + loc;
		return { mon: mon, gross: gross, tx: tx, pen: pen, hea: hea, care: care, emp: emp, inc: inc, loc: loc, ded: ded, net: gross - ded, T: T, wd: wd, sp: sp, tb: tb, calc: calc, cr: Math.min(cr, lim), year: year, kd: kd };
	}
	function calc(root, S) {
		var f = root.querySelector('form'), r = S.rates, yr = Q.seg(root, 'm') !== 'mo', a = Q.num(f.a.value);
		if (!a) { return { err: (yr ? '세전 연봉' : '세전 월급') + '을 넣어 주세요.' }; }
		var gross = yr ? a / 12 : a, nt = Math.min(Q.num(f.t.value), gross), fam = Math.max(1, Math.min(11, Q.num(f.fm.value) || 1)), kids = Math.min(fam - 1, Q.num(f.kd.value));
		var x = net(gross, nt, fam, kids, r), pct = function (v) { return Math.round(v / x.gross * 1000) / 10; };
		var h = '<div class="eb-qa__tot"><small>한 달 실수령액 (예상)</small><b>' + Q.won(x.net) + '</b><small>연 약 ' + Q.kr(Math.round(x.net * 12 / 1e4) * 1e4) + ' · 세전의 ' + pct(x.net) + '%</small></div>'
			+ '<div class="eb-qa__bar is-big" aria-hidden="true"><i class="k1" style="width:' + pct(x.net) + '%"></i><i class="k2" style="width:' + pct(x.pen + x.hea + x.care + x.emp) + '%"></i><i class="k3" style="width:' + pct(x.inc + x.loc) + '%"></i></div>'
			+ '<p class="eb-qa__lg"><span><i class="k1"></i>받는 돈</span><span><i class="k2"></i>4대보험 ' + Q.man(x.pen + x.hea + x.care + x.emp) + '</span><span><i class="k3"></i>세금 ' + Q.man(x.inc + x.loc) + '</span></p>'
			+ '<ul class="eb-qa__rows">'
			+ Q.row('국민연금', r.pension_rate + '% · 기준소득월액 상·하한 적용', x.pen, true)
			+ Q.row('건강보험', r.health_rate + '%', x.hea, true)
			+ Q.row('장기요양보험', '건강보험료의 ' + (Math.round(r.care_total / r.health_total * 10000) / 100) + '%', x.care, true)
			+ Q.row('고용보험', r.employ_rate + '%', x.emp, true)
			+ Q.row('소득세', '간이세액표 산식 · 가족 ' + fam + '명' + (kids ? ' · 자녀 ' + kids + '명' : ''), x.inc, true, x.inc ? Q.won(x.inc) : '0원')
			+ Q.row('지방소득세', '소득세의 10%', x.loc, true, x.loc ? Q.won(x.loc) : '0원') + '</ul>';
		// 연봉별 실수령액: 지금 금액 기준 ±1,000만원(월급이면 ±100만원)
		var step = yr ? 5e6 : 5e5, list = [];
		for (var s = -2; s <= 2; s++) {
			var v = a + s * step;
			if (v <= 0) { continue; }
			var y = net(yr ? v / 12 : v, Math.min(nt, yr ? v / 12 : v), fam, kids, r);
			list.push('<tr' + (s ? '' : ' class="is-on"') + '><td>' + (yr ? '연봉 ' : '월급 ') + Q.kr(v) + '</td><td>' + Q.won(y.net) + '</td><td>' + Q.won(y.ded) + '</td></tr>');
		}
		h += '<p class="eb-qa__h">' + (yr ? '연봉' : '월급') + '이 바뀌면</p><table class="eb-qa__cmp"><thead><tr><th>' + (yr ? '연봉' : '월급') + '</th><th>월 실수령</th><th>월 공제</th></tr></thead><tbody>' + list.join('') + '</tbody></table>';
		h += Q.how([
			'월 과세 급여 = ' + Q.won(x.gross) + ' − 비과세 ' + Q.won(nt) + ' = <b>' + Q.won(x.tx) + '</b> (연 ' + Q.won(x.T) + ')',
			'근로소득공제 ' + Q.won(x.wd) + ', 기본공제 150만원 × ' + fam + '명, 연금보험료공제 ' + Q.won(x.pen * 12) + ', 특별소득공제 등(간이세액표 산식) ' + Q.won(x.sp),
			'과세표준 ' + Q.won(x.tb) + ' → 산출세액 ' + Q.won(x.calc) + ' − 근로소득세액공제 ' + Q.won(x.cr) + ' = 연 ' + Q.won(x.year),
			'월 소득세 = ' + (x.tx > 1e7 ? '월 1,000만원 초과 가산식으로 ' + Q.won(x.mon) : Q.won(x.year) + ' ÷ 12') + (x.kd ? ' − 자녀 ' + Q.won(x.kd) : '') + ' = <b>' + Q.won(x.inc) + '</b>, 지방소득세 <b>' + Q.won(x.loc) + '</b>',
			'4대보험은 ' + r.year + '년 요율, 10원 미만 버림'
		]) + '<p class="eb-qa__note">국세청 간이세액표를 만드는 산식으로 계산한 근사치라 실제 월급명세서와 몇백 원~몇천 원 다를 수 있어요. 연말정산 결과(환급·추가 납부)는 따로예요.</p>';
		return h;
	}
	root.addEventListener('qa:seg', function (e) {
		if (e.detail !== 'm') { return; }
		var mo = Q.seg(root, 'm') === 'mo', l = root.querySelector('[name="a"]').closest('label').querySelector('.eb-qa__l');
		l.firstChild.nodeValue = mo ? '세전 월급 ' : '세전 연봉 ';
		root.querySelector('[name="a"]').placeholder = mo ? '예: 3,500,000' : '예: 40,000,000';
	});
	Q.setup(root, calc, ['m', 'a', 't', 'fm', 'kd']);
})();
JS
		. "\n</script>";
} );

// 폐업 한 번에 기준값(2026). 바뀌면 여기만
function eb_close_rates() {
	return array(
		'demo'      => array( 200000, 6000000 ),   // 점포철거비: 3.3㎡(1평)당, 최대 (2025.7.11 이후 폐업, 실비)
		'job'       => 1000000,                    // 전직장려수당 최대
		'grade'     => array( 1820000, 2080000, 2340000, 2600000, 2860000, 3120000, 3380000 ), // 자영업자 고용보험 기준보수 1~7등급(월)
		'days'      => array( 120, 150, 180, 210 ),// 가입 1~3년·3~5년·5~10년·10년 이상
		'rate'      => 60,                         // 기준보수 대비 %
		'yellow'    => 3.3,                        // 노란우산 폐업공제금 기준이율(연, 분기마다 바뀜) - 고칠 수 있음
	);
}

add_shortcode( 'eb_close', function () {
	$c   = eb_close_rates();
	$set = array( 'url' => home_url( '/calculator/closing-all/' ), 'c' => $c );
	$gr  = '';
	foreach ( $c['grade'] as $i => $g ) {
		$gr .= '<option value="' . $i . '"' . ( 0 === $i ? ' selected' : '' ) . '>' . ( $i + 1 ) . '등급 · ' . number_format_i18n( $g / 10000 ) . '만</option>';
	}
	$h = '<div class="eb-qa" data-calc="close" data-qa="' . esc_attr( wp_json_encode( $set ) ) . '"><form class="eb-qa__form" novalidate>'
		. '<div class="eb-qa__g2"><label class="eb-qa__f"><span class="eb-qa__l">폐업(예정)일</span><input type="date" name="d"></label>' . eb_qa_in( 'p', '점포 전용면적', '평', '15', '철거할 때' ) . '</div>'
		. eb_qa_seg( 'x', '점포를 철거하나요?', array( 'y' => '철거해요', 'n' => '안 해요' ), 'y' )
		. eb_qa_seg( 'nx', '폐업 뒤에는', array( 'job' => '취업할래요', 'biz' => '다시 창업', 'no' => '아직 몰라요' ), 'job', ' is-3' )
		. eb_qa_seg( 'y', '노란우산공제', array( 'y' => '가입했어요', 'n' => '안 했어요' ), 'y' )
		. '<div class="eb-qa__g2" data-show="y">' . eb_qa_in( 'ym', '월 납입액', '원', '250,000', '', '', true ) . eb_qa_in( 'yn', '낸 기간', '개월', '60' ) . '</div>'
		. eb_qa_seg( 'e', '자영업자 고용보험', array( 'y' => '가입했어요', 'n' => '안 했어요' ), 'n' )
		. '<div data-show="e" hidden><div class="eb-qa__g2"><label class="eb-qa__f"><span class="eb-qa__l">가입 기간</span><select name="ep"><option value="-1">1년 미만</option><option value="0" selected>1년 ~ 3년 미만</option><option value="1">3년 ~ 5년 미만</option><option value="2">5년 ~ 10년 미만</option><option value="3">10년 이상</option></select></label>'
		. '<label class="eb-qa__f"><span class="eb-qa__l">기준보수 등급</span><select name="eg">' . $gr . '</select></label></div>'
		. eb_qa_seg( 'er', '폐업 이유', array( 'loss' => '적자·매출 감소 등', 'etc' => '그 밖의 이유' ), 'loss' ) . '</div>'
		. '<details class="eb-qa__more"><summary>자세히 고치기 <small>노란우산 이율</small></summary><div class="eb-qa__morein">' . eb_qa_in( 'yr', '노란우산 폐업공제금 이율 (연)', '%', (string) $c['yellow'], '분기마다 바뀌어요', (string) $c['yellow'] ) . '</div></details>'
		. '<p class="eb-qa__err" data-qa-err role="alert" hidden></p><button type="submit" class="eb-qa__go">한 번에 계산하기</button></form>'
		. '<div class="eb-qa__res" data-qa-res aria-live="polite" hidden></div>'
		. eb_qa_solo( array( '/guide/closing-business/' => '가게 폐업 가이드', '/calculator/social-insurance/' => '4대보험', '/calculator/savings-interest/' => '적금 이자' ) ) . '</div>' . eb_qa_embed_box( 'close' );
	return $h . "<script nowprocket>\n" . eb_qa_lib_js() . "\n" . <<<'JS'
(function () {
	var Q = window.ebQa, root = document.querySelector('[data-calc="close"]');
	if (!root) { return; }
	function show() {
		root.querySelector('[data-show="y"]').hidden = Q.seg(root, 'y') !== 'y';
		root.querySelector('[data-show="e"]').hidden = Q.seg(root, 'e') !== 'y';
	}
	root.addEventListener('qa:seg', show);
	function calc(root, S) {
		var f = root.querySelector('form'), C = S.c, d = Q.day(f.d.value);
		if (d === null) { return { err: '폐업(예정)일을 넣어 주세요.' }; }
		var py = Q.num(f.p.value), demoOn = Q.seg(root, 'x') === 'y', nx = Q.seg(root, 'nx');
		var demo = demoOn && py ? Math.min(py * C.demo[0], C.demo[1]) : 0;
		var job = nx === 'job' ? C.job : 0;
		var yOn = Q.seg(root, 'y') === 'y', ym = Q.num(f.ym.value), yn = Math.min(600, Q.num(f.yn.value)), rate = parseFloat(String(f.yr.value).replace(/[^0-9.]/g, '')) || C.yellow;
		var paid = ym * yn, fv = 0, i;
		for (i = 0; i < yn; i++) { fv += ym * Math.pow(1 + rate / 100 / 12, yn - i); }
		var yel = yOn && ym && yn ? Math.floor(fv) : 0;
		var eOn = Q.seg(root, 'e') === 'y', ep = +f.ep.value, eg = +f.eg.value, er = Q.seg(root, 'er');
		var daily = Math.floor(C.grade[eg] * C.rate / 100 / 30), days = ep >= 0 ? C.days[ep] : 0, uOk = eOn && ep >= 0 && er === 'loss', unemp = uOk ? daily * days : 0, uSub;
		if (!eOn) { uSub = '자영업자 고용보험에 1년 이상 가입한 경우만'; } else if (ep < 0) { uSub = '가입 1년 이상이어야 해요'; } else if (er !== 'loss') { uSub = '적자·매출 감소 같은 사유가 인정돼야 해요'; } else { uSub = '하루 ' + Q.won(daily) + ' × ' + days + '일 (기준보수 ' + (eg + 1) + '등급의 ' + C.rate + '%)'; }
		var tot = demo + job + yel + unemp, cnt = (demo > 0) + (job > 0) + (yel > 0) + (unemp > 0);
		var h = '<div class="eb-qa__tot"><small>폐업할 때 받을 수 있는 돈 (예상)</small><b>' + (tot >= 1e4 ? '약 ' + Q.kr(Math.round(tot / 1e4) * 1e4) : Q.won(tot)) + '</b><small>4가지 중 ' + cnt + '가지 해당' + (yel ? ' · 노란우산은 내가 모은 돈' : '') + '</small></div><ul class="eb-qa__rows">'
			+ Q.row('점포 철거비', demoOn ? (py ? py + '평 × ' + Q.man(C.demo[0]) + ' (최대 ' + Q.man(C.demo[1]) + ', 실제 공사비만큼)' : '전용면적을 넣으면 계산해요') : '철거하지 않으면 없어요', demo, demo > 0)
			+ Q.row('전직장려수당', nx === 'job' ? '교육 수료·취업하면 단계별로 최대' : nx === 'biz' ? '다시 창업하면 재기사업화 지원(최대 2,000만원, 심사)을 보세요' : '취업을 고르면 받을 수 있어요', job, job > 0)
			+ Q.row('노란우산 폐업공제금', yOn ? (ym && yn ? '낸 돈 ' + Q.man(paid) + ' + 이자 약 ' + Q.man(Math.max(0, yel - paid)) + ' (연 ' + rate + '% 복리 가정)' : '월 납입액과 기간을 넣어 주세요') : '가입하지 않았어요', yel, yel > 0)
			+ Q.row('자영업자 실업급여', uSub, unemp, unemp > 0) + '</ul>';
		var nm = new Date(d), vat = Date.UTC(nm.getUTCFullYear(), nm.getUTCMonth() + 1, 25), list = [];
		if (demo) { list.push(['철거 전', '소상공인24에서 희망리턴패키지 점포철거 신청 (철거한 뒤엔 못 받아요)']); }
		list.push([Q.md(d), '홈택스에서 폐업 신고']);
		list.push([Q.md(vat), '부가가치세 폐업 확정신고 마감 (폐업한 달의 다음 달 25일)']);
		if (yel) { list.push(['폐업 신고 뒤', '노란우산 누리집·지점에서 폐업공제금 청구']); }
		if (uOk) { list.push([Q.ymd(Q.addMonths(d + Q.DAY, 12) - Q.DAY), '자영업자 실업급여 받을 수 있는 마지막 날 (폐업 다음 날부터 1년) — 고용센터에 빨리 신청']); }
		if (job) { list.push(['폐업 뒤', '희망리턴패키지 취업 교육 신청 → 수료·취업하면 전직장려수당']); }
		h += Q.todo(list) + Q.how([
			'점포 철거비 = 전용면적 ' + py + '평 × ' + Q.won(C.demo[0]) + ' = ' + Q.won(py * C.demo[0]) + ' → 최대 ' + Q.won(C.demo[1]) + ' 안에서 실제 공사비만큼',
			'노란우산 = 월 ' + Q.won(ym) + ' × ' + yn + '개월(낸 돈 ' + Q.won(paid) + ')에 연 ' + rate + '% 월복리로 어림 = <b>' + Q.won(yel) + '</b>',
			'자영업자 실업급여 하루 = 기준보수 ' + Q.won(C.grade[eg]) + ' × ' + C.rate + '% ÷ 30일 = ' + Q.won(daily) + ', 받는 일수 ' + (days || 0) + '일'
		]) + '<p class="eb-qa__note">희망리턴패키지는 예산이 떨어지면 일찍 마감돼요. 노란우산 공제금에는 퇴직소득세가 붙을 수 있고, 실제 이율·금액은 노란우산 누리집(1666-9988)에서 확인하세요.</p>';
		return h;
	}
	Q.setup(root, calc, ['d', 'p', 'x', 'nx', 'y', 'ym', 'yn', 'e', 'ep', 'eg', 'er', 'yr']);
	show();
})();
JS
		. "\n</script>";
} );

/* 74. 계산기 모음 [eb_calc_hub] (페이지 /calculator/ 14866, 2026-10-17 시안, css/90-tools.css '계산기 모음') ------------------------------
 * 상황 아이콘 타일로 거르기 · '한 번에' 계산기 4칸 · 묶음별 한 줄 목록(#welfare #quit #work #finance #biz). '최근 바뀐 기준'·'이번 달 많이 쓴 계산기'는 운영자 요청으로 뺌(2026-10-17)
 * 목록은 eb_calc_catalog()(13-1)에서 이름·설명, 묶음·상황은 eb_calc_hub_meta(). 새 계산기는 둘 다에 한 줄씩
 */
function eb_calc_hub_meta() {
	// 목록 키 => [ 묶음, 상황(공백으로 여러 개), '한 번에' 계산기면 1 ]
	return array(
		'quitall'  => array( 'quit', 'quit', 1 ),
		'baby'     => array( 'finance', 'kid', 1 ),
		'pay'      => array( 'work', 'pay', 1 ),
		'closing'  => array( 'biz', 'biz', 1 ),
		'median'   => array( 'welfare', 'parent', 0 ),
		'pension'  => array( 'welfare', 'parent', 0 ),
		'eitc'     => array( 'welfare', 'kid pay', 0 ),
		'age'      => array( 'welfare', 'parent', 0 ),
		'severance'=> array( 'quit', 'quit', 0 ),
		'unemployment' => array( 'quit', 'quit', 0 ),
		'notice'   => array( 'quit', 'quit', 0 ),
		'leavepay' => array( 'quit', 'quit pay', 0 ),
		'minwage'  => array( 'work', 'pay', 0 ),
		'weekly'   => array( 'work', 'pay', 0 ),
		'insurance'=> array( 'work', 'pay biz', 0 ),
		'leave'    => array( 'work', 'pay quit', 0 ),
		'maternity'=> array( 'finance', 'kid', 0 ),
		'parental' => array( 'finance', 'kid', 0 ),
		'saving'   => array( 'finance', 'biz', 0 ),
		'date'     => array( 'finance', 'quit', 0 ),
	);
}
add_shortcode( 'eb_calc_hub', function () {
	$cat    = eb_calc_catalog();
	$meta   = eb_calc_hub_meta();
	$groups = array( 'welfare' => '복지·수급', 'quit' => '퇴직·실업', 'work' => '월급·근로', 'finance' => '가족·생활', 'biz' => '가게·사업' );
	$sits   = array( 'quit' => '퇴사했어요', 'kid' => '아이가 생겼어요', 'pay' => '월급 확인', 'parent' => '부모님', 'biz' => '가게 정리' );
	$name   = function ( $c ) {
		return preg_replace( '/\s*(모의)?계산기$/u', '', $c[1] );
	};
	// 2026-10-17 시안: 알약 칩 → 질문 + 아이콘 타일(고른 칸 체크·개수, 휴대폰 3칸×2줄·PC 6칸 한 줄)
	$sic = array(
		''       => '<rect x="4" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="4" y="13.5" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="13.5" width="6.5" height="6.5" rx="1.5"/>',
		'quit'   => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8.5 7V5.5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2V7M3 13h18"/>',
		'kid'    => '<circle cx="12" cy="12" r="8.5"/><path d="M9.5 10.5h.01M14.5 10.5h.01M9.5 14.5a3.5 3.5 0 0 0 5 0"/>',
		'pay'    => '<path d="M19 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2"/><path d="M21 12h-5a2 2 0 0 0 0 4h5z"/>',
		'parent' => '<circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 20.5a6.5 6.5 0 0 1 13 0"/>',
		'biz'    => '<path d="M3.5 9 5 4h14l1.5 5M4.5 9v11h15V9M3.5 9h17"/><path d="M9.5 20v-5.5h5V20"/>',
	);
	$scnt = array( '' => 0 );
	foreach ( $meta as $k => $m ) {
		if ( isset( $cat[ $k ] ) ) {
			$scnt['']++;
			foreach ( explode( ' ', $m[1] ) as $s ) {
				$scnt[ $s ] = ( $scnt[ $s ] ?? 0 ) + 1;
			}
		}
	}
	$tile = function ( $k, $label ) use ( $sic, $scnt ) {
		return '<button type="button" data-s="' . $k . '" aria-pressed="' . ( '' === $k ? 'true' : 'false' ) . '"><i aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $sic[ $k ] . '</svg></i><span>' . esc_html( $label ) . '</span><small>' . (int) ( $scnt[ $k ] ?? 0 ) . '개</small></button>';
	};
	$h = '<div class="eb-hub" data-hub><div class="eb-hub__pick"><p class="eb-hub__q"><b>지금 어떤 상황이세요?</b><span>누르면 맞는 계산기만 보여 드려요</span></p><div class="eb-hub__chips" role="group" aria-label="지금 상황">' . $tile( '', '전체 보기' );
	foreach ( $sits as $k => $v ) {
		$h .= $tile( $k, $v );
	}
	$h   .= '</div><p class="eb-hub__res" aria-live="polite">전체 ' . (int) $scnt[''] . '개를 보고 있어요</p></div>';
	$big  = '';
	$list = array_fill_keys( array_keys( $groups ), '' );
	foreach ( $cat as $k => $c ) {
		if ( empty( $meta[ $k ] ) ) {
			continue;
		}
		$m    = $meta[ $k ];
		$url  = home_url( $c[0] );
		if ( $m[2] ) {
			$big .= '<a class="eb-hub__big" href="' . esc_url( $url ) . '" data-s="' . esc_attr( $m[1] ) . '">' . eb_tool_icon( $url ) . '<b>' . esc_html( $name( $c ) ) . '</b><small>' . esc_html( $c[2] ) . '</small></a>';
		}
		$list[ $m[0] ] .= '<a class="eb-hub__row" href="' . esc_url( $url ) . '" data-s="' . esc_attr( $m[1] ) . '">' . eb_tool_icon( $url ) . '<span><b>' . esc_html( $name( $c ) ) . '</b><small>' . esc_html( $c[2] ) . '</small></span></a>';
	}
	$h .= '<h2 id="all-in-one">입력 한 번에 다 계산</h2><div class="eb-hub__bigs">' . $big . '</div>';
	$h .= '<h2 id="hub-all">전체 계산기 <small>' . count( $cat ) . '개</small></h2><div class="eb-hub__groups">';
	foreach ( $groups as $k => $g ) {
		if ( $list[ $k ] ) {
			$h .= '<section class="eb-hub__grp" id="' . $k . '" aria-labelledby="hub-' . $k . '"><h3 id="hub-' . $k . '">' . esc_html( $g ) . '</h3><div class="eb-hub__list">' . $list[ $k ] . '</div></section>';
		}
	}
	$h .= '</div><p class="eb-hub__none" hidden>이 상황에 맞는 계산기가 없어요.</p></div>';
	$h .= "<script nowprocket>(function(){var r=document.querySelector('[data-hub]');if(!r){return;}var bs=r.querySelectorAll('.eb-hub__chips button');bs.forEach(function(b){b.addEventListener('click',function(){var s=b.getAttribute('data-s');bs.forEach(function(x){x.setAttribute('aria-pressed',x===b?'true':'false');});r.querySelectorAll('[data-s]:not(button)').forEach(function(a){a.hidden=!!s&&(' '+a.getAttribute('data-s')+' ').indexOf(' '+s+' ')<0;});r.querySelectorAll('.eb-hub__grp').forEach(function(g){g.hidden=!g.querySelector('.eb-hub__row:not([hidden])');});r.querySelector('.eb-hub__bigs').hidden=!r.querySelector('.eb-hub__big:not([hidden])');r.querySelector('#all-in-one').hidden=r.querySelector('.eb-hub__bigs').hidden;r.querySelector('.eb-hub__none').hidden=!!r.querySelector('.eb-hub__row:not([hidden])');var n=r.querySelectorAll('.eb-hub__row:not([hidden])').length,t=b.querySelector('span').textContent;r.querySelector('.eb-hub__res').textContent=s?'\''+t+'\'에 맞는 계산기 '+n+'개':'전체 '+n+'개를 보고 있어요';});});})();</script>";
	return $h;
} );

/* 75. PC 메가메뉴 4개 판 높이 맞추기 (2026-10-17, css/40-header.css 끝 --mx-h) ------------------------------------------
 * 처음 열 때 판 4개의 높이를 재서 가장 높은 값으로 --mx-h를 정함(창 크기가 바뀌면 다시 잼). 메뉴를 옮겨 다닐 때 아래 경계가 들쭉날쭉하지 않게
 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>(function(){var mx=document.querySelector('.mx');if(!mx){return;}var done=0;function fit(){var ps=[].slice.call(mx.querySelectorAll('.mx-pane'));if(!ps.length){return;}var was=ps.map(function(p){return p.hidden;}),wh=mx.hidden,h=0;mx.style.visibility='hidden';mx.hidden=false;mx.style.setProperty('--mx-h','0px');ps.forEach(function(p){ps.forEach(function(x){x.hidden=x!==p;});h=Math.max(h,p.offsetHeight);});ps.forEach(function(p,i){p.hidden=was[i];});mx.hidden=wh;mx.style.visibility='';if(h){mx.style.setProperty('--mx-h',h+'px');done=1;}}var nav=document.querySelector('.xh')||document;nav.addEventListener('mouseover',function(){if(!done){fit();}},{passive:true});nav.addEventListener('focusin',function(){if(!done){fit();}});window.addEventListener('resize',function(){done=0;});})();</script>";
}, 60 );

/* 75-2. 서랍형 전체 메뉴(600~1079px, css/60-mobile-bar.css 끝): 서랍 바깥(어둡게 비친 곳)을 누르면 닫힘. 뒤 페이지 링크가 눌리지 않게 막음 */
add_action( 'wp_footer', function () {
	echo "<script nowprocket>(function(){var mq=window.matchMedia('(min-width: 600px) and (max-width: 1079px)');function out(e){if(!mq.matches){return null;}var m=document.querySelector('.ebm:not([hidden])'),s=document.querySelector('.ebsr:not([hidden])'),o=s||m;if(!o||o.contains(e.target)){return null;}return o;}document.addEventListener('click',function(e){var o=out(e);if(!o){return;}e.preventDefault();e.stopPropagation();var b=o.classList.contains('ebsr')?o.querySelector('.ebsr__back'):o.querySelector('.ebm__x');if(b){b.click();}},true);})();</script>";
}, 61 );

/* 76. 자주 묻는 질문 모음 eb_faq_data() + /faq/ 페이지 [eb_faq] (2026-10-17, css/90-tools.css 끝 '자주 묻는 질문 페이지') ------------------
 * 질문은 여기 한 곳에만. 70번 복지용구(equip)·71번 협업(partner) FAQ도 여기서 가져다 씀 → 한 번 고치면 두 곳 다 바뀜
 * 답은 HTML 허용(wp_kses_post). 묶음 => [ 이름, 아이콘 SVG, [ [ 질문, 답 ], ... ] ]
 * /faq/: 검색 · 묶음 아이콘 타일(계산기 모음과 같은 모양) · 묶음별 Q/A(eb_faq_item) · 주소 #faq-묶음-번호로 바로 펼침 · FAQPage 구조화 데이터
 */
function eb_faq_data() {
	return array(
		'site'    => array( '사이트 이용', '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>', array(
			array( '이지복지닷컴은 정부 사이트인가요?', '아니요. 개인이 운영하는 정보 사이트예요. 정부·공공기관 공고와 법령을 기준으로 정리하지만, 실제 지원 대상과 금액은 각 기관의 최신 공고와 심사로 정해져요.' ),
			array( '회원가입을 해야 하나요?', '아니요. 회원가입 없이 모든 기능을 쓸 수 있어요. 저장한 글·최근 본 글은 지금 쓰는 기기의 브라우저에만 보관돼서 다른 기기에서는 보이지 않아요.' ),
			array( '제도가 바뀌면 언제 고쳐지나요?', '제도가 바뀌면 내용을 고치고 글 위에 최종 수정일을 표시해요. 계산기는 페이지 아래에 기준 연도와 확인한 날짜를 적어 두었어요.' ),
			array( '틀린 내용을 발견했어요.', '<a href="/contact/">문의하기</a>에서 \'오류 제보\'를 골라 알려 주세요. 공식 자료를 다시 확인해 고칠게요.' ),
			array( '맞춤 혜택 찾기의 정부 서비스 목록은 어디서 가져오나요?', '공공데이터포털의 한국사회보장정보원 복지서비스 정보를 그대로 보여 드려요. 신청하기 전에는 각 기관 공고를 꼭 확인해 주세요.' ),
		) ),
		'calc'    => array( '계산기', '<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8.5 7h7M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01M8.5 15h.01M12 15h.01M15.5 15h.01"/>', array(
			array( '계산기에 넣은 값이 저장되나요?', '아니요. 계산은 지금 보고 있는 화면 안에서만 하고 서버로 보내지 않아요. \'결과 공유\'를 누를 때만 입력값이 공유 주소에 붙어요.' ),
			array( '계산 결과만큼 받을 수 있나요?', '공식 기준으로 계산한 예상 금액이에요. 실제 금액은 회사 자료와 기관 판단에 따라 달라질 수 있으니 신청 전에 담당 기관에 확인해 주세요.' ),
			array( '여러 가지를 한 번에 계산할 수 있나요?', '네. <a href="/calculator/#all-in-one">입력 한 번에 다 계산</a>에서 퇴사·출산·육아·연봉 실수령액·폐업 계산기를 쓰면 관련 금액을 한 번에 보여 드려요.' ),
			array( '계산기를 내 블로그에 넣을 수 있나요?', '\'한 번에\' 계산기 4개 아래 \'내 블로그에 이 계산기 넣기\'에서 코드를 복사하면 돼요. 무료이고, 출처 링크만 지우지 말아 주세요.' ),
			array( '기준 금액은 언제 바뀌나요?', '최저임금·기준 중위소득·기초연금 같은 기준은 대부분 매년 1월 1일에 바뀌어요. 올해 금액은 <a href="/standards/">2026 기준표</a>에 모아 두었어요.' ),
		) ),
		'sched'   => array( '일정·알림', '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a1.94 1.94 0 0 0 3.4 0"/>', array(
			array( '마감 알림은 어떻게 받나요?', '<a href="/schedule/">복지 캘린더</a>에서 일정 옆 종 버튼을 누르고 알림을 허용하면, 그 일정의 시작일·마감 3일 전·마감일 아침 9시에 알려 드려요.' ),
			array( '알림이 오지 않아요.', '카카오톡·네이버 앱 안에서 연 화면은 알림을 막아요. 크롬·사파리 같은 브라우저로 다시 열어 종 버튼을 눌러 주세요. 기기 설정에서 브라우저 알림이 꺼져 있어도 오지 않아요.' ),
			array( '알림을 끄려면 어떻게 하나요?', '복지 캘린더나 <a href="/saved/">저장한 글</a>의 \'알림 켠 일정\'에서 종 버튼을 다시 누르면 꺼져요.' ),
			array( '지급일이 주말이면 언제 들어오나요?', '보통 그 전 평일에 들어와요. 복지 캘린더의 지급일은 주말·공휴일을 반영한 날짜예요.' ),
		) ),
		'equip'   => array( '어르신 복지용구', '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>', array(
			array( '인터넷이나 쿠팡에서 산 것도 지원되나요?', '아니요. 장기요양기관으로 지정된 복지용구 사업소에서 사거나 빌려야 지원돼요. 직접 산 물건값은 돌려받을 수 없어요.' ),
			array( '1년 한도는 언제 다시 채워지나요?', '처음 장기요양 등급을 받은 날(유효기간 시작일)부터 1년마다 새로 160만원이 생겨요. 등급이 끊긴 뒤 1년 넘게 지나 다시 받았다면 새 유효기간 시작일부터 세요.' ),
			array( '남은 한도는 어디서 확인하나요?', '이용하는 복지용구 사업소나 국민건강보험공단(1577-1000)에 물어보면 알려 줘요.' ),
			array( '요양원에 들어가면 어떻게 되나요?', '노인요양시설에 들어가 계신 동안에는 복지용구 급여를 쓸 수 없어요.' ),
			array( '인지지원등급도 받을 수 있나요?', '네. 1~5등급과 같이 인지지원등급도 복지용구를 쓸 수 있어요.' ),
		) ),
		'partner' => array( '협업·광고', '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M21.5 20a6.5 6.5 0 0 0-4-6"/>', array(
			array( '방문 통계를 받아 볼 수 있나요?', '네. 제안서를 보내 주시면 최근 방문 수와 많이 읽힌 주제를 회신 때 함께 보내 드려요.' ),
			array( '공공기관 홍보도 비용이 드나요?', '공익 목적의 정책·지원사업 안내는 비용 없이 싣는 것을 먼저 검토해요. 별도 제작이 필요한 경우만 협의해요.' ),
			array( '계산기를 우리 사이트에 붙일 수 있나요?', '네. <a href="/calculator/quit-all/#qa-embed">퇴사 한 번에 계산기</a> 등 \'한 번에\' 계산기 아래 \'내 블로그에 이 계산기 넣기\'에서 코드를 바로 복사할 수 있어요(출처 링크 유지 조건). 필요한 항목을 넣은 맞춤 계산기는 제안서로 알려 주세요.' ),
			array( '글 수정이나 게시 중단도 요청할 수 있나요?', '제도 변경에 따른 수정은 언제든 반영해요. 광고 글은 협의한 기간이 끝나면 광고 표시와 함께 정리해요.' ),
			array( '광고·협찬 글은 어떻게 표시하나요?', '공정거래위원회 지침대로 글 첫머리에 \'광고\'를 밝혀요. 제휴 링크(쿠팡 파트너스 등)가 있는 글도 같은 방식으로 알려요.' ),
		) ),
	);
}

add_shortcode( 'eb_faq', function () {
	$all   = eb_faq_data();
	$total = 0;
	foreach ( $all as $g ) {
		$total += count( $g[2] );
	}
	$svg  = function ( $d ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $d . '</svg>';
	};
	$tile = function ( $k, $label, $icon, $n ) use ( $svg ) {
		return '<button type="button" data-s="' . esc_attr( $k ) . '" aria-pressed="' . ( '' === $k ? 'true' : 'false' ) . '"><i aria-hidden="true">' . $svg( $icon ) . '</i><span>' . esc_html( $label ) . '</span><small>' . (int) $n . '개</small></button>';
	};
	$h = '<div class="eb-faq" data-faq><label class="eb-faq__s"><span class="screen-reader-text">질문 검색</span>' . $svg( '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>' ) . '<input type="search" placeholder="궁금한 내용 검색 (예: 알림)" autocomplete="off"></label>'
		. '<div class="eb-hub eb-faq__pick"><div class="eb-hub__chips" role="group" aria-label="질문 묶음">' . $tile( '', '전체', '<rect x="4" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="4" width="6.5" height="6.5" rx="1.5"/><rect x="4" y="13.5" width="6.5" height="6.5" rx="1.5"/><rect x="13.5" y="13.5" width="6.5" height="6.5" rx="1.5"/>', $total );
	foreach ( $all as $k => $g ) {
		$h .= $tile( $k, $g[0], $g[1], count( $g[2] ) );
	}
	$h  .= '</div></div><p class="eb-faq__res" aria-live="polite">질문 ' . $total . '개</p>';
	$ld  = array();
	foreach ( $all as $k => $g ) {
		$h .= '<section class="eb-faq__grp" data-g="' . esc_attr( $k ) . '" aria-labelledby="faq-' . esc_attr( $k ) . '"><h2 id="faq-' . esc_attr( $k ) . '">' . esc_html( $g[0] ) . '</h2><div class="eb-pt__faq">';
		foreach ( $g[2] as $i => $qa ) {
			$h   .= str_replace( '<details', '<details id="faq-' . esc_attr( $k ) . '-' . ( $i + 1 ) . '"', eb_faq_item( $qa[0], wp_kses_post( $qa[1] ) ) );
			$ld[] = array( '@type' => 'Question', 'name' => $qa[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $qa[1] ) ) );
		}
		$h .= '</div></section>';
	}
	$h .= '<p class="eb-faq__none" hidden>찾는 질문이 없어요. <a href="/contact/">문의하기</a>로 물어봐 주세요.</p></div>';
	$h .= '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $ld ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
	$h .= "<script nowprocket>\n" . <<<'JS'
(function () {
	var r = document.querySelector('[data-faq]');
	if (!r) { return; }
	var q = r.querySelector('input'), tiles = r.querySelectorAll('.eb-hub__chips button'), res = r.querySelector('.eb-faq__res'), none = r.querySelector('.eb-faq__none'), g = '';
	function norm(s) { return String(s).toLowerCase().replace(/\s+/g, ''); }
	function run() {
		var t = norm(q.value), n = 0;
		r.querySelectorAll('.eb-faq__grp').forEach(function (sec) {
			var on = !g || sec.getAttribute('data-g') === g, m = 0;
			sec.querySelectorAll('details').forEach(function (d) {
				var hit = on && (!t || norm(d.textContent).indexOf(t) >= 0);
				d.hidden = !hit;
				if (hit) { m++; }
				if (t && hit) { d.open = true; }
			});
			sec.hidden = !m;
			n += m;
		});
		none.hidden = !!n;
		res.textContent = (t ? '\'' + q.value.trim() + '\' 검색 결과 ' : (g ? r.querySelector('[data-s="' + g + '"] span').textContent + ' ' : '질문 ')) + n + '개';
	}
	tiles.forEach(function (b) {
		b.addEventListener('click', function () {
			g = b.getAttribute('data-s');
			tiles.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			run();
		});
	});
	q.addEventListener('input', run);
	// 주소 #faq-묶음-번호로 들어오면 그 질문을 펼쳐서 보여 줌
	var h = location.hash && document.getElementById(location.hash.slice(1));
	if (h && h.tagName === 'DETAILS') { h.open = true; setTimeout(function () { h.scrollIntoView({ block: 'center' }); }, 300); }
})();
JS
		. "\n</script>";
	return $h;
} );

/* 77. 사이트 공지 한 줄 (2026-10-17 시안, 설정 > 사이트 공지, css/40-header.css 끝 '공지 한 줄') -----------------------------------------
 * PC(1080px 이상): 헤더 위 30px 줄 '새 소식 · 날짜 · 문구 · 보러 가기 · 닫기'. 자동 마감 공지는 '마감 임박 · D-14 · 이름 · 10.31(토)까지 · 신청 일정'(2026-10-18 A안). 닫으면 이 공지(문구·링크로 만든 꼬리표)가 바뀔 때까지 안 보임(이 브라우저에만 저장)
 * 휴대폰·태블릿: 화면 위엔 안 띄우고 전체 메뉴(68번) 맨 위에 한 줄. 문구를 비우면 둘 다 사라짐. 저장하면 WP Rocket 캐시를 비움
 */
function eb_notice() {
	$n = get_option( 'eb_notice', array() );
	// tg 꼬리표 · dd D-day 배지 · lv 배지 색(w 주황 D-7 이하, r 빨강 D-3 이하) · w 날짜 꼬리말 - 자동 마감 공지만 씀 (2026-10-18 A안)
	$def = array( 'd' => '', 't' => '', 'u' => '', 'a' => '1', 'tg' => '새 소식', 'dd' => '', 'lv' => '', 'w' => '' );
	$n   = is_array( $n ) ? wp_parse_args( $n, $def ) : $def;
	// 문구를 비워 두면(자동 켬일 때) 복지 캘린더에서 가장 가까운 신청·마감 일정을 띄움(2026-10-17)
	if ( '' === trim( $n['t'] ) && '1' === (string) $n['a'] && function_exists( 'eb_x_dues' ) ) {
		$x = eb_x_dues( 1 );
		if ( $x ) {
			$x     = $x[0];
			$today = current_datetime()->setTime( 0, 0 );
			$end   = $x['e'] ? date_create_immutable( $x['e'], wp_timezone() ) : null;
			$left  = $end ? (int) $today->diff( $end )->format( '%r%a' ) : -1;
			// 2026-10-18 A안: '마감 임박' + D-14 + 이름 · 10.31(토)까지 (예전 '새 소식 10.31 마감 … 14일 남았어요'는 꼬리표와 내용이 안 맞고 날짜가 두 번 나와서)
			if ( $x['open'] && $end ) {
				$n['tg'] = '마감 임박';
				$n['dd'] = 0 === $left ? '오늘 마감' : 'D-' . $left;
				$n['lv'] = $left <= 3 ? 'r' : ( $left <= 7 ? 'w' : '' );
				$n['t']  = $x['n'];
				$n['w']  = 0 === $left ? '오늘까지' : $x['el'] . '까지';
				$n['u']  = home_url( '/schedule/#d-' . $x['e'] );
			} elseif ( ! $x['open'] && $x['s'] ) {
				$st      = date_create_immutable( $x['s'], wp_timezone() );
				$n['tg'] = '곧 시작';
				$n['dd'] = 'D-' . (int) $today->diff( $st )->format( '%r%a' );
				$n['t']  = $x['n'];
				$n['w']  = $x['sl'] . ' 시작';
				$n['u']  = home_url( '/schedule/#d-' . $x['s'] );
			}
		}
	}
	if ( '' === trim( $n['t'] ) ) {
		return null;
	}
	$n['k'] = substr( md5( $n['d'] . '|' . $n['t'] . '|' . $n['u'] . '|' . $n['w'] ), 0, 10 );
	return $n;
}
add_action( 'admin_init', function () {
	register_setting( 'eb_notice', 'eb_notice', array(
		'sanitize_callback' => function ( $v ) {
			$v = is_array( $v ) ? $v : array();
			return array(
				'd' => mb_substr( sanitize_text_field( $v['d'] ?? '' ), 0, 10 ),
				't' => mb_substr( sanitize_text_field( $v['t'] ?? '' ), 0, 60 ),
				'u' => esc_url_raw( $v['u'] ?? '' ),
				'a' => empty( $v['a'] ) ? '0' : '1',
			);
		},
	) );
} );
add_action( 'update_option_eb_notice', function () {
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
} );
add_action( 'admin_menu', function () {
	add_options_page( '사이트 공지', '사이트 공지', 'manage_options', 'eb-notice', function () {
		$n = get_option( 'eb_notice', array() );
		$n = is_array( $n ) ? $n : array();
		echo '<div class="wrap"><h1>사이트 공지 한 줄</h1><p>PC는 헤더 위 얇은 줄, 휴대폰은 전체 메뉴 맨 위에 보여요. 문구를 비우면 자동 공지(아래)가 나오고, 자동도 끄면 사라져요. 문구나 링크를 바꾸면 전에 닫았던 사람에게도 다시 보여요.</p><form method="post" action="options.php">';
		settings_fields( 'eb_notice' );
		echo '<table class="form-table"><tr><th><label for="eb-n-d">날짜</label></th><td><input id="eb-n-d" name="eb_notice[d]" value="' . esc_attr( $n['d'] ?? '' ) . '" class="small-text" placeholder="10.17"> <span class="description">예: 10.17 (비워도 돼요)</span></td></tr>'
			. '<tr><th><label for="eb-n-t">문구</label></th><td><input id="eb-n-t" name="eb_notice[t]" value="' . esc_attr( $n['t'] ?? '' ) . '" class="large-text" maxlength="60"><p class="description">60자 이내. 휴대폰 메뉴에서는 두 줄까지 보여요.</p></td></tr>'
			. '<tr><th><label for="eb-n-u">링크</label></th><td><input id="eb-n-u" name="eb_notice[u]" value="' . esc_attr( $n['u'] ?? '' ) . '" class="regular-text" placeholder="/calculator/"></td></tr>'
			. '<tr><th>자동 공지</th><td><label><input type="checkbox" name="eb_notice[a]" value="1"' . checked( '0' !== (string) ( $n['a'] ?? '1' ), true, false ) . '> 문구를 비워 두면 복지 캘린더에서 가장 가까운 신청·마감 일정을 띄워요</label><p class="description">예: [마감 임박] D-14 청소년 미혼 한부모 자립지원 · 10.31(토)까지 — 하루마다 바뀌고, D-7부터 주황·D-3부터 빨강</p></td></tr></table>';
		submit_button( '저장' );
		echo '</form></div>';
	} );
} );
// PC 줄: <body> 바로 뒤. 닫은 공지면 그리기 전에 지움(깜빡임 없게 바로 뒤 스크립트)
add_action( 'wp_body_open', function () {
	$n = eb_notice();
	if ( ! $n || is_admin() ) {
		return;
	}
	$u = $n['u'] ? esc_url( $n['u'] ) : '';
	$dl = '' !== $n['dd']; // 자동 마감 공지
	$ic = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>';
	echo '<div class="eb-nb' . ( $n['lv'] ? ' is-' . $n['lv'] : '' ) . '" id="eb-nb" data-k="' . esc_attr( $n['k'] ) . '" role="region" aria-label="' . esc_attr( $n['tg'] ) . '"><div class="eb-nb__in"><span class="eb-nb__tg">' . ( $dl ? $ic : '' ) . esc_html( $n['tg'] ) . '</span>' . ( $dl ? '<span class="eb-nb__dd">' . esc_html( $n['dd'] ) . '</span>' : '' )
		. '<span class="eb-nb__tx">' . ( $n['d'] ? '<b>' . esc_html( $n['d'] ) . '</b> ' : '' ) . ( $dl ? '<b>' . esc_html( $n['t'] ) . '</b>' : esc_html( $n['t'] ) ) . ( $n['w'] ? ' <span class="eb-nb__w">· ' . esc_html( $n['w'] ) . '</span>' : '' ) . '</span>'
		. ( $u ? '<a class="eb-nb__go" href="' . $u . '">' . ( $dl ? '신청 일정' : '보러 가기' ) . ' ›</a>' : '' )
		. '<button type="button" class="eb-nb__x" aria-label="공지 닫기"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button></div></div>'
		. "<script nowprocket>(function(){var b=document.getElementById('eb-nb');if(!b){return;}var k=b.getAttribute('data-k');try{if(localStorage.getItem('eb_nb_x')===k){b.remove();return;}}catch(e){}b.querySelector('.eb-nb__x').addEventListener('click',function(){try{localStorage.setItem('eb_nb_x',k);}catch(e){}b.remove();});})();</script>";
}, 4 ); // 48번 헤더(wp_body_open 5)보다 먼저 = 헤더 위
// 휴대폰 전체 메뉴 맨 위 한 줄(68번에서 부름)
function eb_notice_menu_html() {
	$n = eb_notice();
	if ( ! $n ) {
		return '';
	}
	$dl = '' !== $n['dd'];
	if ( $dl ) { // 자동 마감 공지: 꼬리표·D-day 한 줄, 이름, 날짜 (2026-10-18 A안)
		$in = '<span class="ebm__ntx"><span class="ebm__nh"><span class="ebm__ntg">' . esc_html( $n['tg'] ) . '</span><span class="ebm__ndd' . ( $n['lv'] ? ' is-' . $n['lv'] : '' ) . '">' . esc_html( $n['dd'] ) . '</span></span><b>' . esc_html( $n['t'] ) . '</b>' . ( $n['w'] ? '<small>' . esc_html( $n['w'] ) . '</small>' : '' ) . '</span>';
	} else {
		$in = '<span class="ebm__ntg">' . esc_html( $n['tg'] ) . '</span><span class="ebm__ntx">' . ( $n['d'] ? '<b>' . esc_html( $n['d'] ) . '</b> ' : '' ) . esc_html( $n['t'] ) . '</span>';
	}
	$cl = 'ebm__nb' . ( $dl ? ' is-due' : '' );
	return $n['u'] ? '<a class="' . $cl . '" href="' . esc_url( $n['u'] ) . '">' . $in . eb_x_ic( 'chev' ) . '</a>' : '<p class="' . $cl . '">' . $in . '</p>';
}

// 77-2. 자동 공지(가장 가까운 마감)는 날마다 바뀜 → 매일 0시 5분 WP Rocket 캐시 비움(자동 공지일 때만)
add_action( 'init', function () {
	if ( ! wp_next_scheduled( 'eb_notice_daily' ) ) {
		$t = ( new DateTime( 'tomorrow 00:05', wp_timezone() ) )->getTimestamp();
		wp_schedule_event( $t, 'daily', 'eb_notice_daily' );
	}
} );
add_action( 'eb_notice_daily', function () {
	$n = get_option( 'eb_notice', array() );
	if ( is_array( $n ) && '' === trim( $n['t'] ?? '' ) && '0' !== (string) ( $n['a'] ?? '1' ) && function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
} );

// 77-3. 메가메뉴 뒤 어두운 막(.xh__dim)의 시작 높이 = 지금 헤더 아래 끝. 공지 줄이 헤더 위에 있으면 처음엔 33px 내려가 있다가 스크롤하면 올라가서
//       고정값(61/93px)이면 막이 헤더 아래쪽을 덮어 양옆이 회색으로 보였음(css/40-header.css --xh-b)
add_action( 'wp_footer', function () {
	echo "<script nowprocket>(function(){var xh=document.getElementById('xh'),de=document.documentElement;if(!xh){return;}var t=0;function set(){t=0;de.style.setProperty('--xh-b',Math.round(xh.getBoundingClientRect().bottom)+'px');xh.classList.toggle('is-sc',(window.scrollY||0)>4);}function q(){if(!t){t=requestAnimationFrame(set);}}xh.addEventListener('mouseover',q,{passive:true});xh.addEventListener('focusin',q);window.addEventListener('scroll',q,{passive:true});window.addEventListener('resize',q);set();})();</script>";
}, 62 );

/* 78. 계산기 날짜 칸 (2026-10-18, css/30-calc.css 끝 '날짜 칸') ------------------------------------------------------------
 * 휴대폰에서 '연도. 월. 일.' 칸이 잘 안 눌리고(조각마다 따로 눌림), 입사일·생년월일처럼 오래전 날짜는 달력으로 넘기기 힘들어서
 * 숫자로 바로 넣는 칸(20200302 → 2020.03.02, 2020-3-2도 됨) + 오른쪽 달력 아이콘을 덧씌움.
 * 원래 <input type="date">는 같은 자리에 그대로 두고(테두리·배경 담당, 글자만 투명) 값만 맞춰 줌 → 계산기 스크립트는 고칠 것 없음.
 * 오른쪽 36px(달력 아이콘)을 누르면 원래 날짜 칸이 눌려 기기 달력이 열림. 새 입력 칸은 form="eb-dt-none"이라 계산기 검사·결과 표에 안 섞임.
 * 끄기: eb_date_input_live() false
 */
function eb_date_input_live() {
	return true;
}
add_action( 'wp_footer', function () {
	if ( ! eb_date_input_live() ) {
		return;
	}
	echo "<script nowprocket>\n" . <<<'JS'
(function () {
	var list = document.querySelectorAll('.eb-calc input[type="date"], .eb-qa input[type="date"]');
	if (!list.length) { return; }
	var desc = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
	var ico = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M8 3v4M16 3v4M3.5 10h17M8 14h.01M12 14h.01M16 14h.01M8 17.5h.01M12 17.5h.01"/></svg>';
	function pad(n) { return (n < 10 ? '0' : '') + n; }
	function show(v) { return v ? v.replace(/-/g, '.') : ''; }
	// '20200302' · '2020.03.02' · '2020-3-2' · '2020/3/2' → '2020-03-02' (없는 날짜면 '')
	function parse(s) {
		var p = String(s).trim().split(/[^0-9]+/).filter(Boolean), y, m, d;
		if (p.length === 1 && p[0].length === 8) { y = +p[0].slice(0, 4); m = +p[0].slice(4, 6); d = +p[0].slice(6); }
		else if (p.length === 3 && p[0].length === 4) { y = +p[0]; m = +p[1]; d = +p[2]; }
		else { return ''; }
		var x = new Date(y, m - 1, d);
		if (y < 1900 || y > 2100 || x.getMonth() !== m - 1 || x.getDate() !== d) { return ''; }
		return y + '-' + pad(m) + '-' + pad(d);
	}
	// 숫자만 칠 때 점을 넣어 줌(2020 → 2020.0 → 2020.03.0 …). 직접 2020.3. 처럼 구분자를 넣었으면 그대로 둠
	function fmt(s) {
		var p = s.split(/[^0-9]/);
		if (p.length > 3 || !p.every(function (x, i) { return i === p.length - 1 || x.length === [4, 2][i]; })) { return s; }
		var n = p.join('').slice(0, 8);
		return n.length > 6 ? n.slice(0, 4) + '.' + n.slice(4, 6) + '.' + n.slice(6) : (n.length > 4 ? n.slice(0, 4) + '.' + n.slice(4) : n);
	}
	[].forEach.call(list, function (d) {
		if (d.closest('.eb-dt')) { return; }
		var w = document.createElement('span'), t = document.createElement('input'), ic = document.createElement('span');
		var lab = d.closest('label'), ls = lab && lab.querySelector('span'), name = ls && ls.firstChild ? ls.firstChild.textContent.trim() : '날짜';
		w.className = 'eb-dt';
		t.type = 'text';
		t.className = 'eb-dt__t';
		t.maxLength = 10;
		t.placeholder = '예: 2020.03.02';
		t.setAttribute('inputmode', 'numeric');
		t.setAttribute('autocomplete', 'off');
		t.setAttribute('form', 'eb-dt-none');
		t.setAttribute('aria-label', name + ' (예: 2020.03.02)');
		ic.className = 'eb-dt__ic';
		ic.setAttribute('aria-hidden', 'true');
		ic.innerHTML = ico;
		d.parentNode.insertBefore(w, d);
		w.appendChild(t);
		w.appendChild(d);
		w.appendChild(ic);
		d.tabIndex = -1;
		d.setAttribute('aria-label', name + ' 달력에서 고르기');
		var busy = false;
		function fromDate() {
			if (busy) { return; }
			t.value = show(desc.get.call(d));
			w.classList.remove('is-bad');
			t.removeAttribute('aria-invalid');
		}
		function push(v) {
			if (v === desc.get.call(d)) { return; }
			busy = true;
			desc.set.call(d, v);
			d.dispatchEvent(new Event('input', { bubbles: true }));
			d.dispatchEvent(new Event('change', { bubbles: true }));
			busy = false;
		}
		// 계산기가 스크립트로 날짜를 넣어도(오늘·공유 링크·다시 하기) 보이는 칸이 따라가게
		try {
			Object.defineProperty(d, 'value', { configurable: true, get: function () { return desc.get.call(d); }, set: function (v) { desc.set.call(d, v); fromDate(); } });
		} catch (e) {}
		d.addEventListener('input', fromDate);
		d.addEventListener('change', fromDate);
		t.addEventListener('input', function (e) {
			if (e.inputType && e.inputType.indexOf('insert') === 0 && t.selectionStart === t.value.length) {
				var f = fmt(t.value);
				if (f !== t.value) { t.value = f; }
			}
			w.classList.remove('is-bad');
			t.removeAttribute('aria-invalid');
			push(parse(t.value));
		});
		t.addEventListener('blur', function () {
			var v = parse(t.value), bad = !!t.value.trim() && !v;
			if (v) { t.value = show(v); }
			w.classList.toggle('is-bad', bad);
			if (bad) { t.setAttribute('aria-invalid', 'true'); } else { t.removeAttribute('aria-invalid'); }
		});
		t.addEventListener('keydown', function (e) {
			var f = d.form;
			if (e.key !== 'Enter' || !f) { return; }
			e.preventDefault();
			push(parse(t.value));
			if (f.requestSubmit) { f.requestSubmit(); } else { f.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true })); }
		});
		if (d.form) { d.form.addEventListener('reset', function () { setTimeout(fromDate, 0); }); }
		fromDate();
	});
})();
JS
	. "\n</script>\n";
}, 70 );

/* 79. 공휴일 표 [eb_hol_table] (2026-10-18 시안, css/30-calc.css 끝 '공휴일 표') ---------------------------------------------
 * 날짜 계산기(15040) '2026·2027년 공휴일'. 자료는 eb_holidays() 하나 - 계산기 근무일 수와 같은 목록이라 자료만 고치면 표도 바뀜.
 * 설날·추석은 이어진 날을 한 줄로, '대체공휴일'은 바로 앞 공휴일 줄 안에 작게. 주말과 겹친 날은 요일 빨강, 대체가 없는 공휴일(신정·현충일·선거일)이 주말이면 '대체공휴일 없음'.
 * 지난 공휴일 흐림·다음 공휴일 D-day·주말과 이어 쉬는 날 수는 화면에서 방문자 날짜로 계산(캐시된 페이지 대비). PC(1080px 이상)는 두 해를 나란히, 그 아래는 연도 고르기.
 * '새 공휴일': 노동절·제헌절(관공서의 공휴일에 관한 규정 개정, 2026.4.28 국무회의 의결)
 */
function eb_hol_groups() {
	$new = array( '2026-05-01' => 1, '2026-07-17' => 1 );
	$tz  = wp_timezone();
	$wk  = array( '일', '월', '화', '수', '목', '금', '토' );
	$hol = eb_holidays();
	$out = array();
	ksort( $hol );
	foreach ( $hol as $d => $name ) {
		$t = new DateTimeImmutable( $d, $tz );
		$y = $t->format( 'Y' );
		$w = (int) $t->format( 'w' );
		if ( ! isset( $out[ $y ] ) ) {
			$out[ $y ] = array();
		}
		$last = count( $out[ $y ] ) - 1;
		if ( '대체공휴일' === $name && $last >= 0 ) {
			$out[ $y ][ $last ]['sub'][] = $t->format( 'n.j' ) . '(' . $wk[ $w ] . ')';
			$out[ $y ][ $last ]['e2']    = $d;
			continue;
		}
		$base = preg_match( '/^(설날|추석)/u', $name, $m ) ? $m[1] : '';
		if ( $base && $last >= 0 && $base === $out[ $y ][ $last ]['base'] && ! $out[ $y ][ $last ]['sub'] ) {
			$out[ $y ][ $last ]['e']  = $d;
			$out[ $y ][ $last ]['e2'] = $d;
			$out[ $y ][ $last ]['w2'] = $w;
			$out[ $y ][ $last ]['n']++;
			continue;
		}
		$out[ $y ][] = array( 's' => $d, 'e' => $d, 'e2' => $d, 'n' => 1, 'w1' => $w, 'w2' => $w, 'base' => $base, 'name' => $base ? $base . ' 연휴' : $name, 'sub' => array(), 'new' => isset( $new[ $d ] ) );
	}
	return $out;
}
add_shortcode( 'eb_hol_table', function () {
	$groups = eb_hol_groups();
	if ( ! $groups ) {
		return '';
	}
	$wk  = array( '일', '월', '화', '수', '목', '금', '토' );
	$tz  = wp_timezone();
	$seg = '';
	$yrs = '';
	foreach ( $groups as $y => $rows ) {
		$days = 0;
		$subs = 0;
		$li   = '';
		foreach ( $rows as $r ) {
			$days += $r['n'] + count( $r['sub'] );
			$subs += count( $r['sub'] );
			$s     = new DateTimeImmutable( $r['s'], $tz );
			$e     = new DateTimeImmutable( $r['e'], $tz );
			$range = $r['n'] > 1;
			$dl    = $s->format( 'n.j' ) . ( $range ? '~' . ( $s->format( 'n' ) === $e->format( 'n' ) ? $e->format( 'j' ) : $e->format( 'n.j' ) ) : '' );
			$wl    = $range ? $wk[ $r['w1'] ] . '~' . $wk[ $r['w2'] ] : $wk[ $r['w1'] ];
			$we    = ! $range && in_array( $r['w1'], array( 0, 6 ), true );
			$note  = $r['sub'] ? implode( '·', $r['sub'] ) . ' 대체공휴일' : ( $we && ! $r['base'] ? '대체공휴일 없음' : '' );
			$tag   = $r['sub'] ? '<span class="eb-hol__tg is-sub">대체</span>' : ( $r['new'] ? '<span class="eb-hol__tg is-new">새 공휴일</span>' : ( $range ? '<span class="eb-hol__tg is-long">' . (int) $r['n'] . '일</span>' : '<span></span>' ) );
			$li   .= '<li class="eb-hol__r" data-s="' . esc_attr( $r['s'] ) . '" data-e="' . esc_attr( $r['e2'] ) . '" data-n="' . esc_attr( $r['name'] ) . '"><span class="eb-hol__d">' . esc_html( $dl ) . '<small' . ( $we ? ' class="is-we"' : '' ) . '>' . esc_html( $wl ) . '</small></span><span class="eb-hol__n">' . esc_html( $r['name'] ) . ( $note ? '<small>' . esc_html( $note ) . '</small>' : '' ) . '</span>' . $tag . '</li>';
		}
		$seg .= '<button type="button" data-y="' . esc_attr( $y ) . '" aria-pressed="false">' . esc_html( $y ) . '년</button>';
		$yrs .= '<section class="eb-hol__yr" data-y="' . esc_attr( $y ) . '" aria-label="' . esc_attr( $y ) . '년 공휴일"><h3 class="eb-hol__yh">' . esc_html( $y ) . '년</h3><p class="eb-hol__sum">공휴일 ' . $days . '일 · 그중 대체공휴일 ' . $subs . '일</p><ul class="eb-hol__list">' . $li . '</ul></section>';
	}
	$h = '<div class="eb-hol"><div class="eb-hol__seg" role="group" aria-label="연도 고르기">' . $seg . '</div>'
		. '<div class="eb-hol__nx" hidden><span class="eb-hol__dd"></span><span class="eb-hol__nt"><b></b><small></small></span></div>'
		. '<div class="eb-hol__yrs">' . $yrs . '</div>'
		. '<p class="eb-hol__ft">지난 공휴일은 흐리게 보여요. 2026년부터 노동절(5월 1일)과 제헌절(7월 17일)이 공휴일이에요(관공서의 공휴일에 관한 규정 개정, 2026.4.28 국무회의 의결). 상시 근로자 5인 미만 사업장은 공휴일이 유급휴일이 아닐 수 있고, 임시공휴일이 정해지면 바뀔 수 있어요. 위 계산기의 근무일 수도 이 목록으로 셉니다.</p></div>';
	$h .= "<script nowprocket>\n" . <<<'JS'
(function () {
	var box = document.querySelector('.eb-hol'); // [data-hol]은 메가메뉴 미니 달력(.m-cal)도 써서 클래스로 찾음
	if (!box) { return; }
	var wk = ['일', '월', '화', '수', '목', '금', '토'];
	function day(s) { var p = s.split('-'); return new Date(+p[0], p[1] - 1, +p[2]); }
	function key(d) { return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2); }
	function md(d) { return (d.getMonth() + 1) + '.' + d.getDate(); }
	function add(d, n) { return new Date(d.getFullYear(), d.getMonth(), d.getDate() + n); }
	var n0 = new Date(), now = new Date(n0.getFullYear(), n0.getMonth(), n0.getDate());
	var rows = [].slice.call(box.querySelectorAll('.eb-hol__r')), off = {}, next = null;
	rows.forEach(function (r) {
		for (var d = day(r.getAttribute('data-s')), e = day(r.getAttribute('data-e')); d <= e; d = add(d, 1)) { off[key(d)] = 1; }
		var past = day(r.getAttribute('data-e')) < now;
		r.classList.toggle('is-past', past);
		if (!past && !next) { next = r; }
	});
	// 다음 공휴일: D-day + 주말·공휴일이 이어지는 쉬는 날 수
	if (next) {
		var s = day(next.getAttribute('data-s')), dd = Math.round((s - now) / 864e5), nx = box.querySelector('.eb-hol__nx');
		var isOff = function (d) { var w = d.getDay(); return w === 0 || w === 6 || !!off[key(d)]; };
		var a = s, b = s;
		while (isOff(add(a, -1))) { a = add(a, -1); }
		while (isOff(add(b, 1))) { b = add(b, 1); }
		var len = Math.round((b - a) / 864e5) + 1;
		nx.querySelector('.eb-hol__dd').textContent = dd > 0 ? 'D-' + dd : '오늘';
		nx.querySelector('b').textContent = (dd > 0 ? '다음 공휴일 · ' : '지금 공휴일 · ') + md(s) + '(' + wk[s.getDay()] + ') ' + next.getAttribute('data-n');
		nx.querySelector('small').textContent = len > 1 ? '주말과 이어 ' + len + '일 쉬어요 (' + md(a) + '~' + md(b) + ')' : '평일 하루 쉬어요';
		nx.hidden = false;
	}
	var segs = [].slice.call(box.querySelectorAll('.eb-hol__seg button')), yrs = [].slice.call(box.querySelectorAll('.eb-hol__yr'));
	function pick(y) {
		segs.forEach(function (x) { x.setAttribute('aria-pressed', x.getAttribute('data-y') === y ? 'true' : 'false'); });
		yrs.forEach(function (x) { x.classList.toggle('is-on', x.getAttribute('data-y') === y); });
	}
	segs.forEach(function (x) { x.addEventListener('click', function () { pick(x.getAttribute('data-y')); }); });
	pick(next ? next.closest('.eb-hol__yr').getAttribute('data-y') : (segs[0] ? segs[0].getAttribute('data-y') : ''));
	box.classList.add('is-js');
})();
JS
		. "\n</script>";
	return $h;
} );
