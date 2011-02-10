<?php
$placemarks = $controller->get_timeline($username);

$fb_user_id = array();
?>
<div id="map"></div>

<section id="timeline">
	<?php foreach ($placemarks as $placemark): ?>		
		<?php	$user_picture = "https://graph.facebook.com/". $placemark->value->user . "/picture"; ?>
		
		<article class="item" 
			data-placemark= "<?php echo $placemark->value->name ?>"
			data-user_id= "<?php echo $placemark->value->user ?>"
			data-lat="<?php echo $placemark->value->lat ?>" data-long="<?php echo $placemark->value->long ?>">
			<figure>
				<img src="<?php echo $user_picture; ?>">
			</figure>

			<div>
				<header>							
					<h2><?php echo $placemark->value->fullname; ?></h1>
					<h1><?php echo $placemark->value->name; ?></h1>
					<p class="address">
						<?php if ($placemark->value->city): ?>
							<?php echo $placemark->value->city . ', ' . $placemark->value->state . ' - ' . $placemark->value->country ?>
						<?php endif ?>						
					</p>
				</header>

				<div class="description">
					<?php echo $placemark->value->description; ?>
					<?php if ($placemark->value->service=='flickr'): ?>
						<a href="<?php echo str_replace('_t.','_b.', $placemark->value->image); ?>" class="lightbox">
							<img src="<?php echo str_replace('_t.','_m.', $placemark->value->image); ?>">
						</a>						
					<?php endif ?>
				</div>

				<footer>
					<time datetime="<?php echo $placemark->value->date ?>">
						<?php echo Helper::showdate($placemark->value->timestamp); ?> via <?php echo $placemark->value->service; ?>
					</time>
					<div class="share"></div>
				</footer>
			</div>
		</article>
		<div style="clear:both"></div>

	<?php endforeach ?>
</section>