<?
//if(isset($_GET["test"]))
{
/*Блокируем контент. ждём дозагрузки страницы*/?>
<div id="preload_overload">
	<style>
	#preload_overload{
		position: fixed;width: 100%;
	    height: 100%;
	    background:#fff;
	    opacity:.95;
	    z-index: 1;display:none;
	}
	.child {
    display:inline-block;
    vertical-align:middle;
	}
	.helper {
	    display:inline-block;
	    vertical-align:middle;
	    height:100%;
	    width:0px;
	}
</style>
<script>
function imgLoaded(img){
	    var $img = $(img);
	    $img.parent().addClass('loaded');
};
var pagePreload={
	start: function(){
		document.body.style.overflow="hidden";
		document.getElementById("preload_overload").style.display="block";
	},
	endLoad: function(){
		window.onload=function() {
			$("head").append("<link rel='stylesheet' type='text/css' href='/style/style-1450046583053.css?06' />");
			setTimeout(function(){
				$( "#preload_overload" ).animate({opacity:0},100,"linear",function(){
					document.body.style.overflow="visible";
					document.getElementById("preload_overload").style.display="none";	
				});
			},1);
		};
	},
	
	parent:this,
	lazyLoad: function(){
		 var $images = $('.lazy_load');
	    $images.each(function(){
	        var $img = $(this),
	            src = $img.attr('data-src');
	         $img
	            .on('load',imgLoaded($img[0]))
	            //.attr('src',src);
	            .attr('style','background-image:url('+src+');');
	            //.css('background-image',src);
	    });
	},
	init: function() {
		this.start();
	},
	
};
	pagePreload.init();
	
</script>
	<div style="width: 100%;height: 100%;text-align: center;">
		<div class="child"><img src="/images/preloader_32.gif" alt="Загрузка страницы.."></div>
		<div class="helper"></div>
	</div>
</div>
<?}?>
<header><nav class="clearfix"><a href="/" class="s-style" title="Главная">S</a><a href="#" id="pull" style="margin: 0;" title="Раскрыть меню">Меню</a><ul class="clearfix"><li><a href='/articles/' title="Статьи">Статьи</a></li><li><a href='/news/' title="Новости">Новости</a></li><li><a href='/program/' title="Программы">Программы</a></li></ul></nav></header>