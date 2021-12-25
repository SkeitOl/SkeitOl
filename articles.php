<?php
include("blocks/bd.php");

$id = false;
<<<<<<< HEAD
$realId = 0;
=======
>>>>>>> 4a97cfd7f59fcb4040559db92172f5a7a54bab5e

if (isset($_GET['id'])) {
	$id = mysql_real_escape_string($_GET['id']);
}

include_once($_SERVER['DOCUMENT_ROOT']."/modules/functions.php");
$article = new Articles();
if ($id !== false) {
		/*
		* смотрим есть ли id или url
		*/
  		$tempId=(int)$id;
  		$myrow=[];
  		if($tempId>0){
			$result = mysql_query("SELECT * FROM articles WHERE id=$id AND active=1", $db);
			$myrow = mysql_fetch_array($result);
  		}
		if ($myrow['id'] == ''){
			$result = mysql_query("SELECT * FROM articles WHERE url='$id' AND active=1", $db);
			$myrow = mysql_fetch_array($result);
			if ($myrow['id'] == ''){
				unset($id);
				/*выводим 404*/
				header("HTTP/1.0 404 Not Found");
				header("HTTP/1.1 404 Not Found");
				header("Status: 404 Not Found");
				//header("Location: https://skeitol.ru/error-pages/error404.htm");
				//die(); exit();

				echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/error-pages/error404.htm');
				die();
			}
		}
		if ($myrow['id'] != ''){
<<<<<<< HEAD
			$realId=(int)$myrow['id'];
=======
			
>>>>>>> 4a97cfd7f59fcb4040559db92172f5a7a54bab5e
			/*UPD 2016.02.24*/
			/*UPD 2016.03.26 add specail  TIMESTAMP_X*/
			$lastModified = strtotime($myrow['TIMESTAMP_X']);
			header("Cache-Control: public");
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) {
				header('HTTP/1.1 304 Not Modified');
				exit();
			}
			
			
			$sys_title= ($myrow['meta_title'])?$myrow['meta_title']:strip_tags($myrow['title']);
			if(!empty($myrow['meta_keywords']))$sys_keywords=strip_tags($myrow['meta_keywords']);

			$sys_description=($myrow['meta_description'])?$myrow['meta_description']:strip_tags($myrow['description']);
          	if(!empty($myrow['src_preview']))$og_image=$myrow['src_preview'];
		}
	}
	else {
		$sys_title = "Статьи";
	}
session_start();

if($realId>0 && !$_SESSION['view'][$realId])
{
<<<<<<< HEAD
	$_SESSION['view'][$realId]=1;
	$result3 = mysql_query("UPDATE articles SET views=views+1 WHERE id='$realId'", $db);
=======
	$_SESSION['view'][$id]=1;
	$result3 = mysql_query("UPDATE articles SET views=views+1 WHERE id='$id'", $db);
>>>>>>> 4a97cfd7f59fcb4040559db92172f5a7a54bab5e
}
//include("blocks/func/func.php");
?><!DOCTYPE html>
<html>
<?php
	if(empty($sys_description))$sys_description="Статьи и информационные ресурсы SkeitOl";
	if(empty($sys_keywords))$sys_keywords="Articles SkeitOl, Статьи, Статьи SkeitOl,Статьи SkeitOl Soft";
	$sys_pages="articles";
	if(empty($sys_pages_print))$sys_pages_print="Статьи";
<<<<<<< HEAD
	$sys_special_footer_text.='<script type="text/javascript" src="/js/articles.js?v6" async></script><script
=======
	$sys_special_footer_text.='<script type="text/javascript" src="/js/articles.js?v5" async></script><script
>>>>>>> 4a97cfd7f59fcb4040559db92172f5a7a54bab5e
	src="//www.google.com/recaptcha/api.js" async></script>';
	include_once("blocks/head_optimize.php");
?>
<body>
	<div class="wrapper-container">
		<div id="content_r_long">
		<?php include("blocks/optimiert/header.php"); ?>
		<?//include_once("blocks/breadcrumb.php");?>
		<div id='content'>
			<div class='left-con'>
				<div class="left-con-block">
					<div class='con-block' <?if (!isset($id)):?>style="background:none"<?endif;?> id="con_block_item">
						<?php
<<<<<<< HEAD
						if ($realId===0)
=======
						if ($id === false)
>>>>>>> 4a97cfd7f59fcb4040559db92172f5a7a54bab5e
						{
							//Выводит список
							$article->showArticlesList($myrow, $db);
						}
						else
						{
							//Выводит данные по id
							$article->showArticlesID($myrow, $db);
						}
						?>
				</div>
			</div>
			<div class='right-con'>
				<div class="right-con-block"><?php include_once("blocks/rightblock-articles.php");?></div>
			</div>
		</div>
	 </div>
	</div>
	<?php //include("blocks/footer.php"); ?>
<?php $long_footer=true; include("blocks/footer_optimize.php");