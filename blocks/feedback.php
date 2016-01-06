<?php
header('Content-Type: text/html; charset= utf-8');
include("blocks/bd.php");
include("blocks/func/func.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Обратная связь</title>
<link rel="stylesheet" type="text/css" href="style/style.css" />
<link rel="SHORTCUT ICON" href="images/S.ico">
<?php include('blocks/encoding.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Plagin view image -->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox.js"></script>
<link href="style/lightbox.css" rel="stylesheet" />
<!-- END Plagin view image -->
</head>
<body>
<?php include("blocks/header.php");?>
<div id='content'>
	<div class='left-con'>
		<div class='con-block'>
			<center><div class='title-small-block'>Обратная связь</div> </center>
			<style>label {color: red;}</style>
			<form id="myForm" name="contactForm" action="add_feedback.php" method="post" enctype="multipart/form-data">
				<p>Ваше имя:<br /><input type="text" name="nik" placeholder="Имя"/><label>*</label></p>
				<p>Ваш e-mail:<br /><input type="email" name="email" placeholder="e-mail"><label>*</label></p>
				<p>Ваше сообщение<label>*</label>:<br />
				<textarea name="message" rows="10" placeholder="Сообщение" style='width:90%;'></textarea>
				</p>
				<p><b>CAPTCHA:</b><br/><img src="captcha/captcha.php" id="captcha-img" /><button onclick="UpdateImg();">Обновить</button>
				<script type="text/javascript">
				function UpdateImg() {
				document.images["captcha-img"].src = 'captcha/captcha.php';
				}
				</script><br/>
				<input type="text" name="captcha_code"><label>*</label></p>
				
				<p>
				<p><label>*</label>-обязательные поля для заполнения</p>
				<button id="sub">Отправить</button>
				<p><span id="result"></span></p>
				</p>
			</form>
			
			<script type="text/javascript">
				$("#sub").click(function () {
				$("#result").html("Отправка данных...");
				$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
				if(info=="1")
				{
				$('#myForm')[0].reset();
				$("#result").html("<span style='color:#088A08;'>Сообщение отправленно</span>");
				UpdateImg();
				}else $("#result").html(info);
				});});
				$("#myForm").submit(function () {
				return false;
				});
			</script>			
		</div>
	</div>
	<div class='right-con'>
		<div class='small-block'>
		<div class='title-small-block'>Программы</div>
			<div class='pr'>
			<ul>
			<?php
			$result = mysql_query("SELECT id,title FROM programm ORDER BY id DESC LIMIT 0,4",$db);
			$myrow=mysql_fetch_array($result);
			do
			{
			printf("
			<img src='images/anim/%s.gif' alt='%s' widht=15px height=15px  align=left />
			<li><a href='programm.php?id=%s'>%s</a></li>",strtolower($myrow['title']),$myrow['title'],$myrow['id'],$myrow['title']);
			}
			while($myrow=mysql_fetch_array($result))?>
			</ul>
			</div>
		</div>
		<div class='small-block'>
			<div class='title-small-block'>Статьи</div>
			<ul>
			<?php
			$result = mysql_query("SELECT id,title FROM articles ORDER BY id DESC LIMIT 0,4",$db);
			$myrow=mysql_fetch_array($result);
			do
			{
			printf("
			<li><a href='articles.php?id=%s'>%s</a></li>",$myrow['id'],$myrow['title']);
			}
			while($myrow=mysql_fetch_array($result))?>
			</ul>
		</div>
	</div>
</div>
<?php include("blocks/footer.php"); ?>
</body>
</html>