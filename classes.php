<?php

	// Faz o loading dinamico de todas as classes que o sistema precisa.
	// Para utilizar eh so colocar o include abaixo em cada arquivo php
	// include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

	require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/app/Settings.class.php';
	include realpath($_SERVER["DOCUMENT_ROOT"]) . '/lib/autoloader/Autoloader.php';
?>