<?php
namespace DeployStudio\Style\Angle;

use DeployStudio\Style\StyleBaseClass;
use DeployStudio\Style\Base\NFormBase;

class NForm extends \DeployStudio\Style\Base\NForm {
	static function open($action, $multipart = false, $id = "", $get = false,
		$validationClass = "validate-form-custom", $form_type = NFormBase::FORM_TYPE_HORIZONTAL) {
		self::openForm ($action, $multipart, $id, $get, $validationClass, $form_type, 4);
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
		return '';
	}

	static function radioBuild ($chkname, $chkid, $c) {
		return '';
	}
}