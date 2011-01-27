<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';
// 
// $key_secret = Settings::get_facebook_oauth_key();
// 
// $facebook = new Facebook(array(
// 	'appId' => $key_secret[0],
// 	'secret' => $key_secret[1],
// 	'cookie' => true,
// 	));
// 
// $data = $facebook->getSignedRequest();


/*
	TODO aqui ou tem que remover o usuario ou setar um flag dizendo q ele ta desabilitado.
*/
error_log('removeu do facebook <pre>'.print_r($_REQUEST, 1).'</pre>');
echo "aqui";

?>