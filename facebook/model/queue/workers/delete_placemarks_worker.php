<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Delete_Placemarks_Worker extends Worker
{
	protected function process($data) {
		$db = DatabaseFactory::get_provider();

		$username = $data->username;
		$service_id = $data->service;

		$key = array("$username", "$service_id");
		$placemarks = $db->get()->startkey($key)->endkey($key)->getView('placemark','by_service_type');

		foreach ($placemarks->rows as $key => $placemark) {
			$db->get()->deleteDoc($placemark->value);
		}

	}
}

$worker = new Delete_Placemarks_Worker();
$worker->run();

?>