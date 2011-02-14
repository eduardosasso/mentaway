<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Queue {
	//coloca um job no queue, $tube deve ser o nome da classe q vai ser o worker dele tudo minusculo
	public static function add($tube, $data) {
		$pheanstalk = new Pheanstalk('127.0.0.1:11300');
		$pheanstalk->useTube($tube)->put(json_encode($data));
	}	
}

?>