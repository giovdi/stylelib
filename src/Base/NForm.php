<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\StyleBaseClass;

class NForm {
	const FORM_TYPE_HORIZONTAL = 1;
	const FORM_TYPE_VERTICAL = 2;
	const FORM_TYPE_INLINE = 3;

	protected static $forms;
	protected static $openForm;

	static function open($action, $multipart = false, $id = "", $get = false,
	$validationClass = "validate-form-custom", $form_type = NForm::FORM_TYPE_HORIZONTAL) {
		StyleBaseClass::checkOption($id, 'form'.rand(1000,9999));
		$formOptions = array(
			'id' => $id,
			'fields' => array()
		);

		self::$openForm = $id;
		self::$forms[$id] = &$formOptions;
		
		switch ($form_type) {
			case NForm::FORM_TYPE_VERTICAL:
				$horizontalClass = '';
				$formOptions['classLabel'] = "";
				$formOptions['classInput'] = "";
				break;

			case NForm::FORM_TYPE_INLINE:
				$horizontalClass = 'form-inline ';
				$formOptions['classLabel'] = "";
				$formOptions['classInput'] = "";
				break;

			case NForm::FORM_TYPE_HORIZONTAL:
			default:
				$horizontalClass = 'form-horizontal ';
				$formOptions['classLabel'] = "col-md-2";
				$formOptions['classInput'] = "col-md-10";
				break;
		}
		
		echo '
		<form class="form '.$horizontalClass.$validationClass.'"
			style="margin-bottom: 0;"
			method="'.($get ? 'get' : 'post').'"
			action="'.$action.'" novalidate="novalidate"
			'.($multipart ? 'enctype="multipart/form-data"' : '').
			' id="'.$id.'">
		<input type="hidden" name="redirect"
			value="'.(isset($_GET['r']) ? urlencode($_GET['r']) : '').'" />';
	}
	
	static function close() {
		self::$openForm = null;
		echo '</form>';
	}

		
	static protected function getFldAttributes($options, $required) {
		$attr = array();

		$attr[] = 'id="' . $options['id'] . '"';
		$attr[] = 'name="' . $options['name'] . '"';

		// regole di validazione
		if ($required)
			$attr[] = 'data-rule-required="true"';
		if (isset($options['email']) && $options['email'])
			$attr[] = 'data-rule-email="true"';
		if (isset($options['number']) && $options['number'])
			$attr[] = 'data-rule-number="true"';
		if (isset($options['min']) && $options['min'])
			$attr[] = 'data-rule-min="' . $options['min'] . '"';
		if (isset($options['max']) && $options['max'])
			$attr[] = 'data-rule-max="' . $options['max'] . '"';
		if (isset($options['date']) && $options['date'])
			$attr[] = 'data-rule-date="true"';
		if (isset($options['dateITA']) && $options['dateITA'])
			$attr[] = 'data-rule-dateITA="true"';
		if (isset($options['time']) && $options['time'])
			$attr[] = 'data-rule-time="true"';
		if (isset($options['regexp']) && $options['regexp'])
			$attr[] = 'data-rule-pattern="' . $options['regexp'] . '"';

		if (isset($options['placeholder']))
			$attr[] = 'placeholder="' . $options['placeholder'] . '"';
		if (isset($options['rows']))
			$attr[] = 'rows="' . $options['rows'] . '"';
		if (isset($options['style']))
			$attr[] = 'style="' . $options['style'] . '"';
		if (isset($options['onblur']))
			$attr[] = 'onblur="' . $options['onblur'] . '"';
		if (isset($options['onchange']))
			$attr[] = 'onchange="' . $options['onchange'] . '"';
		if (isset($options['onkeyup']))
			$attr[] = 'onkeyup="' . $options['onkeyup'] . '"';
		if (isset($options['maxlength']))
			$attr[] = 'maxlength="' . $options['maxlength'] . '"';
		if (isset($options['disabled']) && $options['disabled'])
			$attr[] = 'disabled';
		if (isset($options['multiple']) && $options['multiple'])
			$attr[] = 'multiple="multiple"';
		if (isset($options['dateformat']))
			$attr[] = 'data-format="' . $options['dateformat'] . '"';

		return implode(' ', $attr);
	}

	/* ***************** FIELDS ***************** */
	/* ***************** INPUT ***************** */

	static function input($label, $name, $required = false, $options = array()) {
		$formOptions = self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'input'.rand(100000,999999));
		$options['name'] = $name;
		//$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'input');

		// rules
		$requiredLabel = '';
		if ($required) {
			$requiredLabel = '<font color="red">*</font> ';
		}

		// additional classes
		$additionalDivClasses = array();
		if (isset($options['prepend']) || isset($options['append'])) {
			$additionalDivClasses[] = 'input-group';
		}
		if (isset($options['additionalDivClasses']) && is_array($options['additionalDivClasses'])) {
			$additionalDivClasses = array_merge($additionalDivClasses, $options['additionalDivClasses']);
		}

		// additional field options
		if (!isset($options['type'])) {
			$options['type'] = 'text';
		}
		if (!isset($options['description'])) {
			$options['description'] = '';
		}


		// BUILD FIELD
		$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>';
		$build_field = '<div class="form-group">
			' . $label_output . '
				
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (count($additionalDivClasses) > 0 ? '<div class="' . implode(' ', $additionalDivClasses) . '">' : '') . '
			' . (isset($options['prepend']) ? '<span class="input-group-addon">' . $options['prepend'] . '</span>' : '') . '
			
			<input class="form-control" ' . NForm::getFldAttributes($options, $required) . ' type="' . $options['type'] . '" />
			
			' . (isset($options['append']) ? '<span class="input-group-addon">' . $options['append'] . '</span>' : '') . '
			' . (strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (count($additionalDivClasses) > 0 ? '</div>' : '') . '
			
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		echo $build_field;
		

		// VALUE
		if (isset($options['value']) && strlen($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			echo '$("#'.$options['id'].'").val(\'' . StyleBaseClass::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variante: email ***** */

	static function email($label, $name, $required = false, $options = array()) {
		$options['email'] = true;
		$options['type'] = 'email';
		NForm::input($label, $name, $required, $options);
	}

	/* ***** variante: password ***** */

	static function password($label, $name, $required = false, $options = array()) {
		$options['type'] = 'password';
		NForm::input($label, $name, $required, $options);
	}

	/* ***** variante: file ***** */

	static function file($label, $name, $required = false, $options = array()) {
		$options['type'] = 'file';

		if (isset($options['multiple']) && $options['multiple']) {
			$name .= '[]';
		}

		NForm::input($label, $name, $required, $options);
	}

	/* ***** variante: datepicker ***** */

	static function datepicker($label, $name, $required = false, $options = array()) {
		// campo hidden
		StyleBaseClass::checkOption($options['id'], 'input'.rand(100000,999999));
		$hiddenid = $options['id'].'_hidden';
		
		// campo input
		$optionsInput = $options;
		if (isset($options['value'])) {
			$optionsInput['value'] = date('d/m/Y', strtotime($options['value']));
		}

		$optionsInput['additionalDivClasses'] = array('date');
		if (isset($options['additionalDivClasses'])) {
			$optionsInput['additionalDivClasses'] = array_merge($optionsInput['additionalDivClasses'], $options['additionalDivClasses']);
		}
		
		$optionsInput['prepend'] = '<span class="fa fa-calendar"></span>';
		$optionsInput['dateITA'] = true;
		NForm::input($label, $name.'_in', $required, $optionsInput);
		
		$hiddenValue = empty($options['value']) ? '' : $options['value'];
		NForm::hidden($name, $hiddenValue, $hiddenid);
	}
	
	static function clockpicker($label, $name, $required = false, $options = array()) {
		$optionsClass['additionalDivClasses'] = array('clockpicker');
		
		if (isset($options['additionalDivClasses'])) {
			$options['additionalDivClasses'] = array_merge($optionsClass['additionalDivClasses'], $options['additionalDivClasses']);
		} else {
			$options['additionalDivClasses'] = array('clockpicker');
		}
		
		$options['prepend'] = '<span class="fa fa-clock-o"></span>';
		$options['time'] = true;
		NForm::input($label, $name, $required, $options);
	}
	
	static function touchspin($label, $name, $required = false, $options = array()) {
		$options['additionalDivClasses'] = array('touchspin');
		$options['numeric'] = true;
		NForm::input($label, $name, $required, $options);
	}

	/* ***** variante: datetimepicker ***** * NOT SUPPORTED YET

	static function datetimepicker($label, $name, $required = false, $options = array()) {
		if (!isset($options['dateformat']))
			$options['dateformat'] = 'dd/MM/yyyy HH:mm:ss PP';

		$options['additionalDivClasses'] = array('datetimepicker');
		$options['append'] = '<span data-date-icon="fa fa-calendar" data-time-icon="fa fa-time"></span>';
		//$options['dateITA'] = true;

		NForm::input($label, $name, $required, $options);
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($label, $name, $required = false, $options = array()) {
		$formOptions = self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'textarea'.rand(100000,999999));
		$options['name'] = $name;
		//$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'textarea');

		// rules
		$requiredLabel = '';
		if ($required) {
			$requiredLabel = '<font color="red">*</font> ';
		}

		// additional classes
		$additionalDivClasses = array();

		$additionalFldClasses = array();
		if (isset($options['autosize']) && $options['autosize']){
			$additionalFldClasses[] = 'autosize';
		}
		if (isset($options['additionalFldClasses']) && is_array($options['additionalFldClasses'])) {
			$additionalFldClasses = array_merge($additionalFldClasses, $options['additionalFldClasses']);
		}


		// BUILD FIELD
		echo '<div class="form-group">
			<label class="' . $formOptions['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (count($additionalDivClasses) > 0 ? '<div class="' . implode(' ', $additionalDivClasses) . '">' : '') . '
		
			<textarea class="form-control ' . implode(' ', $additionalFldClasses) . '" '
					. NForm::getFldAttributes($options, $required) 
					. '></textarea>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (count($additionalDivClasses) > 0 ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		
					
		// VALUE
		if (isset($options['value']) && strlen($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			echo '$("#'.$options['id'].'").val(\'' . StyleBaseClass::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variante: wysiwyg ***** */

	static function wysiwyg($label, $name, $required = false, $options = array()) {
		$options['additionalFldClasses'][] = 'wysihtml5';
		NForm::textarea($label, $name, $required, $options);
	}

	/* ***************** INPUT CHECKBOXES ***************** */

	static function checkboxes($label, $mainName, $checkboxes, $options = array()) {
		$formOptions = self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'checkbox'.rand(100000,999999));

		// rules
		$requiredLabel = '';
		if (is_array($checkboxes[0]) && isset($checkboxes[0]['name']) && is_null($checkboxes[0]['name'])
		&& isset($checkboxes[0]['required']) && $checkboxes[0]['required']) {
			$requiredLabel = '<font color="red">*</font> ';
		}

		// BUILD CHECKBOXES
		$checkboxTags = array();
		foreach ($checkboxes as $k => $c) {
			if (!is_array($c)) {
				$c = array('label' => $c, 'value' => $k);
			}
			StyleBaseClass::checkOption($c['required'], false);
			StyleBaseClass::checkOption($c['disabled'], false);

			// checkbox name
			StyleBaseClass::checkOption($c['name'], null);
			$chkname = $mainName;
			if (!is_null($c['name'])) {
				$chkname .= '[' . $c['name'] . ']';
			} elseif (count($checkboxes) > 1) {
				$chkname .= '[]';
			}

			// checkbox id
			if (isset($c['name'])) {
				StyleBaseClass::checkOption($c['id'], $c['name']);
			}
			if (isset($c['value'])) {
				StyleBaseClass::checkOption($c['id'], $c['value']);
			}
			if (count($checkboxes) > 1) {
				StyleBaseClass::checkOption($c['id'], 'c'.rand(100000,999999));
			}
			StyleBaseClass::checkOption($c['id'], null);
			$chkid = $options['id'] . (!is_null($c['id']) ? '_' . $c['id'] : '');

			$checkboxTags[] = '<div class="checkbox checkbox-success">
				<input type="checkbox" name="' . $chkname . '" id="' . $chkid . '" 
					' . (!empty($c['value']) > 0 ? 'value="'.$c['value'].'"' : '') . ' 
					' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
					' . ($c['disabled'] ? 'disabled' : '') . '
					>
					&nbsp;<label>' . $c['label'].'</label>'
									. (strlen($c['label']) > 0 && $c['required'] ? ' <font color="red">*</font>' : '') . '
				</div>';
		}

		// BUILD FIELD
		echo '<div class="form-group">
			<label class="' . $formOptions['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>
		
			<div class="' . $formOptions['classInput'] . ' controls">
			' . (!empty($additionalDivClasses) ? '<div class="' . implode(' ', $additionalDivClasses) . '">' : '') . '
		
			' . implode("\n", $checkboxTags) . '
		
			' . (!empty($options['description']) ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (!empty($additionalDivClasses) ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		
		
		// VALUE
		if (isset($options['value']) && !is_array($options['value'])) {
			$options['value'] = array($options['value']);
		}
		if (isset($options['value']) && is_array($options['value']) && count($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			foreach ($options['value'] as $val) {
				if ($val == 'on') {
					echo '$("#'.$options['id'].'").prop("checked", true);' . "\n";
				} else {
					echo '$("#'.$options['id'].'[value=\\"'.$val.'\\"]").prop("checked", true);' . "\n";
				}
			}
			echo '});</script>';
		}
	}

	/* ***** variante: single checkbox ***** */

	static function checkbox($label, $name, $required = false, $disabled = false, $options = array()) {
		NForm::checkboxes($label, $name, array(
			array('label' => '', 'name' => null, 'required' => $required, 'disabled' => $disabled)
		), $options);
	}

	/* ***************** SELECT ***************** */

	static function select($label, $name, $values, $required = false, $options = array()) {
		$formOptions = self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'select'.rand(100000,999999));
		$options['name'] = $name;
		if (isset($options['multiple']) && $options['multiple']) {
			$options['name'] .= '[]';
		}
		//$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'select', 'values' => $values);

		// rules
		$requiredLabel = '';
		if ($required) {
			$requiredLabel = '<font color="red">*</font> ';
		}

		
		// BUILD FIELD
		$label_output = '<label class="' . $formOptions['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>';
		$build_field = '<div class="form-group">
				' . $label_output . '
				
				<div class="' . $formOptions['classInput'] . ' controls">
					<select class="form-control" ' . NForm::getFldAttributes($options, $required) . ' style="width:100%">
					</select>
				
					' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
					
				</div>
			</div><div class="hr-line-dashed"></div>' . "\n\n";

		// SELECT2 INIT
		// data
		$data = array(array());
		if (!is_array($values)) {
			echo '<b>Debug</b>: $values for the ' . $name . ' field is not an array, please check the select declaration.';
		} elseif (isset($options['labelAsValue']) && $options['labelAsValue']) {
			foreach ($values as $val => $lab) {
				$data[] = array('id' => $lab, 'text' => $lab);
			}
		} else {
			foreach ($values as $val => $lab) {
				$data[] = array('id' => strval($val), 'text' => $lab);
			}
		}

		// placeholder
		if (isset($options['placeholder']))
			$placeholder = $options['placeholder'];
		elseif (isset($options['custom']) && $options['custom'])
			$placeholder = 'Seleziona oppure scrivi e premi INVIO per personalizzare';
		else
			$placeholder = 'Seleziona';

		// altre opzioni select2
		StyleBaseClass::checkOption($options['custom'], false);
		$tags = $options['custom'] ? 'true' : 'false';

		StyleBaseClass::checkOption($options['clear'], false);
		$clear = $options['clear'] ? 'true' : 'false';

		// output
		$output = '
			<script type="text/javascript">
				$(function() {
					select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . ' = $("#' . $options['id'] . '").select2({
						data:' . json_encode($data) . ',
						placeholder:"' . $placeholder . '",
						tags: ' . $tags . ',
						allowClear: ' . $clear . ',
						tokenSeparators: [\',\']
					});
				});
				' . (isset($options['globalData']) && $options['globalData'] ? 'var selectOptions_' . $options['id'] . ' = ' . json_encode($data) : '') . '
			</script>' . "\n\n";

		echo $build_field;
		echo $output;
		
		// VALUE
		if (isset($options['value']) && !is_array($options['value'])) {
			$options['value'] = array($options['value']);
		}
		if (isset($options['value']) && is_array($options['value']) && count($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			foreach ($options['value'] as $val) {
				$exists = false;
				foreach ($data as $d) {
					if (isset($d['id']) && $d['id'] == $val) {
						$exists = true;
					}
				}
				if (!$exists) {
					echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . '.select2().append("<option value=\"' . StyleBaseClass::jsReplace($val) . '\">' . StyleBaseClass::jsReplace($val) . '</option>");' . "\n";
				}
			}
			echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . '.val(["' . StyleBaseClass::jsReplace(implode('","', $options['value'])) . '"]).trigger("change");' . "\n";
			echo '});</script>';
		}
	}

	static function selectRS($label, $name, $rs, $columns_labels, $columns_values, $required = false, $options = array()) {
		$values = array();
		if (count($rs) > 0) {
			foreach ($rs as $row) {

				// get option labels
				if (is_array($columns_labels)) {
					$opt_label = '';
					foreach ($columns_labels as $collabel) {
						if (isset($row[$collabel]))
							$opt_label .= $row[$collabel];
						else
							$opt_label .= $collabel;
					}
				} else
					$opt_label = $row[$columns_labels];

				// get option value
				if (is_array($columns_values)) {
					$opt_value = '';
					foreach ($columns_values as $collabel) {
						if (isset($row[$collabel]))
							$opt_value .= $row[$collabel];
						else
							$opt_value .= $collabel;
					}
				} else
					$opt_value = $row[$columns_values];

				// append option
				$values[$opt_value] = $opt_label;
			};
		}
		NForm::select($label, $name, $values, $required, $options);
	}

	/* ***************** HIDDEN ***************** */

	static function hidden($name, $value, $id = null) {
		StyleBaseClass::checkOption($id, 'hidden'.rand(100000,999999));

		echo '<input name="' . $name . '" id="' . $id . '" type="hidden">
			<script type="text/javascript">$("#' . $id . '").val(\'' . StyleBaseClass::jsReplace($value) . '\');</script>';
	}

	/* ***************** PLAIN HTML ***************** */

	static function html($text) {
		$formOptions = self::$forms[self::$openForm];
		
		$class_label_offset = $formOptions['classLabel'];
		$class_label_offset = str_replace('md-', 'md-offset-', $class_label_offset);
		$class_label_offset = str_replace('lg-', 'lg-offset-', $class_label_offset);

		echo '<div class="form-group">
			<div class="' . $formOptions['classInput'] . ' ' . $class_label_offset . ' controls">
				' . $text . '
			</div>
		</div><div class="hr-line-dashed"></div>';
	}

	/* ***************** SUBMIT FORM ***************** */

	static function submitOnlyButtons($save_icon, $save_label, $cancel_btn = true, $other_actions = array(), $save_button_color = 'primary') {
		$formOptions = self::$forms[self::$openForm];
		
		$other_actions_str = '';
		if (!empty($other_actions)) {
			foreach ($other_actions as $action) {
				if ($action['modaldismiss']) {
					$modaldismiss = ' data-dismiss="modal"';
					$action['href'] = '#';
				} else {
					$modaldismiss = '';
				}

				if (!empty($action['icon']))
					$icon = '<span class="' . $action['icon'] . '"></span> ';
				else
					$icon = '';

				$other_actions_str .= '<a class="btn" href="' . $action['href'] . '"' . $modaldismiss . '>' . $icon . $action['label'] . '</a> ';
			}
		}

		echo '
			<button class="btn btn-' . $save_button_color . ' disabled" type="submit">
				<i class="' . $save_icon . '"></i> ' . $save_label . '
			</button>
			' . ($cancel_btn ? '<a class="btn btn-white" href="javascript:window.history.back()">' . 'Cancel' . '</a>' : '') . '
			' . $other_actions_str.'
			<script>$(function() {$(\'#'.self::$openForm.' button[type=submit]\').removeClass(\'disabled\')})</script>';
	}

	static function submitCustom($save_icon, $save_label, $cancel_btn = true, $other_actions = array(), $save_button_color = 'primary') {
		echo '
			<div class="form-actions formactions-padding-sm">
				<div class="row">
					<div class="col-md-10 col-md-offset-2">
						';
						NForm::submitOnlyButtons($save_icon, $save_label, $cancel_btn, $other_actions, $save_button_color);
						echo '
					</div>
				</div>
			</div>';
	}

	static function submit() {
		NForm::submitCustom('fa fa-save', 'Salva', true, array());
	}

	static function submitAsAjax($redirect, $other_actions = array()) {
		NForm::submitCustom('fa fa-save', 'Salva', true, $other_actions);
		echo '
			<div class="row" id="progress-bar-container" style="display: none">
			<label class="'.$formOptions['classLabel'].'" control-label">In corso...</label>
			<div class="col-md-10" style="padding-top: 7px">
				<div class="progress">
					<div class="progress-bar progress-bar-success"
						 style="width: 0%;">0%</div>
				</div>

				<div class="modal fade" id="formUploadModal" data-redirect="'.$redirect.'">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Avviso</h4>
								</div>
								<div class="modal-body">
									<p>
										<span class="text-danger fa fa-exclamation-circle"></span>
										Attenzione: il server ha restituito il seguente messaggio.<br>
										Contatta il team di sviluppo per maggiori informazioni. Grazie.<br>
										Clicca su Continua per proseguire
								<div id="status" style="max-height: 300px; overflow: auto">
								</div>
							</div>
							<div class="modal-footer">
								<a href="<?php echo $redirect ?>"
									class="btn btn-primary">Continua</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			</div>
		</div>
		';
	}

}
	