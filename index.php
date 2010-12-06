<?php
	require('twitter-login.php');
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
  <link rel="shortcut icon" href="favicon.ico"> 
  <link rel="apple-touch-icon" href="/apple-touch-icon.png"> 
 
  <!-- CSS : implied media="all" --> 
  <link rel="stylesheet" href="<?php echo Helper::auto_version('/css/style.css'); ?>">
 
  <!-- For the less-enabled mobile browsers like Opera Mini --> 
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=1"> 
 
 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects --> 
  <script src="js/modernizr-1.5.min.js"></script> 
 
</head> 

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
 
<!--[if lt IE 7 ]> <body class="ie6 login-register"> <![endif]--> 
<!--[if IE 7 ]>    <body class="ie7 login-register"> <![endif]--> 
<!--[if IE 8 ]>    <body class="ie8 login-register"> <![endif]--> 
<!--[if IE 9 ]>    <body class="ie9 login-register"> <![endif]--> 
<!--[if (gt IE 9)|!(IE)]><!--> <body class="login-register"> <!--<![endif]--> 

	<div id="header"> 
		<a href="http://mentaway.com"><img src="/images/mentaway-logo.png" alt="Mentaway" width="195" height="64" class="logo"/></a>
	</div> 
	
	<div class="wrap">
		
		<?php
			$class = "";
			if (!$messages) {
				$class="hidden";
			}
		?>
		<div id="messages" class='<?php echo "$class $message_type" ?>'>			
			<?php echo $messages ?>
		</div>			

		<div id="login">
			<h2>Sign In</h2>
			
			<div class="help">
				<p>If you have an account just click on the button bellow to log in.</p>
			</div>
			
			<div class="twitter-login-button">			
				<a href='<?php echo $twitter_url ?>' id="twitter-login"><img src='images/sign-in-with-twitter-d.png'  border='0'/></a>	
			</div>	
		</div>

		<div id="register">
			<h2>Register</h2>
			
			<div class="help">
				<p>Use your <strong>invitation code</strong> on the field bellow. <br/> If you don't have one, get yours <strong><a href="http://mentaway.com">here</a></strong>.</p>
			</div>

			<div id="code_block">
				<input type="text" name="code" id="code" placeholder="Invitation Code">				
			</div>

			<div class="twitter-login-button">
				<a href='<?php echo $twitter_url ?>' id="twitter-register"><img src='images/sign-in-with-twitter-d.png'  border='0'/></a>	
			</div>		
		</div>
		
		<div class="clear"></div>
		
	</div>
		
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

  <script src="<?php echo Helper::auto_version('/js/util.js'); ?>"></script>
  <script src="<?php echo Helper::auto_version('/js/login.js'); ?>"></script>
	
	<?php if (Settings::get_env() != Settings::LOCAL): ?>
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
	<?php endif ?>
  
	
</body>
</html>