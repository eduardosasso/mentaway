<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Facebook_Places_Worker extends Worker {
	protected function process($data) {
		$username =  $data;
		
		$places = new Facebook_Places();
		$places->get_updates($username);
	}
}

$facebook_places = new Facebook_Places_Worker();
$facebook_places->run();

?>
