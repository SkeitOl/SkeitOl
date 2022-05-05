<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/lock.php");

$connection = \SkeitOl\Connection::getInstance();
$myrow = [];
$tp = $connection->real_escape_string($_POST["tp"]);
$search_in_bd = $connection->real_escape_string($_POST["search_in_bd"]);
if (!empty($_POST["search_in_bd"]) && $tp) {


	$search_column = $_POST["search_column"] ? $connection->real_escape_string($_POST["search_in_bd"]) : 'title';

	$res = $connection->query("SELECT id,url,title FROM $tp WHERE $search_column LIKE '%$search_in_bd%'");
	if ($res) {
		while ($item = $res->fetch()) {
			$myrow[] = $item;
		}
	}
	?>
	<link rel="stylesheet" href="/admin/style.css">
	<link rel="stylesheet" href="/admin/css/style.css">
	<style>
		.search_table {
			font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
			font-size: 14px;
			background: white; /*max-width: 70%;/*width: 70%;*/
			border-collapse: collapse;
			text-align: left;
		}

		.search_table th {
			font-weight: normal;
			color: #039;
			border-bottom: 2px solid #6678b1;
			padding: 10px 8px;
		}

		.search_table td {
			border-bottom: 1px solid #ccc;
			color: #669;
			padding: 9px 8px;
			transition: .3s linear;
		}

		.search_table tr:hover td {
			background: #e8edff;
		}

		.search_table a {
			color: #3E3E3E;
			text-decoration: none;
		}

		.search_table a:hover {
			text-decoration: underline;
		}

		.quick_blok.search_in_page {
			width: 100%
		}

		.quick_blok.search_in_page p {
			border: none;
		}

		.search_in_page #search_in_bd {
			width: 80%;
			box-sizing: border-box;
		}
	</style>
	<div id="content">
	<h1>Поиск в БД</h1>
	<div class="quick_blok search_in_page">
		<form action="" method="post" class="">
			<p>Поисковая строка</p>
			<input type="text" id="search_in_bd" name="search_in_bd" value="<?= $search_in_bd ?>">
			<p>Таблица</p>
			<input type="text" name="tp" value="<?= htmlspecialchars($tp) ?>">
			<p>Поле</p>
			<select name="search_column">
				<?php
				$res = $connection->query('SHOW COLUMNS FROM articles');
				if ($res) {
					while ($row2 = $res->fetch()) {
						?>
						<option value="<?= $row2['Field'] ?>" <?php if ($search_column == $row2['Field'])
							echo 'selected' ?>><?= $row2['Field'] . " (" . $row2['Type'] . ")" ?></option><?php
					}
				}
				?>
			</select>
			<br><br><input type="submit" name="" value="Поиск" class="save_bth">
		</form>
	</div>
	<p>Результат:</p>
	<?php
	if ($myrow) {
		?>
		<table class="search_table">
			<thead>
			<tr>
				<th>№</th>
				<th>ID</th>
				<th>TITLE</th>
			</tr>
			</thead>
			<?php
			$k = 1;
			foreach ($myrow as $row) {
				?>
				<tr>
					<td><?= ($k++) ?></td>
					<td><?= ($row['id']) ?></td>
					<td>
						<a href="/admin/index.php?act=update&tp=<?= $tp ?>&id=<?= ($row['id']) ?>" target="_blank"><?= strip_tags($row['title']) ?></a>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	} else {
		?>
		<p>По вашему запросу не найдено записей в БД.<p>
		<?php
	}
}
?>
	</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/blocks/footer.php'); ?>