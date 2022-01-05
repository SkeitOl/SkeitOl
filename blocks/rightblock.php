<?php /*<div class='small-block'>
	<div class='title-small-block'><a href="/program/">Программы</a></div>
		<div class='pr'>
		<ul>
		<?php $result = mysql_query("SELECT id,title FROM programm ORDER BY id DESC LIMIT 0,4",$db);	  			$myrow=mysql_fetch_array($result);				do			{				printf("				<img src='/images/anim/%s.gif' alt='%s' widht=15px height=15px  align=left />				<li><a href='/program/%s/'>%s</a></li>",strtolower($myrow['title']),$myrow['title'],mb_strtolower($myrow['title']),$myrow['title']);			}			while($myrow=mysql_fetch_array($result))?>		</ul>	</div>
</div>*/ ?>
<div class='small-block'>
	<div class='title-small-block'><a href="/articles/">Статьи</a></div>
	<ul class="list-right-blocks"><?php
		$st = '';
		if (isset($id)) {
			$st = ' AND id<>' . \SkeitOl\Connection::getInstance()->real_escape_string($id);
		}
		
		$lastArticles = [];
		$cache = new \SkeitOl\CPHPCache();
		if ($cache->InitCache(3600, 'last4Articles' . md5($st), '/articles/last4')) {
			$lastArticles = $cache->GetVars();
		} elseif ($cache->StartDataCache()) {
			
			$res = \SkeitOl\Connection::getInstance()->query("SELECT id,title,url FROM articles WHERE active=1 " . $st . " ORDER BY id DESC LIMIT 0,4");
			while ($item = $res->fetch()) {
				$lastArticles[] = $item;
			}
			
			if (!$lastArticles) {
				$cache->AbortDataCache();
			}
			
			$cache->EndDataCache($lastArticles);
		}
		
		
		if ($lastArticles) {
			foreach ($lastArticles as $myrow_ar) {
				$url_page = $myrow_ar['url'] ?: $myrow_ar['id'];
				printf("<li><a href='/articles/%s/'>%s</a></li>", $url_page, $myrow_ar['title']);
			}
		}
		?></ul>
</div>