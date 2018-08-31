<script>
	$("#<?php echo e($id); ?> #selectAll").click(function() {
		if ($(this).prop('checked'))
			$("#<?php echo e($id); ?> input[type=checkbox]:not(:disabled)").prop('checked', true).trigger('change');
		else
			$("#<?php echo e($id); ?> input[type=checkbox]:not(:disabled)").prop('checked', false).trigger('change');
	});
</script>