<?php
$friends = $user->friends;	
?>

<section id="friends">
	<header>
		<div id="invite_friends">
			<?php if (isset($user->friends) && count($user->friends) > 0): ?>
				<input type="button" value="Invite more friends to join" class="special_button">
			<?php else: ?>
				<input type="button" value="Invite your friends to join" class="special_button">
			<?php endif ?>			
		</div>		
	</header>
	<?php foreach ($friends as $value): ?>
		<?php 
			$friend = $controller->get_user($value);
			
			$cities = $controller->get_cities_visited($friend->_id);
			$states = $controller->get_states_visited($friend->_id);
			$countries = $controller->get_countries_visited($friend->_id);
			
			$last_place = $controller->get_last_place_visited($friend->_id);
			
			$last_place = "in " . Helper::format_location($last_place[0], $last_place[1], $last_place[2]); 

		?>
		
		<?php	$user_picture = "https://graph.facebook.com/". $friend->_id . "/picture"; ?>

		<article class="item">
			<figure>
				<a href="/user/<?php echo $friend->_id; ?>" class="redirect"><img src="<?php echo $user_picture; ?>"></a>
			</figure>
			<header>
				<h1><a href="/user/<?php echo $friend->_id; ?>" class="redirect"><?php echo $friend->fullname; ?></a></h1>
				<p class="address"><?php echo $last_place ?></p>
				<div class="stats">
					<span class="pill"><?php echo $countries ?> <?php echo Helper::plural($countries, 'Country', 'Countries'); ?></span>
					<span class="pill"><?php echo $states ?> <?php echo Helper::plural($states, 'State'); ?></span>
					<span class="pill"><?php echo $cities ?> <?php echo Helper::plural($cities, 'City', 'Cities'); ?></span>
				</div>
			</header>
		</article>
		<div style="clear:both"></div>
	<?php endforeach ?>
</section>