<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\StyleBaseClass;

class Box {
	private static $boxes;
	private static $openBox;

	static function openBase ($box_col = 'col-xs-12', $id = null) {
		StyleBaseClass::checkOption($id, 'box'.rand(1000,9999));
		StyleBaseClass::checkOption($box_col, 'col-xs-12');

		self::$openBox = $id;
		self::$boxes[$id] = &$box_col;

		if ($box_col == 'col-xs-12') {
			StyleBaseClass::rowOpen(null, $id);
			StyleBaseClass::colOpen();
		} else {
			StyleBaseClass::colOpen($box_col);
		}
	}
	
	static function closeBase() {
		$box_col = self::$boxes[self::$openBox];

		if ($box_col == 'col-xs-12') {
			StyleBaseClass::rowClose();
		}
		StyleBaseClass::colClose();
	}
	
	static function row ($label, $value, $colclasslabel = 'col-sm-2', $colclassvalue = 'col-sm-10') {
		StyleBaseClass::rowOpen(null, null, 'padding:5px 0');

		StyleBaseClass::divOpen($colclasslabel, null, 'text-align: right; font-weight: bold');
		echo $label;
		StyleBaseClass::divClose();

		StyleBaseClass::divOpen($colclassvalue);
		echo $value;
		StyleBaseClass::divClose();

		StyleBaseClass::rowClose();
	}
}