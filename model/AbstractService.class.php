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
			$trip = $user->trips[0];
			
			if (isset($user->friends)) {
				$document->friends = $user->friends;
			}
			
			$document->fullname = $user->fullname;

			//se a trip do cara tem data de inicio respeita ela na hora de salvar os checkins, se nao tem nada pega tudo.
			if (isset($trip->begin)) {
				if ($document->timestamp >= strtotime($trip->begin)) {
					$db->save($document);
				}
			} else {
				$db->save($document);
			}

		} catch (Exception $e) {
			/*
				TODO tratar melhor... por enquanto nao faz nada, so evita o erro
			*/
		}
	}
	
}
?>