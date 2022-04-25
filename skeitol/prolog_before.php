<?php
//Ядро
/*if (!require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/core/Core.php")) {
	die("Error include core");
}


global $SKEITOL;
$SKEITOL = new SkeitOl\Core();
*/
if (!defined('DOC_ROOT')) {
	define('DOC_ROOT', $_SERVER["DOCUMENT_ROOT"]);
}

try {
	session_start();
	include_once 'core/connection.php';
	include_once 'core/application.php';
	include_once 'core/cbresult.php';
	include_once 'core/CPHPCache.php';
	include_once 'core/Util.php';

} catch (\Exception $ex) {
	echo $ex->getMessage();
}