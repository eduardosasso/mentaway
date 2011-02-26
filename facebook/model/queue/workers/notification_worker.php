<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Notification_Worker extends Worker {
	protected function process($data) {
		$username = $data;
		
		//Log::write("$username - inc do contador");
		//notifica os amigos desse usuario q ele tem novidades.
		//so entra aqui 1 vez por servico quando tem novidade para ser mais rapido. 
		Notification::inc_counter($username);
	
	}
}

$worker = new Notification_Worker();
$worker->run();

?>
