<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\Base\StyleLib;
use \DeployStudio\Style\StyleBaseClass;

class NForm extends NFormBase {

	/* ***************** INPUT ***************** */

	static function input($label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::inputBase($label, $name, $required, $options, $outputArr);
		get_called_class()::inputBuild($label, $required, $options, $outputArr);
	}

	static function email($label, $name, $required = false, $options = array()) {
		parent::emailBase($options);
		self::input($label, $name, $required, $options);
	}

	static function password($label, $name, $required = false, $options = array()) {
		parent::passwordBase($options);
		self::input($label, $name, $required, $options);
	}

	static function file($label, $name, $required = false, $options = array()) {
		if (isset($options['multiple']) && $options['multiple']) {
			$name .= '[]';
		}

		parent::fileBase($options);
		self::input($label, $name, $required, $options);
	}

	static function datepicker($label, $name, $required = false, $options = array()) {
		parent::datepickerBase($name, $options);
		self::input($label, $name.'_in', $required, $options);
	}

	static function datetimepicker($label, $name, $required = false, $options = array()) {
		parent::datetimepickerBase($name, $options);
		self::input($label, $name, $required, $options);
	}

	static function clockpicker($label, $name, $required = false, $options = array()) {
		parent::clockpickerBase($options);
		self::input($label, $name, $required, $options);
	}

	static function touchspin($label, $name, $required = false, $options = array()) {
		parent::touchspinBase($options);
		self::input($label, $name, $required, $options);
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::textareaBase($label, $name, $required, $options, $outputArr);
		get_called_class()::textareaBuild($label, $required, $options, $outputArr);
	}

	static function wysiwyg($label, $name, $required = false, $options = array()) {
		parent::wysiwygBase($options);
		self::textarea($label, $name, $required, $options);
	}

	/* ***************** INPUT CHECKBOXES ***************** */
	
	static function checkboxes($label, $mainName, $checkboxes, $options = array()) {
		$checkboxTags = array();
		$outputArr = array();
		parent::checkboxesBase($label, $mainName, $checkboxes, $checkboxTags, $options, $outputArr);
		get_called_class()::checkboxesBuild($label, $checkboxTags, $options, $outputArr);
	}

	static function checkbox($label, $name, $required = false, $disabled = false, $options = array()) {
		self::checkboxes($label, $name, array(
			array('label' => '', 'name' => null, 'required' => $required, 'disabled' => $disabled)
		), $options);
	}

	static function radio($label, $name, $radios, $required = false, $options = array()) {
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
		self::checkboxes($label, $name, $vals, $options);
	}

	/* ***************** SELECT ***************** */
	
	static function select($label, $name, $values, $required = false, $options = array()) {
		$outputArr = array();
		parent::selectBase($label, $name, $values, $required, $options, $outputArr);
		get_called_class()::selectBuild($label, $required, $options, $outputArr);
	}
	static function selectAjax($label, $name, $ajaxUrl, $keys_labels = 'text', $key_values = 'id', $required = false, $options = array()) {
		parent::selectAjaxBase($ajaxUrl, $keys_labels, $key_values, $options);
		if (empty($options['value'])) {
			$values = array();
		} elseif (empty($options['value'][0])) {
			$values = array($options['value']);
		} else {
			$values = $options['value'];
		}
		$options['_key_values'] = $key_values;
		self::select($label, $name, $values, $required, $options);
	}
	static function selectRS($label, $name, $rs, $columns_labels, $columns_values, $required = false, $options = array()) {
		$values = array();
		parent::selectRSBase($rs, $columns_labels, $columns_values, $values);
		self::select($label, $name, $values, $required, $options);
	}
}