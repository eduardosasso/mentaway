<?php
/*
	TODO Essa pagina de html tem q ser generica... talvez com template.
*/

?>
<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">

  <!-- www.phpied.com/conditional-comments-block-downloads/ -->
  <!--[if IE]><![endif]-->

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Mentaway</title> 
  <meta name="description" content="Mentaway is a service that helps people to keep track of their trips around the world and share their adventures and discoveries with friends and family"> 
  <meta name="author" content="Eduardo Sasso">   

  <!--  Mobile Viewport Fix
        j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
  device-width : Occupy full width of the screen in its current orientation
  initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
  maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
  -->
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">


  <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="/css/style.css?v=1">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="/css/handheld.css?v=1">

 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="/js/modernizr-1.5.min.js"></script>

</head>


<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="user-page ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="user-page ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="user-page ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="user-page ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body class="user-page"> <!--<![endif]-->
	
	<div id="fb-root"></div>
	
	<input type="hidden" value="<?php echo $user->username ?>" id="username">
	
	<div id="header"> 
		<div class="wrap"> 			
			<a href="/<?php echo $user->username ?>" id="logo"><img src="/images/mentaway-logo.png" alt="Mentaway" width="195" height="64"/></a> 

			<div id="user">
				<a href="/<?php echo $user->username ?>"><img src="<?php echo $user->picture ?>" /></a>
				<?php echo $username_and_or_user_menu ?>
				<p class="location"><?php echo $user->location ?></p>
				<p class="url"><a href="<?php echo $user->site ?>"><?php echo $user->site ?></a></p>
			</div>	
			
		</div> 

	</div> 
	
	<div class="content">
		
		<?php	$user_page = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $user->username; ?>

		<?php echo $messages ?>
				
		<div id="panel_user">
			
			<?php echo $registration_steps ?>
			
			<!--
			TODO melhor eh cada tipo (services, profile e trips) ter sua propria pagina, tem q usar templates para padronizar header e outros detalhes comuns
			-->
			<?php if ($page == 'services'): ?>
				<?php
					$username = $user->username;
					$foursquare = $controller->get_user_service($username,'foursquare');
					$twitter = $controller->get_user_service($username,'twitter');
					$flickr = $controller->get_user_service($username,'flickr');
					$posterous = $controller->get_user_service($username,'posterous');

					$has_foursquare = !empty($foursquare);
					$has_twitter = !empty($twitter);
					$has_flickr = !empty($flickr);
					$has_posterous = !empty($posterous);
					
					$help = "<strong>Click on the service image</strong> to <strong>Add</strong> or <strong>Remove</strong> a service. 
										<p>If you add Flickr you have to <strong>to add geo-location to your photos</strong> so we can put them automatically on your map.
										<strong><a href='http://www.flickr.com/help/map/#204' TARGET='_blank'>Click here</a></strong> to see how to configure.</p>
										
										<p>If you add <strong>Twitter</strong> you have to include <strong>#m</strong> to your tweets and also <strong>enable geo-location</strong>. 
										<strong><a href='http://support.twitter.com/articles/118492-new-how-to-tweet-with-your-location-on-mobile-devices' TARGET='_blank'>Click here</a></strong> to see how to configure.</p> 
					
										<p>If you have a <strong>Posterous</strong> account you can setup and use Mentaway as your travel blogging. 
										Just <strong>add the tag Mentaway</strong> to your posts and we take care of the rest.</p>
										
										<p><strong>Tip:</strong> If you have an iPhone check out <strong><a href='http://instagr.am/' TARGET='_blank'>Instagram</a></strong>, it makes really easy to take pictures and upload them to Flickr with <strong>geo-location</strong>
										and also have Twitter and Foursquare integration which makes it a great tool for populating your Mentaway.</p>
										
										<p>More services like Gowalla, Facebook, Tumblr and others will be included in the future.</p>
										<p>Your Mentaway page is: <strong><a href='$user_page' TARGET='_blank'>$user_page</a></strong>";
				?>

			<div id="services_block" class="list-services">
				<h3>Choose your services</h3>
				<ul>
					<li class="foursquare">
						<?php if (!$has_foursquare): ?>
							<a href="#" id="foursquare" class="add_user_service add">Add Foursquare</a>
						<?php else: ?>
							<a href="#" class="remove_user_service remove" id="foursquare">Remove Foursquare</a>
						<?php endif ?>					
					</li>
					<li class="flickr">
						<?php if (!$has_flickr): ?>
							<a href="#" id="flickr" class="add_user_service add">Add Flickr</a>
						<?php else: ?>
							<a href="#" class="remove_user_service remove" id="flickr">Remove Flickr</a>
						<?php endif ?>					
					</li>				
					<li class="twitter">
						<?php if (!$has_twitter): ?>
							<a href="#" id="twitter" class="add_user_service add">Add Twitter</a>
						<?php else: ?>
							<a href="#" class="remove_user_service remove" id="twitter">Remove Twitter</a>
						<?php endif ?>					
					</li>
					<li class="posterous">
						<?php if (!$has_posterous): ?>
							<a href="#" id="posterous" class="add">Add Posterous</a>
						<?php else: ?>
							<a href="#" class="remove_user_service remove" id="posterous">Remove Posterous</a>
						<?php endif ?>					
					</li>
				</ul>

				<div id="posterous_block" class="hidden">
					<input type="text" placeholder="Posterous URL"	value="" id="posterous_url">
					<input type="button" value="Add" id="add_posterous">
					<span class="tip">Ex: http://<strong>yoursite</strong>.posterous.com</span>
				</div>

				<input type="submit" id="submit_service" value="Save" class="submit">
			</div>
		<?php endif ?> 

		<?php if ($page == 'profile'): ?>
			<?php				
				$help = "Update your profile info. <p>Fields marked with <strong>*</strong> are required.</p>
									<p>If you are a <strong>new user</strong> this will be a <strong>quick three steps process.</strong></p>
									<p>Don't forget to <strong>setup your services</strong> otherwise we won't be able to fetch your updates.</p>
									<p>Your Mentaway page is: <strong><a href='$user_page' TARGET='_blank'>$user_page</a></strong>";
			?>
			
			<div id="profile_block">
				<h3>Configure your profile</h3>
				
				<form>
					<div id="username">
						<label for="username">Username</label>
						<input type="text" name="username" value="<?php echo $user->username ?>" class="required" readonly>
						<span class="tip">http://<?php echo $_SERVER['HTTP_HOST'] ?>/<strong><?php echo $user->username ?></strong></span>
					</div>

					<div id="avatar">
						<!-- <span class="">&nbsp;</span> -->
						<img src="<?php echo $user->picture ?>" alt="User picture" border="0" />
					</div>					
					
					<div id="email">
						<label for="email">Email *</label>
						<input type="email" name="email" value="<?php echo $user->email ?>" class="required email">
					</div>

					<div id="fullname">
						<label for="fullname">Full Name *</label>
						<input type="text" name="fullname" value="<?php echo $user->fullname ?>" class="required">
					</div>	

					<div id="bio">
						<label for="bio">Short Bio</label>
						<textarea name="bio"><?php echo $user->bio ?></textarea>
					</div>

					<div id="site">
						<label for="site">Site</label>
						<input type="url" name="site" value="<?php echo $user->site ?>">
					</div>

					<div id="location">
						<label for="location">Where do you live?</label>
						<input type="text" name="location" value="<?php echo $user->location ?>">
					</div>

					<div id="maptype_block">
						<label for="maptype">Map Type</label>
						<select name="maptype" id="maptype">
							<option value="ROADMAP">Map</option>
							<option value="SATELLITE">Satellite</option>
							<option value="HYBRID">Hybrid</option>
							<option value="TERRAIN">Terrain</option>
						</select>
					</div>

					<div id="options">
						<div id="notification">
							<input type="checkbox" class="checkbox" name="notification" value="true" checked="<?php echo $user->notification ?>" />Receive notifications (not spam)
						</div>

						<div id="follow" class="hidden">
							<input type="checkbox" class="checkbox" value="true" checked="true" />Follow Mentaway on Twitter
						</div>

					</div>

					<input type="submit" id="submit_profile" value="Save" class="submit">
				</form>				
			</div>
		<?php endif ?>

		<?php if ($page == 'trips'): ?>
			<?php
				$help = "Mentaway is in beta, so we are trying to figure it out the best way to explore this feature.
									<p><strong>Tip:</strong> You can set a past date on the begin date of your trip, this way we can collect checkins and pictures taken on a previous trip for example.</p>
									<p>If you just want to play with just type anything on the Trip's name so we can get you up un running...</p>
									<p>Your Mentaway page is: <strong><a href='$user_page' TARGET='_blank'>$user_page</a></strong>";
			?>
			<div id="trip_block">
				<h3>Set your trip</h3>
				<form>
					<div id="name">
						<label for="name">Give your trip a name *</label>
						<textarea name="name" class="required"><?php echo $trip->name; ?></textarea>
						<span class="tip">Ex: Trip to Europe or Road trip, you got the idea</span>
					</div>

					<div id="begin">
						<label for="begin">Begin date</label>
						<input type="text" name="begin" id="begin_trip_date" class="date" value="<?php echo $trip->begin ?>">
						<span class="tip">Can be a past date</span>						
					</div>

					<div id="end">
						<label for="end">End date</label>
						<input type="text" name="end" id="end_trip_date" class="date" value="<?php echo $trip->end ?>">
					</div>

					<div class="current hidden">
						<input type="checkbox" class="checkbox" value="true" name="current" checked="<?php echo $trip->current ?>" />Make it active
					</div>

					<input type="submit" id="submit_trip" value="Save" class="submit">

				</form>
			</div>			
		<?php endif ?>		

	</div> 

	<?php if ($help): ?>
		<div class="help-sidebar">
			<h6>Help</h6>
			<p><?php echo $help ?></p>
		</div>
	<?php endif ?>
	
</div>
	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
	<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js"></script>
	
	<script type="text/javascript" charset="utf-8">
			$('#map_type').val('<?php echo $user->maptype ?>');
	</script>

	<script src="/js/util.js?v=1"></script>
  <script src="/js/user.js?v=1"></script>
  <script src="/js/user-ui.js?v=1"></script>

  <!--[if lt IE 7 ]>
    <script src="js/dd_belatedpng.js?v=1"></script>
  <![endif]-->

  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
       change the UA-XXXXX-X to be your site's ID -->
  <script>
   var _gaq = [['_setAccount', 'UA-18487026-1'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>
  
</body>
</html>