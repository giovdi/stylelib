<?php
namespace DeployStudio\Style;

class Box {
	static function open($icon, $title, $colclass = 'col-sm-12', $id = null, $background_color = 'blue') {
		$id = (!is_null($id) ? ' id="'.$id.'"' : '');
		?>
<div class='<?php echo $colclass ?>'<?php $id ?>>
	<div class='ibox float-e-margins'>
		<div class='ibox-title <?php echo $background_color ?>-background'>
			<h5>
				<div class='<?php echo $icon ?>'></div>
				<?php echo $title?>
			</h5>
			<div class="clear"></div>
		</div>
		<div class='ibox-content'>
			
	<?php
	}
	
	static function close() {
		?>
		</div>
	</div>
</div>
<?php
	}
	
	static function emptyRowOpen () {
		echo '<div class="row">';
	}
	
	static function emptyRowClose () {
		echo '</div>';
	}
	
	static function row ($label, $value, $colclasslabel = 'col-sm-2', $colclassvalue = 'col-sm-10') {
?>
<div class="row" style="padding:5px 0">
	<div class="<?php echo $colclasslabel ?>" style="text-align: right; font-weight: bold"><?php echo $label ?></div>
	<div class="<?php echo $colclassvalue ?>"><?php echo $value ?></div>
</div>
<?php
	}
}