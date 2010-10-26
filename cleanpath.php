<?php 
session_start();

require_once("model/Controller.php");

$controller = new Controller();

$q = $_REQUEST['q'];

$args = explode("/", $q);

$is_user = $controller->is_user($args[0]);

$safe_pages = array("user");  

if (in_array($args[0], $safe_pages)) {
	//se ta na pagina de user ve se recebeu um segundo arg
	$pages = array("services", "profile", "trips");  
	$page = $args[1];

	if (!in_array($args[1], $pages)) {
		header("Location: /user/profile");
	}	
	
	include("util/Message.class.php");
	
	include($args[0].".php");

} elseif ($is_user) {
	$user = $controller->get_user($args[0]);
	
	$username = $user->username;
	$location = $user->location;
	$fullname = $user->fullname;
	$site = $user->site;
	$bio = $user->bio;
	$picture = $user->picture;
	
	$id = end($args);
	
	/*
		TODO Controle tosco para identificar url bookmarkable, se vem com /numero troca para #numero para testar facebook
	*/
	if (count($args) > 1 && is_int(intval($id))) {
		$app_url = get_app_url();
		$username = $user->username;
		
		$url = "$app_url/$username#$id";
		header("Location: $url");
	} else {
		include("app.php");
	}
	
} else {
	//se nao eh user vai para pagina 404
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