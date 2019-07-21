
<script type="text/javascript">
$(function() {
	$("#f{{ $datefilter }}").daterangepicker({
		locale:{
			"format": "DD/MM/YYYY",
			"separator": " - ",
			"applyLabel": "{{ __('universal_stylelib::stylelib.datefilter_apply') }}",
			"cancelLabel": "{{ __('universal_stylelib::stylelib.datefilter_cancel') }}",
			"fromLabel": "{{ __('universal_stylelib::stylelib.datefilter_from') }}",
			"toLabel": "{{ __('universal_stylelib::stylelib.datefilter_to') }}",
			"customRangeLabel": "Custom",
			"weekLabel": "W",
			"daysOfWeek": [
				"{{ __('universal_stylelib::stylelib.datefilter_su') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_mo') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_tu') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_we') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_th') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_fr') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_sa') }}"
			],
			"monthNames": [
				"{{ __('universal_stylelib::stylelib.datefilter_january') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_february') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_march') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_april') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_may') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_june') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_july') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_august') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_september') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_october') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_november') }}",
				"{{ __('universal_stylelib::stylelib.datefilter_december') }}"
			],
			"firstDay": 1
		},
		opens: 'right',
		@if (!empty($_GET['f'.$datefilter.'_start']) && !empty($_GET['f'.$datefilter.'_end']))
			startDate: '{!! date('d/m/Y', $_GET['f'.$datefilter.'_start'] / 1000) !!}',
			endDate: '{!! date('d/m/Y', $_GET['f'.$datefilter.'_end'] / 1000) !!}',
		@endif
		ranges: {
			"{{ __('universal_stylelib::stylelib.datefilter_today') }}": [moment(), moment()],
			"{{ __('universal_stylelib::stylelib.datefilter_yesterday') }}": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			"{{ __('universal_stylelib::stylelib.datefilter_last7days') }}": [moment().subtract(6, 'days'), moment()],
			"{{ __('universal_stylelib::stylelib.datefilter_last30days') }}": [moment().subtract(29, 'days'), moment()],
			"{{ __('universal_stylelib::stylelib.datefilter_thismonth') }}": [moment().startOf('month'), moment().endOf('month')],
			"{{ __('universal_stylelib::stylelib.datefilter_lastmonth') }}": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			"{{ __('universal_stylelib::stylelib.datefilter_frombeginning') }}": [0, 0]
		}
	}).on('apply.daterangepicker', function(ev, picker) {
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
})
</script>