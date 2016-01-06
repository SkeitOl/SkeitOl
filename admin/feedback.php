<?
header('Content-Type: text/html; charset= utf-8');
include("lock.php");
?>
<!DOCTYPE>
<html>
<head>
    <title></title>
    <?php 
	$sys_description="";
	$sys_keywords="";
	$sys_pages="";
	$sys_pages_print="Обратная связь";
	$sys_title="Панель администрирования - Обратная связь";
	
	$sys_special_head_text='';
	include('blocks/head.php'); ?>
</head>
<body>
<div style="width:100%; height:100%;">
    <!-- LEFT block -->
    <?php include('blocks/header.php'); ?>
    <!-- END LEFT block-->
    <!-- LEFT block -->
    <?php include('blocks/lefttd.php'); ?>
    <!-- END LEFT block-->
	<!-- Message-->
    <!-- Content-->
    <div id="content">
	
	<h1><caption>Обратная связь</caption></h1>
	<style>
	.deistv{
	float:left;
	}
	.deistv a{
	margin: 0px 10px 0 10px;
	}
.but_red {
	-moz-box-shadow:inset 0px 1px 0px 0px #f29c93;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f29c93;
	box-shadow:inset 0px 1px 0px 0px #f29c93;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #ce0100) );
	background:-moz-linear-gradient( center top, #fe1a00 5%, #ce0100 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#ce0100');
	background-color:#fe1a00;
	-webkit-border-top-left-radius:14px;
	-moz-border-radius-topleft:14px;
	border-top-left-radius:14px;
	-webkit-border-top-right-radius:14px;
	-moz-border-radius-topright:14px;
	border-top-right-radius:14px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0px;
	border:1px solid #d83526;
	display:inline-block;
	color:#ffffff;
	font-family:Verdana;
	font-size:14px;
	font-weight:normal;
	font-style:normal;
	height:35px;
	line-height:35px;
	width:73px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #b23e35;
}
.but_red:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ce0100), color-stop(1, #fe1a00) );
	background:-moz-linear-gradient( center top, #ce0100 5%, #fe1a00 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ce0100', endColorstr='#fe1a00');
	background-color:#ce0100;
}.but_red:active {
	position:relative;
	top:1px;
}
.but_green {
	-moz-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	-webkit-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9dce2c), color-stop(1, #8cb82b) );
	background:-moz-linear-gradient( center top, #9dce2c 5%, #8cb82b 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#9dce2c', endColorstr='#8cb82b');
	background-color:#9dce2c;
	-webkit-border-top-left-radius:14px;
	-moz-border-radius-topleft:14px;
	border-top-left-radius:14px;
	-webkit-border-top-right-radius:14px;
	-moz-border-radius-topright:14px;
	border-top-right-radius:14px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0px;
	border:1px solid #83c41a;
	display:inline-block;
	color:#ffffff;
	font-family:Verdana;
	font-size:14px;
	font-weight:normal;
	font-style:normal;
	height:35px;
	line-height:35px;
	width:86px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #689324;
}
.but_green:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8cb82b), color-stop(1, #9dce2c) );
	background:-moz-linear-gradient( center top, #8cb82b 5%, #9dce2c 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8cb82b', endColorstr='#9dce2c');
	background-color:#8cb82b;
}.but_green:active {
	position:relative;
	top:1px;
}
.fb input, label, abbr,.fb div{
float: left;
margin:0 10px 0 10px;text-align:center;
}
.fb li{width:100%;
border:1px solid #88887A;
height:20px;
    list-style-type: none; 
}
.fb li:hover{background-color: #E2DDB6;}

.fb input{
width: 20px;
margin-top: 5;
}
.fb abbr{
width:150px;
}
.fb a{width:100%;
color:#1D1A1A;
}
.fb a:visited{
color:#1D1A1A;
}
.fb a:hover{
color:#051981;
text-decoration:underline;
}
.op{
	background: #eee;}
</style>
	<?
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$result=mysql_query("SELECT * FROM feedback WHERE id=$id");
		$myrow= mysql_fetch_array($result);		
		if($myrow['checkbox']==1) mysql_query("UPDATE feedback SET checkbox='0' WHERE id='$id");
		echo"<p>Сообщение №".$_GET['id']."</p>
		<p><a href=feedback.php>К списку</a></p>
		</br>
		<p><b>Имя:</b><br/>".$myrow['nik']."</p>
		<p><b>e-mail:</b><br/>".$myrow['email']."</p>
		<p><b>Дата:</b><br/>".$myrow['datetime']."</p>
		<p><b>Сообщение:</b><br/>".$myrow['message']."</p>
		";
	}
	else
	{		
		$d='"';
		echo"
		<div class='deistv'><a href='#'class='but_green' onclick='Action(".$d."read".$d.")'>Прочитано</a><a href='#'class='but_red'onclick='Action(".$d."del".$d.")'>Удалить</a></div>
	
		<form action='feedback_edit.php' id='myForm' method='post' style='float:left;width:90%'>
			<table class='small-table links'>
				<thead>
					<tr>
						<td><input type='checkbox'  name='id[]' value='1'/></td>
						<td>Дата</td>
						<td>Имя</td>
						<td>Сообщение</td>
					</tr>
				</thead>
				<tbody>		
		
			
				
			";
		$result=mysql_query("SELECT * FROM feedback");
		$myrow= mysql_fetch_array($result);
		do{
			echo"<tr";if($myrow['checkbox']==1) echo" class='op'"; echo">
					<td><input type='checkbox'  name='id[]' value='".$myrow['id']."'/></td>";
					
					
			if(strlen($myrow['message'])>100)$mes=substr($myrow['message'],0,98)."..";
			else $mes=$myrow['message'];
			echo"
				<td>".$myrow['datetime']."</td>
				<td>".$myrow['nik']."</td>
				<td><a href='feedback.php?id=".$myrow['id']."'>".$mes."</a></td>
				</tr>";
		}
		while($myrow= mysql_fetch_array($result));		
	}
	echo"
		</tbody>
	</table>
	";
?>	
	<script type="text/javascript">
	$("#myForm").submit(function () {
	return false;
	});
		function Action(s){
			document.getElementById("action").value=s;			
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), 
			function (info) {
			alert(info);});
			
		}
	</script>
	<input name='action' id='action' type="hidden">
	</form>
	</div>
    <!-- END Content-->
</div>
</body>
</html>	