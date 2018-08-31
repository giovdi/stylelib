<?php
namespace DeployStudio\Style;

class BoxStat {
	function __construct($icon = null, $title = null, $colclass = 'col-lg-3') {
		?>
<div class='<?php echo $colclass ?>'>
	<div class='box'>
		<?php if ($title != null) { ?>
		<div class='box-header'>
			<div class='title'>
				<?php if ($icon != null) echo '<div class="'.$icon.'"></div>' ?>
				<?php echo $title ?>
			</div>
			<div class="clear"></div>
		</div>	
		<?php
		}
	}
	
	function footer() {
	?>
	</div>
</div>
<?php
	}
	
	function stat ($icon, $class, $label, $value, $boxclass = 'col-xs-12') {
		if ($boxclass == 'col-xs-12') {
			echo '<div class="row">';
		}
		?>
		<div class='<?php echo $boxclass ?>'>
			<div class='box-content box-statistic'>
				<h3 class='title text-<?php echo $class ?>'><?php echo $value ?></h3>
				<small><?php echo $label ?></small>
				<div
					class='text-<?php echo $class ?> <?php echo $icon ?> align-right'></div>
			</div>
		</div>
		<?php
		if ($boxclass == 'col-xs-12') {
			echo '</div>';
		}
	}
	
	// deprecated, will be removed in future
	function row ($icon, $class, $label, $value, $boxclass = 'col-xs-12') {
		$this->stat($icon, $class, $label, $value, $boxclass);
	}
	
}