<?php 

require_once("lib/HelperFunctions.php");
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Placemark.class.php");

/*
	TODO Deve percorrer todos os placemarks do usuario para a trip ativa e identificar informacoes como cidades visitadas, fotos tiradas, dias na estrada etc...
*/
class Stats extends AbstractService {
	
		var $city = array();
		var $state = array();
		var $country = array();
		
		const CITY =  1;
		const STATE = 2;
		const COUNTRY = 3;		
	
		public function get_updates($username){
			$controller = new Controller();
			
			$trip = $controller->get_current_trip($username);
			
			$how_many_days = $this->how_many_days($trip->timestamp);
			$how_many_days .= 'on the road';

			/*
				TODO aqui tem q ser os placemarks da trip atual
			*/
			$placemarks = $controller->get_placemarks($username);
			$this->get_location_stats($placemarks);
			$locations =  $this->format_location_message();
			
			$trip->status = $how_many_days . $locations; 
			$controller->add_user_trip($username, $trip);
		}	
		
		public function format_location_message(){
			$cities = count($this->get_cities_visited());
			$states = count($this->get_states_visited());
			$countries = count($this->get_countries_visited());
			
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
		
		public function get_cities_visited(){
			$cities = array_unique($this->city);
			// echo '<pre>';
			// print_r($cities);
			// echo '</pre>';
			return $cities;
		}
		
		public function get_states_visited(){
			$states = array_unique($this->state);
			// echo '<pre>';
			// print_r($states);
			// echo '</pre>';
			return $states;
		}
		
		public function get_countries_visited(){
			return array_unique($this->country);
		}
		
		public function how_many_days($timestamp){
			$date = date(DATE_RFC822, $timestamp); 			
			//return $date;
			return nicetime($date);
		}
		
		public function get_location_stats($placemarks){
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
							case CITY:
							$this->city[] = $name;
							break;
							case STATE:
							$this->state[] = $name;
							break;
							case COUNTRY:	
							$this->country[] = $name;
							break;
						}
					}	
				}		
				
			}
			
		}
		
		private function address_type($types) {
			if (count($types) >=2) {
				if ($types[0] == 'locality' && $types[1] == 'political') return CITY;
				if ($types[0] == 'administrative_area_level_1' && $types[1] == 'political') return STATE;
				if ($types[0] == 'country' && $types[1] == 'political') return COUNTRY;
			}
			return null;			
		}
		
		public function reverse_geo($lat, $long){
			$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($ch);
			curl_close($ch);

			return json_decode($data, true);

		}	
}	
