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
			$user = $controller->get_user($username);

			$access_token =  array('access_token' => $user->token);
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
			$friend = $controller->get_user($friend_id);
			
			if ($friend) {
				//faz o meu amigo me seguir tb
				$me = $username;
				
				$friend_obj = $friend;
				if (isset($friend_obj->friends)) {
					$friend_friends = $friend_obj->friends;
				}
				
				$friend_friends[] = $me;
				$friend_friends = array_unique($friend_friends);
				$friend_obj->friends = $friend_friends;
				
				$controller->save_user($friend_obj);
				
				$friends[] = $friend->_id;
			}
		}
		
		//amigos se seguem, eu sigo ele, ele me segue tb dai.
		$friends = array_unique($friends);
		$user->friends = $friends;
		
		$controller->save_user($user);		
	}
	
}
?>