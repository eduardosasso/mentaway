<?php
require_once("DatabaseFactory.php");

abstract class AbstractService {
	
	//deve retornar um array do objeto placemarks...
	abstract protected function get_updates($username);
	
	//Aqui faz a persistencia dos servicos, Foursquare, Twitter ...
	public function save($document) {
		try {
			$db = DatabaseFactory::get_provider();
			$db->save($document);			
		} catch (Exception $e) {
			/*
				TODO tratar melhor... por enquanto nao faz nada, so evita o erro
			*/
		}
	}
	
}
?>