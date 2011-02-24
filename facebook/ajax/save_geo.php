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
		$trip = $controller->get_current_trip($username);

		Log::write("antes de tentar fazer o geo-reverso");
		Log::write(print_r($document, 1));

		if (isset($document->country) && !empty($document->country)) {
			Log::write("nao tem pais");
			Log::write(print_r($document, 1));

			if (!isset($trip->name)) {
				$trip->name = 'My Trip';
			}

			if (!isset($trip->_id)) {
				$trip->_id = 'trip';
			}

			if (isset($trip->status)) {
				Log::write("tem trip status");
				$status = $trip->status;
			} else {
				Log::write("não tem trip status");
				$status->countries = array();
				$status->states = array();
				$status->cities = array();
			}

			if (in_array($document->country, $status->countries) == false) {
				Log::write($document->country . " não ta no array de paises");

				$status->cities[] = $document->city;
				$status->states[] = $document->state;
				$status->countries[] = $document->country;

				$Gstatus->cities = array_unique($status->cities);
				$status->states = array_unique($status->states);
				$status->countries = array_unique($status->countries);

				$trip->status = $status;

				Log::write("Antes de salvar a tripG");
				Log::write(print_r($trip, 1));

				$controller->add_user_trip($username, $trip);
			}
		}

	} catch (Exception $e) {
		Log::write($e->getMessage());
	}

}

?>