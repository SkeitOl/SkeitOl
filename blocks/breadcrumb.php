<section style="  background: #f6f5f3;
  border-bottom: 1px solid #e9e9e8;">
<div class="container">
<div class="div-hierarchy links" itemscope itemtype="https://data-vocabulary.org/Breadcrumb">
	<span>
		<a itemprop="url" href="https://skeitol.ru" title="Главная">
			<span itemprop="title">Главная</span>
		</a>
	</span>
→ 	<span itemprop="child" itemscope itemtype="https://data-vocabulary.org/Breadcrumb">
		<?if($sys_pages=='programm'):?>
			<a itemprop="url" href="https://skeitol.ru/program/" title="<?=$sys_pages_print?>">
				<span itemprop="title"><?=$sys_pages_print?></span>
			</a>
		<?else:?>
			<a itemprop="url" href="https://skeitol.ru/<?=$sys_pages?>.html" title="<?=$sys_pages_print?>">
				<span itemprop="title"><?=$sys_pages_print?></span>
			</a>
		<?endif;?>
		<?
	if (isset($id)) {
		$result = mysql_query("SELECT * FROM $sys_pages WHERE id=$id", $db);
		$myrow = mysql_fetch_array($result);
		if ($myrow['id'] != ''){
			$sys_title= strip_tags($myrow['title']);
			echo' → <span >'.$myrow['title'].'</span>';}
	}
	?>
	</span>
	
</div>
</div>
</section>