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
		<p class="number">
			<a href="#" id="states"><?php echo $states ?></a>
		</p>
		<p class="label">States</p>
	</div>
	<div>
		<p class="number">
			<a href="#" id="cities"><?php echo $cities ?></a>
		</p>
		<p class="label">Cities</p>
	</div>
</div>

<img src="/facebook/images/logo.png" alt="Mentaway logo" class="logo">