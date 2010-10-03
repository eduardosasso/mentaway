<?php 
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Placemark.class.php");

require_once("lib/flickr/phpFlickr.php");

class Flickr extends AbstractService { 
	
	public function get_updates($username){
		$api_key = "abf2e4a70a2362dcc429faf6060954a1";
		$api_secret = "d4e88e847732c369";
		
		$servicename = 'flickr';
		
		$controller = new Controller();
		
		$trip = $controller->get_current_trip($username);
		
		//mysql datetime format YYYY-MM-DD HH:MM:SS
		$date_trip = date("Y-m-d G:i:s", $trip->timestamp);
		
		$service = $controller->get_user_service($username, $servicename);
		
		$f = new phpFlickr($api_key, $api_secret);
		$f->setToken($service->token);
		
		$args = array("extras"=>"geo,date_taken", "min_taken_date"=>$date_trip);
		$photos = $f->photos_getWithGeoData($args);
		
		echo '<pre>';
		print_r($photos);
		echo '</pre>';		
	}	
}
?>