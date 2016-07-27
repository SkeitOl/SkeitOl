<? 
//header('Content-Type: text/html; charset= utf-8');
include_once($_SERVER['DOCUMENT_ROOT']."/admin/lock.php");
include_once($_SERVER['DOCUMENT_ROOT']."/blocks/bd.php");
if(!empty($_POST["search_in_bd"])&&!empty($_POST["tp"]))
{

	$_POST["search_in_bd"]=htmlspecialchars($_POST["search_in_bd"]);
	$_POST["tp"]=htmlspecialchars($_POST["tp"]);
	$search_column=$_POST["search_column"]?htmlspecialchars($_POST["search_column"]):'title';

	$result = mysql_query("SELECT id,url,title FROM ".$_POST["tp"]." WHERE $search_column LIKE '%".$_POST["search_in_bd"]."%'" ,$db);
	$myrow=mysql_fetch_array($result);
	?>
<link rel="stylesheet" href="/admin/style.css">
<link rel="stylesheet" href="/admin/css/style.css">
<style>
	.search_table {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 14px;background: white;/*max-width: 70%;/*width: 70%;*/border-collapse: collapse;text-align: left;}
	.search_table  th {font-weight: normal;color: #039;border-bottom: 2px solid #6678b1;padding: 10px 8px;}
	.search_table  td {  border-bottom: 1px solid #ccc;color: #669;padding: 9px 8px;transition: .3s linear;}
	.search_table tr:hover td{background: #e8edff;}
	.search_table a{color:#3E3E3E;text-decoration:none;}
	.search_table a:hover {text-decoration:underline;}
	.quick_blok.search_in_page{width: 100%}
	.quick_blok.search_in_page p{border: none;}
	.search_in_page #search_in_bd{width: 80%;box-sizing: border-box;}
</style>
<div id="content">
	<h1>Поиск в БД</h1>
	<div class="quick_blok search_in_page">
		<form action="" method="post" class="">
			<p>Поисковая строка</p>
			<input type="text" id="search_in_bd" name="search_in_bd" value="<?=$_POST["search_in_bd"]?>">
			<p>Таблица</p>
			<input type="text" name="tp" value="<?=$_POST["tp"]?>">
			<p>Поле</p>
			<select name="search_column">
				<?
				$result2 = mysql_query("SHOW COLUMNS FROM articles" ,$db);
				if (mysql_num_rows($result2) > 0) {
					while ($row2 = mysql_fetch_assoc($result2)) {
						?><option value="<?=$row2['Field']?>" <?if($search_column==$row2['Field'])echo'selected'?>><?=$row2['Field']." (".$row2['Type'].")"?></option><?

					}
				}?>
			</select>
			<br><br><input type="submit" name="" value="Поиск" class="save_bth">
		</form>
	</div>
	<p>Результат:</p>
<?
	if($result){
	?>
		<table class="search_table">
			<thead>
				<tr>
					<th>№</th>
					<th>ID</th>
					<th>TITLE</th>					
				</tr>
			</thead>
		<?
		$k=1;
		do
		{
			?>
				<tr>
					<td><?=($k++)?></td>
					<td><?=($myrow['id'])?></td>
					<td><a href="/admin/index.php?act=update&tp=<?=($_POST['tp'])?>&id=<?=($myrow['id'])?>" target="_blank"><?=strip_tags($myrow['title'])?></a></td>					
				</tr>
			<?
		}
		while($myrow=mysql_fetch_array($result));
		?>
		</table>
	<?
	}
	else{?>
		<p>По вашему запросу не найдено записей в БД.<p>
	<?}
}
?>
		</div>
<?
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/blocks/footer.php');?>