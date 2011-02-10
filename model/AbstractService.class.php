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
			
			if ($this->notified == false) {
				//notifica os amigos desse usuario q ele tem novidades.
				//so entra aqui 1 vez por servico quando tem novidade para ser mais rapido. 
				Notification::inc_counter($username);
				$this->notified == true;
			}

		} catch (Exception $e) {			
		}
	}
	
}
?>