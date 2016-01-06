<?php
//header('Content-Type: text/html; charset= utf-8');
function PrintOpros()
{ 
	$result = mysql_query("SELECT * FROM opros");
	$myrow = mysql_fetch_array($result);
	$width = 220;
	$ob = $myrow["otv1"] + $myrow["otv2"] + $myrow["otv3"];
	if($ob!=0)
	{
		$z1 = ($myrow["otv1"] * $width) / $ob;
		$z2 = ($myrow["otv2"] * $width) / $ob;
		$z3 = ($myrow["otv3"] * $width) / $ob;
		/*$p1=($myrow[otv1]*100)/$ob;
		$p1=floor($myrow['otv1']*100/$ob);
		$p2=($myrow[otv2]*100)/$ob;
		$p2=floor($p2);
		$p3=($myrow[otv3]*100)/$ob;
		$p3=floor($p3);
		*/
		$p1=round($myrow['otv1']*100/$ob);
		$p2=round($myrow['otv2']*100/$ob);
		$p3=round($myrow['otv3']*100/$ob);
		if ($z1 == 0)$z1 = 1;
		if ($z2 == 0)$z2 = 1;
		if ($z3 == 0)$z3 = 1;                        
	}
	else
	{
		$z1 =1;
		$z2 = 1;
		$z3 = 1;
		$p1=0;
		$p2=0;
		$p3=0;
	}
	printf("<span id='result'>
			<div id='opros'>
                <p style='margin:10px 0px 0px 0px;'>Как Вам сайт?</p>
                <label>Отлично - %s%%</label>
				<div class='bk-otvat'>
                	<div id='otvet1' style='height: 10px; background-color: green; width:%s%%;'></div>
				</div>
                <label>Хорошо - %s%%</label>
				<div class='bk-otvat'>
                	<div id='otvet2' style='height: 10px; background-color: yellow; width: %s%%;'></div>
                </div>
				<label>Ужасно - %s%%</label>
				<div class='bk-otvat'>
                	<div id='otvet3' style='height: 10px; background-color: red; width: %s%%;'></div>
				</div>
				<p style='margin:2px; color:#999;font-size:10px;'>Проголосовало: %s человек</p>	
			</div>
			</span>
			",$p1,$p1,$p2,$p2,$p3,$p3,($myrow["otv1"] + $myrow["otv2"] + $myrow["otv3"]));
}
function AskQuestion(){
	printf("<span id='result'>
		   		<div id='opros'>
                <p>Как Вам сайт?</p>
			    <p class='question_op'><input id='radiobutton1' type='radio' value='1' name='question'>Отлично</input></p>
				<p class='question_op'><input id='radiobutton2' type='radio' value='2' name='question'>Хорошо</input></p>
				<p class='question_op'><input id='radiobutton3' type='radio' value='3' name='question'>Плохо</input></p>
				<button id='sub' onClick='Hid()' style='margin:5px;'>Ответить</button><img src='/images/4-0.gif' id='load-opros' style=' visibility:hidden'; />
				</div>
		  </span>
		  <script type='text/javascript'>
			function Post(n)
			{
			   $.post('/add_answer.php',{answer_vl:n},onAjaxSuccess);
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
");
	}
?>