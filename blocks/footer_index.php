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
			
			<div class="clear"></div><?/*
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
				<gcse:search></gcse:search>*/?>
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
				$f_bg_src='https://files1.adme.ru/files/comment/part_1375/13740555-1380092876.jpeg';
				break;
		};
//		$f_bg_src='https://files1.adme.ru/files/comment/part_1375/13740555-1380092876.jpeg';
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
					<p><a href="https://vk.com/skeitol" target="_blank" class='social-links vk' title="SkeitOl VK" ><img title="SkeitOl VK" alt="SkeitOl VK" src="/images/vkontakte.png" width="32" height="32" style="width: 32px; height: 32px;" /></a></p>
					<p><a class='social-links facebook' href="https://www.facebook.com/skeit.ol" target="_blank" title="SkeitOl facebook"><img alt="SkeitOl facebook" src="/images/facebook-32.png" title="SkeitOl facebook"/></a></p>
					<p><a class='social-links gplus' href="https://plus.google.com/+SkeitolRus/posts" target="_blank" title="SkeitOl gplus"><img alt="SkeitOl gplus" src="/images/gplus.png" title="SkeitOl gplus" /></a></p>
				
				</div>
				<div class="clear"></div>
                <p>Отправляя любую форму на сайте,<br>вы соглашаетесь с <a target="_blank" href='/privacy.php'>политикой конфиденциальности</a><br> и с <a  target="_blank" href='/agreement.php'>пользовательским соглашением</a> данного сайта.</a></p>
				<div class="col-lg-12 text-center small-text"><p>© SkeitOl 2012 - <?php echo date('Y')?></p></div>
			</div>
		</div>
	</section>
<div style="display:none">
<?php include_once($_SERVER['DOCUMENT_ROOT']."analyticstracking.php") ?>
</div>
<!--UpButton-->
<div id="upbutton">
    <img src="/images/up2.png" width="25" height="25" style="margin: 5px;" alt="Up"/>
</div>
<link rel="stylesheet" href="/bc/slick/slick.css">
<link rel="stylesheet" href="/bc/slick/slick-theme.css">
<script defer src="/js/jquery-1.7.2.min.js"></script>
<script defer src="/bc/slick/slick.min.js"></script>
<script defer src="/js/all_index.js"></script>