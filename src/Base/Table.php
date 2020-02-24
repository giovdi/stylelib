<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\StyleBaseClass;

class Table {
	protected static $tables;
	protected static $openTable;
	public static $MAX = -1;

	protected static function azioniIntestazione ($azioni) {
		foreach ($azioni as $azione) {
			if (!empty($azione['right'])) {
				continue;
			}
			
			StyleBaseClass::checkOption($azione['class'], 'primary');
			StyleBaseClass::checkOption($azione['label'], '');
			
			$modalStr = '';
			if (!empty($azione['modal'])) {
				$azione['href'] = '#';
				$modalStr = ' data-toggle="modal" data-target="#'.$azione['modal'].'"';
			}
			
			$target = '';
			if (!empty($azione['target'])) {
				$target = ' target="'.$azione['target'].'"';
			}
			
			$tooltip = '';
			if (!empty($azione['tooltip'])) {
				$tooltip = ' data-toggle="tooltip" title="'.$azione['tooltip'].'"';
			}
			
			echo ' <a class="btn btn-xs btn-'.$azione['class'].' ibox-title-azione" href="'.$azione['href'].'"'.$tooltip.$target.$modalStr.'>';
			echo '<i class="'.$azione['icon'].'"></i> '.$azione['label'];
			echo '</a>';
		}
		foreach ($azioni as $azione) {
			if (!empty($azione['right'])) {
				echo '<div class="pull-right" style="font-size:14px">'.$azione['right'].'</div>';
			}
		}
	}

	static function getPages($itemsTotal, $itemsPage = null) {
		if (isset($_GET['pp']) && is_numeric($_GET['pp'])) {
			$itemsPage = $_GET['pp'];
		} elseif (is_null($itemsPage)) {
			$itemsPage = 50;
		}

		$pages_offset = 1;

		// split in pages
		$pages_total = ceil($itemsTotal / $itemsPage);
		if (!isset($_GET['p']) || !is_numeric($_GET['p']) || $_GET['p'] < 1) {
			$pages_thispage = 1;
		} else if ($_GET['p'] > $pages_total) {
			$pages_thispage = $pages_total;
		} else {
			$pages_thispage = $_GET['p'];
		}

		// start
		if ($pages_thispage - $pages_offset < 2) {
			$pages_i = 1;
		} else {
			$pages_i = $pages_thispage - $pages_offset;
		}

		// end
		if ($pages_thispage + $pages_offset > $pages_total - 1) {
			$pages_f = $pages_total;
		} else {
			$pages_f = $pages_thispage + $pages_offset;
		}

		// show 'go to first' and 'go to last'
		$gotofirst = ($pages_thispage - $pages_offset > 1 && $pages_total > $pages_offset * 2);
		$gotolast = ($pages_thispage + $pages_offset < $pages_total && $pages_total > $pages_offset * 2);

		return [
			'limit' => $itemsPage,
			'offset' => $itemsPage * $pages_thispage - $itemsPage,
			'paginator_first' => $pages_i,
			'paginator_last' => $pages_f,
			'active_page' => $pages_thispage,
			'num_pages' => $pages_total,
			'gotofirst' => $gotofirst,
			'gotolast' => $gotolast,
			'items_page' => $itemsPage
		];
	}

		
	static function paginazione($totalElements, $pagerSelected = null) {
		$paginator = self::getPages($totalElements, $pagerSelected);
		echo get_called_class()::getPaginator($paginator);
	}
		
	static function openTable($headers, $options) {
		StyleBaseClass::checkOption($options['id'], 'table'.rand(1000,9999));
		StyleBaseClass::checkOption($options['sort'], '');
		StyleBaseClass::checkOption($options['sort_dir'], '');
		$id = $options['id'];
		$sort = $options['sort'];
		$sort_dir = $options['sort_dir'];

		self::$openTable = $id;
		self::$tables[$id] = &$options;

		if ((isset($options['selectAllCheck']) && $options['selectAllCheck'])
		|| (isset($options['form']) && $options['form'])) {
			echo '<form class="form form-horizontal" method="post" action="?multipleAction" id="f_'.$id.'">';
		}
		echo '<table class="table '.$options['tableClass'].'" id="'.$id.'">';
		
		echo '<thead>';
		echo '<tr>';
		if (isset($options['selectAllCheck']) && $options['selectAllCheck']) {
			echo '<th>';
			echo get_called_class()::_allCheckbox();
			echo StyleBaseClass::getView('tableSelectallJs', array('id' => $id));
			echo '</th>';
		}

		// aggiunge le freccette per l'ordinamento e controlla se aggiungere o meno
		// i filtri, ovvero una riga sotto l'intestazione
		$filters = false;
		foreach ($headers as $header) {
			$headerOptions = array();
			$order_chevron = '';
			if (is_array($header)) {
				$value = $header[0];
			
				if (isset($header['colspan'])) {
					$headerOptions[] = 'colspan="'.$header['colspan'].'"';
				}
				if (isset($header['class'])) {
					$headerOptions[] = 'class="'.$header['class'].'"';
				}
				if (isset($header['filter']) && strlen($header['filter']) > 0) {
					$filters = true;
				}
				if (isset($header['datefilter']) && strlen($header['datefilter']) > 0) {
					$filters = true;
				}
				if (isset($header['sort'])) {
					$qstring = array('sort='.$header['sort']);
					if ($header['sort'] == $sort && $sort_dir == 'asc') {
						$qstring[] = 'dir=desc';
					} elseif ($header['sort'] == $sort && $sort_dir == 'desc') {
						$qstring[] = 'dir=asc';
					}
					$headerOptions[] = 'onclick="document.location=\''.StyleLib::strip_query_param(array('sort', 'dir'), $qstring).'\'"';
					
					if ($header['sort'] == $sort && $sort_dir == 'desc')
						$order_chevron = '<div class="float-right pull-right"><span class="fa fa-sort-down fa-sort-desc text-muted"></span></div>';
					elseif ($header['sort'] == $sort && $sort_dir == 'asc')
						$order_chevron = '<div class="float-right pull-right"><span class="fa fa-sort-up fa-sort-asc text-muted"></span></div>';
					else
						$order_chevron = '<div class="float-right pull-right"><span class="fa fa-sort text-muted"></span></div>';
				}
			}
			
			else
				$value = $header;;
			
			echo '<th '.implode(' ', $headerOptions).'>'.$value.$order_chevron.'</th>';
		}
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		
		// aggiunge i filtri
		if ($filters) {
			echo '<tr class="table-filters">';
			
			if (isset($options['selectAllCheck']) && $options['selectAllCheck']) {
				echo '<td></td>';
			}
			foreach ($headers as $header) {
				$autofocus = (isset($header['filter_autofocus']) ? 'autofocus' : '');
				$headerOptions = array();
				if (isset($header['colspan']))
					$headerOptions[] = 'colspan="'.$header['colspan'].'"';
				if (isset($header['class'])) {
					//remove col- declarations
					$class = $header['class'];
					$class = preg_replace('/col-([a-z-]+)-([0-9]+)/', '', $class);
					$headerOptions[] = 'class="'.$class.'"';
				}
				
				
				if (isset($header['filter']) && strlen($header['filter']) > 0 && isset($header['selectfilter']) && is_array($header['selectfilter'])) {
					







						config(['app.debug' => true]);


					// INITIALIZE
					// base options
					$select_id = 'select'.rand(100000,999999);

					// SELECT2 INIT
					$select2Options = array(
						'tokenSeparators' => array(',')
					);

					// parse data
					$data = array(array());
					if (!is_array($header['selectfilter'])) {
						echo '<b>Debug</b>: selectfilter option for the ' . $header['filter'] . ' filter is not an array, please check its declaration.';
					} else {
						foreach ($header['selectfilter'] as $val => $lab) {
							$data[] = array('id' => strval($val), 'text' => $lab);
						}
						$select2Options['data'] = $data;
					}

					// theme
					$select2Options['theme'] = 'bootstrap4';

					// look for other select2 options
					$select2Options['tags'] = true;
					$select2Options['allowClear'] = true;
					$select2Options['placeholder'] = 'Select to filter';

					// output
					$select2JsonOptions = json_encode($select2Options);

					echo '<td '.implode(' ', $headerOptions).'><select type="text" class="form-control table-filter" '
						.'title="'.__('universal_stylelib::stylelib.filter_tooltip').'" data-toggle="tooltip" '
						.'data-placement="bottom" onkeypress="if(event.keyCode == 13) tableFilterSearch(event, this);" '
						.'data-sfilter="'.$header['filter'].'" '.$autofocus.' id="'.$select_id.'">';

						echo '</select></td>';
						echo '
						<script type="text/javascript">
							$(function() {
								select2' . preg_replace("/[^A-Za-z0-9]/", "", $select_id) . ' = $("#' . $select_id . '").select2('.$select2JsonOptions.');
							});
						</script>' . "\n\n";
				
					// VALUE
/* 					if (isset($options['value']) && !is_array($options['value'])) {
						$options['value'] = array($options['value']);
					}
				if (isset($options['value']) && is_array($options['value']) && count($options['value']) > 0) {
						echo '<script type="text/javascript">' . "\n";
						echo '$(function() {' . "\n";
						if (is_array($data)) {
							foreach ($options['value'] as $val) {
								$exists = false;
								foreach ($data as $d) {
									if (isset($d['id']) && $d['id'] == $val) {
										$exists = true;
									}
								}
								if (!$exists) {
									echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $select_id) . '.select2().append("<option value=\"' . StyleBaseClass::jsReplace($val) . '\">' . StyleBaseClass::jsReplace($val) . '</option>");' . "\n";
								}
							}
						}
						if (!empty($options['value'][0]) && is_array($options['value'][0])) {
							// TODO: manca supporto a prepopolamento multiplo delle select ajax
							echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $select_id) . '.val("' . StyleBaseClass::jsReplace($options['value'][0][$options['_key_values']]) . '").trigger("change");' . "\n";
						} else {
							echo 'select2' . preg_replace("/[^A-Za-z0-9]/", "", $select_id) . '.val(["' . StyleBaseClass::jsReplace(implode('","', $options['value'])) . '"]).trigger("change");' . "\n";
						}
						echo '});</script>';
					}
 */	



















					if (isset($_GET['f'.$header['filter']]) && strlen($_GET['f'.$header['filter']]) > 0) {
						echo '<script type="text/javascript">$(function() {$("input[data-sfilter=\''.$header['filter'].'\']")'
							.'.val(\''.StyleLib::jsReplace($_GET['f'.$header['filter']]).'\');});</script>';
					}
				} elseif (isset($header['filter']) && strlen($header['filter']) > 0) {
					echo '<td '.implode(' ', $headerOptions).'><input type="text" class="form-control table-filter" '
						.'title="'.__('universal_stylelib::stylelib.filter_tooltip').'" data-toggle="tooltip" '
						.'data-placement="bottom" onkeypress="if(event.keyCode == 13) tableFilterSearch(event, this);" '
						.'data-sfilter="'.$header['filter'].'" '.$autofocus.' /></td>';
					if (isset($_GET['f'.$header['filter']]) && strlen($_GET['f'.$header['filter']]) > 0) {
						echo '<script type="text/javascript">$(function() {$("input[data-sfilter=\''.$header['filter'].'\']")'
							.'.val(\''.StyleLib::jsReplace($_GET['f'.$header['filter']]).'\');});</script>';
					}
				} elseif (isset($header['datefilter']) && strlen($header['datefilter']) > 0) {
					$daterange_filtered = '';
					if (!empty($_GET['f'.$header['datefilter'].'_start']) && !empty($_GET['f'.$header['datefilter'].'_end'])) {
						$daterange_filtered = date('d/m/Y', $_GET['f'.$header['datefilter'].'_start'] / 1000);
						if ($_GET['f'.$header['datefilter'].'_start'] != $_GET['f'.$header['datefilter'].'_end']) {
							$daterange_filtered .= ' > ' . date('d/m/Y', $_GET['f'.$header['datefilter'].'_end'] / 1000);
						}
					} else {
						$daterange_filtered = __('universal_stylelib::stylelib.datefilter_notset');
					}
					
					echo '<td '.implode(' ', $headerOptions).'><a href="javascript:;" class="form-control btn btn-sm btn-default" '
						.'id="f'.$header['datefilter'].'" style="margin-bottom:0px;text-align:left"><span class="fa fa-calendar"></span> '
						.'<i>'.$daterange_filtered.'</i></a>';
					echo StyleBaseClass::getView('tableDatefilterJs', array('datefilter' => $header['datefilter']));
					echo '</td>';

				} else {
					echo '<td '.implode(' ', $headerOptions).'></td>';
				}
			}
			
			echo '</tr>';
		}
	}
	
	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		// chiusura tabella
		echo '</tbody>';
		echo '</table>';

		// aggiunta azioni multiple
		if (count($azioniMultiple) > 0) {
			StyleBaseClass::divOpen('form-group azioniMultiple');

			echo '<label class="col-sm-2 control-label">'.__('universal_stylelib::stylelib.multiple_actions_items').':</label>';

			StyleBaseClass::colOpen('col-sm-2');
			echo '<select name="multipleAction" class="form-control multipleAction">';
			foreach ($azioniMultiple as $azione) {
				echo '<option value="'.$azione['azione'].'">'.$azione['label'].'</option>';
			}
			echo '</select>';
			StyleBaseClass::colClose();

			StyleBaseClass::colOpen('col-sm-1');
			echo '<input type="hidden" name="referrer" value="'.$_SERVER['REQUEST_URI'].'" />';
			echo '<button href="#" class="btn btn-primary" onclick="$(this).submit()"><i class="fa fa-check"></i></button>';
			StyleBaseClass::colClose();

			StyleBaseClass::divClose();
		}

		// chiusura form
		if ((isset($options['selectAllCheck']) && $options['selectAllCheck'])
			|| (isset($options['form']) && $options['form'])) {
			echo '</form>';
		}
	}
	
	
	static function rows($rows, $keys = array()) {
		foreach ($rows as $row) {
			if (isset($row['options']) && is_array($row['options'])) {
				$options = $row['options'];
				unset($row['options']);
			} else {
				$options = array();
			}
			
			if (count($keys) > 0) {
				$rowValues = array();
				foreach ($keys as $k) {
					$subkeys = explode('.', $k);
					$value = $row;
					foreach ($subkeys as $subk) {
						if (isset($row->$subk)) {
							$value = $value->$subk;
						} else {
							$value = $value[$subk];
						}
					}
					$rowValues[] = $value;
				}
			} else {
				$rowValues = $row;
			}
			self::row($rowValues, $options);
		}
	}
	
	
	static function row($rowValues, $rowOptions = array()) {
		// aggiunta <tr>
		$rowOptionsStr = '';
		foreach ($rowOptions as $key => $value) {
			$rowOptionsStr .= ' '.$key.'="'.$value.'"';
		}
		echo '<tr '.$rowOptionsStr.'>';

		// aggiunta <td>
		foreach ($rowValues as $rowValue) {
			$options = array();

			// pulsanti
			if (is_array($rowValue) && isset($rowValue['type']) && $rowValue['type'] == 'buttons') {
				$buttons = $rowValue[0];
			
				if (isset($rowValue['colspan'])) {
					$options[] = 'colspan="'.($rowValue['colspan'] == self::$MAX ? count($headers) : $rowValue['colspan']).'"';
				}
				if (isset($rowValue['style'])) {
					$options[] = 'style="'.$rowValue['style'].'"';
				}
				if (isset($rowValue['class'])) {
					$options[] = 'class="'.$rowValue['class'].'"';
				}
				if (isset($rowValue['id'])) {
					$options[] = 'id="'.$rowValue['id'].'"';
				}

				$v = '<div class="btn-group">';
				foreach ($buttons as $button) {
					if (!isset($button['class'])) {
						$button['class'] = 'primary';
					}
					
					if (isset($button['confirm']) && isset($button['confirm_text']) && $button['confirm'] && strlen($button['confirm_text'])) {
						$warn = ' onclick="if(!confirm(\''.str_replace("'", "\\'", $button['confirm_text']).'\')) return false;"';
					} elseif (isset($button['confirm']) && $button['confirm']) {
						$warn = ' onclick="if(!confirm(\''.__('universal_stylelib::stylelib.delete_question').'\')) return false;"';
					} else {
						$warn = '';
					}
					
					if (isset($button['disabled']) && $button['disabled']) {
						$btndisabled = 'disabled';
						$button['href'] = '#';
						$button['class'] .= ' disabled';
						$warn = '';
					} else
						$btndisabled = '';
					
					if (isset($button['tooltip'])) {
						$tooltip_str = ' data-toggle="tooltip" data-placement="top" title="'.$button['tooltip'].'"';
					} else
						$tooltip_str = '';
					
					if (isset($button['target'])) {
						$target = ' target="'.$button['target'].'"';
					} else {
						$target = '';
					}
					
					$v .= ' <a href="'.$button['href'].'" class="btn btn-xs btn-'.$button['class'].'" '.$btndisabled.$tooltip_str.$target.$warn.'>
								<i class="'.$button['icon'].'"></i></a>';
				}
				$rowValue[0] = $v.'</div>';
			}
			
			// valore in array
			if (is_array($rowValue)) {
				$value = $rowValue[0];
			
				if (isset($rowValue['colspan'])) {
					$options[] = 'colspan="'.($rowValue['colspan'] == self::$MAX ? count($headers) : $rowValue['colspan']).'"';
				}
				if (isset($rowValue['style'])) {
					$options[] = 'style="'.$rowValue['style'].'"';
				}
				if (isset($rowValue['class'])) {
					$options[] = 'class="'.$rowValue['class'].'"';
				}
				if (isset($rowValue['id'])) {
					$options[] = 'id="'.$rowValue['id'].'"';
				}
			}
			
			// valore semplice
			else {
				$value = $rowValue;
			}

			echo '<td '.implode(' ', $options).'>'.$value.'</td>';
		}
		echo '</tr>';
	}
}