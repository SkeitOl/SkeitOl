<?php

$file = 'data_ar.json';
// Открываем файл для получения существующего содержимого
$current = file_get_contents($file);
// Добавляем нового человека в файл
//$current = "$stringJson";
//// Пишем содержимое обратно в файл
//file_put_contents($file, $current);

$current=json_decode($current);

?><pre><?print_r($current)?></pre><?