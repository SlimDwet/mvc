<?php

class MyModel {

	protected $table;

	public function __construct() {
		$this->getTable();
	}

	private function getTable() {
		if(gettype($this->table) !== 'string') throw new Exception("La table fournie est invalide");
		$sql = "SHOW TABLE $this->table";
		$this->getQuery($sql);
	}

	/**
	 * [select Retourne la liste de résultats recherchés]
	 * @return [object] [Liste des résultats]
	 */
	public function select() {
		global $bdd;

		$args = func_get_args();
		$fields = is_null($item = array_shift($args)) ? array() : $item;
		$where = is_null($item = array_shift($args)) ? array() : $item;

		switch (empty($fields)) {
			case true:
				$sql = "SELECT * ";
				break;
			default:
				$sql = "SELECT ".implode(',', $fields).' ';
				break;
		}
		$sql .="FROM ".$this->table.' WHERE ';
		switch (empty($where)) {
			case true:
				// WHERE 1
				$sql .= '1';
				break;
			default:
				// WHERE
				$sql .= $this->getWhere($where);
				break;
		}

		return $this->getQuery($sql);
	}

	/**
	 * [insert Insert des données en BDD]
	 * @return [type] [Nombre de lignes affectés]
	 */
	public function insert() {
		$args = func_get_args();
		$fields = is_null($item = array_shift($args)) ? array() : $item;
		$datas = is_null($item = array_shift($args)) ? array() : $item;

		if(empty($fields)) throw new Exception("Le champs d'ajout est inexistant", 1);
		if(empty($datas)) throw new Exception("La(s) valeur(s) est/sont d'ajout inexistante", 1);

		$this->table = $table;
		$sql = "INSERT INTO ".$this->table.' ('.implode(', ', $fields).') VALUES ';

		$total_args = count($datas);
		$values = "";
		foreach($datas as $data) {
			$values .= "(";
			$values .= implode(', ', array_map(array($this, 'formateData'), $data));
			if(next($datas)) $values .= "), ";
				else $values .= ')';
		}
		$sql .= $values;

		$result = $this->getExec($sql);
		if($result === false) throw new Exception("Une erreur s'est produite lors de l'ajout");

		return $result;
	}

	/**
	 * [update Met à jour des données en BDD]
	 * @return [type] [Nombre de lignes affectés]
	 */
	public function update() {
		$args = func_get_args();
		$conditions = is_null($item = array_shift($args)) ? 1 : $item;
		$datas = is_null($item = array_shift($args)) ? array() : $item;

		if(empty($datas)) throw new Exception("La valeur de MAJ est inexistante", 1);

		$sql = "UPDATE ".$this->table.' SET ';
		
		foreach($datas as $field => $value) {
			$sql .= $field.' = '.$this->formateData($value);
			if(next($datas)) $sql .= ", ";
		}

		$sql .= " WHERE $condition";prd($sql);
		$result = $this->getExec($sql);
		if($result === false) throw new Exception("Une erreur s'est produite lors de la MAJ");
		
		return $result;
	}

	/**
	 * @param  [Supprime des données de la BDD]
	 * @param  $table string : Nom de la table
	 * @param  $condition string : Condition(s) de suppression
	 * @return [type]
	 */
	public function delete() {
		$args = func_get_args();
		$conditions = is_null($item = array_shift($args)) ? 1 : $item;

		$sql = "DELETE FROM $this->table WHERE $condition";prd($sql);
		$result = $this->getExec($sql);
		if($result === false) throw new Exception("Une erreur s'est produite lors de la suppression");
		
		return $result;
	}

	/**
	 * [truncate On vide la table]
	 * @return [type] [description]
	 */
	public function truncate() {

		$sql = "TRUNCATE TABLE $this->table";prd($sql);
		$return = $this->getQuery($sql);
		if($result === false) throw new Exception("Une erreur s'est produite lors du vidage de la table");
		
		return $result;
	}

	/**
	 * [formateData Formate une information pour son utilisation dans une requête SQL]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	private function formateData($value) {
		return (gettype($value) === 'string') ? '"'.(string) $value.'"' : $value;
	}

	/**
	 * [getQuery Exécute une requête SQL]
	 * @param  [type] $sql [Requête SQL]
	 * @return [type]      [Résultat sour forme d'objet/tableau d'objet]
	 */
	private function getQuery($sql) {
		global $bdd;
		try {
			$req = $bdd->query($sql);
		} catch(PDOException $e) {
			die("Une erreur s'est produite : ".$e->getMessage());
		}
		if($req) return empty($fields) ? $req->fetchAll(PDO::FETCH_OBJ) : $req->fetch(PDO::FETCH_OBJ);

		return false;
	}

	/**
	 * [getExec Exécute une requête SQL]
	 * @param  [type] $sql [Requête SQL]
	 * @return [type]      [Retourne le nombre de lignes affectés]
	 */
	private function getExec($sql) {
		global $bdd;
		try {
			$result = $bdd->exec($sql);
		} catch(PDOException $e) {
			die("Une erreur s'est produite : ".$e->getMessage());
		}
		return $result;
	}

	/**
	 * [getWhere Construction de la partie WHERE d'une requête SQL]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	private function getWhere($where) {
		$query = false;
		if(gettype(current((array) $where)) === 'array') {
			// Multi-conditions
			foreach ($where as $operator => $list) {
				$compare_total = count($list);
				foreach ($list as $value) {
					$query .= $value;
					if(next($list)) $query .= ' '.$operator.' ';
				}
			}
		} else {
			$query = $where;
		}

		return $query;
	}

}