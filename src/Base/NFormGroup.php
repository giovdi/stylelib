<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\Base\StyleLib;
use \DeployStudio\Style\StyleBaseClass;

class NFormGroup extends NFormBase {

	static function rowFirst() {
		StyleBaseClass::divOpen('form-row');
	}
	static function rowBreak() {
		StyleBaseClass::divClose();
		StyleBaseClass::divOpen('form-row');
	}
	static function rowLast() {
		StyleBaseClass::divClose();
	}

	/* ***************** INPUT ***************** */

	static function input($col, $label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::inputBase($label, $name, $required, $options, $outputArr);
		get_called_class()::inputBuild($col, $label, $required, $options, $outputArr);
	}

	static function email($col, $label, $name, $required = false, $options = array()) {
		parent::emailBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	static function password($col, $label, $name, $required = false, $options = array()) {
		parent::passwordBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	static function file($col, $label, $name, $required = false, $options = array()) {
		if (isset($options['multiple']) && $options['multiple']) {
			$name .= '[]';
		}

		parent::fileBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	static function datepicker($col, $label, $name, $required = false, $options = array()) {
		parent::datepickerBase($name, $options);
		self::input($col, $label, $name.'_in', $required, $options);
	}

	static function datetimepicker($col, $label, $name, $required = false, $options = array()) {
		parent::datetimepickerBase($name, $options);
		self::input($col, $label, $name.'_in', $required, $options);
	}

	static function daterangepicker($col, $label, $name, $required = false, $options = array()) {
		parent::daterangepickerBase($name, $options);
		self::input($col, $label, $name.'_in', $required, $options);
	}

	static function datetimerangepicker($col, $label, $name, $required = false, $options = array()) {
		parent::datetimerangepickerBase($name, $options);
		self::input($col, $label, $name.'_in', $required, $options);
	}

	static function clockpicker($col, $label, $name, $required = false, $options = array()) {
		parent::clockpickerBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	static function touchpicker($col, $label, $name, $required = false, $options = array()) {
		parent::touchpickerBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($col, $label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::textareaBase($label, $name, $required, $options, $outputArr);
		get_called_class()::textareaBuild($col, $label, $required, $options, $outputArr);
	}

	static function wysiwyg($col, $label, $name, $required = false, $options = array()) {
		parent::wysiwygBase($options);
		self::textarea($col, $label, $name, $required, $options);
	}

	/* ***************** INPUT CHECKBOXES ***************** */
	
	static function checkboxes($col, $label, $mainName, $checkboxes, $options = array()) {
		$checkboxTags = array();
		$outputArr = array();
		parent::checkboxesBase($label, $mainName, $checkboxes, $checkboxTags, $options, $outputArr);
		get_called_class()::checkboxesBuild($col, $label, $checkboxTags, $options, $outputArr);
	}

	static function checkbox($col, $label, $name, $required = false, $disabled = false, $value = "on", $options = array()) {
		self::checkboxes($col, $label, $name, array(
			array('label' => '', 'name' => null, 'required' => $required, 'disabled' => $disabled, 'value' => $value)
		), $options);
	}

	static function radio($col, $label, $name, $radios, $required = false, $options = array()) {
		$options['radio'] = true;
		if (!isset($radios[0])) {
			$vals = array();
			foreach ($radios as $k => $v) {
				$vals[] = array('label' => $v, 'value' => $k, 'required' => $required);
			}
		} else {
			foreach ($radios as &$rad) {
				$rad['required'] = $required;
			}
			unset($rad);
			$vals = $radios;
		}
		self::checkboxes($col, $label, $name, $vals, $options);
	}

	/* ***************** SELECT ***************** */
	
	static function select($col, $label, $name, $values, $required = false, $options = array()) {
		$outputArr = array();
		parent::selectBase($label, $name, $values, $required, $options, $outputArr);
		get_called_class()::selectBuild($col, $label, $required, $options, $outputArr);
	}
	static function selectRS($col, $label, $name, $rs, $columns_labels, $columns_values, $required = false, $options = array()) {
		$values = array();
		parent::selectRSBase($rs, $columns_labels, $columns_values, $values);
		self::select($col, $label, $name, $values, $required, $options);
	}
}