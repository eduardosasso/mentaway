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
		$twitter_user = $service->token;
		//$twitter_user = 'eduardosasso';

		$twitter_url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=$twitter_user";
		
		$tweets = file_get_contents($twitter_url);

		$tweets = json_decode($tweets);
		
		$placemarks = array();
		$pattern = '/#mentaway/';
		$pattern_short = '/#m/';

		foreach ($tweets as $key => $tweet) {
			$text = $tweet->text;
			
			//tem q ter geo habilitado + hash #m para identificar tweet do mentaway
			if (isset($tweet->geo) && (preg_match($pattern,$text) > 0 || preg_match($pattern_short,$text) > 0)) {
				$timestamp = strtotime($tweet->created_at);

				$lat = $tweet->geo->coordinates[0];
				$long = $tweet->geo->coordinates[1];
				
				$twitpic = '#http://twitpic.com/(\w+)#';
				$image = '';
				if (preg_match($twitpic, $text, $matches) > 0) {
					$image = 'http://twitpic.com/show/thumb/' . $matches[1];
				}
				
				//retira hash e image do twitter...
				$text = preg_replace($twitpic ,'', $text);
				$text = preg_replace('/#m/' ,'', $text);
				$text = preg_replace('/#mentaway/' ,'', $text);
				
				$placemark = new Placemark();
				$placemark->_id = $timestamp . '|twitter';
				$placemark->name = trim($text);
				$placemark->image = $image;
				//$placemark->description = $shout;
				$placemark->date = $tweet->created_at;
				$placemark->timestamp = $timestamp;
				$placemark->lat = $lat;
				$placemark->long = $long;
				$placemark->service = $servicename;
				$placemark->user = $username;
				
				$placemarks[] = $placemark;
				
				parent::save($placemark, $username);
			}
		}

		return $placemarks;
	}
	
	public function validate($twitter_user){
		$twitter_url = "http://api.twitter.com/1/users/show.json?screen_name=$twitter_user";
		
		try {
			$info = file_get_contents($twitter_url);
			$result = true;
		} catch (Exception $e) {
			$result = false;
		}
		
		return $result;
		
	}
	
}
?>