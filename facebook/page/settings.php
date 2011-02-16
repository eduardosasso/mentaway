<?php

$foursquare_active = ($controller->get_user_service($username, 'foursquare') ? 'active' : '');
$twitter_active = ($controller->get_user_service($username, 'twitter') ? 'active' : '');
$flickr_active = ($controller->get_user_service($username, 'flickr') ? 'active' : '');

?>

<section>
	<header>
		<h1>Services synchronization</h1>
		<div>
			<p>Configure the services you want integrate to Mentaway.<br />
			This step is optional. If you don't add any service you can still see your friend's timeline.</p>
		</div>
		
		
	</header>
	
	<div class="services">

		<div id="foursquare" class="service <?php echo $foursquare_active ?>">
			<img src="/facebook/images/foursquare-32x32.png"/>
			<div class="detail">
				<h3>Foursquare</h3>
				<p>Captures all your checkins</p>
				
				<?php if ($foursquare_active): ?>
					<input type="button" value="Remove" class="external" data-url="/services/<?php echo $username ?>/foursquare/remove">
				<?php else: ?>
					<input type="button" value="Add" class="external" data-url="/services/<?php echo $username ?>/foursquare/add">
				<?php endif ?>				
			</div>
		</div>
		
		<div id="twitter" class="service <?php echo $twitter_active ?>">
			<img src="/facebook/images/twitter-32x32.png"/>
			<div class="detail">
				<h3>Twitter</h3>
				<p>Enable geolocation and add #m to your tweets</p>
				
				<?php if ($twitter_active): ?>
					<input type="button" value="Remove" class="external" data-url="/services/<?php echo $username ?>/twitter/remove">
				<?php else: ?>
					<input type="button" value="Add" class="external" data-url="/services/<?php echo $username ?>/twitter/add">
				<?php endif ?>				
			</div>
		</div>
		
		<div id="flickr" class="service <?php echo $flickr_active ?>">
			<img src="/facebook/images/flickr-32x32.png"/>
			<div class="detail">
				<h3>Flickr</h3>
				<p>Include geolocation info to your photos</p>
				
				<?php if ($flickr_active): ?>
					<input type="button" value="Remove" class="external" data-url="/services/<?php echo $username ?>/flickr/remove">
				<?php else: ?>
					<input type="button" value="Add" class="external" data-url="/services/<?php echo $username ?>/flickr/add">
				<?php endif ?>				
			</div>
		</div>
		
	</div>
</section>	

<!-- <a href="/" class="redirect">Ok</a> -->