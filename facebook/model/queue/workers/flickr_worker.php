<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Flickr_Worker extends Worker {
	protected function process($data) {
		$username = $data;

		$flickr = new Flickr();		
		$flickr->get_updates($username);
		
		Queue::add('stats_worker', $username);		
	}
}

$worker = new Flickr_Worker();
$worker->run();

?>