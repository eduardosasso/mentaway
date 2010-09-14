<?php
interface DatabaseInterface
{
	public function save($document);
	public function get_placemarks($user, $trip = '');
	
	public function save_user($user);
	public function get_user($user);	
}
?>