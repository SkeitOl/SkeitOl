<?php
header('Content-Type: text/html; charset= utf-8');	
include("lock.php");
if(isset($_POST['tp'])&&(isset($_POST['activ']))){	
$tp=$_POST['tp'];	$act=$_POST['activ'];}

if(isset($_GET['step']))$step=$_GET['step'];else $step=10;

if(isset($_POST['list']))$list=$_POST['list'];else if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
$result = mysql_query("SELECT COUNT(*) as count FROM ".$tp." ",$db);	  
$row=mysql_fetch_array($result);

if($row['count']>$step)
{	
	$i=1;
	echo"<h1 id='ComboBox1'>Страница №$list</h1>";	
	echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;overflow: auto;'>";		
	echo"<span class='navigation'>";			
	if($list==1)echo"<span class='no-link'><</span>";			
	else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list-1)."><</a>";			
	$n=(int)($row['count']/$step);			
	if($row['count']%$step>0)$n++;			
	for($i=1;$i<=$n;$i++)				
		if($i!=$list)					
			echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($i).">".($i)."</a>";				
		else					
			echo"<span class='no-link'>".($i)."</span>";			
	if($list==$n)echo"<span class='no-link'>></span>";			
	else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list+1).">></a>";		
	echo"</span>";					
	echo"</div>";
}

$startI=0;$endI=$step-1;
if(isset($list)){	
	if($list<=0){
	echo"Нет такой страницы!!!<br>Вывод первой страницы";}	
	else{
	$startI=($list-1)*$step;
	$endI=$startI+$step;}
}

include("blocks/bd.php");
$result = mysql_query("SELECT id,title FROM $tp ORDER BY id DESC LIMIT $startI,$endI",$db);	 
if (!$result) {
    $message  = 'Неверный запрос: ' . mysql_error() . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}
$myrow=mysql_fetch_array($result);
$i=1;
do{
printf("<p><input name='id[]' type='checkbox' value='%s'><label>%s</label></input></p>",$myrow['id'],$myrow['title']);	$i++;
}
while($i<=$step && $myrow= mysql_fetch_array($result));
echo"<input name='activ' type='text' style='display:none;' value='".$act."'><input name='tp' type='text' style='display:none;' value='".$tp."'>";

?>