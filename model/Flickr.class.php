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
		
		foreach ($photos['photo'] as $key => $photo) {
			//http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}_[mstb].jpg
			$image_url = 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_t.jpg';
			
			$description = '';
			$info = $f->photos_getInfo($photo['id']);
			if (isset($info['description'])) {
				$description = $info['description'];
			}
			
			$timestamp = strtotime($photo['datetaken']);
			
			$placemark = new Placemark();
			$placemark->_id = $timestamp . '|flickr';
			$placemark->name = $photo['title'];
			$placemark->image = $image_url;
			$placemark->description = $description;
			$placemark->date = $photo['datetaken'];
			$placemark->timestamp = $timestamp;
			$placemark->lat = $photo['latitude'];
			$placemark->long = $photo['longitude'];
			$placemark->service = 'flickr';
			$placemark->user = $username;
			
			$placemarks[] = $placemark;

			parent::save($placemark, $username);
		}
	}	
}
?>