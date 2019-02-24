<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\Base\StyleLib;
use \DeployStudio\Style\StyleBaseClass;

class NForm extends NFormBase {

	/* ***************** INPUT ***************** */

	static function input($label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::inputBase($label, $name, $required, $options, $outputArr);
		self::inputBuild($label, $required, $options, $outputArr);
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

	private static function inputBuild ($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>';
		$build_field = '<div class="'.$formOptions['formConst']['form-group'].'">
			' . $label_output . '
				
			<div class="' . $formOptions['classInput'] . ' controls">
			<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">

			'.(isset($options['prependBtn']) ? '<div class="input-group-btn input-group-prepend">
				'.$options['prependBtn'].'
				</div>' : '').'
			'.(isset($options['prepend']) ? '<div class="input-group-addon input-group-prepend">
				<span class="input-group-text">'.$options['prepend'].'</span>
				</div>' : '').'
			
			<input class="form-control" ' . self::getFldAttributes($options, $required) . ' type="' . $options['type'] . '" />
			
			'.(isset($options['append']) ? '<div class="input-group-addon input-group-append">
				<span class="input-group-text">'.$options['append'].'</span>
				</div>' : '').'
			'.(isset($options['appendBtn']) ? '<div class="input-group-btn input-group-append">
				'.$options['appendBtn'].'
				</div>' : '').'

			' . (strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			</div>
			
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		echo $build_field;
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::textareaBase($label, $name, $required, $options, $outputArr);
		self::textareaBuild($label, $required, $options, $outputArr);
	}

	static function wysiwyg($label, $name, $required = false, $options = array()) {
		parent::wysiwygBase($options);
		self::textarea($label, $name, $required, $options);
	}

	private static function textareaBuild ($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (count($outputArr['additionalDivClasses']) > 0 ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			<textarea class="form-control ' . implode(' ', $outputArr['additionalFldClasses']) . '" '
					. NFormBase::getFldAttributes($options, $required) 
					. '></textarea>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (count($outputArr['additionalDivClasses']) > 0 ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
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
		self::selectBuild($label, $required, $options, $outputArr);
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
	
	protected static function selectBuild($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>';
		$build_field = '<div class="'.$formOptions['formConst']['form-group'].'">
				' . $label_output . '
				
				<div class="' . $formOptions['classInput'] . ' controls">
					<select class="form-control" ' . NFormBase::getFldAttributes($options, $required) . ' style="width:100%">
					</select>
				
					' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
					
				</div>
			</div><div class="hr-line-dashed"></div>' . "\n\n";
		echo $build_field;
	}

	/* ***************** PLAIN HTML ***************** */

	static function html($text) {
		$formOptions = &self::$forms[self::$openForm];
		
		$class_label_offset = $formOptions['classLabel'];
		$class_label_offset = str_replace('md-', 'md-offset-', $class_label_offset);
		$class_label_offset = str_replace('lg-', 'lg-offset-', $class_label_offset);

		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			<div class="' . $formOptions['classInput'] . ' ' . $class_label_offset . ' controls">
				' . $text . '
			</div>
		</div><div class="hr-line-dashed"></div>';
	}
}