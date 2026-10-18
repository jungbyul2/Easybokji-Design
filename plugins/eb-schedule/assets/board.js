(function () {
	var DAY = 864e5, W = ['일', '월', '화', '수', '목', '금', '토'];
	function d0(s) { var p = s.split('-'); return new Date(+p[0], p[1] - 1, +p[2]); }
	function today() { var n = new Date(); return new Date(n.getFullYear(), n.getMonth(), n.getDate()); }
	function ymd(d) { return d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d.getDate()).slice(-2); }
	function md(d) { return (d.getMonth() + 1) + '.' + d.getDate() + '(' + W[d.getDay()] + ')'; }
	function esc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
	function all(root, sel) { return [].slice.call(root.querySelectorAll(sel)); }

	// ── 우리 지역: 이 보드에서 고른 것(ebs_region)과 맞춤 찾기(eb_finder_last v2) 중 나중 것
	function normSd(s) { return String(s || '').replace(/\s+/g, '').replace(/(특별자치도|특별자치시|특별시|광역시|도)$/, ''); }
	function shortSd(s) { return String(s || '').replace(/(특별자치시|특별자치도|특별시|광역시)$/, '').replace(/^(충청|전라|경상)(남|북)도$/, function (m, a, b) { return a.charAt(0) + b; }).replace(/^경기도$/, '경기'); }
	function getRegion() {
		var a = null, b = null;
		try { a = JSON.parse(localStorage.getItem('ebs_region') || 'null'); } catch (e) {}
		try { var f = JSON.parse(localStorage.getItem('eb_finder_last') || 'null'); if (f && f.v === 2 && f.sd) { b = { sd: f.sd, sg: f.sg || '', at: f.at || 0 }; } } catch (e) {}
		var r = a && b ? ((a.at || 0) >= (b.at || 0) ? a : b) : (a || b);
		return r && r.sd ? r : null;
	}
	function setRegion(r) {
		try { localStorage.setItem('ebs_region', JSON.stringify(r ? { sd: r.sd, sg: r.sg || '', at: Date.now() } : { sd: '', sg: '', at: Date.now() })); } catch (e) {}
		document.dispatchEvent(new CustomEvent('ebs:region'));
	}
	function regionOk(sd, sg, r) {
		r = r === undefined ? getRegion() : r;
		if (!r || normSd(sd) !== normSd(r.sd)) { return false; }
		if (!sg) { return true; } // 시·도 전체 대상
		var a = String(r.sg || '');
		return !!a && (a === sg || a.indexOf(sg) === 0 || sg.indexOf(a) === 0);
	}
	// 월간 달력(테마)이 지역 일정 표시 여부를 물어봄: '시도|시군구'
	window.ebsRegionOk = function (key) { var p = String(key || '').split('|'); return regionOk(p[0], p[1] || ''); };
	window.ebsRegion = getRegion;

	var ebsPin = '<svg class="ebs-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>';

	// ── 보드
	function init(root) {
		if (root.getAttribute('data-ready')) { return; }
		root.setAttribute('data-ready', '1');
		var t = today(), max = +root.getAttribute('data-max') || 0, f = 'all', w = '', expanded = false;
		var list = root.querySelector('.ebs__list'), rows = [];

		var pool = root.querySelector('.ebs__deferred');
		var sourceRows = all(root, '.ebs-r').concat(pool ? all(pool.content, '.ebs-r') : []);
		function prep(li) {
			var s = li.getAttribute('data-s'), e = d0(li.getAttribute('data-e')), sd = s ? d0(s) : null;
			var toE = Math.round((e - t) / DAY);
			if (toE < 0) { li.parentNode.removeChild(li); return; }
			var isOpen = !sd || sd <= t, st = isOpen ? (toE <= 14 ? 'soon' : 'open') : 'next';
			var key = isOpen ? e : sd, days = Math.round((key - t) / DAY);
			li.classList.remove('is-open', 'is-soon', 'is-next');
			li.classList.add('is-' + st);
			li.setAttribute('data-state', st);
			li.querySelector('.ebs-r__dd b').textContent = days === 0 ? (isOpen ? '오늘' : '오늘') : 'D-' + days;
			li.querySelector('.ebs-r__dd small').textContent = isOpen ? '마감까지' : '시작까지';
			var bar = li.querySelector('.ebs-r__bar i');
			if (bar && sd && isOpen) {
				var tot = Math.max(1, (e - sd) / DAY);
				bar.style.width = Math.max(4, Math.min(100, Math.round((t - sd) / DAY / tot * 100))) + '%';
			}
			rows.push({ li: li, st: st, open: isOpen, key: key, local: li.getAttribute('data-local') === '1', sd: li.getAttribute('data-sd') || '', sg: li.getAttribute('data-sg') || '' });
		}
		sourceRows.forEach(prep);
		// 지역 사업 줄은 사는 곳을 골랐을 때만 받아 옴(data-local-src, 2026-10-15)
		var lsrc = root.getAttribute('data-local-src'), lstate = 0;
		function loadLocal(done) {
			if (!lsrc || lstate === 2) { done(); return; }
			if (lstate === 1) { return; }
			lstate = 1;
			fetch(lsrc).then(function (r) { return r.json(); }).then(function (j) {
				var tp = document.createElement('template');
				tp.innerHTML = j && j.html ? j.html : '';
				all(tp.content, '.ebs-r').forEach(prep);
			}).catch(function () {}).then(function () { lstate = 2; done(); });
		}
		all(root, '.ebs__tax .dd[data-dd]').forEach(function (el) {
			var v = Math.round((d0(el.getAttribute('data-dd')) - t) / DAY);
			el.textContent = v > 0 ? 'D-' + v : (v === 0 ? '오늘' : '');
		});

		var empty = root.querySelector('.ebs__empty'), toggle = root.querySelector('.ebs__toggle'), hero = root.querySelector('.ebs__hero');
		var rg = root.querySelector('.ebs-rg'), live = [];

		// 지역이 바뀌면: 맞는 지역 사업만 살리고 맨 위로
		function region() {
			var r = getRegion();
			live = rows.filter(function (o) { return !o.local || regionOk(o.sd, o.sg, r); });
			var mine = live.filter(function (o) { return o.local; });
			// Display order is applied below, after status/persona filtering.
			rows.forEach(function (o) { if (o.local && mine.indexOf(o) < 0) { o.li.hidden = true; } });
			live = mine.concat(live.filter(function (o) { return !o.local; }));
			var c = { all: live.length, open: 0, local: mine.length, next: 0 };
			live.forEach(function (o) { if (o.open) { c.open++; } else { c.next++; } });
			all(root, '[data-c]').forEach(function (el) { el.textContent = c[el.getAttribute('data-c')] || 0; });
			var sn = root.querySelector('.ebs__sum-next'); if (sn) { sn.hidden = !c.next; } // '곧 시작 0'은 숨김
			all(root, '.ebs__tabs [data-f]').forEach(function (b) {
				var k = b.getAttribute('data-f');
				if (k !== 'all' && !c[k]) { b.setAttribute('data-hide', '1'); } else { b.removeAttribute('data-hide'); }
			});
			if ((f === 'local' && !c.local) || (f === 'next' && !c.next) || (f === 'open' && !c.open)) { pickTab('all'); }
			// 지역 버튼 글자
			if (rg) {
				rg.classList.toggle('is-set', !!r);
				rg.querySelector('.ebs-rg__v').textContent = r ? shortSd(r.sd) + (r.sg ? ' ' + r.sg : '') : '선택';
			}
			// 좁은 칸 맨 위: 가장 가까운 마감(접수 중 중 마감이 가장 빠른 것)
			if (hero) {
				var first = live.filter(function (o) { return o.open; }).sort(function (a, b) { return a.key - b.key; })[0];
				hero.hidden = !first;
				if (first) {
					var a = first.li.querySelector('.ebs-r__n a'), n = first.li.querySelector('.ebs-r__n').textContent;
					hero.href = a ? a.getAttribute('href') : '#';
					if (a && a.target) { hero.target = '_blank'; hero.rel = 'noopener'; } else { hero.removeAttribute('target'); }
					hero.querySelector('small').textContent = '가장 가까운 마감 · ' + md(first.key) + (first.local ? ' · 우리 지역' : '');
					hero.querySelector('.ebs__hero-t b').textContent = n;
					hero.querySelector('.ebs__hero-d').textContent = first.li.querySelector('.ebs-r__dd b').textContent;
				}
			}
			apply();
		}

		function apply() {
			var match = 0, mL = 0, mN = 0;
			live.forEach(function (o) {
				var okF = f === 'all' || (f === 'open' && o.open) || (f === 'next' && !o.open) || (f === 'local' && o.local);
				var okW = !w || (' ' + o.li.getAttribute('data-w') + ' ').indexOf(' ' + w + ' ') > -1;
				var ok = okF && okW;
				if (ok) { match++; if (o.local) { mL++; } else { mN++; } ok = !max || expanded || match <= max; }
				o.li.hidden = !ok;
			});
			// Only visible rows participate in layout. Keep detached nodes for filters/calendar actions.
			rows.forEach(function (o) { if (o.li.parentNode === list) { list.removeChild(o.li); } });
			live.forEach(function (o) { if (!o.li.hidden) { list.appendChild(o.li); } });
			// 우리 지역 사업이 있으면 맨 위에 '📍 서울 강남구 n' · 아래에 '전국 n' 묶음 제목 (2026-10-16, 탭 '우리 지역' 대신)
			all(list, '.ebs-sec').forEach(function (x) { list.removeChild(x); });
			if (mL) {
				var rr = getRegion(), firstL = null, firstN = null;
				all(list, '.ebs-r').forEach(function (li) { if (li.getAttribute('data-local') === '1') { firstL = firstL || li; } else { firstN = firstN || li; } });
				var sec = function (cls, html) { var x = document.createElement('li'); x.className = 'ebs-sec' + cls; x.innerHTML = html; return x; };
				if (firstL) { list.insertBefore(sec(' is-local', ebsPin + '<span>' + esc(rr ? shortSd(rr.sd) + (rr.sg ? ' ' + rr.sg : '') : '우리 지역') + '</span><b>' + mL + '</b><small>사는 곳 지원사업</small>'), firstL); }
				if (firstN && mN) { list.insertBefore(sec('', '<span>전국</span><b>' + mN + '</b>'), firstN); }
			}
			if (!live.length) { empty.textContent = '지금은 접수 중이거나 곧 시작하는 일정이 없어요. 새 공고가 나오면 이곳에 바로 올라와요.'; }
			empty.hidden = match > 0;
			// 고른 탭·대상의 일정이 몇 개뿐이면 빈자리에 '전체 일정 보기' 안내
			var hint = root.querySelector('.ebs__hint');
			if (hint) {
				var few = (f !== 'all' || w) && match > 0 && match < (max || 4);
				hint.hidden = !few;
				if (few) { hint.firstChild.textContent = (w ? '고른 대상' : ({ open: '접수 중', local: '우리 지역', next: '곧 시작' })[f]) + ' 일정은 ' + match + '건이에요'; }
			}
			if (toggle) {
				var more = max && match > max;
				toggle.hidden = !more;
				toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
				toggle.firstChild.textContent = expanded ? '접기' : '더 보기 ' + (match - max);
			}
			pushPaint();
		}
		function pickTab(k) {
			f = k;
			all(root, '.ebs__tabs [data-f]').forEach(function (x) { x.setAttribute('aria-selected', x.getAttribute('data-f') === k ? 'true' : 'false'); });
		}

		// 지역 고르기 창
		if (rg) {
			var R = {};
			try { R = JSON.parse(root.getAttribute('data-regions') || '{}') || {}; } catch (e) {}
			var sdSel = rg.querySelector('.ebs-rg__sd'), sgSel = rg.querySelector('.ebs-rg__sg');
			Object.keys(R).forEach(function (sd) { var o = document.createElement('option'); o.value = sd; o.textContent = sd; sdSel.appendChild(o); });
			var fillSg = function (sd, sg) {
				sgSel.innerHTML = '<option value="">시·도 전체</option>' + (R[sd] || []).map(function (x) { return '<option' + (x === sg ? ' selected' : '') + '>' + esc(x) + '</option>'; }).join('');
			};
			rg.addEventListener('toggle', function () {
				if (!rg.open) { return; }
				var r = getRegion();
				if (r && !R[r.sd]) { var o = document.createElement('option'); o.value = r.sd; o.textContent = r.sd; sdSel.appendChild(o); }
				sdSel.value = r ? r.sd : '';
				fillSg(sdSel.value, r ? r.sg : '');
			});
			sdSel.addEventListener('change', function () { fillSg(sdSel.value, ''); });
			rg.querySelector('.ebs-rg__ok').addEventListener('click', function () { setRegion(sdSel.value ? { sd: sdSel.value, sg: sgSel.value } : null); rg.open = false; });
			rg.querySelector('.ebs-rg__clear').addEventListener('click', function () { setRegion(null); rg.open = false; });
		}

		root.addEventListener('click', function (ev) {
			var b = ev.target.closest('button');
			if (!b || !root.contains(b)) { return; }
			if (b.hasAttribute('data-f')) {
				if (b.parentNode.classList.contains('ebs__hint')) { // '전체 일정 보기': 대상 칩도 '모두'로
					w = '';
					all(root, '.ebs__chips [data-w]').forEach(function (x) { x.setAttribute('aria-pressed', x.getAttribute('data-w') === '' ? 'true' : 'false'); });
				}
				pickTab(b.getAttribute('data-f'));
				expanded = false; apply();
			} else if (b.hasAttribute('data-w') && b.parentNode.classList.contains('ebs__chips')) {
				w = b.getAttribute('data-w');
				all(root, '.ebs__chips [data-w]').forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
				expanded = false; apply();
			} else if (b === toggle) {
				expanded = !expanded; apply();
			} else if (b.hasAttribute('data-ics')) {
				ics(b.getAttribute('data-ics'), b.getAttribute('data-t'));
				var det = b.closest('details'); if (det) { det.open = false; }
			}
		});
		document.addEventListener('ebs:region', function () { region(); if (getRegion()) { loadLocal(region); } });
		region();
		if (getRegion()) { loadLocal(region); }
	}

	function ics(day, title) {
		var d = d0(day), d2 = new Date(d.getTime() + DAY), now = new Date();
		var stamp = now.toISOString().replace(/[-:]/g, '').replace(/\.\d+Z$/, 'Z');
		var e = function (s) { return String(s).replace(/([,;\\])/g, '\\$1'); };
		var body = [
			'BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//wordpress-1073525-6734075.cloudwaysapps.com//schedule//KO', 'CALSCALE:GREGORIAN',
			'BEGIN:VEVENT',
			'UID:' + ymd(d) + '-' + Math.random().toString(36).slice(2) + '@easybokji.com',
			'DTSTAMP:' + stamp,
			'DTSTART;VALUE=DATE:' + ymd(d), 'DTEND;VALUE=DATE:' + ymd(d2),
			'SUMMARY:' + e(title),
			'DESCRIPTION:' + e('이지복지닷컴 신청·마감 일정 ' + location.origin + '/schedule/ - 기간은 공고에 따라 바뀔 수 있으니 담당 기관에서 확인해 주세요.'),
			'BEGIN:VALARM', 'ACTION:DISPLAY', 'DESCRIPTION:' + e(title), 'TRIGGER:-PT15H', 'END:VALARM',
			'END:VEVENT', 'END:VCALENDAR'
		].join('\r\n');
		var a = document.createElement('a');
		a.href = URL.createObjectURL(new Blob([body], { type: 'text/calendar;charset=utf-8' }));
		a.download = title.replace(/[\\\/:*?"<>|]/g, '') + '.ics';
		document.body.appendChild(a); a.click();
		setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
	}

	// ── 월간 달력(테마 #eb-cal): 보고 있는 달 내내 접수 중인 일정을 달력 위 한 줄로
	function calendar() {
		var box = document.getElementById('eb-cal');
		if (!box || box.getAttribute('data-ebs')) { return; }
		box.setAttribute('data-ebs', '1');
		var D = {};
		try { D = JSON.parse(box.getAttribute('data-set')) || {}; } catch (e) {}
		var on = D.ongoing || [], title = box.querySelector('.eb-cal__title'), grid = box.querySelector('.eb-cal__grid');
		if (!title || !grid || !on.length) { return; }
		var strip = document.createElement('div');
		strip.className = 'eb-cal__ongo';
		strip.hidden = true;
		grid.parentNode.insertBefore(strip, grid);
		var draw = function () {
			var m = /(\d+)년\s*(\d+)월/.exec(title.textContent || '');
			if (!m) { strip.hidden = true; return; }
			var first = new Date(+m[1], +m[2] - 1, 1), last = new Date(+m[1], +m[2], 0), r = getRegion();
			var xs = on.filter(function (x) {
				var s = x[1] ? d0(x[1]) : null, e = d0(x[2]);
				var ok = (!s || s < first) && e > last; // 이달에 시작·마감 표시가 없는(내내 접수 중인) 것
				if (ok && x[3]) { var p = x[3].split('|'); ok = regionOk(p[0], p[1] || '', r); }
				return ok;
			}).sort(function (a, b) { return a[2] < b[2] ? -1 : 1; });
			strip.hidden = !xs.length;
			strip.innerHTML = '<b>이달 내내 접수 중</b>' + xs.slice(0, 8).map(function (x) {
				var e = d0(x[2]);
				return '<a href="' + esc(x[4] || '#') + '"' + (/^https?:\/\/(?!easybokji\.com)/.test(x[4] || '') ? ' target="_blank" rel="noopener"' : '') + (x[3] ? ' class="is-local"' : '') + '>' + esc(x[0]) + ' <em>~' + (e.getMonth() + 1) + '.' + e.getDate() + '</em></a>';
			}).join('') + (xs.length > 8 ? '<span>+' + (xs.length - 8) + '</span>' : '');
		};
		// 범례에 '우리 지역'(보라) 추가 - 지역을 골랐을 때만
		var lg = box.querySelector('.eb-cal__legend'), lgi = document.createElement('span');
		lgi.innerHTML = '<i class="is-local"></i>우리 지역';
		var legend = function () { lgi.hidden = !getRegion(); };
		if (lg) { lg.appendChild(lgi); legend(); document.addEventListener('ebs:region', legend); }
		if (window.MutationObserver) { new MutationObserver(draw).observe(title, { childList: true, characterData: true, subtree: true }); }
		document.addEventListener('ebs:region', draw);
		draw();
	}

	// 바깥을 누르면 열린 캘린더·지역 창 닫기
	document.addEventListener('click', function (ev) {
		all(document, '.ebs-cal[open], .ebs-rg[open]').forEach(function (d) {
			if (!d.contains(ev.target)) { d.open = false; }
		});
	});

	// ── 마감 알림(웹 푸시): 일정 줄의 종 버튼 → 구독 + 이 일정 켜기/끄기 (2026-10-15, eb-schedule.php 끝 '마감 알림')
	var PK = 'ebs_push', API = '/wp-json/ebs/v1/';
	function pushList() { try { return JSON.parse(localStorage.getItem(PK) || '[]'); } catch (e) { return []; } }
	function pushPaint() {
		var on = pushList();
		all(document, '[data-push]').forEach(function (b) {
			var y = on.indexOf(b.getAttribute('data-push')) > -1;
			b.setAttribute('aria-pressed', y ? 'true' : 'false');
			b.title = y ? '알림 켜짐 · 누르면 꺼요' : '시작·마감 알림 받기';
		});
	}
	function note(msg) {
		var t = document.querySelector('.eb-toast');
		if (!t) { t = document.createElement('div'); t.className = 'eb-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
		t.textContent = msg; t.hidden = false; t.classList.add('is-on');
		clearTimeout(t._h); t._h = setTimeout(function () { t.classList.remove('is-on'); }, 3400);
	}
	function b64(s) {
		s = s.replace(/-/g, '+').replace(/_/g, '/');
		var r = atob(s + '==='.slice((s.length + 3) % 4)), a = new Uint8Array(r.length);
		for (var i = 0; i < r.length; i++) { a[i] = r.charCodeAt(i); }
		return a;
	}
	function pushToggle(b) {
		var k = b.getAttribute('data-push'), on = pushList().indexOf(k) < 0;
		if (!('serviceWorker' in navigator) || !('PushManager' in window) || !window.Notification) {
			note(/iPhone|iPad|iPod/.test(navigator.userAgent) ? '아이폰은 공유 버튼 → \'홈 화면에 추가\'로 이지복지닷컴을 설치한 뒤 알림을 켤 수 있어요' : '이 브라우저는 알림을 지원하지 않아요. 크롬·삼성 인터넷·엣지에서 열어 주세요');
			return;
		}
		var ask = !on || Notification.permission === 'granted' ? Promise.resolve('granted') : Notification.requestPermission();
		Promise.resolve(ask).then(function (p) {
			if (p !== 'granted') { note('알림이 꺼져 있어요. 브라우저 설정에서 이 사이트의 알림을 허용해 주세요'); return; }
			return navigator.serviceWorker.register('/sw.js').then(function () { return navigator.serviceWorker.ready; }).then(function (reg) {
				return reg.pushManager.getSubscription().then(function (sub) {
					if (sub || !on) { return sub; }
					return fetch(API + 'push-key').then(function (r) { return r.json(); }).then(function (j) {
						return reg.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: b64(j.key) });
					});
				});
			}).then(function (sub) {
				var save = function () {
					var l = pushList().filter(function (x) { return x !== k; });
					if (on) { l.push(k); }
					try { localStorage.setItem(PK, JSON.stringify(l)); } catch (e) {}
					// 이름·기간·주소도 남김 → 테마 '저장한 글'의 알림 켠 일정·휴대폰 메뉴 '알림' 탭(functions.php 66번·20번, 2026-10-16)
					var mt = {}; try { mt = JSON.parse(localStorage.getItem(PK + '_meta') || '{}') || {}; } catch (e) {}
					if (on) {
						var li = b.closest('.ebs-r'), lk = li && li.querySelector('.ebs-r__n a');
						mt[k] = li ? { n: b.getAttribute('data-n') || '', s: li.getAttribute('data-s') || '', e: li.getAttribute('data-e') || '', u: lk ? lk.href : '', x: lk && lk.target === '_blank' ? 1 : 0 } : (mt[k] || { n: b.getAttribute('data-n') || '' });
					} else if (b.closest('.ebs-r')) { delete mt[k]; }
					try { localStorage.setItem(PK + '_meta', JSON.stringify(mt)); } catch (e) {}
					document.dispatchEvent(new CustomEvent('ebs:push'));
					pushPaint();
					note(on ? '알림을 켰어요 · 시작일, 마감 3일 전, 마감일 아침 9시에 알려 드려요' : '이 일정 알림을 껐어요');
				};
				if (!sub) { if (!on) { save(); } return; }
				return fetch(API + 'push-sub', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ endpoint: sub.endpoint, k: k, n: b.getAttribute('data-n'), on: on }) }).then(function (r) {
					if (!r.ok) { throw new Error('push-sub'); }
					save();
				});
			});
		}).catch(function () { note('알림을 켜지 못했어요. 잠시 뒤 다시 눌러 주세요'); });
	}
	document.addEventListener('click', function (e) {
		var b = e.target.closest && e.target.closest('[data-push]');
		if (b) { e.preventDefault(); e.stopPropagation(); pushToggle(b); }
	}, true);

	// ── 줄 높이 맞춤 (2026-10-16): 상자가 옆 칸에 맞춰 늘어나면 남는 높이를 줄마다 똑같이 나누고, 모든 줄 높이를 화면 픽셀의 정수배로.
	//    줄 높이가 51.3px처럼 소수면 4px 게이지바가 줄마다 화면 픽셀에 다르게 걸려 1px씩 위아래로 어긋나 보였음(배율 125% 화면 등)
	function snap(list) {
		var rows = all(list, '.ebs-r').filter(function (r) { return r.parentNode === list && r.offsetParent; });
		rows.forEach(function (r) { r.style.minHeight = ''; });
		if (!rows.length) { return; }
		var dpr = window.devicePixelRatio || 1, nat = rows.map(function (r) { return r.getBoundingClientRect().height; });
		// 줄 말고 목록 안의 다른 것(우리 지역·전국 묶음 제목)도 높이에 넣어야 남는 높이가 맞음
		var used = nat.reduce(function (s, h) { return s + h; }, 0) + all(list, '.ebs-sec').reduce(function (s, x) { return s + (x.offsetParent ? x.getBoundingClientRect().height : 0); }, 0);
		var per = Math.max(0, list.getBoundingClientRect().height - used) / rows.length;
		var low = Math.min.apply(null, nat), one = Math.max.apply(null, nat.filter(function (h) { return h < low + 4; }));
		rows.forEach(function (r, i) {
			// 한 줄짜리 줄들은 모두 같은 높이(가장 큰 한 줄 높이 기준), 이름이 두 줄인 줄만 더 높게 - 모두 기기 픽셀 단위
			var base = nat[i] < low + 4 ? one : nat[i], h = Math.floor((base + per) * dpr + 0.01) / dpr;
			if (h < nat[i]) { h = Math.ceil(nat[i] * dpr - 0.01) / dpr; }
			r.style.minHeight = h + 'px';
		});
	}
	var snapQ = false;
	function snapAll() {
		if (snapQ) { return; }
		snapQ = true;
		requestAnimationFrame(function () { snapQ = false; all(document, '.ebs__list').forEach(snap); });
	}
	function snapWatch() {
		snapAll();
		window.addEventListener('resize', snapAll);
		if (document.fonts && document.fonts.ready) { document.fonts.ready.then(snapAll); }
		window.addEventListener('load', snapAll);
		// 대상 칩·탭·더 보기·지역 줄이 바뀌면(줄의 hidden·class 변화) 다시 맞춤 - style은 보지 않아 스스로 다시 부르지 않음
		if (window.MutationObserver) {
			var mo = new MutationObserver(snapAll);
			all(document, '.ebs').forEach(function (b) { mo.observe(b, { subtree: true, childList: true, attributes: true, attributeFilter: ['hidden', 'class', 'open'] }); });
		}
	}

	function run() { all(document, '.ebs').forEach(init); calendar(); pushPaint(); snapWatch(); }
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', run); } else { run(); }
})();
