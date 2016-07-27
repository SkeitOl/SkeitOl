<?
include("../blocks/bd.php");
if(isset($_GET[del])&&($_GET[del]!=''))
{
	$result = mysql_query("DELETE FROM products WHERE id=$_GET[del]", $db);
	header("Location: /admin/"); exit;
	
}?><script>
function hideorshowoldprice(object){
document.getElementById('old_price').disabled=(object.checked)?false:true;
}

function question_del(name){
	if (confirm("Удалить из БД '"+name+"'")) {
  return true;
} else {
  return false;
}

}
</script>
<style>
body{
margin:0;
font-family:Calibri;
background: #e3e3e3;
}
.menu{

	width: 100%;
list-style-type: none;
padding: 0;
background: #5EC26B;
display: block;
height: 30px;
line-height: 30px;
float: left;
margin: 0 0 1em;
color: #fff;
	
	}
	
.menu li{
	float:left;
	padding: 0 0.6em;
	position: relative;
	border-right: 1px dotted #444;
}
.menu li a{
	text-decoration: none;
	color: #fff;
	margin: 0;
	padding: 0;
	display: block;
}
.menu li:hover{
	background: #348D40;
}
.p_list{
	margin:0 auto;
	border:1px solid #9b9a9a;
	border-collapse: collapse;
}
.p_list tr{
border-bottom: 1px solid #9b9a9a; 
}
.p_list tr:hover{
	background:#FAF9BF;
}
.p_list td{
padding: 5px;
}
.div-bloks,.div-bloks-2{
max-width:450px;
margin:0 auto;
overflow: auto;
background: #fff;
padding: 0 8px 10px;
box-shadow: 0 0 8px #ccc;
}
.div-bloks-2{
max-width:850px;
}
</style>
<ul class="menu"><li><a href='/'>Главная</a></li><li><a href='/admin/'>Список товаров</a></li><li><a href='index.php?add=1'>Добавить товар</a></li></ul>

<br>
<?


if(isset($_GET[id])){
}
else if(isset($_GET[update])){
$result = mysql_query("SELECT * FROM products WHERE id=$_GET[update]", $db);
$myrow = mysql_fetch_array($result);
echo"
<div class='div-bloks'>
	<h2>Редактирование товара:</h2>
	<form action='f_product.php' method='post'>
		<p>
		<input type='hidden' name='tp' value='update'/>
		<input type='hidden' name='id' value='".$myrow[id]."'/>
		<label><b>Имя:</b></label><br>
		<input type='text' name='name' value='".$myrow[name]."'/>
		</p>
		<p>
		<label><b>Размеры:</b></label><br>
		<input type='text' name='sizes' value='".$myrow[sizes]."'/>
		</p>
		<p>
		<label><b>Цена:</b></label><br>
		<input type='text' name='price' value='".$myrow[price]."'/>
		</p>
		<p>
		<label><b>Имя изображения:</b></label><br>
		<input type='text' name='img' value='".$myrow[img]."'/>
		</p>
		<p>
		<label><b>Сортировка:</b></label><br>
		<input type='text' name='sort' value='".$myrow[sort]."'/>
		</p>
		<p>
		<label><b>Свойства товара:</b></label><br>
			<label><input type='checkbox' id='' name='check_new' ".((!empty($myrow['new']))?'checked':'')." value='1'> Новинка</label>
		</p>
		<p>
		<label><input onClick='hideorshowoldprice(this)' type='checkbox' id='check_old_price' name='check_old_price' ".((!empty($myrow[old_price]))?'checked':'')." value='1'><b>Старая цена:</b></label><br>
		<input type='text' name='old_price' id='old_price' ".((empty($myrow[old_price]))?'disabled':'')." value='".$myrow[old_price]."'/>
		</p>
		<button>Сохранить</button>
	</form>
</div>
<br>";
}else if(isset($_GET[add])){
echo"
<div class='div-bloks'>
<h2>Добавление нового товара:</h2>
<form action='f_product.php' method='post'>
	<p>
	<input type='hidden' name='tp' value='add'/>
	<label><b>Имя:</b></label><br>
	<input type='text' name='name' value='".$myrow[name]."'/>
	</p>
	<p>
	<label><b>Размеры:</b></label><br>
	<input type='text' name='sizes' value='".$myrow[sizes]."'/>
	</p>
	<p>
	<label><b>Цена:</b></label><br>
	<input type='text' name='price' value='".$myrow[price]."'/>
	</p>
	<p>
	<label><b>Имя изображения:</b></label><br>
	<input type='text' name='img' value='".$myrow[img]."'/>
	</p>
	<p>
	<label><b>Сортировка:</b></label><br>
	<input type='text' name='sort' value='500'/>
	</p>
	<p>
	<label><b>Свойства товара:</b></label><br>
		<label><input type='checkbox' id='' name='check_new' ".((!empty($myrow['new']))?'checked':'')." value='1'> Новинка</label>
	</p>
	<p>
	<label><input type='checkbox' name='check_old_price' value='1'><b>Старая цена:</b></label><br>
	<input type='text' name='old_price' value='".$myrow[old_price]."'/>
	</p>
	<button>Добавить</button>
</form>
</div>
<br>";
}
else
{

$result = mysql_query("SELECT * FROM products", $db);
$myrow = mysql_fetch_array($result);
echo"
<div class='div-bloks-2'>
<h2>Полный список:</h2>
<table class='p_list' cellspacing='1'>
<thead>
<tr>
	<th>Имя</th>
	<th>Цена</th>
	<th>Размеры</th>
	<th>Старая цена</th>
	<th>Имя изображения</th>
	<th>Сортировка</th>
	<th>Свойства товара</th>
	<th>Изменения</th>
</tr>
</thead>
<tbody>
";
do {
echo"<tr>
	<td>".$myrow[name]."</td>
	<td>".$myrow[price]."</td>
	<td>".$myrow[sizes]."</td>
	<td>".$myrow[old_price]."</td>
	<td>".$myrow[img]."</td>
	<td>".$myrow['sort']."</td>
	<td><label><input type='checkbox' id='' name='check_new' ".((!empty($myrow['new']))?'checked':'')." value='1'> Новинка</label></td>
	<td><a href='index.php?update=".$myrow[id]."'>Изменить</a><br><a href='index.php?del=".$myrow[id]."' onclick='return question_del(\"".$myrow[name]."\")'>Удалить</a></td>
</tr>";
}while ($myrow = mysql_fetch_array($result));
echo"</tbody></table></div>";
}

/*echo"<li>
<p>
<label><b>Имя:</b></label><br>
<input type='text' name='name' value='".$myrow[name]."'/>
</p>
<p>
<label><b>Цена:</b></label><br>
<input type='text' name='price' value='".$myrow[price]."'/>
</p>
<p>
<label><b>Размеры:</b></label><br>
<input type='text' name='sizes' value='".$myrow[sizes]."'/>
</p>
<br>
</li>";*/
?>