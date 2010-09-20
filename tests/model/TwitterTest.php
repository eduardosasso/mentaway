<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/Twitter.class.php");
require_once("$root/model/DatabaseFactory.php");

//phpunit tests/model/TwitterTest.php
class TwitterTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			// $db = DatabaseFactory::get_provider();
			// 
			// $db->clean_database();
			
			$username = 'eduardosasso';

			$twitter = new Twitter();
			$placemarks = $twitter->get_updates($username);
			
			print_r($placemarks);
		}
		
		public function xxxtest_validate() {
			$username = 'eduardosassox';

			$twitter = new Twitter();
			$placemarks = $twitter->validate($username);			
		}	
		
		public function xxxtest_twitpic_replace() {
			$pattern = "#http://twitpic.com/(\w+)#";
			
			$text = "Mentaway Sneak Peak Source Code :-) #m http://twitpic.com/2qdh1d";
			
			$res = preg_replace($pattern ,'', $text);
			$res = preg_replace('/#m/' ,'', $res);
			$res = preg_replace('/#mentaway/' ,'', $res);
			echo trim($res);
			
			//$res = preg_match('#http://twitpic.com/(\w+)#',$text, $matches);
			
			//print_r($matches);
		}

}
?>