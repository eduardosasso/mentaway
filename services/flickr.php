<?php
session_start();

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

try {
	$key_secret = Settings::get_flickr_oauth_key();		

	$api_key = $key_secret[0];
	$api_secret = $key_secret[1];

	$permissions = "read";

	ob_start();

	unset($_SESSION['phpFlickr_auth_token']);

	if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
		$redirect = $_SESSION['phpFlickr_auth_redirect'];
		unset($_SESSION['phpFlickr_auth_redirect']);
	}

	$f = new phpFlickr($api_key, $api_secret);

	if (empty($_GET['frob'])) {
		$_SESSION['username'] = $username;

		$oauth_url = $f->auth($permissions);

		header("Location: $oauth_url");

	} else {
		$f->auth_getToken($_GET['frob']);

		$controller = new Controller();

		$username = $_SESSION['username'];

		$service = new Service();
		$service->_id = 'flickr';
		$service->name = 'Flickr';
		$service->token = $_SESSION['phpFlickr_auth_token'];

		$response = $controller->add_user_service($username, $service);	

		Queue::add('flickr_worker', $username);

		header("Location: http://apps.facebook.com/mentaway/settings");	
	}
	
} catch (Exception $e) {
		Log::write($e->getMessage());
		//colocar um mensagem de erro como notificacao.

		$message = new Message();
		$message->page = 'settings';
		$message->uid = $username;
		$message->format = 'error';
		$message->body = '<p>There was an error adding Flickr. Please try again, and don\'t hesitate to contact us if it happens again.</p>';
		Notification::add($message);
	
		header("Location: http://apps.facebook.com/mentaway/settings");	
}


?>