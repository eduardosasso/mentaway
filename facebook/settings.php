<?php
$controller = new Controller();

if (isset($_REQUEST['twitter']) && $_REQUEST['oauth_token']) {
		$key_secret = Settings::get_twitter_oauth_key();

		$consumer_key = $key_secret[0];
		$consumer_secret = $key_secret[1];

		$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
		
		$twitterObj->setToken($_GET['oauth_token']);

		$token = $twitterObj->getAccessToken();

		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

		$twitterInfo= $twitterObj->get_accountVerify_credentials();

		$username = strtolower($twitterInfo->screen_name);
		
		$user = $controller->get_user($username);
		
		if ($user) {
			$user_facebook = $controller->get_user_fbid($user_id);
			if (!$user_facebook) {
				//se caiu aqui é pq é uma conta antiga do mentaway entao integra a conta com o facebook
				$service = new Service();
				$service->_id = 'facebook';
				$service->name = 'Facebook';
				$service->token = $data['oauth_token'];
				$service->secret = $data['user_id'];

				$controller->add_user_service($username, $service);
				
				$friend = new Friend();
				$friend->follow_facebook_friends($username);
			}
		}		
}

?>

<a href="http://apps.facebook.com/mentaway/" class="top-location">Ok</a>