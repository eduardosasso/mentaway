<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Follow_Friends_Worker extends Worker {	
	protected function process($data) {
		$username = $data;
		
		$friend = new Friend();
		$friend->follow_facebook_friends($username);

	}
}

$worker = new Follow_Friends_Worker();
$worker->run();

?>