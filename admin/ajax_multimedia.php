<?
$uploaddirpublic = "/home/s/skeitol/skeitol.ru/public_html/";
$uploaddir = "/home/s/skeitol/skeitol.ru/public_html/images/";
if(isset($_POST["act"]))
{
	$_POST["act"]=htmlspecialchars($_POST["act"]);
	//Создание директории
	if($_POST["act"]=="create_folder")
	{
		if(!empty($_POST["type"])&&!empty($_POST["id"]))
		{
			$uploaddir.=$_POST["type"]."/".$_POST["id"]."/";			
			if(!file_exists($uploaddir))
				if(@mkdir($uploaddir))
					echo"1";
				else echo"0";
		}
	}
}
?>