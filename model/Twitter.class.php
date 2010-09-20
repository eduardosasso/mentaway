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
		$pattern = '/#mentaway/';
		$pattern_short = '/#m/';

		foreach ($tweets as $key => $tweet) {
			$text = $tweet->text;
			
			//tem q ter geo habilitado + hash #m para identificar tweet do mentway
			if (isset($tweet->geo) && (preg_match($pattern,$text) > 0 || preg_match($pattern_short,$text) > 0)) {
				$timestamp = strtotime($tweet->created_at);

				$lat = $tweet->geo->coordinates[0];
				$long = $tweet->geo->coordinates[1];
				
				$placemark = new Placemark();
				$placemark->_id = $timestamp . '|twitter';
				$placemark->name = $text;
				//$placemark->image = $icon;
				//$placemark->description = $shout;
				$placemark->date = $tweet->created_at;
				$placemark->timestamp = $timestamp;
				$placemark->lat = $lat;
				$placemark->long = $long;
				$placemark->service = $servicename;
				$placemark->user = $username;
				
				$placemarks[] = $placemark;
				
				// parent::save($placemark);
			}
		}
				
		print_r($placemarks);

		return $placemarks;

	}
}
?>