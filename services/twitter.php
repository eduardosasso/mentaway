<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("../model/Service.class.php");
require_once("../model/Controller.php");
require_once("../model/Twitter.class.php");

$username = $_REQUEST['username'];
$twitter_user = $_REQUEST['twitter_user'];

$twitter = new Twitter();
$is_valid = $twitter->validate($twitter_user);

if ($is_valid) {
	
	$service = new Service();
	$service->_id = 'twitter';
	$service->name = 'Twitter';
	$service->token = $twitter_user;

	$controller = new Controller();
	
	$response = $controller->add_user_service($username, $service);
	
	/*
		TODO Validar a saida para dar uma mensagem amigavel.
	*/
	echo 'Twitter configured... Add "#m" to your tweets and dont forget to enable geolocation on twitter.';

} else {
		echo 'Invalid Twitter Account';	
}

?>
