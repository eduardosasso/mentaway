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