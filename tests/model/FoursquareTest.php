<?php 
include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

//phpunit tests/model/FoursquareTest.php
class FoursquareTest extends PHPUnit_Framework_TestCase {
		public function test_get_updates() {
			$db = DatabaseFactory::get_provider();
			$controller = new Controller();
			
			$username = '1335915461';
					
			//$service = $controller->get_user_service($username, 'foursquare');
			
			//$url = "https://api.foursquare.com/v2/users/self/checkins?limit=250&oauth_token=" . $service->secret;
			
			// $url = "https://api.foursquare.com/v2/users/self/checkins?oauth_token=" . "JT3BTPEQJCVTF5YANVRO4NFFLOOTG5WQQRCLVXPZBCPQQDB0";
			// 
			// echo "$url";
			// 
			// $res = Helper::http_req($url);
			// $checkins = json_decode($res);
			// 
			// foreach ($checkins->response->checkins->items as $checkin) {
			// 	if ($checkin->photos->count > 0) {
			// 		$image = $checkin->photos->items[2]->url;
			// 		$image_url = $checkin->photos->items[0]->url;
			// 		
			// 		
			// 	}
			// }

			$foursquare = new Foursquare();
			$placemarks = $foursquare->get_updates($username);
			
			print_r($placemarks);

		}
}
?>