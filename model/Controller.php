<?php 
/*
	TODO 
		tem que pegar os markers do usuario x
		tem que recuperar marcacao baseado em data
*/

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("User.class.php");
require_once("Placemark.class.php");
require_once("Posterous.class.php");
require_once("DatabaseFactory.php");

class Controller {
	
	function get_placemarks($user){
		$db = DatabaseFactory::get_provider();
		$placemarks = $db->get_placemarks($user);

		return $placemarks->rows;
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
		$trip = $user->trips[0];
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
	
	/*
		TODO tem q criar, ou alterar na mesma funcao
	*/
	function save_user($user) {		
			$db = DatabaseFactory::get_provider();
			
			// /*
			// 	TODO tem q retornar para o usuario para ver se nao deu erro
			// 	fields vem serializado com todos os campos, explodir...
			// */
			// $user = new User();
			// $user->_id = $fields;
			// $user->username = $fields;
			// $user->fullname = $fields;
			
			$result = $db->save_user($user);
			
			/*
				TODO tem q tratar melhor para dar uma saida amigavel de erro ou successo para o usuario
			*/
			return $result;
		}
}

?>