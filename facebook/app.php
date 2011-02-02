<?php

if (isset($_REQUEST['new'])) {
	//se for um novo usuario passa para a tela intermediaria para sincronizar com
	//conta antiga do mentaway
	include "sync-user.php";
	return;
}

if (isset($_REQUEST['settings'])) {
	include "settings.php";
	return;
}

?>

<div id="container">	
	<header id="main-header">
		<?php include "header.php"; ?>
	</header>

	<div id="content">
		<div id="map"></div>
		<?php include "placemarks.php"; ?>
	</div>

	<div id="sidebar">
		<?php if (Settings::get_env() == Settings::PROD): ?>
			<?php include "adsense-vertical.php"; ?>	
		<?php endif ?>		
	</div>
</div>