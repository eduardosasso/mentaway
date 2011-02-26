<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

abstract class AbstractService {
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
			
			//coloca notificacao no fb para os amigos desse user.
			Queue::add('notification_worker', $username);

		} catch (Exception $e) {			
			Log::write($e->getMessage());
		}
	}

}
?>