<?php header('Content-Type: text/html; charset= utf-8');?>
 <?php if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
}if ($id == '')unset($id);
 include("blocks/bd.php");
 include("blocks/func/func.php"); ?>
<!DOCTYPE>
<html>
	<?php
	$sys_description="Программы и информационные ресурсы SkeitOl";
	$sys_keywords="Программы SkeitOl, Программы, Программы SkeitOl,Программы SkeitOl Soft";
	$sys_pages="programm";
	$sys_pages_print="Программы";
	if (isset($id)) {
		$result = mysql_query("SELECT * FROM programm WHERE id=$id", $db);
		$myrow = mysql_fetch_array($result);
		if ($myrow['id'] == '') {
			unset($id);
			$sys_title="Программы";
		} else{
			$sys_title= strip_tags($myrow['title']);
			if(!empty($myrow['meta_keywords']))$sys_keywords=$myrow['meta_keywords'];
			if(!empty($myrow['meta_description']))$sys_description=$myrow['meta_description'];
		}
	}
	else $sys_title="Программы";
	
	$sys_special_head_text='
		<link href="/css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
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
        <!-- -->
		<style>
			html, body {
			height: 100%;
			}
			#footer {
position: relative;
    margin-top: -200px; /* отрицательное значение высоты футера */
    height: 200px;
    clear:both;
}
		</style>
		';
	include_once("blocks/head.php");
		 ?>
<body>
<div class="wrapper-container">
	<div id="content_r_long">
	<?php include("blocks/header.php");?>
	
	<?//include_once("blocks/breadcrumb.php");?>
	
	<section class="services">
		<div class="container">
        <?php 
		if(!isset($id))//Выводит список программ
		{?>
			
			<div class="col-lg-12 text-center">
				<h1><?=$sys_pages_print?></h1>
			</div>
			<div class="row ">
		<?
        	echo"<style>
				.block-links-items {
					overflow: hidden;
					text-align: center;
					padding: 2em 0;
					display: block;
					position: relative;
				}
.block-links-items .block-items {
	  width: 100%;
  max-width: 70px;
  font: 1em 'open', 'sans-serif', 'Tahoma';
  display: inline-block;
  overflow: hidden;
  overflow-x: auto;
  text-align: center;
  margin: 0.5em;
  padding: 1em;
}
				.block-links-items .block-items a {
							text-decoration: none;
							color: #369;
							display: block;
						}

					.block-links-items .block-items a:hover {
						text-decoration: underline;
						color: #323232;
					}
			  </style>
				<div class='block-links-items'>";
					$result = mysql_query("SELECT id,title FROM programm",$db);	  
					$myrow=mysql_fetch_array($result);	  
					$i=0;
					do
					{
					 echo"<div class='block-items'>
						<div>
						<a href='/program/".mb_strtolower($myrow['title'])."/'><img src='/images/anim/".strtolower($myrow['title']).".gif' alt='".$myrow['title']."'
						class='imgsize' /><p>".$myrow['title']."</p></a>
						</div>
						</div>"; 
					}
					while($myrow=mysql_fetch_array($result));
				echo"</div>
				</div>
			";
       	}
        else //Выводит данные программы
		{
			echo"<div style='padding: 10px;'>";
			echo"".$myrow['text'];
			echo"
				<p>
					<div id='vk_like'></div>
					</p>
					<script type='text/javascript'>
					VK.Widgets.Like('vk_like', {type: 'mini', verb: 1});
					</script>";
			
			echo" </div>";
		}?> 
		</div>
	</section>
	</div>
</div>	
	<?php //include("blocks/footer_index.php"); ?>
	<?php $long_footer=true; include("blocks/footer_new.php"); ?>
</body>
</html>