<? header('Content-Type: text/html; charset= utf-8');
/**/
	  
	  ini_set("display_errors",1);
	  error_reporting(E_ALL);/*
Для проверки авторизации Вы можете использовать полученный параметр hash, сравнив его с md5 подписью от app_id+user_id+secret_key, например md5(194253766748fTanppCrNSeuYPbA4ENCo). 
*/
function GetDocRoot(){
	$needle="public_html";
	return substr(__DIR__,0,strpos(__DIR__,$needle)+1+strlen($needle))."/";
}
$app_id="4759039";$secret_key="Ps6XR8SpOQQg36sgqwbz";
if(!empty($_GET['uid'])){
	$VK_ID=htmlspecialchars($_GET['uid']);
	$first_name=htmlspecialchars($_GET['first_name']);
	$last_name=htmlspecialchars($_GET['last_name']);
	$photo=htmlspecialchars($_GET['photo']);
	$photo_rec=htmlspecialchars($_GET['photo_rec']);
	$hash=htmlspecialchars($_GET['hash']);
	if(md5($app_id.$VK_ID.$secret_key)==$hash){
		//Можно смело добавлять пользователся
		//проверим есть ли такой пользователь
		include(GetDocRoot()."blocks/bd.php");

		$result = mysql_query("SELECT * FROM userlist where VK_ID=".$VK_ID ,$db);
        if(!$result) echo"Ошибка авторизации. бД lost";
        else
        {
        	$myrow=mysql_fetch_array($result);
        	if(!empty($myrow['id']))
        	{
        		//обновим контактные данные

        	}
    		else{
    			//добавми нового пользователя
    			$result = mysql_query("INSERT INTO userlist (pass,user,FIRST_NAME,LAST_NAME,EMAIL,IMG_SRC,VK_ID) VALUES ('".md5($VK_ID)."', 'vk_$VK_ID', '$first_name', '$last_name', '', '$photo', '$VK_ID')",$db);
    			if(!$result) echo"Ошибка создание нового пользователя.".mysql_error();
    			else echo"пользователь добавлен";
    		}
        }
	}
	else{echo"Ошибка авторизации";}
}
?>