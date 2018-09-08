<?php
namespace DeployStudio\Style\Adminlte;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		$options['tema'] = 'adminlte';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box '.($options['border_status'] != null ? 'box-'.$border_status : ''));

		// intestazione box
		StyleBaseClass::divOpen('box-header with-border');
		echo '<h3 class="box-title"><span class="'.$icona.'"></span> '.$titolo.'</h3>';
		parent::azioniIntestazione($azioni);
		parent::paginazione();
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body');

		// opzioni tabella
		$options['tableClass'] = 'table-hover';

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		$options['tema'] = 'adminlte';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');
		StyleBaseClass::divOpen('box-body');

		// opzioni tabella
		$options['tableClass'] = 'table-hover';

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		StyleBaseClass::divClose();
		StyleBaseClass::divClose();
		Box::closeBase($azioniMultiple);
		parent::close($azioniMultiple);
	}
}