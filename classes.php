<?php
	date_default_timezone_set("America/Sao_Paulo");
	
	// Faz o loading dinamico de todas as classes que o sistema precisa.
	// Para utilizar eh so colocar o include abaixo em cada arquivo php
	// include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

	require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/app/Settings.class.php';
	include realpath($_SERVER["DOCUMENT_ROOT"]) . '/lib/autoloader/Autoloader.php';
	
	//se o ambiente é local sempre mostra erros na tela
	if (Settings::get_env() == Settings::LOCAL) {
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);	
	}	
?>