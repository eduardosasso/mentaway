<?php
//php chamado via ajax pela classe Geo.js. Utilizado para salvar pais,estado e cidade via geocode reverso.
include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

$docid = $_REQUEST['docid'];

$country = $_REQUEST['country'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];

$controller = new Controller();

if ($docid) {
	$db = DatabaseFactory::get_provider();
	
	$doc = $db->get()->getDoc($docid);

	$doc->country = $country;
	$doc->state = $state;
	$doc->city = $city;
	
	$db->get()->storeDoc($doc);
}

?>