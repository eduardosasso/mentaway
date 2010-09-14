<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Foursquare.class.php");

//phpunit tests/model/FoursquareTest.php
class FoursquareTest extends PHPUnit_Framework_TestCase {
		public function sstestGet_updates() {
			$user = 'eduardosasso';

			$foursquare = new Foursquare();
			$placemarks = $foursquare->get_updates($user);
			
			echo '<pre>';
			print_r($placemarks);
			echo '</pre>';
			
			$mongo = new Mongo();
			$db = $mongo->mentaway;
			// 
			$collection = $db->placemark;
			$collection->batchInsert($placemarks);
			//$collection->save($placemarks);
			//$collection->insert($placemark);		

			// print_r($placemarks);
		}
}
?>