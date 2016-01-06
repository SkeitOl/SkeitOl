<?
header('Content-Type: text/html; charset= utf-8');
if(isset($_POST['user'])&&isset($_POST['password']))
{
	$user=$_POST['user'];
	$pass=$_POST['password'];
	include("blocks/bd.php");
	$result = mysql_query("SELECT pass FROM userlist WHERE user='$user'");
	if($result)//Пользователь есть
	{

		$myrow = mysql_fetch_array($result);
		if($myrow['pass']==md5(md5($pass)))
		{
			setcookie('site_user',$user,time()*2);
			setcookie('site_user_pass',md5(md5($pass)),time()*2);	
			echo"Hello $user<br>";
		}
		else echo"Не верный пароль!";
	}
	else{
		echo"Нет пользователя - ".$user;
		
		}
}
?>