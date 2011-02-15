<?php
$friends = $user->friends;	
?>

<section id="friends">
	<?php foreach ($friends as $value): ?>
		<?php 
			$friend = $controller->get_user($value);
			
			$cities = $controller->get_cities_visited($friend->_id);
			$states = $controller->get_states_visited($friend->_id);
			$countries = $controller->get_countries_visited($friend->_id);			
		?>
		
		<?php	$user_picture = "https://graph.facebook.com/". $friend->_id . "/picture"; ?>

		<article class="item">
			<figure>
				<a href="/user/<?php echo $friend->_id; ?>" class="redirect"><img src="<?php echo $user_picture; ?>"></a>
			</figure>
			<header>
				<h1><a href="/user/<?php echo $friend->_id; ?>" class="redirect"><?php echo $friend->fullname; ?></a></h1>
				<div class="stats">
					<span><?php echo $countries ?> Countries</span>
					<span><?php echo $states ?> States</span>
					<span><?php echo $cities ?> Cities</span>
				</div>
			</header>
		</article>
		<div style="clear:both"></div>
	<?php endforeach ?>
</section>

<div id="sidebar">
	<?php include "page/sidebar.php"; ?>		
</div>