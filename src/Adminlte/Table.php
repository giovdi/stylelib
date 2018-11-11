<?php
namespace DeployStudio\Style\Adminlte;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-hover');

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box '.($options['border_status'] != null ? 'box-'.$border_status : ''));

		// intestazione box
		StyleBaseClass::divOpen('box-header with-border');
		echo '<h3 class="box-title"><span class="'.$icona.'"></span> '.$titolo.'</h3>';
		parent::azioniIntestazione($azioni);

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			StyleBaseClass::checkOption($options['pagerSelected'], null);
			StyleBaseClass::divOpen('box-tools');
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
			StyleBaseClass::divClose();
		}
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body no-padding');

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		StyleBaseClass::checkOption($options['tableClass'], 'table-hover');

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');
		StyleBaseClass::divOpen('box-body no-padding');

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		parent::close($azioniMultiple);
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