<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Posterous.class.php");

//phpunit tests/model/PosterousTest.php
class PosterousTest extends PHPUnit_Framework_TestCase {
		public function xtest_get_updates() {	
			$posterous = new Posterous();
			$posts = $posterous->get_updates('eduardosasso');
			
			print_r($posts);
		}
		
		public function test_validate(){
			$posterous = new Posterous();

			$result = $posterous->validate('fabiosasso');
			
			echo $result;
			
		}
		
}
?>