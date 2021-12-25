<?php header('Content-Type: text/html; charset= utf-8');
 if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
 if(isset($_GET['id'])){$id=$_GET['id'];}if($id=='') unset($id);
 include("blocks/bd.php");
 include("blocks/func/func.php"); ?>
<!DOCTYPE html>
<html>
    <head>
       <title>
 		<?php
         if(isset($id)){
			$result = mysql_query("SELECT id,title,text,date FROM serials WHERE id=$id",$db);
            $myrow=mysql_fetch_array($result);
			if($myrow['id']==''){unset($id);echo"Сериалы";}
			else echo strip_tags($myrow['title']);}
		else echo"Сериалы";?>
         </title>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <link rel="SHORTCUT ICON" href="images/S.ico">
		<meta charset="utf-8">
		<!--[if lt IE 9]>
		<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        <!-- Plagin view image -->
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/lightbox.js"></script>
		<link href="style/lightbox.css" rel="stylesheet" />
		<!-- END Plagin view image -->
	</head>
<body>
    <?php include("blocks/header.php");?>
	<div id='content'>
        <div class='left-con'>
			<div class="div-hierarchy box-shadow2 links"><a href="index.php" title="Главная">Главная</a> → <a href="news.php" title="Новости">Сериалы</a></div>
			<div class='con-block box-shadow2'>
			<?php
			if(!isset($id))//Выводит список news
			{
				echo"<center><div class='title-small-block'>Сериалы</div> </center>";
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
				$result = mysql_query("SELECT id,title,description,date FROM serials ORDER
				BY id DESC LIMIT $startI,$endI",$db);
				$myrow=mysql_fetch_array($result);
				$i=1;
				do
				{
					printf("<a class='news-item-link' href='serials.php?id=%s'>
						<div class='news-item'>
						<div class='news-title'>%s</div>
						<div class='news-data'>%s</div>
						<div class='news-main'>
							<div class='news-text'>%s</div>
                                                <div class='clear'></div>
						</div>
					</div></a>",$myrow['id'],$myrow['title'],$myrow['date'],$myrow['description']);
					$i++;
				}
				while($i<=$step && $myrow=mysql_fetch_array($result));
				//
				$result = mysql_query("SELECT COUNT(*) as count FROM serials",$db);
				$row=mysql_fetch_array($result);
				if($row['count']>$step)//"Записей больше".$step;
				{
					$i=1;
					echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;
				overflow: auto;'>";
						echo"<span class='navigation'>";
							if($list==1)echo"<span class='no-link'><</span>";
							else echo"<a href=serials.php?list=".($list-1)."><</a>";
							$n=(int)($row['count']/$step);
							if($row['count']%$step>0)$n++;
							for($i=1;$i<=$n;$i++)
								if($i!=$list)
									echo"<a href=serials.php?list=".($i).">".($i)."</a>";
								else
									echo"<span class='no-link'>".($i)."</span>";
							if($list==$n)echo"<span class='no-link'>></span>";
							else echo"<a href=serials.php?list=".($list+1).">></a>";
						echo"</span>";
					echo"</div>";
				}
			}
			else //Выводит данные
			{
				echo"<div class='title-con-block'>".$myrow['title']."</div>
				<div class='news-data'>".$myrow['date']."</div>";
				//echo"<div style='margin: 15px;'>";
				echo"".$myrow['text'];
				//echo" </div>";
			}?>
        </div>
        </div>
		<div class='right-con'>
			<?php include("blocks/rightblock.php");?>
		</div>
	</div>
    <?php include("blocks/footer.php"); ?>
</body>
</html>