<?php

session_start();

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

$username = $_REQUEST['username'];

$controller = new Controller();
$user = $controller->get_user($username);

$token = $user->token;
$secret = $user->secret;

/*
	TODO isso ta meio inicial, ele leva em consideracao q essa info de token na raiz do user eh do twitter e isso nao ta legal.
			 tem continuar testando o token mais em outra hierarquia e tambem permitir a auth via oauth
*/
if ($token && $secret) {	
	
	$service = new Service();
	$service->_id = 'twitter';
	$service->name = 'Twitter';
	$service->token = $token;
	$service->secret = $secret;
	
	/*
		TODO fazer controle de excecao aqui pra se der erro ele mostrar uma mensagem para o user
	*/
	$response = $controller->add_user_service($username, $service);	
	//manda devolta para a pagina de user so pra atualizar a UI
	Message::show("Twitter configured... Add '#m' to your tweets and don't forget to enable geo-location on Twitter.",Message::INFO);
	
	
	/*
		TODO esse conceito ta meio tosco, ele chega aqui por ajax e faz um echo com a url para retornar, tem q melhorar
	*/
	echo "/user/services/$username";
	
}

// 
// // $twitter = new Twitter();
// // $is_valid = $twitter->validate($twitter_user);
// 
// if ($is_valid) {
// 	
// 	$service = new Service();
// 	$service->_id = 'twitter';
// 	$service->name = 'Twitter';
// 	$service->token = $twitter_user;
// 
// 
// 	
// 	$response = $controller->add_user_service($username, $service);
// 	
// 	/*
// 		TODO Validar a saida para dar uma mensagem amigavel.
// 	*/
// 	echo 'Twitter configured... Add "#m" to your tweets and dont forget to enable geolocation on twitter.';
// 
// } else {
// 		echo 'Invalid Twitter Account';	
// }

?>
