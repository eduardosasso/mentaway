<?php
interface DatabaseInterface
{
	public function save_placemark($placemark);
	public function get_placemarks();
	
	public function save_user($user);
	public function get_user($user);	
}
?>