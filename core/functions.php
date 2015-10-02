<?php

// Autoloads
function loadCoreClass($class_name) {
	if(file_exists(CORE_DIR.$class_name.'.php')) require_once $class_name.'.php';
}
function loadAppClass($class_name) {
	if(file_exists(APP_DIR.'Controllers'.DS.$class_name.'.php')) require_once 'Controllers'.DS.$class_name.'.php';
	if(file_exists(APP_DIR.'Models'.DS.$class_name.'.php')) require_once 'Models'.DS.$class_name.'.php';
}
spl_autoload_register('loadCoreClass');
spl_autoload_register('loadAppClass');

// Debug
function prd($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die;
}

function vdd($data) {
	var_dump($data);
	die;
}

/**
 * Vérifie si les données en config sont valides
 */
function checkConfig() {
	$errors = array();
	if(!filter_var(WEB_ROOT, FILTER_VALIDATE_URL)) $errors[] = "Merci de saisir une URL de site correcte";
	if(DEF_CONTROLLER == '') $errors[] = "Merci de sélectionner un controller par défaut";
	if(!file_exists(APP_DIR.'Controllers'.DS.ucfirst(strtolower(DEF_CONTROLLER)).'Controller.php')) $errors[] = "Le controller par défaut n'existe pas";

	if(!empty($errors)) {
		foreach($errors as $err) {
			echo $err."<br>";
		}
		die;
	}
}

if(!function_exists('getCaller')) {
	/**
	 * [getCaller Retourne le nom et la méthode de la classe appelante]
	 * @return [type] [description]
	 */
	function getCaller() {
		$data = array();
		$db_bk = debug_backtrace();
		$data['controller'] = $db_bk[1]['class'];
		$data['action'] = $db_bk[1]['function'];

		return $data;
	}
}