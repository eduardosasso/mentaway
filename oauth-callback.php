<?php

require_once("model/lib/foursquare/EpiCurl.php");
require_once("model/lib/foursquare/EpiOAuth.php");
require_once("model/lib/foursquare/EpiFoursquare.php");

//Put in the key and secret for your Foursquare app
//Your values will be different than mine
$consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";
$consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";

session_start();

$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);
$foursquareObj->setToken($_REQUEST['oauth_token'],$_SESSION['secret']);
$token = $foursquareObj->getAccessToken();
$foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);

try {
	//Making a call to the API
	$foursquareTest = $foursquareObj->get_user();
	
} catch (Exception $e) {
	echo "Error: " . $e;
}

?>
