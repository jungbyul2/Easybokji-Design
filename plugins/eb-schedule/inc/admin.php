<?php
/**
 * 관리자 > 복지 일정
 *   노출 중   : 지금 사이트에 보이는 일정(정부24 자동·승인, 직접 추가, 법정 기간) — 편집·숨기기
 *   검수 대기 : 정부24에서 날짜가 읽힌 서비스 중 아직 안 보이는 것 — 노출·숨김
 *   직접 추가 : 공고가 정부24에 없거나 늦게 올라오는 일정(국가건강검진, 독감 접종 등)
 *   동기화    : 마지막으로 받은 때·오류·응답 항목 이름, 지금 받기, 기간 읽기 시험
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	$wait  = ebs_wait_count();
	$badge = $wait ? ' <span class="awaiting-mod">' . (int) min( $wait, 999 ) . '</span>' : '';
	add_menu_page( '복지 일정', '복지 일정' . $badge, 'manage_options', 'ebs', 'ebs_admin_page', 'dashicons-calendar-alt', 26 );
} );

function ebs_admin_url( $args = array() ) {
	return add_query_arg( $args, admin_url( 'admin.php?page=ebs' ) );
}

/** 검수 대기 중 앞으로 120일 안에 접수 중이거나 시작하는 것 */
function ebs_wait_list( $today = '' ) {
	$today = $today ? $today : current_time( 'Y-m-d' );
	$until = gmdate( 'Y-m-d', strtotime( $today . ' +120 days' ) );
	$rev   = ebs_review();
	$out   = array();
	foreach ( (array) get_option( 'ebs_raw', array() ) as $it ) {
		if ( 'wait' !== ebs_state( $it, $rev ) ) {
			continue;
		}
		$p = ebs_pick_period( $it['p'], $today );
		if ( ! $p || ( $p['s'] && $p['s'] > $until ) ) {
			continue;
		}
		$it['pick'] = $p;
		$out[]      = $it;
	}
	usort( $out, function ( $a, $b ) {
		return strcmp( $a['pick']['e'], $b['pick']['e'] );
	} );
	return $out;
}

function ebs_wait_count() {
	$c = get_transient( 'ebs_wait_count' );
	if ( false === $c ) {
		$c = 0;
		foreach ( ebs_wait_list() as $it ) {
			if ( ebs_is_central( $it ) ) {
				$c++; // 메뉴 숫자는 중앙부처 것만(지역 사업은 수천 건이라)
			}
		}
		set_transient( 'ebs_wait_count', $c, HOUR_IN_SECONDS );
	}
	return (int) $c;
}

function ebs_post_ref( $v ) {
	$v = trim( (string) $v );
	if ( '' === $v ) {
		return 0;
	}
	return preg_match( '/^\d+$/', $v ) ? (int) $v : (int) url_to_postid( $v );
}

/* 저장 --------------------------------------------------------------------------- */

add_action( 'admin_post_ebs_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'ebs' );
	$do   = isset( $_POST['do'] ) ? sanitize_key( wp_unslash( $_POST['do'] ) ) : '';
	$back = isset( $_POST['back'] ) ? esc_url_raw( wp_unslash( $_POST['back'] ) ) : ebs_admin_url();
	$msg  = '';
	$p    = function ( $k ) {
		return isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	};

	switch ( $do ) {
		case 'sync':
			$r   = ebs_sync();
			$msg = is_wp_error( $r ) ? 'err:' . $r->get_error_message() : 'synced';
			break;

		case 'state': // 정부24 한 건(또는 여러 건) 노출·숨김·되돌리기
			$rev = ebs_review();
			$ids = isset( $_POST['ids'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['ids'] ) ) : array( $p( 'id' ) );
			$st  = $p( 'st' );
			foreach ( array_filter( $ids ) as $id ) {
				$cur = isset( $rev[ $id ] ) ? (array) $rev[ $id ] : array();
				if ( in_array( $st, array( 'show', 'hide' ), true ) ) {
					$cur['st'] = $st;
				} else {
					unset( $cur['st'] );
				}
				$rev[ $id ] = $cur;
			}
			update_option( 'ebs_review', $rev, false );
			$msg = 'saved';
			break;

		case 'edit': // 정부24 한 건 고쳐 쓰기
			$id  = $p( 'id' );
			$rev = ebs_review();
			$who = isset( $_POST['who'] ) ? array_values( array_intersect( array_map( 'sanitize_key', (array) wp_unslash( $_POST['who'] ) ), array_keys( ebs_personas() ) ) ) : array();
			$st  = $p( 'st' );
			$rev[ $id ] = array_filter( array(
				'st'          => in_array( $st, array( 'show', 'hide' ), true ) ? $st : '',
				'name'        => $p( 'name' ),
				'target'      => $p( 'target' ),
				'amount'      => $p( 'amount' ),
				'cat'         => in_array( $p( 'cat' ), ebs_categories(), true ) ? $p( 'cat' ) : '',
				'who'         => $who,
				'guide'       => ebs_post_ref( $p( 'guide' ) ),
				'apply'       => esc_url_raw( $p( 'apply' ) ),
				'apply_label' => $p( 'apply_label' ),
			) );
			update_option( 'ebs_review', $rev, false );
			$msg = 'saved';
			break;

		case 'rule': // 법정 기간: 숨기기·신청방법 글 연결
			$name  = $p( 'name' );
			$hide  = (array) get_option( 'ebs_rule_hide', array() );
			$guide = (array) get_option( 'ebs_rule_guides', array() );
			$hide  = array_values( array_diff( $hide, array( $name ) ) );
			if ( '1' === $p( 'hide' ) ) {
				$hide[] = $name;
			}
			if ( isset( $_POST['guide'] ) ) {
				$guide[ $name ] = ebs_post_ref( $p( 'guide' ) );
			}
			update_option( 'ebs_rule_hide', $hide, false );
			update_option( 'ebs_rule_guides', array_filter( $guide ), false );
			$msg = 'saved';
			break;

		case 'manual':
			$list = (array) get_option( 'ebs_manual', array() );
			$id   = $p( 'id' ) ? $p( 'id' ) : substr( md5( uniqid( '', true ) ), 0, 10 );
			$s    = $p( 's' );
			$e    = $p( 'e' );
			if ( '' === $p( 'n' ) || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $e ) || ( '' !== $s && ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $s ) || $s > $e ) ) ) {
				$msg = 'err:이름과 마감일은 꼭 넣어 주세요. 시작일은 마감일보다 앞이어야 해요.';
				break;
			}
			$who = isset( $_POST['who'] ) ? array_values( array_intersect( array_map( 'sanitize_key', (array) wp_unslash( $_POST['who'] ) ), array_keys( ebs_personas() ) ) ) : array();
			$list[ $id ] = array(
				'id'        => $id,
				'n'         => $p( 'n' ),
				's'         => $s,
				'e'         => $e,
				'yearly'    => '1' === $p( 'yearly' ),
				'cat'       => in_array( $p( 'cat' ), ebs_categories(), true ) ? $p( 'cat' ) : '복지',
				'who'       => $who,
				'target'    => $p( 'target' ),
				'amount'    => $p( 'amount' ),
				'url'       => esc_url_raw( $p( 'url' ) ),
				'url_label' => $p( 'url_label' ),
				'guide'     => ebs_post_ref( $p( 'guide' ) ),
				'on'        => '1' === $p( 'on' ),
				'note'      => $p( 'note' ),
				'checked'   => current_time( 'Y-m-d' ),
			);
			update_option( 'ebs_manual', $list, false );
			$msg  = 'saved';
			$back = ebs_admin_url( array( 'tab' => 'manual' ) );
			break;

		case 'manual_del':
			$list = (array) get_option( 'ebs_manual', array() );
			unset( $list[ $p( 'id' ) ] );
			update_option( 'ebs_manual', $list, false );
			$msg = 'saved';
			break;

		case 'guide': // 신청방법 글 한 번에 연결(노출 중 탭 '추천 → 연결', 2026-10-15)
			$src   = $p( 'src' );
			$id    = $p( 'id' );
			$guide = ebs_post_ref( $p( 'guide' ) );
			if ( 'gov24' === $src ) {
				$rev            = ebs_review();
				$cur            = isset( $rev[ $id ] ) ? (array) $rev[ $id ] : array();
				$cur['guide']   = $guide;
				$rev[ $id ]     = $cur;
				update_option( 'ebs_review', $rev, false );
			} elseif ( 'manual' === $src ) {
				$list = (array) get_option( 'ebs_manual', array() );
				if ( isset( $list[ $id ] ) ) {
					$list[ $id ]['guide'] = $guide;
					update_option( 'ebs_manual', $list, false );
				}
			} elseif ( 'rule' === $src ) {
				$g        = (array) get_option( 'ebs_rule_guides', array() );
				$g[ $id ] = $guide;
				update_option( 'ebs_rule_guides', array_filter( $g ), false );
			}
			$msg = 'saved';
			break;

		case 'push_run': // 마감 알림 - 오늘 보낼 것 지금 보내기 / 가장 최근 기기로 시험 (2026-10-15)
			$n   = ebs_push_run();
			$msg = 'ok:오늘 알림을 ' . (int) $n . '대에 보냈어요(오늘이 시작일·마감 3일 전·마감일인 일정만).';
			break;

		case 'push_test':
			$code = ebs_push_run( true );
			$msg  = ( $code >= 200 && $code < 300 ? 'ok:' : 'err:' ) . ( $code >= 200 && $code < 300 ? '가장 최근에 알림을 켠 기기로 시험 알림을 보냈어요(응답 ' . $code . ').' : '시험 알림을 보내지 못했어요(응답 ' . (int) $code . '). 알림을 켠 기기가 없거나 푸시 서비스가 거절했어요.' );
			break;

		case 'settings':
			update_option( 'ebs_auto', 'none' === $p( 'auto' ) ? 'none' : 'central', false );
			$msg = 'saved';
			break;
	}

	delete_transient( 'ebs_wait_count' );
	if ( 'sync' !== $do ) {
		ebs_purge_cache();
	}
	wp_safe_redirect( add_query_arg( 'ebs_msg', rawurlencode( $msg ), remove_query_arg( 'ebs_msg', $back ) ) );
	exit;
} );

/* 화면 --------------------------------------------------------------------------- */

function ebs_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$tab  = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'live'; // phpcs:ignore WordPress.Security.NonceVerification
	$tabs = array(
		'live'   => '노출 중',
		'wait'   => '검수 대기 (' . ebs_wait_count() . ')',
		'manual' => '직접 추가',
		'sync'   => '동기화·설정',
	);
	echo '<div class="wrap ebs-admin"><h1>복지 일정</h1>';
	ebs_admin_style();
	ebs_admin_notice();
	echo '<nav class="nav-tab-wrapper">';
	foreach ( $tabs as $k => $label ) {
		printf( '<a href="%s" class="nav-tab%s">%s</a>', esc_url( ebs_admin_url( array( 'tab' => $k ) ) ), $tab === $k || ( 'edit' === $tab && 'live' === $k ) ? ' nav-tab-active' : '', esc_html( $label ) );
	}
	echo '</nav>';

	switch ( $tab ) {
		case 'wait':
			ebs_tab_wait();
			break;
		case 'manual':
			ebs_tab_manual();
			break;
		case 'sync':
			ebs_tab_sync();
			break;
		case 'edit':
			ebs_tab_edit();
			break;
		default:
			ebs_tab_live();
	}
	echo '</div>';
}

function ebs_admin_notice() {
	$m = isset( $_GET['ebs_msg'] ) ? sanitize_text_field( wp_unslash( $_GET['ebs_msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === $m ) {
		return;
	}
	if ( 0 === strpos( $m, 'err:' ) ) {
		echo '<div class="notice notice-error"><p>' . esc_html( substr( $m, 4 ) ) . '</p></div>';
	} elseif ( 0 === strpos( $m, 'ok:' ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( substr( $m, 3 ) ) . '</p></div>';
	} elseif ( 'synced' === $m ) {
		$meta = ebs_meta();
		echo '<div class="notice notice-success"><p>정부24 서비스 ' . esc_html( number_format_i18n( $meta['total'] ) ) . '건을 받았고, 그중 기간이 날짜로 적힌 ' . esc_html( number_format_i18n( $meta['dated'] ) ) . '건을 저장했어요.</p></div>';
	} else {
		echo '<div class="notice notice-success is-dismissible"><p>저장했어요. 메인과 복지 캘린더 캐시도 비웠어요.</p></div>';
	}
}

function ebs_form_open( $do, $back = '' ) {
	$back = $back ? $back : ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ebs_admin_url() );
	return '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">'
		. '<input type="hidden" name="action" value="ebs_save"><input type="hidden" name="do" value="' . esc_attr( $do ) . '">'
		. '<input type="hidden" name="back" value="' . esc_attr( $back ) . '">' . wp_nonce_field( 'ebs', '_wpnonce', true, false );
}

function ebs_mini_button( $do, $fields, $label, $class = 'button button-small' ) {
	$h = ebs_form_open( $do ) . '';
	foreach ( $fields as $k => $v ) {
		$h .= '<input type="hidden" name="' . esc_attr( $k ) . '" value="' . esc_attr( $v ) . '">';
	}
	return '<span class="ebs-inline">' . $h . '<button class="' . esc_attr( $class ) . '">' . esc_html( $label ) . '</button></form></span>';
}

function ebs_period_label( $s, $e ) {
	return ebs_range( $s, $e );
}

function ebs_src_label( $x ) {
	$m = array( 'gov24' => '정부24', 'manual' => '직접', 'rule' => '법정' );
	$h = '<span class="ebs-src is-' . esc_attr( $x['src'] ) . '">' . esc_html( $m[ $x['src'] ] ) . '</span>';
	if ( 'gov24' === $x['src'] && 'auto' === $x['state'] ) {
		$h .= ' <span class="ebs-src">자동</span>';
	}
	return $h;
}

function ebs_tab_live() {
	$items = ebs_items( array( 'ahead' => 60 ) );
	echo '<p class="description">지금 사이트(메인 위젯·복지 캘린더)에 보이는 일정이에요. 오늘부터 60일 안에 시작하는 것까지 포함해요. 이름을 누르면 편집해요. <strong>신청방법 글을 연결하면 버튼이 사이트 안 글로 먼저 연결돼요.</strong></p>';
	if ( ! $items ) {
		echo '<p>보이는 일정이 없어요. 동기화 탭에서 정부24 데이터를 먼저 받아 주세요.</p>';
		return;
	}
	echo '<table class="widefat striped ebs-table"><thead><tr><th>상태</th><th>일정</th><th>기간</th><th>대상 · 금액</th><th>신청방법 글</th><th></th></tr></thead><tbody>';
	foreach ( $items as $x ) {
		$edit = 'gov24' === $x['src'] ? ebs_admin_url( array( 'tab' => 'edit', 'id' => $x['id'] ) ) : ( 'manual' === $x['src'] ? ebs_admin_url( array( 'tab' => 'manual', 'edit' => $x['id'] ) ) : '' );
		echo '<tr>';
		echo '<td>' . ( $x['open'] ? '<span class="ebs-st is-open">접수 중</span>' : '<span class="ebs-st is-next">곧 시작</span>' ) . '</td>';
		echo '<td>' . ebs_src_label( $x ) . ' <strong>' . ( $edit ? '<a href="' . esc_url( $edit ) . '">' . esc_html( $x['name'] ) . '</a>' : esc_html( $x['name'] ) ) . '</strong>'
			. ( $x['org'] ? '<br><small>' . esc_html( $x['org'] ) . ' · ' . esc_html( $x['cat'] ) . '</small>' : '<br><small>' . esc_html( $x['cat'] ) . '</small>' ) . '</td>';
		echo '<td>' . esc_html( ebs_period_label( $x['s'], $x['e'] ) ) . ( $x['raw'] ? '<br><small title="' . esc_attr( $x['raw'] ) . '">원문: ' . esc_html( ebs_cut( $x['raw'], 40 ) ) . '</small>' : '' ) . '</td>';
		echo '<td>' . esc_html( $x['target'] ) . ( $x['amount'] ? '<br><strong>' . esc_html( $x['amount'] ) . '</strong>' : '' ) . '</td>';
		echo '<td>' . ( $x['guide'] ? '<a href="' . esc_url( $x['guide'] ) . '" target="_blank">연결됨</a>' : ebs_guide_suggest_html( $x ) ) . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput
		echo '<td class="ebs-actions">';
		if ( 'gov24' === $x['src'] ) {
			echo ebs_mini_button( 'state', array( 'id' => $x['id'], 'st' => 'hide' ), '숨기기' ); // phpcs:ignore WordPress.Security.EscapeOutput
		} elseif ( 'rule' === $x['src'] ) {
			echo ebs_rule_form( $x ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function ebs_rule_form( $x ) {
	$g   = (array) get_option( 'ebs_rule_guides', array() );
	$cur = ! empty( $g[ $x['name'] ] ) ? get_permalink( $g[ $x['name'] ] ) : '';
	return '<details><summary>글 연결·숨기기</summary>' . ebs_form_open( 'rule' )
		. '<input type="hidden" name="name" value="' . esc_attr( $x['name'] ) . '">'
		. '<input type="text" name="guide" class="regular-text" placeholder="글 주소 또는 글 번호" value="' . esc_attr( $cur ) . '">'
		. '<label><input type="checkbox" name="hide" value="1"> 이 일정 숨기기</label> <button class="button button-small">저장</button></form></details>';
}

/** 일정 이름과 제목 낱말이 겹치는 공개 글 하나(신청방법 글 연결 추천, 2026-10-15). 못 찾으면 0 */
function ebs_guide_suggest( $name ) {
	static $posts = null;
	if ( null === $posts ) {
		$posts = array();
		foreach ( get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1, 'no_found_rows' => true ) ) as $p ) {
			$posts[ $p->ID ] = html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' );
		}
	}
	$split = '/[\s·ㆍ()\[\]\-|–,.:]+/u';
	$stop  = '/^(20\d\d|지원|지원금|지원사업|사업|신청|신청방법|방법|서비스|발급|대상|대상자|올해|안내|혜택|조회|결과|총정리|단계|최대|만원|이용|이용방법|비교|추천|및|등|복지|가구|저소득|장애인|다자녀|취약계층|노인|어르신|청년|아동)$/u'; // 대상 무리 이름은 겹쳐도 같은 제도가 아님
	$nn    = preg_replace( $split, '', (string) $name );
	$best  = array( 0, 0 );
	foreach ( $posts as $id => $title ) {
		$score = 0;
		foreach ( preg_split( $split, $title ) as $w ) {
			if ( mb_strlen( $w ) >= 3 && ! preg_match( $stop, $w ) && false !== mb_strpos( $nn, $w ) ) {
				$score += mb_strlen( $w );
			}
		}
		if ( $score > $best[1] ) {
			$best = array( $id, $score );
		}
	}
	return $best[1] >= 4 ? $best[0] : 0;
}

function ebs_guide_suggest_html( $x ) {
	$id = ebs_guide_suggest( $x['name'] );
	if ( ! $id ) {
		return '<span class="ebs-muted">없음</span>';
	}
	return '<span class="ebs-muted">없음</span><br><small>추천: <a href="' . esc_url( get_permalink( $id ) ) . '" target="_blank">' . esc_html( ebs_cut( get_the_title( $id ), 28 ) ) . '</a></small> '
		. ebs_mini_button( 'guide', array( 'src' => $x['src'], 'id' => $x['id'], 'guide' => $id ), '연결' );
}

function ebs_tab_wait() {
	$q     = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$scope = isset( $_GET['scope'] ) ? sanitize_key( wp_unslash( $_GET['scope'] ) ) : 'central'; // phpcs:ignore WordPress.Security.NonceVerification
	$pg    = max( 1, isset( $_GET['pg'] ) ? (int) $_GET['pg'] : 1 ); // phpcs:ignore WordPress.Security.NonceVerification
	$list  = array();
	foreach ( ebs_wait_list() as $it ) {
		if ( 'all' !== $scope && ebs_org_kind( $it ) !== $scope ) {
			continue;
		}
		if ( '' !== $q && false === stripos( $it['n'] . ' ' . $it['org'] . ' ' . $it['tgt'], $q ) ) {
			continue;
		}
		$list[] = $it;
	}
	$per   = 50;
	$pages = max( 1, (int) ceil( count( $list ) / $per ) );
	$rows  = array_slice( $list, ( $pg - 1 ) * $per, $per );

	echo '<p class="description">정부24에서 기간이 날짜로 읽힌 서비스 중 아직 사이트에 안 보이는 것이에요(오늘~120일 안). 연도 없이 적힌 기간(해마다)과 지역 사업은 여기서 확인 후 노출해 주세요. 원문과 읽어 낸 기간이 맞는지 꼭 봐 주세요.</p>';
	echo '<form method="get" class="ebs-filter"><input type="hidden" name="page" value="ebs"><input type="hidden" name="tab" value="wait">';
	echo '<select name="scope">';
	foreach ( array( 'central' => '중앙부처', 'public' => '공공기관', 'local' => '지역(지자체)', 'all' => '전체' ) as $k => $l ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $scope, $k, false ), esc_html( $l ) );
	}
	echo '</select> <input type="search" name="q" value="' . esc_attr( $q ) . '" placeholder="이름·기관·대상 검색"> <button class="button">찾기</button> <span class="ebs-muted">' . esc_html( number_format_i18n( count( $list ) ) ) . '건</span></form>';

	if ( ! $rows ) {
		echo '<p>검수할 항목이 없어요.</p>';
		return;
	}
	echo ebs_form_open( 'state' ); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<p><select name="st"><option value="show">고른 항목 노출</option><option value="hide">고른 항목 숨김</option></select> <button class="button button-primary">적용</button></p>';
	echo '<table class="widefat striped ebs-table"><thead><tr><td class="check-column"><input type="checkbox" onclick="var c=this.checked;this.closest(\'table\').querySelectorAll(\'tbody input[type=checkbox]\').forEach(function(x){x.checked=c})"></td><th>서비스</th><th>원문 기간</th><th>읽어 낸 기간</th><th>대상</th><th></th></tr></thead><tbody>';
	foreach ( $rows as $it ) {
		$p = $it['pick'];
		echo '<tr><th class="check-column"><input type="checkbox" name="ids[]" value="' . esc_attr( $it['id'] ) . '"></th>';
		echo '<td><strong><a href="' . esc_url( ebs_admin_url( array( 'tab' => 'edit', 'id' => $it['id'] ) ) ) . '">' . esc_html( $it['n'] ) . '</a></strong><br><small>' . esc_html( $it['org'] ) . ( $it['field'] ? ' · ' . esc_html( $it['field'] ) : '' ) . '</small>'
			. ( $it['first'] > time() - 7 * DAY_IN_SECONDS ? ' <span class="ebs-src is-new">새로</span>' : '' ) . '</td>';
		echo '<td><small>' . esc_html( $it['raw'] ) . '</small></td>';
		// 기간이 여럿이면(상·하반기 등) 다 보여 줌 - 사이트에는 가까운 것부터 차례로 나옴 (2026-10-15)
		$more = count( (array) $it['p'] ) > 1 ? '<br><small>전체 ' . count( $it['p'] ) . '개 기간: ' . esc_html( implode( ' / ', array_map( function ( $q ) {
			$q = ebs_roll_year( $q, current_time( 'Y-m-d' ) ); // 해마다 반복이면 다음에 돌아오는 날짜(요일)로
			return ebs_range( $q['s'], $q['e'] );
		}, $it['p'] ) ) ) . '</small>' : '';
		echo '<td>' . esc_html( ebs_period_label( $p['s'], $p['e'] ) ) . ( ! empty( $p['ny'] ) ? '<br><span class="ebs-src">해마다(연도 없음)</span>' : '' ) . $more . '</td>';
		echo '<td><small>' . esc_html( ebs_cut( $it['tgt'], 70 ) ) . '</small></td>';
		echo '<td>' . ( $it['url'] ? '<a href="' . esc_url( $it['url'] ) . '" target="_blank" rel="noopener">정부24 원문</a>' : '' ) . '</td></tr>';
	}
	echo '</tbody></table></form>';

	if ( $pages > 1 ) {
		echo '<p class="ebs-pages">';
		for ( $i = 1; $i <= $pages; $i++ ) {
			$u = ebs_admin_url( array( 'tab' => 'wait', 'scope' => $scope, 'q' => $q, 'pg' => $i ) );
			echo $i === $pg ? '<strong>' . (int) $i . '</strong> ' : '<a href="' . esc_url( $u ) . '">' . (int) $i . '</a> ';
		}
		echo '</p>';
	}

	$hidden = array();
	foreach ( ebs_review() as $id => $r ) {
		if ( isset( $r['st'] ) && 'hide' === $r['st'] ) {
			$hidden[] = $id;
		}
	}
	if ( $hidden ) {
		$raw = (array) get_option( 'ebs_raw', array() );
		echo '<details class="ebs-hidden"><summary>숨긴 항목 ' . count( $hidden ) . '건</summary><ul>';
		foreach ( $hidden as $id ) {
			$n = isset( $raw[ $id ] ) ? $raw[ $id ]['n'] : $id;
			echo '<li>' . esc_html( $n ) . ' ' . ebs_mini_button( 'state', array( 'id' => $id, 'st' => '' ), '되돌리기' ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</ul></details>';
	}
}

function ebs_who_boxes( $sel ) {
	$h = '';
	foreach ( ebs_personas() as $k => $label ) {
		$h .= '<label class="ebs-chk"><input type="checkbox" name="who[]" value="' . esc_attr( $k ) . '"' . checked( in_array( $k, (array) $sel, true ), true, false ) . '> ' . esc_html( $label ) . '</label>';
	}
	return $h;
}

function ebs_cat_select( $cur ) {
	$h = '<select name="cat"><option value="">자동</option>';
	foreach ( ebs_categories() as $c ) {
		$h .= '<option' . selected( $cur, $c, false ) . '>' . esc_html( $c ) . '</option>';
	}
	return $h . '</select>';
}

function ebs_tab_edit() {
	$id  = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$raw = (array) get_option( 'ebs_raw', array() );
	if ( ! isset( $raw[ $id ] ) ) {
		echo '<p>이 서비스가 최근 받은 데이터에 없어요(기간이 끝났거나 정부24에서 빠졌을 수 있어요).</p>';
		return;
	}
	$it    = $raw[ $id ];
	$rev   = ebs_review();
	$r     = isset( $rev[ $id ] ) ? (array) $rev[ $id ] : array();
	$state = ebs_state( $it, $rev );
	$guide = ! empty( $r['guide'] ) ? get_permalink( $r['guide'] ) : '';
	$who   = ! empty( $r['who'] ) ? $r['who'] : ebs_guess_who( $it['n'] . ' ' . $it['tgt'] . ' ' . $it['sum'] );
	$pers  = array();
	foreach ( $it['p'] as $p ) {
		$pers[] = ebs_period_label( $p['s'], $p['e'] ) . ( ! empty( $p['ny'] ) ? ' (해마다)' : '' );
	}
	$st_l = array( 'show' => '노출(승인)', 'hide' => '숨김', 'auto' => '자동 노출', 'wait' => '검수 대기' );

	echo '<h2>' . esc_html( $it['n'] ) . '</h2>';
	echo '<table class="ebs-ref"><tr><th>기관</th><td>' . esc_html( $it['org'] . ( $it['orgt'] ? ' (' . $it['orgt'] . ')' : '' ) ) . '</td></tr>'
		. '<tr><th>원문 기간</th><td>' . esc_html( $it['raw'] ) . '</td></tr>'
		. '<tr><th>읽어 낸 기간</th><td>' . esc_html( implode( ', ', $pers ) ) . '</td></tr>'
		. '<tr><th>지원대상</th><td>' . esc_html( $it['tgt'] ) . '</td></tr>'
		. '<tr><th>지원내용</th><td>' . esc_html( $it['cnt'] ) . '</td></tr>'
		. '<tr><th>신청방법</th><td>' . esc_html( $it['how'] ) . ( $it['rcv'] ? ' · 접수: ' . esc_html( $it['rcv'] ) : '' ) . '</td></tr>'
		. '<tr><th>지금 상태</th><td><strong>' . esc_html( $st_l[ $state ] ) . '</strong>' . ( $it['url'] ? ' · <a href="' . esc_url( $it['url'] ) . '" target="_blank" rel="noopener">정부24 원문</a>' : '' ) . '</td></tr></table>';

	echo ebs_form_open( 'edit', ebs_admin_url( array( 'tab' => 'edit', 'id' => $id ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<input type="hidden" name="id" value="' . esc_attr( $id ) . '">';
	echo '<table class="form-table">';
	echo '<tr><th>노출</th><td><select name="st"><option value="">기본 규칙대로 (' . esc_html( 'wait' === $state || 'auto' === $state ? $st_l[ $state ] : '대기' ) . ')</option><option value="show"' . selected( isset( $r['st'] ) ? $r['st'] : '', 'show', false ) . '>노출</option><option value="hide"' . selected( isset( $r['st'] ) ? $r['st'] : '', 'hide', false ) . '>숨김</option></select></td></tr>';
	echo '<tr><th>보이는 이름</th><td><input class="regular-text" name="name" value="' . esc_attr( isset( $r['name'] ) ? $r['name'] : '' ) . '" placeholder="' . esc_attr( $it['n'] ) . '"></td></tr>';
	echo '<tr><th>대상 한 줄</th><td><input class="large-text" name="target" maxlength="60" value="' . esc_attr( isset( $r['target'] ) ? $r['target'] : '' ) . '" placeholder="' . esc_attr( ebs_cut( $it['tgt'], 44 ) ) . '"><p class="description">예: 기초·차상위 6세 이상</p></td></tr>';
	echo '<tr><th>금액</th><td><input class="regular-text" name="amount" value="' . esc_attr( isset( $r['amount'] ) ? $r['amount'] : '' ) . '" placeholder="' . esc_attr( ebs_amount_hint( $it['cnt'] ) ) . '"></td></tr>';
	echo '<tr><th>분류</th><td>' . ebs_cat_select( isset( $r['cat'] ) ? $r['cat'] : '' ) . ' <span class="ebs-muted">자동: ' . esc_html( ebs_field_label( $it['field'] . ' ' . $it['n'] ) ) . '</span></td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<tr><th>대상 칩</th><td>' . ebs_who_boxes( $who ) . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<tr><th>신청방법 글</th><td><input class="large-text" name="guide" value="' . esc_attr( $guide ) . '" placeholder="https://wordpress-1073525-6734075.cloudwaysapps.com/... 또는 글 번호"></td></tr>';
	echo '<tr><th>신청하는 곳</th><td><input class="large-text" name="apply" value="' . esc_attr( isset( $r['apply'] ) ? $r['apply'] : '' ) . '" placeholder="' . esc_attr( $it['url'] ) . '"> <input name="apply_label" value="' . esc_attr( isset( $r['apply_label'] ) ? $r['apply_label'] : '' ) . '" placeholder="정부24"></td></tr>';
	echo '</table><p><button class="button button-primary">저장</button></p></form>';
}

function ebs_tab_manual() {
	$list = (array) get_option( 'ebs_manual', array() );
	$eid  = isset( $_GET['edit'] ) ? sanitize_text_field( wp_unslash( $_GET['edit'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$m    = wp_parse_args( isset( $list[ $eid ] ) ? $list[ $eid ] : array(), array(
		'id' => '', 'n' => '', 's' => '', 'e' => '', 'yearly' => false, 'cat' => '복지', 'who' => array(), 'target' => '', 'amount' => '',
		'url' => '', 'url_label' => '', 'guide' => 0, 'on' => true, 'note' => '', 'checked' => '',
	) );

	echo '<p class="description">정부24에 없거나 늦게 올라오는 일정을 직접 넣어요(예: 국가건강검진 12.31 마감, 독감 무료 접종). "해마다 반복"을 켜면 기간이 지난 뒤 다음 해 같은 날짜로 넘어가요.</p>';
	echo '<h2>' . ( $m['id'] ? '일정 고치기' : '새 일정' ) . '</h2>';
	echo ebs_form_open( 'manual', ebs_admin_url( array( 'tab' => 'manual' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<input type="hidden" name="id" value="' . esc_attr( $m['id'] ) . '"><table class="form-table">';
	echo '<tr><th>이름 *</th><td><input class="regular-text" name="n" required value="' . esc_attr( $m['n'] ) . '" placeholder="국가건강검진 (올해 대상자)"></td></tr>';
	echo '<tr><th>기간</th><td><input type="date" name="s" value="' . esc_attr( $m['s'] ) . '"> ~ <input type="date" name="e" required value="' . esc_attr( $m['e'] ) . '"> <label class="ebs-chk"><input type="checkbox" name="yearly" value="1"' . checked( $m['yearly'], true, false ) . '> 해마다 반복</label><p class="description">시작일을 비우면 "~마감일"로 보여요.</p></td></tr>';
	echo '<tr><th>분류</th><td>' . ebs_cat_select( $m['cat'] ) . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<tr><th>대상 칩</th><td>' . ebs_who_boxes( $m['who'] ) . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<tr><th>대상 한 줄</th><td><input class="large-text" name="target" maxlength="60" value="' . esc_attr( $m['target'] ) . '" placeholder="올해 짝수년도 출생자"></td></tr>';
	echo '<tr><th>금액</th><td><input class="regular-text" name="amount" value="' . esc_attr( $m['amount'] ) . '" placeholder="무료"></td></tr>';
	echo '<tr><th>신청하는 곳</th><td><input class="large-text" type="url" name="url" value="' . esc_attr( $m['url'] ) . '" placeholder="https://"> <input name="url_label" value="' . esc_attr( $m['url_label'] ) . '" placeholder="버튼 이름(예: 국민건강보험)"></td></tr>';
	echo '<tr><th>신청방법 글</th><td><input class="large-text" name="guide" value="' . esc_attr( $m['guide'] ? get_permalink( $m['guide'] ) : '' ) . '" placeholder="글 주소 또는 글 번호"></td></tr>';
	echo '<tr><th>메모(근거)</th><td><input class="large-text" name="note" value="' . esc_attr( $m['note'] ) . '" placeholder="출처·확인한 공고 주소"></td></tr>';
	echo '<tr><th>노출</th><td><label class="ebs-chk"><input type="checkbox" name="on" value="1"' . checked( $m['on'], true, false ) . '> 사이트에 보이기</label></td></tr>';
	echo '</table><p><button class="button button-primary">' . ( $m['id'] ? '고친 내용 저장' : '추가' ) . '</button>' . ( $m['id'] ? ' <a class="button" href="' . esc_url( ebs_admin_url( array( 'tab' => 'manual' ) ) ) . '">새로 쓰기</a>' : '' ) . '</p></form>';

	if ( $list ) {
		echo '<h2>직접 넣은 일정</h2><table class="widefat striped ebs-table"><thead><tr><th>이름</th><th>기간</th><th>노출</th><th>확인한 날</th><th></th></tr></thead><tbody>';
		foreach ( $list as $x ) {
			echo '<tr><td><a href="' . esc_url( ebs_admin_url( array( 'tab' => 'manual', 'edit' => $x['id'] ) ) ) . '">' . esc_html( $x['n'] ) . '</a>' . ( $x['note'] ? '<br><small>' . esc_html( $x['note'] ) . '</small>' : '' ) . '</td>';
			echo '<td>' . esc_html( ebs_period_label( $x['s'], $x['e'] ) ) . ( $x['yearly'] ? ' · 해마다' : '' ) . '</td>';
			echo '<td>' . ( $x['on'] ? '보임' : '<span class="ebs-muted">숨김</span>' ) . '</td><td>' . esc_html( $x['checked'] ) . '</td>';
			echo '<td>' . ebs_mini_button( 'manual_del', array( 'id' => $x['id'] ), '삭제', 'button button-small button-link-delete' ) . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</tbody></table>';
	}
}

function ebs_tab_sync() {
	$meta = ebs_meta();
	$next = wp_next_scheduled( 'ebs_daily' );
	echo '<table class="ebs-ref">';
	echo '<tr><th>마지막으로 받은 때</th><td>' . ( $meta['synced'] ? esc_html( wp_date( 'Y.m.d H:i', $meta['synced'] ) ) : '아직 없음' ) . '</td></tr>';
	echo '<tr><th>받은 서비스</th><td>' . esc_html( number_format_i18n( $meta['total'] ) ) . '건 · 기간이 날짜로 적힌 것 ' . esc_html( number_format_i18n( $meta['dated'] ) ) . '건 저장</td></tr>';
	echo '<tr><th>다음 자동 받기</th><td>' . ( $next ? esc_html( wp_date( 'Y.m.d H:i', $next ) ) : '예약 없음(플러그인을 껐다 켜면 다시 예약돼요)' ) . '</td></tr>';
	echo '<tr><th>인증키</th><td>' . ( ebs_key() ? '설정 > 복지서비스 API에 저장된 키 사용' : '<strong>없음</strong> — 설정 > 복지서비스 API에 먼저 저장해 주세요' ) . '</td></tr>';
	if ( $meta['err'] ) {
		echo '<tr><th>마지막 오류</th><td class="ebs-err">' . esc_html( $meta['err'] ) . ( $meta['tried'] ? ' (' . esc_html( wp_date( 'm.d H:i', $meta['tried'] ) ) . ')' : '' ) . '</td></tr>';
	}
	if ( $meta['fields'] ) {
		echo '<tr><th>응답 항목 이름</th><td><code>' . esc_html( implode( ', ', $meta['fields'] ) ) . '</code></td></tr>';
	}
	echo '</table>';
	echo ebs_form_open( 'sync' ) . '<p><button class="button button-primary">지금 받기</button> <span class="ebs-muted">1만여 건을 받아요. 30초~1분쯤 걸릴 수 있어요.</span></p></form>'; // phpcs:ignore WordPress.Security.EscapeOutput

	$auto = get_option( 'ebs_auto', 'central' );
	echo '<h2>자동 노출 규칙</h2>' . ebs_form_open( 'settings' ); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<p><label><input type="radio" name="auto" value="central"' . checked( $auto, 'central', false ) . '> 중앙부처 사업이면서 연도가 적힌 기간은 바로 노출 (권장)</label><br>';
	echo '<label><input type="radio" name="auto" value="none"' . checked( $auto, 'none', false ) . '> 모두 검수 후 노출</label></p><p><button class="button">저장</button></p></form>';

	// 마감 알림(웹 푸시) 현황 (2026-10-15, eb-schedule.php 끝)
	global $wpdb;
	$pt    = ebs_push_table();
	$subs  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $pt" ); // phpcs:ignore
	$picks = 0;
	foreach ( (array) $wpdb->get_col( "SELECT items FROM $pt" ) as $j ) { // phpcs:ignore
		$picks += count( (array) json_decode( $j, true ) );
	}
	$last = (array) get_option( 'ebs_push_last', array() );
	$nxt  = wp_next_scheduled( 'ebs_push_daily' );
	echo '<h2>마감 알림(웹 푸시)</h2><p class="description">방문자가 일정 줄의 종 버튼으로 고른 일정만, 시작일·마감 3일 전·마감일 아침 9시에 브라우저 알림으로 보내요. 이름·연락처는 받지 않아요.</p>';
	echo '<table class="ebs-ref"><tr><th>알림 켠 기기</th><td>' . esc_html( number_format_i18n( $subs ) ) . '대 · 고른 일정 ' . esc_html( number_format_i18n( $picks ) ) . '건</td></tr>'
		. '<tr><th>마지막 보냄</th><td>' . ( ! empty( $last['at'] ) ? esc_html( wp_date( 'Y.m.d H:i', $last['at'] ) . ' · ' . ( ! empty( $last['test'] ) ? '시험 알림' : (int) $last['sent'] . '대' ) ) : '아직 없음' ) . '</td></tr>'
		. '<tr><th>다음 자동 보냄</th><td>' . ( $nxt ? esc_html( wp_date( 'Y.m.d H:i', $nxt ) ) : '예약 없음' ) . '</td></tr></table>';
	echo '<p>' . ebs_mini_button( 'push_test', array(), '가장 최근 기기로 시험 알림', 'button' ) . ' ' . ebs_mini_button( 'push_run', array(), '오늘 알림 지금 보내기', 'button' ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput

	// 기간 읽기 시험(저장 안 함)
	$test = isset( $_GET['t'] ) ? sanitize_text_field( wp_unslash( $_GET['t'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	echo '<h2>기간 읽기 시험</h2><form method="get"><input type="hidden" name="page" value="ebs"><input type="hidden" name="tab" value="sync">';
	echo '<input class="large-text" name="t" value="' . esc_attr( $test ) . '" placeholder="예: 2026. 2. 2. ~ 11. 30."> <button class="button">읽어 보기</button></form>';
	if ( '' !== $test ) {
		$r = ebs_parse_periods( $test );
		echo '<p>' . ( $r ? esc_html( implode( ' / ', array_map( function ( $p ) {
			return ebs_period_label( $p['s'], $p['e'] ) . ' [' . ( $p['s'] ? $p['s'] : '…' ) . ' ~ ' . $p['e'] . ']' . ( $p['ny'] ? ' 연도 없음' : '' );
		}, $r ) ) ) : '날짜를 찾지 못했어요(상시·문장형).' ) . '</p>';
	}
}

function ebs_admin_style() {
	echo '<style>
.ebs-admin .description{max-width:860px}
.ebs-table td,.ebs-table th{vertical-align:top}
.ebs-table small{color:#6b7684}
.ebs-src{display:inline-block;padding:0 6px;border-radius:4px;background:#f0f2f5;color:#4b5565;font-size:11px;line-height:18px}
.ebs-src.is-gov24{background:#eaf0fa;color:#1d3c78}.ebs-src.is-manual{background:#fff3e6;color:#c2620a}.ebs-src.is-rule{background:#f0ebfb;color:#5b3fb0}.ebs-src.is-new{background:#e4f6ef;color:#0e9f6e}
.ebs-st{display:inline-block;padding:1px 7px;border-radius:4px;font-size:12px;font-weight:600;white-space:nowrap}
.ebs-st.is-open{background:#e4f6ef;color:#0e9f6e}.ebs-st.is-next{background:#eaf0fa;color:#1d3c78}
.ebs-muted{color:#8a94a3}.ebs-err{color:#b42318}
.ebs-inline form{display:inline}
.ebs-filter{margin:12px 0}
.ebs-ref{border-collapse:collapse;margin:12px 0;max-width:960px}.ebs-ref th{text-align:left;padding:6px 16px 6px 0;color:#4b5565;font-weight:600;white-space:nowrap;vertical-align:top}.ebs-ref td{padding:6px 0}
.ebs-chk{margin-right:12px;white-space:nowrap}
.ebs-actions details summary{cursor:pointer;color:#2271b1}
.ebs-actions details form{margin-top:6px}
.ebs-pages a,.ebs-pages strong{display:inline-block;padding:2px 6px}
.ebs-hidden{margin-top:20px}
</style>';
}
