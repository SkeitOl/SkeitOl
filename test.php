<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//Ядро
if(!require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/prolog_before.php"))
	die("Error include core");


$vars=[];

$obCache = new \SkeitOl\CPHPCache();
if( $obCache->InitCache(30,"test","dir") )// Если кэш валиден
{
	$vars = $obCache->GetVars();
}
elseif( $obCache->StartDataCache()  )// Если кэш невалиден
{
	$vars["asdasd"]=5;

	$obCache->EndDataCache($vars);
}

//SkeitOl\SkeiOl::dump($vars);