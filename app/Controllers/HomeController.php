<?php

class HomeController extends MyController {
	
	protected $models = array('Home');

	public function index() {
		$this->set(array('prenom' => 'Evans'));
	}

	public function liste() {
		echo "Klass it is baby, yes it is baby !!";
	}

}