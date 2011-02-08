<?php 

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Stats extends AbstractService {
	
		const CITY =  1;
		const STATE = 2;
		const COUNTRY = 3;		
	
		public function get_updates($username){
			$controller = new Controller();
			
			$trip = $controller->get_current_trip($username);
			
			/*
				TODO se a trip do cara ta quebrada seta alguns defaults para ele na hora de atualizar os stats
				como vamos revisar a necessidade de trips isso quebra o galho
			*/
			if (!isset($trip->name)) {
				$trip->name = 'My Trip';
			}
			
			if (!isset($trip->_id)) {
				$trip->_id = 'trip';
			}
			
			//pega so os placemarks do user q estao sem o geocode reverso
			$db = DatabaseFactory::get_provider();
			$placemarks = $db->get()->key($username)->getView('placemark','reverse_geo');
			
			if (empty($placemarks->rows)) {
				return;
			}	

			$trip->status = $this->update_trip_status($trip, $placemarks->rows);
			
			$controller->add_user_trip($username, $trip);
			
		}	
				
		public function update_trip_status($trip, $placemarks){
			$db = DatabaseFactory::get_provider();
			
			if (isset($trip->status)) {
				$status = $trip->status;
			}
			
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
							$placemark->value->city = $name;
							break;
							case self::STATE:
							$status->states[] = $name;
							$placemark->value->state = $name;
							break;
							case self::COUNTRY:	
							$status->countries[] = $name;
							$placemark->value->country = $name;
							break;
						}
					}					
					$db->save($placemark->value);	
				}
			}
			
			$status->cities = array_unique($status->cities);
			$status->states = array_unique($status->states);
			$status->countries = array_unique($status->countries);

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
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($ch);
			curl_close($ch);

			return json_decode($data, true);

		}	
}	
