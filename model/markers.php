<?php 
header("Content-type: application/json");

// error_reporting(E_ALL);
// 
// ini_set('display_errors', TRUE);
// 
// ini_set('display_startup_errors', TRUE);

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
// require_once("$root/model/Placemark.class.php");
require_once("./Backend.php");
require_once("./Placemark.class.php");

 /*
 	TODO 
		tem que pegar os markers do usuario x
		tem que recuperar marcacao baseado em data
 */
	
	$backend = new Backend();
	$placemarks = $backend->get_placemarks();
	print json_encode($placemarks);

?>