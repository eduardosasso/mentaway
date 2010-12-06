<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

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