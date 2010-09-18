<?php 
require_once("Service.class.php");

class User {  
	public $_id;
	public $username;
	public $fullname;
	public $token;
	public $secret;
	public $bio;
	public $date;
	
	public $services = array(); 
	
	function set_service(Service $service) {
		$this->services[] = $service;
	}
}
?>