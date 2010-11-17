<?php
//error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("model/Controller.php");
require_once("model/Foursquare.class.php");
require_once("model/Twitter.class.php");
require_once("model/Flickr.class.php");
require_once("model/Stats.class.php");

set_time_limit(0);

$controller = new Controller();

$username = 'tommaso';
$user = $controller->get_user($username);

foreach ($user->services as $key => $service) {
	$classname = $service->name;

	$object = new $classname;
	$object->get_updates($username);
}

//atualiza stats
$stats = new Stats();
$stats->get_updates($username);	


?>