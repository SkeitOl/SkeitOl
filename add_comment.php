<?php

/** @var SkeitOl\Core $SKEITOL */


//if(isset($_POST['CAPTCHA']))
$recaptcha = $_REQUEST['g-recaptcha-response'];
if (!empty($recaptcha)) {
	
	include("getCurlData.php");
	$google_url = "https://www.google.com/recaptcha/api/siteverify";
	$secret = '6LeaFBETAAAAANFgN9RxAb8-E5_nJjHd6A6wpJjD';
	$ip = $_SERVER['REMOTE_ADDR'];
	$url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
	$res = getCurlData($url);
	$res = json_decode($res, true);
	//session_start();
	//if($_POST['CAPTCHA']!=$_SESSION['code'])
	if (!$res['success']) {
		?>
		<span class='text_error'>CAPTCHA введена не верно!</span>
		<?
	} else {
		
		//Ядро
		if (!require $_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php') {
			die('Error include core');
		}
		
		
		//Проверим корректность ввода
		$name = htmlspecialchars($_POST['NICK']);
		$nLengthName = mb_strlen($name);
		if ($nLengthName === 0 || $nLengthName >= 100) {
			die("<span class='text_error'>Имя пусто или слишком длинное!</span>");
		}
		if (mb_strlen(strip_tags($name)) !== $nLengthName) {
			die("<span class='text_error'>HTML теги запрещены!</span>");
		}
		
		$text = $_POST['TEXT'];
		$length = mb_strlen($text);
		if ($length < 5) {
			die("<span class='text_error'>Текс пуст или слишком длинный!</span>");
		}
		if (mb_strlen(strip_tags($text)) !== $length) {
			die("<span class='text_error'>HTML теги запрещены!</span>");
		}
		
		$id_item = (int)$_POST['ITEM_ID'];
		if ($id_item <= 0) {
			die("<span class='text_error'>ID элемента пуст!</span>");
		}
		
		$email = htmlspecialchars($_POST['EMAIL']);
		if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			die("<span class='text_error'>Не корректный e-mail!</span>");
		}
		
		$dt = date("Y-m-d H:i:s");
		
		//mysql_query("SET NAMES utf8");
		header('Content-Type: text/html; charset= utf-8');
		include_once("blocks/bd.php");
		
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql = "INSERT INTO comments_articles (ID_ARTICLES,TEXT,NICK,EMAIL,DATE_TIME,APPROVED,IP) VALUES
				  ('$id_item','" . mysql_real_escape_string($text) . "','" . mysql_real_escape_string($name) . "','$email','$dt','0','$ip')";
		// echo$sql."<br>";
		//$result = mysql_query($sql, $db) or die('Запрос не удался: ' .
		if (mysql_query($sql, $db)) {
			$to = "skeit.ol@mail.ru";
			$subject = 'Новый комментарий на сайте';
			// текст письма
			$message = '<html>
<head>
  <title>Новый комментарий на сайте</title>
  <style>tr:nth-child(even) {background-color: #f2f2f2}</style>
</head>
<body>
  <p>Добавлен новый комментарий на сайте.</p>
  <table style="width:100%;border-color:#4c4c4c" cellpadding="5" border="1">
    <tr>
      <th><b>Дата</b></th><th><b>Имя</b></th><th><b>Комменнтарий</b></th><th><b>IP</b></th>
    </tr>
    <tr>
      <td>' . $dt . '</td><td>' . $name . '</td><td>' . $text . '</td><td>' . $ip . '</td>
    </tr>
  </table>
</body>
</html>
';
			$headers = 'From: ' . strip_tags('info@skeitol.ru') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			//$headers[] = 'Bcc: birthdaycheck@example.com';
			mail($to, $subject, $message, $headers);
			echo '1';//<span class='text_good'>После проверки сообщения модератором оно будет добавленно.</span>";4
		} else {
			echo "<span style='color:#ff0000;'>Ошибка отправление сообщения=(</span>";
		}
	}
	
} else {
	echo "<span class='text_error'>Нет CAPTCHA!</span>";
}