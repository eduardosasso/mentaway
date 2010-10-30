<?php
session_start();

include 'model/lib/twitter/EpiCurlTwitter.php';
include 'model/lib/twitter/EpiOAuthTwitter.php';
include 'model/lib/twitter/EpiTwitter.php';
include 'model/User.class.php';
include 'util/Message.class.php';

$consumer_key = "rJHgm4ewnT6VqD7MFThA";
$consumer_secret = "88QKvizTTHlIsmPlv93t4tRPIKTNf7lQx4ZnZwPduI";

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

//se o token vier populado significa que eh o callback do oauth
if ($_GET['oauth_token']) {

	require_once("model/Service.class.php");
	require_once("model/Controller.php");
	require_once("model/User.class.php");

	$controller = new Controller();

	$twitterObj->setToken($_GET['oauth_token']);

	$token = $twitterObj->getAccessToken();

	$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

	$twitterInfo= $twitterObj->get_accountVerify_credentials();

	$id = strtolower($twitterInfo->screen_name);

	$user = $controller->get_user($id);

	if (empty($user)) {
		if (!empty($_SESSION['invite'])) {
			
			//se chegou aqui e tem o invite cria o user temp e segue adiante para preencher outras infos
			$user = new User();
			$user->_id = $id;
			$user->username = $id;
			$user->fullname = $twitterInfo->name;
			$user->location = $twitterInfo->location;
			$user->bio = $twitterInfo->description;
			$user->site = $twitterInfo->url;
			$user->picture = $twitterInfo->profile_image_url;
			$user->date = date('m/d/Y');
			$user->token = $token->oauth_token;				
			$user->secret = $token->oauth_token_secret;

			$controller->save_user($user);
			
			$_SESSION['id'] = $id;
			
			header('location: /user/profile');	
		} else {
			//tentou criar um user sem invite, da uma mensagem e redireciona para a home....
			Message::show("Sorry but only invited users for now.", Message::ERROR);
			header('location: /');
		}
		
	} else {
		$id = $user->_id;
		$_SESSION['id'] = $id;
		
		$user->picture = $twitterInfo->profile_image_url;
		$user->token = $token->oauth_token;				
		$user->secret = $token->oauth_token_secret;

		$controller->save_user($user);
		
		if (empty($user->email)) {
			header('location: /user/profile');
			return;			
		}
		
		if (count($user->services) == 0) {
			//usuario ja foi criado mas nao tem nenhum servico
			header('location: /user/services');
			return;
		};
		
		if (count($user->trips) == 0) {
			//usuario ja foi criado mas nao tem trip
			header('location: /user/trips');
			return;
		};

		header('location: /' . $id);
	}

} else {
	//retorna uma variavel para colocar o link na tela...
	$twitter_url = $twitterObj->getAuthenticateUrl();
}

?>
