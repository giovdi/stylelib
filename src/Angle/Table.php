<?php
namespace DeployStudio\Style\Angle;

use DeployStudio\Style\StyleBaseClass;


class Table extends \DeployStudio\Style\Base\Table {

	/*static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		$options['tema'] = 'angle';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box '.($options['border_status'] != null ? 'box-'.$border_status : ''));

		// intestazione box
		StyleBaseClass::divOpen('box-header with-border');
		echo '<h3 class="box-title"><span class="'.$icona.'"></span> '.$titolo.'</h3>';
		parent::azioniIntestazione($azioni);
		parent::paginazione();
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('box-body');

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-xs-12');
		$options['tema'] = 'angle';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('box');
		StyleBaseClass::divOpen('box-body');

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		StyleBaseClass::divClose();
		StyleBaseClass::divClose();
		Box::closeBase($azioniMultiple);
		parent::close($azioniMultiple);
	}*/


	static function open ($icona, $titolo, $azioni, $headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		StyleBaseClass::checkOption($options['border_status'], null);
		$options['tema'] = 'angle';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card card-default');

		// intestazione box
		StyleBaseClass::divOpen('card-header');
		echo '<i class="'.$icona.'"></i> '.$titolo;
		parent::azioniIntestazione($azioni);
		parent::paginazione();
		StyleBaseClass::divClose();
		
		StyleBaseClass::divOpen('card-body');

		// opzioni tabella
		$options['tableClass'] = 'table-striped table-bordered';

		parent::openTable($headers, $options);
	}

	static function openNoTitle ($headers, $options = array()) {
		StyleBaseClass::checkOption($options['colclass'], 'col-md-12');
		$options['tema'] = 'angle';

		Box::openBase($options['colclass']);
		StyleBaseClass::divOpen('card');
		StyleBaseClass::divOpen('card-body');

		// opzioni tabella
		$options['tableClass'] = 'table-striped table-bordered';

		parent::openTable($headers, $options);
	}

	static function close($azioniMultiple = array()) {
		parent::close($azioniMultiple);
		Box::closeBase($azioniMultiple);
		StyleBaseClass::divClose();
		StyleBaseClass::divClose();
	}
}