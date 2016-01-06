<?
if(!empty($_POST["filter"]))
{
	//include("blocks/bd.php");
	$filter=htmlspecialchars($_POST["filter"]);
	//echo"$filter";
	$filter = explode("-", $filter);
	$cat_id=$filter[2];

	include("blocks/bd.php");
	
	$result1 = mysql_query("SELECT id,name FROM category WHERE id='".$cat_id."'", $db);
	$row = mysql_fetch_array($result1);
	if ($result1 && $row['id'] != "") {
		echo"<p style='color:#FF3535'><b>Статьи на тему: " . $row['name'] . "</b></p>";
		echo"<div class='links'><ul>";
		$array1 = array();
		//WHERE category='".$row['name']."'"
		$result1 = mysql_query("SELECT * FROM articles", $db);
		$r = mysql_fetch_array($result1);
		$b = false;
		do {
			$b = False;
			$array1 = unserialize($r['category']);
			for ($i = 0; $i < count($array1); $i++) {
				if ($array1[$i] == $row['id']) {
					$b = True;
					break;
				}
			}
			if ($b) {
				if(!empty($r['url']))$url_page=$r['url'];else $url_page=$r['id'];
				echo"<li><a href='/articles/".$url_page."/' title='" . $r['title'] . "'>" . $r['title'] . "</a></li>";
			}
		} while ($r = mysql_fetch_array($result1));

		echo"</ul></div>";
		echo"<p></p>";
	} else
		echo"<p>Неизвестная категория.</p>";

}
else echo"No filter";
?>