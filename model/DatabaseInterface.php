<?php
interface DatabaseInterface
{
	public function save($document);
	public function get_placemarks($user, $trip = '');
	
	public function save_user($user);
	public function add_user_service($username, Service $service);
	public function remove_user_service($username, $service_id);
	public function get_user($user);	
	
	public function clean_database();
}
?>