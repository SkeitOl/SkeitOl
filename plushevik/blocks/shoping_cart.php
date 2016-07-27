<?
session_start();

if(isset($_POST['tp']))
switch($_POST[tp])
{
	case'add': $_SESSION[shops][$_POST[id]]+=1; break;
}

header("Location: http://plushevik.ru/");
exit;
?>