<?php
namespace DeployStudio\Style\Minimalart;

use DeployStudio\Style\StyleBaseClass;
use DeployStudio\Style\Base\NFormBase;


class NFormGroup extends \DeployStudio\Style\Base\NFormGroup {
	const THEME = 'MinimalArt';
	
	
	static function open($action, $multipart = false, $id = "", $get = false,
		$validationClass = "validate-form-custom") {
		self::openForm ($action, $multipart, $id, $get, $validationClass, NFormBase::FORM_TYPE_VERTICAL, 4);
	}

	static function inputBuild ($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '';
		if (!is_null($label)) {
			$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		}
		$build_field ='<div class="'.$col.' form-group">'.'
			'.$label_output.'
			<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">

			'.(isset($options['prependBtn']) ? '<div class="input-group-btn">
				'.$options['prependBtn'].'
				</div>' : '').'
			'.(isset($options['prepend']) ? '
				<span class="input-group-addon">'.$options['prepend'].'</span>
				' : '').'
			
			<input class="form-control" '.NForm::getFldAttributes($options, $required).' type="'.$options['type'].'" />
			
			'.(isset($options['append']) ? '
				<span class="input-group-addon">'.$options['append'].'</span>
				' : '').'
			'.(isset($options['appendBtn']) ? '<div class="input-group-btn">
				'.$options['appendBtn'].'
				</div>' : '').'
			</div>
			'.(strlen($options['description']) > 0 ? '<p class="help-block">'.$options['description'].'</p>' : '').'

		</div>'."\n\n";
		echo $build_field;
	}

	static function checkboxesBuild ($col, $label, $checkboxTags, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '<label>' . $label.' './*$outputArr['requiredLabel'] .*/ '</label>';
		$build_field ='<div class="'.$col.' form-group">'.'
			'.$label_output.'
			<div class="'/*.implode(' ', $outputArr['additionalDivClasses'])*/.'">
		
			' . (!empty($outputArr['additionalDivClasses']) ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			' . implode("\n", $checkboxTags) . '
		
			' . (!empty($options['description']) ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			' . (!empty($outputArr['additionalDivClasses']) ? '</div>' : '') . '
		
			</div>
		</div>' . "\n\n";
		echo $build_field;
	}

	static function textareaBuild ($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '';
		if (!is_null($label)) {
			$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		}
		$build_field ='<div class="'.$col.' form-group">'.'
			'.$label_output.'
			<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">
			' . (count($outputArr['additionalDivClasses']) > 0 ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			<textarea class="form-control ' . implode(' ', $outputArr['additionalFldClasses']) . '" '
					. NFormBase::getFldAttributes($options, $required) 
					. '></textarea>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			' . (count($outputArr['additionalDivClasses']) > 0 ? '</div>' : '') . '
		
			</div>
		</div>' . "\n\n";
		echo $build_field;
	}

	static function checkboxBuild ($chkname, $chkid, $c) {
		return '<div>
		<input type="checkbox" name="' . $chkname . '" id="' . $chkid . '" 
			' . (!empty($c['value']) ? 'value="'.$c['value'].'"' : '') . ' 
			' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
			' . ($c['disabled'] ? 'disabled' : '') . '
			>
			<label for="' . $chkid . '">' . $c['label'].'</label>'
							. (strlen($c['label']) > 0 && $c['required'] ? ' <font color="red">*</font>' : '') . '
		</div>
		';
	}

	static function radioBuild ($chkname, $chkid, $c) {
		return '<div>
		<input type="radio" name="' . $chkname . '" id="' . $chkid . '" 
			' . (!empty($c['value']) ? 'value="'.$c['value'].'"' : '') . ' 
			' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
			' . ($c['disabled'] ? 'disabled' : '') . '
			>
			<label for="' . $chkid . '">' . $c['label'].'</label>'
							. (strlen($c['label']) > 0 && $c['required'] ? ' <font color="red">*</font>' : '') . '
		</div>
		';
	}

	static function select($col, $label, $name, $values, $required = false, $options = array()) {
		StyleBaseClass::checkOption($options['theme'], 'bootstrap4');
		parent::select($col, $label, $name, $values, $required, $options);
	}

	static function selectRS($col, $label, $name, $rs, $columns_labels, $columns_values, $required = false, $options = array()) {
		StyleBaseClass::checkOption($options['theme'], 'bootstrap4');
		parent::selectRS($col, $label, $name, $rs, $columns_labels, $columns_values, $required, $options);
	}

	static function selectBuild($col, $label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		$label_output = '<label>' . $label.' '.$outputArr['requiredLabel'] . '</label>';
		$build_field ='<div class="'.$col.' form-group">'.'
			'.$label_output.'
			<div class="'.implode(' ', $outputArr['additionalDivClasses']).'">

			<select class="form-control" ' . NFormBase::getFldAttributes($options, $required) . ' style="width:100%">
			</select>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			
			</div>
		</div>' . "\n\n";
		echo $build_field;
	}
	
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