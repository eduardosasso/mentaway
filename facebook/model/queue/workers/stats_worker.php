<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Stats_Worker extends Worker {
	protected function process($data) {
		$username = $data;
		
		$stats = new Stats();		
		$stats->get_updates($username);
	}
}

$worker = new Stats_Worker();
$worker->run();

?>
