<div class="clear"></div>

<!--<div id="left_menu" class="links">
	<ul class="menu">	   
		<li style="color:#171C24;"><a href="feedback.php">Обратная связь
			<?php 
			$result=mysql_query("SELECT * FROM feedback");
			$myrow= mysql_fetch_array($result);
			$k=0;
			do{
				if($myrow['checkbox']==1) $k++;
			}
			while($myrow= mysql_fetch_array($result));
			echo"(".$k.")";
			?>
			</a>
		</li>
		<li>			
			<a href="index.php?act=update&tp=news" class="item-next-img">Новости</a>
			<ul>
				<li><a href="index.php?act=update&tp=news" class="item-next-img">Список</a></li>
				<li><a href="index.php?act=add&tp=news"><img class="li-link" src="images/add.png" title="Добавить"/>Добавить</a></li>
			</ul>
		</li>
		<li>
			<a href="index.php?act=update&tp=articles"class="item-next-img">Статьи</a>
			<ul>
				<li><a href="index.php?act=update&tp=articles"class="item-next-img">Статьи</a></li>
				<li><a href="index.php?act=add&tp=articles"><img class="li-link" src="images/add.png" title="Добавить"/>Добавить</a></li>
			</ul>
		</li>
		<li>
			<a href="index.php?act=update&tp=pages"class="item-next-img">Страницы</a>
			<ul>
				<li><a href="index.php?act=update&tp=pages"class="item-next-img">Страницы</a></li>
				<li><a href="index.php?act=add&tp=pages"><img class="li-link" src="images/add.png" title="Добавить"/>Добавить</a>			</li>
			</ul>
		</li>   
		<li>		   
		   <a href="index.php?act=update&tp=serials"class="item-next-img">Сериалы</a>
		   <ul>
				<li><a href="index.php?act=update&tp=serials"class="item-next-img">Сериалы</a></li>
				<li><a href="index.php?act=add&tp=serials"><img class="li-link" src="images/add.png" title="Добавить"/>Добавить</a>			</li>
			</ul>
		</li>
		<li>			
			<a href="index.php?act=update&tp=program"class="item-next-img">Программы</a>
			<ul>
				<li><a href="index.php?act=update&tp=program"class="item-next-img">Программы</a></li>
				<li><a href="index.php?act=add&tp=program"><img class="li-link" src="images/add.png" title="Добавить"/>Добавить</a></li>
			</ul>
			
		</li>	
		
		<li>Другие
			<ul>
				<li><a href="../index.php">Вернуться на сайт</a></li>
				<li style="color:#171C24;"><a href="2.php">Загрузка картинок</a></li>
				<li style="color:#171C24;"><a href="category.php">Категории[Статьи]</a></li>
				
			</ul>
		</li>
	</ul>
</div>
-->
<style>
nav {  
    height: 40px;  
    width: 100%;  
    background: #455868;  
    font-size: 11pt;  
    font-family: 'PT Sans', Arial, sans-serif;  
    font-weight: bold;  
    position: relative;  
    border-bottom: 2px solid #283744;  
}  
nav ul {  
    padding: 0;  
    margin: 0 auto;  
    width: 600px;  
    height: 40px;  
}nav li {  
    display: inline;  
    float: left;  
}  
.clearfix:before,  
.clearfix:after {  
    content: " ";  
    display: table;  
}  
.clearfix:after {  
    clear: both;  
}  
.clearfix {  
    *zoom: 1;  
}nav a {  
    color: #fff;  
    display: inline-block;  
    width: 100px;  
    text-align: center;  
    text-decoration: none;  
    line-height: 40px;  
    text-shadow: 1px 1px 0px #283744;  
}  
nav li a {  
    border-right: 1px solid #576979;  
    box-sizing:border-box;  
    -moz-box-sizing:border-box;  
    -webkit-box-sizing:border-box;  
}  
nav li:last-child a {  
    border-right: 0;  
}  
nav a:hover, nav a:active {  
    background-color: #8c99a4;  
}
nav a#pull {  
    display: none;  
}
@media screen and (max-width: 600px) {  
    nav {   
        height: auto;  
    }  
    nav ul {  
        width: 100%;  
        display: block;  
        height: auto;  
    }  
    nav li {  
        width: 50%;  
        float: left;  
        position: relative;  
    }  
    nav li a {  
        border-bottom: 1px solid #576979;  
        border-right: 1px solid #576979;  
    }  
    nav a {  
        text-align: left;  
        width: 100%;  
        text-indent: 25px;  
    }  
}
@media only screen and (max-width : 480px) {  
    nav {  
        border-bottom: 0;  
    }  
    nav ul {  
        display: none;  
        height: auto;  
    }  
    nav a#pull {  
        display: block;  
        background-color: #283744;  
        width: 100%;  
        position: relative;  
    }  
    nav a#pull:after {  
        content:"";  
        background: url('nav-icon.png') no-repeat;  
        width: 30px;  
        height: 30px;  
        display: inline-block;  
        position: absolute;  
        rightright: 15px;  
        top: 10px;  
    }  
}
@media only screen and (max-width : 320px) {  
    nav li {  
        display: block;  
        float: none;  
        width: 100%;  
    }  
    nav li a {  
        border-bottom: 1px solid #576979;  
    }  
}  
</style>
<script>
$(function() {
            var pull 		= $('#pull');
                menu 		= $('nav ul');
                menuHeight	= menu.height();

            $(pull).on('click', function(e) {
                e.preventDefault();
                menu.slideToggle();
            });

            $(window).resize(function(){
        		var w = $(window).width();
        		if(w > 320 && menu.is(':hidden')) {
        			menu.removeAttr('style');
        		}
    		});
        });
</script>
<nav class="clearfix">  
    <ul class="clearfix">  
        <li><a href="/admin/">Главная</a></li>  
        <li><a href="index.php?act=update&tp=articles"<?/*class="item-next-img"*/?>>Статьи</a></li>
		<li><a href="index.php?act=update&tp=news" <?/*class="item-next-img"*/?>>Новости</a></li>  
        <li><a href="index.php?act=update&tp=pages" <?/*class="item-next-img"*/?>>Страницы</a></li>
		<li><a href="index.php?act=update&tp=program" <?/*class="item-next-img"*/?>>Программы</a></li>
		<li><a href="/" <?/*class="item-next-img"*/?>>Сайт</a></li>
    </ul>  
    <a href="#" id="pull">Menu</a>  
</nav>
<div class="clear"></div>