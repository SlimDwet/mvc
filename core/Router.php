<?php

class Router {

	private static $controller;
	private static $action = 'index';
	private static $other_params = array();

	public static function parse() {
		$query = self::getQueryData();
		self::parseParameters($query);
	}

	/**
	 * Retourne un tableau avec les paramètres de l'URL
	 */
	private static function getQueryData() {
		$request_uri = strtolower($_SERVER['REQUEST_URI']);
		$exp_site_url = explode('/', WEB_ROOT);
		$exp_query = explode('/', $request_uri);
		foreach ($exp_site_url as $key => $value) {
			if(in_array($value, $exp_query)) {
				unset($exp_query[array_search($value, $exp_query)]);
			}
		}
		foreach ($exp_query as $key => $value) {
			if($value == '') unset($exp_query[$key]);
		}
		$query = array_merge($exp_query);

		return $query;
	}

	/**
	 * Extrait des paramètres le controller, action et les autres paramètres
	 */
	private static function parseParameters($query = []) {
		$nb_params = count($query);
		$other_params = $cont_act = array();
		if(!$nb_params) {
			// Controller et action par défaut
			self::$controller = DEF_CONTROLLER;
		} else {
			// Controller et action demandés
			self::$controller = $query[0];
			$cont_act[] = self::$controller;
			if(isset($query[1])) {
				self::$action = $query[1];
				$cont_act[] = self::$action;
			}

			if($nb_params > 2) {
				$other_params = array_diff($query, $cont_act);
			}
			self::$other_params = array_merge($other_params);
		}

		$controller_file = ucfirst(self::$controller.'Controller');
		if(file_exists(APP_DIR.'Controllers'.DS.$controller_file.'.php')) $controller = new $controller_file();
			else throw new Exception("Le controller $controller_file n'existe pas");
		if(method_exists($controller, self::$action)) $controller->{self::$action}();
			else throw new Exception("La méthode ".self::$action." du controller $controller_file n'existe pas");
	}

}