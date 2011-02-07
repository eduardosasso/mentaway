<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Facebook_Places extends AbstractService { 

	public function get_updates($username){
		$key_secret = Settings::get_facebook_oauth_key();

		$facebook = new Facebook(array(
			'appId' => $key_secret[0],
			'secret' => $key_secret[1],
			'cookie' => true
			));

			$controller = new Controller();
			$user = $controller->get_user($username);
			
			$access_token =  array('access_token' => $user->token);
			
			$checkins = $facebook->api('/me/checkins', 'GET', $access_token);

			foreach ($checkins['data'] as $key => $checkin) {
				$timestamp = strtotime($checkin['created_time']);

				$placemark = new Placemark();
				$placemark->_id = $timestamp . "|$username|places";
				$placemark->name = $checkin['place']['name'];
				if (isset($checkin['message'])) $placemark->description = $checkin['message'];
				
				$placemark->date = $checkin['created_time'];
				$placemark->timestamp = $timestamp;
				$placemark->lat = $checkin['place']['location']['latitude'];
				$placemark->long = $checkin['place']['location']['longitude'];
				$placemark->service = 'facebook';
				$placemark->user = $username;

				$placemarks[] = $placemark;

				parent::save($placemark, $username);
			}
			
		}
}
?>