<?php 

require_once("lib/HelperFunctions.php");
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Placemark.class.php");
require_once("Status.class.php");

/*
	TODO Deve percorrer todos os placemarks do usuario para a trip ativa e identificar informacoes como cidades visitadas, fotos tiradas, dias na estrada etc...
*/
class Stats extends AbstractService {
	
		const CITY =  1;
		const STATE = 2;
		const COUNTRY = 3;		
	
		public function get_updates($username){
			$controller = new Controller();
			
			$trip = $controller->get_current_trip($username);
			
			if (empty($trip)) {
				error_log("Usuario $username sem trip");
				return;
			}
			
			$last_update = $trip->status->last_update;
			
			/*
				TODO aqui tem q ser os placemarks da trip atual
			*/			
			if (!empty($last_update)) {
				$placemarks = $controller->get_placemarks_starting_from($username, $last_update);
			}	else {
				$placemarks = $controller->get_placemarks($username);
			}
			
			if (empty($placemarks)) {
				return;
			}	

			$trip->status = $this->update_trip_status($trip, $placemarks);
			
			$controller->add_user_trip($username, $trip);
			
		}	
				
		public function format_location_message($status){
			$cities = count($status->cities);
			$states = count($status->states);
			$countries = count($status->countries);
			
			if ($cities > 1) {
				$message = ", $cities cities";
			}
			
			if ($states > 1) {
				$message .= ", $states states";
			}
			
			if ($countries > 1) {
				$message .= " and $countries countries";
			}
			
			if ($message) {
				$message .= ' visited so far';
			}

			return $message;
			
		}
		
		public function how_many_days($timestamp){
			$date = date(DATE_RFC822, $timestamp); 			
			//return $date;
			return nicetime($date);
		}
				
		public function update_trip_status($trip, $placemarks){			
			$status = $trip->status;
			
			if (empty($status)) {
				$status->cities = array();
				$status->states = array();
				$status->countries = array();
			} else {
				$status->cities = (array)$status->cities;
				$status->states = (array)$status->states;
				$status->countries = (array)$status->countries;
			}
			
			foreach ($placemarks as $key => $placemark) {
				$lat = $placemark->value->lat;
				$long = $placemark->value->long;
				
				$geo = $this->reverse_geo($lat, $long);
				
				$address_components = $geo['results'][0]['address_components'];
				
				if ($address_components) {
					foreach ($address_components as $key => $value) {

						$address_type = $this->address_type($value['types']);
						$name = $value['long_name'];

						switch ($address_type) {
							case self::CITY:
							$status->cities[] = $name;
							break;
							case self::STATE:
							$status->states[] = $name;
							break;
							case self::COUNTRY:	
							$status->countries[] = $name;
							break;
						}
					}	
				}
			}
			
			$last_placemark = end($placemarks);
			$status->last_update = $last_placemark->value->timestamp;
			
			$status->cities = array_unique($status->cities);
			$status->states = array_unique($status->states);
			$status->countries = array_unique($status->countries);
			
			$locations = $this->format_location_message($status);
			
			$how_many_days = $this->how_many_days(strtotime($trip->begin));
			$how_many_days .= 'on the road';

			$status->message = $how_many_days . $locations; 
			
			return $status;			
			
		}
		
		private function address_type($types) {
			if (count($types) >=2) {
				if ($types[0] == 'locality' && $types[1] == 'political') return self::CITY;
				if ($types[0] == 'administrative_area_level_1' && $types[1] == 'political') return self::STATE;
				if ($types[0] == 'country' && $types[1] == 'political') return self::COUNTRY;
			}
			return null;			
		}
		
		public function reverse_geo($lat, $long){
			$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER,0);
//			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($ch);
			curl_close($ch);

			return json_decode($data, true);

		}	
}	
