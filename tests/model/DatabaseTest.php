<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/DatabaseFactory.php");
require_once("$root/model/User.class.php");
require_once("$root/model/Service.class.php");

//phpunit tests/model/DatabaseTest.php
class DatabaseTest extends PHPUnit_Framework_TestCase {
		public function xxtestAll() {	
			$db = DatabaseFactory::get_provider();
			
			$placemarks = $db->get_placemarks('eduardosasso');
			
			print_r($placemarks);

		}
		
		public function xtest_save_user() {
			$db = DatabaseFactory::get_provider();
			
			$user = new User();
			$user->_id = 'abduzeedo';
			$user->username = 'abduzeedo';
			$user->fullname = 'abduzeedo';
						
			$response = $db->save_user($user);

			print_r($response);
		}
		
		function xxtest_get_user(){
			$username = 'abduzeedo';
			
			$db = DatabaseFactory::get_provider();
			$user = $db->get_user($username);
			
			print_r($response);
		}
		
		public function test_add_user_service(){
			$username = 'abduzeedo';
			
			$db = DatabaseFactory::get_provider();
			
			$service = new Service();
			$service->_id = 'foursquare';
			$service->name = 'Foursquare';
			$service->token = 'token';
			$service->secret = 'secret';
			
			$user->services[] = $service;
			
			$response = $db->add_user_service($username, $service);

			print_r($response);
			
		}
		
		public function xxtestCleanDatabase() {
			$db = DatabaseFactory::get_provider();
			$db->clean_database();
		}
		
		// function(doc) {
		// 		  emit(doc.user, doc);
		// 		}
		
		
}
?>

