<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');

$connection = \SkeitOl\Connection::getInstance();

include("blocks/bd.php");

$id = false;
$realId = 0;

if (isset($_GET['id'])) {
	$id = ($_GET['id']);
}

include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/functions.php");

$article = new Articles();

$sys_title = "Статьи";

if ($id !== false) {
	/*
	* смотрим есть ли id или url
	*/
	$tempId = (int)$id;

	$arArticle = [];

	$cache = new \SkeitOl\CPHPCache();
	$cacheId = md5($id);
	if ($cache->InitCache(3600, $cacheId, '/articles/' . $cacheId)) {
		$arArticle = $cache->GetVars();
	} elseif ($cache->StartDataCache()) {

		$arArticle = $connection->query("SELECT * FROM articles WHERE id=$tempId AND active=1")->fetch();
		if (!$arArticle) {
			$rId = $connection->real_escape_string($id);
			$arArticle = $connection->query("SELECT * FROM articles WHERE url='$rId' AND active=1")->fetch();
		}

		if (!$arArticle) {
			$cache->AbortDataCache();
		} else {
			//сразу получим доп. поля
			$realId = (int)$arArticle['id'];


			if ($prev = $connection->query("SELECT id,title,url FROM articles WHERE id < $realId AND active=1 ORDER BY id DESC LIMIT 1;")->fetch()) {
				$arArticle['PREV'] = $prev;
			}

			if ($next = $connection->query("SELECT id,title,url FROM articles WHERE id > " . $realId . " AND active=1 ORDER BY id LIMIT 1;")->fetch()) {
				$arArticle['NEXT'] = $next;
			}

			$arArticle['COUNT_COMMENTS'] = 0;
			if ($d = $connection->query("SELECT COUNT(*) FROM comments_articles WHERE APPROVED=1 AND ID_ARTICLES=$realId")->fetch()) {
				$arArticle['COUNT_COMMENTS'] = (int)$d['COUNT(*)'];
			}
			if ($arArticle['COUNT_COMMENTS'] > 0) {
				$res = $connection->query("SELECT * FROM comments_articles WHERE APPROVED=1 AND ID_ARTICLES=$realId ORDER BY id DESC LIMIT 10");
				while ($item = $res->fetch()) {
					$arArticle['COMMENTS'][] = $item;
				}
			}

			$arArticle['CATEGORIES'] = [];

			if ($arArticle['category']) {
				$arr_category = unserialize($arArticle['category']);
				if ($arr_category && is_array($arr_category)) {
					$res = $connection->query("SELECT * FROM category WHERE id=" . implode(',', $arr_category));
					while ($item = $res->fetch()) {
						$arArticle['CATEGORIES'][] = $item;
					}
				}
			}
		}

		$cache->EndDataCache($arArticle);
	}

	if (!$arArticle) {
		unset($id);
		/*выводим 404*/
		\SkeitOl\Util::set404();

	} else {

		//301 редирект, чтобы не было дублей
		if (
			strripos($_SERVER['REQUEST_URI'], 'articles.php?id=') !== false
			||
			($_GET['id'] == $arArticle['id'] && $arArticle['url'] && $arArticle['url'] != $_GET['id'])
		) {
			$url = '/articles/' . ($arArticle['url'] ?: $arArticle['id']) . '/';
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://{$_SERVER['SERVER_NAME']}$url");
			include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
		}

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
	if ($list = $_REQUEST['list']) {
		$set404 = false;

		$list = (int)$list;
		if ($list <= 0) {
			$set404 = true;
		} else {
			$cache = new \SkeitOl\CPHPCache();
			$cacheId = 'maxcount';
			if ($cache->InitCache(3600, $cacheId, '/articles')) {
				$maxItems = $cache->GetVars();
			} elseif ($cache->StartDataCache()) {
				$maxItems = 0;
				$result = $connection->query("SELECT count(*) as cnt FROM articles WHERE  active=1")->fetch();
				if ($result) {
					$maxItems = (int)$result['cnt'];
				}

				$cache->EndDataCache($maxItems);
			}
			if ($maxItems >= 1) {
				$maxList = ceil($maxItems / 9);
				if ($list > $maxList) {
					/*выводим 404*/
					\SkeitOl\Util::set404();
				}
			} else {
				$set404 = true;
			}
		}


		if ($set404) {
			\SkeitOl\Util::set404();
		}
	}
}


$categoryId = (int)$_REQUEST['category'];
if ($categoryId > 0) {
	$category = [];

	$cache = new \SkeitOl\CPHPCache();
	if ($cache->InitCache(3600, $categoryId, '/category')) {
		$category = $cache->GetVars();
	} elseif ($cache->StartDataCache()) {

		$category = \SkeitOl\Connection::getInstance()->query("SELECT * FROM category WHERE id='$categoryId'")->fetch();

		if (!$category) {
			$cache->AbortDataCache();
		}

		$cache->EndDataCache($category);
	}

	if ($category) {
		$sys_title = "Статьи на тему: {$category['name']}";
	}
}

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

if ($list = (int)$_REQUEST['list']) {
	if ($list > 1) {
		$sys_title .= ' страница №' . $list;
		if ($sys_description) {
			$sys_description .= '. Cтраница №' . $list;
		}
	}
}

if ($realId > 0 && !$_SESSION['view'][$realId]) {
	$_SESSION['view'][$realId] = 1;
	$connection->query("UPDATE articles SET views=views+1 WHERE id='$realId'")->fetch();
}

?><!DOCTYPE html>
<html lang="ru">
<?php
$sys_special_footer_text .= '<script src="//code.jquery.com/jquery-1.10.2.js"></script><script type="text/javascript" src="/js/articles.js?v10" async></script><script src="//www.google.com/recaptcha/api.js" async></script>';

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
							$article->showArticlesID($arArticle);
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
