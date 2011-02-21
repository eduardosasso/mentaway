<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class CouchDB implements DatabaseInterface { 
	
	private $db;
	
	function __construct() {
		$url = Settings::get_couchdb_url();
	
		$database = "mentaway-fb";
		
		$this->db = new couchClient($url,$database);
	}
	
	public function get(){
		return $this->db;
	}
	
	public function save($document) {
		unset($document->_deleted_conflicts);
		
		$response = $this->db->storeDoc($document);
		
		return $response;
	}
	
	public function get_placemarks($user, $limit = 100) {
		//recupera os ultimos (mais recentes) 100 placemarks de um usuario
		
		$key = array("$user", array());
		$end_key = array("$user");
		
		if ($limit == 0) {
			$placemarks = $this->db->descending(true)->startkey($key)->endkey($end_key)->getView('placemark','placemarks');
		} else {
			$placemarks = $this->db->descending(true)->limit($limit)->startkey($key)->endkey($end_key)->getView('placemark','placemarks');
		}
	
		return $placemarks;
	}
	
	public function clean_database_users(){
		$users = $this->db->getView('users','users');

		foreach ($users->rows as $row ) {
			$this->db->deleteDoc($row->value);
		}
	}
	
	//Remove documentos poara teste
	public function clean_database_user($username) {
		$placemarks = $this->db->key($username)->include_docs(true)->getView('placemark','all');
		
		foreach ($placemarks->rows as $row ) {
			$this->db->deleteDoc($row->value);
		}		
	}
	
	public function clean_database() {	
		$placemarks = $this->db->include_docs(true)->getView('placemark','all');
		
		foreach ($placemarks->rows as $row ) {
			$this->db->deleteDoc($row->value);
		}
		// $docs = $this->db->include_docs(true)->getAllDocs();
		// 	
		// foreach ($docs->rows as $row ) {
		// 	$this->db->deleteDoc($row->doc);
		// }
	}
	
	public function save_user($user) {
		return $this->save($user);
	}
	
	public function add_friends($username, $friends) {
		$user = $this->get_user($username);
		$user->friends = $friends;
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
	
	public function add_user_trip($username, $new_or_updated_trip) {
		$user = $this->get_user($username);
		
		if (isset($user->trips)) {
			$user_trips = $user->trips;

			//ve se a trip eh nova ou atualizacao, se eh atualizacao remove a existente e 
			//inclui novamente a quem vem por argumento com infos atualizadas
			foreach ($user_trips as $key => $trip_saved_on_db) {
				if (isset($trip_saved_on_db->_id) && $new_or_updated_trip->_id == $trip_saved_on_db->_id) {
					
					unset($user_trips[$key]);
					$temp_array = array_values($user_trips);
					$user->trips = $temp_array;
					
				}
			}
		}

		//$user->trips[] = $new_or_updated_trip;

		//coloca a trip nova/atualizada sempre no inicio da lista para usar a convencao q a trip 0 eh a corrente.. lame
		array_unshift($user->trips, $new_or_updated_trip);
		
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
	
	public function get_user_full($fullname) {
		$user = $this->db->key($fullname)->getView('users','users_full');	
		if ($user->rows) {
			return $user;
		}		
	}
	
	public function get_view($design_document, $view_name, $key) {
		if (!empty($key)) {
			$result = $this->db->key($key)->getView($design_document, $view_name);	
			return $result;
		}
	}
	
	//tenta achar um usuario que usava a versao antiga atraves do token de algum servico
	//funcao util para realizar sync de usuario antigo com a app no facebook
	public function find_old_user($token) {
		$user = $this->db->key($token)->getView('users','find_old');	
		if ($user->rows) {
			return $user->rows[0];
		}				
	}
	
	public function get_doc($id){
		try {
			$doc = $this->db->getDoc($id);
			return $doc;			
		} catch (Exception $e) {
			return;
		}
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
		return $this->get_doc($username);
	}
	
}
?>