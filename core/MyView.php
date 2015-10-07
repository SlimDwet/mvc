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
	public function addStyles($styles) {
		
		$styles = (array) $styles;
		if(!empty($styles)) {
			foreach ($styles as $style) {
				$filename = WEB_ROOT.'app/webroot/css/'.$style.'.css';
				if($this->isUrlFileExist($filename)) {
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

		$scripts = (array) $scripts;
		if(!empty($scripts)) {
			foreach ($scripts as $script) {
				$filename = WEB_ROOT.'app/webroot/js/'.$script.'.js';
				if($this->isUrlFileExist($filename)) {
					$this->scripts[] = $filename;
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

	/**
	 * [isUrlFileExist Check si un fichier existe à partir de son URL]
	 * @param  [type]  $file_url [URL du fichier]
	 * @return boolean           [description]
	 */
	private function isUrlFileExist($file_url) {
		$headers = get_headers($file_url);
		return stripos($headers[0], "200 OK") ? true : false;
	}

}