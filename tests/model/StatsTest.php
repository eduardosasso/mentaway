<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Stats.class.php");

//phpunit tests/model/StatsTest.php
class StatsTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			$username = 'eduardosasso';

			$stats = new Stats();
			$stats = $stats->get_updates($username);
			
			print_r($placemarks);
		}
}
?>