<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Flickr extends AbstractService { 
	
	public function get_updates($username){
		$key_secret = Settings::get_flickr_oauth_key();		
		
		$api_key = $key_secret[0];
		$api_secret = $key_secret[1];
		
		$servicename = 'flickr';
		
		$controller = new Controller();
		
		$service = $controller->get_user_service($username, $servicename);
		
		$f = new phpFlickr($api_key, $api_secret);
		$f->setToken($service->token);
		
		$args = array("extras"=>"geo,date_taken");
		$photos = $f->photos_getWithGeoData($args);
		
		foreach ($photos['photo'] as $key => $photo) {
			//http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}_[mstb].jpg
			$image = 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_m.jpg';
			$image_url = 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_b.jpg';
			
			$description = '';
			$info = $f->photos_getInfo($photo['id']);
			if (isset($info['description'])) {
				$description = $info['description'];
			}
			
			$timestamp = strtotime($photo['datetaken']);
			
			$placemark = new Placemark();
			$placemark->_id = $timestamp . "|$username|flickr";
			$placemark->name = $photo['title'];
			$placemark->image = $image;
			$placemark->image_url = $image_url;
			$placemark->description = $description;
			$placemark->date = $photo['datetaken'];
			$placemark->timestamp = $timestamp;
			$placemark->lat = $photo['latitude'];
			$placemark->long = $photo['longitude'];
			$placemark->service = 'flickr';
			$placemark->lightbox = true;
			$placemark->user = $username;
			
			$placemarks[] = $placemark;

			parent::save($placemark, $username);
		}
	}	
}
?>