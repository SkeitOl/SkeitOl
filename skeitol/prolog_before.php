<?php
//Ядро
if(!require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/core/core.php"))
    die("Error include core");


global $SKEITOL;
$SKEITOL=new SkeitOl\SkeiOl();