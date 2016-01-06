<?php header('Content-Type: text/html; charset= utf-8');
 if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
 if(isset($_GET['id'])){$id=$_GET['id'];}if($id=='') unset($id);
 include("blocks/bd.php");
 include("blocks/func/func.php"); ?>
<!DOCTYPE html>
<html>
	<?
	$sys_description="Новости и информационные ресурсы SkeitOl";
	$sys_keywords="News SkeitOl, Новости, Новости SkeitOl, Новости SkeitOl Soft, skeitol";
	$sys_pages="news";
	$sys_pages_print="Новости";
	if (isset($id)) {
		$result = mysql_query("SELECT * FROM news WHERE id=$id", $db);
		$myrow = mysql_fetch_array($result);
		if ($myrow['id'] == '') {
			unset($id);
			$sys_title="Новости";
		} else{
			$sys_title= strip_tags($myrow['title']);
			if(!empty($myrow['meta_keywords']))$sys_keywords=$myrow['meta_keywords'];
			if(!empty($myrow['meta_description']))$sys_description=$myrow['meta_description'];
		}
	}
	else $sys_title="Новости";
	
	$sys_special_head_text='<!-- Plagin view image -->
        <script src="/js/jquery-1.7.2.min.js"></script>
        <script src="/js/lightbox.js"></script>
        <link href="/style/lightbox.css" rel="stylesheet" />
        <!-- END Plagin view image -->
        <!-- Social-->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
        <script type="text/javascript">
            VK.init({apiId: 3743505, onlyWidgets: true});
        </script>
        <!-- -->';
	include_once("blocks/head.php");?>
<body>
	<div class="wrapper-container">
		<div id="content_r_long">
    <?php include("blocks/header.php");?>
	<?//include_once("blocks/breadcrumb.php");?>
	<div id='content'>
        <div class='left-con'>
			
			<div class='con-block box-shadow2'>
			<?php 
			if(!isset($id))//Выводит список news
			{
				echo"<h1 class='title_block'>".$sys_pages_print."</h1>";
				$step=10;
				$startI=0;
				$endI=$step-1;
				if(isset($list))
				{
					if($list<=0)
					{echo"Нет такой страницы!!!<br>Вывод первой страницы";}
					else
					{
						$startI=($list-1)*$step;
						$endI=$startI+$step;
					}
				}
				$result = mysql_query("SELECT * FROM news WHERE active=1 ORDER BY id DESC LIMIT $startI,$endI",$db);	  
				$myrow=mysql_fetch_array($result);
				$i=0;
				?>
					<style>
					.left-con,.con-block,.container,.row{overflow: hidden;}
					.col-sm-4 {width: 46%;margin: 1%;}.end-row{margin: 1em;overflow: hidden;}.container{padding:0;}
					@media only screen and (max-width : 540px) {.col-sm-4 {width: 96%;}.end-row{margin:0}}
					</style>
					<section class="services">
					<div class="container">
					<div class="row">
					<?
				do
				{/*
					if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
					printf("
                                            <a class='news-item-link' href='/news/%s/'>
						<div class='news-item'>
						<div class='news-title'>%s</div>
						<div class='news-data'>
							%s
						</div>
						<div class='news-main'>
							<div class='news-text'>
								%s
							</div>
							<div class='clear'></div>
						</div>              
					</div></a>",$url_page,$myrow['title'],date_format(date_create($myrow['date']),'d-M-Y H:i'),$myrow['description']);
					*/
					
					if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
								echo'
								<div class="col-sm-4 links-news wow slideInUp">
									<div class="preview_block">
										<a href="/news/'.$myrow['id'].'/">											
											<span class="photo_img" style="background-image: url('.strip_tags($myrow['src_preview']).')"></span>
											<span class="title">'.strip_tags($myrow['title']).'</span>
										</a>
									</div>
									
									<div class="news-data"><span itemprop="dateCreated" style="display:none">'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'</span><time datetime="'.(date_format(date_create($myrow['date']), 'Y-m-d')).'T'.(date_format(date_create($myrow['date']), 'H:i')).'"></time>'.(date_format(date_create($myrow['date']), 'd-m-Y H:i')).'</div>
									<p>'.strip_tags($myrow['description']).'</p>
								</div>
								';
					if(($i%2)==1)
						echo'<div class="clear end-row" style=""></div>';
					$i++;
				}
				while($i<=$step && $myrow=mysql_fetch_array($result));
				?>
				</div>
				<div class="clear"></div>
				</div>
				</section>
				<?
				//
				$result = mysql_query("SELECT COUNT(*) as count FROM news",$db);	  
				$row=mysql_fetch_array($result);
				if($row['count']>$step)//"Записей больше".$step;
				{
					$i=1;
					echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;
				overflow: auto;'>";
						echo"<span class='navigation'>";
							if($list==1)echo"<span class='no-link'><</span>";
							else echo"<a href=/news/?list=".($list-1)."><</a>";
							$n=(int)($row['count']/$step);
							if($row['count']%$step>0)$n++;
							for($i=1;$i<=$n;$i++)
								if($i!=$list)
									echo"<a href=/news/?list=".($i).">".($i)."</a>";
								else
									echo"<span class='no-link'>".($i)."</span>";
							if($list==$n)echo"<span class='no-link'>></span>";
							else echo"<a href=/news/?list=".($list+1).">></a>";
						echo"</span>";				
					echo"</div>";
				}		
			}
			else //Выводит данные
			{
				echo"
				<div itemscope='' itemtype='http://schema.org/NewsArticle'>
				<div class='title-con-block' itemprop='name'>".$myrow['title']."</div>
				<div class='news-data'><span itemprop='dateCreated' style='display:none'>".(date_format(date_create($myrow['date']), 'Y-m-d'))."T".(date_format(date_create($myrow['date']), 'H:i'))."</span>".date_format(date_create($myrow['date']),'d-M-Y H:i')."</div>";
				//echo"<div style='margin: 15px;'>";
				echo '<div itemprop="articleBody">'.$myrow['text']."</div>";
				echo"<br/>";
				/*Author*/
				echo"<style>
				.author-view{
				height: 100%;
				float: left;
				border-left: 3px #EE8B0C solid;
				display: inline-block;  margin: 0 10px 2px 0;  line-height: 22px;  padding: 0 10px;  color: #333333;  
				 text-decoration: none;
				}
				</style>";
				echo"<br><div class='author-view'>".$myrow['url']."</div><br/>";
				/*Navigaciya*/
				echo "
				<style>
				.navig{
				width:100%;
				text-align:center;border-left: 3px solid #1552D3;height: 100%;
float: left;}.navig div{width: 49%;
float: left;}
				.navig a{
				margin: 0 10px 0 10px;
				}
				</style>
				<div class='navig links'>";				
				$result = mysql_query("SELECT id,title FROM news WHERE id < ".$myrow['id']." ORDER BY id DESC LIMIT 1;",$db);
				$row=mysql_fetch_array($result);
				echo"<div>";
				if($row['id']!=""){
					echo "<a href='/news/".$row['id']."/' name='".strip_tags($row['title'])."' title='".strip_tags($row['title'])."'>Предыдущая новость</a>";
				}
				echo"</div>";
				$result = mysql_query("SELECT id,title FROM news WHERE id > ".$myrow['id']." ORDER BY id LIMIT 1;",$db);
				$row=mysql_fetch_array($result);
				echo"<div>";
				if($row['id']!=""){
					echo"<a href='/news/".$row['id']."/' name='".strip_tags($row['title'])."' title='".strip_tags($row['title'])."'>Следующая новость</a>";
				}
				echo"</div>";
				
				echo"</div><br/>";
				/*Social*/
				echo"
				<p>
<div id='vk_like'></div>
</p>
<script type='text/javascript'>
VK.Widgets.Like('vk_like', {type: 'mini', verb: 1});
</script>


<!-- Put this div tag to the place, where the Comments block will be -->
<div id='vk_comments'></div>
<script type='text/javascript'>
VK.Widgets.Comments('vk_comments', {limit: 10, width: '*', attach: '*'});
</script>
				
				</div>";
				
			}?> 
			
        </div>
		</div>
		<div class='right-con'>
			<?php include("blocks/rightblock.php");?>		
		</div>
	</div>
	</div>
		</div>
    <?php //include("blocks/footer.php"); ?>
	<? $long_footer=true; include_once("blocks/footer_new.php");?>
</body>
</html>