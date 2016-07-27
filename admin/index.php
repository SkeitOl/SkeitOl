<?
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/
//header('Content-Type: text/html; charset= utf-8');
/*ini_set("display_errors",1);
error_reporting(E_ALL);*/
	include_once($_SERVER['DOCUMENT_ROOT']."/admin/blocks/bd.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/admin/lock.php");

	/*Классы для работы*/
	include_once($_SERVER['DOCUMENT_ROOT']."/admin/skeitol/core/ClassAdmin.php");

    if( isset($_POST['act'])){$act=$_POST['act'];if($act=='')unset($act);}
    if(!isset($act)){if( isset($_GET['act'])){$act=$_GET['act'];if($act=='')unset($act);}}
	if( isset($_POST['tp'])){$tp=$_POST['tp'];if($tp=='')unset($tp);}
    if(!isset($tp)){if( isset($_GET['tp'])){$tp=$_GET['tp'];if($tp=='')unset($tp);}}
	//session_start();
	if(isset($_SESSION['step'])&&(!empty($_SESSION['step'])))
		$step=$_SESSION['step'];
	else $step=10;
	if(isset($_GET['step'])){$step=$_GET['step'];$_SESSION['step']=$step;}

	$admin_class=new ClassAdmin($tp,$db);

//Глобальные настройки
$DEFAULT_AUTHOR="SkeitOl";
?><!DOCTYPE>
<html>
	<?php 
	$sys_description="Панель администратора CMS SkeitOl-Soft";
	$sys_keywords="Панель администратора SkeitOl, SkeitOl - Soft, SkeitOl,CMS SkeitOl Soft";
	$sys_pages="admin";
	$sys_pages_print="Панель администратора";
	$sys_title="Панель администрирования CMS SkeitOl-Soft";
	$sys_special_head_text=@'
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="Stylesheet" type="text/css" href="cal.css?01" />
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js?01"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css?01" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css?01">
	 <!-- End Chose-->
	 <script src="script/cal.js?01"></script>
	<link rel="stylesheet" type="text/css" href="/admin/css/style.css?01" />
	<script src="/admin/js/core.js?01"></script>
	';
	include('blocks/head.php'); 
?><body>
<div style="width:100%;min-height:100%;margin:0;padding:0">
	<!-- LEFT block -->
    <?php include('blocks/header.php'); ?>
    <!-- END LEFT block-->
    <!-- LEFT block -->
    <?php include('blocks/lefttd.php'); ?>
    <!-- END LEFT block-->
	<!-- Message-->
	<div class="toast-container toast-position-top-right"></div>
	<script src="https://js-hotkeys.googlecode.com/files/jquery.hotkeys-0.7.9.min.js"></script>
	<script type="text/javascript">
function Msg(m){
		switch(m)
		{case"1":showSuccessToast();
			<?php
				if($act=='add')
				{			
					echo"
					if(!document.getElementById('check_link').checked)
					{";				
					$sql    = "SHOW TABLE STATUS LIKE '$tp'";
					$result = mysql_query($sql);
					$array  = mysql_fetch_array($result);
					$ai = $array['Auto_increment'];
					echo"s='index.php?act=update&tp=".$tp."&id=".$ai."';";
					echo"document.location.href=s;
					}";
				}?>
				break;
			case"-1":showErrorToast();break;
			case"0":showWarningToast();break;
			default:showErrorToast(); 
			break;
		}
}
	</script>	
	<script type="text/javascript">
		function Goy(d1){
			var b=<?=$step?>;
			switch(d1.selectedIndex){
			case 0: b=10; break;
			case 1: b=20; break;
			case 2: b=50; break;
			case 3: b=100; break;
			}
			s=<? echo"'index.php?act=".$act."&tp=".$tp."&step='";?>;
			s+=b;
			document.location.href =s;
		}	
	</script> 
    <!-- Content-->
    <div id="content">
	<?
	//Вывод  краткого списка записей на главной странице
	function PrintShortLinks($num,$db)
	{
		$result = mysql_query("SELECT * FROM $num ORDER BY id DESC LIMIT 0,5",$db);	  
		if($result)
		{
			?><table class="small-table links">
				<thead>
					<tr>
						<th class='align-center' width="10%">ID</th>
						<th>Заголовок</th>
						<th class='align-center' width="10%">Активна</th>
					</tr>
				</thead>
				<tbody>
				<?
				$myrow=mysql_fetch_array($result);								
				do
				{	
					echo"<tr>
							<td class='align-center'>".$myrow['id']."</td>
							<td class='align-left'><a href='index.php?act=update&tp=".$num."&id=".$myrow['id']."'>".strip_tags($myrow['title'])."</a></td>
							<td class='align-center'><input type='checkbox' disabled='disabled'";
							echo(($myrow[active])?"checked":"");echo"></td>
						</tr>
						";
				}
				while($myrow=mysql_fetch_array($result));
				?>
				</tbody>
			</table>
			<?
		}
	}
	 if(!(isset($act)&& isset($tp))){
	 ?>
		<h2>Добро пожаловать в панель администрирования.</h2>
		<div class="box">
			<p>Инструменты:</p>
			<ul class="list_ul">
				<li><a class="link" target="_blank" href="/admin/2.php" title="Загрузка файлов">Загрузка файлов</a></li>
				<li><a class="link" target="_blank" href="/admin/create_sitemap_xml.php" title="Генерация sitemap.xml">Генерация <span style="color:#000;">sitemap.xml</span></a></li>
				<li><a  class="link" href="category.php">Категории[Статьи]</a></li>
				<li><a class="link" href="/admin/sxd/">Sypex Dumper 2.0.11</a></li>
			</ul>
		</div>
		<ul class="bloks-small">
			<li>
				<h2><a href="index.php?act=update&tp=articles" title="Статьи">Статьи</a></h2>
				<?PrintShortLinks("articles",$db);?>
			</li>
			<li>
				<h2><a href="index.php?act=update&tp=news" title="Новости">Новости</a></h2>
				<?PrintShortLinks("news",$db);?>
			</li>
			<div style="clear:both"></div>
			<li>
				<h2><a href="index.php?act=update&tp=pages" title="Страницы">Страницы</a></h2>
				<?PrintShortLinks("pages",$db);?>
			</li>
			<li>
				<h2><a href="index.php?act=update&tp=program" title="Программы">Программы</a></h2>
				<?PrintShortLinks("programm",$db);?>
			</li>
		</ul>
		<div class="clear"></div>
		<div>
			<?
			$comments_articles=array();
			$result = mysql_query("SELECT * FROM comments_articles WHERE APPROVED<>1 ORDER BY ID DESC LIMIT 0,5",$db);
			$myrow=mysql_fetch_array($result);
			do{
				if($myrow)
					$comments_articles[]=$myrow;
			}
			while($myrow=mysql_fetch_array($result));
			$count_comments_articles=count($comments_articles);?>
			<h2>Новые <a href="/admin/comments.php" class="link">комментарии</a><span class="count"><?=$count_comments_articles?></span></h2>
			<?if($count_comments_articles>0):?>
				<table class="small-table links">
					<thead>
						<tr>
							<th>Имя</th>
							<th>Текст</th>
							<th>Дата</th>
							<th>Одобрен</th>
						</tr>
					</thead>
					<?foreach($comments_articles as $key=>$myrow)
					{
						echo"<tr>
								<td class='align-center'>".$myrow['NICK']."</td>
								<td class='align-center'><a href='/admin/comments.php?ID=".$myrow['ID']."'>".htmlspecialchars(substr($myrow['TEXT'],0,30))."</a></td>
								<td class='align-center'>".$myrow['DATE_TIME']."</td>
								<td class='align-center'><input type='checkbox' disabled='disabled'";
								echo(($myrow['APPROVED'])?"checked":"");echo"></td>
							</tr>";
					}?>
				</table>
		 	<?endif;?>
		</div>
		<?
    }
    else
    {
		$dat=date("d-m-Y");
		echo"<div class='form'>";
		if(!isset($_GET['id'])){
			echo"
			<p style='float: right;position: relative;right: 0;'>Элементов на странице:
			<select  name='ComboBox1' id='ComboBox1' style='width:60px' onchange='Goy(this);'>
			<option value='10'";if($step==10)echo"selected";echo">10</option>
			<option value='20'"; if($step==20)echo"selected";echo">20</option>
			<option value='50'"; if($step==50)echo"selected";echo">50</option>
			<option value='100'"; if($step==100)echo"selected";echo">100</option>
			</select></p>";
		}
		switch($tp)
		{
			case 'news':
			case 'articles':
			case 'serials':
			case 'pages':
				switch($tp){
					case 'news':
						$GLOBAL_SETTINGS= array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Новость",//Элемент
							"ELEMENTS"=>"Новости",//Элементы
							"LIST_ELEMENTS"=>"Новостей",//Список
							"ADD_ELEMENT"=>"Новость",//Добавить
							"DEL_ELEMENT"=>"Новость",//Удалить
						 ),
						);
					break;
					case 'articles':
						$GLOBAL_SETTINGS=array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Стаья",//Элемент
							"ELEMENTS"=>"Статьи",//Элементы
							"LIST_ELEMENTS"=>"Статей",//Список
							"ADD_ELEMENT"=>"Статью",//Добавить
							"DEL_ELEMENT"=>"Статью",//Удалить
						 ),
						);break;
					case 'pages':
						$GLOBAL_SETTINGS=array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Страница",//Элемент
							"ELEMENTS"=>"Страницы",//Элементы
							"LIST_ELEMENTS"=>"страниц",//Список
							"ADD_ELEMENT"=>"страницу",//Добавить
							"DEL_ELEMENT"=>"страницу",//Удалить
						 ),
						);break;
				}
				?>
				<?/*Выводим breab*/?>
				<div class="div-hierarchy links">
					<a href="/admin/" title="Главная">Главная</a> &gt; <a href="/admin/index.php?act=update&tp=<?=$tp?>"><?=($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ELEMENTS"])?></a>
				</div>
				<?
				switch($act)
				{
					case 'add':
						$sql    = "SHOW TABLE STATUS LIKE '".$tp."'";
						$result = mysql_query($sql);
						$array  = mysql_fetch_array($result);
						$ai = $array['Auto_increment'];
						echo"<h3>Добавление новой записи №".$ai.":</h3><br>";
						
               			$admin_class->PrintFormAddOrEdit($myrow,$id,$tp,$act);
               			?>
               			<div style='clear:both;'></div>
						<button id='sub' class='save_bth'>Добавить</button>
						<label><input type='checkbox' id='check_link'/>Не уходить со страницы</label>
						<div style='clear:both;'></div>
               			<?


               			/*
						echo"<form id='myForm' action='add_tp.php' method='post'>";?>
						<ul class="tabs">
							<li><a href="#tab1">Основные</a></li>
							<li><a href="#tab2">SEO</a></li>
							<li><a href="#tab3">Медиа</a></li>
						</ul>
						<div class="tab_container">
						<div id="tab1" class="tab_content">
						<?
						if($tp=='articles'){
								$result = mysql_query("SELECT * FROM category",$db);	  
								$myrow=mysql_fetch_array($result);								
								echo"<div class='side-by-side clearfix'>
								<div>          
								  <em>Категории</em>
								  <select data-placeholder='Выбор категории' class='chosen-select' multiple style='width:350px;' tabindex='1' name=category_m[]>
									<option value=''></option>";															
								do
								{	
									$f='';
									echo"<option value=".$myrow['id']." ".$f.">".$myrow['name']."</option>";									
								}
								while($myrow=mysql_fetch_array($result));								
								echo"
									  </select>
									</div>
								  </div>";
                        }
								  
								  
								$active_p_bool="";
								$active_p='';
								if(isset($myrow[active]))
								{
									$active_p_bool='<input name="active_p_bool" type="hidden" value="1"/>';
									if(($myrow[active]))
										$active_p='checked';
									else $active_p='';
								}
/*
								print <<<ADD
								
									<p><b>Заголовок:</b><textarea  name="title" rows="2"></textarea></p>
									<p><b>Дата:</b><input name="date" id="calendar" type="text" value="$dat" /></p>
									<p><b>Отоброжать:</b><input name="active_p" type="checkbox" $active_p value='1' /></p>
									$active_p_bool
									<p><b>Краткое описание с тегами:</b><br/><textarea name="description" id="description" rows="3"></textarea></p>
									<p><b>Полное описание с тэгами:</b><br/>
										<div class="edit-button">
											<button onclick='add_html_box("b")'>&lt;b>&lt;/b></button>
											<button onclick='add_html_box("img")'>&lt;img/></button>
											<button onclick='add_html_box("p")'>&lt;p>&lt;/p></button>
											<button onclick='add_html_box("h1")'>&lt;h1>&lt;/h1></button>
											<button onclick='add_html_box("h2")'>&lt;h2>&lt;/h2></button>
											<button onclick='add_html_box("h3")'>&lt;h3>&lt;/h3></button>
											<button onclick='add_html_box("a")'>&lt;a/></button>
											<button onclick='add_html_box("a-out")'>&lt;a out/></button>
										</div>
										<textarea name="text" rows="8" id="text-box"></textarea></p>
									<p><b>Автор:</b><input type="text" name="author" value="$DEFAULT_AUTHOR"/></p>
									<input value="$id" type="hidden" name="id"/>
									<input name="tp" type="text" style="display:none;" value="$tp">
									<input name="activ" type="text" style="display:none;" value="$act">
								</div>
									<div id="tab2" class="tab_content">
										<p><b>meta_keywords:</b><br><input type="text" class="text-input" name="meta_keywords" value="$myrow[meta_keywords]"/></p>
										<p><b>meta_description:</b><br><input type="text" class="text-input" name="meta_description" value="$myrow[meta_description]"/></p>
									</div>
									<div id="tab3" class="tab_content">
									</div>
								</div>
							</form> 									
							<button id='sub' class='save_bth'>Добавить</button>
<label><input type='checkbox' id='check_link'/>Не уходить со страницы</label>									
ADD;
*/

                        break;
					case 'del':
						echo"<h3><span id='result'>Удаление записи:</span></h3>
						<form id='myForm' action='add_tp.php' method='post'>";						
						include("upload_del.php");
						echo"</form>
							<input id='activ' name='activ' type='text' style='display:none;' value='".$act."'>
							<input id='tp' name='tp' type='text' style='display:none;' value='".$tp."'>
							<button id='sub2'>Удалить</button>";						
                        break;
					case 'update':
						?><div class="quick_blok">
							<p>Быстрые действия:</p>
							<ul style="height: 30px;line-height: 30px;">
								<li class="icon list"><a href="index.php?act=update&tp=<?=$tp?>" title="Список <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["LIST_ELEMENTS"])?>"><i class="fa fa-lg fa-list"></i></a></li>
								<li class="icon add"><a href="index.php?act=add&tp=<?=$tp?>" title="Добавить <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ADD_ELEMENT"])?>"><i class="fa fa-lg fa-plus-square"></i></a></li>
								<li>
									<form class="small_search" action="search.php" method="post" id="form_small_search">
										<span class="toolbar__search">
											<span>
												<input id="search_in_bd" type="text" name="search_in_bd" class="search__input"placeholder="Что ищем?"/>
											</span>
										</span>
										<span class="search__button">
											<button>Поиск</button>
										</span>
										<input type="hidden" name="tp" value="<?=$tp?>"/>
									</form>									
								</li>
							</ul>
						</div>
						<div class="clear"></div>
						<?
						include_once("blocks/bd.php");	
						if(isset($_GET['id'])) {$id=$_GET['id']; if($id==''){unset($id);}}
						if(!isset($id))
						{
							?><h3><span id='result'>Список записей:</span></h3><?
							/*навигация*/
							//if(isset($_GET['step']))$step=$_GET['step'];else $step=10;

							//if(isset($_POST['list']))$list=$_POST['list'];else 
							if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
							$result = mysql_query("SELECT COUNT(*) as count FROM ".$tp." ",$db);	  
							$row=mysql_fetch_array($result);

							if($row['count']>$step)
							{	
								$i=1;
								echo"<p id='ComboBox1'>Страница <b>№$list</b></p>";
								echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;overflow: auto;'>";		
								echo"<span class='navigation'>";			
								if($list==1)echo"<span class='no-link'><</span>";			
								else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list-1)."><</a>";			
								$n=(int)($row['count']/$step);			
								if($row['count']%$step>0)$n++;			
								for($i=1;$i<=$n;$i++)				
									if($i!=$list)					
										echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($i).">".($i)."</a>";				
									else					
										echo"<span class='no-link'>".($i)."</span>";			
								if($list==$n)echo"<span class='no-link'>></span>";			
								else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list+1).">></a>";		
								echo"</span>";					
								echo"</div>";
							}

							/**/
							/*Список по $step*/
							
							$startI=0;$endI=$step-1;
							if(isset($list)){	
								if($list<=0){
								echo"Нет такой страницы!!!<br>Вывод первой страницы";}	
								else{
								$startI=($list-1)*$step;
								$endI=$startI+$step;}
							}
							include_once("blocks/bd.php");
							$result = mysql_query("SELECT id,title,date FROM $tp ORDER BY id DESC LIMIT $startI,$endI",$db);	 
							if (!$result) {
								$message  = 'Неверный запрос: ' . mysql_error() . "\n";
								$message .= 'Запрос целиком: ' . $query;
								die($message);
							}
							$myrow=mysql_fetch_array($result);
							$i=1;
							?>
							<form action="add_tp.php" method="post">
								<input type="hidden" name="tp" value="<?=$tp?>"/>
								<table class='table'>
									<thead>
										<tr>
											<th width="10%"></td>
											<th width="15%"><b>ID</b></td>
											<th width='15%'><b>Дата</b></td>
											<th width="60%"><b>Заголовок</b></td>
										</tr>
									</thead>
									<tbody>
										<?do{
										echo"<tr>
												<td><input type='checkbox' name='items[]' value='".$myrow['id']."'></td>
												<td>".$myrow['id']."</td>
												<td>".date_format(date_create($myrow['date']),'d-M-Y H:i')."</td>
												<td class='table-left-text links'><a href='index.php?act=update&tp=$tp&id=".$myrow['id']."'>".strip_tags($myrow['title'])."</a></td>
											</tr>";
											$i++;
										}
										while($i<=$step && $myrow= mysql_fetch_array($result));
										?>
									</tbody>
								</table>
								<p>
									<input type="submit" name="edit_items" class="save_bth" value="Редактировать"/>
									<input type="submit" name="delet_items" value="Удалить" onclick="if(confirm('Удалить безвозвратно?')) return true; else return false;"/>
								</p>
							</form>
							
							<?
						}
						else
						{
                            $result=mysql_query("SELECT * FROM $tp WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
							?>
							<?
							if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
							echo"<p><a href='../$tp/".$url_page."/' target='_blank'>".($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ELEMENT"])."</a> № ".$myrow['id']."</p><br>";

                            $admin_class->PrintFormAddOrEdit($myrow,$id,$tp,$act);

                        ?>

				            <?
						}
						break;
                    default: 
                        echo "Неизвестный запрос. =(";
						break;
				}
                break;
				/////////////////////////
            case 'programm':
            case 'program':
				switch($act)
				{
					case 'add':
                        print <<<ADD
							<p><span id='result'>Добавление новой записи:</span></p> 
								<form id="myForm" action="program_add.php" method="post">
									<p><b>Заголовок:</b>
									<textarea  name="title" cols="60" rows="2"></textarea></p>	
									<p><b>Дата:</b><input name="date" id="calendar" type="text" value="$dat" /></p>
									<p><b>Краткое описание с тегами:</b><br/><textarea name="description" id="description" cols="60" rows="5"></textarea></p>
									<p><b>Полное описание с тэгами:</b><br/><textarea name="text" cols="60" rows="15"></textarea></p>
									<p><b>Автор:</b><input type="text" name="author" /></p>
								</form> 
								<button id='sub'>Добавить</button>
								<script type="text/javascript">
									
									 $("#sub").click(function () {
									$("#result").html("Сохранение данных...");
									$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { $("#result").html(info); });
									clearInput();
								});
								$("#myForm").submit(function () {
									return false;
								});
								function clearInput() {
									//$("#myForm :input").each(function () {
									  //  $(this).val('');
									//});
								}
									</script>		  
ADD;
                        break;
					case 'del':
						echo"<p><span id='result'>Удаление записи:</span></p> 
						<form action='program_del.php' method='post'>";
						include("blocks/bd.php");
						$result=mysql_query("SELECT title,id FROM programm");
						$myrow= mysql_fetch_array($result);
						do{
							printf("<p><input name='id' type='radio' value='%s'><label>%s</label></input></p>",$myrow['id'],$myrow['title']); 	   
						}
						while($myrow= mysql_fetch_array($result));						
						echo"<p> <input name='submit' type='submit' value='Удалить урок' /></p>";						
                        break;
					case 'update':
						include("blocks/bd.php");	
						if(isset($_GET['id'])) {$id=$_GET['id']; if($id==''){unset($id);}}
						if(!isset($id))
						{
							$result=mysql_query("SELECT title,id FROM programm");
							$myrow= mysql_fetch_array($result);
							do{
								printf("<p><a href='index.php?act=update&tp=program&id=%s'>%s</a></p>",$myrow['id'],$myrow[						            'title']); 	   
							}
							while($myrow= mysql_fetch_array($result));
						}
						else
						{
                            $result=mysql_query("SELECT * FROM programm WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
                            ?>
					 		<p><span id='result'>Редактирование записи:</span></p> 
							<form id="myForm" action="program_upload.php" method="post">
								<p> Заголовок:
								<textarea  name="title" cols="60" rows="2"><?=$myrow['title']?></textarea></p>
								<p>Дата:
									<input name="date" id="calendar" type="text" value="<?=$myrow['date']?>" /></p>
									<p>Краткое описание с тегами:<br/>
									<textarea name="description" id="description" cols="60" rows="5"><?=$myrow['description']?></textarea></p>
									<p>Полное описание с тэгами:<br/>
									<textarea name="text" cols="60" rows="15"><?=$myrow['text']?></textarea></p>
									<p>Автор:
									<input type="text" name="author" value="<?=$myrow['url']?>" /></p>
									<input value="<?=$myrow['id']?>" type="hidden" name="id"/>
							 </form>             
								<button id='sub'>Сохранить изменения</button>	   
								 <script type="text/javascript">
							$("#myForm").submit(function () {
								return false;});
								</script>
								<?
						}
						break;
                    default: 
                        echo "<h3>Неизвестный запрос.</h3>";
						break;
				}
                break;    
			default:echo "<h3>Неизвестный запрос.</h3>";break;
		}
		echo"</div>";
	}?>
	</div>
    <!-- END Content-->
</div>

	<script type="text/javascript">
		function Save_Page(){
			$("#myForm").submit();
		/*showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
				Msg(info);});*/
		}

/* OLD Upload
		$("#sub").click(function () {
			showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
				Msg(info);

			});
		});
 */
		$(document).ready(function (e) {
			$("#myForm").on('submit', (function (e) {
				e.preventDefault();
				showNoticeToast();
				$.ajax({
					url: $(this).attr('action'), // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData: false,        // To send DOMDocument or non processed data file it is set to false
					success: function (data)   // A function to be called if request succeeds
					{
						Msg(data);
						/* $('#loading').hide();
						 $("#message").html(data);*/
					}
				});
				return false;
			}));
		});

		$("#sub2").click(function () {
			showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
			Msg(info);
			if(info=="1") 
			{
				//location.reload();
				 $.ajax({
					type: "POST",	
					url: "upload_del.php",  
					//cache: false,
					data: {tp:$("#tp").val(),activ:$("#activ").val()},
					success: function(html){  
						$("#myForm").html(html);  
					}  
				});
			}
			});
		});
	</script>
	<!-- Chose-->
	<script src="chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		var config = {
		  '.chosen-select'           : {},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:10},
		  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		  '.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
 	</script>
	<!-- End Chose-->
	<!--Fancybox-->
	<link rel="stylesheet" href="/admin/fancybox/jquery.fancybox.css">
	<script src="/admin/fancybox/jquery.fancybox.js" type="text/javascript"></script>

<?
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/blocks/footer.php');?>