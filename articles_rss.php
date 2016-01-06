<?php header("Content-type: text/xml; charset=utf-8");

// Дата последней сборки фида
$lastBuildDate=time();//date(DATE_FORMAT_RFC822);

echo <<<END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
    <title>skeitol.ru RSSFeed</title>
    <link>http://skeitol.ru</link>
    <description>SkeitOl - cтатьи по программированию, созданию сайтов и многое другое</description>
END;

/*
    <pubDate>$lastBuildDate</pubDate>
    <lastBuildDate>$lastBuildDate</lastBuildDate>
    <generator>Weblog Editor 2.0</generator>
    <copyright>Copyright 2015 skeitol.ru</copyright>
    <managingEditor>editor@skeitol.ru</managingEditor>
    <webMaster>webmaster@skeitol.ru</webMaster>
    <language>ru</language>*/

// В этом файле надо разместить подключение к базе данных
include_once($_SERVER["DOCUMENT_ROOT"]."/blocks/db.php");
if ($result = $mysqli->query('SELECT id,url,title,description,date FROM articles WHERE active=1 AND title IS NOT NULL ORDER BY date DESC LIMIT 10')) {
    /* Выбираем результаты запроса: */
    while( $row = $result->fetch_assoc() ){
        $url_articles=(!empty($row['url']))?'/articles/'.$row['url'].'/':'/articles/'.$row['id'].'/';
     ?><item>
        <title><?=strip_tags($row['title'])?></title>
        <description><![CDATA[<?=strip_tags($row['description'])?>]]></description>
        <link>http://skeitol.ru<?=$url_articles?></link>
        <guid isPermaLink="true">http://skeitol.ru<?=$url_articles?></guid>
        <pubDate><?=date(DATE_FORMAT_RFC822,$row['date'])?></pubDate>
    </item><?
    }

    /* Освобождаем память */
    $result->close();
}
echo <<<END
</channel>
</rss>
END;
?>