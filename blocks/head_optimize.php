<?php
/** @var string $sys_pages */
/** @var string $sys_description */
/** @var string $sys_keywords */
/** @var string $sys_title */
/** @var int $realId */

function request_url()
{
	$result = ''; // Пока результат пуст
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'))
		$result .= 'https://'; else $result .= 'https://';
	// Имя сервера, напр. site.com или www.site.com
	$result .= $_SERVER['SERVER_NAME'];
	// Последняя часть запроса (путь и GET-параметры).
	$result .= $_SERVER['REQUEST_URI'];
	return $result;
}

?>
<head>
	<title><?php echo (!empty($sys_title)) ? $sys_title : "SkeitOl - Soft"; ?></title>
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo (!empty($sys_title)) ? $sys_title : "SkeitOl - Soft"; ?>">
	<meta property="og:url" content="<?= request_url() ?>">
	<?php if (empty($og_image))
		$og_image = "https://skeitol.ru/images/favicon/apple-touch-icon-144x144.png"; ?>
	<meta property="og:image" content="<?= $og_image ?>"/>
	<meta property="og:description" content="<?php echo $sys_description; ?>">
	<meta name="description" content="<?php echo $sys_description; ?>">
	<meta name="keywords" content="<?php echo $sys_keywords; ?>">
	<meta http-equiv="content-language" content="ru">
	<meta name="author" content="SkeitOl">
	<meta name="copyright" content="Все права принадлежат SkeitOl">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- -->
	<link rel="shortcut icon" href="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/"; ?>favicon.ico" type="image/x-icon"/>
	<!--EDGE-->
	<meta name="msapplication-TileColor" content="#fff"/>
	<meta name="msapplication-square150x150logo" content="/images/favicon/apple-touch-icon-152x152.png"/>
	<?php
	if ($realId && $realId > 0) {
		$arPNData = [];
		
		$cache = new \SkeitOl\CPHPCache();
		if ($cache->InitCache(84600, $realId . '_next_prev_item', '/' . $sys_pages)) {
			$arPNData = $cache->GetVars();
		} elseif ($cache->StartDataCache()) {
			$connection = \SkeitOl\Connection::getInstance();
			
			if ($prev = $connection->query("SELECT id,title,url FROM " . $sys_pages . " WHERE id < $realId AND active=1 ORDER BY id DESC LIMIT 1;")->fetch()) {
				$arPNData['prev'] = $prev;
			}
			
			if ($next = $connection->query("SELECT id,title,url FROM " . $sys_pages . " WHERE id > " . $realId . " AND active=1 ORDER BY id LIMIT 1;")->fetch()) {
				$arPNData['next'] = $next;
			}
			
			if (!$arPNData) {
				$cache->AbortDataCache();
			}
			
			$cache->EndDataCache($arPNData);
		}
		
		if ($arPNData) {
			if ($prev = $arPNData['prev']) {
				if (!empty($prev['url'])) {
					$url_page = $prev['url'];
				} else {
					$url_page = $prev['id'];
				}
				echo '<link rel="prev" href="/' . $sys_pages . '/' . $url_page . '/"/>';
				echo '<link rel="prerender" href="/' . $sys_pages . '/' . $url_page . '/" />';
			}
			
			if ($next = $arPNData['next']) {
				if (!empty($next['url'])) {
					$url_page = $next['url'];
				} else {
					$url_page = $next['id'];
				}
				echo '<link rel="next" href="/' . $sys_pages . '/' . $url_page . '/"/>';
				echo '<link rel="prerender" href="/' . $sys_pages . '/' . $url_page . '/" />';//предварительная загрузка будушео контента
			}
		}
	} ?>
	<!-- Apple Touch Icons -->
	<link rel="apple-touch-icon" href="/images/favicon/apple-touch-icon.png"/>
	<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-touch-icon-76x76.png"/>
	<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-touch-icon-152x152.png"/><?php
	
	$file_style = $_SERVER['DOCUMENT_ROOT'] . '/style/style.css';
	if (file_exists($file_style)) {
		echo '<style>' . file_get_contents($file_style) . '</style>';
	}/*
	<link rel='stylesheet' type='text/css' href='/style/style.css<?
	$file_name=$_SERVER['DOCUMENT_ROOT'].'/style/style.css';if(file_exists($file_name))echo'?'.filemtime($file_name);?>' />
	<?*/
	if (!empty($sys_special_head_text)) {
		echo $sys_special_head_text;
	} ?>
</head>