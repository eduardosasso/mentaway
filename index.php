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
		user = "<?php echo $user ?>"
	</script>

</head>


<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
	
	<div id="fb-root"></div>
	
	<div id="header">
		<a href="#" id="logo"><img src="images/mentaway-logo.png" alt="Mentaway - Keep tracking of your adventures" /></a>
		<div id="user">
			<img src="http://a1.twimg.com/profile_images/1129099001/avatar-hair_bigger.jpg" />
			<h3>Fabio Sasso</h3>
			<p class="location">San Francisco, CA</p>
			<p class="url"><a href="#">http://abduzeedo.com</a></p>
		</div>	
	</div>
	
	<div id="content">
		<div id="map"></div>
		
		<div id="panel1">
			<div class="column">
				<p class="dates"></p>
				<h2></h2>
				<div class="desc"><p></p></div>
				<!-- <h3>Comments</h3> -->
			</div>
			
			<div id="navigation" class="navigation">
				<ul id="nav">
					<li id="previous" class="previous"></li>
					<li id="next" class="next"></li>
				</ul>
			
				<ul id="main-nav">
					<li id="diary">Diary</li>
					<li class="disabled-feature">History</li>
					<li class="disabled-feature">Stats</li>
				</ul>
				
				<div id="via">
					<span>sent via <a href="#" class="source"></a></span>
					<div class="icon"></div>
				</div>
				
				<div class="share">
					<span>share this on</span>
					<ul>
						<li><a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="abduzeedo">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
					
						<li><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fexample.com%2Fpage%2Fto%2Flike&amp;layout=button_count&amp;show_faces=true&amp;width=90&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
						</li>										
				</div>
		</div>
		</div>
		
		<div id="panel2">
			<div class="column">
				<h2></h2>
				<p class="dates"></p>
				<div class="desc"></div>
			</div>
		</div>
			
	</div>
	
	<!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=pt-BR"></script> 	
  
	<script src="js/plugins.js?v=1"></script>
	<script src="js/util.js?v=1"></script>
	<script src="js/panel.js?v=1"></script>
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