<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Foursquare.class.php");

//phpunit tests/model/FoursquareTest.php
class FoursquareTest extends PHPUnit_Framework_TestCase {
		public function testGet_updates() {
			$username = 'eduardosasso';

			$foursquare = new Foursquare();
			$placemarks = $foursquare->get_updates($username);
			
			print_r($placemarks);

		}
}
?>