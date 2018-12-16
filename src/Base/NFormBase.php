<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\Base\StyleLib;
use \DeployStudio\Style\StyleBaseClass;

class NFormBase {
	const FORM_TYPE_HORIZONTAL = 1;
	const FORM_TYPE_VERTICAL = 2;
	const FORM_TYPE_INLINE = 3;

	protected static $forms;
	protected static $openForm;

	protected static function openForm($action, $multipart, $id, $get, $validationClass, $form_type, $bootstrap_version) {
		StyleBaseClass::checkOption($id, 'form'.rand(1000,9999));
		$formOptions = array(
			'id' => $id,
			'fields' => array()
		);

		self::$openForm = $id;
		self::$forms[$id] = &$formOptions;
		
		switch ($form_type) {
			case NFormBase::FORM_TYPE_VERTICAL:
				$horizontalClass = '';
				$formOptions['classLabel'] = "";
				$formOptions['classInput'] = "";
				break;

			case NFormBase::FORM_TYPE_INLINE:
				$horizontalClass = 'form-inline ';
				$formOptions['classLabel'] = "";
				$formOptions['classInput'] = "";
				break;

			case NFormBase::FORM_TYPE_HORIZONTAL:
			default:
				$horizontalClass = 'form-horizontal ';
				$formOptions['classLabel'] = "col-md-2";
				$formOptions['classInput'] = "col-md-10";
				break;
		}

		if ($bootstrap_version == 3) {
			$formOptions['formConst'] = array(
				'form-group' => 'form-group'
			);
		} else {
			$formOptions['formConst'] = array(
				'form-group' => 'form-group row'
			);
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
		if (isset($options['digits']) && $options['digits'])
			$attr[] = 'data-rule-digits="true"';
		if (isset($options['integer']) && $options['integer'])
			$attr[] = 'data-rule-pattern="(-?)([0-9]+)"';
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

	static function inputBase($label, $name, $required, &$options, &$outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'input'.rand(100000,999999));
		$options['name'] = $name;
		
		// aggiungi ai fields del form
		$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'input');
		$outputArr = array(
			'requiredLabel' => '',
			'additionalDivClasses' => array(),
			'additionalFldClasses' => array()
		);

		// rules
		if ($required) {
			$outputArr['requiredLabel'] = '<font color="red">*</font> ';
		}

		// additional classes
		if (isset($options['prepend']) || isset($options['append']) || isset($options['prependBtn']) || isset($options['appendBtn'])) {
			$outputArr['additionalDivClasses'][] = 'input-group';
		}
		if (isset($options['additionalDivClasses']) && is_array($options['additionalDivClasses'])) {
			$outputArr['additionalDivClasses'] = array_merge($outputArr['additionalDivClasses'], $options['additionalDivClasses']);
		}

		// additional field options
		if (!isset($options['type'])) {
			$options['type'] = 'text';
		}
		if (!isset($options['description'])) {
			$options['description'] = '';
		}

		// VALUE
		if (isset($options['value']) && strlen($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			echo '$("#'.$options['id'].'").val(\'' . StyleBaseClass::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variante: email ***** */
	static function emailBase(&$options) {
		$options['email'] = true;
		$options['type'] = 'email';
	}

	/* ***** variante: password ***** */
	static function passwordBase(&$options) {
		$options['type'] = 'password';
	}

	/* ***** variante: file ***** */
	static function fileBase(&$options) {
		$options['type'] = 'file';
	}

	/* ***** variante: datepicker ***** */
	static function datepickerBase($name, &$options) {
		// definisci qui un id per poterlo replicare nell'hidden
		StyleBaseClass::checkOption($options['id'], 'input'.rand(100000,999999));
		StyleBaseClass::checkOption($options['additionalDivClasses'], array());
		
		// opzioni campo input
		$options = $options;
		if (isset($options['value'])) {
			$options['value'] = date('d/m/Y', strtotime($options['value']));
		}

		$options['additionalDivClasses'] = array_merge($options['additionalDivClasses'], array('date'));
		$options['prepend'] = '<span class="fa fa-calendar"></span>';
		$options['dateITA'] = true;
		
		// campo hidden
		$hiddenValue = empty($options['value']) ? '' : $options['value'];
		$hiddenid = $options['id'].'_hidden';
		NFormBase::hidden($name, $hiddenValue, $hiddenid);
	}

	/* ***** variante: datetimepicker ***** */
	static function datetimepickerBase($name, &$options) {
		// definisci qui un id per poterlo replicare nell'hidden
		StyleBaseClass::checkOption($options['id'], 'input'.rand(100000,999999));
		StyleBaseClass::checkOption($options['additionalDivClasses'], array());
		
		// opzioni campo input
		$options = $options;
		if (isset($options['value'])) {
			$options['value'] = date('d/m/Y', strtotime($options['value']));
		}

		$options['dateformat'] = 'dd/MM/yyyy HH:mm:ss PP';
		$options['additionalDivClasses'] = array_merge($options['additionalDivClasses'], array('datetimepicker'));
		$options['prepend'] = '<span data-date-icon="fa fa-calendar" data-time-icon="fa fa-time"></span>';
		
		// campo hidden
		$hiddenValue = empty($options['value']) ? '' : $options['value'];
		$hiddenid = $options['id'].'_hidden';
		NFormBase::hidden($name, $hiddenValue, $hiddenid);
	}
	
	/* ***** variante: clockpicker ***** */
	static function clockpickerBase(&$options) {
		if (isset($options['additionalDivClasses'])) {
			$options['additionalDivClasses'] = array_merge($options['additionalDivClasses'], array('clockpicker'));
		} else {
			$options['additionalDivClasses'] = array('clockpicker');
		}
		
		$options['prepend'] = '<span class="fa fa-clock"></span>';
		$options['time'] = true;
	}
	
	/* ***** variante: touchspin ***** */
	static function touchspinBase(&$options) {
		if (isset($options['additionalDivClasses'])) {
			$options['additionalDivClasses'] = array_merge($options['additionalDivClasses'], array('touchspin'));
		} else {
			$options['additionalDivClasses'] = array('touchspin');
		}
		$options['numeric'] = true;
	}

	/* ***************** TEXTAREA ***************** */

	protected static function textareaBase($label, $name, $required, &$options, &$outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'textarea'.rand(100000,999999));
		$options['name'] = $name;
		
		// aggiungi ai fields del form
		$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'textarea');
		$outputArr = array(
			'requiredLabel' => '',
			'additionalDivClasses' => array(),
			'additionalFldClasses' => array()
		);

		// rules
		if ($required) {
			$outputArr['requiredLabel'] = '<font color="red">*</font> ';
		}

		// additional classes
		if (isset($options['autosize']) && $options['autosize']){
			$outputArr['additionalFldClasses'][] = 'autosize';
		}
		if (isset($options['additionalFldClasses']) && is_array($options['additionalFldClasses'])) {
			$outputArr['additionalFldClasses'] = array_merge($outputArr['additionalFldClasses'], $options['additionalFldClasses']);
		}
		
		// VALUE
		if (isset($options['value']) && strlen($options['value']) > 0) {
			echo '<script type="text/javascript">' . "\n";
			echo '$(function() {' . "\n";
			echo '$("#'.$options['id'].'").val(\'' . StyleBaseClass::jsReplace($options['value']) . '\');' . "\n";
			echo '});</script>';
		}
	}

	/* ***** variante: wysiwyg ***** */
	static function wysiwygBase(&$options) {
		$options['additionalFldClasses'][] = 'wysiwyg';
	}

	/* ***************** INPUT CHECKBOXES ***************** */

	static function checkboxesBase($label, $mainName, $checkboxes, &$checkboxTags, &$options, &$outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'checkbox'.rand(100000,999999));

		$outputArr = array(
			'requiredLabel' => '',
			'additionalDivClasses' => array(),
			'additionalFldClasses' => array()
		);

		// rules
		if (is_array($checkboxes[0]) && isset($checkboxes[0]['name']) && is_null($checkboxes[0]['name'])
		&& isset($checkboxes[0]['required']) && $checkboxes[0]['required']) {
			$outputArr['requiredLabel'] = '<font color="red">*</font> ';
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
			$chkid = $options['id'] . StyleLib::idGen((!is_null($c['id']) ? '_' . $c['id'] : ''));

			// aggiungi ai fields del form
			$formOptions['fields'][] = array('name' => $chkname, 'id' => $chkid, 'type' => 'checkbox', 'value' => !empty($c['value']) ? $c['value'] : null);

			$checkboxTags[] = '<div class="checkbox checkbox-success">
				<input type="checkbox" name="' . $chkname . '" id="' . $chkid . '" 
					' . (!empty($c['value']) ? 'value="'.$c['value'].'"' : '') . ' 
					' . ($c['required'] ? 'data-rule-required="true"' : '') . ' 
					' . ($c['disabled'] ? 'disabled' : '') . '
					>
					&nbsp;<label>' . $c['label'].'</label>'
									. (strlen($c['label']) > 0 && $c['required'] ? ' <font color="red">*</font>' : '') . '
				</div>';
		}
		
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

	/* ***************** SELECT ***************** */

	static function selectBase($label, $name, $values, $required, &$options, &$outputArr) {
		$formOptions = &self::$forms[self::$openForm];
		
		// INITIALIZE
		// base options
		StyleBaseClass::checkOption($options['id'], 'select'.rand(100000,999999));
		$options['name'] = $name;
		if (isset($options['multiple']) && $options['multiple']) {
			$options['name'] .= '[]';
		}

		// aggiungi ai fields del form
		$formOptions['fields'][] = array('name' => $options['name'], 'id' => $options['id'], 'type' => 'select', 'values' => $values);
		$outputArr = array(
			'requiredLabel' => '',
			'additionalDivClasses' => array(),
			'additionalFldClasses' => array()
		);

		// rules
		if ($required) {
			$outputArr['requiredLabel'] = '<font color="red">*</font> ';
		}

		// SELECT2 INIT
		$select2Options = array(
			'tokenSeparators' => array(',')
		);

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
		$select2Options['data'] = $data;

		// placeholder
		if (isset($options['placeholder'])) {
			$select2Options['placeholder'] = $options['placeholder'];
		} elseif (isset($options['custom']) && $options['custom']) {
			$select2Options['placeholder'] = 'Seleziona oppure scrivi e premi INVIO per personalizzare';
		} else {
			$select2Options['placeholder'] = 'Seleziona';
		}

		// altre opzioni select2
		StyleBaseClass::checkOption($options['custom'], false);
		$select2Options['tags'] = $options['custom'];

		StyleBaseClass::checkOption($options['clear'], false);
		$select2Options['allowClear'] = $options['clear'];

		StyleBaseClass::checkOption($options['minLength'], 0);
		$select2Options['minimumInputLength'] = $options['minLength'];

		if (isset($options['theme'])) {
			$select2Options['theme'] = $options['theme'];
		}

		// output
		$output = '
			<script type="text/javascript">
				$(function() {
					select2' . preg_replace("/[^A-Za-z0-9]/", "", $options['id']) . ' = $("#' . $options['id'] . '").select2('.
					json_encode($select2Options).');
				});
				' . (isset($options['globalData']) && $options['globalData'] ? 'var selectOptions_' . $options['id'] . ' = ' . json_encode($data) : '') . '
			</script>' . "\n\n";

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

	static function selectRSBase($rs, $columns_labels, $columns_values, &$values) {
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
	}

	/* ***************** HIDDEN ***************** */

	static function hidden($name, $value, $id = null) {
		StyleBaseClass::checkOption($id, 'hidden'.rand(100000,999999));

		echo '<input name="' . $name . '" id="' . $id . '" type="hidden">
			<script type="text/javascript">$("#' . $id . '").val(\'' . StyleBaseClass::jsReplace($value) . '\');</script>';
	}

	/* ***************** FILL FORM ***************** */

	/**
	* Function to fill-in automatically a form based with array's values
	* @param array $set dataset used to fill the form
	*/
	static function fillForm($set, $debug = false) {
		$istruzioni = array();

		foreach (self::$forms[self::$openForm]['fields'] as $form_field) {
			$form_field['name'] = str_replace('[]', '', $form_field['name']);

			// controlla se il campo deve essere riempito
			$field_name = $form_field['name'];
			$fill_value = null;
			if (isset($set[$field_name])) {
				$fill_value = $set[$field_name];
			}

			// controlla datepicker
			elseif (substr($form_field['name'], -3) == '_in') {
				$field_name = substr($form_field['name'], 0, -3);
				if (isset($set[$field_name])) {
					$fill_value = date('d/m/Y', strtotime($set[$field_name]));
				}
			}

			// fill form
			if (is_array($fill_value)) {
				switch ($form_field['type']) {
					case 'select':
						foreach ($fill_value as $val) {
							if (!array_key_exists($val, $form_field['values'])) {
								$istruzioni[] = 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $form_field['id']) . '.append("<option value=\"' . StyleBaseClass::jsReplace($val) . '\">' . StyleBaseClass::jsReplace($val) . '</option>");' . "\n";
							}
						}
						if (count($fill_value) > 0) {
							$istruzioni[] = 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $form_field['id']) . '.val(["' . StyleBaseClass::jsReplace(implode('","', $fill_value)) . '"]).trigger("change");' . "\n";
						}
						break;
						
					case 'checkbox':
						if (strlen($form_field['value']) > 0 && in_array($form_field['value'], $fill_value)) {
							$istruzioni[] = '$("#' . $form_field['id'] . '[value=\\"'.$form_field['value'].'\\"]").prop("checked", true);' . "\n";
						}
						break;

					default:
						; //do nothing
				}
			}
			elseif (strlen($fill_value) > 0) {
				switch ($form_field['type']) {
					case 'hidden':
					case 'input':
					case 'textarea':
						$istruzioni[] = '$("#' . $form_field['id'] . '").val(\'' . StyleBaseClass::jsReplace($fill_value) . '\');' . "\n";
						break;

					case 'select':
						if (!array_key_exists($fill_value, $form_field['values'])) {
							$istruzioni[] = 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $form_field['id']) . '.append("<option value=\"' . StyleBaseClass::jsReplace($fill_value) . '\">' . StyleBaseClass::jsReplace($fill_value) . '</option>");' . "\n";
						}
						$istruzioni[] = 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $form_field['id']) . '.val(\'' . StyleBaseClass::jsReplace($fill_value) . '\').trigger("change");' . "\n";
						break;

					case 'checkbox':
						if (strlen($form_field['value']) > 0 && $form_field['value'] == $fill_value) {
							$istruzioni[] = '$("#' . $form_field['id'] . '[value=\\"'.$form_field['value'].'\\"]").prop("checked", true);' . "\n";
						} elseif (is_null($form_field['value']) && $fill_value !== 0) {
							$istruzioni[] = '$("#' . $form_field['id'] . '").prop("checked", true);' . "\n";
						}
						break;

					default:
						; //do nothing
				}
			}
		}

		echo '<script type="text/javascript">
		$(function() {' . "\n";
		echo implode("\n", $istruzioni);
		echo '});
		</script>';

		if ($debug) {
			echo '<pre>';
			echo '### FORM ###'."\n";
			print_r(self::$forms[self::$openForm]['fields']);
			echo "\n".'### DATASET ###'."\n";
			print_r($set);
			echo "\n".'## RISULTATO ###'."\n";
			echo implode("\n", $istruzioni);
			echo '</pre>';
		}
	}

	/* ***************** SUBMIT FORM ***************** */

	static function submitOnlyButtons($save_icon, $save_label, $cancel_btn = true, $other_actions = array(), $save_button_color = 'primary') {
		$formOptions = &self::$forms[self::$openForm];
		
		$other_actions_str = '';
		if (!empty($other_actions)) {
			foreach ($other_actions as $action) {
				if (isset($action['modaldismiss']) && $action['modaldismiss']) {
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
			' . ($cancel_btn ? '<a class="btn btn-white" href="javascript:window.history.back()">' . 'Annulla' . '</a>' : '') . '
			' . $other_actions_str.'
			<script>$(function() {$(\'#'.self::$openForm.' button[type=submit]\').removeClass(\'disabled\')})</script>';
	}

	static function submitCustom($save_icon, $save_label, $cancel_btn = true, $other_actions = array(), $save_button_color = 'primary') {
		echo '
			<div class="form-actions formactions-padding-sm">
				<div class="row">
					<div class="col-md-10 col-md-offset-2">
						';
						NFormBase::submitOnlyButtons($save_icon, $save_label, $cancel_btn, $other_actions, $save_button_color);
						echo '
					</div>
				</div>
			</div>';
	}

	static function submit() {
		NFormBase::submitCustom('fa fa-save', 'Salva', true, array());
	}

	static function submitAsAjax($redirect, $other_actions = array()) {
		NFormBase::submitCustom('fa fa-save', 'Salva', true, $other_actions);
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
