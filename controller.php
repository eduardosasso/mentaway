<?php 
session_start();

//inclui manual pq esse cara seta variaveis logo apos a classe
include("util/Message.class.php");

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

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
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
				);
		}

		// Finally, destroy the session.
		session_destroy();

		header("Location: /");
	}
	
	$username = $_SESSION['id'];
	
	$user = $controller->get_user($username);
	
	$trip = $controller->get_current_trip($username);
	$username_and_or_user_menu = View::show_username_and_menu($user);

	$registration_steps = View::show_steps_registration($user, $page);

	/*
		TODO recupera as mensagens de erro, ideial era ter um pre-proccess antes de qualquer include para recuperar isso. - drupal
	*/
	$messages = Message::get();
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
						
			if (is_facebook_bot()) {
				$placemark = $controller->get_placemark($username, $id);
								
				//se a requisicao eh feita pela facebook entao so escreve as tags na tela e nada mais.
				echo View::show_facebook_metatags($placemark, $user);
				
			} else {
				$url = "$app_url/$username#$id";

				header("Location: $url");
			}			
			
		} else {
			$logged_in = !empty($_SESSION['id']);

			if ($logged_in) {
				if (count($user->services) == 0) {
					Message::show("Before going to your Mentaway page make sure you include some services otherwise we won't have anything to show :(", Message::ERROR);
					header("Location: /user/services/$user->username");
					return;
				}
				
			}
			
			$messages = Message::get();
			
			include("app.php");
		}

	} else {
		//se nao eh user vai para pagina 404
		include("404.php");  
	}

}

function is_facebook_bot() {

	//$sites = 'Google|Yahoo|msnbot|facebookexternalhit'; // Add the rest of the search-engines 

	$sites = 'facebookexternalhit';

	return (preg_match("/$sites/", $_SERVER['HTTP_USER_AGENT']) > 0) ? true : false;  

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