<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Flickr extends AbstractService { 
	
	public function get_updates($username){
		$key_secret = Settings::get_flickr_oauth_key();		
		
		$api_key = $key_secret[0];
		$api_secret = $key_secret[1];
		
		$servicename = 'flickr';
		
		$controller = new Controller();
		
		$trip = $controller->get_current_trip($username);
		
		//mysql datetime format YYYY-MM-DD HH:MM:SS
		$date_trip = date("Y-m-d G:i:s", strtotime($trip->begin));
		
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
			$placemark->_id = $timestamp . "|$username|flickr";
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