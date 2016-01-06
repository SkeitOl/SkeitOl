<?php header('Content-Type: text/html; charset= utf-8');?>
<?php
include("blocks/bd.php");
?>
<!DOCTYPE html>
<html>
<?php
	$sys_description="Карта сайта SkeitOl";
	$sys_keywords="Maps SkeitOl, Карта сайта SkeitOl,Карта сайта SkeitOl Soft";
	$sys_title="Карта сайта";	
	$sys_special_head_text='';
	$sys_pages="site-map";
	$sys_pages_print="Карта сайта";
	include_once("blocks/head.php");
?>
<body>
<div class="wrapper-container">
	<div class="wrap_con">
	<?php include("blocks/header.php"); ?>
	<?php include("blocks/func/func.php");              include("blocks/bd.php");?>
<?//include_once("blocks/breadcrumb.php");?>    
	<section class="services">
		<div class="container">
			<div class="col-lg-12 text-center">
				<h1><?=$sys_pages_print?></h1>
			</div>
			<div class="row ">
				            
					<ul>
						<li><a href='/'>Главная</a>             
							<ul>
								<li>
									<a href='/program/'> Программы</a>
									<ul>
										<?php    $result = mysql_query("SELECT id,title FROM programm",$db);	  	 		$myrow=mysql_fetch_array($result);	  	  		do	  		{		 		printf("<li><a href='/program/%s/'>%s</a> </li>						",mb_strtolower($myrow['title']),$myrow['title']);		 	}	  		while($myrow=mysql_fetch_array($result));?>	  		               
									</ul>
								</li>
								<li><a href='/news/'>Новости</a></li>
								<li><a href='/articles/'>Статьи</a></li>
								<li><a href='/about/'>О нас</a>
									<ul>
										<li><a href='/about/contacts/'>Контакты</a></li>
										<li><a href='/pages/5/'>Условия использования информации</a></li>
										<li><a href='/pages/4/'>Гид по сайту</a></li>
									</ul>
								</li>
							</ul>
						</li>	
					</ul>
			</div>
		</div>        
	</div>
</div>
	<?include_once("blocks/footer_new.php");?>
	<?php /*include("blocks/footer.php"); 
	<section id="footer_new"  class="premium-domains" style="background: #f6f5f3;
  border-top: 1px solid #e9e9e8;">
		<div class="container">
			<div class="col-lg-12 text-center">
				<h3>Основные разделы</h3>
			</div>
			<div class="col-lg-12 m-b-lg text-center">
				<div class="d1">
					<span><a href="/">Главная</a></span>
					<span><a href="/program/">Программы</a></span>
					<span><a href="/news.html">Новости</a></span>
					<span><a href="/articles.html">Статьи</a></span>
					<span><a href="/site-map.html">Карта сайта</a></span>	
					<span><a href="/pages4.html">Гид</a></span>			
					<p><a href="/pages5.html">Условия использования информации</a></p>
				</div>
			</div>
			
			<div class="clear"></div>
			<div class="col-lg-12 text-center small-text"><p>© SkeitOl 2012 - 2015</p></div>
		</div>
	</section>*/?>
</body></html>