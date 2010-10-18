<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// require_once("model/Service.class.php");
// require_once("model/Controller.php");

// session_start();
// 

function auth_callback(){	
	$oauth_token = isset($_REQUEST['oauth_token']) ? $_REQUEST['oauth_token'] : '';
	//$username = $_REQUEST['username'];

	//se o token vier populado significa que eh o callback do oauth
	if ($oauth_token) {

		$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

		$twitterObj->setToken($oauth_token,$_SESSION['secret']);

		$token = $twitterObj->getAccessToken();

		//$foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);	

		$controller = new Controller();

		// $username = $_SESSION['username'];
		// 
		// $service = new Service();
		// $service->_id = 'foursquare';
		// $service->name = 'Foursquare';
		// $service->token = $token->oauth_token;
		// $service->secret = $token->oauth_token_secret;
		// 
		// $response = $controller->add_user_service($username, $service);

		header( 'Location: '  . '/user/' . $username);	

		// echo $token->oauth_token;
		// 	echo "<br>";
		// 	echo $token->oauth_token_secret;

		/*
			TODO aqui eh o momento de atualizar o usuario e incluir o novo servico...
			e fazer um redirect para a pagina do usuario...
		*/

	}	
	
} 


function get_auth_url(){		
	require_once("model/lib/twitter/EpiCurl.php");
	require_once("model/lib/twitter/EpiOAuth.php");
	require_once("model/lib/twitter/EpiTwitter.php");
	
	$consumer_key = "4H54L27rDeG7Waz1HKdfsA";
	$consumer_secret = "syl1r1YxIoFQDSku0zbY0kY96eHOCoifAO60V7aHxc";
	

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	$authenticate_url = $twitterObj->getAuthenticateUrl();

	return $authenticate_url;

}

?>
