<?php

require_once("../model/Controller.php");

$username = $_REQUEST['username'];
$service = $_REQUEST['service'];

$controller = new Controller();

$result = $controller->remove_user_service($username, $service);

echo "ok";

?>
