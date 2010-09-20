<?php 
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Placemark.class.php");

class Twitter extends AbstractService { 

	public function get_updates($username){
		// $consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";								 
		// $consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";

		$servicename = 'twitter';

		$controller = new Controller();

		$service = $controller->get_user_service($username, $servicename);
		//$twitter_user = $service->token;
		$twitter_user = 'eduardosasso';

		$twitter_url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=$twitter_user";

		$tweets = file_get_contents($twitter_url);

		$tweets = json_decode($tweets);
		
		$placemarks = array();

		foreach ($tweets as $key => $tweet) {

			//tem q ter geo habilitado + hash #m para identificar tweet do mentway
			if (isset($tweet->geo)) {
				$timestamp = strtotime($tweet->created_at);
				print_r($tweet);
			}

			// $placemark = new Placemark();
			// $placemark->_id = $timestamp . '|' . $checkin->venue->name;
			// $placemark->name = $checkin->venue->name;
			// $placemark->image = $icon;
			// $placemark->description = $shout;
			// $placemark->date = $checkin->created;
			// $placemark->timestamp = $timestamp;
			// $placemark->lat = $checkin->venue->geolat;
			// $placemark->long = $checkin->venue->geolong;
			// $placemark->service = $servicename;
			// $placemark->user = $username;
			// 
			// $placemarks[] = $placemark;
			// 
			// parent::save($placemark);
		}

		return $placemarks;

	}
}
?>