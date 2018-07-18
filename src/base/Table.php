<?php
namespace DeployStudio\Style;

class Table {
	private static $tables;
	private static $openTable;
	public static $MAX = -1;

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
	
	static function open($icon, $table_title, $actions, $headers, $options = array()) {
		$colclass = empty($options['colclass']) ? 'col-xs-12' : $options['colclass'];
		$box = !is_null($table_title);
		$form = isset($options['form']) && $options['form'];
		$id = (!isset($options['id']) || is_null($options['id'])) ? StyleLib::idGen($table_title) : $options['id'];

		self::$openTable = $id;
		self::$tables[$id] = &$options;
		
if ($box) {
		?>
	<?php if ($colclass == 'col-xs-12') { ?>
	<div class='row tableModelContainer' id="<?php echo $id; ?>">
	<?php } ?>
		<div class='<?php echo $colclass ?>'>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5 style="margin-right:5px"><span class='<?php echo $icon ?>'></span> <?php echo $table_title?></h5>
					<?php
					foreach ($actions as $action) {
						if (!empty($action['right']))
							continue;
						
						$modalStr = '';
						if (!empty($action['modal'])) {
							$action['href'] = '#';
							$modalStr = ' data-toggle="modal" data-target="#'.$action['modal'].'"';
						}
						
						$target = '';
						if (!empty($action['target'])) {
							$target = ' target="'.$action['target'].'"';
						}
						
						$tooltip = '';
						if (!empty($action['tooltip'])) {
							$tooltip = ' data-toggle="tooltip" title="'.$action['tooltip'].'"';
						}
						
						echo ' <a class="btn btn-xs btn-primary ibox-title-action" href="'.$action['href'].'"'.$tooltip.$target.$modalStr.'>';
						echo '<i class="'.$action['icon'].'"></i>';
						echo '</a>';
					}
					foreach ($actions as $action) {
						if (empty($action['right']))
							continue;
						echo '<div class="pull-right" style="font-size:14px">'.$action['right'].'</div>';
					}

					

					//inizio paginazione
					if (!empty($options['totalElements'])) { ?>
						<div class="tablePagination pull-right hidden-xs">
							<ul class='pagination'>
						
								<?php
								if (!isset($options['pagerSelected'])) {
									$options['pagerSelected'] = null;
								}
								$paginator = self::getPages($options['totalElements'], $options['pagerSelected']);
								$pages_show = '';
								
								// VISUALIZZAZIONE DELLA SEQUENZA
								if ($paginator['gotofirst']) {
									$hellip = '';
									if ($paginator['paginator_first'] > 2) {
										$hellip = '&hellip;';
									}
									$pages_show .= '<li><a href="'.StyleLib::strip_query_param('p', 'p=1').'">1'.$hellip.'</a></li>';
								}
								for ($page = $paginator['paginator_first']; $page <= $paginator['paginator_last']; $page++){
									$active_class = '';
									if ($paginator['active_page'] == $page) {
										$active_class = ' class="active"';
									}
									$pages_show .= "\n".'<li'.$active_class.'>'
										.'<a href="'.StyleLib::strip_query_param('p', 'p='.$page).'">'
										.$page.'</a></li>';
								}
								if ($paginator['gotolast']) {
									$hellip = '';
									if ($paginator['paginator_last'] < $paginator['num_pages'] - 1) {
										$hellip = '&hellip;';
									}
									$pages_show .= '<li><a href="'.StyleLib::strip_query_param('p', 'p='.$paginator['num_pages']).'">'
										.$hellip.$paginator['num_pages'].'</a></li>';
								}

								if ($paginator['gotofirst'] || $paginator['gotolast']) {
									$pages_show .= '<li><a class="gotopage" title="Scrivi e premi INVIO per andare a una pagina specifica" data-toggle="tooltip" data-placement="left">
											<input type="text" class="form-control text-info" onkeypress="if(event.keyCode == 13) tableGotopage(this);" />
										</a></li>';
								}
								
								echo $pages_show;
								?>
								
							</ul>
						</div>
							
						<div class="tablePagination pull-right visible-xs-block">
							<ul class="pagination">
								<li><a class="gotopage" title="Scrivi e conferma per andare a una pagina specifica" data-toggle="tooltip" data-placement="left">
									<input type="text" class="form-control text-info" onkeypress="if(event.keyCode == 13) tableGotopage(this);"
									placeholder="<?php echo $paginator['active_page'].'/'.$paginator['num_pages'] ?>" style="width:70px" />
								</a></li>
							</ul>
						</div>

						<?php
						// paginazione - select elementi per pagina
						if (!empty($options['pagerList'])) {
							echo '<div class="pull-right hidden-xs" style="margin-top:-6px">Per pagina: <select class="pager" style="width:75px">';
							$pager_values = array();
							foreach ($options['pagerList'] as $pp) {
								$pager_values[] = array('id' => $pp, 'text' => strval($pp));
							}
							echo '</select></div>';
							?>
							<script type="text/javascript">
								$(function() {
									$('#<?php echo $id ?> .pager').select2({
										data:<?php echo json_encode($pager_values)?>,
										minimumResultsForSearch: -1,
									});
									$('#<?php echo $id ?> .pager').val('<?php echo $paginator['items_page'] ?>').trigger("change");
									$('#<?php echo $id ?> .pager').on("change", function(e) {
										document.location='<?php echo StyleLib::strip_query_param(array('pp', 'p'),
												array('p=1', "pp='+$(this).val()+'")) ?>';
									});
								});
								
							</script>
							<?php
						}
					} // fine paginazione
					?>

					<div class="clear"></div>
				</div>
				<div class="ibox-content">
<?php } ?>

				<?php if ($form) { ?>
				<form class="form form-horizontal" method="post" action="?multipleAction" id="f_<?php echo $id; ?>">
				<?php } ?>
				 
					<table class="table table-hover" id="t_<?php echo $id; ?>">
						<thead>
							<tr>
							<?php
							if ($form || (isset($options['selectAllCheck']) && $options['selectAllCheck'])) { ?>
								<th>
									<input type="checkbox" id="selectAll">
									<script>
										$("#t_<?php echo $id ?> #selectAll").click(function() {
											if ($(this).prop('checked'))
												$("#t_<?php echo $id ?> input[type=checkbox]:not(:disabled)").prop('checked', true).trigger('change');
											else
												$("#t_<?php echo $id ?> input[type=checkbox]:not(:disabled)").prop('checked', false).trigger('change');
										});
									</script>
								</th>
								<?php
							}
							
							$filters = false;
							foreach ($headers as $header) {
								$headerOptions = array();
								$order_chevron = '';
								if (is_array($header)) {
									$value = $header[0];
								
									if (isset($header['colspan']))
										$headerOptions[] = 'colspan="'.($header['colspan'] == Table::$MAX ? count($headers) : $header['colspan']).'"';
									if (isset($header['class']))
										$headerOptions[] = 'class="'.$header['class'].'"';
									if (isset($header['filter']) && strlen($header['filter']) > 0)
										$filters = true;
									if (isset($header['datefilter']) && strlen($header['datefilter']) > 0)
										$filters = true;
									if (isset($header['sort'])) {
										$qstring = array('sort='.$header['sort']);
										if ($header['sort'] == $_GET['sort'] && $_GET['dir'] != 'desc')
											$qstring[] = 'dir=desc';
										$headerOptions[] = 'onclick="document.location=\''.StyleLib::strip_query_param(array('sort', 'dir'), $qstring).'\'"';
										
										if ($header['sort'] == $_GET['sort'] && $_GET['dir'] == 'desc')
											$order_chevron = '<div class="pull-right"><span class="fa fa-sort-desc text-muted"></span></div>';
										elseif ($header['sort'] == $_GET['sort'])
											$order_chevron = '<div class="pull-right"><span class="fa fa-sort-asc text-muted"></span></div>';
										else
											$order_chevron = '<div class="pull-right"><span class="fa fa-sort text-muted"></span></div>';
									}
								}
								
								else
									$value = $header;;
								
								echo '<th '.implode(' ', $headerOptions).'>'.$value.$order_chevron.'</th>';
							} ?>
							</tr>
						</thead>
						
						<?php if ($filters) { ?>
						<tr>
						<?php
						foreach ($headers as $header) {
							$autofocus = (isset($header['filter_autofocus']) ? 'autofocus' : '');
							$headerOptions = array();
							if (isset($header['colspan']))
								$headerOptions[] = 'colspan="'.($header['colspan'] == Table::$MAX ? count($headers) : $header['colspan']).'"';
							if (isset($header['class'])) {
								//remove col- declarations
								$class = $header['class'];
								$class = preg_replace('/col-([a-z-]+)-([0-9]+)/', '', $class);
								$headerOptions[] = 'class="'.$class.'"';
							}
							
							
							if (isset($header['filter']) && strlen($header['filter']) > 0) {
								echo '<th '.implode(' ', $headerOptions).'><input type="text" class="form-control table-filter" '
									.'title="Scrivi e premi INVIO per filtrare" data-toggle="tooltip" '
									.'data-placement="bottom" onkeypress="if(event.keyCode == 13) tableFilterSearch(event, this);" '
									.'data-sfilter="'.$header['filter'].'" '.$autofocus.' />';
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
								}
								echo '';
								
								
								?>
								<th <?php echo implode(' ', $headerOptions) ?>>
									<a href="javascript:;" class="form-control btn btn-sm btn-default" id="f<?php echo $header['datefilter'] ?>"
									style="margin-bottom:0px;text-align:left"><span class="fa fa-calendar"></span>
										<i><?php echo $daterange_filtered ?></i>
									</a>
									<script type="text/javascript">
									$("#f<?php echo $header['datefilter'] ?>").daterangepicker({
										locale:{
											format: "DD/MM/YYYY",
											"separator": " - ",
										     "applyLabel": "Applica",
										     "cancelLabel": "Cancella",
										     "fromLabel": "Da",
										     "toLabel": "A",
										     "customRangeLabel": "Custom",
										     "weekLabel": "W",
										     "daysOfWeek": [
										         "Do",
										         "Lu",
										         "Ma",
										         "Me",
										         "Gi",
										         "Ve",
										          "Sa"
										     ],
										     "monthNames": [
										         "Gennaio",
										         "Febbraio",
										         "Marzo",
										         "Aprile",
										         "Maggio",
										         "Giugno",
										         "Luglio",
										         "Agosto",
										         "Settembre",
										         "Ottobre",
										         "Novembre",
										         "Dicembre"
										      ],
										       "firstDay": 1
										},
										opens: 'right',
										<?php if (!empty($_GET['start']) && !empty($_GET['f'.$header['datefilter'].'_end'])) {?>
													startDate: '<?php echo date('d/m/Y', $_GET['f'.$header['datefilter'].'_start'] / 1000) ?>',
													endDate: '<?php echo date('d/m/Y', $_GET['f'.$header['datefilter'].'_end'] / 1000) ?>',
												<?php } ?>
												ranges: {
													'Oggi': [moment(), moment()],
													'Ieri': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
													'Ultimi 7 giorni': [moment().subtract(6, 'days'), moment()],
													'Ultimi 30 giorni': [moment().subtract(29, 'days'), moment()],
													'Questo mese': [moment().startOf('month'), moment().endOf('month')],
													'Mese scorso': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
													'Dall\'inizio': [0, 0]
												}
											});
									$('#f<?php echo $header['datefilter'] ?>').on('apply.daterangepicker', function(ev, picker) {
										start = picker.startDate.format('x');
										end = picker.endDate.format('x') - 86400000 + 1;

										console.log(start);
										console.log(end);

										urlPickerParams = '';
										urldest = window.location.href;
										if (urldest.indexOf('?') > 0) {
											urldest = removeParam('f<?php echo $header['datefilter'] ?>_start', urldest);
											urldest = removeParam('f<?php echo $header['datefilter'] ?>_end', urldest);
										}

										if (start > -3600000 && end > -3600000) {
											urldest = addParam('f<?php echo $header['datefilter'] ?>_start', start, urldest);
											urldest = addParam('f<?php echo $header['datefilter'] ?>_end', end, urldest);
										}
										
										document.location = urldest;
									});
									</script>
								</th>
								<?php
							} else {
								echo '<th '.implode(' ', $headerOptions).'></th>';
							}
						} ?>
						</tr>
						<?php } ?>
						
<?php
	}
	
	static function close($multipleActions = array(), $hasform = false, $hasbox = true, $isFullWidth = true) {
		$options = self::$tables[self::$openTable];
		?>
		</table>
					
		<?php if (count($multipleActions) > 0) { ?>
			<div class="form-group multipleActions">
				<label class="col-sm-2 control-label"><?php echo 'Elementi selezionati' ?>: </label>
				<div class="col-sm-2">
					<select name="multipleAction" class="form-control multipleAction">
						<?php
						foreach ($multipleActions as $action) {
							echo '<option value="'.$action['action'].'">'.$action['label'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="col-sm-1">
					<input type="hidden" name="referrer" value="<?php echo $_SERVER['REQUEST_URI'] ?>" />
					<button href="#" class="btn btn-primary" onclick="$(this).submit()"><i class="fa fa-check"></i></button>
				</div>
			</div>
		<?php }	?>

		<?php if ($hasform) { ?>
		</form>
		<?php } ?>

							<?php //inizio paginazione
					if (!empty($options['totalElements'])) { ?>
						<div class="tablePagination pull-right">
							<ul class='pagination'>
						
								<?php
								if (!isset($options['pagerSelected'])) {
									$options['pagerSelected'] = null;
								}
								$paginator = self::getPages($options['totalElements'], $options['pagerSelected']);
								$pages_show = '';
								
								// VISUALIZZAZIONE DELLA SEQUENZA
								if ($paginator['gotofirst']) {
									$hellip = '';
									if ($paginator['paginator_first'] > 2) {
										$hellip = '&hellip;';
									}
									$pages_show .= '<li><a href="'.StyleLib::strip_query_param('p', 'p=1').'">1'.$hellip.'</a></li>';
								}
								for ($page = $paginator['paginator_first']; $page <= $paginator['paginator_last']; $page++){
									$active_class = '';
									if ($paginator['active_page'] == $page) {
										$active_class = ' class="active"';
									}
									$pages_show .= "\n".'<li'.$active_class.'>'
										.'<a href="'.StyleLib::strip_query_param('p', 'p='.$page).'">'
										.$page.'</a></li>';
								}
								if ($paginator['gotolast']) {
									$hellip = '';
									if ($paginator['paginator_last'] < $paginator['num_pages'] - 1) {
										$hellip = '&hellip;';
									}
									$pages_show .= '<li><a href="'.StyleLib::strip_query_param('p', 'p='.$paginator['num_pages']).'">'
										.$hellip.$paginator['num_pages'].'</a></li>';
								}
								
								echo $pages_show;
								
								?>
							</ul>
						</div>
						<div class="clear"></div>
					<?php } // fine paginazione ?>


<?php if ($hasbox) { ?>
			</div>
			
			</div>
		</div>
	<?php if ($isFullWidth) { ?>
	</div>
	<?php } ?>
<?php } ?>

<?php 
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
					$rowValues[] = $row[$k];
				}
			} else {
				$rowValues = $row;
			}
			Table::row($rowValues, $options);
		}
	}
	
	
	static function row($rowValues, $rowOptions = array()) {
	?>
<tr
<?php foreach ($rowOptions as $key => $value) {
	echo ' '.$key.'="'.$value.'"';
} ?>>
	<?php
	foreach ($rowValues as $rowValue) {
		$options = array();
		if (is_array($rowValue) && isset($rowValue['type']) && $rowValue['type'] == 'buttons') {
			$buttons = $rowValue[0];
			$v = '<div class="btn-group">';
			foreach ($buttons as $button) {
				if (!isset($button['class']))
					$button['class'] = 'primary';
				
				if (isset($button['confirm']) && isset($button['confirm_text']) && $button['confirm'] && strlen($button['confirm_text'])) {
					$warn = ' onclick="if(!confirm(\''.str_replace("'", "\\'", $button['confirm_text']).'\')) return false;"';
				} elseif (isset($button['confirm']) && $button['confirm']) {
					$warn = ' onclick="if(!confirm(\'Sei sicuro?\')) return false;"';
				} else {
					$warn = '';
				}
				
				if (isset($button['disabled']) && $button['disabled']) {
					$btndisabled = 'disabled';
					$button['href'] = '#';
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
		
		if (is_array($rowValue)) {
			$value = $rowValue[0];
		
			if (isset($rowValue['colspan']))
				$options[] = 'colspan="'.($rowValue['colspan'] == Table::$MAX ? count($headers) : $rowValue['colspan']).'"';
			if (isset($rowValue['class']))
				$options[] = 'class="'.$rowValue['class'].'"';
		}
		
		else
			$value = $rowValue;
		echo '<td '.implode(' ', $options).'>'.$value.'</td>';
	} ?>
</tr>
<?php 
	}
	
	static function cellCheckbox($id, $disabled = false, $checked = false) {
		return '<input type="checkbox" name="mSel[]" value="'.$id.'"'.($disabled ? ' disabled' : '').($checked ? ' checked' : '').'>';
	}
}