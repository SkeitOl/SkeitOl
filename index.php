<?php header('Content-Type: text/html; charset= utf-8');
if(isset($_GET['id'])){$id=$_GET['id'];}if($id=='') unset($id);
include("blocks/func/func.php");
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
	$sys_special_head_text='
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> <!-- Библиотека jQuery -->
	<link rel="stylesheet" href="/style/flickity.css" media="screen">
	<script src="/js/flickity.pkgd.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/style/animate.css" />
	<script src="/js/jquery.viewportchecker.js"></script>
	';
	include_once("blocks/head.php")?>	
<body>
<style>
	.hidden{
opacity:0;
}
.visible{
opacity:1;
}
	</style>
	<script>
	$('.main-gallery').flickity({
  // options
  cellAlign: 'left',
  contain: true,
  autoPlay: 3500
});

	</script>
	<?php
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
					@media screen and (max-width: 700px) { .col-sm-4 {width: 46%;margin: 1% 1% 1%;padding: 1%; } .col-sm-4:nth-child(odd){float:left;}.col-sm-4:nth-child(even){float:right;}} @media screen and (max-width: 550px) { .col-sm-4 {width: 92%;padding: 3%;}}
.main-gallery.js-flickity {height: 300px;overflow: hidden;}
.my-fl-box{height:300px;width:100%;background:#ccc;position:relative;padding: 0;margin: 0;}
/* position dots in gallery */
.flickity-page-dots {bottom: 10px;}
/* white circles */
.flickity-page-dots .dot {width: 12px;height: 12px;opacity: 1;background: transparent;border: 2px solid white;}
/* fill-in selected dot */
.flickity-page-dots .dot.is-selected {background: white;}
.hero-gallery{max-width:600px;padding:0 1em;margin: 0 auto;}
.hero-gallery h2 {font-size: 4em;color:#fff;margin:1em 0;  display: inline-block;}
.hero-gallery h2 a{color:#fff;text-decoration:none;}
.hero-gallery h2 a:hover{text-decoration:underline;}
.hero-gallery .tagline {font-size: 2.1em;line-height: 1.0;margin: 0;color: #444;font-weight: 100;}
.hero-illustration {position: absolute;right: 25%;top: 20px;max-width: 100px;}
				</style>
					
					<section >
						<div class="main-gallery js-flickity" data-flickity-options='{ "cellAlign": "left", "contain": true,"autoPlay": 4500 }' style='background-image: url(http://www.kartinki.me/pic/201208/800x600/kartinki.me-6185.jpg);'>
							<div class="gallery-cell my-fl-box"style="background: url(http://skeitol.ru/images/articles/96/4.jpg) no-repeat 50% 50%;
    background-size: cover;">
								<div class="hero-gallery" >
									<h2><a style="font-size:1.9rem; text-shadow:0 1px 3px #000" href="http://skeitol.ru/articles/restajling-dejstvuyushih-modelej-lada-kak-eto-budet/">Рестайлинг действующих моделей Lada</a></h2>
									<p class="tagline" style="color:#fff">Как это будет?</p>
								</div>
							</div>
							<div class="gallery-cell my-fl-box"style="background: url(http://skeitol.ru/images/articles/94/383844447.jpg) no-repeat 50% 50%;
    background-size: cover;">
								<div class="hero-gallery" >
									<h2><a style="font-size:1.9rem; text-shadow:0 1px 3px #000" href="http://skeitol.ru/articles/kak-poluchit-prev-yu-kartinku-youtube-rolika/">Превью-картинка youtube-ролика</a></h2>
									<p class="tagline" style="color:#fff">Как получить?</p>									
								</div>
							</div>
							<div class="gallery-cell my-fl-box"style="background: url(http://i2.wp.com/webuilddesign.com/wp-content/uploads/2015/05/owl-carousel-responsive-touch.png) no-repeat 50% 50%;
    background-size: cover;">
								<div class="hero-gallery" >
									<h2><a style="font-size:1.9rem; text-shadow:0 1px 3px #000" href="/articles/adaptivnye-slajdery-i-galerei-izobrazhenij/">Адаптивные слайдеры</a></h2>
									<p class="tagline" style="color:#fff;text-shadow:0 1px 3px #000">ТОП 10</p>									
								</div>
							</div>
							<div class="gallery-cell my-fl-box"style="background: #76DC60;">
								<div class="hero-gallery" >
									<h2><a href="http://skeitol.ru/program1.html">Timer_off</a></h2>
									<p class="tagline">Завершение работы в нужное время</p>
									<img class="hero-illustration" src="http://skeitol.ru/images/anim/timer_off.gif" alt="Timer_off">
								</div>
							</div>
						  <div class="gallery-cell my-fl-box"style="background:#F0E259;">
								<div class="hero-gallery" >
									<h2><a href="http://skeitol.ru/program2.html">Sked</a></h2>
									<p class="tagline">Расписание занятий для универа</p>
									<img class="hero-illustration" src="http://skeitol.ru/images/anim/sked.gif" alt="Sked">
								</div>
							</div>
							<div class="gallery-cell my-fl-box"style="background: #63C1DE;">
								<div class="hero-gallery" >
									<h2><a href="http://skeitol.ru/program4.html">HtmlColor</a></h2>
									<p class="tagline">Помогает узнать HTML кодировку</p>
									<img class="hero-illustration" src="http://skeitol.ru/images/anim/htmlcolor.gif" alt="HtmlColor">
								</div>
							</div>
							<?/*
							<div class="gallery-cell my-fl-box"style="background: #7C7C7A;">
								<div class="hero-gallery" >
									<h2 style="
    margin: 0.7em 0;
    font-size: 3.2em;
"><a href="http://skeitol.ru/elc/">Программирование на Java</a></h2>
									<p class="tagline" style="color:#FBFF06">Электронный учебный курс</p>
									<img class="hero-illustration" src="http://skeitol.ru/elc/files/img/Java_logo.png" alt="Java">
								</div>
							</div>
							*/?>
						</div>
						<div class="clear"></div>
					</section>
				<?/*articles*/?>
				
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
							{	/*	
								//printf("<div><a href='/articles%s.html'>%s</a><abbr>%s</abbr></div>",$myrow['id'],$myrow['title'],date_format(date_create($myrow['date']),'d.m.Y, H:i'));
								if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
								echo'
								<div class="col-sm-4 links-news">
									<h3><a href="/articles/'.$url_page.'/">'.strip_tags($myrow['title']).'</a></h3>
									<div class="news-data"><span itemprop="dateCreated" style="display:none">'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'</span><time datetime="'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'"></time>'.(date_format(date_create($myrow['date']), 'd-m-Y H:i')).'</div>
									<p>'.strip_tags($myrow['description']).'</p>
									<div>
										<div class="view_block">'.$myrow['views'].'</div>
									</div>
								</div>*/
								if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
								echo'
								<div class="col-sm-4 links-news wow slideInUp">
									<div class="preview_block">
										<a href="/articles/'.$url_page.'/">
											<span class="photo_img" style="background-image: url('.strip_tags($myrow['src_preview']).')"></span>
											<span class="title">'.strip_tags($myrow['title']).'</span>
										</a>
									</div>
									
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
			?>
			<style>
			.news-short{
			font-family: 'Lato', Calibri, Arial, sans-serif;
background: #fff;/*#f6b93c url('http://tympanus.net/Development/StackSlider/images/noisebg.png');*/
font-weight: 400;
			font: 1em "Century Gothic",'Calibri';			
			float: left;
			width: 100%;
			}
.news-short a{
width: 100%;
color: #ec7430;
float: left;
font-size: 1em;
font-weight: bold;
}
.news-short a:hover{
text-decoration: none;
}			
.news-short .title{
background: rgba(255, 255, 255, 0.5);
width: 100%;
margin: 0;
padding:0;
box-shadow: 1px 0px 2px rgba(0,0,0,0.2);}
.news-short div{width: 45%;float: left;padding: 2px;height: auto;display: block;margin-left: 10px;margin-bottom: 5px;min-height:30px;}
			.news-short abbr{
			float: left;
			font-size: 0.8em;
			color: #a07419;
text-shadow: 0 1px 1px rgba(255,255,255,0.6);
background: url('../images/config-date.png') no-repeat left;
padding-left: 20px;
			}
@media only screen and (max-width : 540px) {
.news-short div {
width: 94%;}}
			</style>
	<?php include("blocks/footer.php"); ?>
 </body>
</html>