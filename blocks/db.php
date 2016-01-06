<?
include_once($_SERVER["DOCUMENT_ROOT"]."/blocks/db_settings.php");
$mysqli = new mysqli($SETTINGS['DB_CON']['HOSTNAME'],$SETTINGS['DB_CON']['USERNAME'],$SETTINGS['DB_CON']['PASSWORD'], $SETTINGS['DB_CON']['DB_NAME']);
/* проверяем соединение */
if (mysqli_connect_errno()) {
    printf("Ошибка соединения: %s\n", mysqli_connect_error());
    die();
}?>