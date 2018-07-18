<?php
/* * *
 * Reference https://docs.google.com/document/d/1y0ukGEEfHNQb7TedfuI24DcizVGEMTEuG4bgNaUuOTE/edit?usp=sharing
 * ** */

namespace DeployStudio\Style;

use DeployStudio\Style\StyleLib;

class NForm {

	static function open($action, $multipart = false, $id = "", $get = false, $validationClass = "validate-form-custom", $horizontal = true) {
		if ($horizontal) {
			$horizontalClass = 'form-horizontal ';
		} else {
			$options['classLabel'] = "col-md-2";
			$options['classInput'] = "col-md-10";
		}
		
		echo '
		<form class="form '.$horizontalClass.$validationClass.'"
			style="margin-bottom: 0;"
			method="'.($get ? 'get' : 'post').'"
			action="'.$action.'" novalidate="novalidate"
			'.($multipart ? 'enctype="multipart/form-data"' : '')
			.(strlen($id) > 0 ? 'id="' . $id . '"' : '').'>
		<input type="hidden" name="redirect"
			value="'.(isset($_GET['r']) ? $_GET['r'] : '').'" />';
	}

	static function close() {
		echo '</form>';
	}

		
	static private function getFldRules($rules, $required) {
		$attr = array();

		// regole di validazione
		if ($required)
			$attr[] = 'data-rule-required="true"';
		if (isset($rules['email']) && $rules['email'])
			$attr[] = 'data-rule-email="true"';
		if (isset($rules['number']) && $rules['number'])
			$attr[] = 'data-rule-number="true"';
		if (isset($rules['min']) && $rules['min'])
			$attr[] = 'data-rule-min="' . $rules['min'] . '"';
		if (isset($rules['max']) && $rules['max'])
			$attr[] = 'data-rule-max="' . $rules['max'] . '"';
		if (isset($rules['date']) && rules['date'])
			$attr[] = 'data-rule-date="true"';
		if (isset($rules['dateITA']) && $rules['dateITA'])
			$attr[] = 'data-rule-dateITA="true"';
		if (isset($rules['time']) && $rules['time'])
			$attr[] = 'data-rule-time="true"';
		if (isset($rules['regexp']) && $rules['regexp'])
			$attr[] = 'data-rule-pattern="' . $rules['regexp'] . '"';

		return implode(' ', $attr);
	}

	static private function getFldOptions($options) {
		$attr = array();

		$attr[] = 'id="' . $options['id'] . '"';
		$attr[] = 'name="' . $options['name'] . '"';

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

	static function input($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
		// INITIALIZE
		// base options
		if (!isset($options['id'])) {
			$options['id'] = StyleLib::idGen($label);
		}
		$options['name'] = $name;
		//$this->fields[] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'input');

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
		if ($label) {
			$label_output = '<label class="' . $options['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>';
		}
		$build_field = '<div class="form-group">
			' . $label_output . '
				
			<div class="' . $options['classInput'] . ' controls">
			' . (count($additionalDivClasses) > 0 ? '<div class="' . implode(' ', $additionalDivClasses) . '">' : '') . '
			' . (isset($options['prepend']) ? '<span class="input-group-addon">' . $options['prepend'] . '</span>' : '') . '
			
			<input class="form-control" ' . NForm::getFldRules($rules, $required) . ' ' . NForm::getFldOptions($options)
							. ' type="' . $options['type'] . '" />
			
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
			echo '$("#'.$options['id'].'").val(\'' . StyleLib::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variation: email ***** */

	static function email($label, $name, $required = false, $rules = array(), $options = array()) {
		$rules['email'] = true;
		$options['type'] = 'email';
		NForm::input($label, $name, $required, $rules, $options);
	}

	/* ***** variation: password ***** */

	static function password($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['type'] = 'password';
		NForm::input($label, $name, $required, $rules, $options);
	}

	/* ***** variation: file ***** */

	static function file($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['type'] = 'file';

		if (isset($options['multiple']) && $options['multiple'])
			$name .= '[]';

		NForm::input($label, $name, $required, $rules, $options);
	}

	/* ***** variation: datepicker ***** */

	static function datepicker($label, $name, $required = false, $rules = array(), $options = array()) {
		$optionsInput = $options;
		
		if (!isset($options['id'])) {
			$optionsInput['id'] = StyleLib::idGen($label);
			$hiddenid = StyleLib::idGen($label).'_hidden';
		} else {
			$optionsInput['id'] = $options['id'];
			$hiddenid = $options['id'].'_hidden';
		}
		
		if (isset($options['value'])) {
			$optionsInput['value'] = date('d/m/Y', strtotime($options['value']));
		}

		$optionsInput['additionalDivClasses'] = array('date');
		if (isset($options['additionalDivClasses'])) {
			$optionsInput['additionalDivClasses'] = array_merge($optionsInput['additionalDivClasses'], $options['additionalDivClasses']);
		}
		
		$optionsInput['prepend'] = '<span class="fa fa-calendar"></span>';
		$rules['dateITA'] = true;
		NForm::input($label, $name.'_in', $required, $rules, $optionsInput);
		
		$hiddenValue = empty($options['value']) ? '' : $options['value'];
		NForm::hidden($name, $hiddenValue, $hiddenid);
	}
	
	static function clockpicker($label, $name, $required = false, $rules = array(), $options = array()) {
		$optionsClass['additionalDivClasses'] = array('clockpicker');
		
		if (isset($options['additionalDivClasses'])) {
			$options['additionalDivClasses'] = array_merge($optionsClass['additionalDivClasses'], $options['additionalDivClasses']);
		} else {
			$options['additionalDivClasses'] = array('clockpicker');
		}
		
		$options['prepend'] = '<span class="fa fa-clock-o"></span>';
		$rules['time'] = true;
		NForm::input($label, $name, $required, $rules, $options);
	}
	
	static function touchspin($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['additionalDivClasses'] = array('touchspin');
		$rules['numeric'] = true;
		NForm::input($label, $name, $required, $rules, $options);
	}

	/* ***** variation: datetimepicker ***** * NOT SUPPORTED

	static function datetimepicker($label, $name, $required = false, $rules = array(), $options = array()) {
		if (!isset($options['dateformat']))
			$options['dateformat'] = 'dd/MM/yyyy HH:mm:ss PP';

		$options['additionalDivClasses'] = array('datetimepicker');
		$options['append'] = '<span data-date-icon="fa fa-calendar" data-time-icon="fa fa-time"></span>';
		//$rules['dateITA'] = true;

		NForm::input($label, $name, $required, $rules, $options);
	}

	/* ***************** TEXTAREA ***************** */

	static function textarea($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
		// INITIALIZE
		// base options
		if (!isset($options['id']))
			$options['id'] = StyleLib::idGen($label);
		$options['name'] = $name;
		//$this->fields[] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'textarea');

		// rules
		$requiredLabel = '';
		if ($required)
			$requiredLabel = '<font color="red">*</font> ';

		// additional classes
		$additionalDivClasses = array();

		$additionalFldClasses = array();
		if (isset($options['autosize']) && $options['autosize'])
			$additionalFldClasses[] = 'autosize';
		if (isset($options['additionalFldClasses']) && is_array($options['additionalFldClasses']))
			$additionalFldClasses = array_merge($additionalFldClasses, $options['additionalFldClasses']);


		// BUILD FIELD
		echo '<div class="form-group">
			<label class="' . $options['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>
		
			<div class="' . $options['classInput'] . ' controls">
			' . (count($additionalDivClasses) > 0 ? '<div class="' . implode(' ', $additionalDivClasses) . '">' : '') . '
		
			<textarea class="form-control ' . implode(' ', $additionalFldClasses) . '" '
					. NForm::getFldRules($rules, $required) . ' ' . NForm::getFldOptions($options)
					. '></textarea>
		
			' . (isset($options['description']) && strlen($options['description']) > 0 ? '<p class="help-block"><small class="text-muted">' . $options['description'] . '</small>' : '') . '
			' . (count($additionalDivClasses) > 0 ? '</div>' : '') . '
		
			</div>
		</div><div class="hr-line-dashed"></div>' . "\n\n";
		
					
		// VALUE
		if (isset($options['value']) && strlen($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			echo '$("#'.$options['id'].'").val(\'' . StyleLib::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variation: wysiwyg ***** */

	static function wysiwyg($label, $name, $required = false, $rules = array(), $options = array()) {
		$options['additionalFldClasses'][] = 'wysihtml5';
		NForm::textarea($label, $name, $required, $rules, $options);
	}

	/* ***************** INPUT CHECKBOXES ***************** */

	static function checkboxes($label, $mainName, $checkboxes, $options = array()) {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
		// INITIALIZE
		// base options
		if (!isset($options['id']))
			$options['id'] = StyleLib::idGen($label);

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
			if (!isset($c['required'])) {
				$c['required'] = false;
			}
			if (!isset($c['disabled'])) {
				$c['disabled'] = false;
			}
			if (!isset($c['name'])) {
				$c['name'] = null;
			}
			$chkname = $mainName . (!is_null($c['name']) ? '[' . $c['name'] . ']' : '');
			$chkid = $options['id'] . (!is_null($c['name']) ? '_' . $c['name'] : '');
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
			<label class="' . $options['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>
		
			<div class="' . $options['classInput'] . ' controls">
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

	/* ***** variation: single checkbox ***** */

	static function checkbox($label, $name, $required = false, $disabled = false, $options = array()) {
		NForm::checkboxes($label, $name, array(
			array('label' => '', 'name' => null, 'required' => $required, 'disabled' => $disabled)
				), $options);
	}

	/* ***************** SELECT ***************** */

	static function select($label, $name, $values, $required = false, $rules = array(), $options = array()) {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
		// INITIALIZE
		// base options
		if (!isset($options['id']))
			$options['id'] = StyleLib::idGen($label);
		$options['name'] = $name;
		//$this->fields[] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'select', 'values' => $values);

		// rules
		$requiredLabel = '';
		if ($required)
			$requiredLabel = '<font color="red">*</font> ';

		
		$label_output = '';
		if ($label) {
			$label_output = '<label class="' . $options['classLabel'] . ' control-label">' . $requiredLabel . $label . '</label>';
		}

		// BUILD FIELD
		$build_field = '<div class="form-group">
	' . $label_output . '
	
	<div class="' . $options['classInput'] . ' controls">
		<select class="form-control" ' . NForm::getFldRules($rules, $required) . ' ' . NForm::getFldOptions($options) . ' style="width:100%">
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

		// tags (available only if custom = true)
		if (isset($options['custom']) && $options['custom'])
			$tags = 'true';
		else
			$tags = 'false';
		if (isset($options['allowClear']) && $options['allowClear'])
			$clear = 'true';
		else
			$clear = 'false';

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
		if (!isset($options['return']) || !$options['return']) {
			echo $build_field;
			echo $output;
		}
		
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
					echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . '.select2().append("<option value=\"' . StyleLib::jsReplace($val) . '\">' . StyleLib::jsReplace($val) . '</option>");' . "\n";
				}
			}
			echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . '.val(["' . StyleLib::jsReplace(implode('","', $options['value'])) . '"]).trigger("change");' . "\n";
			echo '});</script>';
		}
	}

	static function selectRS($label, $name, $rs, $columns_labels, $columns_values, $required = false, $rules = array(), $options = array()) {
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
		NForm::select($label, $name, $values, $required, $rules, $options);
	}

	/* ***************** HIDDEN ***************** */

	static function hidden($name, $value, $id = null) {
		if (is_null($id))
			$id = $name;

		echo '<input name="' . $name . '" id="' . $id . '" type="hidden">
			<script type="text/javascript">$("#' . $id . '").val(\'' . StyleLib::jsReplace($value) . '\');</script>';
	}

	/* ***************** PLAIN HTML ***************** */

	static function plainHtml($text) {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
		$class_label_offset = $options['classLabel'];
		$class_label_offset = str_replace('md-', 'md-offset-', $class_label_offset);
		$class_label_offset = str_replace('lg-', 'lg-offset-', $class_label_offset);

		echo '<div class="form-group">
			<div class="' . $options['classInput'] . ' ' . $class_label_offset . ' controls">
				' . $text . '
			</div>
		</div><div class="hr-line-dashed"></div>';
	}

	/* ***************** SUBMIT FORM ***************** */

	static function submitOnlyButtons($save_icon, $save_label, $cancel_btn = true, $other_actions = array(), $save_button_color = 'primary') {
		$options['classLabel'] = "col-md-2";
		$options['classInput'] = "col-md-10";
		
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
			' . $other_actions_str;
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
		NForm::submitCustom('fa fa-save', 'Save', true, array());
	}

	static function submitAsAjax($redirect, $other_actions = array()) {
		NForm::submitCustom('fa fa-save', 'Save', true, $other_actions);
		?>
		<div class='row' id="progress-bar-container" style="display: none">
			<label class='<?php echo $options['classLabel'] ?> control-label'><?php echo __('In progress...') ?></label>
			<div class='col-md-10' style="padding-top: 7px">
				<div class="progress">
					<div class="progress-bar progress-bar-success"
						 style="width: 0%;">0%</div>
				</div>

				<div class="modal fade" id="formUploadModal"
					 data-redirect="<?php echo $redirect ?>">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><?php echo 'Avviso' ?></h4>
							</div>
							<div class="modal-body">
								<p>
									<span class="text-danger fa fa-exclamation-circle"></span>
									<?php echo __('Warning: the server returned the following message') ?><br>
									<?php echo __('Contact the developer for additional informations. Thank you.') ?><br>
									<?php echo __('Press continue to proceed.') ?>



								<div id="status" style="max-height: 300px; overflow: auto">
								</div>
							</div>
							<div class="modal-footer">
								<a href="<?php echo $redirect ?>"
									class="btn btn-primary"><?php echo 'Continue' ?></a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			</div>
		</div>
		<?php
	}

}
	