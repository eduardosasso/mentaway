<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Twitter_Worker extends Worker {
	protected function process($data) {
		$username = $data;
		
		$foursquare = new Twitter();		
		$foursquare->get_updates($username);
		
		Queue::add('twitter_worker', $username);
	}
}

$worker = new Twitter_Worker();
$worker->run();

?>
