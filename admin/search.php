<? 
//header('Content-Type: text/html; charset= utf-8');
include("lock.php");
include("blocks/bd.php");

if(!empty($_POST["search_in_bd"])&&!empty($_POST["tp"]))
{

	$_POST["search_in_bd"]=htmlspecialchars($_POST["search_in_bd"]);
	$_POST["tp"]=htmlspecialchars($_POST["tp"]);
	$result = mysql_query("SELECT id,url,title FROM ".$_POST["tp"]." WHERE title LIKE '%".$_POST["search_in_bd"]."%'" ,$db);	  
	$myrow=mysql_fetch_array($result);
	if($result){
	?>
<style>
.search_table {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 14px;background: white;/*max-width: 70%;/*width: 70%;*/border-collapse: collapse;text-align: left;}
.search_table  th {font-weight: normal;color: #039;border-bottom: 2px solid #6678b1;padding: 10px 8px;}
.search_table  td {  border-bottom: 1px solid #ccc;color: #669;padding: 9px 8px;transition: .3s linear;}
.search_table tr:hover td{background: #e8edff;}
.search_table a{color:#3E3E3E;text-decoration:none;}
.search_table a:hover {text-decoration:underline;}
		</style>
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