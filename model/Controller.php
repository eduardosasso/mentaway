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

require_once("./Backend.php");
require_once("./Placemark.class.php");

class Controller {
	private $backend;
	
	function __construct() {
		$this->backend = new Backend();
	}
	
	function print_placemarks(){
		$placemarks = $this->backend->get_placemarks();
		//print json_encode($placemarks);
		print $placemarks;
	}
	
	function print_posts(){
		$posts = $this->backend->get_posts();
		print json_encode($posts);
	}
}

$controller = new Controller();

$action = $_REQUEST['a'];

switch ($action) {
	case "markers":
		$controller->print_placemarks();
		break;
	case "posts":
		$controller->print_posts();
		break;
}

?>