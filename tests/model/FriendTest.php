<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/FriendTest.php
class FriendTest extends PHPUnit_Framework_TestCase {
	public function test_follow_friends(){
		$username = 'eduardosasso';
		$friend = new Friend();
		$friend->follow_facebook_friends($username);
	}
	
	public function xtest_find_facebook_friends(){
		$username = 'eduardosasso';
		$friend = new Friend();
		
		$friends = $friend->find_facebook_friends($username);
		
		echo "<pre>";
		print_r($friends);
		echo "</pre>";
		
	}
	
}	
	
?>