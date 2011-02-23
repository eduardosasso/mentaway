<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class User {  
	public $_id;
	public $username;
	public $fullname;
	public $email;
	public $date;
	public $status;
	public $services = array(); 
	public $trips = array();
	public $friends = array();
	
	function set_service(Service $service) {
		$this->services[] = $service;
	}
	
	function set_trip(Trip $trip) {
		$this->trips[] = $trip;
	}
	
}
?>