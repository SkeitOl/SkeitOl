<?php
/*
ini_set("display_errors",1);
error_reporting(E_ALL);

function IsPalindrom($s){
	$ret=false;
	if(strlen($s)>=2){
		$ret=true;
		$n=mb_strlen($s);
		for($i=0;$i<$n/2;$i++)
			if(mb_substr($s,$i,1,'utf-8')!=mb_substr($s,$n-1-$i,1,'utf-8'))
			{
				$ret=false;break;
			}
	}
 	return $ret;
}

$s="pdp";
echo"s=$s<br>";
echo (IsPalindrom($s))?"true":"false";
/*
header("HTTP/1.0 404 Not Found"); 
header("HTTP/1.1 404 Not Found"); 
//header("Status: 404 Not Found"); 
die();

echo 'HTTP_HOST: '.$_SERVER['HTTP_HOST'].'<br>REQUEST_URI: '.$_SERVER['REQUEST_URI'].'<br>';


if(stristr($_SERVER['REQUEST_URI'], 'ThankYou.php') == true)
{
 echo '"earth" найдена в строке';
}
else  echo '"earth" не найдена в строке';*/
/*
if(mail("eraga.oleg@gmail.com", "TEST SUBJECT", "TEST BODY"))
echo "Почтовая система работает!";
else
echo "Неудача, почтовая система не работает, попробуйте еще!";
*/

echo $_SERVER['DOCUMENT_ROOT']."";

$array = array('1' =>3 ,'2'=>2 );
echo"<pre>";
print_r($array);
echo"</pre>";
foreach ($array as $key => &$value) {
	$value*=3;
}
unset($value);
echo"<pre>";
var_dump($array);
echo"</pre>";
?>