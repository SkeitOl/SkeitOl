<?php 
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
}if ($id == '')
    unset($id);
if (isset($_GET['list']))
    $list = htmlspecialchars($_GET['list']);
else
    $list = 1;
include("blocks/bd.php");

/*ф-ии для работы*/

/*Выводит статью*/
function showArticlesID(
	/*Массив полученный при sql запросе*/
	$myrow,
	/*Подключение к базе данных*/
	$db)
{
    /*StartIDArticlesShow*/
	setlocale(LC_ALL, 'ru_RU.UTF-8');
	$st_date= strftime('%d %h %Y %I:%M', strtotime($myrow['date']));
	$date_publisher=(date_format(date_create($myrow['date']), 'Y-m-d'))."T".(date_format(date_create($myrow['date']), 'H:i'));
	echo"
	<div itemscope='' itemtype='http://schema.org/Article'>
		<div class='title-con-block' ><span itemprop='name' itemprop='headline' >".$myrow['title']."</span></div>
		<span style='display:none' itemprop='description'>".htmlspecialchars($myrow['description'])."</span>";
		$photo_img=strip_tags($myrow['src_preview']);
		if(empty($photo_img))$photo_img="/images/favicon/apple-touch-icon-114x114.png";
		if($photo_img[0]=="/")$photo_img="http://".$_SERVER['SERVER_NAME'].$photo_img;
		$size = getimagesize ($photo_img);
		$sizes = explode('"', $size[3]);
		?>
		<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" style="display:none">
			<img src="<?=$photo_img?>"/>
			<meta itemprop="url" content="<?=$photo_img?>">
			<meta itemprop="width" content="<?echo(!empty($sizes))?$sizes[1]:"150"?>">
			<meta itemprop="height" content="<?echo(!empty($sizes))?$sizes[3]:"150"?>">
		</div>
		<?
		echo"<div class='news-data'>
			<meta itemprop='datePublished' content='".$date_publisher."'/>
			
			<span itemprop='dateCreated' style='display:none'>".$date_publisher."</span><time datetime='".$date_publisher."'></time>".$st_date."
			<div class='views-data'>Просмотров: ".$myrow['views']."</div>

		</div>
		<div style='clear:both'></div>";?>
	
	<?/*<!--
	<div id="raiting_star">
		<div id="raiting">
			<div id="raiting_blank"></div> <!--блок пустых звезд-->
			<div id="raiting_hover"></div> <!--блок  звезд при наведении мышью-->
			<div id="raiting_votes"></div> <!--блок с итогами голосов -->
		</div>
		<div id="raiting_info"><h5>Тут будет иконка загрузки и все такое</h5></div>
	</div>--*/?>
	
	<?
	$count_comments=mysql_query("SELECT COUNT(*) FROM comments_articles WHERE APPROVED='1' AND ID_ARTICLES=".$myrow['id'], $db);
	$row_count_comments = mysql_fetch_array($count_comments);
	?>
	<div style='display:none'><pre><?print_r()?></pre></div>
	<?
	echo '<div itemprop="articleBody">'.$myrow['text']."</div>
		<meta itemprop='interactionCount' content='UserComments:".$row_count_comments[0]."'/>";

	/* Author */
	echo"<br><div class='author-view'><span itemprop='author'>".$myrow['author']."</span></div><br/>";
	/* Category */
	$array1 = array();
	$array1 = unserialize($myrow['category']); /**/
	if (count($array1) > 0) {
		echo"<div class='category-view'><p style='border-left: 3px #57AA43 solid;padding-left: 10px;text-indent: 0px;'>";
		for ($i = 0; $i < count($array1); $i++) {
			$result1 = mysql_query("SELECT * FROM category WHERE id='$array1[$i]'", $db);
			$row1 = mysql_fetch_array($result1);
			echo "<a href='/articles/?category=" . $row1['id'] . "' title='" . $row1['name'] . "'>" . $row1['name'] . "</a>";
			//if($i<count($array1)-1)echo ", ";
		}
		echo"</p></div></div>";
	}
	/* Navigaciya */
	?>
	</div>
	<div class="con-block box-shadow2">
		<div class='navig links'>
			<? $result = mysql_query("SELECT id,title,url FROM articles WHERE id<". $myrow['id']." AND active=1 ORDER BY id DESC LIMIT 1;", $db);
			$row = mysql_fetch_array($result);
			echo"<div>";
			if ($row['id'] != "") {
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo "<a href='/articles/".$url_page."/' name='" . strip_tags($row['title']) . "' title='" . strip_tags($row['title']) . "'>Предыдущая статья<abbr>".strip_tags($row['title'])."</abbr></a>";
			}
			echo"</div>";
			$result = mysql_query("SELECT id,title,url FROM articles WHERE id>".$myrow['id']." AND active=1 ORDER BY id LIMIT 1;", $db);
			$row = mysql_fetch_array($result);
			echo"<div>";
			if ($row['id'] != "") {
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo"<a href='/articles/".$url_page."/' name='" . strip_tags($row['title']) . "' title='" . strip_tags($row['title']) . "'>Следующая статья<abbr>".strip_tags($row['title'])."</abbr></a>";
			}?>
			</div>
		</div>
	</div>
	<?/* Social */?>
	<div class="con-block box-shadow2">
		<h4 class='socl'>Понравилась статья? Поделись в социальных сетях:</h4>
		<div id='vk_like'></div>
		
		<script type='text/javascript'>
			window.onload=function() {
			VK.Widgets.Like('vk_like', {type: 'mini', verb: 1});};
		</script>
	</div>
	<div class="con-block box-shadow2">
		<h4 class='socl'>Комментарии:</h4>
		<?/*
		<!-- Put this div tag to the place, where the Comments block will be -->
		<div id='vk_comments'></div>
		<script type='text/javascript'>
			VK.Widgets.Comments('vk_comments', {limit: 10, width: '*', attach: '*'});
		</script>*/
		//Отправляем запрос есть на получение комментарий:
		$com_res = mysql_query("SELECT * FROM comments_articles WHERE APPROVED='1' AND ID_ARTICLES=".$myrow['id'], $db);
		$row = mysql_fetch_array($com_res);
		/*echo"<pre>";
		print_r($row);
		echo"</pre>";*/
		?>
		<?
		if(empty($row)){echo"<p>Коментарий пока нет, стань первым!</p>";}
		else{?>
		<div class="comments">
			<?
			//setlocale(LC_ALL, 'ru_RU.UTF-8');
			do {?>
				<div class="comment">
					<div class="comment_up">
						<div class="comment__avatar">
	                        <div>
	                            <img width="47" alt="комментарий <?=($row['NICK'])?>" src="<?
								if(empty($row['SRC_IMG'])) echo'/images/iron_ma.png';
								else echo$row['SRC_IMG'];
	                            ?>">
	                        </div>
	                    </div>
						<div class="comment_nik"><?=($row['NICK'])?></div>
						<div class="comment_date"><?=(strftime('%d %h %Y %I:%M', strtotime($row['DATE_TIME'])))?></div>
						<div class="comment_text <?if(strlen($row['TEXT'])>700)echo"short_comment_text" ?>"><?
						if(strlen($row['TEXT'])>700)
						{?>
							<span class="show_all_text"><span class="show_all_text_desc">показать всё</span></span>

						<?}
						echo$row['TEXT'];?></div>
					</div>
					
				</div>
			<?
			} while ($row = mysql_fetch_array($com_res));
			?>
		</div>
		<?}?>
		<div>
			<div><p class="add_com_link" onclick="ShowHideElement('#block_add_com')">Добавить</p></div>
			<script>
			function ShowHideElement (id) {
				if($(id).css("display")=="none")
					$(id).css("display","block");
				else $(id).css("display","none");
			}
			window.onload=function() {
				$("#submit_comment").click(function(){
					if($("#com_nick").val().length==0){
						$("#res_comm").html("<span class='text_error'>Имя пусто!</span>").show();
						$("#com_nick").css({"border":"1px solid red","box-shadow":"0 0 3px red"});
						setTimeout(function(){$("#com_nick").removeAttr("style");$("#res_comm").hide();}, 3000);
						return false;
					}else if($("#com_text").val().length==0){
						$("#res_comm").html("<span class='text_error'>Сообщение пусто!</span>").show();
						$("#com_text").css({"border":"1px solid red","box-shadow":"0 0 3px red"});
						setTimeout(function(){$("#com_text").removeAttr("style");$("#res_comm").hide();}, 3000);
						return false;
					}

					$.post($("#form_add_com").attr("action"), $("#form_add_com").find('input,textarea').serialize()//$("#form_add_com :input, #form_add_com :textarea").serializeArray()
					, function (info) {
						if(info=="1"){
							$("#form_add_com").remove();
							$("#res_comm").html("<span class='text_good'>После проверки сообщения модератором оно будет добавленно.</span>");}
						else $("#res_comm").html(info);
					});
				});
			};
			function submitS(obj) {/*
				$("#form_add_com").submit(function () {
				$.post($("#form_add_com").attr("action"), $("#form_add_com").find('input,textarea').serialize()//$("#form_add_com :input, #form_add_com :textarea").serializeArray()
					, function (info) {
						if(info=="1"){
							$("#form_add_com").remove();
							$("#res_comm").html("<span class='text_good'>После проверки сообщения модератором оно будет добавленно.</span>");}
						else $("#res_comm").html(info);
				});
			});
				return false;*/
			}
			/*$( "#form_add_com" ).submit(function( event ) {
  alert( "Handler for .submit() called." );
  event.preventDefault();
});*/

			</script>
			<div id="block_add_com" style="display:none">
			<?/*
				<!-- Put this script tag to the <head> of your page -->
				<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>
				<script type="text/javascript">
				  VK.init({apiId: 4759039});
				</script>
				<!-- Put this div tag to the place, where Auth block will be -->
				<div id="vk_auth"></div>
				<script type="text/javascript">
				VK.Widgets.Auth("vk_auth", {width: "200px", authUrl: '/auth/'});
				</script>*/?>
				
				<form action="/add_comment.php" id="form_add_com" class="form_com" method="post" onsubmit="submitS(this);return false">
					<input type="hidden" name="IP" value="<?=$_SERVER['REMOTE_ADDR']?>">
					<input type="hidden" name="ITEM_ID" value="<?=$myrow['id']?>">
					<input type="hidden" name="type" value="articles">
					<input type="hidden" name="HASH" value="<?=md5($myrow['id'])?>">
					
					<div class="row">
						<div class="col-4 col-xs-1"><div class="row con-pg"><label for="com_name">Имя<span class="required">*</span>:</label></div></div>
						<div class="col-4 col-xs-1"><div class="row con-pg"><input required id="com_nick" type="text" name="NICK"></div></div>
						<div class="col-4 col-xs-1"><div class="row con-pg text-align-right text-align-left-xs"><label for="com_name">E-mail:</label></div></div>
						<div class="col-4 col-xs-1"><div class="row con-pg"><input  id="com_email" type="text" name="EMAIL"></div></div>
					</div>
					<div class="row">
						<div class="col-4 col-xs-1"><div class="row con-pg"><label for="com_text">Комментарий<span class="required">*</span>:</label></div></div>
						<div class="col-8 col-xs-1"><div class="row con-pg"><textarea required name="TEXT" id="com_text"></textarea></div></div>
					</div>
					<div class="row">
						<div class="col-4 col-xs-1"><div class="row con-pg"><label for="com_captch">CAPTCHA<span class="required">*</span>:</label></div></div>
						<div class="col-8 col-xs-1"><div class="row con-pg"><div class="g-recaptcha" data-sitekey="6LeaFBETAAAAABDp57Hgrxg7A6y5vSlu0QhV5zg-"></div></div></div>
					</div>
					<?/*
					<p><label for="com_name">Имя: </label><input required id="com_nick" type="text" name="NICK"></p>
					<p></p>
					<p><label for="com_captch">CAPTCHA: </label> <?/*<img src="/captcha/captcha_sum.php" id="captcha-img" /><input required id="com_captch" type="text" name="CAPTCHA">?></p>
					<div style="margin:-30px 0 0 150px"><div class="g-recaptcha" data-sitekey="6LeaFBETAAAAABDp57Hgrxg7A6y5vSlu0QhV5zg-"></div></div>
					*/?>
					<div class="align-center">
						<input type="submit" id="submit_comment" value="Отправить"/>
					</div>
				</form>
				<div id="res_comm"></div>
			</div>
		</div>
	 </div>
	 <?/*EndStartIDArticlesShow*/
}
/*Выводит статьи*/
function showArticlesList($myrow, $db){

}
/*Вывод записини*/
function PrintArticlesItem($myrow,$db){
	$array1 = array();
	$array1 = unserialize($myrow['category']); /**/
	$category_string='';
	if (count($array1) > 0) {
		$category_string="<div>
			<p style='color: #5A5353;border-left: 3px #57AA43 solid;padding-left:5px;text-indent: 0px;margin: 3px 0 3px 10px;'>";
		for ($i = 0; $i < count($array1); $i++) {
			$result1 = mysql_query("SELECT * FROM category WHERE id='$array1[$i]'",$db);
			$row1 = mysql_fetch_array($result1);
			$category_string.=$row1['name'].', ';
			//if($i<count($array1)-1)echo ", ";									
		}
		$category_string=substr($category_string,0,-2);
		$category_string.="</p></div>";
	}
	if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];

		setlocale(LC_ALL, 'ru_RU.UTF-8');
		$st_date= strftime('%d %h %Y %I:%M', strtotime($myrow['date']));
		//date_format(date_create($myrow['date']), 'd-M-Y H:i')
		?><a class='news-item-link' href='/articles/<?=$url_page?>/' itemscope itemtype='http://schema.org/Article'>
			<div class='news-item'>
				<div class="left_con">
					<? $photo_img=strip_tags($myrow['src_preview']);
					if(empty($photo_img))$photo_img="/images/favicon/apple-touch-icon-114x114.png";?>
					<?/*<span class="photo_img" style="background-image: url('<?=$photo_img?>')"></span>*/?>
					
					<span class="photo_img lazy_load" style="background-image: url('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7')" data-src="<?=$photo_img?>" ></span>
				</div>
				<div class="right_con">
					<div class='news-title'  itemprop='name'><?=$myrow['title']?></div>											
					<div>
						<div class='news-data'><?=$st_date?><div class='view_block'><?=$myrow['views']?></div></div>
						
					</div>
					<div><?=$category_string?></div>
					<div class='news-main'>
						<div class='news-text' itemprop='description'><?=$myrow['description']?></div>
						<div class='clear'></div>
					</div>
				</div>
			</div>
			</a><?
}

if (isset($id)) {
		/*
		* смотрим есть ли id или url
		*/
		$result = mysql_query("SELECT * FROM articles WHERE id=$id AND active=1", $db);
		$myrow = mysql_fetch_array($result);
		if ($myrow['id'] == ''){
			$result = mysql_query("SELECT * FROM articles WHERE url='$id' AND active=1", $db);
			$myrow = mysql_fetch_array($result);
			if ($myrow['id'] == ''){
				unset($id);
				/*выводим 404*/
				header("HTTP/1.0 404 Not Found"); 
				header("HTTP/1.1 404 Not Found"); 
				header("Status: 404 Not Found");
				header("Location: http://skeitol.ru/error-pages/error404.htm");
				die(); 
				/*echo '<pre>';
				print_r(get_headers('http://skeitol.ru'));*/exit();
			}
			else{
				$id=$myrow['id'];
			}
		} 
		if ($myrow['id'] != ''){
			$sys_title= strip_tags($myrow['title']);
			if(!empty($myrow['meta_keywords']))$sys_keywords=$myrow['meta_keywords'];
			if(!empty($myrow['meta_description']))$sys_description=$myrow['meta_description'];
          	if(!empty($myrow['src_preview']))$og_image=$myrow['src_preview'];
		}
	}
	else $sys_title="Статьи";
header('Content-Type: text/html; charset= utf-8');
session_start();

//echo print_r($_SESSION);
if($_SESSION['view'][$id]!=1 && $_SESSION['view'][$id]!="1")
{
	$_SESSION['view'][$id]=1;	
	$result3 = mysql_query("UPDATE articles SET views=views+1 WHERE id='$id'", $db);
}
include("blocks/func/func.php");
?>
<!DOCTYPE html>
<html>
<?php
	if(empty($sys_description))$sys_description="Статьи и информационные ресурсы SkeitOl";
	if(empty($sys_keywords))$sys_keywords="Articles SkeitOl, Статьи, Статьи SkeitOl,Статьи SkeitOl Soft";
	$sys_pages="articles";
	if(empty($sys_pages_print))$sys_pages_print="Статьи";
	/*<link href="/style/raiting.css" rel="stylesheet" />*/
	$sys_special_head_text='';
    $sys_special_footer_text='
		<link href="/css/articles.css" rel="stylesheet"/>
		<!-- Plagin view image -->
        <script src="/js/jquery-1.7.2.min.js"></script>
        <script src="/js/lightbox.js"></script>
        <link href="/style/lightbox.css" rel="stylesheet" />
        <!-- END Plagin view image -->
        <!-- Social-->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
        <script type="text/javascript">
            VK.init({apiId: 3743505, onlyWidgets: true});
        </script>
        <script type="text/javascript" src="/js/articles.js"></script>';
        $sys_special_footer_text.='<script src="https://www.google.com/recaptcha/api.js"></script>';
	include_once("blocks/head_optimize.php");
?>
<body>
<div class="wrapper-container">
	<div id="content_r_long">
	<?php include("blocks/optimiert/header.php"); ?>
	<?//include_once("blocks/breadcrumb.php");?>
	<div id='content'>
		<div class='left-con'>			
			<div class='con-block box-shadow2'>
				<?php
				if (!isset($id)){//Выводит список
					
					echo"<h1 style='text-align: center; margin: 0px;'>Статьи</h1>";
					$sort["VALUE"]="";$sort["NAME"]="";
					if(isset($_GET['sort'])){						
						switch(htmlspecialchars($_GET['sort'])){
						case"pop": $sort["VALUE"]="views";$sort["NAME"]="pop"; break;
						};
					}
					if(empty($sort["VALUE"]))unset($sort);					
					if(empty($_GET['category'])):
					?>
						<div>
							<p>Сортировка:
							<?if($sort["VALUE"]=="views"){?>
								<b>популярные</b>
							<?}else{?>
								<a href="/articles/?sort=pop" class="link" rel="nofollow">популярные</a>
							<?}?>
							<?if(empty($sort)){?>
								<b>все</b>
							<?}else{?>
								<a class="link" href="/articles/"rel="nofollow">все</a>
							<?}?>
								<span style="float: right"><a class="link" href="/articles/rss/" title="RSS SKEITOL">rss</a></span>
							</p>
						</div>					
					<?
					endif;
					//
					if (!isset($_GET['category'])) {
						
						$step = 10;
						$startI = 0;
						$endI = $step - 1;
						if (isset($list)) {
							if ($list <= 0) {
								echo"Нет такой страницы!!!<br>Вывод первой страницы";
							} else {
								$startI = ($list - 1) * $step;
								$endI = $startI + $step;
							}
						}
						$sql_sort_name='date';//Сортировка по умолчанию
						if(!empty($sort["VALUE"]))$sql_sort_name=$sort["VALUE"];
						//echo"<p style='color: #006fae;'><b>Статьи:</b></p>";
						/*echo"startI=$startI<br>";
						echo"endI=$endI<br>";
						echo"sql_sort_name=$sql_sort_name<br>";*/
						?><div id="list_block"><?
						$result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER BY ".$sql_sort_name." DESC LIMIT $startI,$endI", $db);
						$myrow = mysql_fetch_array($result);
						$in = 1;
						do
						{
							PrintArticlesItem($myrow,$db);
							$in++;
						}
						while ($in <= $step && $myrow = mysql_fetch_array($result));
						?></div><?
						//
							?>
							<style>
								#preload_list_articles{
									background:url('/images/preloader_32.gif');
									display:none;
									width:32px;height:32px;
								}
								#load_articles{display: inline-block;margin: 0 0 11px 0px;vertical-align: bottom;}
							</style>
							<div class="align-center" style="height: 32px;"><span id="preload_list_articles"></span><span id="load_articles" data-list="<?=($list+1)?>">Загрузить ещё</span></div>
							<?
						//Вывод списка
						$result = mysql_query("SELECT COUNT(*) as count FROM articles WHERE active=1", $db);
						$row = mysql_fetch_array($result);
						if ($row['count'] > $step) {//"Записей больше".$step;
							$i = 1;
							$special_sort='';
							if(!empty($sort))$special_sort='&sort='.$sort["NAME"];
							?>
							<p class="no-text-indent">Всего записей: <?=$row['count']?><br>Страница №<?=$list?></p><?
							echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;
				overflow: auto;'>";
							echo"<span class='navigation'>";
							if ($list == 1)
								echo"<span class='no-link'><</span>";
							else
								echo"<a href='/articles/?list=".($list - 1).$special_sort."'><</a>";
							$n = (int) ($row['count'] / $step);
							if ($row['count'] % $step > 0)
								$n++;
							for ($i = 1; $i <= $n; $i++)
								if ($i != $list)
									echo"<a href='/articles/?list=" . ($i).$special_sort."'>" . ($i) . "</a>";
								else
									echo"<span class='no-link'>" . ($i) . "</span>";
							if ($list == $n)
								echo"<span class='no-link'>></span>";
							else
								echo"<a href='/articles/?list=" . ($list + 1) .$special_sort."'>></a>";
							echo"</span>";
							echo"</div>";
							
						}
						//
						
					}
					else {
						$result1 = mysql_query("SELECT id,name FROM category WHERE id='" . $_GET['category'] . "'", $db);
						$row = mysql_fetch_array($result1);
						if ($result1 && $row['id'] != "") 
						{
							echo"<p><b>Статьи на тему: <span style='color:#FF3535'>".$row['name']."</span></b></p>";
							echo"<div class='links'>";
							$array1 = array();
							//WHERE category='".$row['name']."'"
							$result1 = mysql_query("SELECT * FROM articles", $db);
							$r = mysql_fetch_array($result1);
							$b = false;
							do {
								$b = False;
								$array1 = unserialize($r['category']);
								for ($i = 0; $i < count($array1); $i++) {
									if ($array1[$i] == $row['id']) {
										$b = True;
										break;
									}
								}
								if ($b) {
									PrintArticlesItem($r,$db);
									/*
									if(!empty($r['url']))$url_page=$r['url'];else $url_page=$r['id'];
									echo"<li><a href='/articles/".$url_page."/' title='" . $r['title'] . "'>" . $r['title'] . "</a></li>";*/
								}
							} while ($r = mysql_fetch_array($result1));

							echo"</div>";
						} else echo"<p>Неизвестная категория.</p>";
					}
					?>
					</div>
					<?
				}
				else { //Выводит данные по id
					showArticlesID($myrow, $db);
                }?>
            </div>
            <div class='right-con'><?php include_once("blocks/rightblock-articles.php");?></div>
        </div>
         </div>
          </div>
		<?php //include("blocks/footer.php"); ?>
		<?php $long_footer=true; include("blocks/footer_optimize.php"); ?>
    </body>
</html>