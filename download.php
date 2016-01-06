<?php

$file		= $_GET["file"]; 
$file_info	= pathinfo($file);
$file_ext	= $file_info['extension'];
$file_name	= $file_info['basename'];
$ignore_ext = array ('php','html','xml','ini','css','js','txt'); // игнорируемые файлы

if($file)
{
	if(file_exists($file) and in_array($file_ext, $ignore_ext)!=1 )
	{
		
		header('Content-type: application/force-download'); 
		header('Content-Disposition: attachment; filename=' . $file_name . ''); 
		readfile( $file ); 
		exit();
	}
	else
	{
		exit ("<center>Неправильное имя файла !<br /><a href='javascript:history.back()'>Вернуться назад</a></center>");
	}
}
else
{
	exit("Restricted access");
}
?>