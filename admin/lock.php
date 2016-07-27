<?php
/*session_start();
if(!$_SESSION['auth']){
	if($_REQUEST['p']!=123456789)die("Не верный пароль");
	else {
		$_SESSION['auth']=1;
	}
}
elseif(isset($_REQUEST['exit'])){
	unset($_SESSION['auth']);
	session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT']."/admin/blocks/bd.php");
*//**/

if (!function_exists('password_verify')){
	function password_verify($password, $hash){
		return (crypt($password, $hash) === $hash);
	}
}

if(isset($_GET['exit'])){
	header("HTTP/1.0 401 Unauthorized");
	echo"<a href='../'>На главную</a>";
	//header("Location: http://skeitol.ru");
	exit();
}
else{
	include_once($_SERVER['DOCUMENT_ROOT']."/admin/blocks/bd.php");
	if (!isset($_SERVER['PHP_AUTH_USER']))
	{
		Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
		Header ("HTTP/1.0 401 Unauthorized");
		exit();
	}
	else
	{
		if (!get_magic_quotes_gpc())
		{
			$_SERVER['PHP_AUTH_USER'] = (mysql_real_escape_string($_SERVER['PHP_AUTH_USER']));
			$_SERVER['PHP_AUTH_PW'] = (mysql_real_escape_string($_SERVER['PHP_AUTH_PW']));
		}
		$query = "SELECT pass FROM userlist WHERE user='".$_SERVER['PHP_AUTH_USER']."'";
		$lst = @mysql_query($query);
		if (!$lst)
		{
			Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
			Header ("HTTP/1.0 401 Unauthorized");

			exit();
		}
		if (mysql_num_rows($lst) == 0)
		{
			Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
			Header ("HTTP/1.0 401 Unauthorized");
			exit();
		}
		$pass =  @mysql_fetch_array($lst);
		if (!password_verify($_SERVER['PHP_AUTH_PW'], $pass['pass']))//($_SERVER['PHP_AUTH_PW']!= $pass['pass'])
		{
			Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
			Header ("HTTP/1.0 401 Unauthorized");
			//echo"<p>Неверные данные.</p>";
			exit();
		}
	}
}/**/?>