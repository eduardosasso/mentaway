<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("./Placemark.class.php");
require_once("./Foursquare.class.php");

//Esta classe deve abstrair toda a comunicacao com o banco de dados
class Backend { 
	public function get_placemarks(){
		$placemarks = file_get_contents("../temp/markers.json");
		// $object = new Foursquare;
		// 		$placemarks = $object->get_updates();
		// 
		return $placemarks;
	}
}

?> 
