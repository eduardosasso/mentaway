<?php

	// Faz o loading dinamico de todas as classes que o sistema precisa.
	// Para utilizar eh so colocar o include abaixo em cada arquivo php
	// include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

	require_once $_SERVER["DOCUMENT_ROOT"] . '/app/settings.php';
	include $_SERVER["DOCUMENT_ROOT"] . '/lib/autoloader/Autoloader.php';
?>