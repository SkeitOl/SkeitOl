<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');

$id = '';
if ($_GET['id']) {
	$id = (int)$_GET['id'];
}
$arPage = [];

$sys_title = "SkeitOl - cтатьи по программированию, созданию сайтов и многое другое";
$sys_description = "Программы и информационные ресурсы SkeitOl";
$sys_keywords = "SkeitOl, SkeitOl Soft";
$sys_pages = "pages";
$sys_special_head_text = '<!-- Yandex.RTB -->
<script>window.yaContextCb=window.yaContextCb||[]</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>';


?><!doctype html>
<html lang="ru" itemscope itemtype="http://schema.org/WebPage"><?php

//Page ?
$cache = new \SkeitOl\CPHPCache();
$cacheId = md5($id);
if ($cache->InitCache(3600, $cacheId, '/pages/' . $cacheId)) {
	$arPage = $cache->GetVars();
} elseif ($cache->StartDataCache()) {
	$connection = \SkeitOl\Connection::getInstance();
	
	$arPage = $connection->query("SELECT * FROM pages WHERE id=$id")->fetch();
	
	if (!$arPage) {
		$cache->AbortDataCache();
	} else {
		$cache->EndDataCache($arPage);
	}
}

if ($arPage) {
	if ($val = $arPage['title']) {
		$sys_title = strip_tags($val);
	}
}

include_once("blocks/head.php")

?>
<body><?php
if ($arPage) {
	echo '
<div class="wrapper-container">
	<div id="content_r_long">';
} ?>
<?php include("blocks/header.php"); ?>
<div id='content'>
	<?php
	if ($arPage){
		echo "
				<div class='left-con'>
				<div class='con-block links box-shadow2'>";
		echo "<div class='title-con-block'>" . $arPage['title'] . "</div>
					<div class='news-data'>" . $arPage['date'] . "</div>";
		echo "" . $arPage['text'];
		echo "</div>
				</div>
				<div class='right-con'>";
		include("blocks/rightblock.php");
		echo "</div>
				</div>

				</div>
				</div>";
	}
	else{
	?>
</div>
	<div class="block_main_slider">
		<div class="main_page_slider">
			<div class="item" style="background-image: url('/images/bc/383844447.jpg')">
				<a class="t" href="/articles/kak-poluchit-prev-yu-kartinku-youtube-rolika/">Как получить превью-картинку
					youtube-ролика</a></div>
			<? php/*<div class="item" style="background-image: url('/images/articles/98/11231231232312123.png')">
				<a class="t" href="/articles/sublime-text-3-x-universal-nye-licenzionnye-klyuchi-dlya-windows-mac-i-linux/">Sublime
					Text 2 - 3 Лицензионные ключи</a></div>*/
			?>
			<div class="item" style="background-image: url('/images/articles/112/bx_click.png')">
				<a class="t" href="/articles/creat_event_on_click_at_cms_1s_bitriks/">Обработчика события клика в CMS
					1С-Битрикс</a></div>
		</div>
	</div>
	<section class="services">
		<div class="container">
			<div class="col-lg-12 text-center">
				<h2>Последние статьи</h2>
			</div>
			<div class="row ">
				<?php
				$lastArticles = [];
				$cache = new \SkeitOl\CPHPCache();
				if ($cache->InitCache(3600, 'lastArticles9', '/articles/last')) {
					$lastArticles = $cache->GetVars();
				} elseif ($cache->StartDataCache()) {
					$res = \SkeitOl\Connection::getInstance()->query("SELECT * FROM articles WHERE active=1 ORDER BY date DESC LIMIT 0,9");
					while ($item = $res->fetch()) {
						$lastArticles[] = $item;
					}
					if (!$lastArticles) {
						$cache->AbortDataCache();
					} else {
						$cache->EndDataCache($lastArticles);
					}
				}
				
				if ($lastArticles) {
					foreach ($lastArticles as $myrow) {
						if (!empty($myrow['url'])) {
							$url_page = $myrow['url'];
						} else {
							$url_page = $myrow['id'];
						}
						$photo_img = strip_tags($myrow['src_preview']) ?: "/images/favicon/apple-touch-icon-114x114.png";
						
						$url_page = "/articles/$url_page/";
						
						$title = strip_tags($myrow['title']);
						
						$data = date_create($myrow['date']);
						$sDate = (date_format($data, 'Y-m-d')) . 'T' . (date_format($data, 'H:i'));
						$sPrintDate = (date_format($data, 'd-m-Y H:i'));
						?>
						<div class="col-3">
							<div class="links-news wow slideInUp">
								<a href="<?= $url_page ?>">
									<div class="preview_block">
										<div class="photo_img" style="background-image: url('<?= $photo_img ?>')"></div>
										<div class="title">
											<div class="links-news__text"><?= $title ?></div>
										</div>
									</div>
									<div class="links-news__text">
										<div class="news-data">
											<span itemprop="dateCreated" style="display:none"><?= $sDate ?></span>
											<time datetime="<?= $sDate ?>"></time>
											<?= $sPrintDate ?>
											<div class="view_block"><?= $myrow['views'] ?></div>
										</div>
										<p><?= strip_tags($myrow['description']) ?></p>
									</div>
								</a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="clear"></div>
			<p><a href='/articles/' title="Все статьи">Все статьи</a></p>
		</div>
	</section><?/*
	<section class="gray-section services">
		<div class="container">
			<div class="col-lg-12 text-center">
				<h2>Последние новости</h2>
			</div>
			<div class="row">
				<?php
				
				
				$lastNews = [];
				$cache = new \SkeitOl\CPHPCache();
				if ($cache->InitCache(3600, 'lastNews', '/news/last')) {
					$lastNews = $cache->GetVars();
				} elseif ($cache->StartDataCache()) {
					$res = \SkeitOl\Connection::getInstance()->query("SELECT * FROM news WHERE active=1 ORDER BY date DESC LIMIT 0,3");
					while ($item = $res->fetch()) {
						$lastNews[] = $item;
					}
					if (!$lastNews) {
						$cache->AbortDataCache();
					} else {
						$cache->EndDataCache($lastNews);
					}
				}
				
				if ($lastNews) {
					foreach ($lastNews as $myrow) {
						if (!empty($myrow['url'])) {
							$url_page = $myrow['url'];
						} else {
							$url_page = $myrow['id'];
						}
						$url_page = "/news/$url_page/";
						
						$photo_img = strip_tags($myrow['src_preview']) ?: "/images/favicon/apple-touch-icon-114x114.png";
						
						$data = date_create($myrow['date']);
						$sDate = (date_format($data, 'Y-m-d')) . 'T' . (date_format($data, 'H:i'));
						$sPrintDate = (date_format($data, 'd-m-Y H:i'));
						?>
						<div class="col-3">
							<div class="links-news wow slideInUp">
								<a href="<?= $url_page ?>">
									<div class="preview_block">
										<div class="photo_img" style="background-image: url('<?= $photo_img ?>')"></div>
										<div class="title">
											<div class="links-news__text"><?= strip_tags($myrow['title']) ?></div>
										</div>
									</div>
									<div class="links-news__text">
										<div class="news-data">
											<span itemprop="dateCreated" style="display:none"><?= $sDate ?></span>
											<time datetime="<?= $sDate ?>"></time>
											<?= $sPrintDate ?>
										</div>
										<p><?= strip_tags($myrow['description']) ?></p>
									</div>
								</a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="clear"></div>
			<p><a href='/news/' title="Все новости">Все новости</a></p>
		</div>
	</section>
*/?>
<section>
	<div class="container">
		<br><br>
		<div id="yandex_rtb_R-A-1503119-1"></div>
		<script>window.yaContextCb.push(()=>{Ya.Context.AdvManager.render({renderTo: 'yandex_rtb_R-A-1503119-1',blockId: 'R-A-1503119-1'})})</script>
	</div>
</section>
<?php
}
include("blocks/footer.php"); ?>
</body>
</html>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
?>