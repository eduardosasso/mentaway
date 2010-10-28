<?php
	require('twitter-login.php');
?>

<!doctype html>
<html lang="en" class="no-js">
<head>

</head>

<body>
	<input type="text" name="code" id="code">

	<a href='<?php echo $twitter_url ?>' id="twitter-login"><img src='images/sign-in-with-twitter-l.png'  border='0'/></a>	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="/js/login.js?v=1"></script>
</body>

</html>