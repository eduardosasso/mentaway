<?php

// require_once("../model/User.class.php");
// require_once("../model/Controller.php");
// require_once("../model/lib/HelperFunctions.php");

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$username = $_REQUEST['username'];
$fullname = $_REQUEST['fullname'];
$bio = $_REQUEST['bio'];
$email = $_REQUEST['email'];
$site = $_REQUEST['site'];
$location = $_REQUEST['location'];
$maptype = $_REQUEST['maptype'];
$notification = $_REQUEST['notification'];

if (empty($notification)) {
	$notification = 'false';
}

$new_user = new User();
$new_user->username = $username;
$new_user->fullname = $fullname;
$new_user->bio = $bio;
$new_user->email = $email;
$new_user->site = $site;
$new_user->location = $location;
$new_user->maptype = $maptype;
$new_user->notification = $notification;

$controller = new Controller();

$user = $controller->get_user($username);

if ($user) {
	//ta alterando um user, faz um merge
	$new_user = array_remove_empty($new_user);

	$user = (object) array_merge((array)$user, (array)$new_user);
	
} else {
	//user novo, nao vai cair aqui pq eu salvo o user de forma temp.
}

$controller->save_user($user);

if (count($user->services) == 0) {
	echo "/user/services";
} elseif (count($user->trips) == 0) {
	echo "/user/trips";
} else {
	echo "Done. Now go have some fun!";
}


?>
