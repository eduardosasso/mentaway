<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/facebook_places_test.php
class Facebook_Places_Test extends PHPUnit_Framework_TestCase {
	public function xtest_get_updates() {
		$db = DatabaseFactory::get_provider();

		$username = '631466850';

		$places = new Facebook_Places();
		$placemarks = $places->get_updates($username);

		//print_r($placemarks);

	}
	
	public function xtest_api(){
		 
		preg_match("/[^\/]*$/", "http://www.facebook.com/gisele.muller", $matches);
		
		echo "<pre>";
		print_r($matches[0]);
		echo "</pre>";

		return;
		
		
		$key_secret = Settings::get_facebook_oauth_key();
		$username = '100000032825630';

			$facebook = new Facebook(array(
				'appId' => $key_secret[0],
				'secret' => $key_secret[1],
				'cookie' => true
				));

			$controller = new Controller();
			$user = $controller->get_user($username);

			$access_token =  array('access_token' => $user->token);
			$me = $facebook->api('/me', 'GET', $access_token);
			
			echo "<pre>";
			print_r($me);
			echo "</pre>";
		
	}
}
?>