<?php

$cities = (array)$controller->get_cities_list($user_id);
$states = (array)$controller->get_states_list($user->_id);
$countries = (array)$controller->get_countries_list($user->_id);

$countries_formatted = implode('|', $countries);
$states_formatted = implode('|', $states);
$cities_formatted = implode('|', $cities);

$map_countries = 'http://maps.google.com/maps/api/staticmap?size=640x215&maptype=roadmap&markers='. $countries_formatted . '&sensor=false';
$map_states = 'http://maps.google.com/maps/api/staticmap?size=640x215&maptype=roadmap&markers='. $states_formatted . '&sensor=false';
$map_cities = 'http://maps.google.com/maps/api/staticmap?size=640x215&maptype=roadmap&markers='. $cities_formatted . '&sensor=false';

$countries_count = count($countries);
$states_count = count($states);
$cities_count = count($cities);

?>

<section id="stats">
	<header>
		<h1>Places <?php echo $user->fullname ?> visisted</h1>
	</header>
	<article id="countries">
		<header>
			<h1><?php echo $countries_count ?> <?php echo Helper::plural($countries_count, 'Country', 'Countries'); ?></h1>

			<div class="share">
				<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="countries_stats_btn">
			</div>

			<div>
				<?php foreach ($countries as $country): ?>
					<span class="pill"><?php echo $country ?></span>
				<?php endforeach ?>
			</div>
		</header>
		
		<img src="<?php echo $map_countries ?>">
	</article>
	
	<article id="states">
		<header>
			<h1><?php echo $states_count ?> <?php echo Helper::plural($states_count, 'State'); ?></h1>

			<div class="share">
				<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="states_stats_btn">
			</div>

			<div>
				<?php foreach ($states as $state): ?>
					<span class="pill"><?php echo $state ?></span>
				<?php endforeach ?>
			</div>			
		</header>
		
		<img src="<?php echo $map_states ?>">
	</article>
	
	<article id="cities">
		<header>
			<h1><?php echo $cities_count ?> <?php echo Helper::plural($cities_count, 'City', 'Cities'); ?></h1>
			
			<div class="share">
				<input type="button" value="Share" data-uid="<?php echo $user_id ?>" id="cities_stats_btn">
			</div>

			<div>
				<?php foreach ($cities as $city): ?>
					<span class="pill"><?php echo $city ?></span>
				<?php endforeach ?>
			</div>			
		</header>
		
		<img src="<?php echo $map_cities ?>">
	</article>		
</section>

