<?
/*
 * Articles
*/
class Articles
{

    function includeCoreSkeitOl($fullDoc=false){
        $src= "/skeitol/core/Core.php";
        if($fullDoc){
            $src=$_SERVER["DOCUMENT_ROOT"].$src;
        }else{
         $src="..".$src;
        }
        return include_once($src);
    }
    /*Выводит статьи*/
    public function showArticlesList($myrow, $db)
    {
        if (isset($_GET['list']))
            $list = htmlspecialchars($_GET['list']);
        else
            $list = 1;
        $sort["VALUE"]="";
        $sort["NAME"]="";
        if(isset($_GET['sort'])){
            switch(htmlspecialchars($_GET['sort'])){
             case"pop": $sort["VALUE"]="views";$sort["NAME"]="pop"; break;
            };
        }
        if(empty($sort["VALUE"]))unset($sort);

        if($_GET['type']!="ajax_ls_only"){

            echo"<h1 style='text-align: center; margin: 0px;'>Статьи</h1>";
            if(empty($_GET['category'])):
            ?><div style="clear:both">
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
                        <?/*<span style="float: right"><a class="link" href="/articles/rss/" title="RSS
                        SKEITOL">rss</a></span>*/?>
                    </p>
                </div>
                <div class='clear'></div><?
            endif;
        }
        if (!isset($_GET['category'])) {
            $step = 9;
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
            if($_GET['type']!="ajax_ls_only"){
                ?><div id="list_block"><?
            }
            include_once($_SERVER['DOCUMENT_ROOT']."/blocks/bd.php");
            
            $result = mysql_query("SELECT * FROM articles WHERE active=1 ORDER BY ".$sql_sort_name." DESC LIMIT $startI,$endI", $db);
            $myrow = mysql_fetch_array($result);
            $in = 1;

            do
            {
                $this->PrintArticlesItem($myrow,$db);
                $in++;
            }
            while ($in <= $step && $myrow = mysql_fetch_array($result));
            if($_GET['type']!="ajax_ls_only"){


                ?></div>
                <div class='clear'></div><?
                //Вывод списка
                $result = mysql_query("SELECT COUNT(*) as count FROM articles WHERE active=1", $db);
                $row = mysql_fetch_array($result);


                if(($row['count']/ $step)>=$list){
                    ?>
                    <style>
                        #preload_list_articles{
                            background:url('/images/preloader_32.gif');
                            display:none;
                            width:32px;height:32px;
                        }
                        #load_articles{display: inline-block;margin: 0 0 11px 0px;vertical-align: bottom;}
                    </style>
                    <??>
                    <div class="align-center" style="height: 32px;">
                        <span id="preload_list_articles"></span><span id="load_articles" data-list="<?=($list+1)?>">Загрузить ещё</span>
                    </div><?
                }



                if ($row['count'] > $step) {//"Записей больше".$step;
                    $i = 1;
                    $special_sort='';
                    if(!empty($sort))$special_sort='&sort='.$sort["NAME"];

                    ?><p class="no-text-indent">Всего записей: <?=$row['count']?><br>Страница №<?=$list?></p>
                    <div style='position: relative;width: 100%; margin: 0px auto;text-align: center;overflow: auto;'>
                        <span class='navigation'><?
                    if ($list == 1)
                        echo"<span class='no-link'><</span>";
                    else
                        echo"<a href='/articles/?list=".($list - 1).$special_sort."' data-list='".($list - 1)."' class='ajax_nav_links'><</a>";
                    $n = (int) ($row['count'] / $step);
                    if ($row['count'] % $step > 0)
                        $n++;
                    for ($i = 1; $i <= $n; $i++)
                        if ($i != $list)
                            echo"<a href='/articles/?list=" . ($i).$special_sort."' data-list='".($i)."' class='ajax_nav_links'>" . ($i) . "</a>";
                        else
                            echo"<span class='no-link'>" . ($i) . "</span>";
                    if ($list == $n)
                        echo"<span class='no-link'>></span>";
                    else
                        echo"<a href='/articles/?list=" . ($list + 1) .$special_sort."' data-list='".($list+1)."' class='ajax_nav_links'>></a>";
                    echo"</span>";
                    echo"</div>";
                }
            }
							//

						}
						else {
							include_once($_SERVER['DOCUMENT_ROOT']."/blocks/bd.php");
							$result1 = mysql_query("SELECT id,name FROM category WHERE id='" . $_GET['category'] . "'", $db);
							$row = mysql_fetch_array($result1);
							if ($result1 && $row['id'] != "")
							{
								echo"<p><b>Статьи на тему: <span style='color:#FF3535'>".$row['name']."</span></b></p>";
								echo"<div class='links'>";
								$array1 = array();
								//WHERE category='".$row['name']."'"
								$result1 = mysql_query("SELECT * FROM articles ORDER BY date DESC", $db);
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
										$this->PrintArticlesItem($r,$db);
										/*
										if(!empty($r['url']))$url_page=$r['url'];else $url_page=$r['id'];
										echo"<li><a href='/articles/".$url_page."/' title='" . $r['title'] . "'>" . $r['title'] . "</a></li>";*/
									}
								} while ($r = mysql_fetch_array($result1));

								echo"</div>";
							} else echo"<p>Неизвестная категория.</p>";
						}
            if($_GET['type']!="ajax_ls_only"){
                ?></div><?
            }
    }

    /*Выводит статью*/
    function showArticlesID(
	/*Массив полученный при sql запросе*/
	$myrow,
	/*Подключение к базе данных*/
	$db)
{
    /*StartIDArticlesShow*/
	setlocale(LC_ALL, 'ru_RU.UTF-8');
	$st_date= strftime('%d %h %Y %H:%M', strtotime($myrow['date']));
	$date_publisher=(date_format(date_create($myrow['date']), 'Y-m-d'))."T".(date_format(date_create($myrow['date']), 'H:i'));


        self::includeCoreSkeitOl(true);
        $cl= new \SkeitOl\Core();

	echo"
	<div itemscope='' itemtype='https://schema.org/Article'>
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
		<div class='news-data'>
			<meta itemprop='datePublished' content='<?=$date_publisher?>'/>
			<span itemprop='dateCreated' style='display:none'><?=$date_publisher?></span>
			<time datetime='<?=$date_publisher?>'></time><?=$st_date?>
			<div class='views-data'>Просмотров: <?=$myrow['views']?></div>

		</div>
		<div style='clear:both'></div>
		<?
	$row_count_comments= $cl->SQLQuery("SELECT COUNT(*) FROM comments_articles WHERE APPROVED='1' AND ID_ARTICLES=".$myrow['id']);
	?>
	<div itemprop="articleBody"><?=$myrow['text']?></div>
    <meta itemprop='interactionCount' content='UserComments:<?=$row_count_comments[0]?>'/>
    <br><div class='author-view'><span itemprop='author'><?=$myrow['author']?></span></div><br/>
	<?
	/* Category */
	if($myrow['category']){
        $arr_category=unserialize($myrow['category']);
        if (count($arr_category) > 0) {
            $row1=$cl->GetList("category",array("filter"=>array("id"=>$arr_category)));
            if($row1){
                ?>
                <div class='category-view'>
                <p style='border-left: 3px #57AA43 solid;padding-left: 10px;text-indent: 0px;'>
                <?
                foreach($row1 as $arCat){
                    ?>
                    <script>document.write("<a href='/articles/?category=<?=$arCat['id']?>' title='тег <?=$arCat['name'] ?>'><?=$arCat['name']?></a>");</script>
                    <?
                }
            }
/*
           if($_SERVER['REMOTE_ADDR']=="5.158.233.184"){
                \SkeitOl\SkeiOl::dump($arr_category);
                \SkeitOl\SkeiOl::dump($row1);
            }*/

            ?></p></div><?
        }
	}
	?></div><?
	/* Navigaciya */
	?>
	</div>
	<div class="text-center">
		<a target="_new" href="https://timeweb.com/ru/?i=45228&a=168"><img style="border:0px;" src="https://wm.timeweb.ru/images/posters/600x60/600x60.jpg"></a>
	</div>
	<div class="con-block box-shadow2">
		<div class='navig links'>
			<?
			$row=$cl->GetList("articles",array("order"=>array("id"=>"DESC"),"select"=>array("id","title","url"),"filter"=>array("<=id"=>(int)$myrow['id'],"active"=>1),"limit"=>array("top"=>'1','bottom'=>"1"),));

//			if($_SERVER['REMOTE_ADDR']=="5.158.233.184"){
//                \SkeitOl\SkeiOl::dump($row);
//            }
			echo"<div>";
			if ($row) {
			    $row=$row[0];
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo "<a href='/articles/".$url_page."/' name='" . strip_tags($row['title']) . "' title='" . strip_tags($row['title']) . "'>Предыдущая статья<abbr>".strip_tags($row['title'])."</abbr></a>";
			}
			echo"</div>";

			$row=$cl->GetList("articles",array("order"=>array("id"=>""),"select"=>array("id","title","url"),"filter"=>array(">=id"=>(int)$myrow['id'],"active"=>1),"limit"=>array("top"=>'1','bottom'=>"2"),));

			echo"<div>";

			if ($row) {
			    $row=$row[0];
				if(!empty($row['url']))$url_page=$row['url'];else $url_page=$row['id'];
				echo"<a href='/articles/".$url_page."/' name='" . strip_tags($row['title']) . "' title='" . strip_tags($row['title']) . "'>Следующая статья<abbr>".strip_tags($row['title'])."</abbr></a>";
			}?>
			</div>
		</div>
	</div>
	<?/* Social
	<div class="con-block box-shadow2">
		<h4 class='socl'>Понравилась статья? Поделись в социальных сетях:</h4>
		<div id='vk_like'></div>

		<script type='text/javascript'>
			window.onload=function() {
			VK.Widgets.Like('vk_like', {type: 'mini', verb: 1});};
		</script>
	</div>*/?>

	<div class="con-block box-shadow2">
		<?
		$ar_comments=$cl->GetList("comments_articles",array("order"=>array("id"=>"desc"),"filter"=>array("ID_ARTICLES"=>$myrow['id'],"APPROVED"=>'1'),"limit"=>array("top"=>'0','bottom'=>"10")));
		?>
		<h4 class='socl'>Комментарии: <span itemprop="interactionCount"><?=count($ar_comments)?></span></h4>
		<?
		if(count($ar_comments)==0){echo"<p>Коментарий пока нет, стань первым!</p>";}
		else{?>
		<div class="comments">
			<?
			//setlocale(LC_ALL, 'ru_RU.UTF-8');
			foreach($ar_comments as $key=>$row) {?>
				<div class="comment">
					<div class="comment_up" <?if($row['DEPTH_LEVEL']>1):?>style="margin-left:20px"<?endif;?> itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
						<div class="comment__avatar">
	                        <div>
	                            <img width="47" alt="комментарий <?=($row['NICK'])?>" src="<?
								if(empty($row['SRC_IMG'])) echo'/images/iron_ma.png';
								else echo$row['SRC_IMG'];
	                            ?>">
	                        </div>
	                    </div>
						<div class="comment_nik" itemprop="creator"><?=($row['NICK'])?></div>
						<div class="comment_date"><span style="display: none"itemprop="commentTime"><?
						$date_publisher=(date_format(date_create($row['DATE_TIME']), 'Y-m-d'))."T".(date_format(date_create($row['DATE_TIME']), 'H:i'));
						echo $date_publisher;?></span><?=(strftime('%d %h %Y %H:%M', strtotime($row['DATE_TIME'])))?></div>
						<div itemprop="commentText" class="comment_text  <?if(strlen($row['TEXT'])>700)echo"short_comment_text" ?>"><?
						if(strlen($row['TEXT'])>700)
						{?>
							<span class="show_all_text"><span class="show_all_text_desc">показать всё</span></span>

						<?}
						echo$row['TEXT'];?></div>
					</div>

				</div>
			<?}?>
		</div>
		<?}?>
		<div>
		<div class="comment_block">
			<h3 class="comment_block-title<?/*add_com_link*/?>" <?/*onclick="ShowHideElement('#block_add_com')">*/?>>Добавить комментарий</h3>
			<div id="block_add_com"<? /*style="display:none"*/?>>
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
					<div class="row">
						<div class="col-4 col-xs-1"><div class="row con-pg"></div></div>
						<div class="col-8 col-xs-1"><div class="row con-pg"><label for="checkbox-agree"><input id="checkbox-agree" type="checkbox" class="form__input" name="agree" value="Y" required="" aria-required="true">Я согласен с условиями <a target="_blank" class="link" href="/privacy.php">политики конфиденциальности</label></div></div>
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
	 </div>
    <?if($myrow['RECOMMENDATIONS'])
	 {
	    $RECOMMENDATIONS_ID_ARR= unserialize($myrow['RECOMMENDATIONS']);
	    if(is_array($RECOMMENDATIONS_ID_ARR)&&count($RECOMMENDATIONS_ID_ARR)>0){
	        $RECOMMENDATIONS=$cl->GetList("articles",array("select"=>array("id","title","date","url","category","views","src_preview"),"order"=>array("date"=>"desc"),"filter"=>array("id"=>$RECOMMENDATIONS_ID_ARR,"active"=>'1'),"limit"=>array("top"=>'0','bottom'=>"10")));
            if($RECOMMENDATIONS){
            ?>
            <div>
                <div class=""><h3>Читайте так же:</h3>
                <?

                foreach($RECOMMENDATIONS as $article){
                self::PrintArticlesItem($article,$db);
                }
                ?>
                </div>
            </div>
            <div class="clear"></div>
            <?
            }
	    }
	 }
	 /*EndStartIDArticlesShow*/
}

    /*Вывод записи*/
    public function PrintArticlesItem($myrow, $db)
    {
        if(empty($myrow))return"";
        $array1 = array();
	    $array1 = unserialize($myrow['category']);
        $category_string = '';
        if (count($array1) > 0) {
            $category_string = "<div class='tags'>";
            for ($i = 0; $i < count($array1); $i++) {
                $result1 = mysql_query("SELECT * FROM category WHERE id='$array1[$i]'", $db);
                $row1 = mysql_fetch_array($result1);
                $category_string .= '<span class="item">'.$row1['name'] . '</span>';
                //if($i<count($array1)-1)echo ", ";
            }
            $category_string .= "</div>";
        }
        if (!empty($myrow['url'])) $url_page = $myrow['url']; else $url_page = $myrow['id'];

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $st_date = strftime('%d %h %Y %H:%M', strtotime($myrow['date']));
        //date_format(date_create($myrow['date']), 'd-M-Y H:i')
        ?>
        <div class='news-item'  itemscope itemtype='http://schema.org/Article'>
            <div class="left_con">
                <? $photo_img = strip_tags($myrow['src_preview']);
                if (empty($photo_img)) $photo_img = "/images/favicon/apple-touch-icon-114x114.png"; ?>
                <?/*<span class="photo_img" style="background-image: url('<?=$photo_img?>')"></span>*/
                ?><a class='news-item-link' href='/articles/<?= $url_page ?>/'>
                <span class="photo_img lazy_load"
                      style="background-image: url('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7')"
                      data-src="<?= $photo_img ?>"></span>
                 </a>
            </div>
            <div class="right_con">
                <div class='news-title' itemprop='name'><a class='news-item-link' href='/articles/<?= $url_page ?>/'><?= $myrow['title'] ?></a>
                </div>
                <div class='news-main'>
                    <div class='news-text' itemprop='description'><?= $myrow['description'] ?></div>
                    <div class='clear'></div>
                </div>
                <?=$category_string?>
                <div class='news-data'><?= $st_date ?>
                        <div class='view_block'><?= $myrow['views'] ?></div>
                    </div>
            </div>
        </div>
        <?
    }
}
