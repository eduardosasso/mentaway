<?php
	$args = explode('/', $_REQUEST['q']);
	
	if (count($args) < 4) {
		error_log('erro nos servicos, chamou a url com menos argumentos');
		echo "Error. Missing arguments";
		return;
	}
	
  $username = $args[1];
  $service = $args[2];
  $action = $args[3];

	if ($action == 'remove') {
		include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';
		
		$controller = new Controller();
		$controller->remove_user_service($username, $service);
		
		header("Location: http://apps.facebook.com/mentaway/settings");
		
		return;
	}

	include	"$service.php";
?>