<?php
header('Content-Type: text/html; charset= utf-8');
include_once("blocks/bd.php");
session_start();

$code = $_SESSION['code'];

if ($_POST['captcha_code'] == "" || $_POST['captcha_code'] == " ") {
	die("Введите CAPTCHA!");
} else {
	$p_code = $_POST['captcha_code'];
	if ($p_code != $code) {
		die("Неверно введены символы CAPTCHA!");
	} else {
		if (isset($_POST['nik'])) {
			$nik = $_POST['nik'];
			if ($nik == '') {
				unset($nik);
			}
		}
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
			if ($email == '') {
				unset($email);
			}
		}
		if (isset($_POST['message'])) {
			$message = $_POST['message'];
			if ($message == '') {
				unset($message);
			}
		}
		if (isset($nik) && isset($email) && isset($message)) {
			$dt = date("Y-m-d H:i:s");
			mysql_query("SET NAMES utf8");
			if (mysql_query("INSERT INTO feedback (nik,email,message,checkbox,datetime) VALUES
				  ('$nik','$email','$message','1','$dt')"))
				echo "1";
			else echo "<span style='color:#ff0000;'>Ошибка отправление сообщения=(</span>";
		} else echo "<span style='color:#ff0000;'>Заполните все обязательные поля!</span>";
	}
}