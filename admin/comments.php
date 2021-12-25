<?php
include("lock.php");
include("blocks/bd.php");
if (!empty($_POST)) {
    //Удалить записи
    if (!empty($_POST['delete'])) {
        $ID_ITEMS = ($_POST['ID']);
        if (count($ID_ITEMS) <= 0) {
            header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
            die();
        }
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("DELETE FROM comments_articles where ID=" . htmlspecialchars($value), $db);
        }
        if (!$result) echo "Не удалось удалить. " . mysql_error();
        else {
            header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
            die();
        }
    }
    //Одобрить записи
    if (!empty($_POST['CHANGE_APPROVED_TRUE'])) {
        $ID_ITEMS = ($_POST['ID']);
        if (count($ID_ITEMS) <= 0) {
            header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
            die();
        }
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("UPDATE comments_articles SET APPROVED='1' where ID=" . htmlspecialchars($value), $db);
        }
        if (!$result) echo "Не удалось одобрить записи. " . mysql_error();
        else {
            header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
            die();
        }
    }
    //Возможно нужно перезаписать
    if (!empty($_POST['edit'])) {

        $NICK = htmlspecialchars($_POST[NICK]);
        $TEXT = mysql_real_escape_string($_POST[TEXT]);
        $DATE_TIME = htmlspecialchars($_POST[DATE_TIME]);
        $ID_ITEMS = ($_POST['ID']);
        $SRC_IMG = mysql_real_escape_string($_POST['SRC_IMG']);
        $DEPTH_LEVEL = htmlspecialchars($_POST[DEPTH_LEVEL]);
        $APPROVED = (!empty($_POST[APPROVED])) ? "1" : "0";
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("UPDATE comments_articles SET NICK='$NICK',TEXT='$TEXT',DATE_TIME='$DATE_TIME',APPROVED='$APPROVED'
            ,SRC_IMG='$SRC_IMG',DEPTH_LEVEL=$DEPTH_LEVEL where ID=" . htmlspecialchars($value), $db);
        }
        if (!$result) echo "Не удалось обновить";
        else echo "Данные были успешно обновлены";

    }
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

    <style>
        .small-table {
            width: 100%;
        }

        .users_cart {
            box-shadow: 0 1px 8px #9b9a9a;
            padding: 2%;
            max-width: 500px;
            margin: 2% auto;
        }

        .users_cart p {
            margin: 2% 0 !important;
        }

        .users_cart label {
            width: 150px;
            display: inline-block;
            text-align: right;
            margin: 3px 3px 3px 0;
            vertical-align: top;
        }

        .users_cart input[type='text'], .users_cart input[type='email'] {
            height: 1.9rem;
            line-height: 1.9rem;
            padding: 0.2rem 0.5rem;
            border: 1px solid #aaa;
            outline: none;
        }

        .users_cart input[type='text']:focus, .users_cart input[type='email']:focus,
        .users_cart input[type='text']:active, .users_cart input[type='email']:active {
            box-shadow: 0 0 5px #FFE000 !important;
            border: 1px solid #EADD36 !important;
            background: #fff !important;
        }

        .users_cart input[type='text']:hover, .users_cart input[type='email']:hover {
            border: 1px solid #EADD36 !important;
            box-shadow: none !important;
            background: #fff;
        }

        #old_password:focus:invalid, .users_cart input[type='text']:focus:invalid, .users_cart input[type='email']:focus:invalid {
            background: #fff url('https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/invalid.png') no-repeat 98% center;
            box-shadow: 0 0 5px #d45252;
            border-color: #b03535;
        }

        .users_cart input[type='text']:required:valid, .users_cart input[type='text']:required:valid {
            background: #fff url(https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/valid.png) no-repeat 98% center;
            box-shadow: 0 0 2px #5CD053;
            border-color: #5CD053;
        }

        .old_password {
            display: none;
        }

        .com_text {
            min-width: 285px;
            min-height: 75px;
            margin: 0
        }

        .small-table .input_text {
            padding: 5px 10px;
            margin: 8px 0;
            box-sizing: border-box;
            width: 100%
        }
    </style>

    <? if (!empty($ID)) { ?>
        <p><a href="/admin/comments.php" class="link">Весь список</a></p>
        <form action="" method="post">
            <table class="small-table links">
                <thead>
                <tr>
                    <th>Комментарий №<?= $ID ?>:</th>
                </tr>
                </thead>
                <?
                $result = mysql_query("SELECT * FROM comments_articles where ID=" . $ID, $db);
                if (!$result) echo "Нет такого комментария";
                else {
                    $myrow = mysql_fetch_array($result);
                    do {
                        ?>
                        <tr>
                        <td>
                            Имя <br>
                            <input class="input_text" type="text" name="NICK" value="<?= $myrow['NICK'] ?>"></td>
                        </tr>
                        <tr>
                            <td>
                                Текст<br>
                                <textarea class="com_text input_text"
                                          name="TEXT"><?= htmlspecialchars($myrow['TEXT']) ?></textarea></td>
                        </tr>
                        <tr>
                            <td>
                                Дата<br>
                                <input class="input_text" type="text" name="DATE_TIME"
                                       value="<?= $myrow['DATE_TIME'] ?>"></td>
                        </tr>
                        <tr>
                            <td>
                                email<br>
                                <input class="input_text" type="text" name="EMAIL" value="<?= $myrow['EMAIL'] ?>"></td>
                        </tr>
                        <tr>
                            <td>
                                Одобрен <br>
                                <input name="APPROVED" type='checkbox'<?
                                echo(($myrow[APPROVED]) ? "checked" : ""); ?>></td>
                        </tr>
                        <tr>
                            <td>
                                SRC img <br>
                                <input class="input_text" type="text" name="SRC_IMG" value="<?= $myrow['SRC_IMG'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DEPTH_LEVEL<br>
                                <input class="input_text" type="text" name="DEPTH_LEVEL"
                                       value="<?= $myrow['DEPTH_LEVEL'] ?>"></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="/admin/index.php?act=update&tp=articles&id=<?= $myrow['ID_ARTICLES'] ?>" target='_blank'>ID_ARTICLES</a><br>
                                <input class="input_text" type="text" name="ID_ARTICLES"
                                       value="<?= $myrow['ID_ARTICLES'] ?>"></td>
                        </tr>
                        <input type="hidden" name="ID[]" value="<?= $myrow['ID'] ?>">
                        <?
                    } while ($myrow = mysql_fetch_array($result));
                } ?>
            </table>
            <p>
                <input class="save_bth" type="submit" name="edit" value="Изменить">
                <input class="btn del_bth" type="submit" name="delete" value="Удалить">
            </p>
        </form>
    <? } else { ?>
        <h2>Все комментарии:</h2>
        <form action="" method="post">
            <table class="small-table links">
                <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Текст</th>
                    <th>Дата</th>
                    <th>IDitem</th>
                    <th>Одобрен</th>
                    <th>IP</th>
                </tr>
                </thead>
                <?

                if(!require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/core/Core.php"));
                $cl= new \SkeitOl\Core();



                if (isset($_GET['list']))
                    $list = htmlspecialchars($_GET['list']);
                else
                    $list = 1;
                $step = 9;
                $startI = 0;
                $endI = $step - 1;
                if (isset($list)) {
                    if ($list <= 0) {
                        echo"Нет такой страницы!!!<br>Вывод первой страницы";
                    } else {
                        $startI = ($list - 1) * $step;
                        $endI = $startI + $step;
                    }
                }

                $arComments=$cl->GetList("comments_articles",array(
                    //"filter"=>array("id"=>$arr_category)
                    "order"=>array("id"=>"DESC"),
                    "limit"=>array("top"=>$startI,"bottom"=>$endI)

                ));

               // $result = mysql_query("SELECT * FROM comments_articles ORDER BY ID DESC", $db);
                //$myrow = mysql_fetch_array($result);
                //do
                foreach($arComments as $myrow)
                {
                    ?>
                    <tr>
                    <td><input type="checkbox" name="ID[]" value="<?= $myrow['ID'] ?>"></td>
                    <td><a href='/admin/comments.php?ID=<?= $myrow['ID'] ?>'><?= $myrow['ID'] ?></a></td>
                    <td class='align-center'><?= $myrow['NICK'] ?></td>
                    <td class='align-center'><a
                            href='/admin/comments.php?ID=<?= $myrow['ID'] ?>'><?= htmlspecialchars(substr($myrow['TEXT'], 0, 150)) ?></a>
                    </td>
                    <td class='align-center'><?= $myrow['DATE_TIME'] ?></td>
                    <td class='align-center'><?= $myrow['ID_ARTICLES'] ?></td>
                    <td class='align-center'><input type='checkbox' disabled='disabled'
                            <? echo(($myrow[APPROVED]) ? "checked" : ""); ?>></td>
                    <td class='align-center'><?= $myrow['IP'] ?></td>
                    </tr><?
                }
                //while ($myrow = mysql_fetch_array($result));

                //Вывод списка
                $row= $cl->SQLQuery("SELECT COUNT(*) as count FROM comments_articles")[0];
                if ($row['count'] > $step) {//"Записей больше".$step;
                    $page_url="/admin/comments.php";
                    $i = 1;
                    $special_sort='';
                    if(!empty($sort))$special_sort='&sort='.$sort["NAME"];

                ?><p class="no-text-indent">Всего записей: <?=$row['count']?><br>Страница №<?=$list?></p>
                <div style='position: relative;width: 100%; margin: 0px auto;text-align: center;overflow: auto;'>
                        <span class='navigation'><?
                            if ($list == 1)
                                echo"<span class='no-link'><</span>";
                            else
                                echo"<a href='".$page_url."?list=".($list - 1).$special_sort."' data-list='".($list - 1)."' class='ajax_nav_links'><</a>";
                            $n = (int) ($row['count'] / $step);
                            if ($row['count'] % $step > 0)
                                $n++;
                            for ($i = 1; $i <= $n; $i++)
                                if ($i != $list)
                                    echo"<a href='".$page_url."?list=" . ($i).$special_sort."' data-list='".($i)."' class='ajax_nav_links'>" . ($i) . "</a>";
                                else
                                    echo"<span class='no-link'>" . ($i) . "</span>";
                            if ($list == $n)
                                echo"<span class='no-link'>></span>";
                            else
                                echo"<a href='".$page_url."?list=" . ($list + 1) .$special_sort."' data-list='".($list+1)."' class='ajax_nav_links'>></a>";
                            echo"</span>";
                            echo"</div>";
                    }


                ?>
            </table>
            <div class="m-b-10 m-t-10">
            <input class="btn btn_delete" type="submit" name="delete" value="Удалить выделенное"
                   onclick="if(!confirm('вы уверены что хотите удалить элементы?'))return false;">
            <input class="btn btn_save" type="submit" name="CHANGE_APPROVED_TRUE" value="Одобрить выделенное">
            </div>
        </form>
    <? } ?>
</div>
</body>
</html>
