<?
//if(isset($_POST['CAPTCHA']))
$recaptcha=$_POST['g-recaptcha-response'];
if(!empty($recaptcha))
{
	
    include("getCurlData.php");
    $google_url="https://www.google.com/recaptcha/api/siteverify";
    $secret='6LeaFBETAAAAANFgN9RxAb8-E5_nJjHd6A6wpJjD';
    $ip=$_SERVER['REMOTE_ADDR'];
    $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
    $res=getCurlData($url);
    $res= json_decode($res, true);
	//session_start();
	//if($_POST['CAPTCHA']!=$_SESSION['code'])
	if(!$res['success'])
	{?>
		<span class='text_error'>CAPTCHA введена не верно!</span>
	<?
	}
	else
	{

		//Проверим корректность ввода
		$name=htmlspecialchars($_REQUEST['NICK']);

		if((strlen($name)<=0 || strlen($name>=150)))die("<span class='text_error'>Имя пусто или слишком длинное!</span>");
		$text=htmlspecialchars($_REQUEST['TEXT']);
		if(!(strlen($text)>0 && strlen($text<1000)))die("<span class='text_error'>Текс пуст или слишком длинный!</span>");
		$id_item=htmlspecialchars($_REQUEST['ITEM_ID']);
		if(!($id_item!=0))die("<span class='text_error'>ID элемента пуст!</span>");

		$email=htmlspecialchars($_REQUEST["EMAIL"]);

		$dt=date("Y-m-d H:i:s");
		//mysql_query("SET NAMES utf8");
		header('Content-Type: text/html; charset= utf-8');
		include_once("blocks/bd.php");
		$sql="INSERT INTO comments_articles (ID_ARTICLES,TEXT,NICK,EMAIL,DATE_TIME,APPROVED,IP) VALUES
				  ('$id_item','$text','$name','$email','$dt','0','$_SERVER[REMOTE_ADDR]')";
	 // echo$sql."<br>";
		//$result = mysql_query($sql, $db) or die('Запрос не удался: ' .
		if(mysql_query($sql, $db))
				echo "1";//<span class='text_good'>После проверки сообщения модератором оно будет добавленно.</span>";
		else echo "<span style='color:#ff0000;'>Ошибка отправление сообщения=(</span>";
	}
	
}else echo"<span class='text_error'>Нет CAPTCHA!</span>";?>