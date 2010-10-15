<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("model/Controller.php");

$controller = new Controller();

$q = $_REQUEST['q'];

$args = explode("/", $q);

$is_user = $controller->is_user($args[0]);

$safe_pages = array("user", "search", "thread");  

if (in_array($args[0], $safe_pages)) {
	
	include($args[0].".php");

} elseif ($is_user) {
	$user = $args[0];
	
	$id = end($args);
	
	/*
		TODO Controle tosco para identificar url bookmarkable, se vem com /numero troca para #numero para testar facebook
	*/
	if (count($args) > 1 && is_int(intval($id))) {
		$app_url = get_app_url();
		$url = "$app_url/$user#$id";
		header("Location: $url");
	} else {
		include("index.php");
	}
	
} else {
	
	include("404.php");  
}

function get_app_url() {
	$url = 'http://';
	
	$domain = $_SERVER["SERVER_NAME"];
	
	if ($domain == 'localhost') {
		$domain .= '/mentaway'; 
	}

	$url .= $domain;
	
	return $url;
}

?>