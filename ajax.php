<?php
session_start();
//Responsavel por transferir as chamadas via ajax para o Controller...

//header("Content-type: application/json");

include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

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
		$begin = $_REQUEST['begin'];
		$end = $_REQUEST['end'];			
		
		if ($begin != 'null' && $end != 'null') {
			$posts = $controller->get_posts_by_interval($user, $begin, $end);
		} else {
			$posts = $controller->get_posts_by_interval($user);
		}
		
		print json_encode($posts);
		
		break;
	case "get_user":
			$user = $controller->get_user($user);
			header("Content-type: application/json");
			print json_encode($user);
			break;	
	case "save_user":
		$fields = $_REQUEST['fields'];
		$result = $controller->save_user($fields);
		print json_encode($result);
		break;	
	case "invite":
		$code = $_REQUEST['code'];
		if (strtolower($code) == '9z3e') {
			$_SESSION['invite'] = true;
			echo "true";			
		} else {
			unset($_SESSION['invite']);
			echo "false";			
		}
		break;
}
?>