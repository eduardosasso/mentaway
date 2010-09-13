<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$q = $_REQUEST['q'];

$user = $q;
/*
	TODO aqui tem q validar a variavel user acima
*/
$is_user = true;

$safe_pages = array("user", "search", "thread");  

if (in_array($q, $safe_pages)) {
	include($q.".php");  
} elseif ($is_user) {
	include("index.php");
} else {
	include("404.php");  
}
?>