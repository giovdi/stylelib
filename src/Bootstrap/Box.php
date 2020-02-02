<?php
namespace DeployStudio\Style\Bootstrap;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class Box extends \DeployStudio\Style\Base\Box {

	static function open ($box_col = 'col-12', $id = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('card');
		StyleBaseClass::divOpen('card-body');
	}
		
	static function openTitolo ($icona, $titolo, $box_col = 'col-12', $id = null, $bg_header = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('card');

		StyleBaseClass::divOpen('card-header '.(!is_null($bg_header) ? 'bg-'.$bg_header : ''));
		echo '<i class="'.$icona.'"></i> '.$titolo;
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('card-body');
	}
	
	static function close() {
		StyleBaseClass::divClose(); //card-body
		StyleBaseClass::divClose(); //card
		parent::closeBase();
	}
	
	static function listOpen ($horizontal = true) {
		echo '<dl '.($horizontal ? 'class="dl-horizontal"' : '').'>';
	}
	static function listRow ($label, $value) {
		echo '<dt>'.$label.'</dt><dd>'.$value.'</dd>';
	}
	static function listClose () {
		echo '</dl>';
	}
}