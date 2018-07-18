<?php
namespace DeployStudio\Style;

class StyleLib {
	static function idGen ($str) {
		$str = strtolower($str);
		$str = ucwords($str);
		$str = lcfirst($str);
		$str = preg_replace("/&([aeiou])(grave|acute);/", "$1", $str);
		$str = preg_replace("/([^a-zA-Z0-9]+)/", "", $str);
		return $str;
	}
	
	static function jsReplace($testo, $htmlchars = FALSE) {
		$testo = str_replace('\'', '\\\'', $testo);
		$testo = str_replace("\r\n", '\\r\\n', $testo);
		$testo = str_replace("\n", '\\n', $testo);
		if ($htmlchars) {
			$testo = htmlspecialchars($testo);
		}
		return $testo;
	}

	/**
	 * Removes and adds one or more parameters from Query String
	 * @param mixed $params_strip Parameters to be stripped from Query String (string or array)
	 * @param mixed $params_merge Parameters to be added to Query String (string or array)
	 * @return string Full URL sanitized
	 */
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
}