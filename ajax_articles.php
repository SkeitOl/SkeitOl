<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');

include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/functions.php");

/*$sql_sort_name = 'date';//Сортировка по умолчанию
if (!empty($sort["VALUE"]))
	$sql_sort_name = $sort["VALUE"];
if (isset($_GET['list']))
	$list = htmlspecialchars($_GET['list']);
else
	$list = 1;
$step = 10;
$startI = 0;
$endI = $step - 1;
if (isset($list)) {
	if ($list <= 0) {
		echo "Нет такой страницы!!!<br>Вывод первой страницы";
	} else {
		$startI = ($list - 1) * $step;
		$endI = $startI + $step;
	}
}*/

/*
$result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER
				BY " . $sql_sort_name . " DESC LIMIT $startI,$endI", $db);
$myrow = mysql_fetch_array($result);*/

$article = new Articles();
$article->showArticlesList([]);

include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');