<?php 
require_once("DatabaseInterface.php");
require_once("Service.class.php");

require_once "lib/couchdb/couch.php";
require_once "lib/couchdb/couchClient.php";
require_once "lib/couchdb/couchDocument.php";

require_once "lib/HelperFunctions.php";

class CouchDB implements DatabaseInterface { 
	
	private $db;
	
	function __construct() {
		$url = "http://localhost:5984/";
		$database = "mentaway";
		
		$this->db = new couchClient($url,$database);
	}
	
	public function save($document) {
		/*
			TODO Tem q tratar o retorno e excecoes
		*/
		$response = $this->db->storeDoc($document);
		
		return $response;
	}
	
	public function get_placemarks($user, $trip = '') {
		$placemarks = $this->db->startkey($user)->endkey($user)->getView('placemark','placemarks');
		
		return $placemarks;
	}
	
	//Remove documentos poara teste
	public function clean_database() {
		$all_or_nothing = true;
		
		// codigo da view
		// 		function(doc) {
		// 		  emit(doc.user, doc);
		// 		}
		
		$placemarks = $this->db->getView('placemark','placemarks');
		
		foreach ($placemarks->rows as $row ) {
			$this->db->deleteDoc($row->value);
		}
	}
	
	public function save_user($user) {
		return $this->save($user);
	}
	
	public function add_user_service($username, Service $service) {
		$user = $this->get_user($username);
		
		$user_services = $user->services;
		
		//ve se o servico ja existe, se sim remove para atualizar...
		foreach ($user_services as $key => $value) {
			if ($value->_id == $service->_id) {
				unset($user_services[$key]);
				$temp_array = array_values($user_services);
				$user->services = $temp_array;
			}
		}
		
		$user->services[] = $service;
		
		$response = $this->save_user($user);
		
		return $response;		
	}
		
	public function get_user($username) {
		$result = $this->db->getDoc($username);
		return $result;
	}
}
?>