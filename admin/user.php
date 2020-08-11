<?php header('Content-Type: text/html; charset= utf-8');
	  /*
	  ini_set("display_errors",1);
	  error_reporting(E_ALL);*/

	  include("lock.php");
	  include("blocks/bd.php");/*
echo"<pre>";
print_r($_POST);
echo"</pre>";*/
?>
<!DOCTYPE>
<html>
<?

if(isset($_GET['edit_user']))
{
	$edit_user=htmlspecialchars($_GET[edit_user]);
	//echo"edit_user=$edit_user<br>";
	$query = "SELECT * FROM userlist WHERE id='".$edit_user."'";
	$lst = @mysql_query($query);
	//if (mysql_num_rows($lst) == 0) exit();
	$arr =  @mysql_fetch_array($lst);
	$user["user"]= $arr['user'];
	$user["FIRST_NAME"]= $arr['FIRST_NAME'];
	$user["LAST_NAME"]= $arr['LAST_NAME'];
	$user["EMAIL"]= $arr['EMAIL'];
	$img_src= $arr['IMG_SRC'];
	$user_id= $arr['id'];
	
}
else { echo "Не указан пользователь.";die();}

$sys_description="Просмотр и редактирование информации о пользователе";
$sys_keywords="SkeitOl, полльзователь SkeitOl,SkeitOl CMS";
$sys_pages="users";
$sys_pages_print="Пользователь ".$user["FIRST_NAME"];
$sys_title="Страница пользователя ".$user["FIRST_NAME"];

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
		/*блокировка Ctr+s*/
		$(document).bind("keydown", function(e) {
		  if(e.ctrlKey && (e.which == 83)) {
			e.preventDefault();
			{
				//alert("Ctrl+S");
				Save_Page();
			}
			return false;
		  }
		});/*End блокировка Ctr+s*/
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
.users_cart {box-shadow: 0 1px 8px #9b9a9a;padding: 2%;max-width: 500px;margin: 2% auto;}
.users_cart p {margin:0 0 2% 0 !important;}
.users_cart label {width: 150px;display: inline-block;text-align: right;margin: 3px 3px 3px 0;vertical-align: top;}
.users_cart input[type='text'], .users_cart input[type='email'] {height: 1.9rem;line-height: 1.9rem;padding: 0.2rem 0.5rem;border: 1px solid #aaa;outline: none;}

.users_cart input[type='text']:focus, .users_cart input[type='email']:focus,
.users_cart input[type='text']:active, .users_cart input[type='email']:active {box-shadow: 0 0 5px #FFE000 !important;border: 1px solid #EADD36 !important;background: #fff !important;}
.users_cart input[type='text']:hover, .users_cart input[type='email']:hover {border: 1px solid #EADD36 !important;box-shadow: none !important;background: #fff;}

#old_password:focus:invalid,.users_cart input[type='text']:focus:invalid, .users_cart input[type='email']:focus:invalid { /* when a field is considered invalid by the browser */
background: #fff url('https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/invalid.png') no-repeat 98% center;
box-shadow: 0 0 5px #d45252;border-color: #b03535;}

.users_cart input[type='text']:required:valid, .users_cart input[type='text']:required:valid { /* when a field is considered valid by the browser */
background: #fff url(https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/valid.png) no-repeat 98% center;
box-shadow: 0 0 2px #5CD053;border-color: #5CD053;}


.pas_block{display:none}
.users_cart .col-2-3 label {width: 100%;text-align: left;}
.ava_img{position:relative;display:inline-block;}
.change_pas{font-size: 0.9em;border-bottom: 1px dashed #ccc;color: #00629c;cursor: pointer;}
.change_pas:hover{border:none;color:#9A9A9A;}
#show_new_ava {display:none;position: absolute;cursor:pointer;top: 0;left: 0;background: rgba(0, 0, 0, 0.52) url('/images/fileIcon.png') no-repeat center center;bottom: 0;right: 0;background-size: 30px;}
.ava_img:hover #show_new_ava{display:block;}
.con-box{clear:both; overflow:hidden;}
.col-3,.col-2-3{float:left;}
.col-3{width:33.3333%}
.col-2-3{width: 66.666666%;}

        </style>
        <h2>Профиль пользователя:</h2>

        <form class="users_cart" method="post">
            Основные
			<hr>
            <div class="con-box">
                <div class="col-3 align-center ">
                    <div>
                        <span class="ava_img">
                            <img src="images/ava/<?=$edit_user?>/<?=$img_src?>">
                            <span id="show_new_ava"></span>
                        </span>
                        <input id="new_ava_file" type="file" name="img_src" accept="image/jpeg,image/png,image/gif">
                        <script>
                            document.getElementById("new_ava_file").style.display="none";
                            $("#show_new_ava").click(function(){
                                $("#new_ava_file").trigger('click');
                            });
                            $(function(){
                                $(".change_pas").click(function(){
                                    this.style.display="none";
                                    $(".pas_block").css("display","block");
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-2-3">
                    <div>
                         <p>
                            <label>Ник:</label>
                            <input type="text" name="user_user" required value="<?=$user["user"]?>"/>
                        </p>
                        <p>
                            <span class="change_pas">Изменить пароль</span>
                            <div class="pas_block">
                                <p>
                                    <label>Старый пароль:</label>
                                    <input type="text" id="old_password" name="old_password" value="" />
                                     <br>
                                    <label>Новый пароль:</label>
                                    <input type="text" class="new_password" name="new_password" value="" />
                                </p>
                            </div>
                        </p>
                        
                    </div>
                </div>
           </div>
            <br>
            Дополнительные
            <hr>
            <p>
                <label>Имя:</label>
                <input type="text" name="user_first_name" value="<?=$user["FIRST_NAME"]?>"/>
            </p>
            <p>
                <label>Фамилия:</label>
                <input type="text" name="user_last_name" value="<?=$user["LAST_NAME"]?>"/>
            </p>
            <p>
                <label>E-mail:</label>
                <input type="email" name="user_email"  value="<?=$user["EMAIL"]?>"/>
            </p>
            
            <p>
                <label></label>
                <input type="text" value="<??>"/>
            </p>
            <div style="clear: both; text-align: center; margin: 2% 0 0;">
                <input type="submit" class="save_bth" value="Сохранить" name="save" />
            </div>
        </form>
    </div>
</body>
</html>
