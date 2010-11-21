<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/PosterousTest.php
class PosterousTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {	
			$posterous = new Posterous();
			$posts = $posterous->get_updates('eduardosasso');
			
			print_r($posts);
		}
		
		public function xtest_validate(){
			$posterous = new Posterous();

			$result = $posterous->validate('fabiosasso');
			
			echo $result;
			
		}
		
}
?>