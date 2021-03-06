<?php
interface DatabaseInterface
{
	public function save($document);
	public function get_placemarks($user);
	
	public function save_user($user);
	public function add_user_service($username, Service $service);
	public function add_user_trip($username, $trip);
	public function remove_user_service($username, $service_id);
	public function get_user($user);	
	public function get_all_users();	
	
	public function clean_database();
}
?>