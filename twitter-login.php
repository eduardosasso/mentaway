<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

// require_once("model/Service.class.php");
// require_once("model/Controller.php");


include 'model/lib/twitter/EpiCurl.php';
include 'model/lib/twitter/EpiOAuth.php';
include 'model/lib/twitter/EpiTwitter.php';

$consumer_key = "4H54L27rDeG7Waz1HKdfsA";
$consumer_secret = "syl1r1YxIoFQDSku0zbY0kY96eHOCoifAO60V7aHxc";

$oauth_token = isset($_REQUEST['oauth_token']) ? $_REQUEST['oauth_token'] : '';
//$username = $_REQUEST['username'];

//se o token vier populado significa que eh o callback do oauth
if ($oauth_token) {
	auth_callback();
}

// session_start();
// 

function auth_callback(){	

		$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
		
		$twitterObj->setToken($oauth_token);
		
		$token = $twitterObj->getAccessToken();
		
		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
		
		// save to cookies
		setcookie('oauth_token', $token->oauth_token);
		setcookie('oauth_token_secret', $token->oauth_token_secret);

		$twitterInfo= $twitterObj->get_accountVerify_credentials();
		
		echo '<pre>';
		print_r($twitterInfo);
		echo '</pre>';
	
} 


function get_auth_url(){		
	$consumer_key = "4H54L27rDeG7Waz1HKdfsA";
	$consumer_secret = "syl1r1YxIoFQDSku0zbY0kY96eHOCoifAO60V7aHxc";

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	$authenticate_url = $twitterObj->getAuthenticateUrl();

	return $authenticate_url;

}

?>
