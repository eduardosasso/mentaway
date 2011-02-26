<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Update_Checkins_Worker extends Worker {
	protected function process($data) {
		$controller = new Controller();
		
		$doc = $controller->get_doc($data->docid);
		
		Log::write(print_r($data, true));
		
		if ($data->type == 'friends') {
			$doc->friends = array_unique(array_merge((array)$doc->friends, array_unique((array)$data->friends)));
		}
		
		if ($data->type == 'geo') {
			$doc->country = $data->country;
			$doc->state = $data->state;
			$doc->city = $data->city;
			
			// $user = $controller->get_user($doc->user);
			// 			$user->trips[0]->status->cities[]  
			
			//tem q fazer todo esse processo em outro worker... para processar em fila, e não paralelo.

			//depois de salvar o geo tenta atualizar o stats do user.
			// $trip = $controller->get_current_trip($username);
			// $trip = $controller->get_current_trip($username);
			// 
			// 		if (!isset($trip->name)) {
			// 			$trip->name = 'My Trip';
			// 		}
			// 
			// 		if (!isset($trip->_id)) {
			// 			$trip->_id = 'trip';
			// 		}
			// 
			// 		if (isset($trip->status)) {
			// 			$status = $trip->status;
			// 		}
			// 
			// 		if (empty($status)) {
			// 			$status->cities = array();
			// 			$status->states = array();
			// 			$status->countries = array();
			// 		} else {
			// 			$status->cities = (array)$status->cities;
			// 			$status->states = (array)$status->states;
			// 			$status->countries = (array)$status->countries;
			// 		}
			// 
			// 		$status->cities[] = $city;
			// 		$status->states[] = $state;
			// 		$status->countries[] = $country;
			// 
			// 		$Gstatus->cities = array_unique($status->cities);
			// 		$status->states = array_unique($status->states);
			// 		$status->countries = array_unique($status->countries);
			// 
			// 		$trip->status = $status;
			// 
			// 		$controller->add_user_trip($username, $trip);
			
		}

		$controller->save($doc);
		
	}
}

$worker = new Update_Checkins_Worker();
$worker->run();

?>
