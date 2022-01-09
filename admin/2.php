<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include("lock.php"); ?>
	<!doctype html>
	<html lang="ru">
	<head><title>Загрузка файлов на сервер</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	<h2><p><b> Форма для загрузки файлов </b></p></h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<p><label>Куда сохранить:
				<span style='color:#ccc'>/images/</span></label><input type="text" name="uploaddir"><br>
		</p>
		<div id="fm" style="width:100%; float:left;">
			<p id="filename1">
				<input type="file" name="filename[]"><img src="images/delete.png" align="middle" width="24" onclick="Del(1)"/>
			</p>
		</div>
		<p><img src='images/plus.png' width='32' onclick='Add()' alt="Добавить"/></p>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script>
			var i = 1;

			function Add() {
				s = '<p id="filename' + (++i) + '"><input type="file" name="filename[]"><img src="images/delete.png" width="24" align="middle" onclick="Del(' + i + ')"/></p>';
				$("#fm").append(s);
			}

			function Del(i) {
				$("#filename" + i).remove();
			}
		</script>
		<input type="submit" value="Загрузить">
	</form>
	</body>
	</html>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');