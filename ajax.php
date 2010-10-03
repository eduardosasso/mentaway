<?php
//Responsavel por transferir as chamadas via ajax para o Controller...

//header("Content-type: application/json");

require_once("model/Controller.php");

$controller = new Controller();

$action = $_REQUEST['a'];
$user = $_REQUEST['uid'];

/*
	TODO Execucao de metodo e passagem de argumentos podia ser dinamica
*/

switch ($action) {
	case "markers":
		$placemarks = $controller->get_placemarks($user);
		print json_encode($placemarks);		
		break;
	case "posts":
		$begin = '';
		$end = '';
		
		if (!empty($_REQUEST['begin']) && !empty($_REQUEST['end'])) {
			$begin = $_REQUEST['begin'];
			$end = $_REQUEST['end'];			
		}		
		
		$posts = $controller->get_posts_by_interval($user, $begin, $end);
		
		print json_encode($posts);
		
		break;
	case "get_user":
			$user = $controller->get_user($user);
			print json_encode($user);
			break;	
	case "save_user":
		$fields = $_REQUEST['fields'];
		$result = $controller->save_user($fields);
		print json_encode($result);
		break;	
}
?>