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
	
	public function find_mutual_friends($username){
		$fb_friends = $this->find_facebook_friends($username);
		
		$controller = new Controller();
		$user = $controller->get_user($username);
		
		$mutual_friends = array();
		
		foreach ($fb_friends as $value) {
			echo "<pre>";
			print_r($value['id']);
			echo "</pre>";
			// //procura o amigo do facebook no mentaway
			// 			$friend = $controller->get_user($value['id']);
			// 			if ($friend) {
			// 				$mutual_friends[] = $friend->fullname;
			// 				echo $friend->fullname;
			// 
			// 			}
		}	
		
		return $mutual_friends;
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
			//procura o amigo do facebook no mentaway
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
				
				$this->update_placemarks($friend_obj);
				
				$friends[] = $friend->_id;
			}
		}
		
		//amigos se seguem, eu sigo ele, ele me segue tb dai.
		$friends = array_unique($friends);
		$user->friends = $friends;
		
		//loops no placemarks de cada amigo
		//atualiza o timeline com os novos amigos
		
		$controller->save_user($user);	
		$this->update_placemarks($user);
	}
	
	public function update_placemarks($user) {
		//atualiza o placemark do usuario adicionando seus amigos na lista.
		$controller = new Controller();
		$placemarks = $controller->get_placemarks($user->_id);
		
		if (isset($user->friends)) {
			foreach ($placemarks as $key => $placemark) {
				$placemark->value->friends = $user->friends;

				$controller->save($placemark->value);
			}
		}		
	}
	
}
?>