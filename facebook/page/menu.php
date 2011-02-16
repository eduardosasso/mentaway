<?php
	function css($page,$arg){
		if ($page == $arg) print 'active';
	}
	
	$friends = count($user->friends);

	//identifica a url no query string para ver se é de um user "user/1122222" pra continuar usando ela em outros links
	preg_match("/(user\/.*?)[&|\/]/", $page_url, $matches);
	$url_prefix = '/';
	
	if ($matches) {
		$url_prefix .= $matches[1] . '/';
	}
	
	$status = ($controller->get_countries_visited($user_id)  > 0);
	
?>

<nav class="menu">
	<ul>
		<li><a href="<?php echo $url_prefix; ?>" class="redirect <?php echo css($page,'timeline'); ?>">Timeline</a></li>
		
		<?php if ($friends >0): ?>
			<li><a href="<?php echo $url_prefix; ?>friends" id="friends_link" class="redirect <?php echo css($page,'friends'); ?>">Friends</a></li>
		<?php endif ?>
		
		<?php if ($status): ?>
			<li><a href="<?php echo $url_prefix; ?>stats" class="redirect <?php echo css($page,'stats'); ?>">Stats</a></li>
		<?php endif ?>		
		
		<?php if ($session['uid'] == $user_id): ?>			
			<li><a href="/settings" class="redirect <?php echo css($page,'settings'); ?>">Settings</a></li>
		<?php endif ?>
		
		<li class="help"><a href="<?php echo $url_prefix; ?>help" class="redirect <?php echo css($page,'help'); ?>">Help</a></li>
		
	</ul>
</nav>


