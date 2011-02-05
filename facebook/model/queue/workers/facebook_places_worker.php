<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Facebook_Places_Worker extends Worker {
	protected function process($data) {
		$username =  $data;
		
		// $key_secret = Settings::get_facebook_oauth_key();
		// 
		// $facebook = new Facebook(array(
		// 	'appId' => $key_secret[0],
		// 	'secret' => $key_secret[1],
		// 	'cookie' => true
		// 	));
		// 
		$controller = new Controller();
		$user = $controller->get_user($username);
		// 
		// $access_token =  array('access_token' => $service->token);
		// 
		// $checkins = $facebook->api('/me/checkins', 'GET', $access_token);
		// 
		// error_log($access_token);
		// 
		
		echo "<pre>";
		print_r($user->token);
		echo "</pre>";
		
		// echo "<pre>";
		// 		print_r($checkins);
		// 		echo "</pre>";
		
		
		
	}
}

$facebook_places = new Facebook_Places();
$facebook_places->run();

?>
