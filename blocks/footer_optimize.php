<section class="footer_new premium-domains <?php if($long_footer)echo"long_footer";?>">
	<div>
		<div class="container">
			<div class="col-lg-12 text-center">
				<?php include_once("blocks/breadcrumb_footer.php");?>
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
			<div class="clear"></div><?php/*
			<div class="col-lg-12 text-center">
				<h3>Контакты</h3>
			</div>
			
			<div class="col-lg-12 m-b-lg text-center">
				<div class="d1">
					<span><a href="mailto:skeit.ol@mail.ru">
					<img src="/images/email-32.png" class="social-links-f e-mail"><br>
					skeit.ol@mail.ru</a></span>				<span><a href="https://vk.com/skeitol" target="_blank">
						<img src="/images/vkontakte.png" class="social-links-f vk" width="32" height="32" style="width: 32px; height: 32px;"><br>
						Вконтакте</a></span>				<span><a href="https://www.facebook.com/skeit.ol" target="_blank">
							<img src="/images/f32.png" class="social-links-f facebook"><br>
							Facebook</a></span>
					<ar> <p><a href="/feedback.php">Обратная связь</a></p></ar>
				</div>
			</div>*/?>
			<div class="clear"></div>
            <p class="small-text">Отправляя любую форму на сайте, вы соглашаетесь с <a target="_blank" href='/privacy.php'>политикой конфиденциальности</a><br> и с <a  target="_blank" href='/agreement.php'>пользовательским соглашением</a> данного сайта.</p>
			<div class="col-lg-12 text-center small-text"><p>© SkeitOl 2012 - <?=date('Y')?></p></div>
		</div>
		</div>
	</section>
	<style>
		#upbutton {width: 35px;position: fixed;height: 100%;z-index: 100;top: 0;left: 0;cursor:pointer;}
		#upbutton:hover {background: #000;opacity: 0.6;}
		#upbutton img {opacity: 0.6;}
	</style>
<div id="upbutton">
    <img src="/images/up2.png" width="25" height="25" style="margin: 5px;"  alt="up"/>
</div>
<!-- End UpButton-->
<div style="display:none"><!-- Google analyticstracking -->
<?php include_once("analyticstracking.php") ?>
<!-- .Google analyticstracking -->
<!-- Yandex.Metrika informer --><a async href="https://metrika.yandex.ru/stat/?id=24809018&amp;from=informer"target="_blank" rel="nofollow"><img src="https://mc.yandex.ru/informer/24809018/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"style="width:88px; height:31px; border:0;" alt="Яндекс.Метрик" /></a><!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24809018 = new Ya.Metrika({ id:24809018, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/24809018" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</div>
<script defer src="/js/jquery-1.7.2.min.js" ></script>
<?php
if(!empty($sys_special_footer_text)) {
	echo $sys_special_footer_text;
} ?>
<script defer src="/js/all.js?v1"></script>
<?php
echo '</body>';
echo '</html>';