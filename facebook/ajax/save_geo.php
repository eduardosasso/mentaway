<?php
//php chamado via ajax pela classe Geo.js. Utilizado para salvar pais,estado e cidade via geocode reverso.
include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

$docid = $_REQUEST['docid'];

$country = $_REQUEST['country'];
$state = $_REQUEST['state'];
$city = $_REQUEST['city'];


if ($docid) {
	$data = array("type"=>"geo", "country" => $country, "state" => $state, "city" => $city, "docid"=>$docid);
	
	Queue::add('update_checkins_worker', $data);

}
