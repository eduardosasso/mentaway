<?php 
require_once("Placemark.class.php");
require_once("Foursquare.class.php");
require_once("Posterous.class.php");

//Esta classe deve abstrair toda a comunicacao com o banco de dados
class Backend { 
	public function get_placemarks($user){
		$placemarks = file_get_contents("../temp/markers.json");
		// $object = new Foursquare;
		// 		$placemarks = $object->get_updates();
		// 
		return $placemarks;
	}
	
	public function get_posts($user) {
		$posterous = new Posterous();
		$posts = $posterous->get_updates();
		return $posts;
	}
	
}

?> 
