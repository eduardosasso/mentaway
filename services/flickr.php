<?php
	session_start();
	
	$api_key                 = "abf2e4a70a2362dcc429faf6060954a1";
	$api_secret              = "d4e88e847732c369";
	//$default_redirect        = "/mentaway/eduardosasso";
	$permissions             = "read";
	$path_to_phpFlickr_class = "../model/lib/flickr/";

	ob_start();

	require_once("../model/Service.class.php");
	require_once("../model/Controller.php");
	require_once("../util/Message.class.php");

	require_once($path_to_phpFlickr_class . "phpFlickr.php");
	
	//@unset($_SESSION['phpFlickr_auth_token']);
	unset($_SESSION['phpFlickr_auth_token']);

	if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
		$redirect = $_SESSION['phpFlickr_auth_redirect'];
		unset($_SESSION['phpFlickr_auth_redirect']);
	}

	$f = new phpFlickr($api_key, $api_secret);

	if (empty($_GET['frob'])) {
		$_SESSION['username'] = $_REQUEST['username'];
		//$f->auth($permissions, false);
		$url = $f->auth($permissions);
		echo $url;
		
	} else {
		$f->auth_getToken($_GET['frob']);
		
		$controller = new Controller();
		
		$username = $_SESSION['username'];
		
		$service = new Service();
		$service->_id = 'flickr';
		$service->name = 'Flickr';
		$service->token = $_SESSION['phpFlickr_auth_token'];
		
		$response = $controller->add_user_service($username, $service);	
		
		Message::set("Flickr configured... Don't forget to set Geo location on your photos. If you have an iPhone you should definitely check out <a href='http://instagr.am/'>Instagram</a> to do this.");	
		
		header( 'Location: /user/services');
	}

	// if (empty($redirect)) {
	// 			//header("Location: " . $default_redirect);
	// 			echo 'http://' . $default_redirect;
	// 		} else {		
	// 			echo 'http://' . $redirect;
	// 			//header("Location: " . $redirect);
	// 		}
 
?>