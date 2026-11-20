/* Ferienwohnung Elias – Website-Skripte */
(function () {
	'use strict';
	var D = window.FEWO || { t: {}, prices: {}, booked: [], lang: 'de', locale: 'de-AT' };
	var T = D.t;
	var $ = function (s, r) { return (r || document).querySelector(s); };
	var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* ---------- Kopfzeile & mobile Leiste ---------- */
	var header = $('#site-header'), mbar = $('#mbar');
	var solid = header && header.classList.contains('solid');
	function onScroll() {
		if (header && !solid) header.classList.toggle('scrolled', window.scrollY > 10);
		if (mbar) mbar.classList.toggle('show', window.scrollY > 600);
	}
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	var menuBtn = $('.menu-btn'), links = $('#links');
	if (menuBtn && links) {
		menuBtn.addEventListener('click', function () {
			var open = links.classList.toggle('open');
			menuBtn.setAttribute('aria-expanded', open);
		});
		links.addEventListener('click', function (e) {
			if (e.target.tagName === 'A') { links.classList.remove('open'); menuBtn.setAttribute('aria-expanded', 'false'); }
		});
	}

	/* ---------- Einblenden & Zähler ---------- */
	var revealSel = '.front :is(.eyebrow, .fewo-section > h2, .fewo-section > .intro, .fact, .fewo-gallery, .amen-card, .cal-card, .calc-card, .map-card, .faq-list > *, .contact, .hero-copy > *, .hero-visual)';
	function countUp(el) {
		var m = el.textContent.match(/^(\D*)(\d+)(.*)$/);
		if (!m || reduce) return;
		var end = +m[2], t0 = null;
		function step(ts) {
			if (t0 === null) t0 = ts;
			var p = Math.min((ts - t0) / 1200, 1);
			el.textContent = m[1] + Math.round(end * (1 - Math.pow(1 - p, 3))) + m[3];
			if (p < 1) requestAnimationFrame(step);
		}
		el.textContent = m[1] + '0' + m[3];
		requestAnimationFrame(step);
	}
	var targets = [];
	try { targets = $$(revealSel); } catch (e) { targets = []; }
	if ('IntersectionObserver' in window && targets.length) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (!en.isIntersecting) return;
				var el = en.target, siblings = el.parentNode ? Array.prototype.indexOf.call(el.parentNode.children, el) : 0;
				el.style.transitionDelay = Math.min(siblings, 4) * 0.08 + 's';
				el.classList.add('in');
				$$('.fact-num', el).forEach(countUp);
				io.unobserve(el);
			});
		}, { threshold: 0.12 });
		targets.forEach(function (el) { io.observe(el); });
	} else {
		targets.forEach(function (el) { el.classList.add('in'); });
	}

	/* ---------- Sommer / Winter ---------- */
	$$('.season button').forEach(function (b) {
		b.addEventListener('click', function () {
			document.body.classList.remove('summer', 'winter');
			document.body.classList.add(b.dataset.season);
			$$('.season button').forEach(function (x) { x.setAttribute('aria-pressed', x === b); });
		});
		b.setAttribute('aria-pressed', document.body.classList.contains(b.dataset.season));
	});

	/* ---------- Galerie-Großansicht ---------- */
	var lb = $('#lightbox');
	var figs = $$('.fewo-gallery figure');
	if (lb && figs.length) {
		var gi = 0, lbImg = $('#lb-img'), lbCap = $('#lb-cap');
		var show = function (i) {
			gi = (i + figs.length) % figs.length;
			var img = $('img', figs[gi]), cap = $('figcaption', figs[gi]);
			lbImg.src = img.currentSrc || img.src;
			lbImg.alt = img.alt;
			lbCap.textContent = cap ? cap.textContent : img.alt;
		};
		var close = function () { lb.classList.remove('open'); var f = $('img', figs[gi]); if (f) f.focus(); };
		figs.forEach(function (f, i) {
			var img = $('img', f);
			img.tabIndex = 0;
			img.setAttribute('role', 'button');
			var open = function () { show(i); lb.classList.add('open'); $('.lb-close', lb).focus(); };
			f.addEventListener('click', open);
			img.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); } });
		});
		$('.lb-close', lb).addEventListener('click', close);
		$('.lb-prev', lb).addEventListener('click', function () { show(gi - 1); });
		$('.lb-next', lb).addEventListener('click', function () { show(gi + 1); });
		lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
		document.addEventListener('keydown', function (e) {
			if (!lb.classList.contains('open')) return;
			if (e.key === 'Escape') close();
			if (e.key === 'ArrowLeft') show(gi - 1);
			if (e.key === 'ArrowRight') show(gi + 1);
		});
		var tx = null;
		lb.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; }, { passive: true });
		lb.addEventListener('touchend', function (e) {
			if (tx === null) return;
			var dx = e.changedTouches[0].clientX - tx;
			if (Math.abs(dx) > 50) show(gi + (dx < 0 ? 1 : -1));
			tx = null;
		});
	}

	/* ---------- Preise ---------- */
	var P = D.prices || {};
	var fmt = function (n) { return n.toLocaleString(D.locale, { style: 'currency', currency: 'EUR', maximumFractionDigits: n % 1 ? 2 : 0 }); };
	var iso = function (d) { return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); };
	var parse = function (s) { return new Date(s + 'T00:00:00'); };
	function nightPrice(d) {
		var k = iso(d), s = (P.seasons || []).find(function (x) { return k >= x.from && k <= x.to; });
		return s ? +s.price : +P.base || 0;
	}
	var allPrices = [+P.base || 0].concat((P.seasons || []).map(function (s) { return +s.price; })).filter(function (x) { return x > 0; });
	var fromPrice = allPrices.length ? Math.min.apply(null, allPrices) : 0;
	$$('.price-night').forEach(function (el) {
		if (fromPrice) { el.textContent = T.from + ' ' + fmt(fromPrice); }
		else {
			el.textContent = T.onRequest;
			var unit = el.parentNode.querySelector('.price-unit'); if (unit) unit.hidden = true;
			el.parentNode.classList.add('on-request');
		}
	});

	/* ---------- Kalender ---------- */
	var cal = $('.booking');
	var bookedNights = {};
	(D.booked || []).forEach(function (b) {
		var d = parse(b.from), end = parse(b.to);
		while (d < end) { bookedNights[iso(d)] = true; d.setDate(d.getDate() + 1); }
	});
	var today = new Date(); today.setHours(0, 0, 0, 0);
	var view = new Date(today.getFullYear(), today.getMonth(), 1);
	var selStart = null, selEnd = null;
	var rangeFree = function (a, b) { var d = new Date(a); while (d < b) { if (bookedNights[iso(d)]) return false; d.setDate(d.getDate() + 1); } return true; };

	function renderCal() {
		if (!cal) return;
		var box = $('.cal-months', cal), loc = D.locale, html = '';
		var dows = [0, 1, 2, 3, 4, 5, 6].map(function (i) { return new Date(2024, 0, 1 + i).toLocaleDateString(loc, { weekday: 'short' }).replace('.', ''); });
		for (var m = 0; m < 2; m++) {
			var first = new Date(view.getFullYear(), view.getMonth() + m, 1);
			var days = new Date(first.getFullYear(), first.getMonth() + 1, 0).getDate();
			var offset = (first.getDay() + 6) % 7;
			var title = first.toLocaleDateString(loc, { month: 'long', year: 'numeric' });
			html += '<div class="month"><h3>' + title.charAt(0).toUpperCase() + title.slice(1) + '</h3><div class="grid7">';
			html += dows.map(function (d) { return '<span class="dow" aria-hidden="true">' + d + '</span>'; }).join('') + new Array(offset + 1).join('<span></span>');
			for (var d = 1; d <= days; d++) {
				var date = new Date(first.getFullYear(), first.getMonth(), d), k = iso(date);
				var past = date < today, isB = !!bookedNights[k];
				var cls = 'day' + (isB ? ' booked' : '');
				if (selStart && k === iso(selStart)) cls += ' start';
				if (selEnd && k === iso(selEnd)) cls += ' end';
				if (selStart && selEnd && date > selStart && date < selEnd) cls += ' in-range';
				var canDepart = isB && selStart && !selEnd && date > selStart && rangeFree(selStart, date);
				var dis = past || (isB && !canDepart);
				var label = date.toLocaleDateString(loc, { weekday: 'long', day: 'numeric', month: 'long' }) + (isB ? ', ' + T.booked : '');
				html += '<button type="button" class="' + cls + '" data-d="' + k + '"' + (dis ? ' disabled' : '') + ' aria-label="' + label + '">' + d + '</button>';
			}
			html += '</div></div>';
		}
		box.innerHTML = html;
		$('.cal-prev', cal).disabled = view <= new Date(today.getFullYear(), today.getMonth(), 1);
	}

	function syncInputs() {
		if (!cal) return;
		var a = selStart ? iso(selStart) : '', b = selEnd ? iso(selEnd) : '';
		['#in-from', '#f-from'].forEach(function (s) { var el = $(s); if (el) el.value = a; });
		['#in-to', '#f-to'].forEach(function (s) { var el = $(s); if (el) el.value = b; });
		$('.cal-label', cal).textContent = !selStart ? T.pickIn : !selEnd ? T.pickOut :
			selStart.toLocaleDateString(D.locale) + ' – ' + selEnd.toLocaleDateString(D.locale);
	}

	var lastEstimate = '';
	function calc() {
		if (!cal) return;
		var lines = $('.lines', cal), total = $('.total-sum', cal);
		lastEstimate = '';
		if (!selStart || !selEnd) { lines.innerHTML = '<div><span>' + T.pickDates + '</span><span></span></div>'; total.textContent = '–'; return; }
		var nights = Math.round((selEnd - selStart) / 864e5);
		var adults = +$('#in-adults').value, kids = +$('#in-kids').value;
		var guests = $('#f-guests');
		if (guests) guests.value = adults + ' ' + T.adultsWord + (kids ? ', ' + kids + ' ' + T.kidsWord : '');
		if (!rangeFree(selStart, selEnd)) { lines.innerHTML = '<div class="warn"><span>' + T.notFree + '</span></div>'; total.textContent = '–'; return; }
		if (!fromPrice) { lines.innerHTML = '<div><span>' + nights + ' ' + (nights === 1 ? T.night : T.nights) + '</span><span></span></div>'; total.textContent = T.onRequest; return; }

		var sum = 0, groups = [], d = new Date(selStart);
		while (d < selEnd) {
			var p = nightPrice(d), g = groups[groups.length - 1];
			if (g && g.p === p) g.n++; else groups.push({ p: p, n: 1 });
			sum += p; d.setDate(d.getDate() + 1);
		}
		var html = groups.map(function (g) {
			return '<div><span>' + fmt(g.p) + ' × ' + g.n + ' ' + (g.n === 1 ? T.night : T.nights) + '</span><span>' + fmt(g.p * g.n) + '</span></div>';
		}).join('');
		var clean = +P.cleaning || 0, tax = (+P.tax || 0) * adults * nights;
		if (clean) html += '<div><span>' + T.cleaning + '</span><span>' + fmt(clean) + '</span></div>';
		if (tax) html += '<div><span>' + T.tax + '</span><span>' + fmt(tax) + '</span></div>';
		if (nights < (+P.minNights || 1)) html += '<div class="warn"><span>' + T.minStay.replace('{n}', P.minNights) + '</span></div>';
		lines.innerHTML = html;
		total.textContent = fmt(sum + clean + tax);
		lastEstimate = total.textContent;
	}

	function fromInputs(a, b) {
		selStart = a ? parse(a) : null;
		selEnd = b ? parse(b) : null;
		if (selStart && selEnd && selEnd <= selStart) selEnd = null;
		if (selStart) view = new Date(selStart.getFullYear(), selStart.getMonth(), 1);
		syncInputs(); renderCal(); calc();
	}

	if (cal) {
		$('.cal-months', cal).addEventListener('click', function (e) {
			var b = e.target.closest('.day');
			if (!b || b.disabled) return;
			var d = parse(b.dataset.d);
			if (!selStart || selEnd || d <= selStart || !rangeFree(selStart, d)) { selStart = d; selEnd = null; }
			else selEnd = d;
			syncInputs(); renderCal(); calc();
			var again = $('.day[data-d="' + iso(d) + '"]', cal); if (again) again.focus();
		});
		$('.cal-prev', cal).addEventListener('click', function () { view = new Date(view.getFullYear(), view.getMonth() - 1, 1); renderCal(); });
		$('.cal-next', cal).addEventListener('click', function () { view = new Date(view.getFullYear(), view.getMonth() + 1, 1); renderCal(); });
		var minDate = iso(today);
		['#in-from', '#in-to', '#f-from', '#f-to'].forEach(function (s) { var el = $(s); if (el) el.min = minDate; });
		[['#in-from', '#in-to'], ['#f-from', '#f-to']].forEach(function (pair) {
			pair.forEach(function (s) {
				var el = $(s); if (!el) return;
				el.addEventListener('change', function () { fromInputs($(pair[0]).value, $(pair[1]).value); });
			});
		});
		['#in-adults', '#in-kids'].forEach(function (s) { $(s).addEventListener('change', calc); });
		renderCal(); syncInputs(); calc();
	}

	/* ---------- Anfrageformular ---------- */
	var form = $('.fewo-form');
	if (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var msg = $('.form-msg', form);
			var el = form.elements, name = el['name'].value.trim(), mail = el['email'].value.trim();
			if (!name || !/^\S+@\S+\.\S+$/.test(mail) || !el['consent'].checked) { msg.textContent = T.invalid; return; }
			var fd = new FormData(form);
			fd.set('lang', D.lang);
			if (!fd.get('message')) fd.set('message', '');
			if (lastEstimate) fd.set('estimate', lastEstimate);
			var btn = $('button[type="submit"]', form);
			btn.disabled = true;
			msg.textContent = T.sending;
			// Falls der Versand nicht klappt: fertige E-Mail zum Abschicken anbieten.
			var fallback = function () {
				var lines = [
					T.name + ': ' + name,
					T.email + ': ' + mail,
					T.arrival + ': ' + (el['from'].value || '–'),
					T.departure + ': ' + (el['to'].value || '–'),
					T.guests + ': ' + (el['guests'].value || '–')
				];
				if (lastEstimate) lines.push(T.total + ': ' + lastEstimate);
				lines.push('', el['message'].value || '');
				var href = 'mailto:' + D.email + '?subject=' + encodeURIComponent('Anfrage Ferienwohnung Elias') + '&body=' + encodeURIComponent(lines.join('\n'));
				msg.textContent = T.fallback + ' ';
				var a = document.createElement('a');
				a.href = href; a.className = 'btn btn-light'; a.textContent = T.fallbackBtn;
				a.style.marginTop = '10px';
				msg.appendChild(document.createElement('br'));
				msg.appendChild(a);
			};
			fetch(D.formUrl, { method: 'POST', body: fd })
				.then(function (r) { return r.json().catch(function () { return {}; }); })
				.then(function (j) {
					if (j && j.success) { msg.textContent = T.ok; form.reset(); }
					else fallback();
				})
				.catch(fallback)
				.then(function () { btn.disabled = false; });
		});
	}
})();
