<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/lock.php");

/*Классы для работы*/
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/skeitol/core/ClassAdmin.php");

if (isset($_POST['act'])) {
	$act = $_POST['act'];
	if ($act == '')
		unset($act);
}
if (!isset($act) && isset($_GET['act'])) {
	$act = $_GET['act'];
	if ($act == '') {
		unset($act);
	}
}
if (isset($_POST['tp'])) {
	$tp = $_POST['tp'];
	if ($tp == '') {
		unset($tp);
	}
}
if (!isset($tp) && isset($_GET['tp'])) {
	$tp = $_GET['tp'];
	if ($tp == '')
		unset($tp);
}

$connection = \SkeitOl\Connection::getInstance();

if (isset($_SESSION['step']) && (!empty($_SESSION['step'])))
	$step = $_SESSION['step'];
else $step = 10;
if (isset($_GET['step'])) {
	$step = $_GET['step'];
	$_SESSION['step'] = $step;
}

$admin_class = new ClassAdmin($tp, $db);

//Глобальные настройки
$DEFAULT_AUTHOR = "SkeitOl";

$sys_description = "Панель администратора CMS SkeitOl-Soft";
$sys_keywords = "Панель администратора SkeitOl, SkeitOl - Soft, SkeitOl,CMS SkeitOl Soft";
$sys_pages = "admin";
$sys_pages_print = "Панель администратора";
$sys_title = "Панель администрирования CMS SkeitOl-Soft";
$sys_special_head_text = @'
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="Stylesheet" type="text/css" href="cal.css?01" />
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js?01"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css?01" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css?01">
	 <!-- End Chose-->
	 <script src="script/cal.js?01"></script>
	<link rel="stylesheet" type="text/css" href="/admin/css/style.css?01" />
	<script src="/admin/js/core.js?01"></script>
	';

?>
<?php include('blocks/header.php'); ?>
	<!-- END LEFT block-->
	<!-- LEFT block -->
<?php include('blocks/lefttd.php'); ?>
	<!-- END LEFT block-->
	<!-- Message-->
	<div class="toast-container toast-position-top-right"></div>
	<script src="https://js-hotkeys.googlecode.com/files/jquery.hotkeys-0.7.9.min.js"></script>
	<script type="text/javascript">
		function Msg(m) {
			switch (m) {
				case"1":
					showSuccessToast();
				<?php
				if ($act == 'add') {
					echo "
					if(!document.getElementById('check_link').checked)
					{";
					$sql = "SHOW TABLE STATUS LIKE '$tp'";
					$result = mysql_query($sql);
					$array = mysql_fetch_array($result);
					$ai = $array['Auto_increment'];
					echo "s='index.php?act=update&tp=" . $tp . "&id=" . $ai . "';";
					echo "document.location.href=s;
					}";
				}?>
					break;
				case"-1":
					showErrorToast();
					break;
				case"0":
					showWarningToast();
					break;
				default:
					showErrorToast();
					break;
			}
		}
	</script>
	<script type="text/javascript">
		function Goy(d1) {
			var b = <?=$step?>;
			switch (d1.selectedIndex) {
				case 0:
					b = 10;
					break;
				case 1:
					b = 20;
					break;
				case 2:
					b = 50;
					break;
				case 3:
					b = 100;
					break;
			}
			s =<?php echo "'index.php?act=" . $act . "&tp=" . $tp . "&step='";?>;
			s += b;
			document.location.href = s;
		}
	</script>
	<!-- Content-->
	<div id="content" class="container-sm container-fluid">
		<?php
		//Вывод  краткого списка записей на главной странице
		function PrintShortLinks($num)
		{
			$res = \SkeitOl\Connection::getInstance()->query("SELECT * FROM $num ORDER BY id DESC LIMIT 0,5");
			if ($res) {
				?>
				<table class="table table-striped">
					<thead>
					<tr>
						<th class='align-center' width="10%">ID</th>
						<th>Заголовок</th>
						<th class='align-center' width="10%">Активна</th>
					</tr>
					</thead>
					<tbody>
					<?
					while ($myrow = $res->fetch()) {
						echo "<tr>
							<td class='align-center'>" . $myrow['id'] . "</td>
							<td class='align-left'><a href='index.php?act=update&tp=" . $num . "&id=" . $myrow['id'] . "'>" . strip_tags($myrow['title']) . "</a></td>
							<td class='align-center'><input type='checkbox' disabled='disabled'";
						echo(($myrow['active']) ? "checked" : "");
						echo "></td></tr>";
					}
					?>
					</tbody>
				</table>
				<?
			}
		}
		
		if (!(isset($act) && isset($tp))) {
			?>
			<div class="my-3">
				<h3>Инструменты:</h3>
				<div class="list-group list-group-horizontal-md">
					<a class="list-group-item list-group-item-action" target="_blank" href="/admin/2.php" title="Загрузка файлов">Загрузка
						файлов</a>
					<a class="list-group-item list-group-item-action" target="_blank" href="/admin/create_sitemap_xml.php" title="Генерация sitemap.xml">Генерация
						<span style="color:#000;">sitemap.xml</span></a></li>
					<a class="list-group-item list-group-item-action" href="category.php">Категории[Статьи]</a>
					<a class="list-group-item list-group-item-action" href="/admin/sxd/">Sypex Dumper 2.0.11</a>
					<a class="list-group-item list-group-item-action" href="/admin/cache.php">Cache</a>
				</div>
			</div>
			<div class="my-5 border p-4">
				<?php
				$comments_articles = [];
				
				$allNotApproved = 0;
				if ($res = \SkeitOl\Connection::getInstance()->query("SELECT COUNT(*) FROM comments_articles WHERE APPROVED<>1 ")->fetch()) {
					$allNotApproved = (int)$res['COUNT(*)'];
				}
				
				if ($allNotApproved > 0) {
					$res = \SkeitOl\Connection::getInstance()->query("SELECT ID,TEXT,NICK,DATE_TIME,APPROVED FROM comments_articles WHERE APPROVED<>1 ORDER BY ID DESC LIMIT 0,5");
					while ($item = $res->fetch()) {
						$comments_articles[] = $item;
					}
				}
				?>
				<h2>Новые
					<a href="/admin/comments.php" class="link">комментарии</a><span class="count"><?= $allNotApproved ?></span>
				</h2>
				<?php if ($allNotApproved > 0): ?>
					<table class="table table-striped">
						<thead>
						<tr>
							<th>ID</th>
							<th>Имя</th>
							<th>Текст</th>
							<th>Дата</th>
							<th>Одобрен</th>
						</tr>
						</thead>
						<?php
						foreach ($comments_articles as $key => $myrow) {
							$url = '/admin/comments.php?ID=' . $myrow['ID'];
							echo "<tr>
								<td class='align-center'><a href='$url'>" . $myrow['ID'] . "</a></td>
								<td class='align-center'>" . htmlspecialchars($myrow['NICK']) . "</td>
								<td class='align-center'><a href='$url'>" . htmlspecialchars(substr($myrow['TEXT'], 0, 30)) . "</a></td>
								<td class='align-center'>" . $myrow['DATE_TIME'] . "</td>
								<td class='align-center'><input type='checkbox' disabled='disabled'";
							echo(($myrow['APPROVED']) ? "checked" : "");
							echo "></td>
							</tr>";
						} ?>
					</table>
				<?php endif; ?>
			</div>
			<div class="my-5 border p-4">
				<div class="row">
					<div class="col-lg-6 col-sm-12">
						<h2><a href="index.php?act=update&tp=articles" title="Статьи">Статьи</a></h2>
						<?php PrintShortLinks("articles"); ?>
					</div>
					<div class="col-lg-6 col-sm-12">
						<h2><a href="index.php?act=update&tp=news" title="Новости">Новости</a></h2>
						<?php PrintShortLinks("news"); ?>
					</div>
					<div class="col-lg-6 col-sm-12">
						<h2><a href="index.php?act=update&tp=pages" title="Страницы">Страницы</a></h2>
						<?php PrintShortLinks("pages"); ?>
					</div>
					<div class="col-lg-6 col-sm-12">
						<h2><a href="index.php?act=update&tp=program" title="Программы">Программы</a></h2>
						<?php PrintShortLinks("programm"); ?>
					</div>
				</div>
			</div>
		
		<?php
		}
		else
		{
		$dat = date("d-m-Y");
		echo "<div class='form'>";
		if (!isset($_GET['id'])) {
			echo "
			<p style='float: right;position: relative;right: 0;'>Элементов на странице:
			<select  name='ComboBox1' id='ComboBox1' style='width:60px' onchange='Goy(this);'>
			<option value='10'";
			if ($step == 10)
				echo "selected";
			echo ">10</option>
			<option value='20'";
			if ($step == 20)
				echo "selected";
			echo ">20</option>
			<option value='50'";
			if ($step == 50)
				echo "selected";
			echo ">50</option>
			<option value='100'";
			if ($step == 100)
				echo "selected";
			echo ">100</option>
			</select></p>";
		}
		switch ($tp)
		{
		case 'news':
		case 'articles':
		case 'serials':
		case 'pages':
		switch ($tp) {
			case 'news':
				$GLOBAL_SETTINGS = [
					"DETAIL_PROPERTY_PRINT" => [
						"ELEMENT"       => "Новость",//Элемент
						"ELEMENTS"      => "Новости",//Элементы
						"LIST_ELEMENTS" => "Новостей",//Список
						"ADD_ELEMENT"   => "Новость",//Добавить
						"DEL_ELEMENT"   => "Новость",//Удалить
					],
				];
				break;
			case 'articles':
				$GLOBAL_SETTINGS = [
					"DETAIL_PROPERTY_PRINT" => [
						"ELEMENT"       => "Стаья",//Элемент
						"ELEMENTS"      => "Статьи",//Элементы
						"LIST_ELEMENTS" => "Статей",//Список
						"ADD_ELEMENT"   => "Статью",//Добавить
						"DEL_ELEMENT"   => "Статью",//Удалить
					],
				];
				break;
			case 'pages':
				$GLOBAL_SETTINGS = [
					"DETAIL_PROPERTY_PRINT" => [
						"ELEMENT"       => "Страница",//Элемент
						"ELEMENTS"      => "Страницы",//Элементы
						"LIST_ELEMENTS" => "страниц",//Список
						"ADD_ELEMENT"   => "страницу",//Добавить
						"DEL_ELEMENT"   => "страницу",//Удалить
					],
				];
				break;
		}
		?>
		<?php
		/*Выводим breab*/
		?>
			<div class="div-hierarchy links">
				<a href="/admin/" title="Главная">Главная</a> &gt;
				<a href="/admin/index.php?act=update&tp=<?= $tp ?>"><?= ($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ELEMENTS"]) ?></a>
			</div>
			<?php
		
		switch ($act) {
		case 'add':
			$ai = $connection->query("SHOW TABLE STATUS LIKE '" . $connection->real_escape_string($tp) . "'")->fetch()['Auto_increment'];
			echo "<h3>Добавление новой записи №" . $ai . ":</h3><br>";
			
			$admin_class->PrintFormAddOrEdit($myrow, $id, $tp, $act);
			?>
			<div style='clear:both;'></div>
			<button id='sub' class='save_bth'>Добавить</button>
			<label><input type='checkbox' id='check_link'/>Не уходить со страницы</label>
			<div style='clear:both;'></div>
			<?php
			break;
			case 'del':
				echo "<h3><span id='result'>Удаление записи:</span></h3>
						<form id='myForm' action='add_tp.php' method='post'>";
				include("upload_del.php");
				echo "</form>
							<input id='activ' name='activ' type='text' style='display:none;' value='" . $act . "'>
							<input id='tp' name='tp' type='text' style='display:none;' value='" . $tp . "'>
							<button id='sub2'>Удалить</button>";
				break;
		case 'update':
			?>
			<div class="quick_blok">
				<p>Быстрые действия:</p>
				<ul style="height: 30px;line-height: 30px;">
					<li class="icon list">
						<a href="index.php?act=update&tp=<?= $tp ?>" title="Список <?= mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["LIST_ELEMENTS"]) ?>"><i class="fa fa-lg fa-list"></i></a>
					</li>
					<li class="icon add">
						<a href="index.php?act=add&tp=<?= $tp ?>" title="Добавить <?= mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ADD_ELEMENT"]) ?>"><i class="fa fa-lg fa-plus-square"></i></a>
					</li>
					<li>
						<form class="small_search" action="search.php" method="post" id="form_small_search">
										<span class="toolbar__search">
											<span>
												<input id="search_in_bd" type="text" name="search_in_bd" class="search__input" placeholder="Что ищем?"/>
											</span>
										</span>
							<span class="search__button">
											<button>Поиск</button>
										</span>
							<input type="hidden" name="tp" value="<?= $tp ?>"/>
						</form>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
			<?php
			include_once("blocks/bd.php");
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				if ($id == '') {
					unset($id);
				}
			}
		if (!isset($id)) {
			?><h3><span id='result'>Список записей:</span></h3><?php
			/*навигация*/
			$list = $_GET['list'] ?: 1;
			
			$row = $connection->query('SELECT COUNT(*) as count FROM ' . $connection->real_escape_string($tp))->fetch();
		if ($row['count'] > $step) {
			$i = 1;
			echo "<p id='ComboBox1'>Страница <b>№$list</b></p>";
			?>
			<nav aria-label="Page navigation example">
				<?php
				$n = (int)($row['count'] / $step);
				if ($row['count'] % $step > 0) {
					$n++;
				}
				?>
				<ul class="pagination">
					<li class="page-item<?= ($list == 1) ? ' active' : '' ?>">
						<?php
						if ($list == 1) {
							?>
							<span class="page-link" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</span>
							<?php
						} else {
							?>
							<a class="page-link" href="index.php?act=<?= $act . "&tp=" . $tp . "&list=" . ($list - 1) ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
							<?php
						}
						?>

					</li>
					<?php
					for ($i = 1; $i <= $n; $i++) {
						?>
					<li class="page-item<?= ($i != $list) ? '' : ' active' ?>">
						<?php
						if ($i != $list) {
							echo "<a class=\"page-link\" href=index.php?act=" . $act . "&tp=" . $tp . "&list=" . ($i) . ">" . ($i) . "</a>";
						} else {
							echo "<span class=\"page-link\">" . ($i) . "</span>";
						}
						?></li><?php
					}
					
					
					?>
					<li class="page-item<?= ($list == $n) ? ' active' : '' ?>">
						<?php
						if ($list == $n) {
							echo "<span class=\"page-link\">";
						} else {
							echo "<a class=\"page-link\" href=index.php?act=" . $act . "&tp=" . $tp . "&list=" . ($list + 1) . " aria-label=\"Next\">";
						}
						?>
						<span aria-hidden="true">&raquo;</span>
						<?php
						if ($list == $n) {
							echo '</span>';
						} else {
							echo '</a>';
						}
						?>
					</li>
				</ul>
			</nav>
			<?php
		}
			
			/**/
			/*Список по $step*/
			
			$startI = 0;$endI = $step - 1;
			if (isset($list)) {
				if ($list <= 0) {
					echo "Нет такой страницы!!!<br>Вывод первой страницы";
				} else {
					$startI = ($list - 1) * $step;
					$endI = $startI + $step;
				}
			}
			$res = $connection->query("SELECT id,title,date FROM $tp ORDER BY id DESC LIMIT $startI,$endI");
			$i = 1;
			?>
			<form action="add_tp.php" method="post">
				<input type="hidden" name="tp" value="<?= $tp ?>"/>
				<table class='table'>
					<thead>
					<tr>
						<th width="10%"></th>
						<th width="15%"><b>ID</b></th>
						<th width='15%'><b>Дата</b></th>
						<th width="60%"><b>Заголовок</b></th>
					</tr>
					</thead>
					<tbody>
					<?php
					
					while ($myrow = $res->fetch()) {
						echo "<tr>
												<td><input type='checkbox' name='items[]' value='" . $myrow['id'] . "'></td>
												<td>" . $myrow['id'] . "</td>
												<td>" . date_format(date_create($myrow['date']), 'd-M-Y H:i') . "</td>
												<td class='table-left-text links'><a href='index.php?act=update&tp=$tp&id=" . $myrow['id'] . "'>" . strip_tags($myrow['title']) . "</a></td>
											</tr>";
						$i++;
					}
					?>
					</tbody>
				</table>
				<p>
					<input type="submit" name="edit_items" class="btn save_bth btn-success" value="Редактировать"/>
					<input type="submit" name="delet_items" class="btn btn-danger" value="Удалить" onclick="if(confirm('Удалить безвозвратно?')) return true; else return false;"/>
				</p>
			</form>
		
		<?php
		}
		else {
			$myrow = $connection->query("SELECT * FROM $tp WHERE id=$id")->fetch();
			?>
			<?php
			if (!empty($myrow['url']))
				$url_page = $myrow['url']; else $url_page = $myrow['id'];
			echo "<p><a href='../$tp/" . $url_page . "/' target='_blank'>" . ($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ELEMENT"]) . "</a> № " . $myrow['id'] . "</p><br>";
			
			$admin_class->PrintFormAddOrEdit($myrow, $id, $tp, $act);
			
			?>
			
			<?php
		}
		break;
		default:
			echo "Неизвестный запрос. =(";
			break;
		}
		break;
		/////////////////////////
		case 'programm':
		case 'program':
		switch ($act)
		{
		case 'add':
			print <<<ADD
							<p><span id='result'>Добавление новой записи:</span></p>
								<form id="myForm" action="program_add.php" method="post">
									<p><b>Заголовок:</b>
									<textarea  name="title" cols="60" rows="2"></textarea></p>
									<p><b>Дата:</b><input name="date" id="calendar" type="text" value="$dat" /></p>
									<p><b>Краткое описание с тегами:</b><br/><textarea name="description" id="description" cols="60" rows="5"></textarea></p>
									<p><b>Полное описание с тэгами:</b><br/><textarea name="text" cols="60" rows="15"></textarea></p>
									<p><b>Автор:</b><input type="text" name="author" /></p>
								</form>
								<button id='sub'>Добавить</button>
								<script type="text/javascript">
									
									 $("#sub").click(function () {
									$("#result").html("Сохранение данных...");
									$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { $("#result").html(info); });
									clearInput();
								});
								$("#myForm").submit(function () {
									return false;
								});
								function clearInput() {
									//$("#myForm :input").each(function () {
									  //  $(this).val('');
									//});
								}
									</script>
ADD;
			break;
		case 'del':
			echo "<p><span id='result'>Удаление записи:</span></p>
						<form action='program_del.php' method='post'>";
			include("blocks/bd.php");
			$result = mysql_query("SELECT title,id FROM programm");
			$myrow = mysql_fetch_array($result);
			do {
				printf("<p><input name='id' type='radio' value='%s'><label>%s</label></input></p>", $myrow['id'], $myrow['title']);
			} while ($myrow = mysql_fetch_array($result));
			echo "<p> <input name='submit' type='submit' value='Удалить урок' /></p>";
			break;
		case 'update':
		include("blocks/bd.php");
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			if ($id == '') {
				unset($id);
			}
		}
		if (!isset($id))
		{
			$result = mysql_query("SELECT title,id FROM programm");
			$myrow = mysql_fetch_array($result);
			do {
				printf("<p><a href='index.php?act=update&tp=program&id=%s'>%s</a></p>", $myrow['id'], $myrow['title']);
			} while ($myrow = mysql_fetch_array($result));
		}
		else
		{
		$result = mysql_query("SELECT * FROM programm WHERE id=$id");
		$myrow = mysql_fetch_array($result);
		?>
			<p><span id='result'>Редактирование записи:</span></p>
			<form id="myForm" action="program_upload.php" method="post">
				<p> Заголовок:
					<textarea name="title" cols="60" rows="2"><?= $myrow['title'] ?></textarea></p>
				<p>Дата:
					<input name="date" id="calendar" type="text" value="<?= $myrow['date'] ?>"/></p>
				<p>Краткое описание с тегами:<br/>
					<textarea name="description" id="description" cols="60" rows="5"><?= $myrow['description'] ?></textarea>
				</p>
				<p>Полное описание с тэгами:<br/>
					<textarea name="text" cols="60" rows="15"><?= $myrow['text'] ?></textarea></p>
				<p>Автор:
					<input type="text" name="author" value="<?= $myrow['url'] ?>"/></p>
				<input value="<?= $myrow['id'] ?>" type="hidden" name="id"/>
			</form>
			<button id='sub'>Сохранить изменения</button>
			<script type="text/javascript">
				$("#myForm").submit(function () {
					return false;
				});
			</script>
			<?php
		}
			break;
			default:
				echo "<h3>Неизвестный запрос.</h3>";
				break;
		}
			break;
			default:
				echo "<h3>Неизвестный запрос.</h3>";
				break;
		}
			echo "</div>";
		} ?>
	</div>
	<!-- END Content-->
	</div>

	<script type="text/javascript">
		function Save_Page() {
			$("#myForm").submit();
			/*showNoticeToast();
				$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
					Msg(info);});*/
		}

		/* OLD Upload
				$("#sub").click(function () {
					showNoticeToast();
					$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
						Msg(info);
		
					});
				});
		 */
		$(document).ready(function (e) {
			$("#myForm").on('submit', (function (e) {
				e.preventDefault();
				showNoticeToast();
				$.ajax({
					url: $(this).attr('action'), // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData: false,        // To send DOMDocument or non processed data file it is set to false
					success: function (data)   // A function to be called if request succeeds
					{
						Msg(data);
						/* $('#loading').hide();
						 $("#message").html(data);*/
					}
				});
				return false;
			}));
		});

		$("#sub2").click(function () {
			showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
				Msg(info);
				if (info == "1") {
					//location.reload();
					$.ajax({
						type: "POST",
						url: "upload_del.php",
						//cache: false,
						data: {tp: $("#tp").val(), activ: $("#activ").val()},
						success: function (html) {
							$("#myForm").html(html);
						}
					});
				}
			});
		});
	</script>
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
	</script>
	<!-- End Chose-->
	<!--Fancybox-->
	<link rel="stylesheet" href="/admin/fancybox/jquery.fancybox.css">
	<script src="/admin/fancybox/jquery.fancybox.js" type="text/javascript"></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/blocks/footer.php'); ?>