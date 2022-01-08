<?php

/** @var SkeitOl\Core $SKEITOL */

$result = [
	'status' => 'error'
];

$isAjaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!$isAjaxRequest) {
	$result['message'] = 'Permission denied!';
} else {
//if(isset($_POST['CAPTCHA']))
	$recaptcha = $_REQUEST['g-recaptcha-response'];
	if (!empty($recaptcha)) {
		include("../getCurlData.php");
		$google_url = "https://www.google.com/recaptcha/api/siteverify";
		$secret = '6LeaFBETAAAAANFgN9RxAb8-E5_nJjHd6A6wpJjD';
		$ip = $_SERVER['REMOTE_ADDR'];
		$url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
		$res = getCurlData($url);
		$res = json_decode($res, true);
		//session_start();
		//if($_POST['CAPTCHA']!=$_SESSION['code'])
		if (!$res['success']) {
			$result['message'] = 'CAPTCHA введена не верно!';
		} else {
			
			//Ядро
			if (!require $_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php') {
				$result['message'] = 'Error include core';
			} else {
				//Проверим корректность ввода
				$name = htmlspecialchars($_POST['NICK']);
				$nLengthName = mb_strlen($name);
				if ($nLengthName === 0 || $nLengthName >= 100) {
					$result['message'] = 'Имя пусто или слишком длинное!';
				} else {
					if (mb_strlen(strip_tags($name)) !== $nLengthName) {
						$result['message'] = 'HTML теги запрещены!';
					} else {
						$text = $_POST['TEXT'];
						$length = mb_strlen($text);
						if ($length < 5) {
							$result['message'] = 'Текст пуст или слишком короткий!';
						} else {
							if (mb_strlen(strip_tags($text)) !== $length) {
								$result['message'] = 'HTML теги запрещены!';
							} else {
								if (strripos($text, 'http://') !== false || strripos($text, 'https://') !== false) {
									$result['message'] = 'Ссылки запрещены!';
								} else {
									
									$id_item = (int)$_POST['ITEM_ID'];
									if ($id_item <= 0) {
										$result['message'] = 'ID элемента пуст!';
									} else {
										
										$email = htmlspecialchars($_POST['EMAIL']);
										if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
											$result['message'] = 'Не корректный e-mail!';
										}
										
										if (!$result['message']) {
											
											$dt = date("Y-m-d H:i:s");
											
											
											$ip = $_SERVER['REMOTE_ADDR'];
											
											$connection = \SkeitOl\Connection::getInstance();
											
											$sql = "INSERT INTO comments_articles (ID_ARTICLES,TEXT,NICK,EMAIL,DATE_TIME,APPROVED,IP) VALUES
				  ('$id_item','" . $connection->real_escape_string($text) . "','" . $connection->real_escape_string($name) . "','$email','$dt','0','$ip')";
											if ($connection->query($sql)->fetch()) {
												$to = "skeit.ol.mail@gmail.com";
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
												$result['status'] = 'ok';
												$result['message'] = 'Спасибо, ваще сообщение принято.';
											} else {
												$result['message'] = 'Ошибка отправление сообщения :(';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	} else {
		$result['message'] = 'Нет CAPTCHA!';
		//echo "<span class='text_error'>Нет CAPTCHA!</span>";
	}
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);