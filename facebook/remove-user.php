<?php
//Arquivo chamado pelo facebook quando um usuario desinstala a aplicacao

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

try {
	$key_secret = Settings::get_facebook_oauth_key();

	$facebook = new Facebook(array(
		'appId' => $key_secret[0],
		'secret' => $key_secret[1],
		'cookie' => true,
		));

	$data = $facebook->getSignedRequest();
	$username = $data['user_id'];

	//remove todos os placemarks do usuario e o proprio user na sequencia.
	$db = DatabaseFactory::get_provider();
	$db->clean_database_user($username);

	$user = $db->get()->getDoc($username);
	$db->get()->deleteDoc($user);	
} catch (Exception $e) {
	Log::write($e->getMessage());
	
}


?>