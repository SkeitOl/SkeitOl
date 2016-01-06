<?php
 header('Content-Type: text/html; charset= utf-8');
session_start();
 
$code=$_SESSION['code'];
 
if($_POST['captcha_code']=="" || $_POST['captcha_code']==" ")
{
          die("Введите символы!");
}
else
{
          $p_code=$_POST['captcha_code'];
          if($p_code!=$code)
          {
             die("Неверно введены символы!");
          }
          else
          {
              //Тут делаем все что должно быть, 
              //если капча введена верно
			  echo"Ololo =)))";
          }
}
 
?>