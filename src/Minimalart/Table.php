<?php
namespace DeployStudio\Style\Minimalart;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['bg_header'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped table-bordered');

		$options['box'] = true;
		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');

		// intestazione box
		StyleBaseClass::divOpen('box-header with-border '.(!is_null($options['bg_header']) ? 'bg-'.$options['bg_header'] : ''));
		echo '<h3 class="box-title"><i class="'.$icona.'"></i> '.$titolo.'</h3>';
		parent::azioniIntestazione($azioni);

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::checkOption($options['pagerSelected'], null);
			StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			StyleBaseClass::divClose();
		}
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body no-padding');
		StyleBaseClass::divOpen('table-responsive', null, '');

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped');

		$options['box'] = true;
		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');
		StyleBaseClass::divOpen('box-body no-padding');
		StyleBaseClass::divOpen('table-responsive', null, '');

		parent::openTable($headers, $options);
	}

	static function openNoBox ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped');

		$options['box'] = false;
		StyleBaseClass::divOpen('table-responsive', null, '');
		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		// close table
		parent::close($azioniMultiple);
		StyleBaseClass::divClose();

		// close box if previously opened
		if ($options['box']) {;
			StyleBaseClass::divClose();

			if (isset($options['totalElements']) && $options['totalElements'] > 0) {
				StyleBaseClass::divOpen('box-footer clearfix');
				StyleBaseClass::divOpen('box-tools');
				parent::paginazione($options['totalElements'], $options['pagerSelected']);
				StyleBaseClass::divClose();
				StyleBaseClass::divClose();
			}

			StyleBaseClass::divClose();
			Box::closeBase($azioniMultiple);
		}
	}

	static function cellCheckbox($id, $disabled = false, $checked = false) {
		return '<div class="checkbox">
			<input type="checkbox" name="mSel[]" value="'.$id.'" id="cell_'.$id.'"
			'.($disabled ? ' disabled' : '').($checked ? ' checked' : '').'>
			<label for="cell_'.$id.'"></label>
		</div>';
	}
	static function _allCheckbox() {
		return '<div class="checkbox">
			<input type="checkbox" id="selectAll">
			<label for="selectAll"></label>
		</div>';
	}

	/** PAGINATOR */
	static function paginatorElement($page_nr, $page_label, $active) {
		return '<li>
			<a href="'.StyleBaseClass::strip_query_param('p', 'p='.$page_nr).'"'.($active ? ' class="current"' : '').'>
				'.$page_label.'
			</a>
		</li>';
	}

	static function paginatorGoToFormLarge() {
		return '<li class="page-item">
			<div class="gotopage">
				<form class="paginatorform">
					<input type="number" class="form-control text-info"
					title="'.__('universal_stylelib::stylelib.pager_tooltip_desktop').'" data-toggle="tooltip" data-placement="left" />
				</form>
			</div>
		</li>';
	}

	static function paginatorGoToFormSmall($active_page, $num_pages) {
		return '<div class="tablePagination pull-right visible-xs-block d-block d-sm-none">
			<ul class="pagination">
				<li class="page-item">
					<div class="gotopage onlybox" style="padding:0;">
						<form class="paginatorform">
							<input type="number" class="form-control text-info"
							placeholder="'.$active_page.'/'.$num_pages.'"
							title="'.__('universal_stylelib::stylelib.pager_tooltip_mobile').'" data-toggle="tooltip" data-placement="left" />
						</form>
					</div>
				</li>
			</ul>
		</div>';
	}

	static function paginatorContainer($content) {
		return '<div class="clearfix">
			<ul class="pagination pagination-sm pull-right">
				'.$content.'
			</ul>
		</div>';
	}

	static function paginatorPerPageSelector() {
		return '<div class="pull-right hidden-xs d-none d-sm-block paginator-items-page">
			'.__('universal_stylelib::stylelib.per_page').': <select class="pager"></select>
		</div>';
	}
}