	<section class="premium-domains">
		<div class="container">
			<div class="col-lg-12 text-center">
				<div class="navy-line"></div>
					<h2>Основные разделы</h2>
			</div>
			<div class="col-lg-12 m-b-lg text-center">
				<div class="d1">
					<span><a href='/'>Главная</a></span>
					<span><a href='/program/'>Программы</a></span>
					<span><a href='/news/'>Новости</a></span>
					<span><a href='/articles/'>Статьи</a></span>
					<span><a href='/site-map.html'>Карта сайта</a></span>	
					<span><a href="/about/">О нас</a></span>
					<div class="clear"></div>
					<p><a href='/pages/5/'>Условия использования информации</a></p>
				</div>
				
			</div>
			
			<div class="clear"></div>
			<script>
				  (function() {
					var cx = '001110423535615128330:os1s-ieva4o';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
						'//www.google.com/cse/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				  })();
				</script>
				<gcse:search></gcse:search>
			<br><br>
		</div>
	</section>
	<?php
		$f_bg_src="/images/footer/";
		$current_month = date('m');
		$m_arr= array(
			"winter"=>array("1.jpg",
				"2.jpg",
				"3.jpg",
				"4.jpg",
				"5.jpg",
				"6.jpg",
				"7.jpg",
				"8.jpg"),
			"autumn"=>array("1.jpeg",
				"2.jpg",
				"3.jpg",
				"4.jpg",
				"5.jpg",
				"6.jpg",
				"7.jpg",
				"8.jpg",
				"9.jpg",
				"10.jpg"),
			"summer"=>array("1.jpg",
				"2.jpg",
				"3.jpg",
				"4.jpg",
				"5.jpg"),
			"spring"=>array("1.jpg",
				"2.jpg",
				"3.jpg",
				"4.jpg",
				"5.jpg",
				"6.jpg",
				"7.jpg")
			);
		switch ($current_month) {
			case 12:
			case 1:
			case 2:
				
				$time_year='winter';
				$r=rand(0,count($m_arr[$time_year]));
				$f_bg_src.=$time_year.'/'.$m_arr[$time_year][$r];
				break;
			case 3:
			case 4:
			case 5:
				$time_year='spring';
				$r=rand(0,count($m_arr[$time_year]));
				$f_bg_src.=$time_year.'/'.$m_arr[$time_year][$r];
				break;
			case 6:
			case 7:
			case 8:
				$time_year='summer';
				$r=rand(0,count($m_arr[$time_year]));
				$f_bg_src.=$time_year.'/'.$m_arr[$time_year][$r];
				break;
			case 9:
			case 10:
			case 11:
				$time_year='autumn';
				$r=rand(0,count($m_arr[$time_year]));
				$f_bg_src.=$time_year.'/'.$m_arr[$time_year][$r];
				break;
			default:
				$f_bg_src='http://files1.adme.ru/files/comment/part_1375/13740555-1380092876.jpeg';
				break;
		};
//		$f_bg_src='http://files1.adme.ru/files/comment/part_1375/13740555-1380092876.jpeg';
	?>
	<section class="module parallax parallax-1 services" style="background-image:url('<?php echo$f_bg_src;?>')">
		<div class="background_f">
			<div class="container">
				<div class="col-lg-12 text-center">
					<!--<div class="navy-line"></div>-->
						<h2>Контакты</h2>
				</div>
				<div class="col-lg-12 m-b-lg text-center">
					<p><strong>E-mail:</strong> <a href="mailto:info@skeitol.ru">info@skeitol.ru</a></p>
					<p><a href='feedback.php'>Обратная связь</a></p>
					<p><a href="http://vk.com/skeitol" target="_blank" class='social-links vk' title="SkeitOl VK" ><img title="SkeitOl VK" alt="SkeitOl VK" src="/images/vkontakte.png" width="32" height="32" style="width: 32px; height: 32px;" /></a></p>
					<p><a class='social-links facebook' href="http://www.facebook.com/skeit.ol" target="_blank" title="SkeitOl facebook"><img alt="SkeitOl facebook" src="/images/facebook-32.png" title="SkeitOl facebook"/></a></p>
					<p><a class='social-links gplus' href="https://plus.google.com/+SkeitolRus/posts" target="_blank" title="SkeitOl gplus"><img alt="SkeitOl gplus" src="/images/gplus.png" title="SkeitOl gplus" /></a></p>
				
				</div>				
				<div class="clear"></div>
				<div class="col-lg-12 text-center small-text"><p>© SkeitOl 2012 - <?php echo date('Y')?></p></div>
			</div>
		</div>
	</section>
	<!--
	<section class="contact gray-section">
		
	</section>-->
<div style="display:none"><!-- Google analyticstracking -->
<?php include_once("analyticstracking.php") ?>
<!-- .Google analyticstracking -->
<!-- Yandex.Metrika informer --><a href="https://metrika.yandex.ru/stat/?id=24809018&amp;from=informer"target="_blank" rel="nofollow"><img src="https://mc.yandex.ru/informer/24809018/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a><!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24809018 = new Ya.Metrika({ id:24809018, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/24809018" style="position:absolute; left:-9999px;" alt="Яндекс.Метрика" /></div></noscript><!-- /Yandex.Metrika counter -->
</div>
	
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
    <img src="/images/up2.png" width="25" height="25" style="margin: 5px;" alt="Up"/>
</div>
<script>        $(document).ready(function () { $("#upbutton").hide(); $(function () { $(window).scroll(function () { if ($(this).scrollTop() > 80) { $('#upbutton').fadeIn(); } else { $('#upbutton').fadeOut(); } }); $('#upbutton').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); return false; }); }); });    </script>
<!-- End UpButton-->
