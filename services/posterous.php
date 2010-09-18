<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("../model/Service.class.php");
require_once("../model/Controller.php");
require_once("../model/Posterous.class.php");

$username = $_REQUEST['username'];
$url = $_REQUEST['site'];

//descobre o subdominio do cara no posterous...
$url = parse_url($url);

$hostname = explode('.',$url['host']);
$hostname = $hostname[0];
//--//

$posterous = new Posterous();
$is_valid = $posterous->validate($hostname);

if ($is_valid) {
	
	$service = new Service();
	$service->_id = 'posterous';
	$service->name = 'Posterous';
	$service->token = $hostname;

	$controller = new Controller();
	
	$response = $controller->add_user_service($username, $service);
	
	/*
		TODO Validar a saida para dar uma mensagem amigavel.
	*/
	echo 'Posterous configured... Add tag "mentaway" to your posts';

} else {
		echo 'Invalid Posterous Site';	
}


?>
