<?php

class MyController {

	protected $models = array();
	protected $caller;

	public function __construct() {
		$this->getModels();
		$this->caller = getCaller();
	}

	/**
	 * [set Affiche la vue en lui passant les données dynamiques à afficher]
	 * @param array $data [description]
	 */
	public function set($data = array()) {
		$view = APP_DIR.'Views/'.ucfirst(strtolower(Router::getController())).'/'.strtolower(Router::getAction()).'.php';
		if(!file_exists($view))
			throw new Exception("La vue de l'action est introuvable");

		if(!empty($data)) extract($data);

		require_once $view;
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