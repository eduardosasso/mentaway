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
		try {
			unset($document->_deleted_conflicts);
			$response = $this->db->storeDoc($document);
			
			//se for um registro novo, e tiver amigos entao notifica eles q tem novidade
			if (isset($document->_rev) == false && isset($document->friends) && count((array)$document->friends) > 0) {
				Queue::add('notification_worker', $document->friends);
			}
						
			return $response;
		} catch (Exception $e) {
			//se deu conflict update entao tenta recuperar a ultima versao do doc e salva novamente
			if ($e->getCode() == 409) {
				$doc_last_rev = $this->db->getDoc($document->_id);
				
				if ($document->lat) {
					//se for um placemark e deu conflito ao salvar recupera a ultima revisao e faz um sync dos amigos
					$document->friends = array_values(array_unique(array_merge((array)$doc_last_rev->friends, (array)$document->friends)));
				} elseif ($document->fullname) {
					//ta atualizando o usuario entao tem q preservar os stats e amigos
					
					$document->friends = array_values(array_unique(array_merge((array)$doc_last_rev->friends, (array)$document->friends)));
					
					$document->cities = array_values(array_unique(array_merge((array)$doc_last_rev->cities, (array)$document->cities)));
					$document->states = array_values(array_unique(array_merge((array)$doc_last_rev->states, (array)$document->states)));
					$document->countries = array_values(array_unique(array_merge((array)$doc_last_rev->countries, (array)$document->countries)));
				}
				
				$document->_rev = $doc_last_rev->_rev;

				$this->save($document);
			}
		}

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
			
			//se ele chamou o geo_reverso via ajax primeiro vai tentar paro o usuario autenticado
			//se não achar dai faz para outros users q precisam fazer geo reverso
			if ($view_name == 'reverse_geo' && count($result->rows) == 0) {
				$result = $this->db->getView($design_document, $view_name);	
			}			
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