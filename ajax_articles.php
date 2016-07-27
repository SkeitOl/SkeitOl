<?
include_once($_SERVER['DOCUMENT_ROOT']."/blocks/bd.php");
include_once($_SERVER['DOCUMENT_ROOT']."/modules/functions.php");

$sql_sort_name='date';//Сортировка по умолчанию
if(!empty($sort["VALUE"]))$sql_sort_name=$sort["VALUE"];
if (isset($_GET['list']))
	$list = htmlspecialchars($_GET['list']);
else
	$list = 1;
$step = 10;
$startI = 0;
$endI = $step - 1;
if (isset($list)) {
	if ($list <= 0) {
		echo"Нет такой страницы!!!<br>Вывод первой страницы";
	}
	else {
		$startI = ($list - 1) * $step;
		$endI = $startI + $step;
	}
}
$result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER
				BY ".$sql_sort_name." DESC LIMIT $startI,$endI", $db);
$myrow = mysql_fetch_array($result);

$article = new Articles();
$article->showArticlesList($myrow, $db);
/*
if (isset($_GET['list']))
    $list = htmlspecialchars($_GET['list']);
else
    $list = 1;

include_once("blocks/bd.php");

function PrintArticlesItem($myrow,$db){
	$array1 = array();
	$array1 = unserialize($myrow['category']);
	$category_string='';
	if (count($array1) > 0) {
		$category_string="<div>
			<p style='color: #5A5353;border-left: 3px #57AA43 solid;padding-left:5px;text-indent: 0px;margin: 3px 0 3px 10px;'>";
		for ($i = 0; $i < count($array1); $i++) {
			$result1 = mysql_query("SELECT * FROM category WHERE id='$array1[$i]'",$db);
			$row1 = mysql_fetch_array($result1);
			$category_string.=$row1['name'].', ';
			//if($i<count($array1)-1)echo ", ";									
		}
		$category_string=substr($category_string,0,-2);
		$category_string.="</p></div>";
	}
	if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];

		setlocale(LC_ALL, 'ru_RU.UTF-8');
		$st_date= strftime('%d %h %Y %I:%M', strtotime($myrow['date']));
		//date_format(date_create($myrow['date']), 'd-M-Y H:i')
		?><a class='news-item-link' href='/articles/<?=$url_page?>/' itemscope itemtype='http://schema.org/Article'>
			<div class='news-item'>
				<div class="left_con">
					<? $photo_img=strip_tags($myrow['src_preview']);
					if(empty($photo_img))$photo_img="/images/favicon/apple-touch-icon-114x114.png";?>
					<span class="photo_img" style="background-image: url('<?=$photo_img?>')"></span>
				</div>
				<div class="right_con">
					<div class='news-title'  itemprop='name'><?=$myrow['title']?></div>											
					<div>
						<div class='news-data'><?=$st_date?><div class='view_block'><?=$myrow['views']?></div></div>
						
					</div>
					<div><?=$category_string?></div>
					<div class='news-main'>
						<div class='news-text' itemprop='description'><?=$myrow['description']?></div>
						<div class='clear'></div>
					</div>
				</div>
			</div>
			</a><?
}

$step = 10;
$startI = 0;
$endI = $step - 1;
if (isset($list)) {
	if ($list <= 0) {
		echo"Нет такой страницы!!!<br>Вывод первой страницы";
	} 
	else {
		$startI = ($list - 1) * $step;
		$endI = $startI + $step;
	}
}
$sql_sort_name='date';//Сортировка по умолчанию
if(!empty($sort["VALUE"]))$sql_sort_name=$sort["VALUE"];

$result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER
				BY ".$sql_sort_name." DESC LIMIT $startI,$endI", $db);
	$myrow = mysql_fetch_array($result);
	$in = 1;
	if(!$myrow)die();
	do {
		PrintArticlesItem($myrow,$db);
		$in++;
	} while ($in <= $step && $myrow = mysql_fetch_array($result));
*/
?>