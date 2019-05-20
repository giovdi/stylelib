<?php
namespace DeployStudio\Style\Minimalart;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped table-bordered');

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');

		// intestazione box
		StyleBaseClass::divOpen('box-header with-border');
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

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card');
		StyleBaseClass::divOpen('card-body');

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		parent::close($azioniMultiple);
		StyleBaseClass::divClose();
		StyleBaseClass::divClose();

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::divOpen('box-footer clearfix');
			//StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			//StyleBaseClass::divClose();
			StyleBaseClass::divClose();
		}

		StyleBaseClass::divClose();
		Box::closeBase($azioniMultiple);
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
}