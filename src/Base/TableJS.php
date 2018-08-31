<?php
namespace DeployStudio\Style;

class TableJS {
	private $colclass;
	
	public static $MAX = -1;
	
	function __construct($icon, $table_title, $headers, $colclass = 'col-sm-12', $items_per_page = 25) {
		$this->colclass = $colclass;
		?>
<?php if ($colclass == 'col-sm-12') { ?>
<div class='row' id="<?php echo idGen($table_title); ?>">
<?php } ?>
	<div class='<?php echo $colclass ?>'>
		<div class='box bordered-box'>
			<div class='box-header blue-background'>
				<div class='title'>
					<div class='<?php echo $icon ?>'></div>
					<?php echo $table_title?>
				</div>
				<div class="clear"></div>
			</div>
			<div class='box-content box-no-padding'>

					<table class='data-table table table-bordered table-striped' data-pagination-records="<?php echo $items_per_page ?>">
						<thead>
							<tr>
							<?php foreach ($headers as $header) {
								$options = array();
								if (is_array($header)) {
									$value = $header[0];
								
									if (isset($header['colspan']))
										$options[] = 'colspan="'.($header['colspan'] == $MAX ? count($headers) : $header['colspan']).'"';
									if (isset($header['class']))
										$options[] = 'class="'.$header['class'].'"';
									if (isset($header['help'])) {
										$value .= ' <span class="icon fa fa-question-circle has-tooltip" data-placement="top" title="'.$header['help'].'"></span>';
									}
								}
								
								else
									$value = $header;
								
								echo '<th '.implode(' ', $options).'>'.$value.'</th>';
							} ?>
						</tr>
						</thead>

<?php
	}
	
	function footer($pageElements = 25, $multipleActions = array()) {
		?>
					</table>
					<?php if (count($multipleActions) > 0) {
						?>
				<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo __('Selected items') ?>: </label>
						<div class="col-sm-2">
							<select name="multipleAction" class="form-control multipleAction">
								<?php
								foreach ($multipleActions as $action) {
									echo '<option value="'.$action['action'].'">'.$action['label'].'</option>';
								}
								?>
							</select>
						</div>
						<div class="col-sm-1">
							<button href="#" class="btn btn-primary" onclick="$(this).submit()"><i class="fa fa-check"></i></button>
						</div>
						<script type="text/javascript">
						$(function() {
							$('.multipleAction').select2({
							    minimumResultsForSearch: -1
							});
						});
						</script>
					</div>
					<?php
					}
					?>
			</div>
		</div>
	</div>
<?php if ($this->colclass == 'col-sm-12') { ?>
</div>
<?php } ?>
<script type="text/javascript">
var tablePager = <?php echo $pageElements ?>;
</script>

<?php 
	}
	
	function row($rowValues) {
	?>
<tr>
	<?php foreach ($rowValues as $rowValue) {
		$options = array();
		if (is_array($rowValue)) {
			$value = $rowValue[0];
		
			if (isset($rowValue['colspan']))
				$options[] = 'colspan="'.($rowValue['colspan'] == $MAX ? count($headers) : $rowValue['colspan']).'"';
			if (isset($rowValue['class']))
				$options[] = 'class="'.$rowValue['class'].'"';
		}
		
		else
			$value = $rowValue;
		echo '<td '.implode(' ', $options).'>'.$value.'</td>';
	} ?>
</tr>
<?php 
	}
	
	function rowCheckbox($id, $disabled = false) {
		return '<input type="checkbox" name="mSel[]" value="'.$id.'"'.($disabled ? ' disabled' : '').'>';
	}
}