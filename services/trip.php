<?php
// require_once("../model/Trip.class.php");
// require_once("../model/Controller.php");

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$action = $_REQUEST['action'];

switch ($action) {
	case "get":
		get_trip();
		break;
	case "add":
		add_trip();
		break;
	case "status":
		get_current_trip_status();
		break;
}

function add_trip() {
	$username = $_REQUEST['username'];
	$name = $_REQUEST['name'];
	$begin = $_REQUEST['begin'];
	
	if (empty($begin)) {
		$begin = date('m/d/Y');
	}
	
	$end = $_REQUEST['end'];
	/*
		TODO aqui eh pra ter suporte para multiplas trips. Quando setar uma trip para current todas as outras tem q ficar off
	*/
	//$current = $_REQUEST['current'];
	$current = true;
	
	//$date = date('D M d H:i:s O Y');
	
	$controller = new Controller();
	$trip = $controller->get_current_trip($username);
	
	/*
		TODO esse id tem q ser dinamico quando tiver suporte para multiplas trips
	*/
	$trip->_id = 'trip';
	$trip->name = $name;
	$trip->begin = $begin;
	$trip->end = $end;
	
	//$trip->timestamp = strtotime($begin);
	$trip->current = $current;
	
	$controller = new Controller();

	if (!empty($trip->name)) {
		//validacao basica pra ver se o user pelo menos colocou um nome na trip
		/*
			TODO tem q validar no css tb
		*/
		$response = $controller->add_user_trip($username, $trip);
	}

	/*
	TODO Validar a saida para dar uma mensagem amigavel.
	*/
	$user = $controller->get_user($username);
	
	if (count($user->trips) == 0) {
		echo "/user/trips";			
		return;
	};
	
	if (empty($user->email)) {
		echo "/user/profile";
		return;			
	}
	
	if (count($user->services) == 0) {
		echo "/user/services";
		return;
	};
	
	echo 'Trip configured. Everything from now on will be tracked as your current trip.';	
}

function get_trip() {
	/*
		TODO a funcao deve pegar a trip baseado na url + user por exemplo para identificar de qual a trip um placemark eh.
	*/
	$username = $_REQUEST['username'];
	$controller = new Controller();
	$trip =  $controller->get_current_trip($username);
	header("Content-type: application/json");
	print json_encode($trip);
}

function get_current_trip_status(){
	$username = $_REQUEST['username'];
	$controller = new Controller();
	$status =  $controller->get_current_trip_status($username);
	echo $status;
}


?>
