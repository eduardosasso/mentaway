<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Foursquare.class.php");

//phpunit tests/model/FoursquareTest.php
class FoursquareTest extends PHPUnit_Framework_TestCase {
		public function testGet_updates() {	
			$object = new Foursquare;
			$placemarks = $object->get_updates();
			print_r($placemarks);
		}
}
?>