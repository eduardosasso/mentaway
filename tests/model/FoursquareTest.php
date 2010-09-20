<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Foursquare.class.php");
require_once("$root/model/DatabaseFactory.php");

//phpunit tests/model/FoursquareTest.php
class FoursquareTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			$db = DatabaseFactory::get_provider();
			
			//$db->clean_database();
			
			$username = 'eduardosasso';

			$foursquare = new Foursquare();
			$placemarks = $foursquare->get_updates($username);
			
			//print_r($placemarks);

		}
}
?>