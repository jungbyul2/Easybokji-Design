// 시안 B 문구 변경(실제 적용 땐 functions.php 48번·복지지도 page.php에서 바꿈)
(function () {
	var q = function (s) { return document.querySelector(s); };
	var find = q('.hx__pane[data-pane=find]'), sent = q('.hx__sent');
	if (find && sent && !q('.hx__fh')) {
		var h = document.createElement('div');
		h.className = 'hx__fh';
		h.innerHTML = '<h2>내 조건으로 찾기</h2><p>나이와 사는 곳만 고르면 돼요</p>';
		find.insertBefore(h, find.firstChild);
	}
	var go = q('.hx__go');
	if (go && go.firstChild && go.firstChild.nodeType === 3) { go.firstChild.textContent = '받을 수 있는 혜택 보기'; }
	var m = q('.hx__fc > .hx__map span');
	if (m) { m.innerHTML = '지도로 우리 지역 혜택 보기<small>시·군·구별</small>'; }
	var t = q('.hx__t-m');
	if (t) { t.innerHTML = '다가오는 <em>복지 일정</em>'; }
})();
