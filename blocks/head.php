<?function request_url()
{
  $result = ''; // Пока результат пуст
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on'))$result .= 'https://'; else $result .= 'https://';
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  return $result;
}?>
<head>
	<title><?echo(!empty($sys_title))?$sys_title:"SkeitOl - Soft";?></title>
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?echo(!empty($sys_title))?$sys_title:"SkeitOl - Soft";?>">
	<meta property="og:url" content="<?=request_url()?>">
	<?if(empty($og_image))$og_image="https://skeitol.ru/images/favicon/apple-touch-icon-144x144.png";?>
  	<meta property="og:image" content="<?=$og_image?>"/>
	<meta property="og:description" content="<?echo $sys_description;?>">
	<meta name="description" content="<?echo $sys_description;?>">
	<meta name="keywords" content="<?echo $sys_keywords;?>">
	<meta http-equiv="content-language" content="ru">
	<meta name="author" content="SkeitOl">
	<meta name="copyright" content="Все права принадлежат SkeitOl">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?echo "https://".$_SERVER['HTTP_HOST']."/";?>favicon.ico" type="image/x-icon" /><?
	$file_style=$_SERVER['DOCUMENT_ROOT'].'/style/style.css';
	if(file_exists($file_style)){
		echo'<style>'.file_get_contents($file_style).'</style>';
	}/*
	<link rel="stylesheet" type="text/css" href="<?echo "https://".$_SERVER['HTTP_HOST']."/";?>style/style-1450046583053.css?v06" />*/?>
	<!--EDGE-->
	<meta name="msapplication-TileColor"content="#fff"/>
	<meta name="msapplication-square150x150logo" content="/images/favicon/apple-touch-icon-152x152.png"/>
	<?if(!empty($id))
	{
		$result = mysql_query("SELECT id,title,url FROM ".$sys_pages." WHERE id < " . $myrow['id'] . " AND active=1 ORDER BY id DESC LIMIT 1;", $db);
		if($result){
			$row = mysql_fetch_array($result);
			if ($row['id'] != "") {
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo '<link rel="prev" href="/'.$sys_pages.'/'.$url_page.'/"/>';
				echo'<link rel="prerender" href="/'.$sys_pages.'/'.$url_page.'/" />';//предварительная загрузка будушео контента
			}
			$result = mysql_query("SELECT id,title,url FROM ".$sys_pages." WHERE id > " . $myrow['id'] . " AND active=1 ORDER BY id LIMIT 1;", $db);
			$row = mysql_fetch_array($result);
			if ($row['id'] != "") {
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo '<link rel="next" href="/'.$sys_pages.'/'.$url_page.'/"/>';
				echo'<link rel="prerender" href="/'.$sys_pages.'/'.$url_page.'/" />';//предварительная загрузка будушео контента
			}
		}
	}?>
	<!---->
	<!-- Apple Touch Icons -->
	<link rel="apple-touch-icon" href="/images/favicon/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-touch-icon-152x152.png" />
	<?if(!empty($sys_special_head_text))echo $sys_special_head_text;?>
</head>