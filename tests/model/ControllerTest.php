<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Controller.php");

//phpunit tests/model/ControllerTest.php
class ControllerTest extends PHPUnit_Framework_TestCase {
		public function xtestAll() {
			$controller = new Controller();
			$controller->print_placemarks('eduardosasso');
		}
		
		public function test_get_user_service(){
			$username = 'eduardosasso';
			$servicename = 'foursquare';
			
			$controller = new Controller();
			
			$service = $controller->get_user_service($username, $servicename);
			
			print_r($service);

		}	
}
?>