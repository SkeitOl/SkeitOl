<?php header('Content-Type: text/html; charset= utf-8');?>
<?php
include("lock.php");
	echo"<p>Кол-во переданых файлов: ".count($_FILES['filename']['name'])."</p>";
	if(count($_FILES['filename']['name'])>0)
	{
	/*echo 'Document root: '.$_SERVER['DOCUMENT_ROOT'].'<br>';
echo 'Полный путь к скрипту и его имя: '.$_SERVER['SCRIPT_FILENAME'].'<br>';
echo 'Имя скрипта: '.$_SERVER['SCRIPT_NAME'].'<br>';*/
		$uploaddir = "/home/s/skeitol/skeitol.ru/public_html/images/";
		if(isset($_POST['uploaddir']))$uploaddir=$uploaddir.$_POST['uploaddir']."/";
		if(!file_exists($uploaddir))@mkdir($uploaddir);	
		//echo '1<br>';
		?>
		<style>
			.file_name{color:#488F15;}
			.file_src{color:#3E6026;}
			p{margin: 5px 0;}
			pre{margin: 3px 0;}
		</style>
		<?
		echo '<ul>';
		foreach($_FILES['filename']['name'] as $k=>$f){
			//if (!$_FILES['filename']['error'][$k])
			if (is_uploaded_file($_FILES['filename']['tmp_name'][$k])){
				
				if (move_uploaded_file($_FILES['filename']['tmp_name'][$k], $uploaddir.$_FILES['filename']['name'][$k])){
					echo '<li>Файл: <span class="file_name">'.$_FILES['filename']['name'][$k].'</span> загружен в <span class="file_src">'.$uploaddir.'</span>';
					$url=str_replace($_SERVER['DOCUMENT_ROOT'],"",$uploaddir.$_FILES['filename']['name'][$k]);
					?><img src="<?=$url?>" height="30px" alt="">
					<p>Ссылка на файл: </p>
					<pre><?=$url?></pre></li>
					<?
				}
				else echo 'Error upload file: '.$_FILES['filename']['name'][$k].'.<br />';
			}		
		}echo '</ul>';
	}	

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