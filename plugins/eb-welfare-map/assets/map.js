/* 이지복지 우리 지역 복지지도 (eb-welfare-map) - 화면 스크립트
 * 첫 화면은 서버가 그린 HTML. 이 스크립트가 지역 검색·지도·필터·더 보기·주소(공유)를 붙임.
 * 지역 기억은 복지 캘린더와 같은 ebs_region만 씀. 맞춤 찾기 기록(eb_finder_last)은 읽기만 함. */
(function () {
	'use strict';
	var root = document.getElementById('wmap');
	var cfgEl = document.getElementById('wmap-cfg');
	if (!root || !cfgEl) { return; }
	var C;
	try { C = JSON.parse(cfgEl.textContent); } catch (e) { return; }

	var LABEL = { open: '접수 중', soon: '곧 시작', always: '상시', unknown: '기간 확인 필요', closed: '마감' };
	var ORDER = ['open', 'soon', 'always', 'unknown', 'closed'];
	var LIFE = ['임신·출산', '영유아', '아동', '청소년', '청년', '중장년', '노년'];
	var HH = ['저소득', '장애인', '한부모·조손', '다자녀', '다문화·탈북민', '보훈대상자'];
	var TH_TOP = ['생활지원', '일자리', '주거', '신체건강', '보호·돌봄', '서민금융', '정신건강', '교육'];
	var PAGE = 10;
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* ── 지역 표 ─────────────────────────────────────────── */
	var SD = {}, SG = {}, SDL = [];
	C.reg.sd.forEach(function (s) {
		var o = { id: s[0], n: s[1], s: s[2], g: [] };
		s[3].forEach(function (g) { var x = { id: g[0], n: g[1], sd: s[0] }; o.g.push(x); SG[g[0]] = x; });
		SD[s[0]] = o; SDL.push(o);
	});
	var nz = function (s) { return String(s || '').replace(/\s+/g, ''); };
	function sdCode(name) {
		name = nz(name);
		if (!name) { return ''; }
		if (SD[name]) { return name; }
		for (var i = 0; i < SDL.length; i++) { if (SDL[i].n === name || SDL[i].s === name) { return SDL[i].id; } }
		for (var j = 0; j < C.reg.al.length; j++) { var a = C.reg.al[j]; if (!a[2] && a[0] === name) { return a[1]; } }
		return '';
	}
	function sgId(sd, name) {
		name = nz(name);
		var s = SD[sd];
		if (!s || !name) { return ''; }
		for (var i = 0; i < s.g.length; i++) { if (s.g[i].n === name || s.g[i].id === name) { return s.g[i].id; } }
		return '';
	}
	function sgAlias(sd, name) {
		name = nz(name);
		for (var j = 0; j < C.reg.al.length; j++) { var a = C.reg.al[j]; if (a[2] && a[1] === sd && a[0] === name) { return { to: a[2].split(','), note: a[3] || '' }; } }
		return null;
	}
	function label(sd, sg, short) {
		var s = SD[sd];
		if (!s) { return ''; }
		return (short ? s.s : s.n) + (sg && SG[sg] ? ' ' + SG[sg].n : '');
	}

	/* ── 도구 ───────────────────────────────────────────── */
	function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
	function $(sel, el) { return (el || root).querySelector(sel); }
	function all(sel, el) { return [].slice.call((el || root).querySelectorAll(sel)); }
	function has(a, v) { return !!a && a.indexOf(v) > -1; }
	function any(a, b) { for (var i = 0; i < b.length; i++) { if (has(a, b[i])) { return true; } } return false; }
	function num(n) { return Number(n || 0).toLocaleString('ko-KR'); }
	function lget(k) { try { return JSON.parse(localStorage.getItem(k) || 'null'); } catch (e) { return null; } }
	function lset(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) {} }
	function today() { var d = new Date(); return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2); }
	var WK = ['일', '월', '화', '수', '목', '금', '토'];
	function md(ymd, wk) { if (!ymd) { return ''; } var p = ymd.split('-'), d = new Date(+p[0], +p[1] - 1, +p[2]); return (+p[1]) + '.' + (+p[2]) + (wk ? '(' + WK[d.getDay()] + ')' : ''); }
	function ymdDot(ymd) { if (!ymd) { return ''; } var p = ymd.split('-'); return p[0] + '.' + (+p[1]) + '.' + (+p[2]); }
	function days(a, b) { var p = a.split('-'), q = b.split('-'); return Math.round((new Date(+q[0], +q[1] - 1, +q[2]) - new Date(+p[0], +p[1] - 1, +p[2])) / 864e5); }
	function toast(msg) {
		var t = document.querySelector('.eb-toast');
		if (!t) { t = document.createElement('div'); t.className = 'eb-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
		t.textContent = msg; t.hidden = false; t.classList.add('is-on');
		clearTimeout(t._h); t._h = setTimeout(function () { t.classList.remove('is-on'); }, 2600);
	}
	function api(path) {
		var h = {};
		if (C.nonce) { h['X-WP-Nonce'] = C.nonce; }
		return fetch(C.api + path, { headers: h, credentials: 'same-origin' }).then(function (r) {
			if (!r.ok) { throw new Error('HTTP ' + r.status); }
			return r.json();
		});
	}
	var ICON = {
		arrow: '<path d="M5 12h14M13 6l6 6-6 6"/>',
		star: '<path d="m12 3.5 2.6 5.3 5.9.9-4.3 4.1 1 5.8-5.2-2.7-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/>',
		share: '<path d="M12 15V3.5M7.5 8 12 3.5 16.5 8M5 12.5V19a1.5 1.5 0 0 0 1.5 1.5h11A1.5 1.5 0 0 0 19 19v-6.5"/>',
		cal: '<rect x="3" y="4.5" width="18" height="16" rx="2.5"/><path d="M16 2.5v4M8 2.5v4M3 9.5h18"/>',
		pin: '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		find: '<path d="M11 3.5l1.9 4.9 4.9 1.9-4.9 1.9L11 17.1l-1.9-4.9-4.9-1.9 4.9-1.9z"/><path d="M18.2 15.2l.8 1.9 1.9.8-1.9.8-.8 1.9-.8-1.9-1.9-.8 1.9-.8z"/>',
		ext: '<path d="M14 4h6v6M20 4l-9 9M18 14v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4"/>',
		x: '<path d="M6 6l12 12M18 6 6 18"/>'
	};
	function ic(k) { return '<svg class="wmap-ic" viewBox="0 0 24 24" aria-hidden="true">' + ICON[k] + '</svg>'; }

	/* ── 상태 ───────────────────────────────────────────── */
	var S = { sd: '', sg: '', f: { life: [], hh: [], th: [], st: [], q: '' }, data: null, nation: null, shown: {}, req: 0 };
	var T = today();

	function statusNow(st) {
		if (!st || st.k !== 'period') { return st ? st.k : 'unknown'; }
		if (st.e < T) { return 'closed'; }
		if (st.s && st.s > T) { return 'soon'; }
		return 'open';
	}

	/* ── 주소 ───────────────────────────────────────────── */
	function readUrl() {
		var q = new URLSearchParams(location.search), out = { sd: '', sg: '', split: null, moved: false, bad: false };
		var r = (q.get('r') || '').replace(/\D/g, '');
		if (r) {
			if (SG[r]) { out.sd = SG[r].sd; out.sg = r; } else if (SD[r]) { out.sd = r; } else { out.bad = true; }
		} else if (q.get('sd')) {
			out.sd = sdCode(q.get('sd'));
			if (!out.sd) { out.bad = true; }
			else {
				out.moved = nz(q.get('sd')) !== SD[out.sd].n && nz(q.get('sd')) !== SD[out.sd].s;
				var g = q.get('sg');
				if (g && out.sd !== '36') {
					out.sg = sgId(out.sd, g);
					if (!out.sg) {
						var al = sgAlias(out.sd, g);
						if (al && al.to.length === 1) { out.sg = al.to[0]; out.moved = true; }
						else if (al) { out.split = { from: nz(g), note: al.note, to: al.to }; }
						else { out.bad = true; }
					}
				}
			}
		}
		['life', 'hh', 'th', 'st'].forEach(function (k) { S.f[k] = (q.get(k) || '').split(',').filter(Boolean); });
		S.f.q = q.get('q') || '';
		return out;
	}
	function regionQuery(sd, sg) {
		var p = new URLSearchParams();
		if (sd) { p.set('sd', SD[sd].n); if (sg) { p.set('sg', SG[sg].n); } }
		return p;
	}
	function pageUrl(sd, sg, withFilters) {
		var p = regionQuery(sd, sg);
		if (withFilters) {
			['life', 'hh', 'th', 'st'].forEach(function (k) { if (S.f[k].length) { p.set(k, S.f[k].join(',')); } });
			if (S.f.q) { p.set('q', S.f.q); }
		}
		var s = p.toString();
		return C.base + (s ? (C.base.indexOf('?') > -1 ? '&' : '?') + s : '');
	}
	function syncUrl(push) {
		var u = pageUrl(S.sd, S.sg, true);
		if (u === location.href) { return; }
		try { history[push ? 'pushState' : 'replaceState']({ wmap: 1 }, '', u); } catch (e) {}
	}

	/* ── 지역 기억(캘린더와 공통 ebs_region) ───────────────── */
	function remember(sd, sg) {
		lset('ebs_region', sd ? { sd: SD[sd].n, sg: sg ? SG[sg].n : '', at: Date.now() } : { sd: '', sg: '', at: Date.now() });
		try { document.dispatchEvent(new CustomEvent('ebs:region')); } catch (e) {}
	}
	function lastRegion() {
		var a = lget('ebs_region'), f = lget('eb_finder_last'), b = f && f.v === 2 && f.sd ? { sd: f.sd, sg: f.sg || '', at: f.at || 0 } : null;
		var r = a && b ? ((a.at || 0) >= (b.at || 0) ? a : b) : (a || b);
		if (!r || !r.sd) { return null; }
		var sd = sdCode(r.sd);
		if (!sd) { return null; }
		var sg = r.sg ? sgId(sd, r.sg) : '';
		if (r.sg && !sg) { var al = sgAlias(sd, r.sg); if (al && al.to.length === 1) { sg = al.to[0]; } }
		return { sd: sd, sg: sg };
	}

	/* ── 다른 화면 주소 ───────────────────────────────────── */
	function findUrl() {
		var f = lget('eb_finder_last'), p = new URLSearchParams();
		var life = f && f.v === 2 ? (f.life || '') : '', hh = f && f.v === 2 ? (f.hh || []) : [], th = f && f.v === 2 ? (f.th || []) : [];
		// 맞춤 찾기에 고른 조건이 없으면 지도에서 고른 조건을 넘김(생애주기는 하나만)
		if (!life && !hh.length && !th.length) { life = S.f.life[0] || ''; hh = S.f.hh; th = S.f.th; }
		if (life) { p.set('life', life); }
		if (hh.length) { p.set('hh', hh.join(',')); }
		if (th.length) { p.set('th', th.join(',')); }
		if (S.sd) { p.set('sd', SD[S.sd].n); if (S.sg) { p.set('sg', SG[S.sg].n); } }
		return C.find + '?' + p.toString() + '#finder';
	}
	function calUrl() {
		var p = regionQuery(S.sd, S.sg).toString();
		return C.cal + (p ? '?' + p : '') + '#applying';
	}

	/* ── 지역 검색(콤보박스) ─────────────────────────────── */
	var qIn = $('#wmap-q'), sug = $('#wmap-sug'), sugItems = [], sugAt = -1;
	var INDEX = [];
	SDL.forEach(function (s) {
		INDEX.push({ sd: s.id, sg: '', t: s.n, k: [s.n, s.s], w: 1 });
		s.g.forEach(function (g) { INDEX.push({ sd: s.id, sg: g.id, t: s.s + ' ' + g.n, k: [s.n, s.s, g.n, g.n.replace(/(시|군|구)$/, '')], w: 2 }); });
	});
	C.reg.al.forEach(function (a) {
		if (!a[2]) {
			// 옛 시·도 이름: '광주광역시' → 전남광주, '광주 광산구'처럼 시·군·구와 함께도
			var s = SD[a[1]];
			INDEX.push({ sd: s.id, sg: '', t: s.n, k: [a[0], a[0].replace(/(특별자치도|특별자치시|특별시|광역시|도)$/, '')], w: 0, old: a[0] });
			s.g.forEach(function (g) { INDEX.push({ sd: s.id, sg: g.id, t: s.s + ' ' + g.n, k: [a[0], a[0].replace(/(특별자치도|특별자치시|특별시|광역시|도)$/, ''), g.n, g.n.replace(/(시|군|구)$/, '')], w: 0, old: a[0] }); });
		} else {
			INDEX.push({ sd: a[1], sg: '', split: a[2].split(','), t: SD[a[1]].s + ' ' + a[0] + ' (옛 이름)', k: [SD[a[1]].n, SD[a[1]].s, a[0]], w: 3, note: a[3] });
		}
	});
	function search(q) {
		var toks = String(q || '').trim().split(/\s+/).map(nz).filter(Boolean);
		if (!toks.length) { return []; }
		var out = [], seen = {};
		INDEX.forEach(function (x) {
			var ok = toks.every(function (t) { return x.k.some(function (k) { return k && k.indexOf(t) === 0; }); });
			if (!ok) { return; }
			// 시·도만 맞은 낱말 하나로는 시·군·구를 다 늘어놓지 않음(경기 → 경기도 하나)
			if (x.sg && toks.length === 1 && x.k.slice(0, 2).some(function (k) { return k.indexOf(toks[0]) === 0; }) && !(x.k[2] && x.k[2].indexOf(toks[0]) === 0)) { return; }
			var key = x.sd + '|' + x.sg + '|' + (x.split ? x.split.join() : '');
			if (seen[key]) { return; }
			seen[key] = 1;
			var exact = toks.some(function (t) { return x.k[2] === t || x.k[3] === t; });
			out.push({ x: x, sc: (exact ? 0 : 10) + (x.old ? 5 : 0) + (x.sg ? 1 : 0) });
		});
		out.sort(function (a, b) { return a.sc - b.sc || a.x.t.localeCompare(b.x.t, 'ko'); });
		return out.slice(0, 8).map(function (o) { return o.x; });
	}
	function showSug() {
		var list = search(qIn.value);
		sugItems = list; sugAt = -1;
		if (!qIn.value.trim()) { sug.hidden = true; qIn.setAttribute('aria-expanded', 'false'); return; }
		sug.innerHTML = list.length ? list.map(function (x, i) {
			var c = C.cnt[x.sd], n = x.split ? '' : (x.sg ? c.g[x.sg] : c.s + Object.keys(c.g).reduce(function (a, k) { return a + c.g[k]; }, 0));
			return '<li role="option" id="wmap-o' + i + '" aria-selected="false" data-i="' + i + '"><span>' + esc(x.t) + (x.old ? ' <small>' + esc(x.old) + '</small>' : '') + '</span>' + (n !== '' ? '<em>' + num(n) + '건</em>' : '') + '</li>';
		}).join('') : '<li class="is-none" role="option" aria-disabled="true" aria-selected="false">맞는 지역이 없어요. 시·도 이름부터 써 보세요.</li>';
		sug.hidden = false;
		qIn.setAttribute('aria-expanded', 'true');
	}
	function moveSug(d) {
		if (!sugItems.length) { return; }
		sugAt = (sugAt + d + sugItems.length) % sugItems.length;
		all('li', sug).forEach(function (li, i) { li.setAttribute('aria-selected', i === sugAt ? 'true' : 'false'); li.classList.toggle('is-at', i === sugAt); });
		qIn.setAttribute('aria-activedescendant', 'wmap-o' + sugAt);
		var li = $('#wmap-o' + sugAt, sug);
		if (li && li.scrollIntoView) { li.scrollIntoView({ block: 'nearest' }); }
	}
	function pickSug(i) {
		var x = sugItems[i];
		if (!x) { return; }
		sug.hidden = true; qIn.setAttribute('aria-expanded', 'false'); qIn.removeAttribute('aria-activedescendant');
		qIn.value = '';
		if (x.split) { go(x.sd, '', { split: { from: x.t.replace(/^\S+\s/, '').replace(' (옛 이름)', ''), note: x.note, to: x.split }, focus: true }); return; }
		go(x.sd, x.sg, { focus: true });
	}
	qIn.addEventListener('input', showSug);
	qIn.addEventListener('keydown', function (e) {
		if (e.key === 'ArrowDown') { e.preventDefault(); if (sug.hidden) { showSug(); } moveSug(1); }
		else if (e.key === 'ArrowUp') { e.preventDefault(); moveSug(-1); }
		else if (e.key === 'Enter') { e.preventDefault(); pickSug(sugAt > -1 ? sugAt : 0); }
		else if (e.key === 'Escape') { if (!sug.hidden) { e.preventDefault(); sug.hidden = true; qIn.setAttribute('aria-expanded', 'false'); } }
	});
	sug.addEventListener('mousedown', function (e) { e.preventDefault(); });
	sug.addEventListener('click', function (e) { var li = e.target.closest('li[data-i]'); if (li) { pickSug(+li.getAttribute('data-i')); } });
	qIn.addEventListener('blur', function () { setTimeout(function () { sug.hidden = true; qIn.setAttribute('aria-expanded', 'false'); }, 150); });

	/* ── 지역 목록(지도와 같은 선택 수단) ─────────────────── */
	var pick = $('#wmap-pick');
	function sdTotal(id) { var c = C.cnt[id]; return c.s + Object.keys(c.g).reduce(function (a, k) { return a + c.g[k]; }, 0); }
	function renderPick() {
		var h;
		if (!S.sd) {
			h = '<h2 class="wmap__h" id="wmap-pick-h">시·도 고르기</h2><ul class="wmap__list is-sd" aria-labelledby="wmap-pick-h">' + SDL.map(function (s) {
				return '<li><a href="' + esc(pageUrl(s.id, '')) + '" data-sd="' + s.id + '"><span>' + esc(s.s) + '</span><small>' + num(sdTotal(s.id)) + '건</small></a></li>';
			}).join('') + '</ul>';
		} else {
			var s = SD[S.sd], c = C.cnt[S.sd];
			if (!s.g.length) {
				h = '<h2 class="wmap__h" id="wmap-pick-h">' + esc(s.n) + '</h2><p class="wmap__one">시·군·구가 없는 단층 지역이에요. 결과가 ' + esc(s.s) + ' 전체 사업이에요.</p>';
			} else {
				h = '<h2 class="wmap__h" id="wmap-pick-h">' + esc(s.n) + '의 시·군·구</h2><ul class="wmap__list" aria-labelledby="wmap-pick-h"><li class="is-all"><a href="' + esc(pageUrl(S.sd, '')) + '" data-sd="' + S.sd + '" data-sg=""' + (!S.sg ? ' aria-current="true"' : '') + '><span>' + esc(s.s) + ' 전체 사업만</span><small>' + num(c.s) + '건</small></a></li>' + s.g.map(function (g) {
					return '<li><a href="' + esc(pageUrl(S.sd, g.id)) + '" data-sd="' + S.sd + '" data-sg="' + g.id + '"' + (g.id === S.sg ? ' aria-current="true"' : '') + '><span>' + esc(g.n) + '</span><small>' + num(c.g[g.id]) + '건</small></a></li>';
				}).join('') + '</ul>';
			}
			h += '<p class="wmap__up"><a href="' + esc(C.base) + '" data-sd="">전국 시·도 다시 고르기</a></p>';
		}
		pick.innerHTML = h;
	}
	root.addEventListener('click', function (e) {
		var a = e.target.closest('a[data-sd]');
		if (!a || e.ctrlKey || e.metaKey || e.shiftKey || e.button > 0) { return; }
		e.preventDefault();
		var sd = a.getAttribute('data-sd'), sg = a.getAttribute('data-sg') || '';
		go(sd, sg, { focus: true, from: a });
	});

	/* ── 경로·지난번 지역 ─────────────────────────────────── */
	var crumb = $('.wmap__crumb'), lastEl = $('.wmap__last'), grid = $('.wmap__grid');
	function renderCrumb() {
		crumb.hidden = !S.sd;
		if (!S.sd) { return; }
		var h = '<li><a href="' + esc(C.base) + '" data-sd="">전국</a></li>';
		h += S.sg ? '<li><a href="' + esc(pageUrl(S.sd, '')) + '" data-sd="' + S.sd + '" data-sg="">' + esc(SD[S.sd].n) + '</a></li><li aria-current="page">' + esc(SG[S.sg].n) + '</li>' : '<li aria-current="page">' + esc(SD[S.sd].n) + '</li>';
		$('ol', crumb).innerHTML = h;
		var tg = $('.wmap__tgl', crumb);
		if (!tg) {
			tg = document.createElement('button');
			tg.type = 'button'; tg.className = 'wmap__tgl'; tg.setAttribute('aria-controls', 'wmap-pick');
			crumb.insertBefore(tg, $('.wmap__clear', crumb));
		}
		tg.hidden = !S.sg;
		tg.textContent = '다른 시·군·구';
		tg.setAttribute('aria-expanded', grid.classList.contains('is-pick') ? 'true' : 'false');
	}
	crumb.addEventListener('click', function (e) {
		if (e.target.closest('.wmap__clear')) {
			remember('', '');
			go('', '', { focus: true, keepRemember: true });
			toast('고른 지역을 지웠어요');
		}
		var tg = e.target.closest('.wmap__tgl');
		if (tg) {
			var on = !grid.classList.contains('is-pick');
			grid.classList.toggle('is-pick', on);
			tg.setAttribute('aria-expanded', on ? 'true' : 'false');
			if (on) { var cur = $('a[aria-current]', pick) || $('a', pick); if (cur) { cur.focus(); } }
		}
	});
	function renderLast() {
		var r = !S.sd ? lastRegion() : null;
		lastEl.hidden = !r;
		if (r) { lastEl.innerHTML = '지난번에 본 지역 <a href="' + esc(pageUrl(r.sd, r.sg)) + '" data-sd="' + r.sd + '" data-sg="' + r.sg + '">' + esc(label(r.sd, r.sg, true)) + '</a>'; }
	}

	/* ── 지도 ───────────────────────────────────────────── */
	var svgBox = $('.wmap__svg'), geoCache = {}, geoLevel = null, tip = null;
	// 전국 지도 이름 자리: 수도권은 무게중심이 겹쳐서 옮김(경기 → 용인 근처, 인천 → 서쪽 바다 쪽)
	var LPOS = { '41': [216, 147], '28': [158, 125], '11': [200, 108], '36': [214, 206] };
	var mapFig = $('.wmap__map');
	(function mapToggle() {
		var cap = $('figcaption', mapFig), b = document.createElement('button');
		b.type = 'button'; b.className = 'wmap__mtg'; b.setAttribute('aria-expanded', 'false'); b.textContent = '지도 펼치기';
		b.addEventListener('click', function () { var on = !mapFig.classList.contains('is-open'); mapFig.classList.toggle('is-open', on); b.setAttribute('aria-expanded', on ? 'true' : 'false'); b.textContent = on ? '지도 접기' : '지도 펼치기'; if (on) { drawMap(); } });
		cap.appendChild(b);
	})();
	function geoFile(level) { return level === 'nat' ? 'sido.json' : 'sd-' + level + '.json'; }
	function mapMsg(t, err) {
		svgBox.setAttribute('data-state', err ? 'err' : 'wait');
		svgBox.innerHTML = '<p class="wmap__msg">' + esc(t) + (err ? ' <button type="button" class="wmap-retry">다시 시도</button>' : '') + '</p>';
		var b = $('.wmap-retry', svgBox);
		if (b) { b.addEventListener('click', function () { geoLevel = null; drawMap(); }); }
	}
	function drawMap() {
		if (!mapFig.classList.contains('is-open')) { return; } // 휴대폰에서 접어 둔 지도는 펼칠 때 받음
		var level = S.sd ? S.sd : 'nat';
		if (geoLevel === level && $('svg', svgBox)) { paintMap(); return; }
		geoLevel = level;
		if (geoCache[level]) { buildSvg(geoCache[level], level); return; }
		mapMsg('지도를 불러오는 중이에요…');
		fetch(C.geo + geoFile(level) + '?v=' + encodeURIComponent(C.gv)).then(function (r) { if (!r.ok) { throw new Error(); } return r.json(); })
			.then(function (j) { geoCache[level] = j; if (geoLevel === level) { buildSvg(j, level); } })
			.catch(function () { if (geoLevel === level) { geoLevel = null; mapMsg('지도를 불러오지 못했어요. 지역 검색이나 목록으로 고를 수 있어요.', true); } });
	}
	function buildSvg(j, level) {
		var nat = level === 'nat';
		var h = '<svg viewBox="0 0 ' + j.v[0] + ' ' + j.v[1] + '" role="group" aria-label="' + (nat ? '전국 시·도 지도' : esc(SD[level].n) + ' 시·군·구 지도') + '">';
		var labels = '';
		j.u.forEach(function (u) {
			var sd = nat ? u.id : level, sg = nat ? '' : u.id;
			if (nat ? !SD[sd] : (level === '36' ? false : !SG[sg])) { return; }
			var n = nat ? sdTotal(sd) : (level === '36' ? C.cnt['36'].s : C.cnt[level].g[sg]);
			var name = nat ? SD[sd].n : (level === '36' ? SD['36'].n : SG[sg].n);
			var href = level === '36' ? pageUrl('36', '') : pageUrl(sd, sg);
			h += '<a href="' + esc(href) + '" data-sd="' + sd + '" data-sg="' + sg + '" aria-label="' + esc(name) + ', 등록 정책 ' + num(n) + '건"><path d="' + u.d + '"/></a>';
			if (nat && u.c) { var lp = LPOS[sd] || u.c; labels += '<text x="' + lp[0] + '" y="' + lp[1] + '">' + esc(SD[sd].s) + '</text>'; }
		});
		h += '<g class="wmap__lb" aria-hidden="true">' + labels + '</g></svg>';
		svgBox.innerHTML = h + (j.note ? '<p class="wmap__note">' + esc(j.note) + '</p>' : '');
		svgBox.setAttribute('data-state', 'ok');
		$('.wmap__mt', mapFig).textContent = nat ? '지도에서 시·도 고르기' : (level === '36' ? '세종특별자치시' : '지도에서 ' + SD[level].s + ' 시·군·구 고르기');
		paintMap();
	}
	function paintMap() {
		all('a', svgBox).forEach(function (a) {
			var on = S.sd && (geoLevel === 'nat' ? a.getAttribute('data-sd') === S.sd : (a.getAttribute('data-sg') === S.sg || geoLevel === '36'));
			a.classList.toggle('is-on', !!on);
			if (on) { a.setAttribute('aria-current', 'true'); } else { a.removeAttribute('aria-current'); }
			if (on && a.parentNode.lastElementChild !== a) { a.parentNode.insertBefore(a, a.parentNode.querySelector('.wmap__lb')); } // 굵은 테두리가 이웃에 가리지 않게 뒤로
		});
		var sel = $('a.is-on', svgBox);
		showTip(sel && geoLevel !== 'nat' && geoLevel !== '36' ? sel : null, true);
	}
	function showTip(a, sticky) {
		if (!tip) { tip = document.createElement('div'); tip.className = 'wmap__tip'; tip.setAttribute('aria-hidden', 'true'); svgBox.parentNode.appendChild(tip); }
		if (!a) { if (!sticky) { var s = $('a.is-on', svgBox); if (s && geoLevel !== 'nat' && geoLevel !== '36') { a = s; } } if (!a) { tip.hidden = true; return; } }
		var r = a.getBoundingClientRect(), b = svgBox.parentNode.getBoundingClientRect();
		tip.textContent = a.getAttribute('aria-label').replace(', 등록 정책', ' ·');
		tip.hidden = false;
		tip.style.left = Math.max(4, Math.min(b.width - 8, r.left - b.left + r.width / 2)) + 'px';
		tip.style.top = Math.max(0, r.top - b.top) + 'px';
	}
	svgBox.addEventListener('mouseover', function (e) { var a = e.target.closest('a'); if (a) { showTip(a); } });
	svgBox.addEventListener('mouseleave', function () { showTip(null); });
	svgBox.addEventListener('focusin', function (e) { var a = e.target.closest('a'); if (a) { showTip(a); } });
	svgBox.addEventListener('focusout', function () { showTip(null); });

	/* ── 결과 ───────────────────────────────────────────── */
	var main = $('#wmap-main');
	function matchF(c, skipSt) {
		var f = S.f;
		if (f.life.length && c.l.length && !any(c.l, f.life)) { return false; }
		if (f.hh.length && !any(c.h, f.hh)) { return false; }
		if (f.th.length && !any(c.t, f.th)) { return false; }
		if (!skipSt && f.st.length && !has(f.st, statusNow(c.st))) { return false; }
		if (f.q) { var q = nz(f.q).toLowerCase(); if ((nz(c.n) + nz(c.o)).toLowerCase().indexOf(q) < 0) { return false; } }
		return true;
	}
	function groupsOf(d) {
		var gs = [];
		if (d.sg) { gs.push({ k: 'sgg', t: SG[d.sg].n + ' 사업', list: d.groups.sgg }); }
		gs.push({ k: 'sido', t: SD[d.sd].n + (d.sd === '36' ? ' 사업' : ' 전체 사업'), list: d.groups.sido });
		gs.push({ k: 'nation', t: '전국 공통 사업', list: S.nation || null });
		if (d.groups.check.length) { gs.push({ k: 'check', t: '적용 지역 확인 중인 ' + SD[d.sd].s + ' 사업', list: d.groups.check }); }
		return gs;
	}
	function card(c) {
		var now = statusNow(c.st), st = c.st, per = '';
		if (st.k === 'period') {
			var dd = now === 'open' ? days(T, st.e) : (now === 'soon' ? days(T, st.s) : null);
			per = '<p class="wmap-c__per">' + (st.s ? esc(md(st.s, true)) + ' ~ ' : '~ ') + esc(md(st.e, true)) + (dd !== null ? ' <b class="wmap-dd">' + (dd === 0 ? (now === 'open' ? '오늘 마감' : '오늘 시작') : (now === 'open' ? '마감 D-' : '시작 D-') + dd) + '</b>' : '') + ' <small>' + (st.src === 'cal' ? '복지 캘린더 기준' : '이지복지 확인') + '</small></p>';
		} else if (st.k === 'always') {
			per = '<p class="wmap-c__per">상시 신청 <small>이지복지 확인</small></p>';
		} else if (st.why === 'cal-wait') {
			per = '<p class="wmap-c__per is-wait">캘린더 일정 확인 중</p>';
		}
		var dl = '<div><dt>대상</dt><dd>' + esc(c.tg || '원문에서 확인') + '</dd></div>' + (c.bn ? '<div><dt>혜택</dt><dd>' + esc(c.bn) + '</dd></div>' : (c.sm ? '<div><dt>목적</dt><dd>' + esc(c.sm) + '</dd></div>' : ''));
		var ft = [];
		if (c.m) { ft.push('복지로 수정 ' + ymdDot(c.m)); }
		if (st.chk) { ft.push('이지복지 확인 ' + ymdDot(st.chk)); }
		var old = c.m && days(c.m, T) > 540;
		var links = '';
		if (c.p && c.p.length) { links += c.p.map(function (p) { return '<a class="wmap-c__post" href="' + esc(p.u) + '">쉽게 읽는 안내: ' + esc(p.t) + '</a>'; }).join(''); }
		if (st.src === 'cal' || st.cal) { links += '<a class="wmap-c__cal" href="' + esc(calUrl()) + '">' + ic('cal') + '복지 캘린더에서 일정·알림</a>'; }
		return '<li class="wmap-c" data-i="' + esc(c.i) + '" tabindex="-1"><div class="wmap-c__hd"><span class="wmap-st is-' + now + '">' + LABEL[now] + '</span><span class="wmap-c__area">' + esc(c.a) + '</span></div>'
			+ '<h3 class="wmap-c__t">' + esc(c.n) + '</h3><p class="wmap-c__o">' + esc(c.o) + '</p><dl class="wmap-c__dl">' + dl + '</dl>' + per
			+ (c.nt ? '<p class="wmap-c__nt">' + esc(c.nt) + '</p>' : '')
			+ (old ? '<p class="wmap-c__nt is-old">복지로 원문이 1년 반 넘게 수정되지 않았어요. 지금도 하는지 담당 기관에 확인해 주세요.</p>' : '')
			+ (links ? '<p class="wmap-c__links">' + links + '</p>' : '')
			+ '<div class="wmap-c__ft"><span class="wmap-c__dt">' + (ft.length ? esc(ft.join(' · ')) : '수정일 정보 없음') + '</span>'
			+ (c.u ? '<a class="wmap-c__src" href="' + esc(c.u) + '" target="_blank" rel="noopener">공식 정보 보기' + ic('ext') + '<span class="screen-reader-text"> - ' + esc(c.n) + ' (복지로, 새 창)</span></a>' : '<span class="wmap-c__src is-none">공식 주소 없음</span>')
			+ '</div></li>';
	}

	function chips(key, list, more, names) {
		return list.map(function (v, i) {
			return '<button type="button" class="wmap-chip' + (more && i >= more ? ' is-x' : '') + '" data-f="' + key + '" data-v="' + esc(v) + '" aria-pressed="' + (has(S.f[key], v) ? 'true' : 'false') + '"' + (more && i >= more && !has(S.f[key], v) ? ' hidden' : '') + '>' + esc(names ? names[v] : v) + '<em></em></button>';
		}).join('');
	}
	function themesOf(d) {
		var cnt = {};
		[d.groups.sgg, d.groups.sido].forEach(function (l) { l.forEach(function (c) { c.t.forEach(function (t) { cnt[t] = (cnt[t] || 0) + 1; }); }); });
		(S.nation || []).forEach(function (c) { c.t.forEach(function (t) { cnt[t] = (cnt[t] || 0) + 1; }); });
		var keys = Object.keys(cnt);
		keys.sort(function (a, b) { var x = TH_TOP.indexOf(a), y = TH_TOP.indexOf(b); x = x < 0 ? 99 : x; y = y < 0 ? 99 : y; return x - y || cnt[b] - cnt[a]; });
		return keys;
	}
	function filtersHtml(d) {
		var th = themesOf(d);
		return '<div class="wmap-f" role="group" aria-labelledby="wmap-f-h"><h2 class="screen-reader-text" id="wmap-f-h">결과 좁히기</h2>'
			+ '<div class="wmap-f__r"><span class="wmap-f__l" id="wmap-fl1">대상</span><div class="wmap-f__c" role="group" aria-labelledby="wmap-fl1">' + chips('life', LIFE) + '<span class="wmap-f__sep" aria-hidden="true"></span>' + chips('hh', HH) + '</div></div>'
			+ '<div class="wmap-f__r"><span class="wmap-f__l" id="wmap-fl2">지원 분야</span><div class="wmap-f__c" role="group" aria-labelledby="wmap-fl2">' + chips('th', th, 8) + (th.length > 8 ? '<button type="button" class="wmap-f__more" aria-expanded="false">+' + (th.length - 8) + ' 더 보기</button>' : '') + '</div></div>'
			+ '<div class="wmap-f__r"><span class="wmap-f__l" id="wmap-fl3">신청 상태</span><div class="wmap-f__c" role="group" aria-labelledby="wmap-fl3">' + chips('st', ORDER, 0, LABEL) + '</div></div>'
			+ '<div class="wmap-f__r wmap-f__r--q"><label class="wmap-f__l" for="wmap-fq">사업 이름</label><input id="wmap-fq" type="search" value="' + esc(S.f.q) + '" placeholder="예: 교복, 산후조리"><button type="button" class="wmap-f__reset">조건 풀기</button></div>'
			+ '<p class="wmap-f__note">생애주기 구분이 없는 사업은 대상 조건과 상관없이 함께 보여요. \'접수 중\'은 기간이 확인된 사업만이에요.</p>'
			+ '<p class="wmap-f__sum" aria-live="polite"></p></div>';
	}

	function render(d, opt) {
		opt = opt || {};
		S.data = d;
		if (!d.ok) { main.innerHTML = '<div class="wmap-err" role="alert"><p>' + esc(d.msg || '지역을 찾지 못했어요.') + '</p><p><a class="wmap-btn" href="' + esc(C.base) + '" data-sd="">전국 지도로</a></p></div>'; return; }
		if (d.split) {
			main.innerHTML = '<div class="wmap-split" tabindex="-1"><h2>' + esc(SD[d.sd].n + ' ' + d.split.from) + '</h2><p>' + esc(d.split.note) + ' 지금 사는 곳을 골라 주세요.</p><p class="wmap-split__b">' + d.split.choices.map(function (c) { return '<a class="wmap-btn" href="' + esc(pageUrl(d.sd, c.id)) + '" data-sd="' + d.sd + '" data-sg="' + c.id + '">' + esc(c.n) + '</a>'; }).join('') + '</p></div>';
			return;
		}
		var s = SD[d.sd], g = d.sg ? SG[d.sg] : null, gr = d.groups;
		// 목록·지도 건수를 방금 받은 결과에 맞춤(페이지가 캐시돼 있어도 같은 숫자)
		var cc = C.cnt[d.sd], before = JSON.stringify(cc);
		cc.s = gr.sido.length; cc.c = gr.check.length;
		if (g) { cc.g[d.sg] = gr.sgg.length; }
		if (JSON.stringify(cc) !== before) { renderPick(); geoLevel = null; drawMap(); }
		var saved = (lget('eb_saved') || []).some(function (x) { return x && x.u === pageUrl(d.sd, d.sg); });
		var h = '<header class="wmap-hd" tabindex="-1"><p class="wmap-hd__eb">고른 지역</p><h2 class="wmap-hd__t">' + esc(label(d.sd, d.sg)) + '</h2>'
			+ (opt.moved ? '<p class="wmap-hd__moved">옛 지역 이름으로 연 주소예요. 지금 행정구역인 ' + esc(label(d.sd, d.sg)) + '(으)로 보여 드려요.</p>' : '')
			+ '<p class="wmap-hd__n">등록된 정책 ' + (g ? esc(g.n) + ' ' + gr.sgg.length + '건 · ' : '') + esc(s.s) + ' 전체 ' + gr.sido.length + '건 · 전국 공통 ' + d.nation_n + '건' + (gr.check.length ? ' · 지역 확인 중 ' + gr.check.length + '건' : '') + '</p>'
			+ '<p class="wmap-hd__warn">지역을 골랐다고 지원 대상이 되는 건 아니에요. 나이·소득 같은 자격은 사업마다 달라요.</p>'
			+ '<div class="wmap-hd__act"><a class="wmap-btn is-main" href="' + esc(findUrl()) + '">' + ic('find') + '내 조건으로 더 좁히기</a>'
			+ '<a class="wmap-btn" href="' + esc(calUrl()) + '">' + ic('cal') + '이 지역 일정</a>'
			+ '<button type="button" class="wmap-ib wmap-save" aria-pressed="' + saved + '" aria-label="' + (saved ? '저장됨 · 누르면 저장 취소' : '이 지역 저장') + '" title="' + (saved ? '저장됨' : '이 지역 저장') + '">' + ic('star') + '</button>'
			+ '<button type="button" class="wmap-ib wmap-share" aria-label="이 지역 화면 공유" title="공유">' + ic('share') + '</button></div></header>';
		h += filtersHtml(d);
		h += '<div class="wmap-gs"></div>';
		h += relatedHtml(d);
		main.innerHTML = h;
		S.shown = {};
		renderGroups();
		paintChips();
		if (opt.focus) { var hd = $('.wmap-hd', main); if (hd) { hd.focus({ preventScroll: true }); if (window.innerWidth < 1080) { hd.scrollIntoView({ block: 'start', behavior: reduce ? 'auto' : 'smooth' }); } } }
		if (!S.nation) { loadNation(); }
	}

	function renderGroups() {
		var d = S.data, box = $('.wmap-gs', main);
		if (!d || !box) { return; }
		var total = 0, h = '';
		groupsOf(d).forEach(function (g) {
			if (!g.list) { h += '<section class="wmap-g" data-g="' + g.k + '"><h2 class="wmap-g__h">' + esc(g.t) + ' <b>' + d.nation_n + '</b></h2><p class="wmap-empty">' + (S.nationErr ? '전국 공통 목록을 불러오지 못했어요. <button type="button" class="wmap-retry" data-retry="nation">다시 시도</button>' : '불러오는 중이에요…') + '</p></section>'; return; }
			var list = g.list.filter(function (c) { return matchF(c); });
			total += g.k === 'check' ? 0 : list.length;
			var lim = S.shown[g.k] || (g.k === 'nation' ? 5 : PAGE);
			var cnt = list.length === g.list.length ? '<b>' + g.list.length + '</b>' : '<b>' + list.length + '</b><small> / ' + g.list.length + '</small>';
			var body = list.length ? '<ul class="wmap-g__l">' + list.slice(0, lim).map(card).join('') + '</ul>' : '<p class="wmap-empty">' + (g.list.length ? '조건에 맞는 사업이 없어요.' : '등록된 사업이 없어요.') + '</p>';
			var more = list.length > lim ? '<button type="button" class="wmap-more" data-g="' + g.k + '">' + Math.min(20, list.length - lim) + '건 더 보기 <small>(' + (list.length - lim) + '건 남음)</small></button>' : '';
			if (g.k === 'check') {
				h += '<details class="wmap-g is-check" data-g="check"' + (S.openCheck ? ' open' : '') + '><summary><h2 class="wmap-g__h">' + esc(g.t) + ' ' + cnt + '</h2></summary><p class="wmap-g__d">복지로 원문에 시·군·구가 비어 있거나 옛 지역 이름이라, 이 시·군·구에 해당하는지 아직 확인하지 못한 사업이에요. 내용을 보고 담당 기관에 확인해 주세요.</p>' + body + more + '</details>';
			} else {
				h += '<section class="wmap-g" data-g="' + g.k + '"><h2 class="wmap-g__h">' + esc(g.t) + ' ' + cnt + '</h2>' + body + more + '</section>';
			}
		});
		var anyF = S.f.life.length || S.f.hh.length || S.f.th.length || S.f.st.length || S.f.q;
		if (anyF && !total && S.nation) { h = '<div class="wmap-none" role="status"><p><b>고른 조건에 맞는 사업이 없어요.</b> 조건을 하나씩 풀어 보세요.</p><button type="button" class="wmap-btn wmap-f__reset">조건 모두 풀기</button></div>' + h; }
		box.innerHTML = h;
		var sum = $('.wmap-f__sum', main);
		if (sum) { sum.textContent = anyF ? '조건에 맞는 사업 ' + total + '건' + (S.nation ? '' : ' (전국 공통 제외)') : ''; }
		var det = $('details.is-check', box);
		if (det) { det.addEventListener('toggle', function () { S.openCheck = det.open; }); }
	}

	function paintChips() {
		var d = S.data;
		if (!d || !d.groups) { return; }
		var pool = [].concat(d.sg ? d.groups.sgg : [], d.groups.sido, S.nation || []);
		all('.wmap-chip', main).forEach(function (b) {
			var k = b.getAttribute('data-f'), v = b.getAttribute('data-v');
			b.setAttribute('aria-pressed', has(S.f[k], v) ? 'true' : 'false');
			var n = 0;
			pool.forEach(function (c) {
				if (k === 'st') { if (matchF(c, true) && statusNow(c.st) === v) { n++; } return; }
				var save = S.f[k]; S.f[k] = [v];
				if (matchF(c)) { n++; }
				S.f[k] = save;
			});
			$('em', b).textContent = n;
			b.classList.toggle('is-zero', !n && !has(S.f[k], v));
		});
	}

	function relatedHtml(d) {
		var h = '<div class="wmap-rel">';
		// 신청 일정(복지 캘린더)
		var cal = d.cal || { n: 0, items: [] };
		h += '<section class="wmap-box" aria-labelledby="wmap-cal-h"><h2 id="wmap-cal-h">' + ic('cal') + '가까운 신청 일정</h2>';
		if (cal.items.length) {
			h += '<ul class="wmap-cal">' + cal.items.map(function (x) {
				var open = (!x.s || x.s <= T) && T <= x.e, dd = open ? days(T, x.e) : days(T, x.s);
				return '<li><span class="wmap-dd">' + (open ? (dd ? '마감 D-' + dd : '오늘 마감') : (dd ? '시작 D-' + dd : '오늘 시작')) + '</span><span><b>' + esc(x.n) + '</b><small>' + (x.s ? esc(md(x.s, true)) + ' ~ ' : '~ ') + esc(md(x.e, true)) + '</small></span></li>';
			}).join('') + '</ul>';
		} else {
			h += '<p>이 지역에서 확인된 신청 일정이 아직 없어요. 전국 일정과 지급일은 복지 캘린더에서 볼 수 있어요.</p>';
		}
		h += '<a class="wmap-box__go" href="' + esc(calUrl()) + '">' + esc(label(d.sd, d.sg, true)) + ' 일정 모두 보기 ›</a><p class="wmap-box__s">알림은 복지 캘린더의 종 버튼으로 켤 수 있어요.</p></section>';
		// 신청할 곳
		h += '<section class="wmap-box" aria-labelledby="wmap-near-h"><h2 id="wmap-near-h">' + ic('pin') + '신청할 곳 찾기</h2><p>정확한 관할 주민센터·보건소는 주소를 넣어 확인해 주세요. 지도에서 고른 지역만으로는 특정 기관을 정하지 않아요.</p><a class="wmap-box__go" href="' + esc(C.near) + '">우리 동네 복지 기관 찾기 ›</a></section>';
		// 상황별 가이드(이 지역 사업 중 그 상황과 맞는 수)
		var pool = [].concat(d.sg ? d.groups.sgg : [], d.groups.sido);
		var gs = (C.guides || []).map(function (g) {
			var c = g.c, n = pool.filter(function (x) { return (c.life && has(x.l, c.life)) || (c.hh && c.hh.length && any(x.h, c.hh)) || (c.th && c.th.length && any(x.t, c.th)); }).length;
			return { g: g, n: n };
		}).filter(function (x) { return x.n; }).sort(function (a, b) { return b.n - a.n; }).slice(0, 4);
		if (gs.length) {
			h += '<section class="wmap-box" aria-labelledby="wmap-gd-h"><h2 id="wmap-gd-h">상황별 가이드</h2><p class="wmap-box__s">이 지역 사업 중 그 상황과 맞는 수예요.</p><ul class="wmap-gd">' + gs.map(function (x) { return '<li><a href="' + esc(x.g.u) + '">' + esc(x.g.n) + '<em>' + x.n + '건</em></a></li>'; }).join('') + '</ul></section>';
		}
		// 정리 글: 이 시·도 대상 글 먼저, 그다음 고른 조건과 겹치는 글
		var posts = (C.posts || []).map(function (p) {
			var sc = has(p.r, d.sd) ? 100 : (p.r.length ? -1 : 0);
			S.f.life.forEach(function (v) { if (has(p.l, v)) { sc += 3; } });
			S.f.hh.forEach(function (v) { if (has(p.h, v)) { sc += 3; } });
			S.f.th.forEach(function (v) { if (has(p.th, v)) { sc += 2; } });
			return { p: p, sc: sc + (p.p ? 1 : 0) };
		}).filter(function (x) { return x.sc > 1; }).sort(function (a, b) { return b.sc - a.sc; }).slice(0, 4);
		if (posts.length) {
			var sv = lget('eb_saved') || [];
			h += '<section class="wmap-box wmap-posts" aria-labelledby="wmap-ps-h"><h2 id="wmap-ps-h">쉽게 읽는 정리 글</h2><ul>' + posts.map(function (x) {
				var on = sv.some(function (s) { return s && s.u === x.p.u; });
				return '<li><a href="' + esc(x.p.u) + '">' + (has(x.p.r, d.sd) ? '<em>' + esc(SD[d.sd].s) + '</em>' : '') + esc(x.p.t) + '</a><button type="button" class="wmap-ib wmap-psave" data-u="' + esc(x.p.u) + '" data-t="' + esc(x.p.t) + '" aria-pressed="' + on + '" aria-label="' + esc(x.p.t) + (on ? ' 저장됨 · 누르면 취소' : ' 저장') + '">' + ic('star') + '</button></li>';
			}).join('') + '</ul><a class="wmap-box__go" href="' + esc(C.saved) + '">저장한 글 보기 ›</a></section>';
		}
		return h + '</div>';
	}

	/* ── 결과 영역 이벤트 ─────────────────────────────────── */
	var qTimer;
	main.addEventListener('click', function (e) {
		var b = e.target.closest('.wmap-chip');
		if (b) {
			var k = b.getAttribute('data-f'), v = b.getAttribute('data-v');
			S.f[k] = has(S.f[k], v) ? S.f[k].filter(function (x) { return x !== v; }) : S.f[k].concat(v);
			S.shown = {};
			renderGroups(); paintChips(); syncUrl(false);
			return;
		}
		if (e.target.closest('.wmap-f__reset')) {
			S.f = { life: [], hh: [], th: [], st: [], q: '' };
			var fq = $('#wmap-fq', main); if (fq) { fq.value = ''; }
			S.shown = {}; renderGroups(); paintChips(); syncUrl(false);
			var first = $('.wmap-chip', main); if (first && e.target.closest('.wmap-none')) { first.focus(); }
			return;
		}
		var m = e.target.closest('.wmap-f__more');
		if (m) {
			var on = m.getAttribute('aria-expanded') !== 'true';
			all('.wmap-chip.is-x', main).forEach(function (x) { if (!has(S.f.th, x.getAttribute('data-v'))) { x.hidden = !on; } });
			m.setAttribute('aria-expanded', on ? 'true' : 'false');
			m.textContent = on ? '접기' : '+' + all('.wmap-chip.is-x', main).length + ' 더 보기';
			return;
		}
		var mo = e.target.closest('.wmap-more');
		if (mo) {
			var gk = mo.getAttribute('data-g'), sec = mo.parentNode, before = all('.wmap-c', sec).length;
			S.shown[gk] = before + 20;
			renderGroups();
			var nsec = $('[data-g="' + gk + '"]', $('.wmap-gs', main)), nxt = nsec && all('.wmap-c', nsec)[before];
			if (nxt) { nxt.focus({ preventScroll: true }); }
			return;
		}
		if (e.target.closest('.wmap-retry')) { S.nationErr = false; renderGroups(); loadNation(); return; }
		if (e.target.closest('.wmap-save')) { toggleSave(pageUrl(S.sd, S.sg), label(S.sd, S.sg) + ' 복지지도', e.target.closest('.wmap-save')); return; }
		var ps = e.target.closest('.wmap-psave');
		if (ps) { toggleSave(ps.getAttribute('data-u'), ps.getAttribute('data-t'), ps); return; }
		if (e.target.closest('.wmap-share')) {
			var u = pageUrl(S.sd, S.sg), t = label(S.sd, S.sg) + ' 복지정책 - 이지복지닷컴';
			if (navigator.share) { navigator.share({ title: t, url: u }).catch(function () {}); return; }
			if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(u).then(function () { toast('링크를 복사했어요'); }, function () { window.prompt('이 주소를 복사해 주세요', u); }); }
			else { window.prompt('이 주소를 복사해 주세요', u); }
		}
	});
	main.addEventListener('input', function (e) {
		if (e.target.id !== 'wmap-fq') { return; }
		clearTimeout(qTimer);
		qTimer = setTimeout(function () { S.f.q = e.target.value.trim(); S.shown = {}; renderGroups(); paintChips(); syncUrl(false); }, 250);
	});
	function toggleSave(u, t, btn) {
		var list = lget('eb_saved') || [], on = list.some(function (x) { return x && x.u === u; });
		list = on ? list.filter(function (x) { return x.u !== u; }) : [{ u: u, t: t, d: Date.now() }].concat(list).slice(0, 50);
		lset('eb_saved', list);
		try { document.dispatchEvent(new CustomEvent('eb:saved')); } catch (e) {}
		btn.setAttribute('aria-pressed', on ? 'false' : 'true');
		toast(on ? '저장을 취소했어요' : '저장했어요 · 메뉴의 \'저장한 글\'에서 다시 볼 수 있어요');
	}

	/* ── 불러오기 ────────────────────────────────────────── */
	function loadNation() {
		if (S.nationReq) { return; }
		S.nationReq = true;
		api('nation').then(function (j) { S.nation = j.items || []; S.nationReq = false; renderGroups(); paintChips(); var gs = $('.wmap-gd', main); if (!gs) { /* 가이드 수는 지역 사업 기준이라 그대로 */ } })
			.catch(function () { S.nationReq = false; S.nationErr = true; renderGroups(); });
	}
	function loading() {
		main.setAttribute('aria-busy', 'true');
		var hd = $('.wmap-hd', main);
		main.innerHTML = '<div class="wmap-load" role="status"><span class="wmap-spin" aria-hidden="true"></span>' + esc(label(S.sd, S.sg)) + ' 정책을 불러오는 중이에요…</div>';
		if (hd) { /* 이전 머리는 지움 */ }
	}
	function load(opt) {
		var my = ++S.req;
		if (!S.sd) {
			main.innerHTML = '<div class="wmap-intro"><h2>어느 지역을 볼까요?</h2><p>시·도를 고르면 시·군·구 목록이 나와요. 시·군·구까지 고르면 <b>시·군·구 사업 · 시·도 사업 · 전국 공통 사업</b>을 나눠 보여 드려요.</p><p class="wmap-intro__n">전국 공통 사업 <b>' + num(C.nation) + '건</b>은 어느 지역을 골라도 함께 보여요.</p></div>';
			S.data = null;
			return;
		}
		if (opt.split) {
			render({ ok: true, sd: S.sd, split: { from: opt.split.from, note: opt.split.note, choices: opt.split.to.map(function (id) { return { id: id, n: SG[id] ? SG[id].n : id }; }) } });
			return;
		}
		loading();
		api('region?sd=' + encodeURIComponent(SD[S.sd].n) + '&sg=' + encodeURIComponent(S.sg ? SG[S.sg].n : '')).then(function (j) {
			if (my !== S.req) { return; }
			main.removeAttribute('aria-busy');
			render(j, opt);
		}).catch(function () {
			if (my !== S.req) { return; }
			main.removeAttribute('aria-busy');
			main.innerHTML = '<div class="wmap-err" role="alert"><p><b>정책 목록을 불러오지 못했어요.</b> 잠시 뒤 다시 시도해 주세요. 지역 목록과 지도는 그대로 쓸 수 있어요.</p><p><button type="button" class="wmap-btn wmap-reload">다시 시도</button> <a class="wmap-btn" href="' + esc(findUrl()) + '">맞춤 찾기로 찾기</a></p></div>';
			var rb = $('.wmap-reload', main); if (rb) { rb.addEventListener('click', function () { load(opt); }); rb.focus(); }
		});
	}

	/* ── 지역 바꾸기 ─────────────────────────────────────── */
	function go(sd, sg, opt) {
		opt = opt || {};
		if (sd && !SD[sd]) { return; }
		if (sg && !SG[sg]) { sg = ''; }
		if (sd === '36') { sg = ''; }
		var changed = sd !== S.sd || sg !== S.sg || opt.split;
		S.sd = sd; S.sg = sg;
		grid.classList.toggle('has-sd', !!sd);
		grid.classList.toggle('has-sg', !!sg);
		grid.classList.remove('is-pick');
		if (!opt.noPush && changed) { syncUrl(true); }
		if (sd && !opt.keepRemember && !opt.split) { remember(sd, sg); }
		renderCrumb(); renderPick(); renderLast(); drawMap();
		load(opt);
		if (opt.focus && !sd) { var f = $('a', pick); if (f) { f.focus(); } }
		document.title = (sd ? label(sd, sg) + ' 복지정책 - ' : '') + baseTitle;
	}
	var baseTitle = document.title.replace(/^.+? 복지정책 - /, '');
	window.addEventListener('popstate', function () {
		var u = readUrl();
		if (u.bad) { go('', '', { noPush: true }); return; }
		go(u.sd, u.sg, { noPush: true, split: u.split, moved: u.moved });
	});

	/* ── 시작 ───────────────────────────────────────────── */
	(function start() {
		var u = readUrl();
		S.sd = u.sd; S.sg = u.sg;
		grid.classList.toggle('has-sd', !!u.sd);
		grid.classList.toggle('has-sg', !!u.sg);
		renderCrumb(); renderPick(); renderLast();
		if (window.matchMedia('(min-width: 768px)').matches) { mapFig.classList.add('is-open'); $('.wmap__mtg', mapFig).setAttribute('aria-expanded', 'true'); $('.wmap__mtg', mapFig).textContent = '지도 접기'; }
		drawMap();
		if (u.bad) { main.innerHTML = '<div class="wmap-err" role="alert"><p>주소의 지역을 찾지 못했어요. 목록이나 검색으로 다시 골라 주세요.</p></div>'; S.sd = ''; S.sg = ''; renderCrumb(); renderPick(); return; }
		if (u.split) { load({ split: u.split }); return; }
		if (C.init && C.init.ok && C.init.sd === u.sd && (C.init.sg || '') === u.sg && C.init.groups) {
			render(C.init, { moved: u.moved });
			remember(u.sd, u.sg);
		} else if (u.sd) {
			remember(u.sd, u.sg);
			load({ moved: u.moved });
		}
		// 옛 이름 주소는 지금 이름으로 바꿔 둠(공유·새로고침)
		if (u.sd && u.moved) { syncUrl(false); }
		if (u.sd) { document.title = label(u.sd, u.sg) + ' 복지정책 - ' + baseTitle; }
		// 다른 탭에서 지역을 바꾸면(캘린더 등) 지난번 지역 버튼만 새로
		window.addEventListener('storage', function (e) { if (e.key === 'ebs_region' || e.key === 'eb_finder_last') { renderLast(); } });
		window.addEventListener('resize', function () { var s = $('a.is-on', svgBox); if (s && tip && !tip.hidden) { showTip(s, true); } });
	})();
})();
