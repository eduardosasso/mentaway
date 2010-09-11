<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/model/AbstractService.class.php");
require_once("$root/model/Placemark.class.php");

require_once("$root/lib/foursquare/EpiCurl.php");
require_once("$root/lib/foursquare/EpiOAuth.php");
require_once("$root/lib/foursquare/EpiFoursquare.php");

class Foursquare extends AbstractService { 
	public function get_updates(){
		$user = 'eduardo.sasso@gmail.com';
		$pass = 'pasek07';
		
		$foursquare = new EpiFoursquare();

		/*
			TODO Tem que ser via OAuth
		*/
		$history = $foursquare->get_basic('/history.json', array(), $user, $pass);
		$history = json_decode($history->responseText);
		
		$placemarks = array();
		
		foreach ($history->checkins as $key => $checkin) {
			$placemark = new Placemark();
			$placemark->name = $checkin->venue->name;
			$placemark->image = $checkin->venue->primarycategory->iconurl;
			$placemark->description = $checkin->shout;
			$placemark->date = $checkin->created;
			$placemark->lat = $checkin->venue->geolat;
			$placemark->long = $checkin->venue->geolong;
			$placemark->service = "Foursquare"
			
			$placemarks[] = $placemark;
		}
		
		return $placemarks;
		
	}
}
?>