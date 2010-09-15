<?php 
/*
	TODO 
		tem que pegar os markers do usuario x
		tem que recuperar marcacao baseado em data
*/

header("Content-type: application/json");

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

require_once("User.php");
require_once("Placemark.class.php");
require_once("DatabaseFactory.php");

class Controller {
	
	function print_placemarks($user){
		$db = DatabaseFactory::get_provider();
		$placemarks = $db->get_placemarks($user);
		
		//$placemarks = $this->backend->get_placemarks($user);
		//print json_encode($placemarks);

		print json_encode($placemarks->rows);

		//print_r($placemarks->rows);

	}
	
	function print_posts($user){
		$posts = $this->backend->get_posts($user);
		print json_encode($posts);
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
			
			$user = $db->save_user($user);
			
			/*
				TODO tem q tratar melhor para dar uma saida amigavel de erro ou successo para o usuario
			*/
			print json_encode($user);
		}
	
	
}

$controller = new Controller();

$action = $_REQUEST['a'];
$user = $_REQUEST['uid'];

switch ($action) {
	case "markers":
		$controller->print_placemarks($user);
		break;
	case "posts":
		$controller->print_posts($user);
		break;
	case "save_user":
		$fields = $_REQUEST['fields'];
		$controller->save_user($fields);
		break;	
}

?>