<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/facebook_places_test.php
class Facebook_Places_Test extends PHPUnit_Framework_TestCase {
	public function test_get_updates() {
		$db = DatabaseFactory::get_provider();

		$username = '631466850';

		$places = new Facebook_Places();
		$placemarks = $places->get_updates($username);

		//print_r($placemarks);

	}
}
?>