<?php
$placemarks = $controller->get_timeline($user->id);

$fb_user_id = array();
?>

<section id="placemarks">
	<?php foreach ($placemarks as $placemark): ?>
		<?php
			if (empty($avatar[$placemark->key])) {
				$user_fb = $controller->get_user_service($placemark->key, "facebook");
				$fb_user_id[$placemark->key] = $user_fb->secret;
			}
			$user_picture = "https://graph.facebook.com/". $fb_user_id[$placemark->key] . "/picture";
		?>
		<article class="article" 
			data-placemark= "<?php echo $placemark->value->name ?>"
			data-user_id= "<?php echo $fb_user_id[$placemark->key] ?>"
			data-lat="<?php echo $placemark->value->lat ?>" data-long="<?php echo $placemark->value->long ?>">
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
					<div class="share"></div>
				</footer>
			</div>
		</article>
		<div style="clear:both"></div>

	<?php endforeach ?>
</section>