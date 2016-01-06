<div id="left_menu">
<a href="/admin/" alt='Главная' ><img src="../images/sol.gif" width="70%" height="35px" alt="SkeitOL" />    
<h3>Панель администрирования</h3></a>
<h2>Меню</h2>
<ul>		<style>ul img{width:26px;}</style>		
   </li>
		<a href="feedback.php"><li style="color:#171C24;">Обратная связь
		<?php 
		$result=mysql_query("SELECT * FROM feedback");
		$myrow= mysql_fetch_array($result);
		$k=0;
		do{
		if($myrow['checkbox']==1) $k++;
		}
		while($myrow= mysql_fetch_array($result));
		echo"(".$k.")"
		?>
		</li></a>					
   </li><br/>
   <li class="li-title">Новости</li>		
   <li>			<p>			<a href="index.php?act=add&tp=news"><img class="li-link" src="images/add_icon.png" title="Добавить"/></a>			
   <a href="index.php?act=update&tp=news"><img class="li-link" src="images/edit_icon.png" title="Редактировать"/></a>			
   <a href="index.php?act=del&tp=news"><img class="li-link" src="images/delete_icon.png" title="Удалить"/></a>			
   </p>		</li>						
   <li class="li-title">Статьи</li>		<li>			<p>			
   <a href="index.php?act=add&tp=articles"><img class="li-link" src="images/add_icon.png" title="Добавить"/></a>			
   <a href="index.php?act=update&tp=articles"><img class="li-link" src="images/edit_icon.png" title="Редактировать"/></a>			
   <a href="index.php?act=del&tp=articles"><img class="li-link" src="images/delete_icon.png" title="Удалить"/></a>			
   </p>		
   </li>
<li class="li-title">Страницы</li>		<li>			<p>			
   <a href="index.php?act=add&tp=pages"><img class="li-link" src="images/add_icon.png" title="Добавить"/></a>			
   <a href="index.php?act=update&tp=pages"><img class="li-link" src="images/edit_icon.png" title="Редактировать"/></a>			
   <a href="index.php?act=del&tp=pages"><img class="li-link" src="images/delete_icon.png" title="Удалить"/></a>			
   </p>		
   </li>   
<li class="li-title">Сериалы</li>		<li>			<p>			
   <a href="index.php?act=add&tp=serials"><img class="li-link" src="images/add_icon.png" title="Добавить"/></a>			
   <a href="index.php?act=update&tp=serials"><img class="li-link" src="images/edit_icon.png" title="Редактировать"/></a>			
   <a href="index.php?act=del&tp=serials"><img class="li-link" src="images/delete_icon.png" title="Удалить"/></a>			
   </p>		
      
   <li class="li-title">Программы</li><li>			<p>			<a href="index.php?act=add&tp=program"><img class="li-link" src="images/add_icon.png" title="Добавить"/></a>			<a href="index.php?act=update&tp=program"><img class="li-link" src="images/edit_icon.png" title="Редактировать"/></a>			<a href="index.php?act=del&tp=program"><img class="li-link" src="images/delete_icon.png" title="Удалить"/></a>			</p>		</li>	<li class="li-title">На сайт</li>        <li class="li-link">            <a href="../index.php">Вернуться на сайт</a>        </li>
 <li class="li-title">Другие</li>	
 <a href="2.php"><li style="color:#171C24;">Загрузка картинок</li></a>
  <a href="category.php"><li style="color:#171C24;">Категории[Статьи]</li></a>
  <a href="lock.php?exit"><li style="color:#FF5C6F">Выход</li></a>
 </ul></div>