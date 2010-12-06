<?php

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$action = $_REQUEST['action'];
$username = $_REQUEST['username'];
$service = $_REQUEST['service'];

$controller = new Controller();

switch ($action) {
	case "remove":
		$result = $controller->remove_user_service($username, $service);
		echo "ok";
		break;
	case "save":
		$user = $controller->get_user($username);
		
		if (empty($user->email)) {
			echo "/user/profile/$user->username";
			return;			
		}
		
		if (count($user->services) == 0) {
			echo "/user/services/$user->username";
			return;
		};
		
		if (count($user->trips) == 0) {
			echo "/user/trips/$user->username";			
			return;
		};
		
		echo "Done! Services saved.";
		break;	
}


?>
