<?php
class Message { 
	public $title;
	public $body;
	public $file;
	public $page;
	public $format;
	public $uid;
	public $persistent;
}

class Notification {
	const INFO = 'info';
	const ERROR = 'error';

	public static function add($message){
		$message->_id = 'message-' . uniqid();
		$message->type = 'message';
		$message->timestamp = time();

		$db = DatabaseFactory::get_provider();
		$db->save($message);		
	}	

	public static function get($uid, $page){
		$db = DatabaseFactory::get_provider();

		//sintaxe para recuperar as mensagens de um usuario ordenados pela mais recente.
		$startkey = array("$uid", "$page", array());
		$endkey= array("$uid", "$page");
		$messages = $db->get()->descending(true)->startkey($startkey)->endkey($endkey)->getView('notification','user');

		Notification::update_or_remove($messages);

	if (count($messages->rows) > 0) {
		return $messages->rows;
	}
	
	return array();

}

private static function set_fb_counter($username, $count) {
	//faz direto via curl a chamada para tentar ser o mais rapido possivel.
	try {

		$key_secret = Settings::get_facebook_oauth_key();

		$key = $key_secret[0];
		$token = $key_secret[1];

		$url = "https://api.facebook.com/method/dashboard.setCount?uid=$username&count=$count&api_key=$key&format=json-strings&access_token=$key|$token";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);

		curl_exec($ch);
		curl_close($ch);

	} catch (Exception $e) {
		Log::write($e->getMessage());
	}

}

//zera o contador ao lado do icone da app no fb
public static function clean_counter($username) {
	Notification::set_fb_counter($username,0);
}

//inc no contador do fb para o user ou para os amigos dele, sinalizando novidades
public static function inc_counter($username, $friends = true) {
	if ($friends) {
		$controller = new Controller();
		$user = $controller->get_user($username);
		
		if (isset($user->friends)) {
			foreach ($user->friends as $friend) {
				Notification::set_fb_counter($friend,1);
			}
		}
		
	} else {
		Notification::set_fb_counter($username,1);
	}	
}


private static function update_or_remove($messages){
	$db = DatabaseFactory::get_provider();

	foreach ($messages->rows as $key => $message) {
		if ($message->value->persistent == 'false' || empty($message->value->persistent)) {				
			$db->get()->deleteDoc($message->value);
		}

		if ($message->value->persistent == 'true') {
			if (isset($message->value->opened) && (date('Ymd') > $message->value->opened)) {
				//se hj é maior que a data q a msg foi aberta exclui.
				$db->get()->deleteDoc($message->value);
				unset($messages->rows[$key]);
			} else {
				//se é uma msg persistente atualiza a data que ela foi aberta pela primeira vez
				//essa data vai ser comparada para deixar esse tipo de msg visivel por 1 dia a partir 
				//do dia q foi aberta.
				$message_ = $message->value;
				$message_->opened = date('Ymd');
				$db->save($message_);
			}

		}

	}
}

}

?>