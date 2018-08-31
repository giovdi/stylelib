<?php
namespace DeployStudio\Style\Adminlte;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class Box extends \DeployStudio\Style\Base\Box {

	static function open ($box_col = 'col-xs-12', $id = null, $border_status = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('box '.($border_status != null ? 'box-'.$border_status : ''));
		StyleBaseClass::divOpen('box-body');
	}
		
	static function openTitolo ($icona, $titolo, $box_col = 'col-xs-12', $id = null, $border_status = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('box '.($border_status != null ? 'box-'.$border_status : ''));

		StyleBaseClass::divOpen('box-header with-border');
		echo '<h3 class="box-title"><span class="'.$icona.'"></span> '.$titolo.'</h3>';
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body');
	}
	
	static function close() {
		StyleBaseClass::divClose(); //box-body
		StyleBaseClass::divClose(); //box
		parent::closeBase();
	}
}