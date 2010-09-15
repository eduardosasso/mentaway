<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/DatabaseFactory.php");


//phpunit tests/model/DatabaseTest.php
class DatabaseTest extends PHPUnit_Framework_TestCase {
		public function xxtestAll() {	
			$db = DatabaseFactory::get_provider();
			
			$placemarks = $db->get_placemarks('eduardosasso');
			
			print_r($placemarks);

		}
		
		public function testCleanDatabase() {
			$db = DatabaseFactory::get_provider();
			$db->clean_database();
		}
		
		// function(doc) {
		// 		  emit(doc.user, doc);
		// 		}
		
		
}
?>

