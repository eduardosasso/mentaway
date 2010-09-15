<?php
require_once("model/lib/foursquare/EpiCurl.php");
require_once("model/lib/foursquare/EpiOAuth.php");
require_once("model/lib/foursquare/EpiFoursquare.php");

//Put in the key and secret for your Foursquare app
//Your values will be different than mine
$consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";
$consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";
$loginurl = "";


session_start();

try{
	$foursquareObj = new EpiFoursquare($consumer_key, $consumer_secret);
	
	$results = $foursquareObj->getAuthorizeUrl();
	
	$loginurl = $results['url'] . "?oauth_token=" . $results['oauth_token'];
	
	$_SESSION['secret'] = $results['oauth_token_secret'];
	
} catch (Execption $e) {
	//If there is a problem throw an exception
}

echo "<a href='" . $loginurl . "'>Add Foursquare</a>";
?>
