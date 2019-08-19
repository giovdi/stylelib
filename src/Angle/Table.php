<?php
namespace DeployStudio\Style\Angle;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped table-bordered');

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card card-default');

		// intestazione box
		StyleBaseClass::divOpen('card-header');
		echo '<i class="'.$icona.'"></i> '.$titolo;
		parent::azioniIntestazione($azioni);

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::checkOption($options['pagerSelected'], null);
			StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			StyleBaseClass::divClose();
		}
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('table-responsive', null, 'border-top:2px solid #eee');

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped table-bordered');

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card');
		StyleBaseClass::divOpen('card-body');

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		parent::close($azioniMultiple);
		StyleBaseClass::divClose();

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::divOpen('card-footer clearfix');
			StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			StyleBaseClass::divClose();
			StyleBaseClass::divClose();
		}

		StyleBaseClass::divClose();
		Box::closeBase($azioniMultiple);
	}
	
	static function cellCheckbox($id, $disabled = false, $checked = false) {
		return '<input type="checkbox" name="mSel[]" value="'.$id.'"'.($disabled ? ' disabled' : '').($checked ? ' checked' : '').'>';
	}
	static function _allCheckbox() {
		return '<input type="checkbox" id="selectAll">';
	}

	/** PAGINATOR */
	static function paginatorElement($page_nr, $page_label, $active) {
		return '<li class="page-item'.($active ? ' active' : '').'">
			<a class="page-link" href="'.StyleBaseClass::strip_query_param('p', 'p='.$page_nr).'">
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
		return '<div class="tablePagination no-margin pull-right hidden-xs d-none d-sm-block">
			<ul class="pagination pagination-sm" style="margin:0; font-size:14px">
				'.$content.'
			</ul>
		</div>';
	}

	static function paginatorPerPageSelector() {
		return '<div class="pull-right hidden-xs d-none d-sm-block paginator-items-page">
			'.__('universal_stylelib::stylelib.per_page').': <select class="pager" style="width:75px"></select>
		</div>';
	}
}