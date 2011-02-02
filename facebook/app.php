<?php

if (isset($_REQUEST['new'])) {
	//se for um novo usuario passa para a tela intermediaria para sincronizar com
	//conta antiga do mentaway
	include "sync-user.php";
	return;
}

if (isset($_REQUEST['services'])) {
	if (isset($_REQUEST['add'])) {
		include "services/foursquare.php";
	}
	return;
}


$page = "timeline";

if (isset($_REQUEST['settings'])) {
	//include "settings.php";
	$page = "settings";
}

?>

<div id="container">	
	<header id="main-header">
		<?php include "page/header.php"; ?>
		<?php include "page/menu.php"; ?>		
	</header>

	<div id="page" class="<?php echo $page ?>">
		<?php include "page/$page.php"; ?>
	</div>

	<div id="sidebar">
		<?php include "ads.php"; ?>		
	</div>
</div>