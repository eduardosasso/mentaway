<?php
	function css($page,$arg){
		if ($page == $arg) print 'active';
	}
?>

<nav class="menu">
	<ul>
		<li><a href="/timeline" class="redirect <?php echo css($page,'timeline'); ?>">Timeline</a></li>
		<li><a href="/settings" class="redirect <?php echo css($page,'settings'); ?>">Settings</a></li>
	</ul>
</nav>


