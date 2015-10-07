<?php

class Errors {

	private static $common_style = 'padding: 10px;';

	public static function init() {
		error_reporting(E_ALL | E_STRICT | E_PARSE);
		set_error_handler('Errors::myErrorHandler');
		set_exception_handler(array('Errors', 'myErrorException'));
	}

	/**
	 * Handler erreur pour un affichage personnalisé
	 */
	public static function myErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
		
		switch ($errno) {
			case E_USER_NOTICE:
				$bg_color = 'rgba(110, 255, 110, 0.29)';
				$color = '#21BA23';
				$title = 'NOTICE';
				break;
			case E_USER_WARNING:
				$bg_color = 'rgba(255, 181, 84, 0.29)';
				$color = '#FFA500';
				$title = 'ATTENTION';
				break;
			case E_USER_ERROR:
				$bg_color = 'rgba(244, 42, 42, 0.29)';
				$color = '#FF0000';
				$title = 'DANGER';
				break;
			default:
				$bg_color = 'white';
				$color = 'black';
				$title = 'ERREUR';
				break;
		}

		$msg = '<div style="'.self::$common_style.'background-color: '.$bg_color.'; border: 2px solid;">';
		$msg .= '<b style="color="'.$color.'">'.$title.' : </b><br><br>';
		$msg .= 'Fichier : <b>'.$errfile.'</b><br>';
		$msg .= 'Ligne : <b>'.$errline.'</b><br><br>';
		$msg .= $errstr;
		$msg .= '</div>';
		echo $msg;
		die;
	}

	/**
	 * Handler exception pour un affichae personnalisé
	 */
	public static function myErrorException($exception) {
		switch ($exception->getCode()) {
			case 1:
				// Message de warning
				$color = '#FFA500';
				$bg_color = 'rgba(255, 181, 84, 0.29)';
				break;
			default:
				// Message de danger
				$color = '#FF0000';
				$bg_color = 'rgba(244, 42, 42, 0.29)';
				break;
		}

		$msg = '<div style="border: 2px solid '.$color.'; background-color: '.$bg_color.'; padding: 10px;">';
		$msg .= '<b>Exception :</b><br>';
		$msg .= 'Fichier : <b>'.$exception->getFile().'</b><br>';
		$msg .= 'Ligne : <b>'.$exception->getLine().'</b><br>';
		$msg .= 'Message : <b>'.$exception->getMessage().'</b>';
		$msg .= '</div><br>';
		echo $msg;
		die;
	}

}