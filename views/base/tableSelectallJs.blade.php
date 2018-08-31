<script>
	$("#{{ $id }} #selectAll").click(function() {
		if ($(this).prop('checked'))
			$("#{{ $id }} input[type=checkbox]:not(:disabled)").prop('checked', true).trigger('change');
		else
			$("#{{ $id }} input[type=checkbox]:not(:disabled)").prop('checked', false).trigger('change');
	});
</script>