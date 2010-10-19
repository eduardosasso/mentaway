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
	
	$twitter_id = $_SESSION['twitter_id'];
	
	//se nao foi autenticado pelo twitter ou nao tem conta criada entra aqui
	if (empty($twitter_id)) {
		$controller = new Controller();
		
		$twitterObj->setToken($_GET['oauth_token']);

		$token = $twitterObj->getAccessToken();

		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

		/*
			TODO procurar o user e redirecionar
		*/
		$twitterInfo= $twitterObj->get_accountVerify_credentials();
		$screen_name = $twitterInfo->screen_name;
		
		$user = $controller->get_user($screen_name);
		
		if (empty($user)) {
			//novo usuario redireciona para a tela de servicos...
		} else {
			$id = $user->_id;

			/*
				TODO sempre q logar atualiza algumas infos do twitter q o usuario possa ter alterado.
			*/
			$user->bio = $twitterInfo->description;
			$user->site = $twitterInfo->url;
			$user->picture = $twitterInfo->profile_image_url;
			
			$controller->save_user($user);
			
			//atualiza o cookie e a sessao e redireciona o usuario para a tela dele...
			$_SESSION['id'] = $id;
			header('location: /' . $id);			
		}
		
		/*
			TODO se nao achar user vai para a pagina de criar user.
		*/

		echo $twitterInfo->id;
		echo "<br>";
		echo $twitterInfo->screen_name;
		echo "<br>";
		echo $twitterInfo->profile_image_url;		
	} else {
		/*
			TODO se ja ta autenticado vai para a pagina do user
		*/
	}
			
	
} else {
	//retorna uma variavel para colocar o link na tela...
	$twitter_url = $twitterObj->getAuthenticateUrl();
}

?>
