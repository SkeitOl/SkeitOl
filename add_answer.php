<?php
include_once("blocks/bd.php");if( isset($_POST['answer_vl']))      {$vl=$_POST['answer_vl'];if($vl==''){unset($vl);}}if(isset($vl)) {   
if(mysql_query("UPDATE opros SET otv$vl=otv$vl+1 "))   {	   
setcookie('myopros1','���� �������',time()*2);	   
include("blocks/func/func.php");	   PrintOpros();   }  
 else echo "<p>������ ���������� =(</p>";}
 else echo "<p>�� ��� �������� ���� ���������</p>";?>