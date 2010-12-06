<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

set_time_limit(0);

$controller = new Controller();

$username = $_REQUEST['username'];

$user = $controller->get_user($username);

foreach ($user->services as $key => $service) {
	$classname = $service->name;

	$object = new $classname;
	$object->get_updates($username);
}

//retorna o número de registros encontrados... dai quem chamou sabe o q fazer baseado se retornou >1 ou zero
echo count($controller->get_placemarks($username));

//atualiza stats
// $stats = new Stats();
// $stats->get_updates($username);	


?>