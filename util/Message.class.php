<?php 
class Message { 
	
	public static function set($message) {
		$_SESSION["message"] = $message;
	}
	
	public static function get() {
		$messages = $_SESSION["message"];
		unset($_SESSION["message"]);
		return $messages;
	}	
}
 
$messages = Message::get();
	
?>

