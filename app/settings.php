<?php

$domain = $_SERVER["SERVER_NAME"];

switch ($domain) {
	case 'mentaway.dev':
		$settings = setup_local_env();
		break;
	case 'mentaway.com':
		$settings = setup_prod_env();
		break;
	default:
		$settings = setup_dev_env();
		break;
}

function setup_default_env() {
	$settings = new StdClass;
	$settings->db = "http://localhost:5984/";
	
	return $settings;
}

function setup_local_env(){
	// error_reporting(E_ALL);
	// ini_set('display_errors', TRUE);
	// ini_set('display_startup_errors', TRUE);
	
	$settings = setup_default_env();

	return $settings;	
}


?>