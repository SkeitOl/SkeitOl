<?php 
include("lock.php");
include("blocks/bd.php");
if(!empty($_POST)){
    //Удалить записи
    if(!empty($_POST['delete'])){
        $ID_ITEMS=($_POST['ID']);
        if(count($ID_ITEMS)<=0){header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/comments.php");die();}
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("DELETE FROM comments_articles where ID=".htmlspecialchars($value),$db);    
        }
        if(!$result) echo"Не удалось удалить. ".mysql_error();
        else {header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/comments.php");die();}
    }
    //Одобрить записи
    if(!empty($_POST['CHANGE_APPROVED_TRUE'])){
        $ID_ITEMS=($_POST['ID']);
        if(count($ID_ITEMS)<=0){header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/comments.php");die();}
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("UPDATE comments_articles SET APPROVED='1' where ID=".htmlspecialchars($value),$db);    
        }
        if(!$result) echo"Не удалось одобрить записи. ".mysql_error();
        else {header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/comments.php");die();}
    }    
    //Возможно нужно перезаписать
    if(!empty($_POST['edit']))
    {

        $NICK=htmlspecialchars($_POST[NICK]);
        $TEXT=mysql_real_escape_string($_POST[TEXT]);
        $DATE_TIME=htmlspecialchars($_POST[DATE_TIME]);
        $ID_ITEMS=($_POST['ID']);
        $SRC_IMG=mysql_real_escape_string($_POST['SRC_IMG']);
        $APPROVED=(!empty($_POST[APPROVED]))?"1":"0";
        foreach ($ID_ITEMS as $key => $value) {
            $result = mysql_query("UPDATE comments_articles SET NICK='$NICK',TEXT='$TEXT',DATE_TIME='$DATE_TIME',APPROVED='$APPROVED'
            ,SRC_IMG='$SRC_IMG' where ID=".htmlspecialchars($value) ,$db);
        }
        if(!$result) echo"Не удалось обновить";
        else echo"Данные были успешно обновлены";

    }
}

header('Content-Type: text/html; charset= utf-8');/*
	  
	  ini_set("display_errors",1);
	  error_reporting(E_ALL);*/

	  ?>
<!DOCTYPE>
<html>
<?
if(isset($_GET['ID']))$ID=htmlspecialchars($_GET['ID']);
else $ID=0;




$sys_description="Просмотр и редактирование информации о пользователе";
$sys_keywords="SkeitOl, полльзователь SkeitOl,SkeitOl CMS";
$sys_pages="users";
$sys_pages_print="Пользователь ";
$sys_title="Страница пользователя ";

$sys_special_head_text=@'
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

                    #old_password:focus:invalid,.users_cart input[type='text']:focus:invalid, .users_cart input[type='email']:focus:invalid {
                        background: #fff url('http://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/invalid.png') no-repeat 98% center;
                        box-shadow: 0 0 5px #d45252;
                        border-color: #b03535;
                    }

                    .users_cart input[type='text']:required:valid, .users_cart input[type='text']:required:valid {
                        background: #fff url(http://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/valid.png) no-repeat 98% center;
                        box-shadow: 0 0 2px #5CD053;
                        border-color: #5CD053;
                    }

            .old_password {
                display: none;
            }


            .save_bth {
                background: #25A91B;
                border: none;
                padding: 1%;
                color: #fff;
                cursor: pointer;
                border-radius: 5px;
                outline: none;
            }

                .save_bth:hover, .save_bth:focus {
                    background: #1D6D17;
                }

                .save_bth:active {
                    background: #25A91B;
                    box-shadow: 0 0 5px #1D6D17;
                }
        </style>
        
        <? if(!empty($ID)){ ?>
            <h2>Комментарий №<?=$ID?>:</h2>
            <p><a href="/admin/comments.php" class="link">Весь список</a></p>
            <form action="" method="post">
            <table class="small-table links">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Текст</th>
                        <th>Дата</th>
                        <th>Одобрен</th>
                        <th>SRC img</th>
                        <th>ItemID</th>
                    </tr>
                </thead>
                <?
                $result = mysql_query("SELECT * FROM comments_articles where ID=".$ID ,$db);
                if(!$result) echo"Нет такого комментария";
                else
                {
                    $myrow=mysql_fetch_array($result);                              
                    do
                    {?><tr>
                                <td class='align-center'><input type="text" name="NICK" value="<?=$myrow['NICK']?>"></td>
                                <td class='align-center'><textarea name="TEXT"><?=htmlspecialchars($myrow['TEXT'])?></textarea></td>
                                <td class='align-center'><input type="text" name="DATE_TIME" value="<?=$myrow['DATE_TIME']?>"></td>                           
                                <td class='align-center'><input name="APPROVED" type='checkbox'<?
                                echo(($myrow[APPROVED])?"checked":"");?>></td>
                                <td><input type="text" name="SRC_IMG" value="<?=$myrow['SRC_IMG']?>"></td>
                                <td><input type="text" name="ID_ARTICLES" value="<?=$myrow['ID_ARTICLES']?>"></td>
                            </tr>
                        <input type="hidden" name="ID[]" value="<?=$myrow['ID']?>">
                        <?
                    }
                    while($myrow=mysql_fetch_array($result));
                }?>
            </table>
            <input type="submit" name="edit" value="Изменить">
            <input type="submit" name="delete" value="Удалить">
            </form>
        <?}else{?>
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
                $result = mysql_query("SELECT * FROM comments_articles ORDER BY ID DESC" ,$db);
                    $myrow=mysql_fetch_array($result);                              
                    do
                    {   
                        ?><tr>
                            <td><input type="checkbox" name="ID[]" value="<?=$myrow['ID']?>"></td>
                            <td><a href='/admin/comments.php?ID=<?=$myrow['ID']?>'><?=$myrow['ID']?></a></td>
                            <td class='align-center'><?=$myrow['NICK']?></td>
                            <td class='align-center'><a href='/admin/comments.php?ID=<?=$myrow['ID']?>'><?=htmlspecialchars(substr($myrow['TEXT'],0,150))?></a></td>
                            <td class='align-center'><?=$myrow['DATE_TIME']?></td>                           
                            <td class='align-center'><?=$myrow['ID_ARTICLES']?></td>
                            <td class='align-center'><input type='checkbox' disabled='disabled'
                            <?echo(($myrow[APPROVED])?"checked":"");?>></td>
                            <td class='align-center'><?=$myrow['IP']?></td>
                        </tr><?
                    }
                    while($myrow=mysql_fetch_array($result));
                ?>
            </table>
            <input type="submit" name="delete" value="Удалить выделенное" onclick="if(!confirm('вы уверены что хотите удалить элементы?'))return false;">
            <input type="submit" name="CHANGE_APPROVED_TRUE" value="Одобрить выделенное">
        </form>
        <?}?>
    </div>
</body>
</html>
