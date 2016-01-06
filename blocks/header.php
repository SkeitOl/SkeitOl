<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
	/*Navi*/
	$(function () {
		var pull = $('#pull');
		menu = $('nav ul');
		menuHeight = menu.height();
		$(pull).on('click', function (e) {
			e.preventDefault();
			menu.slideToggle();
		});
		$(window).resize(function () {
			var w = $(window).width();
			if (w > 320 && menu.is(':hidden')) {
				menu.removeAttr('style');
			}
		});
	});
</script>
<header>
	<nav class="clearfix">
	<a href="/" class="s-style" title="Главная">S</a>
		 <a href="#" id="pull" style="margin: 0;" title="Раскрыть меню">Меню</a>
		<ul class="clearfix"><?/*
			<li><a href="/" title="Главная">Главная</a></li>
			*/?><li><a href='/articles/' title="Статьи">Статьи</a></li>
			<li><a href='/news/' title="Новости">Новости</a></li>
			<li><a href='/program/' title="Программы">Программы</a></li>
			<!--<li><a href='serials.php'>Сериалы [O_o]</a></li>-->
		</ul>
	   
	</nav>
</header>