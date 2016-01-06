<div class='small-block'>	
	<div class='title-small-block'><a href="/program/">Программы</a></div>	
		<div class='pr'>		
		<ul>			
		<?php $result = mysql_query("SELECT id,title FROM programm ORDER BY id DESC LIMIT 0,4",$db);	  			$myrow=mysql_fetch_array($result);				do			{				printf("				<img src='/images/anim/%s.gif' alt='%s' widht=15px height=15px  align=left />				<li><a href='/program/%s/'>%s</a></li>",strtolower($myrow['title']),$myrow['title'],mb_strtolower($myrow['title']),$myrow['title']);			}			while($myrow=mysql_fetch_array($result))?>		</ul>	</div>
</div>
<div class='small-block'>	
	<div class='title-small-block'><a href="/articles/">Статьи</a></div>
	<noidex>	
		<ul  class="list-right-blocks"><?php
			$st='';
			if (isset($id)) {$st=' AND id<>'.$id;}
			//echo "id=$id";
			$result = mysql_query("SELECT id,title,url FROM articles WHERE active=1 ".$st." ORDER BY id DESC LIMIT 0,4",$db);
			$myrow=mysql_fetch_array($result);do{
				if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
			printf("<li><a href='/articles/%s/'>%s</a></li>",$url_page,$myrow['title']);}
			while($myrow=mysql_fetch_array($result))?></ul>
	</noidex>
</div><?/*
<div class='small-block'>	
	<div class='title-small-block'>Опрос</div>	<?php	if (!isset($_COOKIE['myopros1']))AskQuestion();	else PrintOpros();	?>
</div>*/?>