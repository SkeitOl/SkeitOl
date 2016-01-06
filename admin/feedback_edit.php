<?
header('Content-Type: text/html; charset= utf-8');
include("lock.php");
if(isset($_POST['action'])){
	echo"POST[action]=".$_POST['action'];
	if(isset($_POST['id']))
	switch($_POST['action'])
	{
	case 'read': 
		foreach($_POST['id'] as $key => $value){
		$result= mysql_query("UPDATE feedback SET checkbox='0' WHERE id='".$value."'");}break;
	case 'del': 
	foreach($_POST['id'] as $key => $value){			
		$result= mysql_query("DELETE FROM feedback WHERE id='".$value."'");}
		break;
	};
	if($result)echo "Успешно";
	else {
		echo "-1";
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
}
else 
{	
echo"No\nMassiv Post:\n";
}

?>