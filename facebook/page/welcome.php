<?php
	$controller = new Controller();
	
	$bt_label = "Join/Login";
	if ($controller->is_user($session['uid'])) {
		$bt_label = "Login";		
	}
	
	if ($session['uid'] && $controller->is_user($session['uid']) == false) {
		$bt_label = "Join Mentaway";
	}
	
?>

<div id="main_welcome">
	<header>
		<h1>Mentaway</h1>
		<div class="slogan">
			<h2>Automatically track and organize your travels. For you, friends and familly.</h2>
			<input type="button" value="<?php echo $bt_label ?>" data-url="<?php echo $auth_url ?>" class="external">
		</div>
	</header>
	<div id="content">
	<section id="txt_1">
		<header><h3>How to use it</h3></header>
		<p>Create an account (takes less then a minute) then <strong>add some services</strong> like Foursquare and Flickr.
		Every time you checkin or upload a picture using your <strong>iPhone</strong> or <strong>Android</strong>, Mentaway will organize and track <strong>places</strong> you've <strong>visited</strong> around the world.   
		</p>
	</section>

	<section id="txt_2">
		<header><h3>See where your friends are</h3></header>
		<p>Check up on your friends, see where they have been, how many <strong>places they've visited</strong>.<br /> Get <strong>inspired to travel</strong> more.</p>
	</section>

	<section id="txt_3">
		<header><h3>Auto-magic</h3></header>
		<p>Add the services you would like to keep track of and we will take care of the rest.<br /> <strong>No configuration</strong>, no manual data input. <br /> We like to keep things simple and useful.</p>
	</section>
	
	<section id="txt_4">
		<header><h3>Socialize</h3></header>
		<p>Mentaway <strong>integration with Facebook</strong> makes communication among friends really simple. Comment on something and your friend will <strong>receive a notification</strong> on his Facebook wall.</p>
	</section>
	</div>
</div>