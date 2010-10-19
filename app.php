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
  <link rel="stylesheet" href="css/style.css?v=1">
  <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.1.css">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=1">

 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/modernizr-1.5.min.js"></script>

	<?php
	/*
		TODO primeira versao tosca de controle de usuarios, melhorar.
	*/
		$user = $_REQUEST['q'];

		/*
			TODO procurar user...
		*/
	?>

	<script type="text/javascript" charset="utf-8">
		user = "<?php echo $username ?>"
	</script>

</head>


<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
	<div id="map"></div>
	<div id="fb-root"></div>
		<div id="header">

			<div class="wrap">
				<a href="#" id="logo"><img src="images/mentaway-logo.png" alt="Mentaway - Keep tracking of your adventures" /></a>

				<ul id="main-nav">
					<li id="diary">Diary</li>
					<li class="disabled-feature">History</li>
					<li class="disabled-feature">Stats</li>
				</ul>

				<div id="info">
					<h1></h1>
				</div>

				<div id="user">
					<img src="<?php echo $picture ?>" />
					<h3><?php echo $fullname ?></h3>
					<p class="location"><?php echo $location ?></p>
					<p class="url"><a href="<?php echo $site ?>"><?php echo $site ?></a></p>
				</div>	

			</div>

		</div>
		
		<div id="panel1">
			
			<div class="column">
				<p class="dates"></p>
				<div id="via">
					<span>sent via <a href="#" class="source"></a></span>
					<div class="icon"></div>
				</div>
				<h2></h2>
				<div class="desc">
					<p></p>
					<div class="clear"></div>
				</div>			
				<div class="share">
					<ul>
						<!-- <li id="tweet"></li>	-->
						<li id="fb-like"></li>
					</ul>
				</div>				
			</div>
			
		</div>
		
		<div id="panel2">
			<div id="close">close</div>
			<div class="column">
				<h2></h2>
				<p class="dates"></p>
				<div class="desc"></div>
			</div>
		</div>
	
		<div id="navigation">
			<ul>
				<li><a href="#" id="first">First Spot</a></li>
				<li><a href="#" id="previous">Previous</a></li>
				<li><a href="#" id="next">Next</a></li>
				<li><a href="#" id="last">Last Stop</a></li>
			</ul>
			
		</div>
	
	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=pt-BR"></script> 
	
	<script src="js/plugins.js?v=1"></script>
	<script src="js/util.js?v=1"></script>
	<script src="js/user.js?v=1"></script>
	<script src="js/panel.js?v=1"></script>
	<script src="js/diary.js?v=1"></script>
	<script src="js/nav.js?v=1"></script>
	<script src="js/map.js?v=1"></script>
  <script src="js/script.js?v=1"></script>

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