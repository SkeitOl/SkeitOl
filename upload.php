<?php header('Content-Type: text/html; charset= utf-8');?>
<?php
include("lock.php");
echo"l=".count($_FILES['filename']['name'])."<br>";
	if(count($_FILES['filename']['name'])>0)
	{
		$uploaddir = "/home/sl.ru/www/images/";
		if(isset($_POST['uploaddir']))$uploaddir=$uploaddir.$_POST['uploaddir']."/";
		if(!file_exists($uploaddir))@mkdir($uploaddir);	
		echo '1';
		foreach($_FILES['filename']['name'] as $k=>$f){
			//if (!$_FILES['filename']['error'][$k])
				if (is_uploaded_file($_FILES['filename']['tmp_name'][$k])){
				echo '2';
					if (move_uploaded_file($_FILES['filename']['tmp_name'][$k], $uploaddir.$_FILES['filename']['name'][$k])){
						echo 'Файл: '.$_FILES['filename']['name'][$k].' загружен.<br />';
					}
					else echo 'Error upload file: '.$_FILES['filename']['name'][$k].'.<br />';
	}}}	

   /*if($_FILES["filename"]["size"] > 1024*20*1024)
   {
     echo ("Размер файла превышает 20 мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
	 /*
	if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
	{
	 // Если файл загружен успешно, перемещаем его
	 // из временной директории в конечную
	 if(move_uploaded_file($_FILES["filename"]["tmp_name"],$uploadfile))
	 echo "Файл '<span style='color:#228B22;'>".$_FILES["filename"]["name"]."</span>' успешно загружен";
	} else echo"<span style='color:#EE0000;'>Ошибка загрузки файла</span>";
	*/
	
	/*
	
	*/
	unset($_FILES['filename']);
?>