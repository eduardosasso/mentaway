<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class User {  
	public $_id;
	public $username;
	public $fullname;
	public $email;
	public $picture;
	public $site;
	public $token;
	public $secret;
	public $bio;
	public $date;
	public $notification; //true or false se ele quer receber alguma coisa por email
	public $maptype;
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