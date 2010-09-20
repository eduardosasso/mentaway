<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("../model/Trip.class.php");
require_once("../model/Controller.php");

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

// } else {
// 	echo 'Error setting trip.';	
// }

?>
