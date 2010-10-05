<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Flickr.class.php");

//phpunit tests/model/FlickrTest.php
class FlickrTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			$username = 'eduardosasso';

			$flickr = new Flickr();
			$placemarks = $flickr->get_updates($username);
		}
		
		
}
?>