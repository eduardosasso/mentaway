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
				$trip = $user->trips[0];

				if (isset($trip->status)) {
					$status = $trip->status;
				} else {
					$status->countries = array();
					$status->states = array();
					$status->cities = array();
				}
				
				if (in_array($document->country, $status->countries) == false) {
					$status->cities[] = $document->city;
					$status->states[] = $document->state;
					$status->countries[] = $document->country;

					$status->cities = array_unique($status->cities);
					$status->states = array_unique($status->states);
					$status->countries = array_unique($status->countries);

					$trip->status = $status;

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