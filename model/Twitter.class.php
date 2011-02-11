<?php 

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Twitter extends AbstractService { 

	public function get_updates($username){
		$key_secret = Settings::get_twitter_oauth_key();

		$consumer_key = $key_secret[0];
		$consumer_secret = $key_secret[1];

		$servicename = 'twitter';

		$controller = new Controller();

		$service = $controller->get_user_service($username, $servicename);

		if (empty($service->token) || empty($service->secret)) {
			return;
		}

		try {
			$twitter = new EpiTwitter($consumer_key, $consumer_secret, $service->token, $service->secret);

			$tweets = $twitter->get('/statuses/user_timeline.json');

			$placemarks = array();
			$pattern = '/#mentaway/';
			$pattern_short = '/#m/';

			foreach ($tweets as $key => $tweet) {
				$text = $tweet->text;

				//tem q ter geo habilitado + hash #m para identificar tweet do mentaway
				if (isset($tweet->geo) && (preg_match($pattern,$text) > 0 || preg_match($pattern_short,$text) > 0)) {
					$timestamp = strtotime($tweet->created_at);

					$lat = $tweet->geo->coordinates[0];
					$long = $tweet->geo->coordinates[1];

					$twitpic = '#http://twitpic.com/(\w+)#';
					$image = '';
					if (preg_match($twitpic, $text, $matches) > 0) {
						$image = 'http://twitpic.com/show/thumb/' . $matches[1];
					}

					//retira hash e image do twitter...
					$text = preg_replace($twitpic ,'', $text);
					$text = preg_replace('/#m/' ,'', $text);
					$text = preg_replace('/#mentaway/' ,'', $text);

					$placemark = new Placemark();
					$placemark->_id = $timestamp . "|$username|twitter";
					$placemark->name = trim($text);
					$placemark->image = $image;
					//$placemark->description = $shout;
					$placemark->date = $tweet->created_at;
					$placemark->timestamp = $timestamp;
					$placemark->lat = $lat;
					$placemark->long = $long;
					$placemark->service = $servicename;
					$placemark->user = $username;

					$placemarks[] = $placemark;

					parent::save($placemark, $username);
				}
			}

			return $placemarks;
		} catch (Exception $e) {
			/*
				TODO por algum motivo nao conseguiu pegar o twitter... identificar melhor, talvez removendo a autorizacao da conta para testar o erro
				//usuarios arasmus - EpiTwitterNotAuthorizedException
			*/
			
			/*
				TODO usar uma funcao log generica para poder plugar diferentes tipos de log.
			*/
			error_log("Erro recuperando twitter - usuario $username", 0);
			
			return;
		}
	}

	public function validate($twitter_user){
		$twitter_url = "http://api.twitter.com/1/users/show.json?screen_name=$twitter_user";

		try {
			$info = file_get_contents($twitter_url);
			$result = true;
		} catch (Exception $e) {
			$result = false;
		}

		return $result;

	}
	
	public static function shout($username, $text){
		$key_secret = Settings::get_twitter_oauth_key();

		$consumer_key = $key_secret[0];
		$consumer_secret = $key_secret[1];

		$servicename = 'twitter';

		$controller = new Controller();

		$service = $controller->get_user_service($username, $servicename);

		if (empty($service->token) || empty($service->secret)) {
			return;
		}

		try {
			$twitter = new EpiTwitter($consumer_key, $consumer_secret, $service->token, $service->secret);
			$twitter->useAsynchronous();

			$params = array("status" => $text);
			$tweets = $twitter->post('/statuses/update.json', $params);

		} catch (Exception $e) {
			Log::write($e->getMessage());
		}

	}
	
	public static function follow_mentaway($username) {
		$key_secret = Settings::get_twitter_oauth_key();

		$consumer_key = $key_secret[0];
		$consumer_secret = $key_secret[1];

		$servicename = 'twitter';

		$controller = new Controller();

		$service = $controller->get_user_service($username, $servicename);

		if (empty($service->token) || empty($service->secret)) {
			return;
		}

		try {
			$twitter = new EpiTwitter($consumer_key, $consumer_secret, $service->token, $service->secret);
			$twitter->useAsynchronous();

			$params = array("screen_name" => "mentaway", "follow" => "true");
			$tweets = $twitter->post('/friendships/create.json', $params);
			
		} catch (Exception $e) {
		 	Log::write($e->getMessage());
		}
		
	}

}
?>