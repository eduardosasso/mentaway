<?php 
class Message { 
	const INFO = 'info';
	const ERROR = 'error';

	const INLINE = 'inline';
	const ALERT = 'alert';
	
	public static function show($message, $type = Message::INFO, $format = Message::INLINE) {
		$_SESSION["message"] = $message;

		$_SESSION["message-type"] = $type;

		$_SESSION["message-format"] = $format;
	}
	
	public static function get_message() {
		$messages = $_SESSION["message"];
		unset($_SESSION["message"]);
		return $messages;
	}	
	
	public static function get_type() {
		$message_type = $_SESSION["message-type"];
		unset($_SESSION["message-type"]);
		return $message_type;
	}	
	
	public static function get_format() {
		$message_format = $_SESSION["message-format"];
		unset($_SESSION["message-format"]);
		return $message_format;
	}	
	
	public static function get() {
		$messages = '';
		
		$message = Message::get_message(); 
		$message_type = Message::get_type();
		$message_format = 'message-' . Message::get_format();

		if (!empty($message)) {
			$messages = "<div id='messages' class='$message_type $message_format'>$message</div>";
		}
		
		return $messages;
		
	}
	
}

?>