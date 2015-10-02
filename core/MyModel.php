<?php

class MyModel {

	private $table;

	public function __construct() {
		$this->getTable();
	}

	private function getTable() {
		if(gettype($this->table) !== 'string') throw new Exception("La table fournie est invalide");
		$sql = "SHOW TABLE $this->table";
		$this->getQuery($sql);
	}

	/**
	 * Retourne la liste de résultats recherchés
	 */
	public function select($fields = array(), $where = array()) {
		global $bdd;

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
	 * Insert des données en BDD
	 */
	public function insert($fields = array(), $datas = array()) {
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

		return $this->getExec($sql);
	}

	/**
	 * Met à jour des données en BDD
	 */
	public function update($condition = 1, $datas = array()) {
		if(empty($datas)) throw new Exception("La valeur de MAJ est inexistante", 1);

		$sql = "UPDATE ".$this->table.' SET ';
		
		foreach($datas as $field => $value) {
			$sql .= $field.' = '.$this->formateData($value);
			if(next($datas)) $sql .= ", ";
		}

		$sql .= " WHERE $condition";prd($sql);
		return $this->getExec($sql);
	}

	/**
	 * @param  [Supprime des données de la BDD]
	 * @param  $table string : Nom de la table
	 * @param  $condition string : Condition(s) de suppression
	 * @return [type]
	 */
	public function delete($condition = 1) {

		$sql = "DELETE FROM $this->table WHERE $condition";prd($sql);
		return $this->getExec($sql);
	}

	public function truncate($table) {
		if(gettype($table) !== 'string') throw new Exception("La table fournie est invalide");

		$this->table = $table;
		$sql = "TRUNCATE TABLE $this->table";//prd($sql);
		return $this->getQuery($sql);
	}

	private function formateData($value) {
		return (gettype($value) === 'string') ? '"'.(string) $value.'"' : $value;
	}

	/**
	 * Exécute la requête SQL et retourne un résultat sour forme d'objet/tableau d'objet
	 */
	private function getQuery($sql) {
		global $bdd;
		try {
			$req = $bdd->query($sql);
		} catch(PDOException $e) {
			die("Une erreur s'est produite : ".$e->getMessage());
		}
		return empty($fields) ? $req->fetchAll(PDO::FETCH_OBJ) : $req->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * Exécute la requête SQL et retourne le nombre de lignes affectés
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
	 * Construction de la partie WHERE d'une requête
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