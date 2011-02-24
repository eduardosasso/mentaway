<?php
session_start();

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$key_secret = Settings::get_twitter_oauth_key();

$consumer_key = $key_secret[0];
$consumer_secret = $key_secret[1];

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

//se o token vier populado significa que eh o callback do oauth
$oauth_token = $_GET['oauth_token'];
if ($oauth_token) {
	$username = $_SESSION['username'];

	$controller = new Controller();

	try {
		$twitterObj->setToken($oauth_token);

		$token = $twitterObj->getAccessToken();

		$service = new Service();
		$service->_id = 'twitter';
		$service->name = 'Twitter';
		$service->token = $token->oauth_token;
		$service->secret = $token->oauth_token_secret;

		$response = $controller->add_user_service($username, $service);

	} catch (Exception $e) {
		Log::write($e->getMessage());
	}

	// Twitter::follow_mentaway($username);	
	// 	Twitter::shout($username,"I just added Twitter to my @mentaway account. http://goo.gl/Sggu5");

	header("Location: http://apps.facebook.com/mentaway/settings");	

} else {
	if ($action == 'add') {
		$_SESSION['username'] = $username;

		$oauth_url = $twitterObj->getAuthenticateUrl();

		header("Location: $oauth_url");	
	}	
}

?>
