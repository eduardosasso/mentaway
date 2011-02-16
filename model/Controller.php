<?php 
/*
	TODO 
		tem que pegar os markers do usuario x
		tem que recuperar marcacao baseado em data
*/

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Controller {
	
	function get_placemarks($username){
		$db = DatabaseFactory::get_provider();
		$placemarks = $db->get_placemarks($username);

		return $placemarks->rows;
	}

	function get_timeline($username){
		$db = DatabaseFactory::get_provider();
		
		$key = array("$username", array());
		$end_key = array("$username");
		
		$timeline = $db->get()->descending(true)->limit(100)->startkey($key)->endkey($end_key)->getView('placemark','timeline');
		
		// $user = $this->get_user($username);
		// 		
		// 		$placemarks = $this->get_placemarks($username);
		// 		
		// 		if (isset($user->friends) && count($user->friends)>0) {
		// 			foreach ($user->friends as $friend) {
		// 				$friend_placemarks = $this->get_placemarks($friend);
		// 				$placemarks = array_merge($placemarks, $friend_placemarks);
		// 			}
		// 		}
		// 		
		// 		usort($placemarks, "Helper::cmp_timestamp");
		
		return $timeline->rows;
	}
	
	function get_placemark($user, $checkin_id) {
		$placemarks = $this->get_placemarks($user);
		return $placemarks[$checkin_id];		
	}
	
	public function get_cities_visited($username) {
		$cities = count((array)$this->get_cities_list($username));
		return $cities;
	}
	
	public function get_countries_visited($username) {
		$countries = count((array)$this->get_countries_list($username));
		return $countries;
	}
	
	public function get_states_visited($username) {
		$states = count((array)$this->get_states_list($username));
		return $states;
	}	
	
	
	public function get_cities_list($username) {
		try {
			$user = $this->get_user($username);
			$cities = $user->trips[0]->status->cities;
			return $cities;			
		} catch (Exception $e) {
		}
	}
	
	public function get_states_list($username) {
		try {
			$user = $this->get_user($username);
			$states = $user->trips[0]->status->states;
			return $states;			
		} catch (Exception $e) {
		}
	}
	
	public function get_countries_list($username) {
		try {
			$user = $this->get_user($username);
			$countries = $user->trips[0]->status->countries;
			return $countries;			
		} catch (Exception $e) {			
		}
	}
	
	public function get_last_place_visited($username){
		try {
			$db = DatabaseFactory::get_provider();
			$key = array("$username", array());
			$end_key = array("$username");

			$last_place = $db->get()->descending(true)->limit(1)->startkey($key)->endkey($end_key)->getView('users','last_place_visited');
			return $last_place->rows[0]->value;
			
		} catch (Exception $e) {
			
		}
	}
	
	public function get_view($design_document, $view_name, $key) {
		$db = DatabaseFactory::get_provider();
		$view = $db->get_view($design_document, $view_name, $key);	
		return $view;
	}
	
	function get_placemarks_starting_from($user, $timestamp){
		$placemarks = $this->get_placemarks($user);
		
		//filtra o placemark e retorna somente os placemarks a partir do timestamp informado
		return array_filter($placemarks, function($id) use ($timestamp) {return ($id->value->timestamp > $timestamp);});
	}
	
	public function get_posts($username) {
		/*
			TODO aqui ta errado tem q ser tipo a funcao abaixo.
		*/
		
		$service = $this->get_user_service($username, 'posterous');
		$hostname = $service->token;
		
		$posterous = new Posterous();
		$posts = $posterous->get_updates($hostname);
		
		return $posts;
	}
	
	public function get_posts_by_interval($username, $begin_date = null, $end_date = null) {
		/*
			TODO refazer data inicial e final e desconsiderar a parte da hora, pegar so data...
		*/
		
		$posterous = new Posterous();
		$posts_ = $posterous->get_updates($username);
		
		if (empty($posts_)) {
			return null;
		}
		
		$posts = array();
		$nearest_post = '';
		
		if ($begin_date && $end_date) {			
			foreach ($posts_ as $key => $post) {
				//procura o post mais proximo da data inicial
				if ($post->timestamp >= $begin_date) {
					$nearest_post = $post;
				}
				if ($post->timestamp >= $begin_date && $post->timestamp < $end_date) {
					$posts[] = $post;
				}
			}
		} else {
			$posts[] = $posts_[0];
		}
		
		//tem usar o post mais proximo baseado na data q o usuario esta, se nao acha usa o ultimo mesmo.
		if (count($posts) == 0 && !empty($nearest_post)) {
			$posts[] = $nearest_post;			
		} else {
			$posts[] = $posts_[0];
		}
		
		return $posts;
	}
	
	public function get_user_full($fullname) {
		$db = DatabaseFactory::get_provider();
		$user = $db->get_user_full($fullname);
		return $user;
	}
	
	public function get_user_by_id($user_id){
		$db = DatabaseFactory::get_provider();
		$user = $db->get_doc($user_id);
		return $user;
	}

	function get_all_users(){
		$db = DatabaseFactory::get_provider();
		$users = $db->get_all_users();
		return $users;
	}
		
	function get_user($username){
		$db = DatabaseFactory::get_provider();
		$user = $db->get_user($username);
		return $user;
	}
	
	function is_user($username) {
		$user = $this->get_user($username);
		
		if (empty($user)) {
			return false;
		} else {
			return true;
		}
	}
	
	//retorna detalhes de acesso ao servico
	function get_user_service($username, $servicename){
		$db = DatabaseFactory::get_provider();
		$user = $db->get_user($username);
		
		foreach ($user->services as $key => $service) {
			if ($service->_id == $servicename) {
				return $service;
			}
		}		
		
		return null;
	}
	
	function remove_user_service($username, $service_id) {
		$db = DatabaseFactory::get_provider();
		
		$response = $db->remove_user_service($username, $service_id);
		
		return $response;		
	}
	
	function add_user_trip($username, $trip) {
		$db = DatabaseFactory::get_provider();

		$response = $db->add_user_trip($username, $trip);
		
		return $response;				
	}
	
	function get_current_trip($username) {
		$db = DatabaseFactory::get_provider();

		$user = $db->get_user($username);
		/*
			TODO fazer com q a trip corrent seja sempre indice zero ou encontrar a trip corrent via loop.
		*/
		$trip = null;
		
		if (count($user->trips) > 0) {
			$trip = $user->trips[0];
		}
		
		return $trip;
	}
	
	function get_current_trip_status($username){
		$trip = $this->get_current_trip($username);
		return $trip->status;
	}
	
	function add_user_service($username, Service $service) {
		$db = DatabaseFactory::get_provider();

		$response = $db->add_user_service($username, $service);
		
		return $response;		
	}
	
	function new_user(){
		$key_secret = Settings::get_facebook_oauth_key();

		$facebook = new Facebook(array(
			'appId' => $key_secret[0],
			'secret' => $key_secret[1],
			'cookie' => true,
			));
		
		$auth_ = $facebook->getSession();
		$fb_user_ = $facebook->api('/me');
		
		//tenta achar um user com esse id no bd
		//se achar é pq é um user antigo q cancelou e voltou novamente
		$user_ = $this->get_user_by_id($fb_user_['id']);
		if (!$user_) {
			$user_ = new User();
		}
		
		//se o usuario tem o vanity name setado entao usa ele como username.
		//facebook.com/username
		$username_ = $fb_user_['name'] . ' ' . $fb_user_['id'];
		if (isset($fb_user_['link'])) {
			preg_match("/[^\/]*$/", $fb_user_['link'], $matches);
			$username_ = $matches[0];
		}
		
		$user_->username = Helper::clean_string($username_);
		
		$token_ = $auth_['access_token'];
		
		$user_->_id = $fb_user_['id'];
		$user_->fullname = $fb_user_['name'];
		$user_->email = $fb_user_['email'];
		$user_->date = date('m/d/Y');
		$user_->token = $token_;	
		
		$saved_user = $this->save_user($user_);
		
		//Adiciona as paginas de blank slate para instrucoes iniciais para os usuarios.
		$message = new Message();
		$message->file = 'blank/timeline.php';
		$message->page = 'timeline';
		$message->uid = $fb_user_['id'];
		$message->persistent = 'true';

		Notification::add($message);
		
		$message = new Message();
		$message->file = 'blank/settings.php';
		$message->page = 'settings';
		$message->uid = $fb_user_['id'];
		$message->persistent = 'true';
		
		Notification::add($message);
		
		//segue meus amigos
		Queue::add('follow_friends_worker', $fb_user_['id']);

		//logo que criou o user manda uma tarefa para o queue ver se ele tem algum checkin no places...
		Queue::add('facebook_places_worker', $fb_user_['id']);		
		
		return $this->get_user_by_id($saved_user->id);
	}

	function save($doc) {
		$db = DatabaseFactory::get_provider();

		$result = $db->save($doc);

		return $result;
	}
	
	function save_user($user) {		
			$db = DatabaseFactory::get_provider();
			
			$result = $db->save_user($user);
			
			return $result;
		}
}

?>