<?php  header('Content-Type: text/html; charset= utf-8');
include("lock.php");if( isset($_POST['title'])){$title=$_POST['title'];	if($title=='') unset($title);}if(isset($_POST['date'])) 		 {$date=$_POST['date'];     if($date==''){unset($date);} }if(isset($_POST['description'])) {$description=$_POST['description'];if($description==''){unset($description);} }if(isset($_POST['text']))        {$text=$_POST['text'];      if($text==''){unset($text);} }if(isset($_POST['author'])) 	 {$author=$_POST['author'];   if($author==''){unset($author);} }if(isset($_POST['id'])) {$id=$_POST['id']; if($id==''){unset($id);}}if(isset($title)&&isset($date)&&isset($description)	  &&isset($text)&&isset($author)&&isset($id)){    
$text = mysql_real_escape_string($text);
$result= mysql_query("UPDATE programm SET title='$title',date='$date',description='$description',text='$text',		  url='$author' WHERE id='$id'");    
if($result=='true'){echo "<p>Данные успешно обнолены</p>";}    
else {echo "<p>Ошибка обновления =(</p>";}}
else echo "<p>Введена не вся информация</p>"?>