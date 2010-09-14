<?php 
require_once("DatabaseInterface.php");

class MongoDatabase implements DatabaseInterface { 
	
	public function save_placemark($placemark) {
		return "aaa";
	}
	
	public function get_placemarks() {
				return "b";
	}
	
	public function save_user($user) {
				return "c";
	}
	
	public function get_user($user) {
				return "d";
	}
	

}
?>