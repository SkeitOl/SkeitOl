<?
header('Content-Type: application/xml; charset=utf-8');

/*ini_set("display_errors",1);
error_reporting(E_ALL);*/
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include("lock.php");

function parseToXML($htmlStr)
{
	$xmlStr = str_replace('<', '&lt;', $htmlStr);
//$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr = str_replace('"', '&quot;', $xmlStr);
	$xmlStr = str_replace("'", '&#39;', $xmlStr);
	$xmlStr = str_replace("&", '&amp;', $xmlStr);
	$xmlStr = str_replace("
", '<br>', $xmlStr);
	return $xmlStr;
}

$s_map = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9
	https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\r\n";

// указываем главную страницу сайта
$site_url = '';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'))
	$site_url .= 'https://';
else  $site_url .= 'https://';
//fix
$site_url = 'https://';
$site_url .= $_SERVER['SERVER_NAME'] . '/';
//echo"site_url=$site_url";
$s_map .= '
<url>
    <loc>' . $site_url . '</loc>
    <lastmod>' . date("Y-m-d\TH:i:s+03:00") . '</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.00</priority>
</url>' . "\r\n";

function printXMLData($tp, $site_url)
{
	
	// тут нужно получить ссылку на страницу
	$query = "SELECT id,TIMESTAMP_X,url FROM " . $tp . " WHERE active=1 order by date desc";
	$s_map = '';
	$res = \SkeitOl\Connection::getInstance()->query($query);
	$items = [];
	while ($item = $res->fetch()) {
		$items[] = $item;
	}
	if ($items) {
		$s_map .= '<!-- ' . $tp . ' -->' . "\r\n";
		$s_map .= '<url>' . "\r\n";
		$s_map .= '<loc>' . $site_url . $tp . '/</loc>' . "\r\n";
		$s_map .= '<lastmod>' . (date_format(date_create($items[0]['TIMESTAMP_X']), 'Y-m-d\TH:i:s+03:00')) . '</lastmod>' . "\r\n";
		$s_map .= '<changefreq>weekly</changefreq>' . "\r\n";
		$s_map .= '<priority>0.90</priority>' . "\r\n";
		$s_map .= '</url>' . "\r\n";
		foreach ($items as $row){
			if (!empty($row['url'])) {
				$url_page = $row['url'] . '/';
			} else {
				$url_page = $row['id'] . '/';
			}
			
			$s_map .= '<url>' . "\r\n";
			$s_map .= '<loc>' . $site_url . $tp . '/' . $url_page . '</loc>' . "\r\n";
			$s_map .= '<lastmod>' . (date_format(date_create($row['TIMESTAMP_X']), 'Y-m-d\TH:i:s+03:00')) . '</lastmod>' . "\r\n";
			$s_map .= '<changefreq>weekly</changefreq>' . "\r\n";
			$s_map .= '<priority>0.50</priority>' . "\r\n";
			$s_map .= '</url>' . "\r\n";
			
		}
	}
	return $s_map;
}

$tp = 'articles';
$s_map .= printXMLData($tp, $site_url);
$tp = 'news';
$s_map .= printXMLData($tp, $site_url);

$s_map .= '</urlset>';

echo //'<pre>' .
	($s_map)
	//. '</pre>'
;

include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');