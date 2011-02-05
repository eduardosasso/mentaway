<?php

$controller = new Controller();
$user_id = $data['user_id'];

if (isset($_REQUEST['new'])) {
	//novo usuario. cria a conta e vai para a pagina de settings para incluir servicos.
	$user = $controller->new_user();
	$username = $user->_id;
	
	$page = "settings";
} else {
	$user = $controller->get_user($user_id);
	$username = $user->_id;

	$page = "timeline";
}

if (isset($_REQUEST['settings'])) {
	$page = "settings";
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

	<div id="sidebar">
		<?php include "ads.php"; ?>		
	</div>
</div>