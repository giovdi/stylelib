<?php
namespace DeployStudio\Style\Bootstrap;

use DeployStudio\Style\StyleBaseClass;
use DeployStudio\Style\Base\NFormBase;

class NForm extends \DeployStudio\Style\Base\NForm {
	const THEME = 'Bootstrap';

	static function open($action, $multipart = false, $id = "", $get = false,
		$validationClass = "validate-form-custom", $form_type = NFormBase::FORM_TYPE_HORIZONTAL) {
		self::openForm ($action, $multipart, $id, $get, $validationClass, $form_type, 4);
	}

	static function inputBuild ($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '';
		if (!is_null($label)) {
			$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>';
		}
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

			' . (strlen($options['description']) > 0 ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			</div>
			
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		echo $build_field;
	}

	static function textareaBuild ($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		$label_output = '';
		if (!is_null($label)) {
			$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>';
		}
		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			'.$label_output.'
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (count($outputArr['additionalDivClasses']) > 0 ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			<textarea class="form-control ' . implode(' ', $outputArr['additionalFldClasses']) . '" '
					. NFormBase::getFldAttributes($options, $required) 
					. '></textarea>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			' . (count($outputArr['additionalDivClasses']) > 0 ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
	}
	
	static function checkboxesBuild ($label, $checkboxTags, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (!empty($outputArr['additionalDivClasses']) ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			' . implode("\n", $checkboxTags) . '
		
			' . (!empty($options['description']) ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
			' . (!empty($outputArr['additionalDivClasses']) ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
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
		return '';
	}
	
	static function selectBuild($label, $required, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>';
		$build_field = '<div class="'.$formOptions['formConst']['form-group'].'">
				' . $label_output . '
				
				<div class="' . $formOptions['classInput'] . ' controls">
					<select class="form-control" ' . NFormBase::getFldAttributes($options, $required) . ' style="width:100%">
					</select>
				
					' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block">' . $options['description'] . '</p>' : '') . '
					
				</div>
			</div><div class="hr-line-dashed"></div>' . "\n\n";
		echo $build_field;
	}
	
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