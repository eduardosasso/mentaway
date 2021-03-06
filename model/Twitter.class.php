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

			//$tweets = $twitter->get('/statuses/user_timeline.json', array("count"=>"200"));
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

					$image = '';
					$image_url = '';
					$lightbox = false;
					
					$twitpic = '/(http:\/\/twitpic.com\/(\w+))/';
					$yfrog = '/(http:\/\/yfrog.com\/(\w+))/';
					$plixi = '/(http:\/\/plixi.com\/.+\/(\w+))/';
					$instagram = "/(http:\/\/instagr.am\/.+\/(\w+))/";

					if (preg_match($twitpic, $text, $matches) > 0) {
						$image = 'http://twitpic.com/show/thumb/' . $matches[2];
						$image_url = $matches[0];
						$lightbox = true;
						$text = str_replace($matches[0] ,'', $text);
					} elseif (preg_match($yfrog, $text, $matches) > 0) {
						$image = $matches[0] . ".th.jpg";
						//$image_url = $matches[0] . ":iphone";
						$image_url = $matches[0];
						$lightbox = true;
						$text = str_replace($matches[0] ,'', $text);
					} elseif (preg_match($plixi, $text, $matches) > 0) {
						$image = "http://api.plixi.com/api/tpapi.svc/imagefromurl?size=small&url=" . urlencode($matches[0]);
						//$image_url = "http://api.plixi.com/api/tpapi.svc/imagefromurl?size=medium&url=" . urlencode($matches[0]);
						$image_url = $matches[0];
						$text = str_replace($matches[0] ,'', $text);
						$lightbox = true;
					} elseif (preg_match($instagram, $text, $matches) > 0) {
						$image = $matches[0] . "/media/?size=t";
						$image_url = $matches[0] . "/media/?size=l";
						$text = str_replace($matches[0] ,'', $text);
						$lightbox = true;
					}

					//retira hash e image do twitter...
					$text = str_replace('#mentaway' ,'', $text);
					$text = str_replace('#m' ,'', $text);

					$placemark = new Placemark();
					$placemark->_id = $timestamp . "|$username|twitter";
					$placemark->name = trim($text);
					$placemark->image = $image;
					$placemark->image_url = $image_url;					
					$placemark->lightbox = $lightbox;
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
			//echo $e->getMessage();
			Log::write("Erro recuperando twitter - usuario $username");
			
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