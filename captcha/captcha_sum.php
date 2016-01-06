<? {include_once("captcha.php");}?>
<?/*/*
if(rand(0,100)%2===0){include_once("captcha.php");}
else*//*
{
$width = 100;               //Ширина изображения
$height = 60;               //Высота изображения
$font_size = 16;            //Размер шрифта
$let_amount = 4;            //Количество символов, которые нужно набрать
$fon_let_amount = 15;       //Количество символов на фоне
$font = "pt sans narrow.ttf";         //Путь к шрифту
$font = "cour.ttf"; 
 
//набор символов
//$letters = array("a","b","c","d","e","f","g");
$letters = range("1","2","3");
//цвета
$colors = array("90","110","130","150","170","190","210");  
 
$src = imagecreatetruecolor($width,$height);    //создаем изображение               
$fon = imagecolorallocate($src,255,255,255);    //создаем фон
imagefill($src,0,0,$fon);                       //заливаем изображение фоном
 
for($i=0;$i < $fon_let_amount;$i++)          //добавляем на фон буковки
{
    //случайный цвет
    $color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),100); 
    //случайный символ
    $letter = $letters[rand(0,sizeof($letters)-1)]; 
    //случайный размер                              
    $size = rand($font_size-2,$font_size+2);                                            
    imagettftext($src,$size,rand(0,45),
        rand($width*0.1,$width-$width*0.1),
        rand($height*0.2,$height),$color,$font,$letter);
}

$a=rand(1,9);
$b=rand(1,9);
$k=rand(0,2);
$c=0;
switch($k){
	case 0:$c=$a+$b;$kl="+";break;
	case 1:$c=$a-$b;$kl="-";break;
	case 2:$c=$a*$b;$kl="*";break;
  default:$c=$a+$b;$kl="+";break;
}
session_start();
unset($_SESSION['CAPTCHA']);
$_SESSION['CAPTCHA']=array();
$_SESSION['CAPTCHA']['CODE_SUM']=$c;
$_SESSION['CAPTCHA']['s1']=$k;
$_SESSION['CAPTCHA']['a']=$a;
$_SESSION['CAPTCHA']['b']=$b;
$_SESSION['CAPTCHA']['kl']=$kl;
$_SESSION['CAPTCHA']['dt']=date();

$ar= array($a,$kl,$b);
//$ar= array("1","+","3");
$_SESSION['CAPTCHA']['ar']=$ar;
for($i=0;$i<count($ar);$i++){/*
	$color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],
        $colors[rand(0,sizeof($colors)-1)],
        $colors[rand(0,sizeof($colors)-1)],rand(20,40)); 
   $size = rand($font_size*2-2,$font_size*2+2);
                  //запоминаем код
   $_SESSION['i'.$i]=$ar[$i];
   imagettftext($src,$size,rand(0,15),$i*25,(($height*2)/3) + rand(0,5),rand($height*0.2,$height),$color,$font,"s".$ar[$i]);
   *//*
  $color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],
        $colors[rand(0,sizeof($colors)-1)],
        $colors[rand(0,sizeof($colors)-1)],rand(20,40)); 
   $letter = (string)$ar[$i];
   $size = rand($font_size*2-2,$font_size*2+2);
   $x = $i*15;      //даем каждому символу случайное смещение
   $y = (($height*2)/3) + rand(0,5);                            
   $_SESSION['CAPTCHA']['i'.$i]=strval($letter);
   
   imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,strval($letter));
}
header ("Content-type: image/gif");         //выводим готовую картинку
imagegif($src);
}
?>*/?>