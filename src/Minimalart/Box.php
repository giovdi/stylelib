<?php
namespace DeployStudio\Style\Minimalart;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class Box extends \DeployStudio\Style\Base\Box {

	static function open ($box_col = 'col-12', $id = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('box');
		StyleBaseClass::divOpen('box-body');
	}
		
	static function openTitolo ($icona, $titolo, $box_col = 'col-12', $id = null, $bg_header = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('box');

		StyleBaseClass::divOpen('box-header with-border '.(!is_null($bg_header) ? 'bg-'.$bg_header : ''));
		echo '<h3 class="box-title"><i class="'.$icona.'"></i> '.$titolo.'</h3>';
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body');
	}
	
	static function close() {
		StyleBaseClass::divClose(); //box-body
		StyleBaseClass::divClose(); //box
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