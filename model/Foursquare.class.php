<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Foursquare extends AbstractService { 
	
	public function get_updates($username){
		$key_secret = Settings::get_foursquare_oauth_key();
		
		$consumer_key = $key_secret[0];
		$consumer_secret = $key_secret[1];
		
		$servicename = 'foursquare';
		
		$controller = new Controller();
		
		$service = $controller->get_user_service($username, $servicename);
		
		// $foursquare = new EpiFoursquare($consumer_key, $consumer_secret, $service->token, $service->secret);
		// 		
		// 		$history = $foursquare->get('/history.json', array('l' => 250));
		// 		$history = json_decode($history->responseText);
		
		$url = "https://api.foursquare.com/v2/users/self/checkins?limit=250&oauth_token=" . $service->secret;
		
		$res = Helper::http_req($url);
		$history = json_decode($res);
		
		$placemarks = array();
		
		foreach ($history->response->checkins->items as $checkin) {
			
			$shout = '';
			if (isset($checkin->shout)) {
				$shout = $checkin->shout;
			}
			
			$icon = '';
			if (isset($checkin->venue->categories[0]->icon)) {
				$icon = $checkin->venue->categories[0]->icon;
			}
			
			$timestamp = $checkin->createdAt;
			
			$placemark = new Placemark();
			$placemark->_id = $timestamp . "|$username|foursquare";
			$placemark->name = $checkin->venue->name;
			$placemark->icon = $icon;
			$placemark->description = $shout;
			$placemark->date = $checkin->createdAt;
			$placemark->timestamp = $timestamp;
			$placemark->lat = $checkin->venue->location->lat;
			$placemark->long = $checkin->venue->location->lng;
			// $placemark->city = $checkin->venue->location->city;
			// $placemark->state = $checkin->venue->location->state;
			// $placemark->country = $checkin->venue->location->country;
			$placemark->service = $servicename;
			$placemark->user = $username;
			
			if ($checkin->photos->count > 0) {
				$placemark->lightbox = true;
				$placemark->image = $checkin->photos->items[0]->sizes->items[1]->url;
				$placemark->image_url = $checkin->photos->items[0]->sizes->items[0]->url;				
			}
			
			$placemarks[] = $placemark;

			parent::save($placemark, $username);
		}
		
		return $placemarks;
		
	}
}
?>