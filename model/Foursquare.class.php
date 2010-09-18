<?php 
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Placemark.class.php");

require_once("lib/foursquare/EpiCurl.php");
require_once("lib/foursquare/EpiOAuth.php");
require_once("lib/foursquare/EpiFoursquare.php");

class Foursquare extends AbstractService { 
	
	public function get_updates($username){
		$consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";								 
		$consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";
		
		$servicename = 'foursquare';
		
		$controller = new Controller();
		
		$service = $controller->get_user_service($username, $servicename);
		
		$foursquare = new EpiFoursquare($consumer_key, $consumer_secret, $service->token, $service->secret);
		
		$history = $foursquare->get('/history.json');
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

			parent::save($placemark);
		}
		
		return $placemarks;
		
	}
}
?>