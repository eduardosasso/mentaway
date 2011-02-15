<?php

$cities = (array)$controller->get_cities_list($user_id);
$states = (array)$controller->get_states_list($user->_id);
$countries = (array)$controller->get_countries_list($user->_id);

$countries_formatted = implode('|', $countries);
$states_formatted = implode('|', $states);
$cities_formatted = implode('|', $cities);

$map_countries = 'http://maps.google.com/maps/api/staticmap?size=720x215&maptype=roadmap&markers='. $countries_formatted . '&sensor=false';
$map_states = 'http://maps.google.com/maps/api/staticmap?size=720x215&maptype=roadmap&markers='. $states_formatted . '&sensor=false';
$map_cities = 'http://maps.google.com/maps/api/staticmap?size=720x215&maptype=roadmap&markers='. $cities_formatted . '&sensor=false';

?>

<section id="stats">
	<article id="countries">
		<header>
			<h1><?php echo count($countries) ?> Countries</h1>

			<div>
				<?php foreach ($countries as $country): ?>
					<span><?php echo $country ?></span>
				<?php endforeach ?>
			</div>
		</header>
		
		<div class="share">
			<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="countries_stats_btn">
		</div>
		
		<img src="<?php echo $map_countries ?>">
	</article>
	
	<article id="states">
		<header>
			<h1><?php echo count($states) ?> States</h1>

			<div>
				<?php foreach ($states as $state): ?>
					<span><?php echo $state ?></span>
				<?php endforeach ?>
			</div>			
		</header>

		<div class="share">
			<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="states_stats_btn">
		</div>
		
		<img src="<?php echo $map_states ?>">
	</article>
	
	<article id="cities">
		<header>
			<h1><?php echo count($cities) ?> Cities</h1>

			<div>
				<?php foreach ($cities as $city): ?>
					<span><?php echo $city ?></span>
				<?php endforeach ?>
			</div>			
		</header>
		
		<div class="share">
			<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="cities_stats_btn">
		</div>
		
		<img src="<?php echo $map_cities ?>">
	</article>		
</section>

