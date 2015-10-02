<?php

class Home extends MyModel {

	private $table = 'voiture';

	public function __construct() {
		parent::__construct();
	}

	public function getAll() {
		$this->select()
	}

}