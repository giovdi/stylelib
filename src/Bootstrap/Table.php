<?php
namespace DeployStudio\Style\Bootstrap;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['bg_header'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped table-bordered m-0');

		$options['box'] = true;
		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card');

		// intestazione box
		StyleBaseClass::divOpen('card-header with-border '.(!is_null($options['bg_header']) ? 'bg-'.$options['bg_header'] : ''));
		echo '<i class="'.$icona.'"></i> '.$titolo;
		foreach ($azioni as &$azione) {
			StyleBaseClass::checkOption($azione['class'], 'primary btn-xs');
		}
		unset($azione);
		parent::azioniIntestazione($azioni);

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::checkOption($options['pagerSelected'], null);
			StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			StyleBaseClass::divClose();
		}
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('card-body p-0');
		StyleBaseClass::divOpen('table-responsive', null, '');

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped m-0');

		$options['box'] = true;
		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card');
		StyleBaseClass::divOpen('card-body p-0');
		StyleBaseClass::divOpen('table-responsive', null, '');

		parent::openTable($headers, $options);
	}

	static function openNoBox ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-striped m-0');

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
				StyleBaseClass::divOpen('card-footer clearfix');
				//StyleBaseClass::divOpen('card-tools');
				parent::paginazione($options['totalElements'], $options['pagerSelected']);
				//StyleBaseClass::divClose();
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
}