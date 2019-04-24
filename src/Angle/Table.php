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
}