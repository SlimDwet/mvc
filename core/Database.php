<?php

class Database {

	private $host;
	private $db_name;
	private $db_user;
	private $db_pass;
	private $pdo;

	public function __construct() {
		$this->loadDatabaseConfig();
		try {
			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);
		} catch(PDOException $e) {
			die("Connexion impossible : ".$e->getMessage());
		}
	}

	/**
	 * [loadDatabaseConfig Chargement des informations de connexions à la BDD]
	 * @return [type] [description]
	 */
	public function loadDatabaseConfig() {
		$database_filename = APP_DIR.'Config/database.php';
		if(!file_exists($database_filename)) throw new Exception("Le fichier de configuration de la BDD est introuvable");

		require_once $database_filename;
		if(!isset($database)) throw new Exception("Données de connexion BDD manquantes");
		if(!isset($database['host']) OR empty($database['host'])) throw new Exception("Hôte BDD manquant");
		if(!isset($database['db_name']) OR empty($database['host'])) throw new Exception("Nom BDD manquant");
		if(!isset($database['user']) OR empty($database['host'])) throw new Exception("User BDD manquant");
		if(!isset($database['pass']) OR empty($database['host'])) throw new Exception("Mot de passe BDD manquant");
		
		$this->host = $database['host'];
		$this->db_name = $database['db_name'];
		$this->db_user = $database['user'];
		$this->db_pass = $database['pass'];
	}

	/**
	 * [getInstance Retourne une instance de PDO]
	 * @return [type] [description]
	 */
	public function getInstance() {
		return $this->pdo;
	}
}