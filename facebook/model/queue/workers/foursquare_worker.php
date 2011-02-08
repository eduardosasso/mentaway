<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Foursquare_Worker extends Worker {
	protected function process($data) {
		$username = $data;
		
		$foursquare = new Foursquare();		
		$foursquare->get_updates($username);
		
		Queue::add('stats_worker', $username);
	}
}

$worker = new Foursquare_Worker();
$worker->run();

?>
