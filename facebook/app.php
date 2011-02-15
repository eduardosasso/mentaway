<?php

$controller = new Controller();
$user_id = $session['uid'];

$page_url = $_SERVER['QUERY_STRING'];
$which_page = "/(settings|timeline|new|user|friends)/";

preg_match_all($which_page, $page_url, $page_matches);

$page_requested = $page_matches[0][0];

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
	case 'friends':
		$user = $controller->get_user($user_id);
		$page = "friends";
				
		break;
	case 'user':
		$page = $page_matches[0][1];
		
		if (!$page) {
			$page = "timeline";
		}

		//recupera o user do query string entre /....&
		preg_match("/\/(.*?)[&|\/]/", $page_url, $matches);
		$user_id_ = $matches[1];		
		
		$user = $controller->get_user($user_id_);
		$username = $user->_id;
		$user_id = $user->_id;
		
		switch ($page) {
			case 'timeline':
				$placemarks = $controller->get_placemarks($username);
				break;
		}
		
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