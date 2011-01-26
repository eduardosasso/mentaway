<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$facebook = new Facebook(array(
	'appId' => '136687686378472',
	'secret' => 'cc7fd1a64d2a02f07622de9355c34de8',
	'cookie' => true,
));

$data = $facebook->getSignedRequest();

//se tiver vazio é pq não autorizou ou não ta logado no fb
if (empty($data['user_id'])) {
	$req_perms = "publish_stream,
								offline_access,
								read_stream,
								user_checkins,
								email,
								user_location,
								user_likes,
								publish_checkins";
	$auth_url = $facebook->getLoginUrl(array("req_perms"=>$req_perms,
																					 "next"=>"http://apps.facebook.com/mentaway/", 
																					 "cancel_url"=>"http://facebook.com"));
	echo("<script> top.location.href='" . $auth_url . "'</script>");
} else {
	$user_id = $data['user_id'];
	include("app.php");
}

?>