<?
header('Content-Type: text/html; charset= utf-8');
include("bd.php");
include("lock.php");
if(isset($_POST['activ']))$activ=$_POST['activ'];
if(isset($_GET['activ']))$activ=$_GET['activ'];
if(isset($activ)){
	switch($activ){
	case "add":
		$query = "INSERT INTO category (name) VALUES ('".$_POST['category']."')";
		$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());		
	break;
	case "update":
		$query = "UPDATE category SET name='$_POST[name]' WHERE id='$_POST[id]'";
		
		$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());		
	break;
	case "del":
		if(isset($_POST['id']))$id=$_POST['id'];
		if(isset($_GET['id']))$id=$_GET['id'];		
		$query = "DELETE FROM category WHERE id='$id'";
		$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
	break;
	};
	if (!$result) {
			$message  = 'Неверный запрос: ' . mysql_error() . "\n";
			$message .= 'Запрос целиком: ' . $query;
			die($message);
		}else echo"Запрос удался.";
}
?>
<!DOCTYPE>
<html>
<head>
    <title>category</title>
    <link rel="shortcut icon" href="../images/s.ico" type="image/x-icon" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div style="width:100%; height:100%;">
    <!-- LEFT block -->
    <?php include('blocks/lefttd.php'); ?>
    <!-- END LEFT block-->

    <!-- Content-->
    <div id="content">
	<h1>Категории [Статьи]</h1>
	<style>
		.borders{border: 1px solid #ccc;}
		
	</style>
	<?
	echo"<p>Добавление новой записи:</p>";
	print <<<ADD
		<form id="myForm" action="category.php" method="post" class='borders'>
			<p>Имя будушей категории:<br/>
			<input type="text" name="category" value="" placeholder="Компьютеры"/></p>
				<input name="activ" type="text" style="display:none;" value="add">
				<input name="tp" type="text" style="display:none;" value="$tp">
		<button id='sub'>Добавить</button>
		</form>									
					
ADD;
		?>

		<form id="myForm" action="category.php" method="post" class='borders'>
		
<p>Существующие категории:</p>
<style>
.activ_a a{margin:0 10px 0 10px;}</style>
		<?
		$result = mysql_query("SELECT * FROM category",$db);	  
		$myrow=mysql_fetch_array($result);
		do{
		echo"
			<form id='myForm' action='category.php' method='post' class='borders'>
				<input name='activ' type='hidden' style='display:none;' value='update'>
				<input name='id' type='hidden' style='display:none;' value='".$myrow['id']."'>
				<p class='activ_a'>Название: <input type='text' name='name' value='".$myrow['name']."'><input type='submit' value='Изменить'></a><a href='category.php?activ=del&id=".$myrow['id']."'>Удалить</a></p>
			</form>
		";
		}while($myrow=mysql_fetch_array($result));
		?>
		<input name="activ" type="text" style="display:none;" value="add">
		</form>
	</div>
    <!-- END Content-->
</div>
<script type="text/javascript">
	/*$("#sub").click(function () {
		showNoticeToast();
		$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
			Msg(info);
			alert(info);
			});});
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
    }*/
  </script>
	<!-- End Chose-->
</body>
</html>	