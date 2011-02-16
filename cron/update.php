<?php
//Script para atualizar servicos dos usuarios, checkins etc.
//Coloca no Queue para execucao em paralelo


include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$users = $controller->get_all_users();

foreach ($users as $user) {
	$username = $user->value->_id;
	
	Queue::add('facebook_places_worker', $username);
	
	foreach ($user->value->services as $key => $service) {
		$service_name = $service->_id . '_worker';		
		Queue::add($service_name, $username);
	}
}

?>