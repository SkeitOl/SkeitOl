<div class="top-con">
	<div class="logotype">
		<a href="/admin/" alt='Главная' >
			<img src="../images/sol.gif" width="70%" height="35px" alt="SkeitOL" style="max-width:100px;"/>
		</a>
	</div>
	<div class="boxs-exit">
		<?
		if($_SERVER['PHP_AUTH_USER']):
			$query = "SELECT * FROM userlist WHERE user='".$_SERVER['PHP_AUTH_USER']."'";
			$lst = @mysql_query($query);
			if (mysql_num_rows($lst) == 0) exit();
			$arr =  @mysql_fetch_array($lst);			
			$user_name= $arr['FIRST_NAME'];
			$img_src= $arr['IMG_SRC'];
			$user_id= $arr['id'];
		endif;
		?>
		<ul>
			<li class="box-ava">
				<div class="ava" <?if(!empty($img_src)):?>style="background-image:url('images/ava/<?=$user_id?>/<?=$img_src?>')"<?endif;?>
				><a href="user.php?edit_user=<?=$user_id?>" title="Настроить учётную запись"><?=$user_name?></a>
				</div>
			</li>
			<li class="box-exit">
				<a href="lock.php?exit" title="Выйти из панели администратора" alt="Выйти из панели администратора">выйти</a>
			</li>
		</ul>
	</div>
</div>