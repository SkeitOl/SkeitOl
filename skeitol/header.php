<?php
//Ядро
if(!require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/prolog_before.php")) {
	die("Error include core");
}

//global constant
define("SITE_DIR","/");
define("SITE_TEMPLATE_PATH","/skeitol/templates/main/");


//Шаблон
if(!require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."header.php")) {
	die("Error include template");
}
