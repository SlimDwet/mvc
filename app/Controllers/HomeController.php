<?php

class HomeController extends MyController {
	
	protected $models = array('Home');

	public function index() {
		$this->View->addStyles('styles');
		$this->set();
	}

	public function liste($params = null) {
		echo (isset($params)) ? "Paramètre = ".(string) current($params) : '';
	}

}