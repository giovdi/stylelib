<?php
namespace DeployStudio\Style\Angle;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class Box extends \DeployStudio\Style\Base\Box {
	static function open ($box_col = 'col-12', $id = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('card card-default');
		StyleBaseClass::divOpen('card-body');
	}
		
	static function openTitolo ($icona, $titolo, $box_col = 'col-12', $id = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('card card-default');

		StyleBaseClass::divOpen('card-header');
		echo '<i class="'.$icona.'"></i> '.$titolo;
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('card-body');
	}
	
	static function close() {
		StyleBaseClass::divClose(); //card-body
		StyleBaseClass::divClose(); //card card-default
		parent::closeBase();
	}
}