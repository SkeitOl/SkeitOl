<section style="  background: #f6f5f3;border-bottom: 1px solid #e9e9e8; text-align:left;margin: 0 0 1em;">

<div class="div-hierarchy links" itemscope itemtype="https://schema.org/BreadcrumbList">
	<span itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem">
		<a itemprop="item" href="https://skeitol.ru" title="Главная">
			<span itemprop="name">Главная</span>
			<meta itemprop="position" content="1"/>
		</a>
	</span>
> 	<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<?/*<span itemprop="child" itemscope itemtype="https://data-vocabulary.org/Breadcrumb">*/?>
		
		<?
	if (isset($id)) {
		if($sys_pages=='programm'):?>
				<a itemprop="item" href="https://skeitol.ru/program/" title="<?=$sys_pages_print?>">
					<span itemprop="name"><?=$sys_pages_print?></span>
					<meta itemprop="position" content="2" />
				</a>
			<?else:?>
				<a itemprop="item" href="https://skeitol.ru/<?=$sys_pages?>/" title="<?=$sys_pages_print?>">
					<span itemprop="name"><?=$sys_pages_print?></span>
					<meta itemprop="position" content="2" />
				</a>
			<?endif;
		
		$result = mysql_query("SELECT * FROM $sys_pages WHERE id=$id", $db);
		$myrow = mysql_fetch_array($result);
		if ($myrow['id'] != ''){
			$sys_title= strip_tags($myrow['title']);
			?> > <span><?=$sys_title?></span><?
			//echo' > <span >'.$myrow['title'].'</span>';
		}
	}
	else{?>

		<span itemprop="title"><?=$sys_pages_print?></span>
	<?}
	?>
	</span>
	
</div>
</section>