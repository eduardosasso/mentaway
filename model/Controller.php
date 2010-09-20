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
	
	public function get_posts($username) {
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
		
		$service = $this->get_user_service($username, 'posterous');
		$hostname = $service->token;
		
		$posterous = new Posterous();
		$posts_ = $posterous->get_updates($hostname);
		
		$posts = array();
		if ($begin_date && $end_date) {
			foreach ($posts_ as $key => $post) {
				if ($post->timestamp >= $begin_date && $post->timestamp < $end_date) {
					$posts[] = $post;
				}
			}
		} else {
			$posts[] = $posts_[0];
		}
		
		if (count($posts) == 0) {
			$posts[] = $posts_[0];
		}
		
		return $posts;
	}
	
		
	function get_user($username){
		$db = DatabaseFactory::get_provider();
		$user = $db->get_user($username);
		return $user;
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
	
	function add_user_service($username, Service $service) {
		$db = DatabaseFactory::get_provider();

		$response = $db->add_user_service($username, $service);
		
		return $response;		
	}
	
	/*
		TODO tem q criar, ou alterar na mesma funcao
	*/
	function save_user($fields) {		
			$db = DatabaseFactory::get_provider();
			
			/*
				TODO tem q retornar para o usuario para ver se nao deu erro
				fields vem serializado com todos os campos, explodir...
			*/
			$user = new User();
			$user->_id = $fields;
			$user->username = $fields;
			$user->fullname = $fields;
			
			$result = $db->save_user($user);
			
			/*
				TODO tem q tratar melhor para dar uma saida amigavel de erro ou successo para o usuario
			*/
			return $result;
		}
}

?>