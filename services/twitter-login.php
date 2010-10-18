<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include 'model/lib/twitter/EpiCurl.php';
include 'model/lib/twitter/EpiOAuth.php';
include 'model/lib/twitter/EpiTwitter.php';

$consumer_key = "4H54L27rDeG7Waz1HKdfsA";
$consumer_secret = "syl1r1YxIoFQDSku0zbY0kY96eHOCoifAO60V7aHxc";

try {
	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	echo '<a href="' . $twitterObj->getAuthenticateUrl() . '">Authorize with Twitter</a>';	
} catch (Exception $e) {
	echo $e;
}

?>

