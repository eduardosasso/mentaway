<?php
//error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$users = $controller->get_all_users();

foreach ($users as $key => $user) {

	foreach ($user->value->services as $key => $service) {
		$username = $user->id;
		$classname = $service->name;

		$object = new $classname;

		//Faz um Try/catch para o erro nao ser fatal, tenta atualizar todos sempre...
		try {
			$object->get_updates($username);
		} catch (Exception $e) {
			error_log("Problema fazendo update do usuario: $username");
		}
		
	}

	//atualiza stats
	$stats = new Stats();
	$stats->get_updates($username);	
}

?>