<?php
namespace DeployStudio\Style\Base;

use \DeployStudio\Style\StyleBaseClass;

class BoxStat {
	protected static function statContent ($content, $boxclass) {
		if ($boxclass == 'col-12' || $boxclass == 'col-xs-12') {
			StyleBaseClass::divOpen('row');
		}
		StyleBaseClass::divOpen($boxclass);
		echo $content;
		StyleBaseClass::divClose();
		if ($boxclass == 'col-12' || $boxclass == 'col-xs-12') {
			StyleBaseClass::divClose();
		}
	}
}