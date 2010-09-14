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

require_once("Backend.php");
require_once("Placemark.class.php");
require_once("DatabaseFactory.php");

class Controller {
	private $backend;
	
	function __construct() {
		$this->backend = new Backend();
	}
	
	function print_placemarks($user){
		$db = DatabaseFactory::get_provider();
		$placemarks = $db->get_placemarks($user);
		
		//$placemarks = $this->backend->get_placemarks($user);
		//print json_encode($placemarks);

		print_r($placemarks);

	}
	
	function print_posts($user){
		$posts = $this->backend->get_posts($user);
		print json_encode($posts);
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
}

?>