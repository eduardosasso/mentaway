<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/DatabaseTest.php
class DatabaseTest extends PHPUnit_Framework_TestCase {
	
		public function xxtest_date_conversion() {
			$time = strtotime('Mon, 5 Jul 10 22:53:21 -3');
			print $time . ' ';
			print date('d/m/y H:i:s',$time); 
			
		}
		
		public function xxxtest_get_all_users() {	
			$db = DatabaseFactory::get_provider();
			
			$users = $db->get_all_users();
			
			print_r($users);
		}
		
		public function xtest_get_placemarks() {	
			$db = DatabaseFactory::get_provider();
			
			$placemarks = $db->get_placemarks('eduardosasso');
			
			print_r($placemarks);

		}
		
		public function xtest_save_user() {
			$db = DatabaseFactory::get_provider();
			
			$user = new User();
			$user->_id = 'rodmaz';
			$user->username = 'rodmaz';
			$user->fullname = 'Rodrigo Mazzilli';
						
			$response = $db->save_user($user);

			print_r($response);
		}
		
		function xxtest_get_user(){
			$username = 'abduzeedo';
			
			$db = DatabaseFactory::get_provider();
			$user = $db->get_user($username);
			
			print_r($response);
		}
		
		public function xtest_add_user_service(){
			$username = 'abduzeedo';
			
			$db = DatabaseFactory::get_provider();
			
			$service = new Service();
			$service->_id = 'twitter';
			$service->name = 'Twitter';
			$service->token = 'twitter';
			$service->secret = 'twitter';
			
			$user->services[] = $service;
			
			$response = $db->add_user_service($username, $service);

			print_r($response);		
		}
		
		public function test_add_user_trip(){
			$username = 'eduardosasso';
			
			$db = DatabaseFactory::get_provider();

			$date = date('D M d H:i:s O Y');
			
			$trip = new Trip();
			$trip->_id = 'trip';
			$trip->name = 'Trip para os States 2010';
			$trip->begin =  $date;
			$trip->current = true;
			
			$response = $db->add_user_trip($username, $trip);
			
			print_r($response);
			
		}
		
		
		public function xtest_remove_user_service(){
			$username = 'abduzeedo';
			$service_id = 'twitter';
			
			$db = DatabaseFactory::get_provider();
			
			$response = $db->remove_user_service($username, $service_id);
			
			print_r($response);
		}
		
		public function xxxtestCleanDatabase() {
			$db = DatabaseFactory::get_provider();
			$db->clean_database();
		}
		
}
?>

