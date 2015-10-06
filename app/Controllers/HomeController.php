<?php

class HomeController extends MyController {
	
	protected $models = array('Home');

	public function index() {
		// $this->View->addStyles(array('styles'));
		echo "<== TO DO ==><br>- Améliorer l'import des CSS/JS avec le support d'une css/js seule au lieu d'un array<br>
		- Gérer le reverse routing";
	}

	public function liste($params = null) {
		echo (isset($params)) ? "Paramètre = ".(string) current($params) : '';
	}

}