<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Twitter.class.php");
require_once("$root/model/DatabaseFactory.php");

//phpunit tests/model/TwitterTest.php
class TwitterTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			// $db = DatabaseFactory::get_provider();
			// 
			// $db->clean_database();
			
			$username = 'eduardosasso';

			$twitter = new Twitter();
			$placemarks = $twitter->get_updates($username);
			
			//print_r($placemarks);

		}
}
?>