<?php
session_start();

require_once("../model/Service.class.php");
require_once("../model/Controller.php");

require_once("../model/lib/foursquare/EpiCurl.php");
require_once("../model/lib/foursquare/EpiOAuth.php");
require_once("../model/lib/foursquare/EpiFoursquare.php");

$consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";								 
$consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";

$oauth_token = isset($_REQUEST['oauth_token']) ? $_REQUEST['oauth_token'] : '';
$username = $_REQUEST['username'];

//se o token vier populado significa que eh o callback do oauth
if ($oauth_token) {
	// error_reporting(E_ALL);
	// 	ini_set('display_errors', TRUE);
	// 	ini_set('display_startup_errors', TRUE);
	
	$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);
	
	$foursquareObj->setToken($oauth_token,$_SESSION['secret']);
	
	$token = $foursquareObj->getAccessToken();
	
	//$foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);	
	
	$controller = new Controller();
	
	$username = $_SESSION['username'];
	
	$service = new Service();
	$service->_id = 'foursquare';
	$service->name = 'Foursquare';
	$service->token = $token->oauth_token;
	$service->secret = $token->oauth_token_secret;
	
	$response = $controller->add_user_service($username, $service);

	header( 'Location: '  . '/user/' . $username);	
	
	// echo $token->oauth_token;
	// 	echo "<br>";
	// 	echo $token->oauth_token_secret;
	
	/*
		TODO aqui eh o momento de atualizar o usuario e incluir o novo servico...
		e fazer um redirect para a pagina do usuario...
	*/
	
	

} else {
	try {
		$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);

		$results = $foursquareObj->getAuthorizeUrl();

		$loginurl = $results['url'] . "?oauth_token=" . $results['oauth_token'];

		$_SESSION['secret'] = $results['oauth_token_secret'];
		
		$_SESSION['username'] = $username;

		//retorna a url e faz o redirect pelo js
		echo $loginurl;

	} catch (Execption $e) {
		//If there is a problem throw an exception
	}

}

?>
