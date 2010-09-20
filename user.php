<?php
/*
	TODO Essa pagina de html tem q ser generica... talvez com template.
*/
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));
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

	<?php
	/*
		TODO primeira versao tosca de controle de usuarios, melhorar.
		Usar templates para separar logica do visual
	*/
		$user = $_REQUEST['q'];
		
		$user = explode('/',$user);
		$user = $user[1];
		
		require_once("model/Controller.php");
		$controller = new Controller();
		
		$user = $controller->get_user($user);
		
		$username = $user->username;
		
		if (!$user) {
			echo "User not found. Wait to be invited...";
		}
		
	?>

</head>


<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->

	<div id="user">
		<input type="hidden" value="<?php echo $username ?>" id="username">
		
		<?php if ($user): ?>
			<input type="button" value="Add Foursquare" id="foursquare" class="add_user_service">
			
			<div id="posterous_block">
				<input type="text" placeholder="Posterous URL"	value="" id="posterous_url">
				<input type="button" value="Add Posterous" id="add_posterous">
			</div>
		<?php endif ?>

		<!-- <h1>User Page</h1>
		
		<input type="text" placeholder="User Name" value="<?php //echo $user ?>" id="username_field">
		<input type="text" placeholder="Full Name" value="" id="fullname_field">
		
		<input type="button" value="Create New User Account" id="new_user_account">  -->
		
	</div>
		

	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo BASE_URL ?>/js/jquery-1.4.2.min.js"><\/script>')</script>

	<script src="<?php echo BASE_URL ?>/js/plugins.js?v=1"></script>
  <script src="<?php echo BASE_URL ?>/js/script.js?v=1"></script>
	<script type="text/javascript" charset="utf-8">
			base_url = "<?php echo BASE_URL; ?>"
	</script>


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