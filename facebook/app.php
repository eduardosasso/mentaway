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

$user_picture = "https://graph.facebook.com/$user_id/picture";

$controller = new Controller();

$user = $controller->get_user_fbid($user_id);

$placemarks = $controller->get_placemarks($user->username);
/*
	TODO 
		arrumar a view  e trazer ordenado por timestamp desc
		combinar os placemarks dos usuarios em 1 e ordenar
*/

usort($placemarks, "Helper::cmp_timestamp");

//$friends = $facebook->api("me/friends");

//se é usuario usa o php abaixo para todas as operacoes q tem q fazer... para esse new user
?>

<div id="container">
	<header id="main-header">
	<img src="../images/mentaway-logo.png" alt="Mentaway logo">
	<nav>
	<ul>
	<li><a href="#">Friends</a></li>
	<li><a href="#">Profile</a></li>
	</ul>
	</nav>			
	</header>

	<div id="content">
		<div id="map"></div>

		<section id="placemarks">
			<?php foreach ($placemarks as $placemark): ?>
				<article class="article" data-lat="<?php echo $placemark->value->lat ?>" data-long="<?php echo $placemark->value->long ?>">
					<figure>
						<img src="<?php echo $user_picture; ?>">
					</figure>

					<div>
						<header>							
							<h1><?php echo $placemark->value->name; ?></h1>
						</header>

						<div class="description">
							<?php echo $placemark->value->description; ?>
							<?php if ($placemark->value->service=='flickr'): ?>
								<img src="<?php echo str_replace('_t.','_m.', $placemark->value->image); ?>">
							<?php endif ?>
						</div>

						<footer>
							<p class="address"></p>
							<time datetime="<?php echo $placemark->value->date ?>">
								<?php echo Helper::showdate($placemark->value->timestamp); ?> via <?php echo $placemark->value->service; ?>
							</time>
							<div class="share">

							</div>
						</footer>
					</div>
				</article>
				<div style="clear:both"></div>

			<?php endforeach ?>
		</section>

	</div>

	<div id="sidebar">
		<?php include "adsense-vertical.php"; ?>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/google-wave-scrollbar/mousewheel.js"></script>
<script type="text/javascript" src="js/google-wave-scrollbar/gwave-scroll-pane-0.1.js"></script>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script src="<?php echo Helper::auto_version('/js/map.js'); ?>"></script>
<script src="<?php echo Helper::auto_version('js/app.js'); ?>"></script>
