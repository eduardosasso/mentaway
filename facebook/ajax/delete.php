<?php
include $_SERVER["DOCUMENT_ROOT"] . '/classes.php';

$docid = $_REQUEST['docid'];

$controller = new Controller();

if ($docid) {
	$db = DatabaseFactory::get_provider();
	
	$doc = $db->get()->getDoc($docid);
	
	$db->get()->deleteDoc($doc);
}

?>