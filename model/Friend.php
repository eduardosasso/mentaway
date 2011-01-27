<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Friend {
	
	public function find_facebook_friends($username){
		$key_secret = Settings::get_facebook_oauth_key();

		try {
			$facebook = new Facebook(array(
				'appId' => $key_secret[0],
				'secret' => $key_secret[1],
				'cookie' => true
				));

			$controller = new Controller();
			$service = $controller->get_user_service($username, "facebook");

			$access_token =  array('access_token' => $service->token);
			$friends = $facebook->api('/me/friends', 'GET', $access_token);

			return $friends['data'];
			
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}
	
	public function follow_facebook_friends($username){
		$fb_friends = $this->find_facebook_friends($username);
		$this->follow_friends($username, $fb_friends,'facebook');		
	}
	
	private function follow_friends($username, $friend_list, $servicename){
		$controller = new Controller();
		$user = $controller->get_user($username);
		
		$friends = array();
		if (isset($user->friends)) {
			$friends = $user->friends;
		}
		
		foreach ($friend_list as $value) {
			if ($servicename == 'facebook') {
				$friend_id = $value['id'];
			}			
			$friend = $controller->get_user_fbid($friend_id);
			
			if ($friend) {
				$friends[] = $friend;			
			}
		}
		$friends = array_unique($friends);

		// echo "<pre>";
		// print_r($friends);
		// echo "</pre>";
	}
	
}
?>