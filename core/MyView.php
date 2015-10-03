<?php

class MyView {

	protected $styles;
	protected $scripts;

	public function __construct() {}

	/**
	 * [addStyles Ajout des CSS]
	 * @param array $styles [description]
	 */
	public function addStyles($styles) {
		$styles_added = array();
		if(is_array($styles) && !empty($styles)) {
			foreach ($styles as $style) {
				$filename = APP_DIR.'Assets/css/'.$style.'.css';
				if(file_exists($filename)) {
					$styles_added[] = '<link rel="stylesheet" type="text/css" href="'.$filename.'"/>';
				} else throw new Exception('La feuille de style "'.$style.'.css" est introuvable', 1);
				vdd($styles_added);
			}
		} else throw new Exception("Les feuilles de styles sont attendus sous forme de tableau de string)", 1);
		
		$this->styles = $styles_added;
	}

	/**
	 * [addScripts Ajout des scripts]
	 * @param array $scripts [description]
	 */
	public function addScripts($scripts) {
		$scripts_added = array();
		if(is_array($scripts) && !empty($scripts)) {
			foreach ($scripts as $script) {
				$filename = APP_DIR.'Assets/js/'.$script.'.js';
				if(file_exists($filename)) {
					$scripts_added[] = '<script type="text/javascript" src="'.$filename.'"></script>';
				} else throw new Exception('Le script "'.$script.'.js" est introuvable', 1);
			}
		} else throw new Exception("Les scripts sont attendus sous forme de tableau de string)", 1);
		$this->scripts = $scripts_added;
	}

	/**
	 * [getStyles Affiche les CSS ajoutés]
	 * @return [type] [description]
	 */
	public function getStyles() {
		if(!empty($this->styles)) {
			foreach ($this->styles as $style) echo $style;
		}
	}

	/**
	 * [getScripts Affiche les scripts ajoutés]
	 * @return [type] [description]
	 */
	public function getScripts() {
		if(!empty($this->scripts)) {
			foreach ($this->scripts as $script) echo $script;
		}
	}

}