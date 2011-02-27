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

		if (count((array)$fb_friends) > 0 ) {
			$this->follow_friends($username, $fb_friends);
		}

	}
	
	private function follow_friends($username, $friend_list){
		$controller = new Controller();

		$friends = array();
		
		//percorre lista de amigos do fb para achar amigos no mentaway
		foreach ($friend_list as $value) {
			$friend_id = $value['id'];
						
			//procura o amigo do facebook no mentaway
			$friend = $controller->get_user($friend_id);
			
			if ($friend) {
				//se achou um amigo do facebook no mentaway entao segue...
				$friends[] = $friend->_id;
				
				//faz o meu amigo me seguir tb
				$me = $username;				
				$this->save_user_friends($friend->_id, array($me));
			}
		}
		
		//amigos se seguem, eu sigo ele, ele me segue tb dai.
		$friends = array_unique($friends);
		
		//loops no placemarks de cada amigo
		//atualiza o timeline com os novos amigos
		
		$this->save_user_friends($username, $friends);	
	}
	
	//quando um usuario desinstala a app do facebook, retira ele de amigo dos seus amigos
	public function unfollow_me($username) {
		$controller = new Controller();
		$user = $controller->get_user($username);

		foreach ($user->friends as $friend) {
			$friend_user = $controller->get_user($friend);
			
			$friend_old_friends = array();
			foreach ($friend_user->friends as $old_friend) {
				if ($old_friend != $username) {
					$friend_old_friends[] = $old_friend;
				}			
			}
			
			$friend_user->friends = $friend_old_friends;
			
			$controller->save_user($friend_user);
			
		}
		
	}
	
	public function update_placemarks($username) {
		//atualiza o placemark do usuario adicionando seus amigos na lista.
		$controller = new Controller();
		$placemarks = $controller->get_placemarks($username, 50);

		foreach ($placemarks as $placemark) {
			$data = array("type"=>"friends", "username" => $username, "docid"=> $placemark->value->_id);

			Queue::add('update_checkins_worker', $data);
		}

	}
	
	private function save_user_friends($username, $friends) {
		if (count((array)$friends) > 0) {
			$controller = new Controller();
			$user = $controller->get_user($username);
			
			//so inclui amigos novos
			foreach ($friends as $friend) {
				if (in_array($friend, (array)$user->friends) == false) {
					//quando achar um amigo novo entra aqui uma vez so, e ai autiliza em lote pra ser mais rapido
					$user->friends = array_values(array_unique(array_merge((array)$user->friends, (array)$friends)));
					
					$controller->save($user);

					$this->update_placemarks($username);
					return;
				}
			}			
		}		
	}
	
}
?>