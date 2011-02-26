<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/DatabaseTest.php
class DatabaseTest extends PHPUnit_Framework_TestCase {
		public function xtest_remove_user_service_items(){
			//$data = array("username"=>"631466850","service"=>"flickr");
			
			$db = DatabaseFactory::get_provider();

			$username = "631466850";
			$service_id = "foursquare";

			$key = array("$username", "$service_id");
			$placemarks = $db->get()->startkey($key)->endkey($key)->getView('placemark','by_service_type');

			foreach ($placemarks->rows as $key => $placemark) {
				$db->get()->deleteDoc($placemark->value);
			}
		}
		
		public function test_inc_counter(){
			$uid = "631466850";
			
			Notification::inc_counter($uid);
			
			// $key_secret = Settings::get_facebook_oauth_key();
			// 
			// $facebook = new Facebook(array(
			// 	'appId' => $key_secret[0],
			// 	'secret' => $key_secret[1],
			// 	'cookie' => true
			// 	));
			// 
			// $username = "1335915461";
			// 
			// $controller = new Controller();
			// $user = $controller->get_user($username);
			// 
			// echo "<pre>";
			// print_r($user->token);
			// echo "</pre>";
			// 
			// $uid = "1335915461";
			// 
			// $facebook->api(array(
			// 	'method' => 'dashboard.setCount',
			// 	'uid' => $uid,
			// 	'count' => 12,
			// 	'access_token' => $user->token
			// 	));
		}
		
		public function xtest_save(){
			$db = DatabaseFactory::get_provider();
			$doc = $db->get()->getDoc("1297254477|631466850|foursquare");
			unset($doc->_rev);
			
			$res = $db->save($doc);
						echo "<pre>";
						print_r($res);
						echo "</pre>";
		}
	
		public function xtest_clean_database_users(){
			$db = DatabaseFactory::get_provider();
			$db->clean_database_users();
		}
		public function xxxtest_find_old_user(){
			$token = '5PY1LKTYUR1LFAQMD2SH4B52JHFIO04XDYPZMQYEKUWB0QWR';
			
			$db = DatabaseFactory::get_provider();
			$user = $db->find_old_user($token);
			
			echo "<pre>";
			print_r($user);
			echo "</pre>";			
		}
		
		public function xtest_get_full_user(){
			$db = DatabaseFactory::get_provider();
			
			$fullname = "Refilmagem";
			
			$users = $db->get_user_full($fullname);
			
			print_r($users);
		}
		
		public function xtest_add_friends(){
			$db = DatabaseFactory::get_provider();
			
			$username = "eduardosasso";
			$friends = array('abduzeedo','gismullr');
			
			$user = $db->add_friends($username, $friends);
			
			echo "<pre>";
			print_r($user);
			echo "</pre>";
			
			
		}
	
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
			$username = "631466850";
			
			$placemarks = $db->get_placemarks($username);
			
			// $key = array("$username", array());
			// $end_key = array("$username");
			// 
			// $placemarks = $db->get()->descending(true)->limit(100)->startkey($key)->endkey($end_key)->getView('placemark','placemarks');
			
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
		
		public function xtest_add_user_trip(){
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
		
		public function xtest_clean_database() {
			$db = DatabaseFactory::get_provider();
			$db->clean_database();
		}
		
		public function test_clean_database_user(){
			$username = '631466850';
			$db = DatabaseFactory::get_provider();
			$db->clean_database_user($username);
		}
		
}
?>

