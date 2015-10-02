<?php

class MyController {

	protected $models = array();

	public function __construct() {
		$this->getModels();
	}

	// SELECT
	public function find($table, $fields, $where) {
		return $this->model->select($table, $fields, $where);
	}

	// INSERT
	public function insert($table = null, $fields = null, $args = null) {
		$args = func_get_args();
		$table = array_shift($args); // Récupération de la table
		$fields = array_shift($args); // Récupération des champs
		
		$result = $this->model->insert($table, $fields, (array) $args);
		if($result === false) throw new Exception("Une erreur s'est produite lors de l'ajout");
		return $result;
	}

	// UPDATE
	public function update($table = null, $condition = null, $args = null) {
		$args = func_get_args();
		$table = array_shift($args); // Récupération de la table
		$conditions = array_shift($args);
		$condition = is_null($conditions) ? 1 : $conditions; // Récupération de la condition
		$args = array_shift($args); // Liste des données

		$result = $this->model->update($table, $condition, (array) $args);
		if($result === false) throw new Exception("Une erreur s'est produite lors de la MAJ");
		return $result;
	}

	// DELETE
	public function delete() {
		$args = func_get_args();
		$table = array_shift($args); // Récupération de la table
		$conditions = array_shift($args);
		$condition = is_null($conditions) ? 1 : $conditions; // Récupération de la condition

		$result = $this->model->delete($table, $condition);
		if($result === false) throw new Exception("Une erreur s'est produite lors de la suppression");
		return $result;
	}

	// TRUNCATE
	public function truncate() {
		$args = func_get_args();
		$table = current($args); // Récupération de la table

		$result = $this->model->truncate($table);
		if($result === false) throw new Exception("Une erreur s'est produite lors du vidage de la table");
		return $result;
	}

	public function set($data = array(), $class = __CLASS__) {
		$controller = str_replace("Controller", "", get_class($this));
	}

	public function getModels() {
		if(!empty($this->models)) {
			foreach ($this->models as $model) {
				if(!property_exists($this, $model)) {
					$this->{$model} = new $model();
				}
			}
			prd($this);
		}
	}

}