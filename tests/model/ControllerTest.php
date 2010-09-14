<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Controller.php");

//phpunit tests/model/PosterousTest.php
class ControllerTest extends PHPUnit_Framework_TestCase {
		public function testAll() {
			$controller = new Controller();
			$controller->print_placemarks('eduardosasso');
		}
}
?>