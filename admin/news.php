<?
header('Content-Type: text/html; charset= utf-8');
include("lock.php");
    if( isset($_POST['act'])){$act=$_POST['act'];if($act=='')unset($act);}
    if(!isset($act)){if( isset($_GET['act'])){$act=$_GET['act'];if($act=='')unset($act);}}
	if( isset($_POST['tp'])){$tp=$_POST['tp'];if($tp=='')unset($tp);}
    if(!isset($tp)){if( isset($_GET['tp'])){$tp=$_GET['tp'];if($tp=='')unset($tp);}}
	
	if(isset($_GET['step']))$step=$_GET['step'];else $step=10;  
  ?>
<!DOCTYPE>
<html>
<head>
    <title>Панель администрирования CMS SkeitOl</title>
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
});</script>

</head>
<body>
	
</body>
</html>	