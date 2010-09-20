<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("DatabaseFactory.php");

abstract class AbstractService {
	
	//deve retornar um array do objeto placemarks...
	abstract protected function get_updates($username);
	
	//Aqui faz a persistencia dos servicos, Foursquare, Twitter ...
	public function save($document, $username = '') {		
		try {
			$db = DatabaseFactory::get_provider();

			/*
				TODO Salva somente se a data do placemark eh maior ou igual a data da trip atual
				Esse metodo nao esta performatico pois recupera o user a cada Save, melhorar...
			*/
			$user = $db->get_user($username);
			$trip = $user->trips[0];
			
			if ($document->timestamp >= $trip->timestamp) {
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