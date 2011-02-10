<?php
//Roda via cron para recuperar atualizacoes dos usuarios etc...

//error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$users = $controller->get_all_users();

foreach ($users as $key => $user) {
	
	Queue::add('facebook_places_worker', $username);
	
	foreach ($user->value->services as $key => $service) {
		Queue::add("$service_worker", $username);
	}
}

?>