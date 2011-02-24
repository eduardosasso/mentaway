<?php
//php chamado via ajax pela classe Geo.js. Utilizado para salvar pais,estado e cidade via geocode reverso.
include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

$docid = $_REQUEST['docid'];

$country = $_REQUEST['country'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];

$controller = new Controller();

if ($docid) {
	try {
		$db = DatabaseFactory::get_provider();

		$doc = $db->get()->getDoc($docid);

		$doc->country = $country;
		$doc->state = $state;
		$doc->city = $city;

		$username = $doc->user;

		$db->get()->storeDoc($doc);
				
		//depois de salvar o geo tenta atualizar o stats do user.
		// $trip = $controller->get_current_trip($username);
		// 
		// 		if (isset($doc->country) && !empty($doc->country)) {
		// 
		// 			if (!isset($trip->name)) {
		// 				$trip->name = 'My Trip';
		// 			}
		// 
		// 			if (!isset($trip->_id)) {
		// 				$trip->_id = 'trip';
		// 			}
		// 			
		// 			if (empty($status)) {
		// 				$status->cities = array();
		// 				$status->states = array();
		// 				$status->countries = array();
		// 			} else {
		// 				$status->cities = (array)$status->cities;
		// 				$status->states = (array)$status->states;
		// 				$status->countries = (array)$status->countries;
		// 			}
		// 
		// 			if (in_array($doc->country, $status->countries) == false) {
		// 
		// 				$status->cities[] = $doc->city;
		// 				$status->states[] = $doc->state;
		// 				$status->countries[] = $doc->country;
		// 
		// 				$Gstatus->cities = array_unique($status->cities);
		// 				$status->states = array_unique($status->states);
		// 				$status->countries = array_unique($status->countries);
		// 
		// 				$trip->status = $status;
		// 
		// 				$controller->add_user_trip($username, $trip);
		// 			}
		// 		}
		
	} catch (Exception $e) {
		Log::write($e->getMessage());
	}

}

?>