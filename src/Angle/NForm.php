<?php
namespace DeployStudio\Style\Angle;

use DeployStudio\Style\StyleBaseClass;
use DeployStudio\Style\Base\NFormBase;

class NForm extends \DeployStudio\Style\Base\NForm {
	static function open($action, $multipart = false, $id = "", $get = false,
		$validationClass = "validate-form-custom", $form_type = NFormBase::FORM_TYPE_HORIZONTAL) {
		self::openForm ($action, $multipart, $id, $get, $validationClass, $form_type, 4);
	}
}