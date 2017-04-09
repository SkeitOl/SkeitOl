<?php //header('Content-Type: text/html; charset= utf-8');
if(isset($_GET['id'])){$id=$_GET['id'];}if($id=='') unset($id);
include("blocks/bd.php");?>
<!DOCTYPE html>
<html><?
	/*TITLE*/
	if(isset($id)){
		$result = mysql_query("SELECT * FROM pages WHERE id=$id",$db);
		$myrow=mysql_fetch_array($result);
		if($myrow['id']==''){unset($id);$sys_title="SkeitOl - Главная";}
		else $sys_title=strip_tags($myrow['title']);
	}
	else $sys_title="SkeitOl - cтатьи по программированию, созданию сайтов и многое другое";
	$sys_description="Программы и информационные ресурсы SkeitOl";
	$sys_keywords="SkeitOl, SkeitOl Soft";
	$sys_pages="pages";
	$sys_special_head_text='';
	include_once("blocks/head.php")?>
<body><?php
			if(isset($id)){
				echo'
<div class="wrapper-container">
	<div id="content_r_long">';}?>
	<?php include("blocks/header.php");?>
	<div id='content'>
			<?php
			if(isset($id)){
				echo"
				<div class='left-con'>
				<div class='con-block links box-shadow2'>";
				echo"<div class='title-con-block'>".$myrow['title']."</div>
					<div class='news-data'>".$myrow['date']."</div>";
					echo"".$myrow['text'];				
				echo"</div>
				</div>
				<div class='right-con'>";				
				include("blocks/rightblock.php");
				echo"</div>
				</div>

				</div>
				</div>"; 
			}
			else{
				?>
				</div>
	<style>
		.main_page_slider .item{min-height: 300px;background-position: 50% 50%;background-repeat: no-repeat;background-size: cover;}
		.main_page_slider{min-height: 300px}
		.main_page_slider .item .t{    font-size: 1.85rem;
			text-shadow: 0 1px 3px #000;
			color: #fff;
			margin: 1.5em;
			display: inline-block;
			text-decoration: none;
			font-family: "Segoe UI","Helvetica Neue",Helvetica,sans-serif;
			font-weight: 700;}
	</style>
<div class="block_main_slider">
	<div class="main_page_slider">
		<div class="item" style="background-image: url('/images/bc/383844447.jpg')"><a class="t" href="/articles/kak-poluchit-prev-yu-kartinku-youtube-rolika/">Как получить превью-картинку youtube-ролика</a></div>
		<div class="item" style="background-image: url('/images/articles/98/11231231232312123.png')"><a class="t" href="/articles/sublime-text-3-x-universal-nye-licenzionnye-klyuchi-dlya-windows-mac-i-linux/">Sublime Text 2 - 3 Лицензионные ключи</a></div>
		<div class="item" style="background-image: url('/images/articles/112/bx_click.png')"><a class="t" href="/articles/creat_event_on_click_at_cms_1s_bitriks/">Обработчика события клика в CMS 1С-Битрикс</a></div>
	</div>
</div>
				<section class="services">
					<div class="container">
						<div class="col-lg-12 text-center">
							<h2>Последние статьи</h2>
						</div>
						<div class="row ">
							<?
							$result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER BY date DESC LIMIT 0,3",$db);	  
							$myrow=mysql_fetch_array($result);	
							do
							{
								if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
								?><div class="col-sm-4 links-news wow slideInUp">
									<div class="preview_block">
										<a href="/articles/<?=$url_page?>/">
											<span class="photo_img" style="background-image: url('<?=strip_tags($myrow['src_preview'])?>')"></span>
											<span class="title"><?=strip_tags($myrow['title'])?></span>
										</a>
									</div><?
									echo'
									<div class="news-data"><span itemprop="dateCreated" style="display:none">'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'</span><time datetime="'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'"></time>'.(date_format(date_create($myrow['date']), 'd-m-Y H:i')).'
										<div class="view_block">'.$myrow['views'].'</div>
									</div>
									<p>'.strip_tags($myrow['description']).'</p>
								</div>
								';
							}
							while($myrow=mysql_fetch_array($result));	
							?>
						</div>
						<div class="clear"></div>
						<p><a href='/articles/' title="Все статьи">Все статьи</a></p>
					</div>
				</section>
				<section class="gray-section services">
					<div class="container">
						<div class="col-lg-12 text-center">
							<h2>Последние новости</h2>
						</div>
						<div class="row">
							<?
							$result = mysql_query("SELECT * FROM news WHERE active=1 ORDER BY date DESC LIMIT 0,3",$db);	  
							$myrow=mysql_fetch_array($result);	
							do
							{
								if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
								echo'
								<div class="col-sm-4 links-news wow slideInUp">
									<div class="preview_block">
										<a href="/news/'.$myrow['id'].'/">											
											<span class="photo_img" style="background-image: url('.strip_tags($myrow['src_preview']).')"></span>
											<span class="title">'.strip_tags($myrow['title']).'</span>
										</a>
									</div>
									
									<div class="news-data"><span itemprop="dateCreated" style="display:none">'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'</span><time datetime="'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'"></time>'.(date_format(date_create($myrow['date']), 'd-m-Y H:i')).'</div>
									<p>'.strip_tags($myrow['description']).'</p>
								</div>
								';
							}
							while($myrow=mysql_fetch_array($result));	
							?>
						</div>
						<div class="clear"></div>
						<p><a href='/news/' title="Все новости">Все новости</a></p>
					</div>
				</section>
					<?/*News*/?>
			<?}
include("blocks/footer.php"); ?>
</body>
</html>