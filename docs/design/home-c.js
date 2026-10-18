// 시안 C 구조 바꾸기(실제 적용 땐 functions.php 48번 eb_hero_v3_html의 HTML을 이 모양으로 출력)
(function () {
	var q = function (s) { return document.querySelector(s); };
	var find = q('.hx__pane[data-pane=find]'), sent = q('.hx__sent'), go = q('.hx__go'), num = q('.hx__num'), map = q('.hx__fc > .hx__map');
	if (!find || !sent || q('.hx__ctl')) { return; }
	// 카드 머리: 제목 + (고르기 전) 안내 / (고른 뒤) 받을 수 있는 혜택 N개  ·  오른쪽 '지도로 찾기'
	var head = document.createElement('div');
	head.className = 'hx__fh';
	head.innerHTML = '<div class="hx__fhl"><h2>내 조건으로 찾기</h2></div>';
	if (num) { head.firstChild.appendChild(num); }
	if (map) { var ms = map.querySelector('span'); if (ms) { ms.textContent = '지도로 찾기'; } head.appendChild(map); }
	find.insertBefore(head, find.firstChild);
	// 조작 칸: [나이·시기] [사는 곳] [+ 조건 더하기] [혜택 보기]
	var ctl = document.createElement('div');
	ctl.className = 'hx__ctl';
	[].slice.call(sent.querySelectorAll('.hx__pick')).forEach(function (b) { ctl.appendChild(b); });
	var more = ctl.querySelector('.is-more');
	if (more) { [].slice.call(more.childNodes).forEach(function (n) { if (n.nodeType === 3 && n.textContent.trim()) { n.textContent = '조건 더하기'; } }); var sp = more.querySelector('span'); if (sp) { sp.textContent = '조건 더하기'; } }
	// 화면 스크립트가 고른 뒤 문구를 '가구·필요한 도움 더하기'로 되돌려서 잘림 → 실제 적용 땐 functions.php의 그 문구도 '조건 더하기'로
	if (more && window.MutationObserver) { new MutationObserver(function () { var sp2 = more.querySelector('span'); if (sp2 && sp2.textContent !== '조건 더하기' && sp2.textContent.indexOf('더하기') > -1) { sp2.textContent = '조건 더하기'; } }).observe(more, { subtree: true, childList: true, characterData: true }); }
	if (go) { if (go.firstChild && go.firstChild.nodeType === 3) { go.firstChild.textContent = '혜택 보기'; } ctl.appendChild(go); }
	sent.parentNode.insertBefore(ctl, sent.nextSibling);
	sent.setAttribute('aria-hidden', 'true');
	// 제목 한 줄로
	var h1 = q('.hx__h1');
	if (h1) { [].slice.call(h1.childNodes).forEach(function (n) { if (n.nodeType === 3 && n.textContent.indexOf('알 수 있어요') > -1) { n.textContent = n.textContent.replace('알 수 있어요', '알아요'); } }); }
	// 일정 제목
	var tm = q('.hx__t-m'), tp = q('.hx__t-pc');
	if (tm) { tm.textContent = '다가오는 일정'; }
	if (tp) { tp.textContent = '다가오는 일정'; }
})();
