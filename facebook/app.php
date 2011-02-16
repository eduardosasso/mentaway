<?php

$controller = new Controller();
$user_id = $session['uid'];

$page_url = $_SERVER['QUERY_STRING'];
$which_page = "/(settings|timeline|new|user|friends|stats|help)/";

preg_match_all($which_page, $page_url, $page_matches);

$page = $page_matches[0][0];

Notification::clean_counter($user_id);

switch ($page) {
	case 'new':
		$user = $controller->new_user();
		$username = $user->_id;

		$page = "settings";
		
		break;
	case 'settings':	
		$user = $controller->get_user($user_id);
		$username = $user->_id;

		break;
	case 'friends':
		$user = $controller->get_user($user_id);
				
		break;
	case 'stats':
		$user = $controller->get_user($user_id);
		break;	
	case 'user':
		$user_page = $page_matches[0][1];
		
		if (!$user_page) {
			$user_page = "timeline";
		}

		//recupera o user do query string entre /....&
		preg_match("/\/(.*?)[&|\/]/", $page_url, $matches);
		$user_id_ = $matches[1];		
		
		$user = $controller->get_user($user_id_);
		$username = $user->_id;
		$user_id = $user->_id;
		
		switch ($user_page) {
			case 'timeline':
				$placemarks = $controller->get_placemarks($username);
				break;
		}
		
		$page = $user_page;
		
		break;
		
	default:
		$user = $controller->get_user($user_id);
		$username = $user->_id;
		
		$placemarks = $controller->get_timeline($username);
		
		if (empty($page)) {
			$page = "timeline";
		}

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