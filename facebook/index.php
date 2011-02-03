<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mentaway Facebook App</title>
	<link rel="stylesheet/less" href="<?php echo Helper::auto_version('css/facebook.less'); ?>">
	<link rel="stylesheet" href="css/google-wave-scroll.css" type="text/css" media="screen" charset="utf-8" />
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>	
	<script src="js/head.load.min.js"></script>
	<script>
		head.js("https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js",
						"js/less-1.0.41.min.js",
						"http://connect.facebook.net/en_US/all.js",
						"js/scripts.js", 
						"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js",
						"js/google-wave-scrollbar/mousewheel.js",
						"js/google-wave-scrollbar/gwave-scroll-pane-0.1.js",
						"js/underscore-min.js",
						"/js/map.js",
						"js/app.js");						
	</script>
</head>
<body>

<div id="fb-root"></div>
	
<?php

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$key_secret = Settings::get_facebook_oauth_key();

$facebook = new Facebook(array(
	'appId' => $key_secret[0],
	'secret' => $key_secret[1],
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
		"next"=>"http://apps.facebook.com/mentaway/new", 
		"cancel_url"=>"http://facebook.com"));

	include("page/welcome.php");

} else {
	include("app.php");
}

?>
</body>
</html>