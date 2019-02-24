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
		self::inputBuild($col, $label, $required, $options, $outputArr);
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
		parent::datepickerBase($name, $options);
		self::input($col, $label, $name, $required, $options);
	}

	static function clockpicker($col, $label, $name, $required = false, $options = array()) {
		parent::clockpickerBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	static function touchpicker($col, $label, $name, $required = false, $options = array()) {
		parent::touchpickerBase($options);
		self::input($col, $label, $name, $required, $options);
	}

	private static function inputBuild ($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		$build_field ='<div class="'.$col.' mb-3">'.'
			'.$label_output.'
			<div class="controls">
				<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">

				'.(isset($options['prependBtn']) ? '<div class="input-group-btn input-group-prepend">
					'.$options['prependBtn'].'
					</div>' : '').'
				'.(isset($options['prepend']) ? '<div class="input-group-addon input-group-prepend">
					<span class="input-group-text">'.$options['prepend'].'</span>
					</div>' : '').'
				
				<input class="form-control" '.NForm::getFldAttributes($options, $required).' type="'.$options['type'].'" />
				
				'.(isset($options['append']) ? '<div class="input-group-addon input-group-append">
					<span class="input-group-text">'.$options['append'].'</span>
					</div>' : '').'
				'.(isset($options['appendBtn']) ? '<div class="input-group-btn input-group-append">
					'.$options['appendBtn'].'
					</div>' : '').'
				</div>
			</div>
			'.(strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>' : '').'

		</div>'."\n\n";
		echo $build_field;
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($col, $label, $name, $required = false, $options = array()) {
		$outputArr = array();
		parent::textareaBase($label, $name, $required, $options, $outputArr);
		self::textareaBuild($col, $label, $required, $options, $outputArr);
	}

	static function wysiwyg($col, $label, $name, $required = false, $options = array()) {
		parent::wysiwygBase($options);
		self::textarea($col, $label, $name, $required, $options);
	}

	private static function textareaBuild ($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		$build_field ='<div class="'.$col.' mb-3">'.'
			'.$label_output.'
			<div class="controls">
				<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">
				' . (count($outputArr['additionalDivClasses']) > 0 ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
			
				<textarea class="form-control ' . implode(' ', $outputArr['additionalFldClasses']) . '" '
						. NFormBase::getFldAttributes($options, $required) 
						. '></textarea>
			
				' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
				' . (count($outputArr['additionalDivClasses']) > 0 ? '</div>' : '') . '
			
				</div>
			</div>
		</div>' . "\n\n";
		echo $build_field;
	}

	/* ***************** INPUT CHECKBOXES ***************** */
	
	static function checkboxes($col, $label, $name, $required = false, $options = array()) {
		$checkboxTags = array();
		$outputArr = array();
		parent::checkboxesBase($label, $mainName, $checkboxes, $checkboxTags, $options, $outputArr);
		get_called_class()::checkboxesBuild($col, $label, $checkboxTags, $options, $outputArr);
	}

	static function checkbox($col, $label, $name, $required = false, $disabled = false, $options = array()) {
		self::checkboxes($col, $label, $name, array(
			array('label' => '', 'name' => null, 'required' => $required, 'disabled' => $disabled)
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
		self::selectBuild($col, $label, $required, $options, $outputArr);
	}
	static function selectRS($col, $label, $name, $rs, $columns_labels, $columns_values, $required = false, $options = array()) {
		$values = array();
		parent::selectRSBase($rs, $columns_labels, $columns_values, $values);
		self::select($col, $label, $name, $values, $required, $options);
	}
	
	protected static function selectBuild($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		$build_field ='<div class="'.$col.' mb-3">'.'
			'.$label_output.'
			<div class="controls">
				<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">

				<select class="form-control" ' . NFormBase::getFldAttributes($options, $required) . ' style="width:100%">
				</select>
			
				' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
				
				</div>
			</div>
		</div>' . "\n\n";
		echo $build_field;
	}

	/* ***************** PLAIN HTML ***************** */

	static function html($text) {
		$formOptions = &self::$forms[self::$openForm];
		
		$class_label_offset = $formOptions['classLabel'];
		$class_label_offset = str_replace('md-', 'md-offset-', $class_label_offset);
		$class_label_offset = str_replace('lg-', 'lg-offset-', $class_label_offset);

		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			<div class="' . $class_label_offset . '">
				' . $text . '
			</div>
		</div><div class="hr-line-dashed"></div>';
	}
}