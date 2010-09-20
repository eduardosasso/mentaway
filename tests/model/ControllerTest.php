<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Controller.php");

//phpunit tests/model/ControllerTest.php
class ControllerTest extends PHPUnit_Framework_TestCase {
		public function xtestAll() {
			$controller = new Controller();
			$controller->print_placemarks('eduardosasso');
		}
		
		public function xtest_get_posts(){
			$username = 'eduardosasso';
			
			$controller = new Controller();
			$posts = $controller->get_posts($username);
			
			print_r($posts);
		}
		
		public function test_get_posts_by_interval(){
			$username = 'eduardosasso';
			
			$controller = new Controller();
			$begin_date = 1281445385;
			$end_date = 1284727310;
			
			$posts = $controller->get_posts_by_interval($username);
			
			print_r($posts);
		}
		
		
		
		public function xtest_get_user_service(){
			$username = 'eduardosasso';
			$servicename = 'foursquare';
			
			$controller = new Controller();
			
			$service = $controller->get_user_service($username, $servicename);
			
			print_r($service);

		}	
}
?>