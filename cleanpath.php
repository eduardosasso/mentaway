<?php 
session_start();

require_once("model/Controller.php");
require_once("model/View.php");

$controller = new Controller();

$q = $_REQUEST['q'];

$args = explode("/", $q);

$is_user = $controller->is_user($args[0]);

$safe_pages = array("user");  

if (in_array($args[0], $safe_pages)) {
	//se ta na pagina de user ve se recebeu um segundo arg
	$pages = array("services", "profile", "trips", "signout");  
	$page = $args[1];
	
	$username = $_SESSION['id'];
	
	$trip = $controller->get_current_trip($username);
	$trip->begin_date = date('m/d/Y', $trip->timestamp);

	if (!in_array($page, $pages)) {
		header("Location: /user/profile");
	}
	
	if ($page == "signout") {
		unset($_SESSION['id']);
		header("Location: /");
	}
	
	include("util/Message.class.php");
	
	include($args[0].".php");

} elseif ($is_user) {
	$user = $controller->get_user($args[0]);
	
	$username_and_or_user_menu = View::show_username_and_menu($user);
	
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