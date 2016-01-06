<?php header('Content-Type: text/html; charset= utf-8');
function GetDocRoot(){
	$needle="public_html";
	return substr(__DIR__,0,strlen(__DIR__)+strlen($needle)+2-strpos(__DIR__,$needle))."/";
}
?>
<!DOCTYPE>
<html>
	<?php
	$sys_description="Контакты SkeitOl";
	$sys_keywords="Контакты SkeitOl, Контакты, Контакты SkeitOl,Контакты SkeitOl Soft";
	$sys_pages="contacts";
	$sys_pages_print="Контакты";
	$sys_title="Контакты";
	$sys_special_head_text='

		';
	include_once(GetDocRoot()."blocks/head.php");
		 ?>
<body>
<div class="wrapper-container">
	<div id="content_r">
		<div class="wrap_con">
		<?php include(GetDocRoot()."blocks/header.php");?>
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
					<ul class="con_list">
						<li><a href="mailto:skeit.ol@mail.ru">
							<span class="img_b"><img src="/images/email-32.png" class="social-links-f e-mail"></span>
							<span class="text_n">skeit.ol@mail.ru</span></a></li>
						<li><a href="http://vk.com/skeitol" target="_blank"><span class="img_b">
							<img src="/images/vkontakte.png" class="social-links-f vk"></span>
							<span class="text_n">Вконтакте</span></a></li>
						<li><a href="http://www.facebook.com/skeit.ol" target="_blank">
							<span class="img_b">
								<img src="/images/f32.png" class="social-links-f facebook"></span>
							<span class="text_n">Facebook</span></a></li>
					</ul>
				</div>
			</div>
		</section>
		</div>
	</div>
</div>	
	<?php include(GetDocRoot()."blocks/footer_new.php"); ?>
</body>
</html>