<?php
	session_start();
	include('mail_agent.php');
	$mailto=array('skeit.ol@mail.ru');
	
	$phone=$_POST[phone];
	$phone	= str_replace(array(" ","-", "(", ")"),"",$_POST['phone']);
	if(!empty($_POST['clienPhone']))$phone= str_replace(array(" ","-", "(", ")"),"",$_POST['clienPhone']);
	
	$PageType='';
	$cart='';
	$LastName='';
	$SecondName='';
	$Address='';
	//ip
	$ip	= $_SERVER["REMOTE_ADDR"];
	$type=$_POST[tp];
	$name=$_POST[name];
	$Email=$_POST[name];
	$mess='';
	
	//Utm
	$metka = isset($_COOKIE['utm_source'])?$_COOKIE['utm_source']:'';
	//Refer
	$refer=isset($_COOKIE['Refer'])?$_COOKIE['Refer']:'';
	//Дата первого захода
	$FirstEnter=isset($_COOKIE['FirstEnter'])?$_COOKIE['FirstEnter']:'';      	
	//NowUtm
	$metkaNow = isset($_COOKIE['СurrentUTM_source'])?$_COOKIE['СurrentUTM_source']:'';
	//NowRefer
	$referNow=isset($_COOKIE['СurrentRefer'])?$_COOKIE['СurrentRefer']:'';
	
	
	
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	date_default_timezone_set('Europe/Moscow');				
	
	// тестовый блок для отправки писем в формате Битрикс24

	$text  = 'Сайт = '.$_SERVER['HTTP_HOST']."<br>\r\n";
	$text .= 'Тип страницы = '. $PageType."<br>\r\n";
	$text .= 'Тип заявки = Форма заказа '.$type."<br>\r\n";
	$text .= 'Телефон = '.$phone."<br>\r\n";
	$text .= 'Корзина = '. $cart."<br>\r\n";
	$text .= 'Имя = '.(($name!='')?$name:$FirstName)."<br>\r\n";
	$text .= 'Фамилия = '. $LastName."<br>\r\n";
	$text .= 'Отчество = '. $SecondName."<br>\r\n";
	$text .= 'E-mail = '.$Email."<br>\r\n";				
	$text .= 'Вопрос = '. $mess."<br>\r\n";
	$text .= 'Дата и время первого захода = '.$FirstEnter."<br>\r\n";
	$text .= 'Источник трафика = '. $metka."<br>\r\n";
	$text .= 'Сайт перехода = '. $refer."<br>\r\n";
	$text .= 'Текущий источник трафика = '. $metkaNow."<br>\r\n";
	$text .= 'Текущий сайт перехода = '. $referNow."<br>\r\n";
	$text .= 'IP = '. $ip."<br>\r\n";
	$text .= 'SessionId = '.session_id()."<br>\r\n";	
	
	// записываем информацию в файл, так как почтовые сервисы иногда отказываются работать
	$file = fopen("leads.txt","a+");
	if(!$file) 
	{
		//еcho("Ошибка открытия файла");
	}
	else
	{
		fputs ($file,"BEGIN_LEAD\r\n");
		fputs ($file,"LEAD_DATE=".date("d.m.Y H:i:s")."\r\n");
		fputs ($file,$text);
		fputs ($file,"END_LEAD\r\n");
	}
	fclose($file);

	$mail = new MailAgent();
	
	$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
	$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";

	try 
	{
		
		include_once("SendMailSmtpClass.php");
		$mailSMTP = new SendMailSmtpClass('skeit.ol@mail.ru', 'oleg1937', 'ssl://smtp.mail.ru', 'skeit.ol@mail.ru', 465); // создаем экземпляр класса
		// $mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'имя отправителя');
		  
		// заголовок письма
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
		$headers .= "From: Test <skeit.ol@mail.ru>\r\n"; // от кого письмо !!! тут e-mail, через который происходит авторизация
		$result =  $mailSMTP->send('skeit.ol@mail.ru', 'Заявка: '.$LandingType, $text, $headers); // отправляем письмо
		// $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
		if($result === true){
			echo "Письмо успешно отправлено";
		}else{
			echo $result;
		}
		
		//if($mail->sendMail($mailto, 'Заявка: '.$type, $text)) $i=1;
	
	} 
	catch (Exception $e) 
	{
		echo 'Поймано исключение: ',  $e->getMessage(), "\n";
	}
	
	header("Location: index.php");
?> 