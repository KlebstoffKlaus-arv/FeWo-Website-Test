/* Zeilen hinzufügen/löschen auf der Seite „Ferienwohnung“. */
(function () {
	var counter = Date.now();
	document.addEventListener('click', function (e) {
		var add = e.target.closest('.fewo-add');
		if (add) {
			var name = add.dataset.target;
			var tpl = document.getElementById('tpl-' + name);
			var body = document.querySelector('.fewo-rows[data-name="' + name + '"] tbody');
			var html = tpl.innerHTML.replace(/__i__/g, 'n' + (counter++));
			body.insertAdjacentHTML('beforeend', html);
			var first = body.lastElementChild.querySelector('input');
			if (first) first.focus();
			return;
		}
		var del = e.target.closest('.fewo-del');
		if (del) {
			del.closest('tr').remove();
		}
	});
	/* Abreise darf nicht vor der Anreise liegen. */
	document.addEventListener('change', function (e) {
		if (e.target.type !== 'date') return;
		var row = e.target.closest('tr');
		if (!row) return;
		var dates = row.querySelectorAll('input[type="date"]');
		if (dates.length === 2 && dates[0].value) dates[1].min = dates[0].value;
	});
})();
