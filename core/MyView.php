<?php

class MyView {

	private $styles;
	private $scripts;

	public function __construct() {
		$this->styles = array();
		$this->scripts = array();
	}

	/**
	 * [addStyles Ajout des CSS]
	 * @param array $styles [description]
	 */
	public function addStyles($styles = array()) {
		if(!is_array($styles)) throw new Exception("Les feuilles de styles sont attendus sous forme de tableau de string)", 1);
		
		if(!empty($styles)) {
			foreach ($styles as $style) {
				$filename = WEB_ROOT.'app/webroot/css/'.$style.'.css';
				if(file_get_contents($filename)) {
					$this->styles[] = $filename;
				} else throw new Exception('La feuille de style "'.$style.'.css" est introuvable', 1);
			}
		}
	}

	/**
	 * [addScripts Ajout des scripts]
	 * @param array $scripts [description]
	 */
	public function addScripts($scripts) {
		if(!is_array($scripts)) throw new Exception("Les scripts sont attendus sous forme de tableau de string)", 1);

		if(is_array($scripts) && !empty($scripts)) {
			foreach ($scripts as $script) {
				$filename = WEB_ROOT.'app/webroot/js/'.$script.'.js';
				if(file_get_contents($filename)) {
					$this->scripts[] = '<script type="text/javascript" src="'.$filename.'"></script>';
				} else throw new Exception('Le script "'.$script.'.js" est introuvable', 1);
			}
		}
	}

	/**
	 * [getStyles Affiche les CSS ajoutés]
	 * @return [type] [description]
	 */
	public function getStyles() {
		return $this->styles;
	}

	/**
	 * [getScripts Affiche les scripts ajoutés]
	 * @return [type] [description]
	 */
	public function getScripts() {
		return $this->scripts;
	}

}