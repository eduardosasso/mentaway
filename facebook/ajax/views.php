<?php
//wrapper para chamadas seguras no couchdb. 

header("Content-type: application/json");

include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

$design_document = $_REQUEST['design_document'];
$view_name = $_REQUEST['view_name'];
$key = $_REQUEST['key'];

$controller = new Controller();
$view = $controller->get_view($design_document, $view_name, $key);

error_log(print_r($view,1));

print json_encode($view); 

?>