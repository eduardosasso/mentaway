<?php 

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Stats extends AbstractService {

		const CITY =  1;
		const STATE = 2;
		const COUNTRY = 3;		

		public function get_updates($username){
			//pega so os placemarks do user q estao sem o geocode reverso
			$db = DatabaseFactory::get_provider();
			$placemarks = $db->get()->key($username)->getView('placemark','reverse_geo');

			if (empty($placemarks->rows)) {
				return;
			}	

			$this->update_trip_status($username, $placemarks->rows);

		}	

		public function update_trip_status($username, $placemarks){
			$controller = new Controller();
			
			$cities = array();
			$states = array();
			$countries = array();

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
							$cities[] = $name;
							$placemark->value->city = $name;
							break;
							case self::STATE:
							$states[] = $name;
							$placemark->value->state = $name;
							break;
							case self::COUNTRY:	
							$countries[] = $name;
							$placemark->value->country = $name;
							break;
						}
					}					
					$controller->save($placemark->value);	
				}
			}
			
			$user = $controller->get_user($username);
			
			$user->cities = array_unique(array_merge((array)$user->cities, (array)$cities));
			$user->states = array_unique(array_merge((array)$user->states, (array)$states));
			$user->countries = array_unique(array_merge((array)$user->countries, (array)$countries));
			
			$controller->save($user);

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
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($ch);
			curl_close($ch);

			return json_decode($data, true);

		}	
}