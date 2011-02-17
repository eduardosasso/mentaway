<?php
	$controller = new Controller();
	
	$bt_label = "Join/Login";
	if ($controller->is_user($session['uid'])) {
		$bt_label = "Login";		
	}
	
	if ($session['uid'] && $controller->is_user($session['uid']) == false) {
		$bt_label = "Join";
	}
	
?>

<div id="main_welcome">
	<header>
		<h1>Mentaway</h1>
		<div class="slogan">
			<h2>Mentaway helps you track your trips and also follow your friends trips.</h2>
			<input type="button" value="Join Mentaway" data-url="<?php echo $auth_url ?>" class="external">
		</div>
	</header>
	<div id="content">
	<section id="txt_1">
		<header><h3>How to use it</h3></header>
		<p>Just use your favorite services like Twitter, Foursquare and Flickr... the rest is with Mentaway,  <strong>Lorem ipsum dolor</strong> sit amet, consectetur adipiicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
	</section>

	<section id="txt_2">
		<header><h3>Supported services</h3></header>
		<p>Just use your favorite services like <strong>Twitter</strong>, <strong>Foursquare</strong> and <strong>Flickr</strong>... the rest is with Mentaway,  Lorem ipsum dolor sit amet, consectetur adipiicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
	</section>

	<section id="txt_3">
		<header><h3>That’s what life is all about!</h3></header>
		<p>Just use your favorite services like Twitter, Foursquare and Flickr... the rest is with <strong>Mentaway</strong>,  Lorem ipsum dolor sit amet, consectetur adipiicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
	</section>
	
	<section id="txt_4">
		<header><h3>Supported services</h3></header>
		<p>Just use your favorite services like <strong>Twitter</strong>, <strong>Foursquare</strong> and <strong>Flickr</strong>... the rest is with Mentaway,  Lorem ipsum dolor sit amet, consectetur adipiicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
	</section>
	</div>
</div>