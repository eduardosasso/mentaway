<?php

$controller = new Controller();
$user_id = $session['uid'];

$page_url = $_SERVER['QUERY_STRING'];
$which_page = "/(settings|timeline|new|user)/";

preg_match($which_page, $page_url, $page_requested);
$page_requested = $page_requested[0];

Notification::clean_counter($user_id);

switch ($page_requested) {
	case 'new':
		$user = $controller->new_user();
		$username = $user->_id;

		$page = "settings";
		
		break;
	case 'settings':	
		$user = $controller->get_user($user_id);
		$username = $user->_id;

		$page = "settings";
		
		break;
	case 'user':
		//recupera o user do query string entre /....&
		preg_match("/\/(.*?)&/", $page_url, $matches);
		$user_id_ = $matches[1];
		
		$user = $controller->get_user($user_id_);
		$username = $user->_id;
		$user_id = $user->_id;
		
		$placemarks = $controller->get_placemarks($username);
		
		$page = "timeline";
		
		break;
		
	default:
		$user = $controller->get_user($user_id);
		$username = $user->_id;
		
		$placemarks = $controller->get_timeline($username);
		
		$page = "timeline";
		break;
}


?>

<div id="container">	
	<header id="main-header">
		<?php include "page/header.php"; ?>
		<?php include "page/menu.php"; ?>		
	</header>

	<div id="page" class="<?php echo $page ?>">
		<?php include "page/messages.php"; ?>
		<?php include "page/$page.php"; ?>
	</div>
</div>