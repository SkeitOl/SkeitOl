<?php
include("blocks/bd.php");
include_once($_SERVER['DOCUMENT_ROOT']."/modules/functions.php");


///
$categories=array();
$result1 = mysql_query("SELECT id,name FROM category", $db);
$row = mysql_fetch_array($result1);
do {
    $categories[$row["id"]]=array("ID"=>$row["id"],"NAME"=>$row["name"]);
} while ($row = mysql_fetch_array($result1));

//
/*?><pre><?print_r($categories)?></pre><?*/

$sql_sort_name='date';
$step = 1000000;
$startI = 0;
$endI = $step - 1;




$result = mysql_query("SELECT * FROM articles  ORDER BY ".$sql_sort_name." DESC LIMIT $startI,$endI", $db);
$myrow = mysql_fetch_array($result);
$in = 1;

$arResult=array();
do
{
    $tags="";
    if($myrow["category"]){
        $ar=unserialize($myrow["category"]);
        if(is_array($ar)){
            foreach($ar as $value){
                if($categories[$value]){
                    $tags.=$categories[$value]["NAME"].", ";
                }

            }
        }
    }
    if($tags){
        $tags=substr($tags,0,-2);
    }

    $src=$myrow["src_preview"];

    if(strpos($src,array("https:","https:"))===false){
        $src='https://skeitol.ru'.$src;
    }

    $obj=array(
        "ID"=>$myrow["id"],
        "TITLE"=>$myrow["title"],
        "PREVIEW_TEXT"=>$myrow["description"],
        "DATE_ACTIVE"=>$myrow["date"],
        "DETAIL_TEXT"=>$myrow["text"],
        "AUTHOR"=>$myrow["author"],
        "ACTIVE"=>($myrow["active"]==1)?"Y":"N",
        "SECTION_CODE"=>$myrow["url"],
        "VIEWS"=>$myrow["views"],
        "meta_description"=>$myrow["meta_description"],
        "meta_keywords"=>$myrow["meta_keywords"],
        "meta_title"=>$myrow["meta_title"],
        "src_preview"=>$src,
        "TAGS"=>$tags,
    );

    $arResult[]=$obj;
    $in++;
}
while ($in <= $step && $myrow = mysql_fetch_array($result));


$stringJson=json_encode($arResult, JSON_UNESCAPED_UNICODE);

$file = 'data_ar.json';
// Открываем файл для получения существующего содержимого
//$current = file_get_contents($file);
// Добавляем нового человека в файл
$current = "$stringJson";
// Пишем содержимое обратно в файл
file_put_contents($file, $current);


/*?><pre><?print_r($arResult)?></pre><?*/