<?php
session_start();

include 'model/lib/twitter/EpiCurl.php';
include 'model/lib/twitter/EpiOAuth.php';
include 'model/lib/twitter/EpiTwitter.php';

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

	/*
	TODO procurar o user e redirecionar
	*/
	$twitterInfo= $twitterObj->get_accountVerify_credentials();

	$id = strtolower($twitterInfo->screen_name);

	$user = $controller->get_user($id);


	if (empty($user)) {
		//novo usuario redireciona para a tela de servicos...
		echo "novo";
	} else {
		$id = $user->_id;

		/*
		TODO sempre q logar atualiza algumas infos do twitter q o usuario possa ter alterado.
		*/
		$user->location = $twitterInfo->location;
		$user->bio = $twitterInfo->description;
		$user->site = $twitterInfo->url;
		$user->picture = $twitterInfo->profile_image_url;
		$user->token = $token->oauth_token;				
		$user->secret = $token->oauth_token_secret;

		$controller->save_user($user);

		//atualiza o cookie e a sessao e redireciona o usuario para a tela dele...
		$_SESSION['id'] = $id;
		header('location: /' . $id);
	}

} else {
	//retorna uma variavel para colocar o link na tela...
	$twitter_url = $twitterObj->getAuthenticateUrl();
}

?>
