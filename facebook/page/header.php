<?php
$profile_picture = "https://graph.facebook.com/". $user_id . "/picture";

$cities = $controller->get_cities_visited($user_id);
$states = $controller->get_states_visited($user_id);
$countries = $controller->get_countries_visited($user_id);

$friends = count($user->friends);
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
	<?php if ($friends >0): ?>
		<div class="friends">
			<p class="number">
				<a href="#"><?php echo $friends ?></a>
			</p>
			<p class="label">Friends</p>
		</div>		
	<?php endif ?>
</div>

<a href="/" class="redirect"><img src="/facebook/images/logo.png" alt="Mentaway logo" class="logo"></a>