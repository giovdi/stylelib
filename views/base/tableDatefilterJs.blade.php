
<script type="text/javascript">
$("#f{{ $datefilter }}").daterangepicker({
	locale:{
		format: "DD/MM/YYYY",
		"separator": " - ",
		"applyLabel": "Applica",
		"cancelLabel": "Cancella",
		"fromLabel": "Da",
		"toLabel": "A",
		"customRangeLabel": "Custom",
		"weekLabel": "W",
		"daysOfWeek": ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"],
		"monthNames": ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
		"firstDay": 1
	},
	opens: 'right',
	@if (!empty($_GET['f'.$header['datefilter'].'_start']) && !empty($_GET['f'.$header['datefilter'].'_end']))
		startDate: '{!! date('d/m/Y', $_GET['f'.$header['datefilter'].'_start'] / 1000) !!}',
		endDate: '{!! date('d/m/Y', $_GET['f'.$header['datefilter'].'_end'] / 1000) !!}',
	@endif
	ranges: {
		'Oggi': [moment(), moment()],
		'Ieri': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Ultimi 7 giorni': [moment().subtract(6, 'days'), moment()],
		'Ultimi 30 giorni': [moment().subtract(29, 'days'), moment()],
		'Questo mese': [moment().startOf('month'), moment().endOf('month')],
		'Mese scorso': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		'Dall\'inizio': [0, 0]
	}
});
$('#f{{ $datefilter }}').on('apply.daterangepicker', function(ev, picker) {
	start = picker.startDate.format('x');
	end = picker.endDate.format('x') - 86400000 + 1;

	console.log(start);
	console.log(end);

	urlPickerParams = '';
	urldest = window.location.href;
	if (urldest.indexOf('?') > 0) {
		urldest = removeParam('f{{ $datefilter }}_start', urldest);
		urldest = removeParam('f{{ $datefilter }}_end', urldest);
	}

	if (start > -3600000 && end > -3600000) {
		urldest = addParam('f{{ $datefilter }}_start', start, urldest);
		urldest = addParam('f{{ $datefilter }}_end', end, urldest);
	}
	
	document.location = urldest;
});
</script>