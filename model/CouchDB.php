<?php 
require_once("DatabaseInterface.php");

require_once "lib/couchdb/couch.php";
require_once "lib/couchdb/couchClient.php";
require_once "lib/couchdb/couchDocument.php";

class CouchDB implements DatabaseInterface { 
	
	private $db;
	
	function __construct() {
		$url = "http://localhost:5984/";
		$database = "mentaway";
		
		$this->db = new couchClient($url,$database);
	}
	
	public function save($document) {
		$response = $this->db->storeDoc($document);
		
		print_r($response);
	}
	
	public function get_placemarks($user, $trip = '') {
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
		return "c";
	}
	
	public function get_user($user) {
		return "d";
	}
}
?>