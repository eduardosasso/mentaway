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
	
?>

<nav class="menu">
	<ul>
		<li><a href="<?php echo $url_prefix; ?>" class="redirect <?php echo css($page,'timeline'); ?>">Timeline</a></li>
		
		<?php if ($friends >0): ?>
			<li><a href="<?php echo $url_prefix; ?>friends" id="friends_link" class="redirect <?php echo css($page,'friends'); ?>">Friends</a></li>
		<?php endif ?>
		
		<li><a href="<?php echo $url_prefix; ?>stats" class="redirect <?php echo css($page,'stats'); ?>">Stats</a></li>
		
		<?php if ($session['uid'] == $user_id): ?>			
			<li><a href="/settings" class="redirect <?php echo css($page,'settings'); ?>">Settings</a></li>
		<?php endif ?>
		
	</ul>
</nav>


