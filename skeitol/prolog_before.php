<?php
//Ядро
if (!require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/core/Core.php")) {
	die("Error include core");
}


global $SKEITOL;
$SKEITOL = new SkeitOl\Core();