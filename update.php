<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("model/Controller.php");
require_once("model/Foursquare.class.php");
require_once("model/Twitter.class.php");
require_once("model/Flickr.class.php");

$controller = new Controller();

$users = $controller->get_all_users();

foreach ($users as $key => $user) {
	
	foreach ($user->value->services as $key => $service) {
			$username = $user->id;
			$classname = $service->name;
			
			$object = new $classname;
			$object->get_updates($username);
	}
}

?>