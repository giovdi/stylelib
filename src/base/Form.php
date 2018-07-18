<?php
namespace DeployStudio\Style;

class Form {
	private $nobox = false;
	private $class_label = "col-md-2";
	private $class_input = "col-md-5";
	/*
	function __construct($icon, $form_title, $action, $multipart = false, $id = "",
			$get = false, $validationClass = "validate-form-custom", $fullwidth = false) {

if (!is_null($icon)) {
?>
<div class='row'>
	<div class='col-sm-12'>
		<div class='box'>
			<div class='box-header blue-background'>
				<div class='title'>
					<div class='<?php echo $icon ?>'></div>
						<?php echo $form_title?>
					</div>
			</div>
			<div class='box-content'>
<?php } else
	$this->nobox = true; ?>
				<form class="form form-horizontal <?php echo $validationClass ?>"
					style="margin-bottom: 0;"
					method="<?php echo ($get ? 'get' : 'post') ?>"
					action="<?php echo $action ?>" novalidate="novalidate"
					<?php echo ($multipart ? 'enctype="multipart/form-data"' : '') ?>
					<?php echo (strlen($id) > 0 ? 'id="'.$id.'"' : '') ?>>
					<input type="hidden" name="redirect"
						value="<?php echo $_GET['r'] ?>" />
		<?php
		
		if ($fullwidth) {	
			$this->class_label = "col-md-4";
			$this->class_input = "col-md-8";
		}
	}
	
function submitBtns($save_icon, $save_label, $cancel_btn, $otheractions, $ajaxFormRedirect) {
		if (is_null($save_label))
			$save_label = __('Save');
		?>
						<div class='form-actions form-actions-padding-sm'>
						<div class='row'>
							<div class='col-md-10 col-md-offset-2'>
								<button class='btn btn-primary' type='submit'>
									<i class='<?php echo $save_icon ?>'></i> <?php echo $save_label ?>
								</button>
								<?php if ($cancel_btn) { ?>
									<a class='btn' href="javascript:window.history.back()"><?php echo __('Cancel') ?></a>
								<?php } ?>
								<?php
								if (!empty($otheractions)) {
									foreach ($otheractions as $action) {
										if (!empty($action['icon']))
											$icon = '<span class="'.$action['icon'].'"></span> ';
										else
											$icon = '';
										
										echo '<a class="btn" href="'.$action['href'].'">'.$icon.$action['label'].'</a>';
									} 
								} ?>
							</div>
						</div>
						
						<?php if (strlen($ajaxFormRedirect) > 0) { ?>
						<div class='row' id="progress-bar-container" style="display: none">
							<label class='<?php echo $this->class_label ?> control-label'><?php echo __('In corso...') ?></label>
							<div class='col-md-10' style="padding-top: 7px">
								<div class="progress">
									<div class="progress-bar progress-bar-success"
										style="width: 0%;">0%</div>
								</div>

								<div class="modal fade" id="formUploadModal"
									data-redirect="<?php echo $ajaxFormRedirect ?>">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title"><?php echo __('Avviso') ?></h4>
											</div>
											<div class="modal-body">
												<p>
													<span class="text-danger fa fa-exclamation-circle"></span>
														<?php echo __('Attenzione: il server ha restituito il seguente messaggio') ?><br>
														<?php echo __('Contattare lo sviluppatore per maggiori informazioni. Grazie.') ?><br>
														<?php echo __('Premere continua per proseguire.') ?>
												
												
												
												<div id="status" style="max-height: 300px; overflow: auto">
												</div>
											</div>
											<div class="modal-footer">
												<a href="<?php echo $ajaxFormRedirect ?>"
													class="btn btn-primary"><?php echo __('Continua') ?></a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->
							</div>
						</div>
						<?php } ?>
					</div>
<?php 
}/*
	
function footer($save_icon = 'fa fa-floppy-o', $save_label = null, $cancel_btn = true, $otheractions = array(), $ajaxFormRedirect = '') {
	$this->submitBtns($save_icon, $save_label, $cancel_btn, $otheractions, $ajaxFormRedirect);
	?>
				</form>
				<?php if (!$this->nobox) {?>
			</div>
		</div>
	</div>
</div>

<?php
		}
	}
	
	/*
	
	function attrCheck ($options, $rules) {
		$attr = array();
		
		$attr[] = 'id="'.$options['id'].'"';
		$attr[] = 'name="'.$options['name'].'"';
		
		if (isset($options['placeholder']))
			$attr[] = 'placeholder="'.$options['placeholder'].'"';
		if (isset($options['rows']))
			$attr[] = 'rows="'.$options['rows'].'"';
		if (isset($options['style']))
			$attr[] = 'style="'.$options['style'].'"';
		if (isset($options['onblur']))
			$attr[] = 'onblur="'.$options['onblur'].'"';
		if (isset($options['onchange']))
			$attr[] = 'onchange="'.$options['onchange'].'"';
		if (isset($options['onkeyup']))
			$attr[] = 'onkeyup="'.$options['onkeyup'].'"';
		if (isset($options['maxlength']))
			$attr[] = 'maxlength="'.$options['maxlength'].'"';
		if ($options['disabled'])
			$attr[] = 'disabled';
		if ($options['multiple'])
			$attr[] = 'multiple="multiple"';
		
		// regole di validazione
		if ($rules['required'])
			$attr[] = 'data-rule-required="true"';
		if ($rules['email'])
			$attr[] = 'data-rule-email="true"';
		if ($rules['number'])
			$attr[] = 'data-rule-number="true"';
		if ($rules['dateformat'])
			$attr[] = 'data-format="'.$rules['dateformat'].'"';
		if ($rules['min'])
			$attr[] = 'data-rule-min="'.$rules['min'].'"';
		if ($rules['max'])
			$attr[] = 'data-rule-max="'.$rules['max'].'"';
		
		return $attr;
	}*/
	
	
	
	/**
	 * Inserisce un campo di testo di tipo input con un datepicker associato
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * 		<li>prepend: testo fisso prima del campo</li>
	 * 		<li>append: testo fisso dopo il campo</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * 		<li>email: true se il campo è di tipo email</li>
	 * 		<li>number: true se il campo è numerico</li>
	 * </ul>
	 *
	function datepicker($options, $dateformat = 'dd/MM/yyyy', $rules = array()) {
		$options['additionalDivClasses'] = array('datepicker');
		$options['append'] = '<span data-date-icon="fa fa-calendar" data-time-icon="fa fa-clock-o"></span>';
		$rules['dateformat'] = $dateformat;
		
		$this->input($options, $rules);
	}
	
	/**
	 * Inserisce un campo di testo di tipo input con un datetimepicker associato
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * 		<li>prepend: testo fisso prima del campo</li>
	 * 		<li>append: testo fisso dopo il campo</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * 		<li>email: true se il campo è di tipo email</li>
	 * 		<li>number: true se il campo è numerico</li>
	 * </ul>
	 *
	function datetimepicker($options, $dateformat = 'dd/MM/yyyy HH:mm:ss PP', $rules = array()) {
		$options['additionalDivClasses'] = array('datetimepicker');
		$options['append'] = '<span data-date-icon="fa fa-calendar" data-time-icon="fa fa-clock-o"></span>';
		$rules['dateformat'] = $dateformat;
		
		$this->input($options, $rules);
	}
	
	/**
	 * Inserisce un campo di testo di tipo input
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * 		<li>prepend: testo fisso prima del campo</li>
	 * 		<li>append: testo fisso dopo il campo</li>
	 * 		<li>disabled: campo disabilitato</li>
	 * 		<li>additionalDivClasses: array di classi aggiuntive assegnate al div contenitore</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * 		<li>email: true se il campo è di tipo email</li>
	 * 		<li>number: true se il campo è numerico</li>
	 * </ul>
	 *
	function input($options, $rules = array()) {

		if (!isset($options['id']))
			$options['id'] = idGen($options['label']);
		if (!isset($options['name']))
			$options['name'] = idGen($options['label']);
		
		$additionalDivClasses = array();
		if (isset($options['prepend']) || isset($options['append']))
			$additionalDivClasses[] = 'input-group';
		if (is_array($options['additionalDivClasses']))
			$additionalDivClasses = array_merge($additionalDivClasses, $options['additionalDivClasses']);

		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> '
					
		?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$options['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<?php if (count($additionalDivClasses) > 0)
			echo '<div class="'.implode(' ', $additionalDivClasses).'">' ?>
		<?php if (isset($options['prepend']))
			echo '<span class="input-group-addon">'.$options['prepend'].'</span>' ?>
			
		<input class='form-control'
			<?php echo implode(' ', $this->attrCheck($options, $rules)) ?>
			type='text'>
			
		<?php if (isset($options['append']))
			echo '<span class="input-group-addon">'.$options['append'].'</span>' ?>
		<?php if (strlen($options['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>'; ?>
		<?php if (count($additionalDivClasses) > 0)
			echo '</div>' ?>
	</div>
</div>
<?php
		if (strlen($options['value']) > 0) {
			echo '<script type="text/javascript">$("#'.$options['id'].'").val(\''.js_replace($options['value']).'\');</script>';
		}
	}
	
	/**
	 * 
	 * value for selected checkboxes: on
	 * @param unknown $options
	 * @param array $checkboxes
	 * @param array $rules
	 */
	function checkbox($options, $checkboxes = array(), $rules = array()) {

		if (!isset($options['id']))
			$options['id'] = idGen($options['label']);
		if (!isset($options['name']))
			$options['name'] = idGen($options['label']);

		if (count($checkboxes) == 0)
			$checkboxes = array(array('name' => null, 'label' => '', 'checked' => false)); ?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$options['label'] ?></label>
	<div class='<?php echo $this->class_input ?>'>
		<?php
		foreach ($checkboxes as $checkbox) {
			if ($options['checked'] || $checkbox['checked'])
				$checked = 'checked';
			else
				$checked = '';
			?>
			<div class="checkbox">

			<input type='checkbox'
				name="<?php echo $options['name'].(!is_null($checkbox['name']) ? '['.$checkbox['name'].']' : '') ?>"
				<?php echo $checked ?>>
				<?php echo $checkbox['label']; ?>
				
			</div>
		<?php } ?>
		<?php if (strlen($options['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>'; ?>
	</div>
</div>
<?php
	}
	
	/**
	 * Inserisce un campo nascosto
	 * @param String $name nome del campo nascosco
	 * @param misc $value valore del campo
	 *
	function hidden($name, $value, $id = null) {
	?>
<input name="<?php echo $name?>" id="<?php echo is_null($id) ? $name : $id ?>" type='hidden'>
<script type="text/javascript">$("#<?php echo $name ?>").val('<?php echo js_replace($value) ?>');</script>
<?php
	}
	
	
	/**
	 * Inserisce un campo di tipo password
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>disabled: campo disabilitato</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * 		<li>email: true se il campo è di tipo email</li>
	 * 		<li>number: true se il campo è numerico</li>
	 * </ul>
	 *
	function password($options, $rules = array()) {

		if (!isset($options['id']))
			$options['id'] = idGen($options['label']);
		if (!isset($options['name']))
			$options['name'] = idGen($options['label']);
		
		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> '
			
			?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$options['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<input class='form-control'
			<?php echo implode(' ', $this->attrCheck($options, $rules)) ?>
			type='password'>
		<?php if (strlen($options['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>'; ?>
	</div>
</div>
<?php
	}

	
	
	/**
	 * Inserisce un campo di tipo file
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>disabled: campo disabilitato</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function file($options, $rules = array()) {

		if (!isset($options['id']))
			$options['id'] = idGen($options['label']);
		if (!isset($options['name']))
			$options['name'] = idGen($options['label']);

		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> ';
					
		if (isset($options['multiple']))
			$options['name'] .= '[]';
		?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$options['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<input class='form-control'
			<?php echo implode(' ', $this->attrCheck($options, $rules)) ?>
			type='file'>
		<?php if (strlen($options['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>'; ?>
	</div>
</div>
<?php
	}

	
	
	/**
	 * Inserisce un campo di testo di tipo input
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * 		<li>rows: righe del campo di testo</li>
	 * 		<li>additionalAreaClasses: array di classi aggiuntive assegnate alla textarea (es. autosize)</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function textarea($options, $rules = array()) {

		if (!isset($options['id']))
			$options['id'] = idGen($options['label']);
		if (!isset($options['name']))
			$options['name'] = idGen($options['label']);
		
		$additionalAreaClasses = array();
		if (is_array($options['additionalAreaClasses']))
			$additionalAreaClasses = $options['additionalAreaClasses'];
		
		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> '
?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$options['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<textarea
			class='form-control <?php echo implode(' ', $additionalAreaClasses) ?>'
			<?php echo implode(' ', $this->attrCheck($options, $rules)) ?>
			type='text'></textarea>
		<?php if (strlen($options['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$options['description'].'</small>'; ?>
	</div>
</div>
<?php
		if (strlen($options['value']) > 0) {
			echo '<script type="text/javascript">$("#'.$options['id'].'").val(\''.js_replace($options['value']).'\');</script>';
		}
	}
	
	



	/**
	 * Inserisce un campo wysiwyg
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * 		<li>rows: righe del campo di testo</li>
	 * 		<li>additionalAreaClasses: array di classi aggiuntive assegnate alla textarea (es. autosize)</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function wysiwyg($options, $rules = array()) {
		$options['additionalAreaClasses'][] = ' wysihtml5';
		$this->textarea($options, $rules);
	}
	
	
	
	/**
	 * Inserisce un campo di selezione (con select2) prendendo i valori da una query di selezione
	 * @param array $result risultato di una query di selezione
	 * @param string $colvalue colonna contenente il valore delle opzioni del campo
	 * @param string $collabel colonna contenente l'etichetta delle opzioni del campo
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function selectDbResult($result, $colvalue, $collabel, $htmlOptions, $select2Options= array(), $rules = array()){
		$values = array();
		if (count($result) > 0) {
			foreach ($result as $row) {
				if (is_array($collabel)) {
					$val = '';
					foreach ($collabel as $label) {
						if (isset($row[$label]))
							$val .= $row[$label];
						else
							$val .= $label;
					}
					$values[$row[$colvalue]] = $val;
				} else
					$values[$row[$colvalue]] = $row[$collabel];
			};
		}
		
		if ($select2Options['allowCustom'])
			$this->selectTag($values, $htmlOptions, $select2Options, $rules);
		else
			$this->select($values, $htmlOptions, $select2Options, $rules);
	}
	
	
	/**
	 * Inserisce un campo di selezione (con select2)
	 * @param array $values valori del campo
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function selectTag($values, $htmlOptions, $select2Options = array(), $rules = array()) {

		if (!isset($htmlOptions['id']))
			$htmlOptions['id'] = idGen($htmlOptions['label']);
		if (!isset($htmlOptions['name']))
			$htmlOptions['name'] = idGen($htmlOptions['label']);
		if (!isset($htmlOptions['globalData']))
			$htmlOptions['globalData'] = false;
		if (!isset($htmlOptions['dataAsTag']))
			$htmlOptions['dataAsTag'] = false;
		
		if (!isset($select2Options['allowCustom']))
			$select2Options['allowCustom'] = false;
		if (!isset($select2Options['placeholder']) && ($select2Options['allowCustom'] || $htmlOptions['dataAsTag']))
			$select2Options['placeholder'] = __("Seleziona o scrivi e premi INVIO per personalizzare");
		elseif (!isset($select2Options['placeholder']))
			$select2Options['placeholder'] = __("Seleziona");
			
		// load data
		$dataArr = array();
		foreach ($values as $value => $label) {
			$dataArr[] = array(
				'id' => ($select2Options['labelAsValue'] ? $label : $value),
				'text' => $label
			);
		}
		// load default value
		if (isset($htmlOptions['value'])) {
			if (!is_array($htmlOptions['value']))
				$htmlOptions['value'] = array($htmlOptions['value']);
		
			foreach ($htmlOptions['value'] as $defvalue) {
				if (strlen($defvalue) > 0 && !in_array($defvalue, $values) && !key_exists($defvalue, $values)) {
					$dataArr[] = array(
							'id' => $defvalue,
							'text' => ($select2Options['labelAsValue'] || !isset($values[$defvalue]) ? $defvalue : $values[$defvalue]),
					);
				}
			}
		}
		
	 	if (!$htmlOptions['dataAsTag'])
			$select2Options['data'] = $dataArr; // select standard non personalizzabile
	 		// se definito allowCustom = true: select standard personalizzabile
	 		// se definito multiple = true: tag non personalizzabili
		else
			$select2Options['tags'] = $dataArr; // tag personalizzabili (allowCustom = false, multiple = non definito)
		

		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> ';
?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$htmlOptions['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<input class="form-control"
			<?php echo implode(' ', $this->attrCheck($htmlOptions, $rules)) ?>>
		<script type="text/javascript">
			$(function() {
				$("#<?php echo $htmlOptions['id']; ?>").select2({
				    <?php
				    $select2OptionsArr = array();
				    foreach ($select2Options as $optionKey => $optionValue) {
						if (is_string($optionValue))
							$optionValueFilter = "'".js_replace($optionValue)."'";
						elseif (is_bool($optionValue) && $optionValue)
							$optionValueFilter = 'true';
						elseif (is_bool($optionValue) && !$optionValue)
							$optionValueFilter = 'false';
						else
							$optionValueFilter = $optionValue;
						
						switch($optionKey) {
							case 'data':
							case 'tags':
								$select2OptionsArr[] = $optionKey.': '.json_encode($dataArr);
								break;
					    		
							case 'allowCustom':
								if ($optionValue) {
									$select2OptionsArr[] = 'createSearchChoice: function(term) {
						    	        return {
						    	            id: term,
						    	            text: term
						    	        };
						    	    }';
								}
					    		break; //do nothing
					    		
							case 'labelAsValue':
					    		break; //do nothing
					    		
							default:
					    		$select2OptionsArr[] = $optionKey.': '.$optionValueFilter;
					    }
				    }
				    echo implode(', ', $select2OptionsArr); ?>
				});
				<?php 
				if (is_array($htmlOptions['value'])) {
					if (!$htmlOptions['dataAsTag'])
						echo '$("#'.$htmlOptions['id'].'").select2(\'val\', \''.js_replace($htmlOptions['value'][0]).'\');'."\r\n";
					else
						echo '$("#'.$htmlOptions['id'].'").select2(\'val\', '.json_encode($htmlOptions['value']).');'."\r\n";
				}
			?>
			});
			<?php
			if ($htmlOptions['globalData']) {
				echo 'var selectOptions_'.$htmlOptions['id'].' = '.json_encode($dataArr);
			}
			?>
		</script>
		<?php if (strlen($htmlOptions['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$htmlOptions['description'].'</small>'; ?>
	</div>
</div>
<?php
	}
	
	
	
	/**
	 * Inserisce un campo di selezione (con select2) prendendo i valori da una query di selezione
	 * @param array $result risultato di una query di selezione
	 * @param string $colvalue colonna contenente il valore delle opzioni del campo
	 * @param string $collabel colonna contenente l'etichetta delle opzioni del campo
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function selectTagDbResult($result, $colvalue, $collabel, $htmlOptions, $select2Options= array(), $rules = array()){
		$values = array();
		foreach ($result as $row) {
			if (is_array($collabel)) {
				$val = '';
				foreach ($collabel as $label) {
					if (isset($row[$label]))
						$val .= $row[$label];
					else
						$val .= $label;
				}
				$values[$row[$colvalue]] = $val;
			} else
				$values[$row[$colvalue]] = $row[$collabel];
		};
		
		$this->selectTag($values, $htmlOptions, $select2Options, $rules);
	}
	
	
	/**
	 * Inserisce un campo di selezione (con select2)
	 * @param array $values valori del campo
	 * @param array $options
	 * parametri:<br><ul>
	 * 		<li>*label: etichetta del campo</li>
	 * 		<li>id: id campo personalizzato</li>
	 * 		<li>name: nome campo POST personalizzato</li>
	 * 		<li>value: valore preimpostato</li>
	 * 		<li>placeholder: testo visualizzato a campo vuoto</li>
	 * </ul>
	 * @param array $rules
	 * regole di validazione del campo:<br><ul>
	 * 		<li>required: true se il campo è richiesto</li>
	 * </ul>
	 *
	function select($values, $htmlOptions, $select2Options = array(), $rules = array()) {

		if (!isset($htmlOptions['id']))
			$htmlOptions['id'] = idGen($htmlOptions['label']);
		if (!isset($htmlOptions['name']))
			$htmlOptions['name'] = idGen($htmlOptions['label']);
		
		if (!isset($select2Options['placeholder']))
			$select2Options['placeholder'] = "Seleziona";
		if (!isset($select2Options['labelAsValue']))
			$select2Options['labelAsValue'] = false;
		/*if (!isset($select2Options['allowCustom']))
			$select2Options['allowCustom'] = false; deprecated, use selectTag*/
		/*if (!$htmlOptions['multiple'])
			$select2Options['allowClear'] = true;*

		if ($rules['required'])
			$requiredLabel = '<font color="red">*</font> '
?>
<div class='form-group'>
	<label class='<?php echo $this->class_label ?> control-label'><?php echo $requiredLabel.$htmlOptions['label'] ?></label>
	<div class='<?php echo $this->class_input ?> controls'>
		<select class="form-control"
			<?php echo implode(' ', $this->attrCheck($htmlOptions, $rules)) ?>>
			<option></option>
			<?php foreach ($values as $value => $label)
				echo '<option value="'.($select2Options['labelAsValue'] ? $label : $value).'">'.$label.'</option>'; ?>
		</select>
		<?php if (strlen($htmlOptions['description']) > 0)
			echo '<p class="help-block"><small class="text-muted">'.$htmlOptions['description'].'</small>'; ?>
		<script type="text/javascript">
			$(function() {
				$("#<?php echo $htmlOptions['id']; ?>").select2({
				    <?php
				    $select2OptionsArr = array();
				    foreach ($select2Options as $optionKey => $optionValue) {
						if (is_string($optionValue))
							$optionValueFilter = "'".js_replace($optionValue)."'";
						elseif (is_bool($optionValue) && $optionValue)
							$optionValueFilter = 'true';
						elseif (is_bool($optionValue) && !$optionValue)
							$optionValueFilter = 'false';
						else
							$optionValueFilter = $optionValue;
						
						switch($optionKey) {
							case 'labelAsValue':
					    		break; //do nothing
					    		
							default:
					    		$select2OptionsArr[] = $optionKey.': '.$optionValueFilter;
					    }
				    }
				    echo implode(', ', $select2OptionsArr); ?>
				});
				<?php 
				if (strlen($htmlOptions['value']) > 0) {
					echo '$("#'.$htmlOptions['id'].'").select2(\'val\', \''.js_replace($htmlOptions['value']).'\');';
				}
				?>
			});
		</script>
	</div>
</div>
<?php
	}
	
	function plainHtml($text) {
		?>
<div class='form-group'>
	<div class='<?php echo $this->class_input.' '.str_replace('md-', 'md-offset-', $this->class_label) ?> controls'>
		<?php echo $text ?>
	</div>
</div>
<?php 
	}
	*/
}