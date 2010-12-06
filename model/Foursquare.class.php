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
		
		$foursquare = new EpiFoursquare($consumer_key, $consumer_secret, $service->token, $service->secret);
		
		$history = $foursquare->get('/history.json', array('l' => 250));
		$history = json_decode($history->responseText);
		
		$placemarks = array();
		
		foreach ($history->checkins as $key => $checkin) {
			
			$shout = '';
			if (isset($checkin->shout)) {
				$shout = $checkin->shout;
			}
			
			$icon = '';
			if (isset($checkin->venue->primarycategory->iconurl)) {
				$icon = $checkin->venue->primarycategory->iconurl;
			}
			
			$timestamp = strtotime($checkin->created);
			
			$placemark = new Placemark();
			$placemark->_id = $timestamp . '|' . $checkin->venue->name;
			$placemark->name = $checkin->venue->name;
			$placemark->image = $icon;
			$placemark->description = $shout;
			$placemark->date = $checkin->created;
			$placemark->timestamp = $timestamp;
			$placemark->lat = $checkin->venue->geolat;
			$placemark->long = $checkin->venue->geolong;
			$placemark->service = $servicename;
			$placemark->user = $username;
			
			$placemarks[] = $placemark;

			parent::save($placemark, $username);
		}
		
		return $placemarks;
		
	}
}
?>