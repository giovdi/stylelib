<?php
namespace DeployStudio\Style\Bootswatch;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		StyleBaseClass::checkOption($options['tableClass'], 'table-hover');

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		$options = self::$tables[self::$openTable];

		parent::close($azioniMultiple);

		if (isset($options['totalElements']) && $options['totalElements'] > 0) {
			parent::paginazione($options['totalElements'], $options['pagerSelected']);
		}
	}
}