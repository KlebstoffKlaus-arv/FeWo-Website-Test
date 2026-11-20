// Cloudflare Worker: liefert die Website aus und verschickt Anfragen aus dem Formular.
import preise from '../content/preise.json';

const MAX_LEN = { name: 120, email: 200, from: 10, to: 10, guests: 120, message: 4000, estimate: 40, lang: 2 };

export default {
	async fetch(request, env) {
		const url = new URL(request.url);
		if (url.pathname === '/api/anfrage') {
			if (request.method !== 'POST') return json({ success: false }, 405);
			return handleEnquiry(request, env);
		}
		return env.ASSETS.fetch(request);
	},
};

function json(data, status = 200) {
	return new Response(JSON.stringify(data), { status, headers: { 'content-type': 'application/json; charset=utf-8' } });
}

const clean = (v, key) => String(v ?? '').replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F]/g, '').trim().slice(0, MAX_LEN[key] || 200);
const fmtDate = (d) => (/^\d{4}-\d{2}-\d{2}$/.test(d) ? d.split('-').reverse().join('.') : '–');

async function handleEnquiry(request, env) {
	let form;
	try {
		form = await request.formData();
	} catch {
		return json({ success: false }, 400);
	}
	// Spam-Falle: Feld ist für Menschen unsichtbar.
	if (form.get('website')) return json({ success: true });

	const f = {};
	for (const k of Object.keys(MAX_LEN)) f[k] = clean(form.get(k), k);
	f.name = f.name.replace(/[\r\n]/g, ' ');
	if (!f.name || !/^[^\s@<>]+@[^\s@<>]+\.[^\s@<>]+$/.test(f.email) || !form.get('consent')) {
		return json({ success: false, reason: 'invalid' }, 400);
	}

	const to = env.MAIL_TO || preise.anfrageEmail;
	const from = env.MAIL_FROM;
	if (!env.EMAIL || !from || !to) {
		// E-Mail-Versand ist (noch) nicht eingerichtet – die Website bietet dann einen E-Mail-Link an.
		return json({ success: false, reason: 'not-configured' }, 503);
	}

	const text = [
		'Neue Anfrage über die Website:',
		'',
		`Name: ${f.name}`,
		`E-Mail: ${f.email}`,
		`Anreise: ${fmtDate(f.from)}`,
		`Abreise: ${fmtDate(f.to)}`,
		`Personen: ${f.guests || '–'}`,
		f.estimate ? `Vom Preisrechner geschätzt: ${f.estimate}` : null,
		`Sprache der Anfrage: ${(f.lang || 'de').toUpperCase()}`,
		'',
		'Nachricht:',
		f.message || '–',
		'',
		`Zum Antworten einfach auf diese E-Mail antworten (oder an ${f.email} schreiben).`,
	]
		.filter((l) => l !== null)
		.join('\n');

	const subject = `Anfrage Ferienwohnung Elias: ${f.name}` + (f.from ? ` (${fmtDate(f.from)} – ${fmtDate(f.to)})` : '');
	const message = { to, from: { email: from, name: 'Website Ferienwohnung Elias' }, subject, text, replyTo: f.email };

	try {
		await env.EMAIL.send(message);
	} catch (e) {
		console.error('E-Mail-Versand fehlgeschlagen:', e && (e.code || e.message));
		return json({ success: false, reason: 'send-failed' }, 502);
	}
	return json({ success: true });
}
