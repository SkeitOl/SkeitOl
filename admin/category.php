<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include("lock.php");

if (isset($_POST['activ'])) {
	$activ = $_POST['activ'];
}
if (isset($_GET['activ'])) {
	$activ = $_GET['activ'];
}

$connection = \SkeitOl\Connection::getInstance();
$errors = [];

if (isset($activ)) {
	$res = false;
	switch ($activ) {
		case "add":
			if (!$res = $connection->query("INSERT INTO category (name) VALUES ('" . $_POST['category'] . "')")->fetch()) {
				$errors[] = 'Запрос не удался: ' . $connection->getError();
			}
			break;
		case "update":
			if (!$res = $connection->query("UPDATE category SET name='$_POST[name]' WHERE id='$_POST[id]'")->fetch()) {
				$errors[] = 'Запрос не удался: ' . $connection->getError();
			}
			break;
		case "del":
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
			}
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
			}
			
			if (!$res = $connection->query("DELETE FROM category WHERE id='$id'")->fetch()) {
				$errors[] = 'Запрос не удался: ' . $connection->getError();
			}
			break;
	}
	if (!$res) {
		echo implode('<br>', $errors);
	} else {
		echo "Запрос удался.";
	}
}
?>
	<!DOCTYPE>
	<html>
	<head>
		<title>category</title>
		<link rel="shortcut icon" href="../images/s.ico" type="image/x-icon"/>
		<link rel="Stylesheet" type="text/css" href="style.css"/>
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
				.borders {
					border: 1px solid #ccc;
				}

			</style>
			<?php
			echo "<p>Добавление новой записи:</p>";
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
					.activ_a a {
						margin: 0 10px 0 10px;
					}</style>
				<?php
				
				$res = $connection->query("SELECT * FROM category");
				while ($myrow = $res->fetch()) {
					echo "
			<form id='myForm' action='category.php' method='post' class='borders'>
				<input name='activ' type='hidden' style='display:none;' value='update'>
				<input name='id' type='hidden' style='display:none;' value='" . $myrow['id'] . "'>
				<p class='activ_a'>Название: <input type='text' name='name' value='" . $myrow['name'] . "'><input type='submit' value='Изменить'></a><a href='category.php?activ=del&id=" . $myrow['id'] . "'>Удалить</a></p>
			</form>
		";
				}
				?>
				<input name="activ" type="text" style="display:none;" value="add">
			</form>
		</div>
		<!-- END Content-->
	</div>
	<!-- Chose-->
	<script src="chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		var config = {
			'.chosen-select': {},
			'.chosen-select-deselect': {allow_single_deselect: true},
			'.chosen-select-no-single': {disable_search_threshold: 10},
			'.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
			'.chosen-select-width': {width: "95%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
		*/
	</script>
	<!-- End Chose-->
	</body>
	</html>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');