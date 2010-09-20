<?php 
require_once("Service.class.php");
require_once("Trip.class.php");

class User {  
	public $_id;
	public $username;
	public $fullname;
	public $token;
	public $secret;
	public $bio;
	public $date;
	
	public $services = array(); 
	public $trips = array();
	
	function set_service(Service $service) {
		$this->services[] = $service;
	}
	
	function set_trip(Trip $trip) {
		$this->trips[] = $trip;
	}
	
}
?>