<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/FriendTest.php
class FriendTest extends PHPUnit_Framework_TestCase {
	public function test_follow_friends(){
		$username = '631466850';
		
		// $controller = new Controller();
		// 		$user = $controller->get_user($username);
		// 		
		$friend = new Friend();
		$friend->follow_facebook_friends($username);
		//$friend->update_placemarks($user);
	}
	
	public function xtest_find_facebook_friends(){
		//$username = '707970176'; 
		$username = '1106857050';
		$friend = new Friend();
		
		//$friends = $friend->find_facebook_friends($username);
		$friends = $friend->find_mutual_friends($username);
		
		// echo "<pre>";
		// print_r($friends);
		// echo "</pre>";
		
	}
	
}	
	
?>