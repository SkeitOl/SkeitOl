<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');

$connection = \SkeitOl\Connection::getInstance();

include("blocks/bd.php");

$id = false;
$realId = 0;

if (isset($_GET['id'])) {
	$id = mysql_real_escape_string($_GET['id']);
}

include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/functions.php");

$article = new Articles();
/*if ($_REQUEST['PHPSESSID'] = '2b1f4e5fd0898b69c081b79861892dad') {

}*/

if ($id !== false) {
	/*
	* смотрим есть ли id или url
	*/
	$tempId = (int)$id;
	
	$arArticle = [];
	
	$cache = new \SkeitOl\CPHPCache();
	if ($cache->InitCache(84600, $id, '/articles')) {
		$arArticle = $cache->GetVars();
	} elseif ($cache->StartDataCache()) {
		
		$arArticle = $connection->query("SELECT * FROM articles WHERE id=$tempId AND active=1")->fetch();
		if (!$arArticle) {
			$arArticle = $connection->query("SELECT * FROM articles WHERE url='$id' AND active=1")->fetch();
		}
		
		if (!$arArticle) {
			$cache->AbortDataCache();
		}
		
		$cache->EndDataCache($arArticle);
	}
	
	if (!$arArticle) {
		unset($id);
		/*выводим 404*/
		header("HTTP/1.0 404 Not Found");
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/error-pages/error404.htm');
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
	} else {
		
		$realId = (int)$arArticle['id'];
		
		$lastModified = strtotime($arArticle['TIMESTAMP_X']);
		
		header("Cache-Control: public");
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
		
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) {
			header('HTTP/1.1 304 Not Modified');
			exit();
		}
		
		$sys_title = ($arArticle['meta_title']) ?: strip_tags($arArticle['title']);
		if (!empty($arArticle['meta_keywords'])) {
			$sys_keywords = strip_tags($arArticle['meta_keywords']);
		}
		
		$sys_description = ($arArticle['meta_description']) ?: strip_tags($arArticle['description']);
		if (!empty($arArticle['src_preview'])) {
			$og_image = $arArticle['src_preview'];
		}
	}
} else {
	$sys_title = "Статьи";
}


if ($realId > 0 && !$_SESSION['view'][$realId]) {
	$_SESSION['view'][$realId] = 1;
	$connection->query("UPDATE articles SET views=views+1 WHERE id='$realId'")->fetch();
}

?><!DOCTYPE html>
<html lang="ru">
<?php
if (empty($sys_description)) {
	$sys_description = "Статьи и информационные ресурсы SkeitOl";
}
if (empty($sys_keywords)) {
	$sys_keywords = "Articles SkeitOl, Статьи, Статьи SkeitOl,Статьи SkeitOl Soft";
}
$sys_pages = "articles";
if (empty($sys_pages_print)) {
	$sys_pages_print = "Статьи";
}

$sys_special_footer_text .= '<script type="text/javascript" src="/js/articles.js?v6" async></script><script src="//www.google.com/recaptcha/api.js" async></script>';

include_once("blocks/head_optimize.php");

?>
<body>
<div class="wrapper-container">
	<div id="content_r_long">
		<?php include("blocks/optimiert/header.php"); ?>
		<?php //include_once("blocks/breadcrumb.php");?>
		<div id='content'>
			<div class='left-con'>
				<div class="left-con-block">
					<div class='con-block' <?php if (!isset($id)): ?>style="background:none"<?php endif; ?> id="con_block_item">
						<?php
						if ($realId === 0) {
							//Выводит список
							$article->showArticlesList($arArticle, $db);
						} else {
							//Выводит данные по id
							$article->showArticlesID($arArticle, $db);
						}
						?>
					</div>
				</div>
				<div class='right-con'>
					<div class="right-con-block"><?php include_once("blocks/rightblock-articles.php"); ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php //include("blocks/footer.php"); ?>
<?php

$long_footer = true;
include("blocks/footer_optimize.php");

include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
