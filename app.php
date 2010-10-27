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
  <meta name="description" content="">
  <meta name="author" content="Eduardo Sasso">

  <meta property="fb:app_id" content="136687686378472"/> 
	<meta property="fb:admins" content="631466850"/>
	<meta property="og:title" content="title title"/>
	<meta property="og:type" content="type"/>
	<meta property="og:url" content="url"/>
	<meta property="og:image" content="http://farm5.static.flickr.com/4085/5091161303_e5ab5d044d_t.jpg"/>
	<meta property="og:site_name" content="Mentaway"/>
	<meta property="og:description" content="Lorem ipsum pro nullam mnesarchum ut, vim ea wisi modus concludaturque, cum id meliore splendide. His ei utroque convenire definitionem, te has eius invenire cotidieque. Nec et velit debitis antiopam, ex elaboraret referrentur per, periculis molestiae scriptorem in sit. Ei erant quidam ornatus mea, clita nostro rationibus eum ea. Ut quot commune assueverit nec, in fabulas senserit maluisset per. Eos ad vero reque dicta, timeam quaeque conclusionemque mel cu, cum in rationibus expetendis consequuntur."/>

	  </head>

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
	<input type="hidden" value="<?php echo $username ?>" id="username">
	
	<div id="map"></div>
	
	<div id="fb-root"></div>
	
	<div id="header">
		<a href="#" id="logo"><img src="images/mentaway-logo.png" alt="Mentaway - Keep tracking of your adventures" /></a>
		
		<div class="wrap">

			<ul id="main-nav">
				<li id="diary"><a href="">Diary</a></li>
				<li class="disabled-feature">History</li>
				<li class="disabled-feature">Stats</li>
			</ul>

			<div id="info">
				<h1></h1>
				<h4 class="trip-status"></h4>
			</div>

			<div id="user">
				<img src="<?php echo $picture ?>" />
				<?php echo $username_and_or_user_menu ?>
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
			<div id="via">
				<span>sent via <a href="#" class="source"></a></span>
			</div>		
			<div class="desc"></div>
		</div>
	</div>

	<div id="navigation">
		<ul>
			<li id="first"><a title="Go to the first visited location on this trip" href="#">First Spot</a></li>
			<li id="previous"><a title="Go to the previous location"href="#">Previous</a></li>
			<li id="next"><a title="Go to the next location" href="#">Next</a></li>
			<li id="last"><a title="Go to the last visited location on this trip" href="#">Last Stop</a></li>
		</ul>

	</div>
	
	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
	
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