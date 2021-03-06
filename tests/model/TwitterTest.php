<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/TwitterTest.php
class TwitterTest extends PHPUnit_Framework_TestCase {
	public function xtest_follow(){
		$username = '631466850';
		Twitter::follow_mentaway($username);
	}
	
	public function xxxtest_shout(){
		$username = '631466850';
		Twitter::shout($username,"Testing twitter from @mentaway");
	}

		public function test_get_updates() {
			// $db = DatabaseFactory::get_provider();
			// 
			// $db->clean_database();
			
			$username = '631466850';

			$twitter = new Twitter();
			$placemarks = $twitter->get_updates($username);
			
			print_r($placemarks);
		}
		
		public function xxxtest_validate() {
			$username = 'eduardosassox';

			$twitter = new Twitter();
			$placemarks = $twitter->validate($username);			
		}	
		
		public function xtest_twitpic_replace() {
			$pattern = "/(http:\/\/twitpic.com\/(\w+))/";
			$ygrog =	"(http:\/\/yfrog.com\/(\w+))";
			$plixi = "(http:\/\/plixi.com\/.+\/(\w+))";
			$instagram = "(http:\/\/instagr.am\/.+\/(\w+))";
			
			$text = "Testing oEmbed support on Mentaway #m http://twitpic.com/41kqqg";
			
			// $res = preg_replace($pattern ,'', $text);
			// $res = preg_replace('/#m/' ,'', $res);
			// $res = preg_replace('/#mentaway/' ,'', $res);
			//echo trim($res);
			
			preg_match($pattern,$text, $matches);
			
			print_r($matches);
		}

}
?>