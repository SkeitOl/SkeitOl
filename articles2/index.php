<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/header.php");
?>
<pre>
<?php
//$DB_ART=new DBArticles();
//$result = mysql_query("SELECT * FROM articles WHERE id=$id AND active=1", $db);
//var_dump($SketOl->GetList(DBArticles::$DB_NAME,array("id"),array("id"=>136,"active"=>1)));
//var_dump($SketOl->GetList(DBArticles::$DB_NAME,array("select"=>array("id","views"),"filter"=>array(">=id"=>130,    "active"=>1),"limit"=>array("top"=>5,"bottom"=>7))));
?>
</pre>
<?
DBArticles::ArticlesList(array(
    "SELECT_CODE"=>array("*"),
    "COUNT"=>3,
//    "SORT_BY"=>"desc",
//    "SORT_ORDER"=>"url",
    //"FILTER"=>array("id"=>array(84,97))
));
?>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/footer.php");
?>
