<?php
session_start();

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$key_secret = Settings::get_foursquare_oauth_key();

$consumer_key = $key_secret[0];
$consumer_secret = $key_secret[1];

$oauth_token = isset($_REQUEST['oauth_token']) ? $_REQUEST['oauth_token'] : '';
$username = $_REQUEST['username'];

//se o token vier populado significa que eh o callback do oauth
if ($oauth_token) {
	
	$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);
	
	$foursquareObj->setToken($oauth_token,$_SESSION['secret']);
	
	$token = $foursquareObj->getAccessToken();
	
	//$foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);	
	
	$controller = new Controller();
	
	$username = $_SESSION['username'];
	
	$service = new Service();
	$service->_id = 'foursquare';
	$service->name = 'Foursquare';
	$service->token = $token->oauth_token;
	$service->secret = $token->oauth_token_secret;
	
	$response = $controller->add_user_service($username, $service);
	
	Message::Show("Done! We will get all your Foursquare Checkins automatically from now on.");

	header( 'Location: '  . '/user/services/' . $username);	
	
	// echo $token->oauth_token;
	// 	echo "<br>";
	// 	echo $token->oauth_token_secret;
	
	/*
		TODO aqui eh o momento de atualizar o usuario e incluir o novo servico...
		e fazer um redirect para a pagina do usuario...
	*/
	
	

} else {
	try {
		$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);

		$results = $foursquareObj->getAuthorizeUrl();

		$loginurl = $results['url'] . "?oauth_token=" . $results['oauth_token'];

		$_SESSION['secret'] = $results['oauth_token_secret'];
		
		$_SESSION['username'] = $username;

		//retorna a url e faz o redirect pelo js
		echo $loginurl;

	} catch (Execption $e) {
		//If there is a problem throw an exception
	}

}

?>
