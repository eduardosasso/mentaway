<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

class Update_Checkins_Worker extends Worker {
	protected function process($data) {
		$controller = new Controller();
		
		$doc = $controller->get_doc($data->docid);
		
		//Log::write(print_r($data, true));
		
		if ($data->type == 'friends') {
			$user = $controller->get_user($data->username);
			
			$doc->friends = array_values(array_unique(array_merge((array)$doc->friends, (array)$user->friends)));
		}
		
		if ($data->type == 'geo') {
			$doc->country = $data->country;
			$doc->state = $data->state;
			$doc->city = $data->city;
			
			$user = $controller->get_user($doc->user);
			
			$user->cities = array_values(array_unique(array_merge((array)$user->cities, array($doc->city))));
			$user->states = array_values(array_unique(array_merge((array)$user->states, array($doc->state))));
			$user->countries = array_values(array_unique(array_merge((array)$user->countries, array($doc->country))));
			
			$controller->save($user);
			
		}

		$controller->save($doc);
		
	}
}

$worker = new Update_Checkins_Worker();
$worker->run();

?>
