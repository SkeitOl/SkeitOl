<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <title>Тест</title>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <link rel="SHORTCUT ICON" href="images/S.ico">
        <script src='js/jquery-1.8.3.js' type='text/javascript'></script>
   </head>
<body>
        <?php include("blocks/header.php"); 
		include("blocks/func/func.php");
		include("blocks/bd.php");?>
        <div id='content'>
      		<p>Тесты</p>
            <div style='width:100%; min-height:350px; background-color:#FFC;'>
            
            <?php 
			if(isset($_POST['type'])) $type=$_POST['type'];
			if($type=='')unset($type);
			if(!isset($type) || $type='new')
			{//Выводим список
				printf("<p><b>Выбирите тему:</b><br/></p>");
				$result = mysql_query("SELECT * FROM tests");
				$myrow = mysql_fetch_array($result);
				echo"<form name='test_form' action='test.php' method='post'>";
				do{
				printf(
				"<input id='radiobutton%s' type='radio' value='%s' name='question' style='margin:3px;'><label>%s</label></input><span> (вопросов:</span><b>%s)</b><br/>
				<input type='hidden' value='1' name='type'></input>
				"//"<a href='%s'>%s</a> <span>вопросов:</span><b>%s</b><br/>"
				,$myrow['id'],$myrow['idquestion'],$myrow['title'],$myrow['countquestion']);
				$maxvall=$myrow['countquestion'];
				}
				while($myrow=mysql_fetch_array($result));
				echo("
				
				<button id='sub' onClick='Hid()' style='margin:5px;'>Начать</button>
				</form>
			<script type='text/javascript'>
			function check(buttons,message){
                      if ( buttons == null ) return false;
                      for ( var i = 0; i < buttons.length; i++ ){
                          if ( buttons[i].checked) return true;
                            }
                      alert(message);
                      return false;
			}
			
			
			function Post(n)
			{
			   $.post('test.php',{type:n},onAjaxSuccess);
			}
			function onAjaxSuccess(data)
			{
 	 		// Здесь мы получаем данные, отправленные сервером и выводим их на экран.
	  		//$('#result').html(data);
			//document.getElementById('load-opros').style.visibility='hidden';
			}
			function Hid() 
			{
				 var buttons=document.test_form.question;
				 if ( buttons == null ) alert('Выберите хотя бы один пункт');
				 else
				 {
					 var b=false;
					 for ( var i = 0; i < buttons.length; i++ )
                          if ( buttons[i].checked) b= true;
                     if(b)
					 {
						
                       Post(1);
              		 }else alert('Выберите хотя бы один пункт');
             	}
			 }
			 </script>
				");
			
			}
			else
			{
			echo "<p></p>";
			if(isset($_POST['idquestion']))
			$idquestion=$_POST['idquestion'];
			else $idquestion=2;
			if(isset($_POST['numberquestion']))
			$numberquestion=$_POST['numberquestion'];
			else $numberquestion=1;
			
			$result = mysql_query("SELECT * FROM testquestion WHERE idquestion=$idquestion AND id2=$numberquestion");
			$myrow = mysql_fetch_array($result);
			printf(" 
			<span id='result'>
		   		<div id='opros' style='margin:10px;height:130px;'>
                <p><b>Вопрос %s/%s</b><br/>%s</p>
				<p><b>Варианты ответов:</b></p>
				<input id='radiobutton1' type='radio' value='1' name='question' style='margin:3px;'><label>%s</label></input><br/>
				<input id='radiobutton2' type='radio' value='2' name='question' style='margin:3px;'><label>%s</label></input><br/>
				<input id='radiobutton3' type='radio' value='3' name='question' style='margin:3px;'><label>%s</label></input><br/>
				<input id='radiobutton4' type='radio' value='4' name='question' style='margin:3px;'><label>%s</label></input><br/>
				<button id='sub' onClick='Hid()' style='margin:5px;'>Ответить</button><img src='images/4-0.gif' id='load-opros' style=' visibility:hidden'; />
				</div>
		  </span>
		  <script type='text/javascript'>
			function Post(n)
			{
			   $.post('add_answer.php',{answer_vl:n},onAjaxSuccess);
			}
			function onAjaxSuccess(data)
			{
 	 		// Здесь мы получаем данные, отправленные сервером и выводим их на экран.
	  		$('#result').html(data);
			document.getElementById('load-opros').style.visibility='hidden';
			}
			function Hid() {
                    var n = 200;
                    if (document.getElementById('radiobutton1').checked || document.getElementById('radiobutton2').checked || document.getElementById('radiobutton3').checked) {
						document.getElementById('load-opros').style.visibility='visible';
                       if(document.getElementById('radiobutton1').checked)Post(1);
					   if(document.getElementById('radiobutton2').checked)Post(2);
					   if(document.getElementById('radiobutton3').checked)Post(3);
              }else alert('Выберите хотя бы один пункт');
             }</script>
",$numberquestion,$maxvall,$myrow['question'],$myrow['otv1'],$myrow['otv2'],$myrow['otv3'],$myrow['otv4']);
			}
			?>
         
            </div>
    	</div>
	<?php include("blocks/footer.php"); ?>
 </body>
</html>