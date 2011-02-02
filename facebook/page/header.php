<?php
	$profile_picture = "https://graph.facebook.com/". $user_id . "/picture";
	
	$cities = $controller->get_cities_visited($username);
	$states = $controller->get_states_visited($username);
	$countries = $controller->get_countries_visited($username);

?>

<img src="<?php echo $profile_picture ?>" class="profile">

<div class="stats">
	<div>
		<p class="number">
			<a href="#" id="countries"><?php echo $countries ?></a>
		</p>
		<p class="label">Countries</p>
	</div>
	<div>
		<p class="number"><?php echo $states ?></p>
		<p class="label">States</p>
	</div>
	<div>
		<p class="number"><?php echo $cities ?></p>
		<p class="label">Cities</p>
	</div>
	<div style="clear:both"></div>
</div>

<img src="../images/mentaway-logo.png" alt="Mentaway logo" class="logo">