<div class="shadow">
	<div id="map"></div>
</div>

<section id="timeline">
	<nav>
		<?php foreach ($placemarks as $placemark): ?>		
			<?php	$user_picture = "https://graph.facebook.com/". $placemark->value->user . "/picture"; ?>

			<article class="item" 
			data-placemark= "<?php echo $placemark->value->name ?>"
			data-xid = "<?php echo str_replace('|','_', $placemark->value->_id) ?>"
			data-user_id= "<?php echo $placemark->value->user ?>"
			data-lat="<?php echo $placemark->value->lat ?>" data-long="<?php echo $placemark->value->long ?>">
			<figure>
				<a href="/user/<?php echo $placemark->value->user; ?>" class="redirect"><img src="<?php echo $user_picture; ?>"></a>
			</figure>

			<div>
				<header>							
					<h2><a href="/user/<?php echo $placemark->value->user; ?>" class="redirect"><?php echo $placemark->value->fullname; ?></a></h1>
						<h1><?php echo Helper::linkify($placemark->value->name); ?></h1>
					</header>

					<div class="description">
						<?php
							$img = '';
							if ($placemark->value->image) {
								$img = $placemark->value->image;
								$img = "<img src='$img'>";
								
								if ($placemark->value->image_url) {
									$image_url = $placemark->value->image_url;
									if ($placemark->value->lightbox == 'true') {
										$class = "class='lightbox'";
									}
									
									$img = "<a href='$image_url' $class>$img</a>";									
								}
							}elseif ($placemark->value->icon) {
								$icon = $placemark->value->icon;
								$img = "<img src='$icon' class='icon'>";
							}
						?>												
						<?php echo $img ?>
						<p class="body"><?php echo Helper::linkify($placemark->value->description); ?></p>
					</div>

					<footer>
						<p class="address">
							<?php if ($placemark->value->country): ?>
								<?php echo Helper::format_location($placemark->value->country, $placemark->value->state, $placemark->value->city); ?>
							<?php endif ?>						
						</p>
						<time datetime="<?php echo $placemark->value->date ?>">
							<?php echo Helper::showdate($placemark->value->timestamp); ?> via <span class="service_name"><?php echo $placemark->value->service; ?></span>
							<a href="#" class="comment_link">Comment</a>
						</time>
						<div class="share"></div>
					</footer>
				</div>
			</article>
			<div style="clear:both"></div>

		<?php endforeach ?>
	</nav>
</section>