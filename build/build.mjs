// Baut die Website aus den Inhalten in content/ in den Ordner dist/.
// Aufruf: npm run build
import { readFileSync, writeFileSync, mkdirSync, rmSync, cpSync, readdirSync, existsSync } from 'node:fs';
import { join, dirname, extname } from 'node:path';
import { fileURLToPath } from 'node:url';
import STR from './strings.mjs';

const ROOT = join(dirname(fileURLToPath(import.meta.url)), '..');
const DIST = join(ROOT, 'dist');
const SITE_URL = (process.env.SITE_URL || 'https://www.ferienwohnung-elias.at').replace(/\/$/, '');
const LANGS = ['de', 'en', 'nl'];
const LOCALES = { de: 'de-AT', en: 'en-GB', nl: 'nl-NL' };
const HOME = { de: '/', en: '/en/', nl: '/nl/' };

const json = (f) => JSON.parse(readFileSync(join(ROOT, 'content', f), 'utf8'));
const preise = json('preise.json');
const fotos = json('fotos.json');
const recht = json('rechtliches.json');
const texte = Object.fromEntries(LANGS.map((l) => [l, json(`texte-${l}.json`)]));

/* ---------- Helfer ---------- */
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
// *Wort* wird hervorgehoben, Zeilenumbrüche bleiben erhalten.
const fmt = (s) => esc(s).replace(/\*([^*]+)\*/g, '<em>$1</em>').replace(/\r?\n/g, '<br>');
const arr = (v) => (Array.isArray(v) ? v : v ? [v] : []);
const img = (p) => (p ? (p.startsWith('/') || p.startsWith('http') ? p : '/' + p) : '');
const num = (v) => {
	const n = parseFloat(String(v ?? '').replace(',', '.'));
	return Number.isFinite(n) && n > 0 ? n : 0;
};
const date = (v) => {
	const m = String(v ?? '').match(/^(\d{4}-\d{2}-\d{2})/);
	return m ? m[1] : '';
};

/* ---------- Daten für Kalender & Preisrechner (ohne interne Notizen) ---------- */
const priceData = {
	base: num(preise.grundpreis),
	cleaning: num(preise.endreinigung),
	tax: num(preise.gaestetaxe),
	minNights: Math.max(1, parseInt(preise.mindestnaechte, 10) || 1),
	seasons: arr(preise.saisonpreise)
		.map((s) => ({ from: date(s.von), to: date(s.bis), price: num(s.preis) }))
		.filter((s) => s.from && s.to && s.to >= s.from && s.price),
};
const booked = arr(preise.belegung)
	.map((b) => ({ from: date(b.anreise), to: date(b.abreise) }))
	.filter((b) => b.from && b.to && b.to > b.from);

/* ---------- Bausteine ---------- */
function head(lang, { title, description, path, alternates }) {
	const t = STR[lang];
	const alt = alternates
		? LANGS.map((l) => `<link rel="alternate" hreflang="${l}" href="${SITE_URL}${HOME[l]}">`).join('\n') + `\n<link rel="alternate" hreflang="x-default" href="${SITE_URL}/">`
		: '';
	return `<!doctype html>
<html lang="${lang}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${esc(title)}</title>
<meta name="description" content="${esc(description)}">
<link rel="canonical" href="${SITE_URL}${path}">
${alt}
<meta property="og:type" content="website">
<meta property="og:title" content="${esc(title)}">
<meta property="og:description" content="${esc(description)}">
<meta property="og:image" content="${SITE_URL}/images/og-image.jpg">
<meta name="theme-color" content="#1F4E4A">
<link rel="icon" href="/assets/img/favicon.png" type="image/png">
<link rel="preload" href="/assets/fonts/bricolage-grotesque-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="/assets/css/site.css?v=${VERSION}">
<script>document.documentElement.classList.add('js');</script>
</head>`;
}

function header(lang, { front, langLinks }) {
	const t = STR[lang];
	const a = (id) => (front ? `#${id}` : `${HOME[lang]}#${id}`);
	const langs = LANGS.map(
		(l) => `<a href="${langLinks[l]}" hreflang="${l}" lang="${l}" aria-label="${esc(STR[l].langName)}"${l === lang ? ' aria-current="true"' : ''}>${l.toUpperCase()}</a>`
	).join('');
	return `<body class="${front ? 'front-page' : 'sub-page'}">
<script>(function(){var m=new Date().getMonth();document.body.classList.add(m>=10||m<=2?'winter':'summer');})();</script>
<a class="skip-link" href="#main">${esc(t.skip)}</a>
<header class="site-header${front ? '' : ' scrolled solid'}" id="site-header">
	<div class="wrap nav">
		<a class="logo" href="${HOME[lang]}" aria-label="Ferienwohnung Elias"><img src="/assets/img/logo.png" alt="Ferienwohnung Elias" width="440" height="263"></a>
		<div class="nav-right">
			<nav class="links" id="links" aria-label="${esc(t.menuAria)}">
				<a href="${a('wohnung')}">${esc(t.navApt)}</a>
				<a href="${a('ausstattung')}">${esc(t.navAmen)}</a>
				<a href="${a('buchen')}">${esc(t.navBook)}</a>
				<a href="${a('umgebung')}">${esc(t.navArea)}</a>
				<a href="${a('faq')}">${esc(t.navFaq)}</a>
				<a class="btn btn-primary" href="${a('kontakt')}">${esc(t.navCta)}</a>
			</nav>
			<div class="lang" aria-label="${esc(t.langAria)}">${langs}</div>
			<button class="menu-btn" type="button" aria-label="${esc(t.menuOpen)}" aria-expanded="false" aria-controls="links">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
			</button>
		</div>
	</div>
</header>
<main id="main">`;
}

function footer(lang, { front }) {
	const t = STR[lang];
	const extra = front
		? `<div class="mbar" id="mbar">
	<div><b class="price-night"></b> <span class="price-unit">${esc(t.perNight)}</span></div>
	<a class="btn btn-primary" href="#buchen">${esc(t.mbar)}</a>
</div>
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="${esc(t.image)}">
	<button class="lb-btn lb-close" type="button" aria-label="${esc(t.close)}">✕</button>
	<button class="lb-btn lb-prev" type="button" aria-label="‹">‹</button>
	<figure><img id="lb-img" alt=""><figcaption id="lb-cap"></figcaption></figure>
	<button class="lb-btn lb-next" type="button" aria-label="›">›</button>
</div>
<script>window.FEWO=${JSON.stringify({
				lang,
				locale: LOCALES[lang],
				t,
				prices: priceData,
				booked,
				formUrl: '/api/anfrage',
				email: preise.anfrageEmail || 'fewoelias@gmail.com',
			}).replace(/</g, '\\u003c')};</script>`
		: '';
	return `</main>
<footer class="site-footer">
	<div class="wrap foot">
		<span>© ${new Date().getFullYear()} Ferienwohnung Elias · ${esc(texte[lang].kontakt.gastgeber)} · Eggstraße 15, 6991 Riezlern</span>
		<nav aria-label="${esc(t.imprint)} / ${esc(t.privacyPage)}">
			<a href="/impressum/">${esc(t.imprint)}</a>
			<a href="/datenschutz/">${esc(t.privacyPage)}</a>
		</nav>
	</div>
</footer>
${extra}
<script src="/assets/js/site.js?v=${VERSION}" defer></script>
</body>
</html>
`;
}

const eyebrow = (s) => `<p class="eyebrow">${esc(s)}</p>`;

function frontPage(lang) {
	const T = texte[lang];
	const t = STR[lang];
	const S = T.start;

	const hero = `<section class="fewo-hero" id="start">
	<div class="hero-grid">
		<div class="hero-copy">
			<div class="season" role="group" aria-label="${esc(t.seasonAria)}"><button type="button" data-season="summer">${esc(t.summer)}</button><button type="button" data-season="winter">${esc(t.winter)}</button></div>
			${eyebrow('Riezlern · Kleinwalsertal')}
			<h1 class="season-summer">${fmt(S.titelSommer)}</h1>
			<h1 class="season-winter">${fmt(S.titelWinter)}</h1>
			<p class="lead season-summer">${fmt(S.textSommer)}</p>
			<p class="lead season-winter">${fmt(S.textWinter)}</p>
			<div class="actions">
				<a class="btn btn-primary" href="#buchen">${esc(S.knopfVerfuegbarkeit)}</a>
				<a class="btn btn-light" href="#wohnung">${esc(S.knopfFotos)}</a>
			</div>
		</div>
		<div class="hero-visual">
			<figure class="hero-img season-summer"><img src="${esc(img(fotos.titelbildSommer))}" alt="Ferienwohnung Elias" fetchpriority="high"></figure>
			<figure class="hero-img season-winter"><img src="${esc(img(fotos.titelbildWinter))}" alt="Ferienwohnung Elias" loading="lazy"></figure>
			<div class="float-card fc1"><p><strong>${esc(S.infoKarte1Titel)}</strong><br>${esc(S.infoKarte1Text)}</p></div>
			<div class="float-card fc2"><p><strong>${esc(S.infoKarte2Titel)}</strong><br>${esc(S.infoKarte2Text)}</p></div>
		</div>
	</div>
	<div class="facts">${arr(T.eckdaten)
		.map((f) => `<div class="fact"><p class="fact-num">${esc(f.zahl)}</p><p class="fact-label">${esc(f.text)}</p></div>`)
		.join('')}</div>
</section>`;

	const gallery = arr(fotos.galerie)
		.filter((g) => g && g.bild)
		.map((g) => {
			const cap = g[lang] || g.de || '';
			return `<figure><img src="${esc(img(g.bild))}" alt="${esc(cap)}" loading="lazy"><figcaption>${esc(cap)}</figcaption></figure>`;
		})
		.join('\n');
	const W = T.wohnung;
	const apt = `<section class="fewo-section" id="wohnung">
	${eyebrow(W.oberzeile)}
	<h2>${fmt(W.titel)}</h2>
	<p class="intro">${fmt(W.text)}</p>
	<div class="fewo-gallery">${gallery}</div>
</section>`;

	const A = T.ausstattung;
	const amen = `<section class="fewo-section bg-sand" id="ausstattung">
	${eyebrow(A.oberzeile)}
	<h2>${fmt(A.titel)}</h2>
	<p class="intro">${fmt(A.text)}</p>
	<div class="grid-3">${arr(A.bereiche)
		.map((b, i) => `<div class="amen-card ic-${(i % 3) + 1}"><h3>${esc(b.titel)}</h3><ul>${arr(b.punkte).map((p) => `<li>${esc(p)}</li>`).join('')}</ul></div>`)
		.join('')}</div>
	${A.hinweis ? `<p class="note">${esc(A.hinweis)}</p>` : ''}
</section>`;

	const B = T.buchung;
	const book = `<section class="fewo-section" id="buchen">
	${eyebrow(B.oberzeile)}
	<h2>${fmt(B.titel)}</h2>
	<p class="intro">${fmt(B.text)}</p>
	<div class="booking">
		<div class="cal-card">
			<div class="cal-head">
				<button type="button" class="cal-prev" aria-label="${esc(t.prev)}">‹</button>
				<strong class="cal-label" aria-live="polite">${esc(t.pickIn)}</strong>
				<button type="button" class="cal-next" aria-label="${esc(t.next)}">›</button>
			</div>
			<div class="cal-months"></div>
			<div class="legend">
				<span><i class="lg-booked"></i>${esc(t.booked)}</span>
				<span><i class="lg-inout"></i>${esc(t.inout)}</span>
				<span><i class="lg-stay"></i>${esc(t.stay)}</span>
			</div>
			<p class="note">${esc(t.calNote)}</p>
		</div>
		<aside class="calc-card">
			<div class="price-big"><span class="price-night"></span> <small class="price-unit">${esc(t.perNight)}</small></div>
			<div class="row2">
				<div class="field"><label for="in-from">${esc(t.arrival)}</label><input type="date" id="in-from"></div>
				<div class="field"><label for="in-to">${esc(t.departure)}</label><input type="date" id="in-to"></div>
			</div>
			<div class="row2">
				<div class="field"><label for="in-adults">${esc(t.adults)}</label><select id="in-adults"><option>1</option><option selected>2</option><option>3</option><option>4</option><option>5</option></select></div>
				<div class="field"><label for="in-kids">${esc(t.kids)}</label><select id="in-kids"><option selected>0</option><option>1</option><option>2</option><option>3</option></select></div>
			</div>
			<div class="lines"></div>
			<div class="total"><span>${esc(t.total)}</span><span class="total-sum">–</span></div>
			<a class="btn btn-primary btn-block" href="#kontakt">${esc(t.bookCta)}</a>
			<p class="note">${esc(t.calcNote)}</p>
		</aside>
	</div>
</section>`;

	const U = T.umgebung;
	const tiles = (list, images, cls) =>
		`<div class="grid-3 ${cls}">${arr(list)
			.map((x, i) => {
				const im = arr(images)[i];
				return `<article class="tile">${im ? `<img src="${esc(img(im))}" alt="" loading="lazy">` : ''}<div class="tile-body"><h3>${esc(x.titel)}</h3><p>${esc(x.text)}</p></div></article>`;
			})
			.join('')}</div>`;
	const maps = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(U.adresse || 'Eggstraße 15, 6991 Riezlern');
	const area = `<section class="fewo-section bg-sand" id="umgebung">
	${eyebrow(U.oberzeile)}
	<h2 class="season-summer">${fmt(U.titelSommer)}</h2>
	<h2 class="season-winter">${fmt(U.titelWinter)}</h2>
	<p class="intro">${fmt(U.text)}</p>
	${tiles(U.sommer, fotos.umgebungSommer, 'season-summer')}
	${tiles(U.winter, fotos.umgebungWinter, 'season-winter')}
	<div class="map-card">
		<div><h3>${esc(U.adresse)}</h3><p>${esc(U.lageText)}</p></div>
		<a class="btn btn-apricot" href="${esc(maps)}" target="_blank" rel="noopener">${esc(U.routeKnopf)}</a>
	</div>
</section>`;

	const F = T.faq;
	const faq = `<section class="fewo-section" id="faq">
	${eyebrow(F.oberzeile)}
	<h2>${fmt(F.titel)}</h2>
	<div class="faq-list">${arr(F.fragen)
		.map((q) => `<details><summary>${esc(q.frage)}</summary><p>${fmt(q.antwort)}</p></details>`)
		.join('')}</div>
</section>`;

	const K = T.kontakt;
	const consent = esc(t.privacy).replace('{link}', `<a href="/datenschutz/" target="_blank">${esc(t.privacyLink)}</a>`);
	const contact = `<section class="fewo-section pt-0" id="kontakt">
	<div class="contact">
		<div class="contact-copy">
			${eyebrow(K.oberzeile)}
			<h2>${fmt(K.titel)}</h2>
			<p class="intro">${fmt(K.text)}</p>
			<p class="host"><strong>${esc(K.gastgeber)}</strong><br>${esc(K.gastgeberText)} · <a href="tel:${esc(String(preise.telefon || '').replace(/[^+\d]/g, ''))}">${esc(preise.telefon)}</a></p>
		</div>
		<form class="fewo-form" novalidate>
			<div class="row2">
				<div class="field"><label for="f-name">${esc(t.name)}</label><input id="f-name" name="name" required autocomplete="name"></div>
				<div class="field"><label for="f-mail">${esc(t.email)}</label><input id="f-mail" name="email" type="email" required autocomplete="email"></div>
			</div>
			<div class="row2">
				<div class="field"><label for="f-from">${esc(t.arrival)}</label><input id="f-from" name="from" type="date"></div>
				<div class="field"><label for="f-to">${esc(t.departure)}</label><input id="f-to" name="to" type="date"></div>
			</div>
			<div class="field"><label for="f-guests">${esc(t.guests)}</label><input id="f-guests" name="guests" placeholder="${esc(t.guestsPh)}"></div>
			<div class="field"><label for="f-msg">${esc(t.message)}</label><textarea id="f-msg" name="message" rows="4" placeholder="${esc(t.messagePh)}"></textarea></div>
			<div class="hp" aria-hidden="true"><label for="f-web">Website</label><input id="f-web" name="website" tabindex="-1" autocomplete="off"></div>
			<label class="consent"><input type="checkbox" name="consent" value="1" required> <span>${consent}</span></label>
			<button class="btn btn-apricot btn-block" type="submit">${esc(t.send)}</button>
			<p class="form-msg" aria-live="polite"></p>
		</form>
	</div>
</section>`;

	const langLinks = Object.fromEntries(LANGS.map((l) => [l, HOME[l]]));
	return (
		head(lang, { title: T.seo.titel, description: T.seo.beschreibung, path: HOME[lang], alternates: true }) +
		'\n' +
		header(lang, { front: true, langLinks }) +
		`<div class="front">\n${hero}\n${apt}\n${amen}\n${book}\n${area}\n${faq}\n${contact}\n</div>\n` +
		footer(lang, { front: true })
	);
}

function plainPage(title, bodyHtml, path) {
	const lang = 'de';
	const langLinks = Object.fromEntries(LANGS.map((l) => [l, HOME[l]]));
	return (
		head(lang, { title: `${title} – Ferienwohnung Elias`, description: title, path }) +
		'\n' +
		header(lang, { front: false, langLinks }) +
		`<article class="page-plain wrap"><h1>${esc(title)}</h1><div class="page-content">${bodyHtml}</div></article>\n` +
		footer(lang, { front: false })
	);
}

function notFoundPage() {
	const t = STR.de;
	return plainPage('404', `<p>${esc(t.notFound)}</p><p><a class="btn btn-primary" href="/">${esc(t.backHome)}</a></p>`, '/404');
}

// Rechtstexte kommen aus dem Editor: nur harmlose Tags durchlassen.
function cleanHtml(html) {
	return String(html || '')
		.replace(/<\s*(script|style|iframe|object|embed)[\s\S]*?<\/\s*\1\s*>/gi, '')
		.replace(/\son\w+\s*=\s*("[^"]*"|'[^']*'|[^\s>]+)/gi, '')
		.replace(/javascript:/gi, '');
}

/* ---------- Bilder verkleinern ---------- */
async function copyImages() {
	const src = join(ROOT, 'images');
	const out = join(DIST, 'images');
	mkdirSync(out, { recursive: true });
	if (!existsSync(src)) return;
	let sharp = null;
	try {
		sharp = (await import('sharp')).default;
	} catch {
		console.warn('Hinweis: "sharp" nicht installiert – Bilder werden unverändert kopiert.');
	}
	const files = readdirSync(src, { recursive: true }).filter((f) => /\.(jpe?g|png|webp|avif|gif)$/i.test(f));
	for (const f of files) {
		const from = join(src, f);
		const to = join(out, f);
		mkdirSync(dirname(to), { recursive: true });
		const ext = extname(f).toLowerCase();
		if (!sharp || ext === '.gif') {
			cpSync(from, to);
			continue;
		}
		try {
			const meta = await sharp(from).metadata();
			const big = Math.max(meta.width || 0, meta.height || 0) > 1800;
			const size = (await import('node:fs')).statSync(from).size;
			// Bereits optimierte Bilder unverändert übernehmen (kein Qualitätsverlust).
			if (!big && size < 600 * 1024 && meta.orientation === undefined) {
				cpSync(from, to);
				continue;
			}
			let p = sharp(from, { failOn: 'none' }).rotate().resize({ width: 1800, height: 1800, fit: 'inside', withoutEnlargement: true });
			if (ext === '.png') p = p.png({ compressionLevel: 9, palette: true });
			else if (ext === '.webp') p = p.webp({ quality: 80 });
			else if (ext === '.avif') p = p.avif({ quality: 55 });
			else p = p.jpeg({ quality: 80, mozjpeg: true });
			await p.toFile(to);
		} catch (e) {
			console.warn(`Bild ${f} konnte nicht verkleinert werden (${e.message}) – wird kopiert.`);
			cpSync(from, to);
		}
	}
	console.log(`${files.length} Bilder verarbeitet.`);
}

/* ---------- Bauen ---------- */
const VERSION = Date.now().toString(36);

function write(rel, content) {
	const p = join(DIST, rel);
	mkdirSync(dirname(p), { recursive: true });
	writeFileSync(p, content);
}

rmSync(DIST, { recursive: true, force: true });
mkdirSync(DIST, { recursive: true });
cpSync(join(ROOT, 'src'), join(DIST, 'assets'), { recursive: true });
await copyImages();

for (const l of LANGS) write(l === 'de' ? 'index.html' : `${l}/index.html`, frontPage(l));
write('impressum/index.html', plainPage('Impressum', cleanHtml(recht.impressum), '/impressum/'));
write('datenschutz/index.html', plainPage('Datenschutzerklärung', cleanHtml(recht.datenschutz), '/datenschutz/'));
write('404.html', notFoundPage());

write('robots.txt', `User-agent: *\nAllow: /\nSitemap: ${SITE_URL}/sitemap.xml\n`);
write(
	'sitemap.xml',
	`<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n${['/', '/en/', '/nl/', '/impressum/', '/datenschutz/']
		.map((p) => `<url><loc>${SITE_URL}${p}</loc></url>`)
		.join('\n')}\n</urlset>\n`
);
// Alte Adressen der bisherigen Website weiterleiten.
write(
	'_redirects',
	['/index.html / 301', '/wohnung.html /#wohnung 301', '/preise-anfrage.html /#buchen 301', '/lage.html /#umgebung 301', '/impressum.html /impressum/ 301', '/datenschutz.html /datenschutz/ 301'].join('\n') + '\n'
);
write(
	'_headers',
	`/*
  X-Content-Type-Options: nosniff
  Referrer-Policy: strict-origin-when-cross-origin
  X-Frame-Options: SAMEORIGIN
  Permissions-Policy: camera=(), microphone=(), geolocation=()
/assets/*
  Cache-Control: public, max-age=31536000, immutable
/images/*
  Cache-Control: public, max-age=604800
`
);
console.log('Fertig: dist/ gebaut.');
