<?php header('Content-Type: text/html; charset= utf-8');?>
<!DOCTYPE>
<html>
	<?php
	$sys_description="О SkeitOl";
	$sys_keywords="О нас SkeitOl, About, About SkeitOl,О SkeitOl Soft";
	$sys_pages="contacts";
	$sys_pages_print="О нас";
	$sys_title="О нас";
	$sys_special_head_text='';
	include_once($_SERVER["DOCUMENT_ROOT"]."/blocks/head_optimize.php");
?>
<body>
<div class="wrapper-container">
	<div id="content_r">
		<div class="wrap_con">
		<?php include($_SERVER["DOCUMENT_ROOT"]."/blocks/optimiert/header.php");?>
		<section class="services">
			<div class="container">
				<div class="col-lg-12 text-center">
					<h1><?=$sys_pages_print?></h1>
				</div>
				<div class="row ">
					<style>
					.social-links-f{background:#7E7E7E;padding: 4px;border-radius: 50%;}				
					.con_list{list-style-type:none;max-width:200px;margin:0 auto;}
					.con_list li{display: block;float: left;width: 100%;margin: 8px;}
					.con_list li:hover a{color:#EC7430}
					.con_list li:hover .social-links-f{background:#EC7430;}
					.con_list .img_b{width: 50px;display: inline-block;float: left;vertical-align: middle;}
					.con_list .text_n{vertical-align: middle;display: inline-block;line-height:35px;float: left;}
					.con_list .img_b img{width:32px;height:32px;}

				</style>
					<h2>Уважаемые друзья!</h2>
					<p><a href="//skeitol.ru">Skeitol.ru</a> является некоммерческим проектом и создан «людьми для людей».<br>Мы и сами постоянно им пользуемся :)</p>
					<p>На сайте публикуются cтатьи и обзоры по программированию, операционным системам, железу, сетям.</p>
					<p><a href='/pages/4/'>Гид</a></span> по сайту.</p>
					<br>
					<p>Если вам понравилась наша система - разместите на своем интернет-ресурсе ссылку на наш проект.</p>
					<br>
					<p><a href="/about/contacts/" alt="контакты skeitol" title="контакты skeitol" >Контакты</a></p>
					<p><a href="http://skeitol.ru/pages/5/" alt="Условия использования информации skeitol" title="Условия использования информации skeitol">Условия использования информации</a></p>
				</div>
			</div>
		</section>
		</div>
	</div>
</div>	
	<?php include($_SERVER["DOCUMENT_ROOT"]."/blocks/footer_optimize.php"); ?>
</body>
</html>