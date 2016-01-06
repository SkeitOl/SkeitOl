<?
if($_SERVER['REQUEST_URI']=="/")// ||$_SERVER['REQUEST_URI']=="" || $_SERVER['REQUEST_URI']=="index.php"|| empty($_SERVER['REQUEST_URI']))
{
	include_once("footer_index.php");
}
else{
    $long_footer=true; include("footer_new.php");
/*?>
<div id='footer'>
    <div class="cen">
        <div class='ft-block'>
            <div class='title'>Основные разделы</div>
            <div class="d1"><span><a href='/'>Главная</a></span>
			<span><a href='/program/'>Программы</a></span>
			<span><a href='/news.html'>Новости</a></span>
			<span><a href='/articles.html'>Статьи</a></span>
			<span><a href='/site-map.html'>Карта сайта</a></span>	<span><a href='/pages4.html'>Гид</a></span>
			<p style="text-align:center"><a href='/pages5.html'>Условия использования информации</a></p>
			</div>
            <div class='title'>Приложения</div>
            <div class="d1"><span><a href='/program/timer_off/'>Timer_off</a></span>
				<span><a href='/program/sked/'>Sked</a></span>
				<span><a href='/program/htmlcolor/'>HtmlColor</a></span>			</div>
        </div>
        <div class='sp'></div>
        <div class='ft-block'>
            <div class='title'>Контакты</div>
            <div class="d1"><span><a href="mailto:info@skeitol.ru">
                <img src="/images/email-32.png" /><br />info@skeitol.ru</a></span>				<span><a href="http://vk.com/skeitol" target="_blank">
                    <img src="/images/vkontakte.png" width="32" height="32" style="width: 32px; height: 32px;" /><br />
                    Вконтакте</a></span>				<span><a href="http://www.facebook.com/skeit.ol" target="_blank">
                        <img src="/images/facebook-32.png" /><br />
                        Facebook</a></span>
                <ar> <p><a href='/feedback.php'>Обратная связь</a></p></ar>
            </div>
        </div>
        <div class='downfotter'><div class="d1">
		<span>
		<!-- Yandex.Metrika informer --><a href="https://metrika.yandex.ru/stat/?id=24809018&amp;from=informer" target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/24809018/3_0_FFFFFFFF_FFFFFFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a><!-- /Yandex.Metrika informer --><!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24809018 = new Ya.Metrika({id:24809018, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24809018" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
		</span>
		<span>© SkeitOl 2012 - <?php echo date('Y')?></span></div></div>
    </div>
</div>

<!-- Google analyticstracking -->
<?php include_once("analyticstracking.php") ?>
<!-- .Google analyticstracking -->
<!--UpButton-->
<script src="/js/jquery-1.7.2.min.js"></script>
<style>
    #upbutton {
        width: 35px;
        position: fixed;
        height: 100%;
        z-index: 100;
        top: 0;
        left: 0;
		cursor:pointer;
    }

        #upbutton:hover {
            background: #000;
            opacity: 0.6;
        }

        #upbutton img {
            opacity: 0.6;
        }
</style>
<div id="upbutton">
    <img src="/images/up2.png" width="25" height="25" style="margin: 5px;" />
</div>
<script>        $(document).ready(function () { $("#upbutton").hide(); $(function () { $(window).scroll(function () { if ($(this).scrollTop() > 80) { $('#upbutton').fadeIn(); } else { $('#upbutton').fadeOut(); } }); $('#upbutton').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); return false; }); }); });    </script>
<!-- End UpButton-->	
<?}*/
}?>