<?php
require_once("DatabaseFactory.php");

abstract class AbstractService {
	
	//deve retornar um array do objeto placemarks...
	abstract protected function get_updates($username);
	
	//Aqui faz a persistencia dos servicos, Foursquare, Twitter ...
	public function save($document) {
		$db = DatabaseFactory::get_provider();
		$db->save($document);
	}
	
}
?>