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
require_once("DatabaseFactory.php");

class Controller {
	
	function get_placemarks($user){
		$db = DatabaseFactory::get_provider();
		$placemarks = $db->get_placemarks($user);

		return $placemarks->rows;
	}
	
	function get_posts($user){
		$posts = $this->backend->get_posts($user);
		return $posts;
	}
		
	function get_user($username){
		$db = DatabaseFactory::get_provider();
		$user = $db->get_user($username);
		return $user;
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