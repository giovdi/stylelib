<?php
namespace DeployStudio\Style\Minimalart;

use DeployStudio\Style\StyleBaseClass;


class Paginator {
	static function getHtml($pager) {
		$pages_show = '';

		// VISUALIZZAZIONE DELLA SEQUENZA
		if ($pager['gotofirst']) {
			$hellip = '';
			if ($pager['paginator_first'] > 2) {
				$hellip = '&hellip;';
			}
			$pages_show .= self::paginatorElement('1', '1'.$hellip, false);
		}
		for ($page = $pager['paginator_first']; $page <= $pager['paginator_last']; $page++){
			$pages_show .= self::paginatorElement($page, $page, $pager['active_page'] == $page);
		}
		if ($pager['gotolast']) {
			$hellip = '';
			if ($pager['paginator_last'] < $pager['num_pages'] - 1) {
				$hellip = '&hellip;';
			}
			$pages_show .= self::paginatorElement($pager['num_pages'], $hellip.$pager['num_pages'], false);
		}
		
		if ($pager['gotofirst'] || $pager['gotolast']) {
			$pages_show .= self::paginatorGoToFormLarge();
		}
		
		echo self::paginatorContainer($pages_show);
		echo self::paginatorGoToFormSmall($pager['active_page'], $pager['num_pages']);
		

		// paginazione - select elementi per pagina
		echo self::paginatorPerPageSelector();
		echo '<script>var itemsPage = '.$pager['items_page'].';</script>';
	}

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