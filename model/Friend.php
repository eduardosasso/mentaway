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
			Log::write($e->getMessage());
		}
	}
	
	public function follow_facebook_friends($username){
		$fb_friends = $this->find_facebook_friends($username);
		$this->follow_friends($username, $fb_friends);
		//Queue::add('stats_worker', $username);
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
	
	private function follow_friends($username, $friend_list){
		$controller = new Controller();

		$friends = array();
		
		//percorre lista de amigos do fb para achar amigos no mentaway
		foreach ($friend_list as $value) {
			$friend_id = $value['id'];
						
			//procura o amigo do facebook no mentaway
			$friend = $controller->get_user($friend_id);
			
			//se achou um amigo do facebook nomentaway entao segue...
			if ($friend) {
				//faz o meu amigo me seguir tb
				$me = $username;
				
				$friend_obj = $friend;
				if (isset($friend_obj->friends)) {
					$friend_friends = $friend_obj->friends;
				}
				
				$friend_friends[] = $me;
				$friend_friends = array_unique($friend_friends);
				
				$controller->save_user_friends($friend_obj->_id, $friend_friends);
				
				$this->update_placemarks($friend_obj->_id, $friend_friends);
				
				$friends[] = $friend->_id;
			}
		}
		
		//amigos se seguem, eu sigo ele, ele me segue tb dai.
		$friends = array_unique($friends);
		
		//loops no placemarks de cada amigo
		//atualiza o timeline com os novos amigos
		
		$controller->save_user_friends($username, $friends);	
		
		//rodar como worker, atualizar o placemark um de cada vez.
		$this->update_placemarks($username, $friends);
	}
	
	public function update_placemarks($username, $friends) {
		
		//atualiza o placemark do usuario adicionando seus amigos na lista.
		$controller = new Controller();
		$placemarks = $controller->get_placemarks($username, 50);
		
		if (count($friends) > 0) {
			foreach ($placemarks as $key => $placemark) {
				$data = array("type"=>"friends", "friends" => $friends, "docid"=> $placemark->value->_id);
				
				Log::write(print_r($data, true));
				
				Queue::add('update_checkins_worker', $data);
			}
		}		
	}
	
}
?>