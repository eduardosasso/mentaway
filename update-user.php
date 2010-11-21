<?php
//error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$username = 'arasmus';
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