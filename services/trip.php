<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("../model/Trip.class.php");
require_once("../model/Controller.php");

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
	$trip_desc = $_REQUEST['desc'];
	$date = date('D M d H:i:s O Y');

	$trip = new Trip();
	$trip->_id = 'trip';
	$trip->name = $trip_desc;
	$trip->date = $date;
	$trip->timestamp = strtotime($trip->date);
	$trip->current = true;
	
	$controller = new Controller();
	$response = $controller->add_user_trip($username, $trip);

	/*
	TODO Validar a saida para dar uma mensagem amigavel.
	*/
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
