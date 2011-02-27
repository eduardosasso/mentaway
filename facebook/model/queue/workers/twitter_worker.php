<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Twitter_Worker extends Worker {
	protected function process($data) {
		$username = $data;
		
		$twitter = new Twitter();		
		$twitter->get_updates($username);
		
		//Queue::add('stats_worker', $username);
	}
}

$worker = new Twitter_Worker();
$worker->run();

?>
