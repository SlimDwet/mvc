<?php

class HomeController extends MyController {
	
	protected $models = array('Home');

	public function index() {
		echo "<h1>Je suis la Home</h1>";
	}

}