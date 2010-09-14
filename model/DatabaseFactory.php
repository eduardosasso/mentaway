<?php 
require_once("MongoDatabase.php");

//Factory basico para abstrair o banco de dados utilizado pelo resto da app
class DatabaseFactory {
	public static function get_provider() {
		return new MongoDatabase();
	}
}	
?>