<?
$arr=array(
	"PRICES"=> array(
		"Сколоко"=>array(
			"VALUE"=>1000,
			"VALUE_PRINT"=>"1000 руб")
		)
	);
?>
<pre><?
print_r($arr);
?></pre><?

?><p>sd</p>
<pre><?
print_r($arr["PRICES"][0]);
?></pre><?

/*
function strcode($str, $passw="")
{
   $salt = "Dn8*#2n!9j";
   $len = strlen($str);
   $gamma = '';
   $n = $len>100 ? 8 : 2;
   while( strlen($gamma)<$len )
   {
      $gamma .= substr(pack('H*', sha1($passw.$gamma.$salt)), 0, $n);
   }
   return $str^$gamma;
}
$sekret_key='prazdnik_morozko5';

//$txt = '{"fio":"Викторов Олег Сергеевич","date":"2014-11-30T12:00:00.000Z","price":"5012.2","product":[152,12,998,112,115,335,50,1]}';
$txt = '{"fio":"Викторов Олег Сергеевич"}';
echo $txt.'<br>';
echo 'len='.strlen($str).'<br>';
$salt = "Dn8*#2n!9j";
$len = strlen($str);
$gamma = '';
$n = $len>100 ? 8 : 2;
echo 'n='.($len>100 ? 8 : 2).'<br>';
echo 'sha1='.(sha1($passw.$gamma.$salt)).'<br>';
echo 'pack='.(pack('H*', sha1($passw.$gamma.$salt))).'<br>';
echo 'substr='.(substr(pack('H*', sha1($passw.$gamma.$salt)), 0, $n)).'<br>';



$txt = base64_encode(strcode($txt,$sekret_key));
echo $txt.'<br>';

$txt = $txt;
$txt = strcode(base64_decode($txt),$sekret_key);


//$txt = '{"a":1,"b":2,"c":3,"d":4,"e":5}';


echo"<pre>";
var_dump(json_decode($txt));

echo"</pre><br>
<pre>";
var_dump(json_decode($txt, true));
echo"</pre>";
//echo $txt.'<br>';

$arr=json_decode($txt);
echo"<pre>";
print_r($arr);
echo"</pre>";

echo"<pre>";
print_r($_POST);
echo"</pre>";
 
?>
<form action="" method="post">
	<?
		for($i=0;$i<10;$i++) {
			?>
			<p><label for="id<?=$i?>">id<?=$i?></label>
			<input id="id<?=$i?>" type="checkbox" name="id[]" value="id<?=$i?>"></p>
			<?
		}
	?>
	<input type="submit">
</form>*/