<?php

class MyController {

	protected $models = array();
	protected $View;

	public function __construct() {
		$this->getModels();
		if(is_null($this->View)) $this->View = new MyView(); // Objet gérant les vues
	}

	/**
	 * [set Affiche la vue en lui passant les données dynamiques à afficher]
	 * @param array $data [description]
	 */
	public function set($data = array()) {

		$header = APP_DIR.'Views/default/header.php';
		$footer = APP_DIR.'Views/default/footer.php';
		if(!file_exists($header)) throw new Exception("La vue header est manquante");
		if(!file_exists($footer)) throw new Exception("La vue footer est manquante");

		$current_view = APP_DIR.'Views/'.ucfirst(strtolower(Router::getController())).'/'.strtolower(Router::getAction()).'.php';
		if(!file_exists($current_view)) throw new Exception("La vue de l'action est introuvable");

		if(!empty($data)) extract($data);

		require_once $header;
		require_once $current_view;
		require_once $footer;
	}

	/**
	 * [getModels Instancie les models]
	 * @return [type] [description]
	 */
	public function getModels() {
		if(!empty($this->models)) {
			foreach ($this->models as $model) {
				if(!property_exists($this, $model)) {
					$this->{$model} = new $model();
				}
			}
		}
	}

}