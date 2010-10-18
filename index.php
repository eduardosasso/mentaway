<?php
	require('twitter-login.php');
	$url = get_auth_url();
?>
<a href="<?php echo $url; ?>"><img src="images/sign-in-with-twitter-l.png"  border="0" /></a>