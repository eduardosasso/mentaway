<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Posterous.class.php");

//phpunit tests/model/PosterousTest.php
class PosterousTest extends PHPUnit_Framework_TestCase {
		public function testGet_updates() {	
			$posterous = new Posterous();
			$posts = $posterous->get_updates();
			
			print_r($posts);
		}
}
?>