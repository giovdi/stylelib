<?php
namespace DeployStudio\Style;

use \Jenssegers\Blade\Blade;

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
	
	static function strip_query_param($params_strip, $params_merge = array(), $pageret = true) {
		if (!is_array($params_strip)) {
			$params_strip = array($params_strip);
		}
		if (!is_array($params_merge)) {
			$params_merge = array($params_merge);
		}
	
		$pageQ = preg_split("/(&|\?)/", $_SERVER['REQUEST_URI']);
		$page = $pageQ[0];
		array_shift($pageQ);
		foreach ($params_strip as $param) {
			for ($i = 0; $i < count($pageQ); $i++) {
				if (substr($pageQ[$i], 0, strpos($pageQ[$i], '=')) == $param) {
					array_splice($pageQ, $i, 1);
					$i--;
				}
			}
		}

		if (count(array_merge($pageQ, $params_merge)) > 0) {
			return ($pageret ? $page.'?' : '').implode('&', array_merge($pageQ, $params_merge));
		} else {
			return ($pageret ? $page : '');
		}
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
		return $blade->make($tema.'.'.$template, $params)->render();
	}
}