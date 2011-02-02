<?php
session_start();

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$controller = new Controller();

$key_secret = Settings::get_foursquare_oauth_key();

$consumer_key = $key_secret[0];
$consumer_secret = $key_secret[1];

$oauth_token = isset($_REQUEST['oauth_token']) ? $_REQUEST['oauth_token'] : '';

//se o token vier populado significa que eh o callback do oauth
if ($oauth_token) {
	
	$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);
	
	$foursquareObj->setToken($oauth_token,$_SESSION['secret']);
	
	$token = $foursquareObj->getAccessToken();
	
	//$foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);	
	
	$username = $_SESSION['username'];
	
	$service = new Service();
	$service->_id = 'foursquare';
	$service->name = 'Foursquare';
	$service->token = $token->oauth_token;
	$service->secret = $token->oauth_token_secret;
	
	$response = $controller->add_user_service($username, $service);

	header("Location: http://apps.facebook.com/mentaway/settings");	
	
} else {
	try {
		if ($action == 'add') {
			$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);

			$results = $foursquareObj->getAuthorizeUrl();

			$oauth_url = $results['url'] . "?oauth_token=" . $results['oauth_token'];

			$_SESSION['secret'] = $results['oauth_token_secret'];

			$_SESSION['username'] = $username;

			header("Location: $oauth_url");
		} 
	} catch (Execption $e) {
		error_log($e->getMessage());
	}

}

?>
