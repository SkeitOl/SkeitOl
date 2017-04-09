<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 05.09.16
 * Time: 22:54
 */?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<?$file_style=$_SERVER['DOCUMENT_ROOT'].'/style/style.css';
if(file_exists($file_style)){
    echo'<style>'.file_get_contents($file_style).'</style>';
}
?>
    <title>Document</title>
</head>
<body>

