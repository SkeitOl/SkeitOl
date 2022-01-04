<?php
if (!function_exists('password_verify')) {
	function password_verify($password, $hash)
	{
		return (crypt($password, $hash) === $hash);
	}
}

if (isset($_GET['exit'])) {
	header("HTTP/1.0 401 Unauthorized");
	echo "<a href='../'>На главную</a>";
	//header("Location: https://skeitol.ru");
	exit();
}
if (strlen(trim($_SERVER['PHP_AUTH_USER'])) === 0) {
	Header("WWW-Authenticate: Basic realm=\"Admin Page\"");
	Header("HTTP/1.0 401 Unauthorized");
	exit();
}

/*if (!get_magic_quotes_gpc()) {
	$_SERVER['PHP_AUTH_USER'] = (mysql_real_escape_string($_SERVER['PHP_AUTH_USER']));
	$_SERVER['PHP_AUTH_PW'] = (mysql_real_escape_string($_SERVER['PHP_AUTH_PW']));
}*/

$lst = \SkeitOl\Connection::getInstance()->query("SELECT id,pass FROM userlist WHERE user='" . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "'")->fetch();

if (!$lst) {
	Header("WWW-Authenticate: Basic realm=\"Admin Page\"");
	Header("HTTP/1.0 401 Unauthorized");
	exit();
}

if (!password_verify($_SERVER['PHP_AUTH_PW'], $lst['pass']))//($_SERVER['PHP_AUTH_PW']!= $pass['pass'])
{
	Header("WWW-Authenticate: Basic realm=\"Admin Page\"");
	Header("HTTP/1.0 401 Unauthorized");
	exit();
}