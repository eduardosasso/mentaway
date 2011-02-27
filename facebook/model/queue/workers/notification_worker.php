<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Notification_Worker extends Worker {
	protected function process($data) {
		$friends = $data;
		
		//Log::write("$username - inc do contador");
		//notifica os amigos desse usuario q ele tem novidades.
		//so entra aqui 1 vez por servico quando tem novidade para ser mais rapido. 
		
		foreach ($friends as $friend) {
			Notification::inc_counter($friend);	
		}		
	}
}

$worker = new Notification_Worker();
$worker->run();

?>
