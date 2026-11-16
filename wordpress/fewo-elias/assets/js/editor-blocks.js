/* Platzhalter der eigenen Blöcke im Editor (die echte Ausgabe erfolgt auf der Website). */
(function (blocks, element, blockEditor) {
	var el = element.createElement;

	function placeholder(title, text) {
		return function Edit() {
			return el(
				'div',
				blockEditor.useBlockProps({ className: 'fewo-placeholder' }),
				el('strong', null, title),
				el('p', null, text)
			);
		};
	}

	var defs = {
		'fewo/saison': ['Sommer/Winter-Schalter', 'Schaltet auf der Website zwischen den Sommer- und Winter-Inhalten um.', 'image-flip-horizontal'],
		'fewo/buchung': ['Kalender & Preisrechner', 'Wird auf der Website automatisch angezeigt. Preise und Belegung ändert ihr links im Menü unter „Ferienwohnung“.', 'calendar-alt'],
		'fewo/anfrage': ['Anfrageformular', 'Anfragen werden an die E-Mail-Adresse geschickt, die unter „Ferienwohnung“ eingetragen ist.', 'email-alt']
	};

	Object.keys(defs).forEach(function (name) {
		var d = defs[name];
		blocks.registerBlockType(name, {
			apiVersion: 3,
			title: d[0],
			icon: d[2],
			category: 'widgets',
			supports: { html: false, reusable: false, multiple: false },
			edit: placeholder(d[0], d[1]),
			save: function () { return null; }
		});
	});
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
