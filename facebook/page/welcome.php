<?php
	$controller = new Controller();
	
	$bt_label = "Join/Login";
	if ($controller->is_user($session['uid'])) {
		$bt_label = "Login";		
	}
	
	if ($session['uid'] && $controller->is_user($session['uid']) == false) {
		$bt_label = "Join";
	}
	
?>

<p><img src="../images/mentaway-logo.png"></p>

<p>Mentaway helps you track your trips and also follow your friends trips.</p>

<input type="button" value="<?php echo $bt_label ?>" data-url="<?php echo $auth_url ?>" class="external">