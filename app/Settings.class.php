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
	
	public static function get_couchdb_url() {
		$url = 'http://localhost:5984/';
		
		if (Settings::get_env() == Settings::LOCAL) {
			//via ssh tunnel base quente.
			$url = "http://localhost:5985/";
		}
		
		return $url;
	}	
	
}	 

?>