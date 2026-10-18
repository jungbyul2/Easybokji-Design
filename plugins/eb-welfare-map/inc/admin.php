<?php
/**
 * 관리자: 복지지도 (관리자 메뉴 '복지지도')
 *   상태     공개 전환 · 원본 갱신 상태(멈춤·오류) · 적용 범위 통계 · 캐시 새로
 *   검수     적용 지역 확인 필요 · 옛 지역 이름 · 중복 후보 · 원문 오래됨 · 검수한 것 · 사라진 사업 · 확인 기간 지남
 *            → 적용 범위(시·도 전체/시·군·구/숨김), 신청 상태(상시/기간/마감 + 근거 링크), 대상·혜택 한 줄, 캘린더 일정·정리 글 연결
 *   지역 코드표  시·도/시·군·구 코드, 옛 이름, 맞춤 찾기·캘린더 지역 이름과 대조
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	$d     = ebm_data();
	$n     = isset( $d['st']['sc']['check'] ) ? (int) $d['st']['sc']['check'] : 0;
	$badge = $n ? ' <span class="awaiting-mod">' . number_format_i18n( $n ) . '</span>' : '';
	add_menu_page( '우리 지역 복지지도', '복지지도' . $badge, 'manage_options', 'ebm', 'ebm_admin_page', 'dashicons-location-alt', 27 );
} );

function ebm_admin_url( $args = array() ) {
	return add_query_arg( array_merge( array( 'page' => 'ebm' ), $args ), admin_url( 'admin.php' ) );
}

function ebm_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$tab  = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'status'; // phpcs:ignore
	$tabs = array( 'status' => '상태', 'review' => '검수', 'regions' => '지역 코드표' );
	echo '<div class="wrap ebm-admin"><h1>우리 지역 복지지도</h1>';
	ebm_admin_style();
	if ( isset( $_GET['ebm_msg'] ) ) { // phpcs:ignore
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( sanitize_text_field( wp_unslash( $_GET['ebm_msg'] ) ) ) . '</p></div>'; // phpcs:ignore
	}
	echo '<nav class="nav-tab-wrapper">';
	foreach ( $tabs as $k => $l ) {
		printf( '<a class="nav-tab%s" href="%s">%s</a>', $tab === $k ? ' nav-tab-active' : '', esc_url( ebm_admin_url( array( 'tab' => $k ) ) ), esc_html( $l ) );
	}
	echo '</nav>';
	if ( 'review' === $tab ) {
		ebm_tab_review();
	} elseif ( 'regions' === $tab ) {
		ebm_tab_regions();
	} else {
		ebm_tab_status();
	}
	echo '</div>';
}

function ebm_form( $do, $hidden = array() ) {
	$h = '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="ebm_save"><input type="hidden" name="do" value="' . esc_attr( $do ) . '">'
		. '<input type="hidden" name="back" value="' . esc_attr( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ebm_admin_url() ) . '">' . wp_nonce_field( 'ebm', '_wpnonce', true, false );
	foreach ( $hidden as $k => $v ) {
		$h .= '<input type="hidden" name="' . esc_attr( $k ) . '" value="' . esc_attr( $v ) . '">';
	}
	return $h;
}

/* 상태 ------------------------------------------------------------------------------- */
function ebm_tab_status() {
	$d   = ebm_data();
	$f   = ebm_freshness();
	$pub = ebm_is_public();
	$pid = ebm_page_id();
	echo '<h2>공개</h2><p>' . ( $pub ? '<strong style="color:#00a32a">방문자에게 공개 중</strong>' : '<strong style="color:#b32d2e">관리자 미리 보기</strong> (방문자에게는 페이지·메뉴·홈 진입점·API가 보이지 않음)' ) . '</p>';
	echo '<p>페이지: ' . ( $pid ? '<a href="' . esc_url( get_permalink( $pid ) ) . '" target="_blank">' . esc_html( get_permalink( $pid ) ) . '</a> · <a href="' . esc_url( get_edit_post_link( $pid ) ) . '">편집</a>' : '없음' ) . '</p>';
	echo ebm_form( 'public', array( 'on' => $pub ? 0 : 1 ) ) . '<button class="button ' . ( $pub ? '' : 'button-primary' ) . '">' . ( $pub ? '다시 관리자만 보기로' : '방문자에게 공개하기' ) . '</button></form>'; // phpcs:ignore
	echo '<p class="description">공개하면 페이지가 \'공개\'로 바뀌고 WP Rocket 캐시를 모두 비워요(홈·메뉴 진입점이 모든 페이지에 있어서).</p>';

	echo '<h2>원본 자료</h2><table class="widefat striped" style="max-width:900px"><tbody>';
	echo '<tr><th>지역(지자체) 서비스</th><td>' . number_format_i18n( $d['st']['L'] ) . '건 · 받은 때 ' . esc_html( $f['local'] ? wp_date( 'Y.m.d H:i', $f['local'] ) : '없음' ) . '</td></tr>';
	echo '<tr><th>중앙부처 서비스(전국 공통)</th><td>' . number_format_i18n( $d['st']['C'] ) . '건 · 받은 때 ' . esc_html( $f['central'] ? wp_date( 'Y.m.d H:i', $f['central'] ) : '없음' ) . '</td></tr>';
	echo '<tr><th>갱신</th><td>' . ( $f['stale'] ? '<strong style="color:#b32d2e">36시간 넘게 새 자료를 받지 못했어요.</strong> 설정 > 복지서비스 API에서 확인해 주세요. 화면은 마지막 자료를 보여 주고 받은 날을 그대로 표시해요.' : '정상' ) . ( $f['err'] ? '<br><span style="color:#b32d2e">최근 오류: ' . esc_html( $f['err'] ) . '</span>' : '' ) . '</td></tr>';
	$raw = (array) get_option( 'eb_ws_local_raw1', array() );
	$sample = (array) get_option( 'eb_ws_local', array() );
	$sample = $sample ? reset( $sample ) : array();
	echo '<tr><th>원문 수정일·ID 저장</th><td>' . ( isset( $sample['m'] ) ? '저장됨(테마 56번 보강 적용)' : '<span style="color:#b32d2e">아직 없음</span> - 테마 56번 보강 후 다음 받기부터 저장돼요. 그 전에는 서비스 ID는 주소에서 읽고, 원문 수정일은 \'정보 없음\'으로 보여요.' ) . ( $raw ? '<br><small>원본 응답 항목: ' . esc_html( implode( ', ', array_keys( $raw ) ) ) . '</small>' : '' ) . '</td></tr>';
	echo '<tr><th>복지 캘린더 연결</th><td>' . ( function_exists( 'ebs_items' ) ? '확인된 일정 ' . count( array_filter( ebm_cal_items(), 'ebm_cal_confirmed' ) ) . '건 사용 가능' : '<span style="color:#b32d2e">eb-schedule 플러그인이 꺼져 있어요</span>' ) . '</td></tr>';
	echo '</tbody></table>';

	$names = array( 'nation' => '전국 공통', 'sido' => '시·도 전체', 'sgg' => '시·군·구 하나', 'multi' => '여러 시·군·구', 'legacy' => '옛 지역 이름', 'check' => '적용 지역 확인 필요', 'hide' => '지도에서 숨김' );
	echo '<h2>적용 범위</h2><table class="widefat striped" style="max-width:900px"><thead><tr><th>범위</th><th>건수</th><th></th></tr></thead><tbody>';
	foreach ( $names as $k => $l ) {
		$n = isset( $d['st']['sc'][ $k ] ) ? $d['st']['sc'][ $k ] : 0;
		$q = array( 'check' => 'check', 'legacy' => 'legacy', 'hide' => 'reviewed' );
		echo '<tr><td>' . esc_html( $l ) . '</td><td>' . number_format_i18n( $n ) . '</td><td>' . ( isset( $q[ $k ] ) && $n ? '<a href="' . esc_url( ebm_admin_url( array( 'tab' => 'review', 'q' => $q[ $k ] ) ) ) . '">검수 목록 ›</a>' : '' ) . '</td></tr>';
	}
	echo '<tr><td>중복 후보(이름·기관·지역 같고 ID 다름)</td><td>' . count( $d['dup'] ) . '묶음</td><td>' . ( $d['dup'] ? '<a href="' . esc_url( ebm_admin_url( array( 'tab' => 'review', 'q' => 'dup' ) ) ) . '">검수 목록 ›</a>' : '' ) . '</td></tr>';
	echo '</tbody></table><p class="description">같은 서비스 ID는 한 건으로만 세요. 이름만 같은 것은 자동으로 합치지 않아요(지역마다 따로 하는 같은 이름 사업이 많아서).</p>';
	echo ebm_form( 'flush' ) . '<p><button class="button">계산 다시 하기(캐시 비우기)</button></p></form>'; // phpcs:ignore
}

/* 검수 ------------------------------------------------------------------------------- */
function ebm_review_queue( $q, $sd, $s ) {
	$d    = ebm_data();
	$rev  = ebm_review_all();
	$out  = array();
	$t    = current_time( 'Y-m-d' );
	$old  = gmdate( 'Y-m-d', strtotime( $t . ' -540 days' ) );
	if ( 'gone' === $q ) {
		foreach ( $rev as $id => $rv ) {
			if ( ! isset( $d['items'][ $id ] ) ) {
				$out[] = array( 'i' => $id, 'gone' => true, 'rv' => $rv );
			}
		}
		return $out;
	}
	$dupset = array();
	foreach ( $d['dup'] as $grp ) {
		foreach ( $grp as $id ) {
			$dupset[ $id ] = $grp;
		}
	}
	foreach ( $d['items'] as $id => $it ) {
		if ( 'L' !== $it['k'] && ! in_array( $q, array( 'all', 'reviewed', 'ended' ), true ) ) {
			continue;
		}
		if ( $sd && $it['sd'] !== $sd ) {
			continue;
		}
		if ( '' !== $s && false === mb_stripos( $it['n'] . ' ' . $it['o'] . ' ' . $id, $s ) ) {
			continue;
		}
		$rv = isset( $rev[ $id ] ) ? $rev[ $id ] : null;
		switch ( $q ) {
			case 'check':
				$ok = 'check' === $it['sc'];
				break;
			case 'legacy':
				$ok = 'legacy' === $it['sc'] || ( isset( $it['auto']['sc'] ) && 'legacy' === $it['auto']['sc'] );
				break;
			case 'dup':
				$ok = isset( $dupset[ $id ] );
				break;
			case 'old':
				$ok = $it['m'] && $it['m'] < $old;
				break;
			case 'noid':
				$ok = 'X' === $id[0] || ! $it['u'];
				break;
			case 'reviewed':
				$ok = (bool) $rv;
				break;
			case 'ended':
				$ok = $rv && isset( $rv['st'] ) && 'period' === $rv['st'] && ! empty( $rv['e'] ) && $rv['e'] < $t;
				break;
			default:
				$ok = true;
		}
		if ( $ok ) {
			$out[] = array( 'i' => $id, 'it' => $it, 'rv' => $rv, 'dup' => isset( $dupset[ $id ] ) ? $dupset[ $id ] : null );
		}
	}
	if ( 'dup' === $q ) {
		usort( $out, function ( $a, $b ) {
			return strcmp( $a['it']['n'] . $a['it']['sd'], $b['it']['n'] . $b['it']['sd'] );
		} );
	}
	return $out;
}

/** 캘린더 일정 추천(이름이 겹치는 순 - 추천만, 연결은 관리자가 고름) */
function ebm_cal_suggest( $name, $sd = '', $n = 3 ) {
	$split = '/[\s·ㆍ()\[\]\-|–,.:]+/u';
	$stop  = '/^(20\d\d|지원|지원금|지원사업|사업|신청|서비스|대상|안내|및|등|복지|가구)$/u';
	$words = array_filter( preg_split( $split, (string) $name ), function ( $w ) use ( $stop ) {
		return mb_strlen( $w ) >= 2 && ! preg_match( $stop, $w );
	} );
	$out = array();
	foreach ( ebm_cal_items() as $key => $x ) {
		$sc = 0;
		foreach ( $words as $w ) {
			if ( false !== mb_strpos( $x['name'], $w ) ) {
				$sc += mb_strlen( $w );
			}
		}
		if ( $sd && ! empty( $x['local'] ) && ebm_sd_code( $x['sd'] ) !== $sd ) {
			$sc = 0;
		}
		if ( $sc >= 3 ) {
			$out[ $key ] = $sc;
		}
	}
	arsort( $out );
	return array_slice( array_keys( $out ), 0, $n );
}

function ebm_tab_review() {
	$q   = isset( $_GET['q'] ) ? sanitize_key( wp_unslash( $_GET['q'] ) ) : 'check'; // phpcs:ignore
	$sd  = isset( $_GET['sd'] ) ? preg_replace( '/\D/', '', wp_unslash( $_GET['sd'] ) ) : ''; // phpcs:ignore
	$s   = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore
	$pg  = max( 1, isset( $_GET['pg'] ) ? (int) $_GET['pg'] : 1 ); // phpcs:ignore
	$qs  = array( 'check' => '적용 지역 확인 필요', 'legacy' => '옛 지역 이름', 'dup' => '중복 후보', 'old' => '원문 오래됨(1년 반+)', 'noid' => 'ID·주소 없음', 'reviewed' => '검수한 것', 'ended' => '확인 기간 지남', 'gone' => '사라진 사업', 'all' => '전체' );
	$list = ebm_review_queue( $q, $sd, $s );
	echo '<form method="get" class="ebm-filter"><input type="hidden" name="page" value="ebm"><input type="hidden" name="tab" value="review"><select name="q">';
	foreach ( $qs as $k => $l ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $q, $k, false ), esc_html( $l ) );
	}
	echo '</select> <select name="sd"><option value="">모든 시·도</option>';
	foreach ( ebm_regions()['sido'] as $x ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $x['id'] ), selected( $sd, $x['id'], false ), esc_html( $x['n'] ) );
	}
	echo '</select> <input type="search" name="s" value="' . esc_attr( $s ) . '" placeholder="이름·기관·ID"> <button class="button">보기</button> <span class="ebm-muted">' . number_format_i18n( count( $list ) ) . '건</span></form>';
	$help = array(
		'check'  => '복지로 원문에 시·군·구가 비었는데 기관·사업 이름에 시·군·구가 보이거나(가평군 교복 등), 통합 전 지역(옛 광주광역시·전라남도) 기준일 수 있는 사업이에요. 원문을 열어 대상 지역을 확인한 뒤 정해 주세요. \'추천\'은 기관 이름에서 읽은 것이라 그대로 믿지 말고 원문과 대조해 주세요.',
		'legacy' => '2026년 7월 인천 구 재편 전 이름(중구·동구·서구)으로 등록된 사업이에요. 지금은 새 구들에 함께 보이고 \'옛 지역\' 안내가 붙어요. 원문이 고쳐지면 자동으로 정리돼요.',
		'dup'    => '이름·기관·지역이 같은데 서비스 ID가 다른 사업이에요. 자동으로 합치지 않아요. 같은 사업이면 하나를 \'지도에서 숨김\'으로 두세요.',
		'gone'   => '검수 기록은 있는데 복지로 자료에서 사라진 사업이에요. 지도에는 나오지 않아요. 기록을 지워도 돼요.',
		'ended'  => '이지복지가 확인한 신청 기간이 끝났어요. 지도에는 \'마감\'으로 보여요. 다음 공고가 나왔는지 확인해 주세요.',
	);
	if ( isset( $help[ $q ] ) ) {
		echo '<p class="description" style="max-width:980px">' . esc_html( $help[ $q ] ) . '</p>';
	}
	$per   = 30;
	$rows  = array_slice( $list, ( $pg - 1 ) * $per, $per );
	$pages = max( 1, (int) ceil( count( $list ) / $per ) );
	if ( ! $rows ) {
		echo '<p>목록이 비어 있어요.</p>';
		return;
	}
	echo '<table class="widefat striped ebm-table"><thead><tr><th style="width:34%">사업</th><th>원문 지역 → 지금 판정</th><th>신청 상태</th><th style="width:30%">검수</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		echo ebm_review_row( $row ); // phpcs:ignore
	}
	echo '</tbody></table>';
	if ( $pages > 1 ) {
		echo '<p class="ebm-pages">';
		for ( $i = 1; $i <= $pages; $i++ ) {
			echo $i === $pg ? '<strong>' . $i . '</strong> ' : '<a href="' . esc_url( ebm_admin_url( array( 'tab' => 'review', 'q' => $q, 'sd' => $sd, 's' => $s, 'pg' => $i ) ) ) . '">' . $i . '</a> '; // phpcs:ignore
		}
		echo '</p>';
	}
}

function ebm_review_row( $row ) {
	$id = $row['i'];
	$rv = (array) $row['rv'];
	if ( ! empty( $row['gone'] ) ) {
		return '<tr><td><strong>' . esc_html( $id ) . '</strong><br><small>' . esc_html( isset( $rv['memo'] ) ? $rv['memo'] : '' ) . '</small></td><td colspan="2">복지로 자료에 없음 · 검수 ' . esc_html( isset( $rv['chk'] ) ? $rv['chk'] : '' ) . '</td><td>' . ebm_form( 'forget', array( 'id' => $id ) ) . '<button class="button button-small">기록 지우기</button></form></td></tr>';
	}
	$it   = $row['it'];
	$labs = array( 'nation' => '전국 공통', 'sido' => '시·도 전체', 'sgg' => '시·군·구', 'multi' => '여러 시·군·구', 'legacy' => '옛 지역', 'check' => '확인 필요', 'hide' => '숨김' );
	$why  = array( 'sg-missing' => '원문 시·군·구 빈칸 + 시·군·구 기관·이름', 'merged' => '통합 전 지역 기준 가능', 'sg-unknown' => '코드표에 없는 시·군·구', 'sd-unknown' => '코드표에 없는 시·도', 'old-name' => '옛 이름', 'edu' => '교육청', 'review' => '관리자 검수', 'empty' => '지역 없음' );
	$h    = '<tr id="ebm-' . esc_attr( $id ) . '"><td><strong>' . esc_html( $it['n'] ) . '</strong><br><small>' . esc_html( $it['o'] ) . '</small><br><small class="ebm-muted">' . esc_html( $id ) . ( $it['m'] ? ' · 복지로 수정 ' . esc_html( $it['m'] ) : '' ) . '</small>'
		. ( $it['u'] ? '<br><a href="' . esc_url( $it['u'] ) . '" target="_blank" rel="noopener">복지로 원문 ↗</a>' : '' ) . ( $row['dup'] ? '<br><span class="ebm-tag">중복 후보: ' . esc_html( implode( ', ', array_diff( $row['dup'], array( $id ) ) ) ) . '</span>' : '' ) . '</td>';
	$raw  = isset( $it['raw'] ) ? $it['raw'] : array( '', '' );
	$h   .= '<td><small>원문</small> ' . esc_html( trim( $raw[0] . ' / ' . ( '' === $raw[1] ? '(빈칸)' : $raw[1] ) ) ) . '<br><small>판정</small> <b>' . esc_html( $labs[ $it['sc'] ] ) . '</b> ' . esc_html( ebm_area_label( $it ) ) . ( $it['why'] && isset( $why[ $it['why'] ] ) ? '<br><small class="ebm-muted">' . esc_html( $why[ $it['why'] ] ) . '</small>' : '' );
	if ( isset( $it['auto'] ) ) {
		$h .= '<br><small class="ebm-muted">자동 판정은 ' . esc_html( $labs[ $it['auto']['sc'] ] ) . '</small>';
	}
	$h   .= '</td>';
	$st   = ebm_status( $id );
	$sl   = ebm_status_labels();
	$h   .= '<td>' . esc_html( $sl[ ebm_status_now( $st ) ] ) . ( 'period' === $st['k'] ? '<br><small>' . esc_html( $st['s'] . ' ~ ' . $st['e'] ) . ' (' . ( 'cal' === $st['src'] ? '캘린더' : '확인' ) . ')</small>' : '' ) . ( ! empty( $st['chk'] ) ? '<br><small class="ebm-muted">확인 ' . esc_html( $st['chk'] ) . '</small>' : '' ) . '</td>';

	// 빠른 버튼(확인 필요): 시·도 전체 / 추천 시·군·구 - 원문 확인 후 누르기
	$quick = '';
	if ( 'L' === $it['k'] && $it['sd'] && in_array( $it['sc'], array( 'check', 'legacy' ), true ) ) {
		$quick .= ebm_form( 'scope', array( 'id' => $id, 'sc' => 'sido' ) ) . '<button class="button button-small">' . esc_html( ebm_sido( $it['sd'] )['s'] ) . ' 전체로 확인</button></form> ';
		foreach ( ebm_mentioned_sgg( $it['sd'], $it['n'], $it['o'] ) as $gid ) {
			$quick .= ebm_form( 'scope', array( 'id' => $id, 'sc' => 'sgg', 'r' => $gid ) ) . '<button class="button button-small">추천: ' . esc_html( ebm_sgg( $gid )['n'] ) . '만</button></form> ';
		}
	}
	// 자세히 검수
	$sd    = $it['sd'];
	$cur_r = isset( $rv['r'] ) ? (array) $rv['r'] : ( in_array( $it['sc'], array( 'sgg', 'multi', 'legacy' ), true ) ? $it['r'] : array() );
	$opts  = '';
	if ( $sd && ebm_sido( $sd ) ) {
		foreach ( ebm_sido( $sd )['g'] as $g ) {
			$opts .= '<label class="ebm-chk"><input type="checkbox" name="r[]" value="' . esc_attr( $g['id'] ) . '"' . checked( in_array( $g['id'], $cur_r, true ), true, false ) . '>' . esc_html( $g['n'] ) . '</label>';
		}
	}
	$cal_opts = '<option value="">연결 안 함</option>';
	$cal      = ebm_cal_items();
	$sug      = ebm_cal_suggest( $it['n'], $sd );
	$cur_cal  = isset( $rv['cal'] ) ? $rv['cal'] : '';
	foreach ( array_unique( array_merge( $cur_cal ? array( $cur_cal ) : array(), $sug ) ) as $k ) {
		if ( isset( $cal[ $k ] ) ) {
			$x         = $cal[ $k ];
			$cal_opts .= '<option value="' . esc_attr( $k ) . '"' . selected( $cur_cal, $k, false ) . '>' . esc_html( ( in_array( $k, $sug, true ) ? '추천 · ' : '' ) . $x['name'] . ' (' . $x['s'] . '~' . $x['e'] . ( ebm_cal_confirmed( $x ) ? '' : ', 캘린더 검수 대기' ) . ')' ) . '</option>';
		} elseif ( $k === $cur_cal ) {
			$cal_opts .= '<option value="' . esc_attr( $k ) . '" selected>' . esc_html( $k ) . ' (지금 캘린더에 없음)</option>';
		}
	}
	$v   = function ( $k ) use ( $rv ) {
		return isset( $rv[ $k ] ) ? ( is_array( $rv[ $k ] ) ? implode( ',', $rv[ $k ] ) : (string) $rv[ $k ] ) : '';
	};
	$sc  = $v( 'sc' ) ? $v( 'sc' ) : 'auto';
	$stv = $v( 'st' );
	$det = ebm_form( 'review', array( 'id' => $id ) )
		. ( 'L' === $it['k'] ? '<p><b>적용 범위</b><br><select name="sc"><option value="auto"' . selected( $sc, 'auto', false ) . '>자동 판정 그대로</option><option value="sido"' . selected( $sc, 'sido', false ) . '>시·도 전체</option><option value="sgg"' . selected( $sc, 'sgg', false ) . '>아래 시·군·구만</option><option value="hide"' . selected( $sc, 'hide', false ) . '>지도에서 숨김(중복·종료 등)</option></select></p>' . ( $opts ? '<div class="ebm-sgs">' . $opts . '</div>' : '' ) : '<p class="ebm-muted">전국 공통 사업은 적용 범위를 바꾸지 않아요.</p>' )
		. '<p><b>신청 상태</b> <small>(공식 공고로 확인한 것만)</small><br><select name="st"><option value=""' . selected( $stv, '', false ) . '>모름(기간 확인 필요)</option><option value="always"' . selected( $stv, 'always', false ) . '>상시 신청</option><option value="period"' . selected( $stv, 'period', false ) . '>기간 있음</option><option value="closed"' . selected( $stv, 'closed', false ) . '>올해 마감</option></select> '
		. '<input type="date" name="s" value="' . esc_attr( $v( 's' ) ) . '" aria-label="시작일"> ~ <input type="date" name="e" value="' . esc_attr( $v( 'e' ) ) . '" aria-label="마감일"></p>'
		. '<p><input type="url" name="src" class="large-text" placeholder="근거 공고 주소(시·군·구 공고·복지로 등)" value="' . esc_attr( $v( 'src' ) ) . '"></p>'
		. '<p><b>복지 캘린더 일정 연결</b><br><select name="cal" style="max-width:100%">' . $cal_opts . '</select><br><small class="ebm-muted">추천은 이름이 겹치는 일정이에요. 같은 사업일 때만 연결해 주세요(캘린더에서 \'노출 중\'인 일정만 기간이 지도에 반영돼요).</small></p>'
		. '<p><input type="text" name="tg" class="large-text" placeholder="대상 한 줄(비우면 생애주기·가구 상황)" value="' . esc_attr( $v( 'tg' ) ) . '"></p>'
		. '<p><input type="text" name="bn" class="large-text" placeholder="혜택 한 줄(예: 1인당 40만원 교복 현물)" value="' . esc_attr( $v( 'bn' ) ) . '"></p>'
		. '<p><input type="text" name="post" class="regular-text" placeholder="쉽게 읽는 안내 글 번호(쉼표)" value="' . esc_attr( $v( 'post' ) ) . '"></p>'
		. '<p><input type="text" name="memo" class="large-text" placeholder="메모(관리자만)" value="' . esc_attr( $v( 'memo' ) ) . '"></p>'
		. '<p><button class="button button-primary">저장</button> ' . ( $rv ? '<label><input type="checkbox" name="clear" value="1"> 검수 기록 지우기</label>' : '' ) . '</p></form>';
	$h .= '<td>' . ( $quick ? '<div class="ebm-quick">' . $quick . '</div>' : '' ) . '<details' . ( $rv ? '' : '' ) . '><summary>자세히 검수' . ( $rv ? ' (검수함)' : '' ) . '</summary>' . $det . '</details></td></tr>';
	return $h;
}

/* 지역 코드표 -------------------------------------------------------------------------- */
function ebm_tab_regions() {
	$r = ebm_regions();
	echo '<p>기준: ' . esc_html( $r['src'] ) . ' · 판 ' . esc_html( $r['ver'] ) . ' · 시·도 ' . count( $r['sido'] ) . ' · 시·군·구 ' . array_sum( array_map( function ( $s ) {
		return count( $s['g'] );
	}, $r['sido'] ) ) . '(일반구는 시 하나로, 세종은 단층)</p>';
	// 맞춤 찾기(복지로 지역 데이터)·캘린더 지역 이름과 대조
	$miss = array();
	foreach ( function_exists( 'eb_ws_regions' ) ? eb_ws_regions() : array() as $sdn => $sgs ) {
		$code = ebm_sd_code( $sdn );
		if ( ! $code ) {
			$miss[] = array( '맞춤 찾기', $sdn, '', '시·도 이름을 코드표에서 못 찾음' );
			continue;
		}
		foreach ( $sgs as $sg => $n ) {
			if ( '' === $sg || ebm_sg_id( $code, $sg ) || '36' === $code ) {
				continue;
			}
			$al     = ebm_sg_alias( $code, $sg );
			$miss[] = array( '맞춤 찾기', $sdn, $sg . ' (' . $n . '건)', $al ? '옛 이름 → ' . implode( '·', array_map( function ( $id ) {
				return ebm_sgg( $id )['n'];
			}, $al['to'] ) ) : '코드표에 없음 - 확인 필요' );
		}
	}
	foreach ( function_exists( 'ebs_region_options' ) ? ebs_region_options() : array() as $sdn => $sgs ) {
		$code = ebm_sd_code( $sdn );
		if ( ! $code ) {
			$miss[] = array( '복지 캘린더', $sdn, '', '시·도 이름을 코드표에서 못 찾음' );
			continue;
		}
		foreach ( $sgs as $sg ) {
			if ( ! ebm_sg_id( $code, $sg ) && '36' !== $code ) {
				$al     = ebm_sg_alias( $code, $sg );
				$miss[] = array( '복지 캘린더', $sdn, $sg, $al ? '옛 이름' : '코드표에 없음 - 확인 필요' );
			}
		}
	}
	echo '<h2>다른 기능의 지역 이름과 대조</h2>';
	if ( $miss ) {
		echo '<table class="widefat striped" style="max-width:900px"><thead><tr><th>어디</th><th>시·도</th><th>시·군·구</th><th>결과</th></tr></thead><tbody>';
		foreach ( $miss as $m ) {
			echo '<tr><td>' . esc_html( $m[0] ) . '</td><td>' . esc_html( $m[1] ) . '</td><td>' . esc_html( $m[2] ) . '</td><td>' . esc_html( $m[3] ) . '</td></tr>';
		}
		echo '</tbody></table>';
	} else {
		echo '<p>모두 일치해요.</p>';
	}
	echo '<h2>옛 이름</h2><ul>';
	foreach ( $r['sdAlias'] as $n => $c ) {
		echo '<li>' . esc_html( $n ) . ' → ' . esc_html( ebm_sido( (string) $c )['n'] ) . '</li>';
	}
	foreach ( $r['sgAlias'] as $a ) {
		echo '<li>' . esc_html( ebm_sido( $a['sd'] )['n'] . ' ' . $a['n'] ) . ' → ' . esc_html( implode( '·', array_map( function ( $id ) {
			return ebm_sgg( $id )['n'] . '(' . $id . ')';
		}, $a['to'] ) ) ) . ' <small>' . esc_html( $a['note'] ) . '</small></li>';
	}
	echo '</ul><h2>코드</h2><table class="widefat striped"><thead><tr><th>시·도</th><th>시·군·구 (코드)</th></tr></thead><tbody>';
	foreach ( $r['sido'] as $s ) {
		echo '<tr><td><b>' . esc_html( $s['n'] ) . '</b><br><small>' . esc_html( $s['id'] ) . '</small></td><td><small>' . esc_html( implode( ' · ', array_map( function ( $g ) {
			return $g['n'] . ' ' . $g['id'];
		}, $s['g'] ) ) ) . '</small></td></tr>';
	}
	echo '</tbody></table>';
}

/* 저장 ------------------------------------------------------------------------------- */
add_action( 'admin_post_ebm_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '권한이 없습니다.' );
	}
	check_admin_referer( 'ebm' );
	$do   = isset( $_POST['do'] ) ? sanitize_key( wp_unslash( $_POST['do'] ) ) : '';
	$back = isset( $_POST['back'] ) ? esc_url_raw( wp_unslash( $_POST['back'] ) ) : ebm_admin_url();
	$id   = isset( $_POST['id'] ) ? preg_replace( '/[^A-Za-z0-9]/', '', wp_unslash( $_POST['id'] ) ) : '';
	$msg  = '저장했어요.';
	$rev  = ebm_review_all();
	$date = function ( $k ) {
		$v = isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : ''; // phpcs:ignore
		return preg_match( '/^\d{4}-\d{2}-\d{2}$/', $v ) ? $v : '';
	};
	switch ( $do ) {
		case 'public':
			ebm_set_public( ! empty( $_POST['on'] ) );
			$msg = ! empty( $_POST['on'] ) ? '방문자에게 공개했어요.' : '관리자만 보기로 바꿨어요.';
			break;
		case 'flush':
			$msg = '다시 계산하도록 캐시를 비웠어요.';
			break;
		case 'forget':
			unset( $rev[ $id ] );
			update_option( 'ebm_review', $rev, false );
			$msg = '기록을 지웠어요.';
			break;
		case 'scope':
			$sc          = isset( $_POST['sc'] ) ? sanitize_key( wp_unslash( $_POST['sc'] ) ) : '';
			$rv          = isset( $rev[ $id ] ) ? (array) $rev[ $id ] : array();
			$rv['sc']    = in_array( $sc, array( 'sido', 'sgg', 'hide' ), true ) ? $sc : 'auto';
			$rv['r']     = 'sgg' === $sc && ! empty( $_POST['r'] ) ? array( preg_replace( '/\D/', '', wp_unslash( $_POST['r'] ) ) ) : array();
			$rv['chk']   = current_time( 'Y-m-d' );
			$rv['by']    = get_current_user_id();
			$rev[ $id ]  = $rv;
			update_option( 'ebm_review', $rev, false );
			break;
		case 'review':
			if ( ! empty( $_POST['clear'] ) ) {
				unset( $rev[ $id ] );
				update_option( 'ebm_review', $rev, false );
				$msg = '검수 기록을 지웠어요.';
				break;
			}
			$sc = isset( $_POST['sc'] ) ? sanitize_key( wp_unslash( $_POST['sc'] ) ) : 'auto';
			$st = isset( $_POST['st'] ) ? sanitize_key( wp_unslash( $_POST['st'] ) ) : '';
			$rv = array(
				'sc'   => in_array( $sc, array( 'auto', 'sido', 'sgg', 'hide' ), true ) ? $sc : 'auto',
				'r'    => array_values( array_filter( array_map( function ( $x ) {
					return preg_replace( '/\D/', '', $x );
				}, isset( $_POST['r'] ) ? (array) wp_unslash( $_POST['r'] ) : array() ), 'ebm_sgg' ) ),
				'st'   => in_array( $st, array( 'always', 'period', 'closed' ), true ) ? $st : '',
				's'    => $date( 's' ),
				'e'    => $date( 'e' ),
				'src'  => isset( $_POST['src'] ) ? esc_url_raw( wp_unslash( $_POST['src'] ) ) : '',
				'cal'  => isset( $_POST['cal'] ) ? sanitize_text_field( wp_unslash( $_POST['cal'] ) ) : '',
				'tg'   => isset( $_POST['tg'] ) ? sanitize_text_field( wp_unslash( $_POST['tg'] ) ) : '',
				'bn'   => isset( $_POST['bn'] ) ? sanitize_text_field( wp_unslash( $_POST['bn'] ) ) : '',
				'post' => array_values( array_filter( array_map( 'absint', explode( ',', isset( $_POST['post'] ) ? sanitize_text_field( wp_unslash( $_POST['post'] ) ) : '' ) ) ) ),
				'memo' => isset( $_POST['memo'] ) ? sanitize_text_field( wp_unslash( $_POST['memo'] ) ) : '',
				'chk'  => current_time( 'Y-m-d' ),
				'by'   => get_current_user_id(),
			);
			if ( 'sgg' === $rv['sc'] && ! $rv['r'] ) {
				$rv['sc'] = 'auto';
				$msg      = '시·군·구를 고르지 않아 적용 범위는 자동 판정 그대로 두었어요. 나머지는 저장했어요.';
			}
			if ( 'period' === $rv['st'] && ! $rv['e'] ) {
				$rv['st'] = '';
				$msg      = '마감일이 없어 신청 상태는 \'모름\'으로 두었어요(기간을 모르는 사업을 접수 중으로 보이지 않게). 나머지는 저장했어요.';
			}
			if ( 'period' === $rv['st'] && $rv['s'] && $rv['s'] > $rv['e'] ) {
				$rv['st'] = '';
				$msg      = '시작일이 마감일보다 늦어 신청 상태는 저장하지 않았어요.';
			}
			if ( in_array( $rv['st'], array( 'always', 'period', 'closed' ), true ) && ! $rv['src'] ) {
				$msg .= ' 근거 공고 주소도 넣어 두면 다음 검수 때 편해요.';
			}
			$rev[ $id ] = $rv;
			update_option( 'ebm_review', $rev, false );
			break;
	}
	ebm_flush_cache();
	wp_safe_redirect( add_query_arg( 'ebm_msg', rawurlencode( $msg ), $back ) . ( $id ? '#ebm-' . $id : '' ) );
	exit;
} );

function ebm_admin_style() {
	echo '<style>.ebm-admin .ebm-filter{margin:12px 0}.ebm-muted{color:#646970}.ebm-table td{vertical-align:top}.ebm-table details summary{cursor:pointer;color:#2271b1;font-weight:600}.ebm-sgs{display:flex;flex-wrap:wrap;gap:2px 10px;max-height:150px;overflow:auto;padding:6px;border:1px solid #dcdcde;background:#fff}.ebm-chk{font-size:12px;white-space:nowrap}.ebm-quick{display:flex;flex-wrap:wrap;gap:4px;margin-bottom:6px}.ebm-quick form{display:inline}.ebm-tag{display:inline-block;margin-top:3px;padding:1px 6px;font-size:11px;background:#fcf0f1;color:#8a2424;border-radius:3px}.ebm-pages a,.ebm-pages strong{display:inline-block;min-width:22px;text-align:center}</style>'; // phpcs:ignore
}
