<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

abstract class AbstractService {
	//deve retornar um array do objeto placemarks...
	abstract protected function get_updates($username);

	//Aqui faz a persistencia dos servicos, Foursquare, Twitter ...
	public function save($document, $username = '') {		
		try {
			$db = DatabaseFactory::get_provider();

			$has_doc = $db->get_doc($document->_id);
			
			//quando recupera novos docs so tenta incluir se esse id não esta no banco
			if ($has_doc == false) {
				$user = $db->get_user($username);

				if (isset($user->friends)) {
					$document->friends = $user->friends;
				}

				$document->fullname = $user->fullname;

				$db->save($document);
			}
		} catch (Exception $e) {			
			Log::write($e->getMessage());
		}
	}

}
?>