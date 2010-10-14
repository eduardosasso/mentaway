<?php 
require_once("DatabaseInterface.php");
require_once("Service.class.php");
require_once("Trip.class.php");

require_once "lib/couchdb/couch.php";
require_once "lib/couchdb/couchClient.php";
require_once "lib/couchdb/couchDocument.php";

require_once "lib/HelperFunctions.php";

class CouchDB implements DatabaseInterface { 
	
	private $db;
	
	function __construct() {
		//$url = "http://localhost:5984/";

		//via ssh tunnel base quente.
		$url = "http://localhost:5985/";
		
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
		// codigo da view
		// function(doc) {
		// 		  if (doc.lat)
		// 		    emit(doc.user, doc);
		// 		}
		
		$placemarks = $this->db->startkey($user)->endkey($user)->getView('placemark','placemarks');
		
		return $placemarks;
	}
	
	//Remove documentos poara teste
	public function clean_database() {
		$all_or_nothing = true;
		
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
	
	public function add_user_trip($username, Trip $trip) {
		$user = $this->get_user($username);
		
		if (isset($user->trips)) {
			$user_trips = $user->trips;

			//ve se o servico ja existe, se sim remove para atualizar...
			foreach ($user_trips as $key => $value) {
				if ($value->_id == $trip->_id) {
					unset($user_trips[$key]);
					$temp_array = array_values($user_trips);
					$user->trips = $temp_array;
				}
			}
		}
	
		$user->trips[] = $trip;
		
		$response = $this->save_user($user);
		
		return $response;		
	}
	
	public function remove_user_service($username, $service_id) {
		$user = $this->get_user($username);
		
		$user_services = $user->services;
		
		foreach ($user_services as $key => $value) {
			if ($value->_id == $service_id) {
				unset($user_services[$key]);
				$temp_array = array_values($user_services);
				$user->services = $temp_array;
			}
		}
		
		$response = $this->save_user($user);
		
		return $response;		
		
	}
	
	public function get_all_users() {
		// function(doc) {
		//   if (doc.services)
		//   emit(doc.username, doc);
		// }
		
		$users = $this->db->getView('users','users');
		return $users->rows;
	}
		
	public function get_user($username) {
		try {
			$result = $this->db->getDoc($username);
		} catch (couchException $e) {
			/*
				TODO tratar melhor o erro ver exatamente o que eh.
				como solucao temp retorno null indicando q usuario nao foi encontrado
			*/
			$result = null;
		}				
		return $result;		
	}
	
}
?>