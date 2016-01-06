<style>
html, body {
height: 100%;
}
#content_r{overflow:auto;padding-bottom: 195px;}
#content_r_long{overflow:auto;padding-bottom:240px;}
.wrapper-container {
min-height: 100%;
}
.footer_new{
position: relative;
margin-top: -195px;
height: 195px;
clear:both;}
body .long_footer{margin-top:-240px;height:240px;}
@media screen and (max-width: 620px){
	.footer_new,body .long_footer{position:relative;margin:0;height:auto;clear:both;}
	.wrapper-container {min-height:auto;}
	#content_r,#content_r_long{overflow:auto;padding:0;}
}
</style>
<section class="footer_new premium-domains <? if($long_footer)echo"long_footer";?>">
	<div style="background: #f6f5f3;border-top: 1px solid #e9e9e8;">
		<div class="container">
			<div class="col-lg-12 text-center">
				<?include_once("blocks/breadcrumb_footer.php");?>
			</div>
			<div class="col-lg-12 text-center">
				<h3>Основные разделы</h3>
			</div>
			<div class="col-lg-12 m-b-lg text-center">
				<div class="d1">
					<span><a href="/">Главная</a></span>
					<span><a href="/program/">Программы</a></span>
					<span><a href="/news/">Новости</a></span>
					<span><a href="/articles/">Статьи</a></span>
					<span><a href="/site-map.html">Карта сайта</a></span>	
					<span><a href="/about/">О нас</a></span>
					<div class="clear"></div>
					<p><a href="/pages/5/">Условия использования информации</a></p>
				</div>
			</div>
			<div class="clear"></div><?/*
			<div class="col-lg-12 text-center">
				<h3>Контакты</h3>
			</div>
			
			<div class="col-lg-12 m-b-lg text-center">
				<div class="d1">
					<span><a href="mailto:skeit.ol@mail.ru">
					<img src="/images/email-32.png" class="social-links-f e-mail"><br>
					skeit.ol@mail.ru</a></span>				<span><a href="http://vk.com/skeitol" target="_blank">
						<img src="/images/vkontakte.png" class="social-links-f vk" width="32" height="32" style="width: 32px; height: 32px;"><br>
						Вконтакте</a></span>				<span><a href="http://www.facebook.com/skeit.ol" target="_blank">
							<img src="/images/f32.png" class="social-links-f facebook"><br>
							Facebook</a></span>
					<ar> <p><a href="/feedback.php">Обратная связь</a></p></ar>
				</div>
			</div>*/?>
			<div class="clear"></div>
			<div class="col-lg-12 text-center small-text"><p>© SkeitOl 2012 - 2015</p></div>
		</div>
		</div>
	</section>
	<style>
		#upbutton {width: 35px;position: fixed;height: 100%;z-index: 100;top: 0;left: 0;cursor:pointer;}
		#upbutton:hover {background: #000;opacity: 0.6;}
		#upbutton img {opacity: 0.6;}
	</style>
<div id="upbutton">
    <img src="/images/up2.png" width="25" height="25" style="margin: 5px;" />
</div>
<script>        $(document).ready(function () { $("#upbutton").hide(); $(function () { $(window).scroll(function () { if ($(this).scrollTop() > 80) { $('#upbutton').fadeIn(); } else { $('#upbutton').fadeOut(); } }); $('#upbutton').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); return false; }); }); });    </script>
<!-- End UpButton-->
<div style="display:none"><!-- Google analyticstracking -->
<?php include_once("analyticstracking.php") ?>
<!-- .Google analyticstracking -->
<!-- Yandex.Metrika informer --><a href="https://metrika.yandex.ru/stat/?id=24809018&amp;from=informer"target="_blank" rel="nofollow"><img src="https://mc.yandex.ru/informer/24809018/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a><!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24809018 = new Ya.Metrika({ id:24809018, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/24809018" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</div>