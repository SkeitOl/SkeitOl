<?header('Content-Type: text/html; charset= utf-8');
include("lock.php");
include("blocks/bd.php");
    if( isset($_POST['act'])){$act=$_POST['act'];if($act=='')unset($act);}
    if(!isset($act)){if( isset($_GET['act'])){$act=$_GET['act'];if($act=='')unset($act);}}
	if( isset($_POST['tp'])){$tp=$_POST['tp'];if($tp=='')unset($tp);}
    if(!isset($tp)){if( isset($_GET['tp'])){$tp=$_GET['tp'];if($tp=='')unset($tp);}}
	
	session_start();
	if(isset($_SESSION['step'])&&(!empty($_SESSION['step'])))
		$step=$_SESSION['step'];
	else $step=10;
	if(isset($_GET['step'])){
		$step=$_GET['step'];
		$_SESSION['step']=$step;
	}
  ?>
<!DOCTYPE>
<html>
<head>
    <title>Панель администрирования</title>
    <link rel="icon" href="../images/s.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../images/s.ico" type="image/x-icon" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
	<link rel="Stylesheet" type="text/css" href="cal.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <script src="script/jquery-1.8.3.js"></script>
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css">
	 <!-- End Chose-->
	 <script src="script/cal.js"></script>
	 <script type="text/javascript">
		$(document).ready(function(){
		$('#calendar').simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
		});
	</script>
	<script>
	$(document).ready(function() {

	//Когда страница загружается...
	$(".tab_content").hide(); //Скрыть весь контент
	$("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
	$(".tab_content:first").show(); //Показать контент первой вкладки

	//Событие по клику
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Удаление любого "active" класса
		$(this).addClass("active"); //Добавление "active" класса на активную вкладку
		$(".tab_content").hide(); //Скрыть контент вкладок

		var activeTab = $(this).find("a").attr("href"); //Найти href значение атрибута для выявления активной вкладки и контента
		$(activeTab).fadeIn(); //Fade in контента с активным ID
		return false;
	});

});
	/*блокировка Ctr+s*/
$(document).bind('keydown', function(e) {
  if(e.ctrlKey && (e.which == 83)) {
    e.preventDefault();
    {
		//alert('Ctrl+S');
		Save_Page();
	}
    return false;
  }
});
	/*End блокировка Ctr+s*/</script>
<script>
    
    function add_html_box(char) {
	var textarea = document.getElementById('text-box');
        switch (char) {
            case "b": textarea.value += "<b></b>"; break;
            case "p": textarea.value += "<p></p>"; break;
            case "img": textarea.value += "<img src=''/>"; break;
            case "a": textarea.value += "<a href=''></a>"; break;
            case "a-out": textarea.value += "<a href='' target='_blank' class='link-out'></a>"; break;
            case "h1": textarea.value += "<h1></h1>"; break;
            case "h2": textarea.value += "<h2></h2>"; break;
            case "h3": textarea.value += "<h3></h3>"; break;
        }
    }
</script>
	<style>
    .edit-button {
        background:#fff;
        box-shadow: 0 0 7px rgba(0,0,0, 1.2) !important;
        margin:0.4em;
        padding:0.2em;
    }
	.text-input{
		width:90%;
		padding:3px;
		max-width:600px;
		height:2em;
	}
</style>
</head>
<body>

<div style="width:100%; height:100%;">
    <!-- LEFT block -->
    <?php include('blocks/lefttd.php'); ?>
    <!-- END LEFT block-->
	<!-- Message-->
	<div class="toast-container toast-position-top-right"></div>
	
	  <script src="https://js-hotkeys.googlecode.com/files/jquery.hotkeys-0.7.9.min.js"></script>
	<script type="text/javascript">
    function showSuccessToast() {
        $().toastmessage('showSuccessToast', "Успешно");
    }  
    function showNoticeToast() {
        $().toastmessage('showNoticeToast', "Сохранение данных..<br>");
    }
    function showWarningToast() {
        $().toastmessage('showWarningToast', "Введена не вся информация");
    }
    function showErrorToast() {
        $().toastmessage('showErrorToast', "Ошибка!<br>");
    }
	function Msg(m){
		//alert(m);
	switch(m)
	{		
		case"1":showSuccessToast();
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
		var b=10;
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
	function PrintShortLinks($num,$db)
	{
		$result = mysql_query("SELECT * FROM $num ORDER BY id DESC LIMIT 0,5",$db);	  
		if($result)
		{
			?>
			<style>
				.small-table{
					
				}
				.align-left{
					text-align:left;
				}
			</style>
			<table class="small-table">
			<tr>
				<th width="80">id</th>
				<th>Title</th>
				<th>Title</th>
			</tr>
			<?
			$myrow=mysql_fetch_array($result);								
			do
			{	
				echo"<tr>
						<td>".$myrow['id']."</td>
						<td class='align-left'><a href='index.php?act=update&tp=".$num."&id=".$myrow['id']."'>".strip_tags($myrow['title'])."</a></td>
						<td><input type='checkbox' disabled='disabled'";
						echo(($myrow[active])?"checked":"");echo"></td>
					</tr>
					";
			}
			while($myrow=mysql_fetch_array($result));
			?>
			</table>
			<?
		}
	}
	
	
	 if(!(isset($act)&& isset($tp))){
        echo"<h2>Добро пожаловать в панель администрирования.</h2>";
        echo"<p>Выберите необходимое действие слева</p>";
		?>
		<h2>Статьи</h2>
		<?PrintShortLinks("articles",$db);?>
		<h2>Новости</h2>
		<?PrintShortLinks("news",$db);?>
		<?
    }
    else
    { 
		$dat=date("d-m-Y");
		echo"<div class='form'>";			
		echo"
		<p style='float: right;position: relative;right: 0;'>Элементов на странице:
		<select  name='ComboBox1' id='ComboBox1' style='width:60' onchange='Goy(this);'>
		<option value='10'";if($step==10)echo"selected";echo">10</option>
		<option value='20'"; if($step==20)echo"selected";echo">20</option>
		<option value='50'"; if($step==50)echo"selected";echo">50</option>
		<option value='100'"; if($step==100)echo"selected";echo">100</option>
		</select></p>";
		switch($tp)
		{
			case 'news':
			case 'articles':
			case 'serials':
			case 'pages':
				switch($tp){
					case 'news':echo"<h2 style='color:#FF3300'>Новости</h2>";break;
					case 'articles':echo"<h2 style='color:#FF3300'>Статьи</h2>";break;
					case 'serials':echo"<h2 style='color:#FF3300'>Сериалы</h2>";break;
					case 'pages':echo"<h2 style='color:#FF3300'>Страницы</h2>";break;
				}
				switch($act)
				{
					case 'add':						
						echo"<h3>Добавление новой записи:</h3>";
						$dat=date("Y-m-d H:m:s");
						echo"<form id='myForm' action='add_tp.php' method='post'>";?>
						<ul class="tabs">
							<li><a href="#tab1">Основные</a></li>
							<li><a href="#tab2">SEO</a></li>
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
								  </div>";}
								  
								  
								$active_p_bool="";
								$active_p='';
								if(isset($myrow[active]))
								{
									$active_p_bool='<input name="active_p_bool" type="hidden" value="1"/>';
									if(($myrow[active]))
										$active_p='checked';
									else $active_p='';
								}
								  
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
									<p><b>Автор:</b><input type="text" name="author" value="Администратор"/></p>
									<input value="$id" type="hidden" name="id"/>
									<input name="tp" type="text" style="display:none;" value="$tp">
									<input name="activ" type="text" style="display:none;" value="$act">
								</div>
									<div id="tab2" class="tab_content">
										<p><b>meta_keywords:</b><br><input type="text" class="text-input" name="meta_keywords" value="$myrow[meta_keywords]"/></p>
										<p><b>meta_description:</b><br><input type="text" class="text-input" name="meta_description" value="$myrow[meta_description]"/></p>
									</div>
								</div>
							</form> 									
							<button id='sub'>Добавить</button>
<label><input type='checkbox' id='check_link'/>Не уходить со страницы</label>									
ADD;
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
						echo"<h3><span id='result'>Редактирование записи:</span></h3>";
						include("blocks/bd.php");	
						if(isset($_GET['id'])) {$id=$_GET['id']; if($id==''){unset($id);}}
						if(!isset($id))
						{
							
							/*навигация*/
							if(isset($_GET['step']))$step=$_GET['step'];else $step=10;

							//if(isset($_POST['list']))$list=$_POST['list'];else 
							if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
							$result = mysql_query("SELECT COUNT(*) as count FROM ".$tp." ",$db);	  
							$row=mysql_fetch_array($result);

							if($row['count']>$step)
							{	
								$i=1;
								echo"<h1 id='ComboBox1'>Страница №$list</h1>";	
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
							include("blocks/bd.php");
							$result = mysql_query("SELECT id,title,date FROM $tp ORDER BY id DESC LIMIT $startI,$endI",$db);	 
							if (!$result) {
								$message  = 'Неверный запрос: ' . mysql_error() . "\n";
								$message .= 'Запрос целиком: ' . $query;
								die($message);
							}
							
							$myrow=mysql_fetch_array($result);
							$i=1;
							echo"<table border='1'>
							<col class='col1'>
							<col class='col2'>
							<col class='col3'>
							<tr>
								<td><b>ID</b></td>
								<td><b>Дата</b></td>
								<td><b>Заголовок</b></td>
							</tr>
							<tbody>";$s='"';
							do{
							printf("<tr onclick=%slocation.href='index.php?act=update&tp=$tp&id=%s'%s>
								<td>%s</td>
								<td>%s</td>
								<td align='left'>%s</td>
							</tr>",$s,$myrow['id'],$s,$myrow['id'],date_format(date_create($myrow['date']),'d-M-Y H:i'),strip_tags($myrow['title']));		
								$i++;
							}
							while($i<=$step && $myrow= mysql_fetch_array($result));
							echo"</tbody>
							</table>";
						}
						else
						{
                            $result=mysql_query("SELECT * FROM $tp WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
							echo"<p><a href='../$tp".$myrow['id'].".html' target='_blank'>$tp </a>№ ".$myrow['id']."</p>";
							
							
							echo"<form id='myForm' action='add_tp.php' method='post'>";
							?>
								<ul class="tabs">
									<li><a href="#tab1">Основные</a></li>
									<li><a href="#tab2">SEO</a></li>
								</ul>
								<div class="tab_container">
								<div id="tab1" class="tab_content">
   
								<?	
							if($tp=='articles'){
								$array1 = array();/**/
								$array1 = unserialize($myrow['category']);/**/									
								$result = mysql_query("SELECT * FROM category",$db);	  
								$myrow=mysql_fetch_array($result);
								$i=1;							
								echo"<div class='side-by-side clearfix'>
								<div>          
								  <em>Категории</em>
								  <select data-placeholder='Выбор категории' class='chosen-select' multiple style='width:350px;' tabindex='1' name=category_m[]>
									<option value=''></option>";															
								do{	
									$f='';
									if(count($array1)>0)
									for($i=0;$i<count($array1);$i++)
										if($myrow['id']==$array1[$i]){$f='selected';break;}
									echo"<option value=".$myrow['id']." ".$f.">".$myrow['name']."</option>";									
								}
								while($myrow=mysql_fetch_array($result));								
								echo"
									  </select>
									</div>
								  </div>";
								}
							$result=mysql_query("SELECT * FROM $tp WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
							$myrow['title']=htmlspecialchars($myrow['title'], ENT_QUOTES);
							$myrow['description']=htmlspecialchars($myrow['description'], ENT_QUOTES);
							$myrow['text']=htmlspecialchars($myrow['text'], ENT_QUOTES);
							
							$active_p_bool="";
							$active_p='';
							if(isset($myrow[active]))
							{
								$active_p_bool='<input name="active_p_bool" type="hidden" value="1"/>';
								if(($myrow[active]))
									$active_p='checked';
								else $active_p='';
							}
                            print <<<HERE
								
										<p><b>Заголовок:</b>
										<textarea  name="title" rows="2">$myrow[title]</textarea></p>
										<p><b>Дата:</b>
										<input name="date" id="calendar" type="text" value="$myrow[date]" /></p>
										<p><b>Отоброжать:</b><input name="active_p" type="checkbox" $active_p value='1' /></p>
										$active_p_bool
										<p><b>Краткое описание с тегами:</b><br/>
										<textarea name="description" id="description" rows="3">$myrow[description]</textarea></p>
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
										<textarea name="text" rows="8" id="text-box">$myrow[text]</textarea></p>
										<p><b>Автор:</b>
										<input type="text" name="author" value="$myrow[url]" /></p>	
										
											
										<input value="$id" type="hidden" name="id"/>
										<input name="tp" type="text" style="display:none;" value="$tp">
										<input name="activ" type="text" style="display:none;" value="$act">
									</div>
									<div id="tab2" class="tab_content">
										<p><b>meta_keywords:</b><br><input type="text" name="meta_keywords" class="text-input"value="$myrow[meta_keywords]"/></p>
										<p><b>meta_description:</b><br><input type="text" name="meta_description"class="text-input" value="$myrow[meta_description]"/></p>
									</div>
								</div>
							</form>             
							<button id='sub'>Сохранить изменения</button>							
HERE;
						}
						break;
                    default: 
                        echo "Неизвестный запрос. =(";
						break;
				}
                break;
				/////////////////////////
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
                            print <<<HERE
					 <p><span id='result'>Редактирование записи:</span></p> 
							<form id="myForm" action="program_upload.php" method="post">
								<p> Заголовок:
								<textarea  name="title" cols="60" rows="2">$myrow[title]</textarea></p>
								<p>Дата:
									<input name="date" id="calendar" type="text" value="$myrow[date]" /></p>
									<p>Краткое описание с тегами:<br/>
									<textarea name="description" id="description" cols="60" rows="5">$myrow[description]</textarea></p>
									<p>Полное описание с тэгами:<br/>
									<textarea name="text" cols="60" rows="15">$myrow[text]</textarea></p>
									<p>Автор:
									<input type="text" name="author" value="$myrow[url]" /></p>
								<input value="$myrow[id]" type="hidden" name="id"/>
							 </form>             
								<button id='sub'>Сохранить изменения</button>	   
								 <script type="text/javascript">								
								 $("#sub").click(function () {
								//$("#result").html("Сохранение данных...");
								$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { $("#result").html(info); });});
							$("#myForm").submit(function () {
								return false;});
								</script>
HERE;
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
	}
?>
	</div>
    <!-- END Content-->
</div>
<script type="text/javascript">
	function Save_Page(){
	showNoticeToast();
		$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
			Msg(info);});
	}
	$("#sub").click(function () {
		showNoticeToast();
		$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
			Msg(info);});});
	$("#myForm").submit(function () {
	return false;
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
			});});
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
</body>
</html>	