<?php
/**
 * Plugin Name: 이지복지 스테이징 보호
 * Description: 스테이징(테스트) 사이트에서만 메일·GA4·웹 푸시·예약 작업·외부 API 호출을 막습니다. 운영 사이트(easybokji.com)에서는 아무 일도 하지 않습니다.
 * Version:     1.0.0
 * Author:      이지복지
 *
 * 둘 곳: 스테이징의 wp-content/mu-plugins/eb-staging-guard.php (안내: 저장소 staging/README.md)
 * mu-plugins(꼭 쓰는 플러그인)는 관리자 화면에서 끌 수 없고 다른 플러그인보다 먼저 읽힙니다.
 *
 * 켜지는 조건: 사이트 주소(설정 > 일반의 '사이트 주소')가 아래 EB_STG_HOST이거나 *.cloudwaysapps.com일 때만.
 *   주소에 easybokji.com이 들어 있으면 절대 켜지지 않음 → 실수로 운영에 올라가도 영향 없음.
 *
 * 하는 일
 *  1. 메일: wp_mail을 보내지 않고 '보낸 것처럼' 처리(폼 완료 화면 시험용). 기록만 남김(받는 주소는 가림)
 *  2. GA4: 테마 functions.php 30번 추적 코드를 빼고, 혹시 남은 코드도 수집하지 않게 끄기 신호(ga-disable)를 넣음
 *  3. 웹 푸시: 복지 일정 플러그인 알림을 끈 상태(ebs_push_off)로 보이게 함 + 예약 작업·외부 요청 차단으로 발송 경로를 막음
 *  4. 예약 작업(WP-Cron·Action Scheduler): 실행하지 않음(등록은 그대로 두어 운영과 같은 목록을 볼 수 있음)
 *  5. 외부 API: WordPress HTTP 요청 중 허용 목록 밖은 막음 → 테마·플러그인은 DB에 저장된 마지막 데이터로 화면을 그림
 *     (보건복지부 소식 eb_mohw_news_last, 복지서비스 eb_ws_all·eb_ws_local, 쿠팡 eb_cp_*_last 등 - 실패 시 이전 데이터 유지 확인함)
 *  6. 확인 화면: 관리자 > 도구 > 스테이징 보호 (막은 요청·메일 기록), 관리자 막대에 '스테이징 보호 켜짐' 표시
 *
 * 막지 못하는 것: 플러그인이 WordPress HTTP 기능을 거치지 않고 PHP curl로 직접 보내는 요청. 확인 화면 '알아 둘 것' 참고.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const EB_STG_HOST = 'wordpress-1073525-6734075.cloudwaysapps.com';

// 서버 밖으로 나가도 되는 곳(읽기 전용·키 없음). 그 밖은 모두 막음. 이 사이트 자신(스테이징 주소)은 늘 허용
// 복지지도처럼 꼭 받아야 하는 곳이 생기면 여기 한 줄을 더하는 대신, 먼저 저장된 데이터로 시험할 수 있는지 확인
function eb_stg_allowed_hosts() {
	return array(
		'api.wordpress.org',      // 워드프레스·플러그인 버전 정보
		'downloads.wordpress.org', // 플러그인 내려받기(관리자가 직접 누를 때만)
		'www.youtube.com',        // 글 속 영상 출처 줄(69번 oEmbed, 키 없음). 막으면 출처가 빈 값으로 저장돼 화면이 운영과 달라짐
	);
}

function eb_stg_host_of( $url ) {
	$h = wp_parse_url( (string) $url, PHP_URL_HOST );
	return is_string( $h ) ? strtolower( $h ) : '';
}

// 운영에서는 false. 한 요청 안에서는 한 번만 계산
function eb_stg_on() {
	static $on = null;
	if ( null !== $on ) {
		return $on;
	}
	$host = eb_stg_host_of( get_option( 'home' ) );
	if ( '' === $host || false !== strpos( $host, 'easybokji.com' ) ) {
		$on = false;
	} else {
		$on = EB_STG_HOST === $host || '.cloudwaysapps.com' === substr( $host, -18 );
	}
	return $on;
}

if ( ! eb_stg_on() ) {
	return;
}

// 기록: 같은 종류는 횟수만 늘림(최근 60개, 자동 불러오기 안 함). 주소의 ? 뒤(인증키 등)는 남기지 않음
function eb_stg_log( $type, $what ) {
	$log = get_option( 'eb_stg_log', array() );
	$log = is_array( $log ) ? $log : array();
	$k   = $type . '|' . $what;
	$log[ $k ] = array(
		't' => $type,
		'w' => $what,
		'n' => isset( $log[ $k ]['n'] ) ? (int) $log[ $k ]['n'] + 1 : 1,
		'at' => time(),
	);
	uasort( $log, function ( $a, $b ) {
		return $b['at'] - $a['at'];
	} );
	update_option( 'eb_stg_log', array_slice( $log, 0, 60, true ), false );
}

/* 1. 메일 --------------------------------------------------------------------- */
add_filter( 'pre_wp_mail', function ( $return, $atts ) {
	$to = isset( $atts['to'] ) ? (array) $atts['to'] : array();
	if ( 1 === count( $to ) && is_string( $to[0] ) && false !== strpos( $to[0], ',' ) ) {
		$to = explode( ',', $to[0] );
	}
	$masked = array_map( function ( $a ) {
		$a = trim( (string) $a );
		$p = strrpos( $a, '@' );
		return false === $p ? '(주소 없음)' : '***' . substr( $a, $p );
	}, $to );
	$subject = isset( $atts['subject'] ) ? wp_strip_all_tags( (string) $atts['subject'] ) : '';
	eb_stg_log( 'mail', implode( ', ', $masked ) . ' · ' . mb_substr( $subject, 0, 60 ) );
	return true; // 보낸 것처럼(폼 완료 화면 시험용)
}, 1, 2 );

/* 2. GA4 ---------------------------------------------------------------------- */
// 테마 30번은 이름 없는 함수라 remove_action으로 못 뺌 → wp_head 5번 자리에서 'googletagmanager'가 든 테마 함수를 찾아 뺌
add_action( 'template_redirect', function () {
	global $wp_filter;
	if ( empty( $wp_filter['wp_head'] ) || empty( $wp_filter['wp_head']->callbacks[5] ) ) {
		return;
	}
	foreach ( $wp_filter['wp_head']->callbacks[5] as $cb ) {
		if ( ! $cb['function'] instanceof Closure ) {
			continue;
		}
		try {
			$rf   = new ReflectionFunction( $cb['function'] );
			$file = (string) $rf->getFileName();
			if ( false === strpos( wp_normalize_path( $file ), '/themes/generatepress_child/' ) ) {
				continue;
			}
			$lines = @file( $file ); // phpcs:ignore
			$src   = $lines ? implode( '', array_slice( $lines, $rf->getStartLine() - 1, $rf->getEndLine() - $rf->getStartLine() + 1 ) ) : '';
			if ( false !== strpos( $src, 'googletagmanager' ) ) {
				remove_action( 'wp_head', $cb['function'], 5 );
			}
		} catch ( ReflectionException $e ) {
			continue;
		}
	}
}, 99 );

// 다른 플러그인이 넣은 구글 태그 파일도 빼기
add_action( 'wp_print_scripts', function () {
	foreach ( wp_scripts()->queue as $h ) {
		$s = wp_scripts()->registered[ $h ] ?? null;
		if ( $s && $s->src && false !== strpos( (string) $s->src, 'googletagmanager.com' ) ) {
			wp_dequeue_script( $h );
		}
	}
}, 99 );

// 남은 코드가 있어도 수집하지 않게(구글 공식 끄기 신호). 가장 먼저 출력
add_action( 'wp_head', function () {
	echo "<script>window['ga-disable-G-E2CKYTVFMF']=true;</script>\n";
}, 0 );

/* 3. 웹 푸시 ------------------------------------------------------------------- */
// 복지 일정 플러그인·테마(66번)가 보는 '알림 끔' 값 → 종 버튼·알림 스크립트가 빠짐
add_filter( 'pre_option_ebs_push_off', function () {
	return '1';
} );

/* 4. 예약 작업 ----------------------------------------------------------------- */
// 실행할 작업을 늘 '없음'으로 → wp-cron.php를 누가 불러도(서버 크론 포함) 아무것도 실행 안 함
add_filter( 'pre_get_ready_cron_jobs', function () {
	return array();
} );
add_filter( 'action_scheduler_allow_async_request_runner', '__return_false' );
add_filter( 'action_scheduler_queue_runner_concurrent_batches', function () {
	return 0;
} );

/* 5. 외부 요청 ------------------------------------------------------------------ */
add_filter( 'pre_http_request', function ( $pre, $args, $url ) {
	if ( false !== $pre ) {
		return $pre;
	}
	$host = eb_stg_host_of( $url );
	if ( '' === $host || eb_stg_host_of( get_option( 'home' ) ) === $host || eb_stg_host_of( get_option( 'siteurl' ) ) === $host ) {
		return $pre;
	}
	if ( in_array( $host, eb_stg_allowed_hosts(), true ) ) {
		if ( 'www.youtube.com' !== $host || 0 === strpos( (string) wp_parse_url( $url, PHP_URL_PATH ), '/oembed' ) ) {
			return $pre;
		}
	}
	eb_stg_log( 'http', $host . (string) wp_parse_url( $url, PHP_URL_PATH ) );
	return new WP_Error( 'eb_staging_blocked', '스테이징: 외부 요청을 막았습니다 (' . $host . ')' );
}, 1, 3 );

/* 6. 확인 화면 ------------------------------------------------------------------ */
add_action( 'admin_bar_menu', function ( $bar ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$bar->add_node( array(
		'id'    => 'eb-stg',
		'title' => '스테이징 보호 켜짐',
		'href'  => admin_url( 'tools.php?page=eb-staging' ),
		'meta'  => array( 'class' => 'eb-stg-bar' ),
	) );
}, 1 );

add_action( 'admin_head', 'eb_stg_bar_css' );
add_action( 'wp_head', 'eb_stg_bar_css' );
function eb_stg_bar_css() {
	if ( is_admin_bar_showing() ) {
		echo '<style>#wpadminbar .eb-stg-bar>.ab-item{background:#b42318!important;color:#fff!important;font-weight:700}</style>';
	}
}

add_action( 'admin_menu', function () {
	add_management_page( '스테이징 보호', '스테이징 보호', 'manage_options', 'eb-staging', 'eb_stg_page' );
} );

add_action( 'admin_post_eb_stg_clear', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'eb_stg_clear' );
	delete_option( 'eb_stg_log' );
	wp_safe_redirect( admin_url( 'tools.php?page=eb-staging' ) );
	exit;
} );

function eb_stg_page() {
	$log   = (array) get_option( 'eb_stg_log', array() );
	$crons = _get_cron_array();
	$n_job = 0;
	foreach ( (array) $crons as $hooks ) {
		$n_job += count( (array) $hooks );
	}
	$names = array( 'mail' => '메일(보낸 것처럼 처리)', 'http' => '외부 요청 막음' );
	$row   = function ( $k, $v ) {
		echo '<tr><th scope="row">' . esc_html( $k ) . '</th><td>' . wp_kses_post( $v ) . '</td></tr>';
	};
	echo '<div class="wrap"><h1>스테이징 보호</h1>';
	echo '<p>이 사이트 주소: <code>' . esc_html( home_url() ) . '</code> → 보호 켜짐. 운영(easybokji.com)에서는 이 파일이 아무 일도 하지 않습니다.</p>';
	echo '<table class="widefat striped" style="max-width:820px"><tbody>';
	$row( '메일', 'wp_mail을 보내지 않음(성공으로 응답). 아래 기록에 받는 주소 도메인·제목만 남음' );
	$row( 'GA4', '테마 30번 추적 코드 빠짐 + 끄기 신호(ga-disable). 확인: 로그아웃 창에서 페이지 소스에 <code>gtag/js</code>가 없어야 함' );
	$row( '웹 푸시', '알림 끔(ebs_push_off=1)으로 보임 · 예약 작업과 외부 요청이 막혀 발송 경로 차단' );
	$row( '예약 작업', '등록 ' . (int) $n_job . '개 · 실행 0개(모두 멈춤)' . ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ? ' · DISABLE_WP_CRON 켜짐' : '' ) );
	$row( '외부 요청 허용', esc_html( implode( ', ', eb_stg_allowed_hosts() ) ) . ' · 이 사이트 자신' );
	echo '</tbody></table>';

	echo '<h2>최근 기록</h2>';
	if ( ! $log ) {
		echo '<p>아직 없음</p>';
	} else {
		echo '<table class="widefat striped" style="max-width:820px"><thead><tr><th>종류</th><th>내용</th><th>횟수</th><th>마지막</th></tr></thead><tbody>';
		foreach ( $log as $e ) {
			echo '<tr><td>' . esc_html( $names[ $e['t'] ] ?? $e['t'] ) . '</td><td><code>' . esc_html( $e['w'] ) . '</code></td><td>' . (int) $e['n'] . '</td><td>' . esc_html( wp_date( 'm.d H:i', (int) $e['at'] ) ) . '</td></tr>';
		}
		echo '</tbody></table>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin-top:12px"><input type="hidden" name="action" value="eb_stg_clear">';
		wp_nonce_field( 'eb_stg_clear' );
		submit_button( '기록 지우기', 'secondary', 'submit', false );
		echo '</form>';
	}

	echo '<h2>알아 둘 것</h2><ul style="list-style:disc;padding-left:20px;max-width:820px">';
	echo '<li>PHP curl로 직접 보내는 요청은 여기서 못 막습니다. 웹 푸시 발송 방식은 복지 일정 플러그인(eb-schedule) 코드 확인 전까지 <strong>확인 필요</strong>.</li>';
	echo '<li>외부 요청이 막히면 테마는 DB에 저장된 마지막 데이터(새 소식·복지서비스 목록·쿠팡 상품)로 화면을 그립니다. 새로 받기 버튼은 실패로 표시됩니다.</li>';
	echo '<li>스테이징을 운영으로 밀어 올리기(Push to Live) 전에는 이 파일을 지우거나 제외하세요. 올라가도 동작하지 않지만 남길 이유가 없습니다.</li>';
	echo '</ul></div>';
}
