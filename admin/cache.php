<?php
include("lock.php");
//Ядро
if(!require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/prolog_before.php"))
    die("Error include core");

// упрощенная функция scandir
function myscandir($dir)
{
    $list = scandir($dir);
    unset($list[0],$list[1]);
    return array_values($list);
}

// функция очищения папки
function clear_dir($dir)
{
    $list = myscandir($dir);

    foreach ($list as $file)
    {
        if (is_dir($dir.$file))
        {
            clear_dir($dir.$file.'/');
            rmdir($dir.$file);
        }
        else
        {
            unlink($dir.$file);
        }
    }
}

if($_REQUEST["del_type"]=="all"){
    clear_dir($SKEITOL->getCahcePath());
}

header('Content-Type: text/html; charset= utf-8');/*

	  ini_set("display_errors",1);
	  error_reporting(E_ALL);*/

?>
<!DOCTYPE>
<html>
<?
if (isset($_GET['ID'])) $ID = htmlspecialchars($_GET['ID']);
else $ID = 0;


$sys_description = "Просмотр и редактирование информации о пользователе";
$sys_keywords = "SkeitOl, полльзователь SkeitOl,SkeitOl CMS";
$sys_pages = "users";
$sys_pages_print = "Пользователь ";
$sys_title = "Страница пользователя ";

$sys_special_head_text = @'
	<link rel="Stylesheet" type="text/css" href="cal.css?01" />
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js?01"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css?01" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css?01">
	 <!-- End Chose-->
	 <script src="script/cal.js?01"></script>
	 <script type="text/javascript">
		$(document).ready(function(){
		$("#calendar").simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
		});
	</script>
	<script>
		$(document).ready(function() {
			//Когда страница загружается...
			$(".tab_content").hide(); //Скрыть весь контент
			$("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
			$(".tab_content:first").show(); //Показать контент первой вкладки
			//Событие по клику
			$("ul.tabs li").click(function() {
				$("ul.tabs li").removeClass("active"); //Удаление любого "active" класса
				$(this).addClass("active"); //Добавление "active" класса на активную вкладку
				$(".tab_content").hide(); //Скрыть контент вкладок
				var activeTab = $(this).find("a").attr("href"); //Найти href значение атрибута для выявления активной вкладки и контента
				$(activeTab).fadeIn(); //Fade in контента с активным ID
				return false;
			});
		});
		//блокировка Ctr+s
		$(document).bind("keydown", function(e) {
		  if(e.ctrlKey && (e.which == 83)) {
			e.preventDefault();
			{
				//alert("Ctrl+S");
				Save_Page();
			}
			return false;
		  }
		});

		//Вставка html в richtextbox
		function add_html_box(char) {
			var textarea = document.getElementById("text-box");
			switch (char) {
				case "b": textarea.value += "<b></b>"; break;
				case "p": textarea.value += "<p></p>"; break;
				case "img": textarea.value += "<img src=\'\'/>"; break;
				case "a": textarea.value += "<a href=\'\'></a>"; break;
				case "a-out": textarea.value += "<a href=\'\' target=\'_blank\' class=\'link-out\'></a>"; break;
				case "h1": textarea.value += "<h1></h1>"; break;
				case "h2": textarea.value += "<h2></h2>"; break;
				case "h3": textarea.value += "<h3></h3>"; break;
			}
		}
	</script>
	';
include('blocks/head.php'); ?>
<body>
<!-- LEFT block -->
<?php include('blocks/header.php'); ?>
<!-- END LEFT block-->
<!-- LEFT block -->
<?php include('blocks/lefttd.php'); ?>
<!-- END LEFT block-->
<div id="content">
<div style="margin: 10px;padding: 10px">

    <form action="">
        <p>Очистить папку кеша.</p>
        <ul>
            <li><input id="checkbox_clear_all" type="checkbox" name="del_type" value="all"><label for="checkbox_clear_all">Все <?=SkeitOl\Util::getStrFileSize(SkeitOl\Util::getFilesSize($SKEITOL->getCahcePath()))?></label></li>
        </ul>
        <p><input type="submit" class="btn" value="Начать"></p>
    </form>
</div>

</div>
</body>
</html>