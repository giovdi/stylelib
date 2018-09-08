<?php
namespace DeployStudio\Style;

use \Philo\Blade\Blade;

class StyleBaseClass {
	protected static $blade_views = __DIR__ . '/../views';
	protected static $blade_cache = __DIR__ . '/../cache';
	
	static function jsReplace($testo, $htmlchars = FALSE) {
		$testo = str_replace('\'', '\\\'', $testo);
		$testo = str_replace("\r\n", '\\r\\n', $testo);
		$testo = str_replace("\n", '\\n', $testo);
		if ($htmlchars) {
			$testo = htmlspecialchars($testo);
		}
		return $testo;
	}
	
	static function checkOption (&$var, $default) {
		if (empty($var)) {
			$var = $default;
		}
	}

	static function rowOpen ($classi_aggiuntive = null, $id = null, $style = null) {
		StyleBaseClass::divOpen('row '.$classi_aggiuntive, $id, $style);
	}
	static function rowClose() {
		StyleBaseClass::divClose();
	}

	static function colOpen ($classi_colonna = 'col-xs-12', $id = null, $style = null) {
		StyleBaseClass::divOpen($classi_colonna, $id, $style);
	}
	static function colClose() {
		StyleBaseClass::divClose();
	}

	static function divOpen ($class = null, $id = null, $style = null) {
		echo '<div '.(!is_null($class) ? 'class="'.$class.'"' : '')
			.' '.(!is_null($id) ? 'id="'.$id.'"' : '')
			.' '.(!is_null($style) ? 'style="'.$style.'"' : '').'>';
	}
	static function divClose() {
		echo '</div>';
	}

	static function getView ($template, $params = array(), $tema = 'base') {
		if (!is_dir(self::$blade_cache)) {
			mkdir (self::$blade_cache);
		}

		$blade = new Blade(self::$blade_views, self::$blade_cache);
		return $blade->view()->make($tema.'.'.$template, $params)->render();
	}
}