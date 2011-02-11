<?php
//Script para atualizar servicos dos usuarios, checkins etc.
//Coloca no Queue para execucao em paralelo

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$users = $controller->get_all_users();

foreach ($users as $key => $user) {
	
	Queue::add('facebook_places_worker', $username);
	
	foreach ($user->value->services as $key => $service) {
		Queue::add($service->_id . '_worker', $username);
	}
}

?>