<?php

class Settings {
	const LOCAL = 'mentaway.dev';
	const PROD = 'mentaway.com';
	const DEV = 'beta.mentaway.com';	
	
	public static function get_env() {
		if (isset($_SERVER["SERVER_NAME"])) {
			$domain = $_SERVER["SERVER_NAME"];
		} else {
			//se ta testando com phpunit não  vai ter SERVER_NAME entao assume que é local			
			$domain = Settings::LOCAL;		
			return $domain;	
		}
		
		if (isset($_ENV['USER']) && $_ENV['USER'] == 'eduardosasso') {
			return Settings::LOCAL;
		}

		switch ($domain) {
			case Settings::LOCAL:
				return Settings::LOCAL;
				break;
			case Settings::PROD:
				return Settings::PROD;
				break;
			default:
				return Settings::DEV;
				break;
		}		
		
	}
	
	public static function get_twitter_oauth_key(){
		$consumer_key = "rJHgm4ewnT6VqD7MFThA";
		$consumer_secret = "88QKvizTTHlIsmPlv93t4tRPIKTNf7lQx4ZnZwPduI";
		
		if (Settings::get_env() == Settings::LOCAL) {
			$consumer_key = "ehdVztRxrLeQDvaiOXfOrg";
			$consumer_secret = "m5TwGbCbQ9iz1wWrsEyp4Fa9Q5PgTwH2PXQmZLltU4";
		}
		
		$key_secret = array();
		$key_secret[] = $consumer_key;
		$key_secret[] = $consumer_secret;
		
		return $key_secret;		
	}
	
	public static function get_facebook_oauth_key(){
		$appId =  '136687686378472';
		$secret = 'cc7fd1a64d2a02f07622de9355c34de8';
		
		$key_secret = array();
		$key_secret[] = $appId;
		$key_secret[] = $secret;
		
		return $key_secret;
		
	}
	
	public static function get_foursquare_oauth_key() {
		$consumer_key = "3ZJVNOQBLHDFE3YKW3BJ1XQZG0XRJWLN4EVNR3WYRKEO0FED";
		$consumer_secret = "YLMEQHX1LO5K0XDGWCEQKNI0WXRPWNTKM05VXELYZ30J42C2";
		
		if (Settings::get_env() == Settings::LOCAL) {
			$consumer_key = "A50Y3YTNHIXKMLBRV24JRSJXQCGNCSVVWAXV3S1D1DPGAKDJ";
			$consumer_secret = "MU5SR2PHQ02FJDKJXMUZW0R3OWOAOBPZGHEX1YTDJPUH0HJQ";
		}
		
		$key_secret = array();
		$key_secret[] = $consumer_key;
		$key_secret[] = $consumer_secret;
		
		return $key_secret;
	}
	
	public static function get_flickr_oauth_key(){
		$consumer_key = "abf2e4a70a2362dcc429faf6060954a1";
		$consumer_secret = "d4e88e847732c369";
		
		if (Settings::get_env() == Settings::LOCAL) {
			$consumer_key = "1003882fc64173a086b55b4a255f8c2f";
			$consumer_secret = "6adf2461ab5e6b59";
		}
		
		$key_secret = array();
		$key_secret[] = $consumer_key;
		$key_secret[] = $consumer_secret;
		
		return $key_secret;	
	}
	
	public static function get_couchdb_url() {
		$url = 'http://localhost:5984/';
		//$url = 'http://localhost:5985/';
		
		// if (Settings::get_env() == Settings::LOCAL) {
		// 	//via ssh tunnel base quente.
		// 	$url = "http://localhost:5985/";
		// }
		
		return $url;
	}	
	
}	 

?>