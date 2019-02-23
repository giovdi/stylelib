<?php
namespace DeployStudio\Style\Adminlte;

use DeployStudio\Style\StyleBaseClass;


class NForm extends \DeployStudio\Style\Base\NForm {
	static function open($action, $multipart = false, $id = "", $get = false,
		$validationClass = "validate-form-custom", $form_type = NForm::FORM_TYPE_HORIZONTAL) {
		self::openForm ($action, $multipart, $id, $get, $validationClass, $form_type, 3);
	}
	
	static function checkboxesBuild ($label, $checkboxTags, $options, $outputArr) {
		$formOptions = &self::$forms[self::$openForm];

		echo '<div class="'.$formOptions['formConst']['form-group'].'">
			<label class="' . $formOptions['classLabel'] . ' control-label">' . $outputArr['requiredLabel'] . $label . '</label>
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (!empty($outputArr['additionalDivClasses']) ? '<div class="' . implode(' ', $outputArr['additionalDivClasses']) . '">' : '') . '
		
			' . implode("\n", $checkboxTags) . '
		
			' . (!empty($options['description']) ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (!empty($outputArr['additionalDivClasses']) ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
	}

	static function checkboxBuild ($chkname, $chkid, $c) {
		return '
			<div class="checkbox">
				<label>
					<input type="checkbox" name="'.$chkname.'" id="'.$chkid.'"
						' . (!empty($c['value']) ? 'value="'.$c['value'].'"' : '') . ' 
						' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
						' . ($c['disabled'] ? 'disabled' : '') . '>
					' . $c['label'] . '
					' . (strlen($c['label']) > 0 && $c['required'] ? ' <font color="red">*</font>' : '') . '
				</label>
			</div>';
	}

	static function radioBuild ($chkname, $chkid, $c) {
		return '
			<div class="radio">
				<label>
					<input type="radio" name="'.$chkname.'" id="'.$chkid.'"
						' . (!empty($c['value']) ? 'value="'.$c['value'].'"' : '') . ' 
						' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
						' . ($c['disabled'] ? 'disabled' : '') . '>
					' . $c['label'] . '
				</label>
			</div>';
	}
}