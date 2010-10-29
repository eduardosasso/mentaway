<?php
/*
	TODO Essa pagina de html tem q ser generica... talvez com template.
*/
$script_name = dirname($_SERVER["SCRIPT_NAME"]);
$base_url = '';

if ($script_name != '/') {
	$base_url = dirname($_SERVER["SCRIPT_NAME"]);
}

define('BASE_URL',$base_url);

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

  <title>Mentaway: Explore the world</title>
  <meta name="description" content="">
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
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css?v=1">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="<?php echo BASE_URL ?>/css/handheld.css?v=1">

 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="<?php echo BASE_URL ?>/js/modernizr-1.5.min.js"></script>

</head>


<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body class="user-page"> <!--<![endif]-->
	
	<div id="fb-root"></div>
	
	<input type="hidden" value="<?php echo $user->username ?>" id="username">
	
	<div id="header"> 
		<a href="/<?php echo $user->username ?>" id="logo"><img src="/images/mentaway-logo.png" alt="Mentaway - Keep tracking of your adventures" width="195" height="64"/></a> 
		<div class="wrap"> 			
			<div id="info" > 
				<h1>Account</h1> 
			</div> 

			<div id="user">
				<img src="<?php echo $user->picture ?>" />
				<?php echo $username_and_or_user_menu ?>
				<p class="location"><?php echo $user->location ?></p>
				<p class="url"><a href="<?php echo $user->site ?>"><?php echo $user->site ?></a></p>
			</div>	
			
		</div> 

	</div> 
	
	<?php echo $registration_steps ?>
	
	<div class="messages">
		<?php echo $messages ?>
	</div>	
	
	<div id="panel_user">
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
			?>
			<h3>Choose your services</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam semper, nunc ac commodo sodales</p>

			<div id="services_block" class="list-services">
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
					<input type="button" value="Add Posterous" id="add_posterous">
				</div>

				<input type="submit" id="submit_service">
			</div>
		<?php endif ?> 
		
		<?php if ($page == 'profile'): ?>
			<div id="profile_block">
				<form>
					<label for="username">Username</label>
					<input type="text" name="username" value="<?php echo $user->username ?>">
					
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" value="<?php echo $user->fullname ?>">

					<label for="bio">Short Bio</label>									
					<input type="text" name="bio" value="<?php echo $user->bio ?>">
					
					<label for="email">Email</label>
					<input type="email" name="email" value="<?php echo $user->email ?>">
					
					<label for="site">Site</label>
					<input type="url" name="site" value="<?php echo $user->site ?>">
					
					<label for="location">Home Base</label>
					<input type="text" name="location" value="<?php echo $user->location ?>">
					
					<span class="">Avatar</span>
					<img src="<?php echo $user->picture ?>" alt="User picture" border="0" />
					
					<label for="maptype">Default Map Type</label>
					<select name="maptype" id="maptype">
					  <option value="ROADMAP">Map</option>
					  <option value="SATELLITE">Satellite</option>
					  <option value="HYBRID">Hybrid</option>
					  <option value="TERRAIN">Terrain</option>
					</select>
					
					<input type="checkbox" name="notification" value="true" checked="<?php echo $user->notification ?>" />Receive notifications (not spam)
					
					<input type="submit" id="submit_profile">
				</form>				
			</div>
		<?php endif ?>
		
		<?php if ($page == 'trips'): ?>
			<div id="trip_block">
				<form>
					<h4>Are you going to travel or are already traveling somewhere?</h4>
					<textarea name="name" rows="8" cols="40"><?php echo $trip->name; ?></textarea>
					
					<label for="begin">Begin *</label>
					<input type="text" name="begin" id="begin_trip_date" class="required date" value="<?php echo $trip->begin ?>">
					
					<label for="end">End</label>
					<input type="text" name="end" id="end_trip_date" class="date" value="<?php echo $trip->end ?>">
					
					<input type="checkbox" value="true" name="current" checked="<?php echo $trip->current ?>" />Current trip
					
					<input type="submit" id="submit_trip">
				</form>
			</div>			
		<?php endif ?>		
		
	</div> 

	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
	
	<script type="text/javascript" charset="utf-8">
			base_url = "<?php echo BASE_URL; ?>"
			
			$('#map_type').val('<?php echo $user->maptype ?>');
	</script>

	<script src="<?php echo BASE_URL ?>/js/plugins.js?v=1"></script>
	<script src="<?php echo BASE_URL ?>/js/util.js?v=1"></script>
  <script src="<?php echo BASE_URL ?>/js/user.js?v=1"></script>
  <script src="<?php echo BASE_URL ?>/js/user-ui.js?v=1"></script>


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