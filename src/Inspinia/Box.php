<?php
namespace DeployStudio\Style\Inspinia;

use \DeployStudio\Style\Base;
use \DeployStudio\Style\StyleBaseClass;

class Box extends \DeployStudio\Style\Base\Box {

	static function open ($box_col = 'col-xs-12', $id = null) {
		parent::openBase($box_col, $id);
		StyleBaseClass::divOpen('ibox-content');
	}
		
	static function openTitolo ($icona, $titolo, $box_col = 'col-xs-12', $id = null) {
		parent::openBase($box_col, $id);

		StyleBaseClass::divOpen('ibox-title');
		echo '<h5><span class="'.$icona.'"></span> '.$titolo.'</h5>';
		StyleBaseClass::divClose();

		StyleBaseClass::divOpen('ibox-content');
	}

	static function close() {
		StyleBaseClass::divClose(); //ibox-content
		parent::closeBase();
	}
}