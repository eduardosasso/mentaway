<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Stats.class.php");
require_once("$root/model/Trip.class.php");

//phpunit tests/model/StatsTest.php
class StatsTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			$username = 'kenjiyamamoto';

			$stats = new Stats();
			$stats = $stats->get_updates($username);
			
		}
		
		public function xtest_how_many_days() {
			$stats = new Stats();
			
			$trip_date = strtotime('01/01/2010');
			
			$days = $stats->how_many_days($trip_date);
			
			echo $days;
			
		}
		
		public function xtest_dummy(){
			$trip = new Trip();
			
			$trip->begin = 'a';
			
			if (isset($trip->begin)) {
				echo "set";
			} else {
				echo "unset";
			}
			
			
		}
		
}
?>