<?php

class Database {

	private $host;
	private $db_name;
	private $db_user;
	private $db_pass;
	private $pdo;

	public function __construct() {
		$this->host = DB_HOST;
		$this->db_name = DB_NAME;
		$this->db_user = DB_USER;
		$this->db_pass = DB_PASS;
		try {
			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);
		} catch(PDOException $e) {
			die("Connexion impossible : ".$e->getMessage());
		}
	}

	public function getInstance() {
		return $this->pdo;
	}
}