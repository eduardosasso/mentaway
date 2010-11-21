<?php 
class Message { 
	const INFO = 'info';
	const ERROR = 'error';
	
	public static function show($message, $type = Message::INFO) {
		$_SESSION["message"] = $message;

		$_SESSION["message-type"] = $type;
	}
	
	public static function get() {
		$messages = $_SESSION["message"];
		unset($_SESSION["message"]);
		return $messages;
	}	
	
	public static function get_type() {
		$message_type = $_SESSION["message-type"];
		unset($_SESSION["message-type"]);
		return $message_type;
	}	
	
}
 
$messages = Message::get();
$message_type = Message::get_type();
	
?>