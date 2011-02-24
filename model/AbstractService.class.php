<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

abstract class AbstractService {
	private $notified = false;
	//deve retornar um array do objeto placemarks...
	abstract protected function get_updates($username);

	//Aqui faz a persistencia dos servicos, Foursquare, Twitter ...
	public function save($document, $username = '') {		
		try {
			$db = DatabaseFactory::get_provider();

			$user = $db->get_user($username);

			if (isset($user->friends)) {
				$document->friends = $user->friends;
			}

			$document->fullname = $user->fullname;

			$db->save($document);

			if (isset($document->country) && !empty($document->country)) {
				Log::write("nao tem pais");
				Log::write(print_r($document, 1));
				
				$trip = $user->trips[0];

				if (isset($trip->status)) {
					Log::write("tem trip status");
					$status = $trip->status;
				} else {
					Log::write("não tem trip status");
					$status->countries = array();
					$status->states = array();
					$status->cities = array();
				}
				
				if (in_array($document->country, $status->countries) == false) {
					Log::write($document->country . " não ta no array de paises");
					
					$status->cities[] = $document->city;
					$status->states[] = $document->state;
					$status->countries[] = $document->country;

					$Gstatus->cities = array_unique($status->cities);
					$status->states = array_unique($status->states);
					$status->countries = array_unique($status->countries);

					$trip->status = $status;
					
					Log::write("Antes de salvar a trip");
					Log::write(print_r($trip, 1));

					$controller->add_user_trip($username, $trip);
				}
			}

			if ($this->notified == false) {
				//Log::write("$username - inc do contador");
				//notifica os amigos desse usuario q ele tem novidades.
				//so entra aqui 1 vez por servico quando tem novidade para ser mais rapido. 
				Notification::inc_counter($username);
				$this->notified == true;
			}

		} catch (Exception $e) {			
			Log::write($e->getMessage());
		}
	}

}
?>