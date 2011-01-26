<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mentaway Facebook App</title>
  <link rel="stylesheet/less" href="<?php echo Helper::auto_version('css/facebook.less'); ?>">
  <link rel="stylesheet" href="css/google-wave-scroll.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
	<?php
		include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

		$user = "eduardosasso";
		$user_picture = "https://graph.facebook.com/$user_id/picture";
		$controller = new Controller();
		$placemarks = $controller->get_placemarks($user);
		$placemarks = array_reverse($placemarks);	
		
	?>
	
	<div id="container">
		<!-- <header id="main-header">
			<img src="../images/mentaway-logo.png" alt="Mentaway logo">
			<nav>
				<ul>
					<li><a href="#">Friends</a></li>
					<li><a href="#">Profile</a></li>
				</ul>
			</nav>			
		</header> -->
		
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
		
		<footer>

		</footer>
		
	</div>	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
	
	<script src="js/less-1.0.41.min.js"></script>

	<script type="text/javascript" src="js/google-wave-scrollbar/mousewheel.js"></script>
  <script type="text/javascript" src="js/google-wave-scrollbar/gwave-scroll-pane-0.1.js"></script>
  
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	
	<script src="<?php echo Helper::auto_version('/js/map.js'); ?>"></script>
  <script src="<?php echo Helper::auto_version('js/facebook.js'); ?>"></script>
</body>
</html>