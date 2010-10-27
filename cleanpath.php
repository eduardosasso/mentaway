<?php 
session_start();

require_once("model/Controller.php");
require_once("model/View.php");

$controller = new Controller();

$q = $_REQUEST['q'];

$args = explode("/", $q);

//solicitou uma pagina do usuario - profile, services, trips ou signout
if ($args[0] == 'user') {
	//se ta na pagina de user ve se recebeu um segundo arg
	$page = $args[1];
	$pages = array("services", "profile", "trips", "signout");  
	
	if (!in_array($page, $pages)) {
		header("Location: /user/profile");
	}
	
	if (empty($_SESSION['id'])) {
		//usuario nao esta logado, redireciona para a home
		header('location: /');
		return;
	}
	
	if ($page == "signout") {
		unset($_SESSION['id']);
		header("Location: /");
	}
	
	$username = $_SESSION['id'];
	
	$user = $controller->get_user($username);
	$trip = $controller->get_current_trip($user->username);
	$username_and_or_user_menu = View::show_username_and_menu($user);
	
	include("util/Message.class.php");
	
	include($args[0].".php");

} else {
	$is_user = $controller->is_user($args[0]);
	
	if ($is_user) {
		$user = $controller->get_user($args[0]);		
		$username_and_or_user_menu = View::show_username_and_menu($user);
		
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