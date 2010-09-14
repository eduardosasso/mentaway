<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$q = $_REQUEST['q'];

$args = explode("/", $q);  

$user = $q;
/*
	TODO aqui tem q validar a variavel user acima
*/
$is_user = true;

$safe_pages = array("user", "search", "thread");  

if (in_array($args[0], $safe_pages)) {
	include($args[0].".php");  
} elseif ($is_user) {
	include("index.php");
} else {
	include("404.php");  
}
?>