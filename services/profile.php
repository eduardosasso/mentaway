<?php

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

//sempre edita o usar pq no login eu ja crio ele temporario, aqui só atualiza alguns dados e seta como ativo.
$controller = new Controller();
$user = $controller->get_user($username);

$user->fullname = $fullname;
$user->bio = $bio;
$user->email = $email;
$user->site = $site;
$user->location = $location;
$user->maptype = $maptype;
$user->notification = $notification;
$user->active = true;

$controller->save_user($user);

if (count($user->services) == 0) {
	echo "/user/services/$user->username";
} elseif (count($user->trips) == 0) {
	echo "/user/trips/$user->username";
} else {
	echo "Done. Now go have some fun!";
}


?>
