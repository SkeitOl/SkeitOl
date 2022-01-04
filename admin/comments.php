<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include_once 'lock.php';

if (isset($_GET['ID'])) {
	$ID = (int)$_GET['ID'];
} else {
	$ID = 0;
}

$sys_description = "Просмотр и редактирование информации о пользователе";
$sys_keywords = "SkeitOl, полльзователь SkeitOl,SkeitOl CMS";
$sys_pages = "users";
$sys_pages_print = "Пользователь ";
$sys_title = "Страница пользователя ";
$sys_h1 = 'Комментарии';

$errors = [];
$arArticle = [];
$MES = trim($_REQUEST['MES']);

global $PAGINATION;

$PAGINATION[] = [
	'text' => 'Комментарий',
	'href' => 'comments.php',
];

if (($ID > 0) && $arArticle = \SkeitOl\Connection::getInstance()->query("SELECT * FROM comments_articles where ID=" . $ID)->fetch()) {
	$sys_title = $sys_h1 = 'Комментарий №' . $ID;
	$PAGINATION[] = [
		'text' => 'Комментарий №' . $ID
	];
}
if ($_GET['ID'] && $ID > 0 && !$arArticle) {
	$errors[] = 'Нет такого комментария';
}


if (!empty($_POST)) {
	
	//Удалить записи
	if (!empty($_POST['delete'])) {
		$ID_ITEMS = $_POST['ID'];
		if (!$ID_ITEMS) {
			header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
			die();
		}
		$ID_ITEMS = (array)$ID_ITEMS;
		$connection = \SkeitOl\Connection::getInstance();
		
		foreach ($ID_ITEMS as $key => $value) {
			$value = (int)$value;
			$res = $connection->query("DELETE FROM comments_articles where ID=$value");
			if (!$res->fetch()) {
				$errors[] = 'Не удалось удалить. ' . $connection->getError();
			}
		}
		
		
		if (!$errors) {
			$mes = '';
			if (count($ID_ITEMS) > 1) {
				$mes = "Комментарии " . implode(',', $ID_ITEMS) . " удалены";
			} else {
				$mes = "Комментарий {$ID_ITEMS[0]} удален";
			}
			header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php?MES=" . urlencode($mes));
			include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
		}
	}
	
	//Одобрить записи
	if (!empty($_POST['CHANGE_APPROVED_TRUE'])) {
		$ID_ITEMS = $_POST['ID'];
		if (!$ID_ITEMS) {
			header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/comments.php");
			include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
		}
		$ID_ITEMS = (array)$ID_ITEMS;
		
		foreach ($ID_ITEMS as $key => $id) {
			$id = (int)$id;
			$q = "UPDATE comments_articles SET APPROVED='1' where ID=$id";
			$result = $connection->query($q)->fetch();
			if (!$result) {
				$errors[] = 'Не удалось изменить. ' . $connection->getError();
			}
		}
		if (!$errors) {
			$mes = '';
			if (count($ID_ITEMS) > 1) {
				$mes = "Комментарии " . implode(',', $ID_ITEMS) . " одобрены";
			} else {
				$mes = "Комментарий {$ID_ITEMS[0]} одобрен";
			}
			$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			header("Location: $url?MES=" . urlencode($mes));
			include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
		}
	}
	
	//Возможно нужно перезаписать
	if (!empty($_POST['edit'])) {
		
		$ID_ITEMS = $_POST['ID'];
		
		$connection = \SkeitOl\Connection::getInstance();
		
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$NICK = $connection->real_escape_string($_POST['NICK']);
		$TEXT = $connection->real_escape_string($_POST['TEXT']);
		$DATE_TIME = $connection->real_escape_string($_POST['DATE_TIME']);
		$SRC_IMG = $connection->real_escape_string($_POST['SRC_IMG']);
		$DEPTH_LEVEL = (int)$_POST['DEPTH_LEVEL'];
		$APPROVED = $_POST['APPROVED'] == '1' ? 1 : 0;
		
		
		$ID_ITEMS = (array)$ID_ITEMS;
		
		foreach ($ID_ITEMS as $key => $id) {
			$id = (int)$id;
			$q = "UPDATE comments_articles SET NICK='$NICK', TEXT='$TEXT', DATE_TIME='$DATE_TIME', APPROVED='$APPROVED', SRC_IMG='$SRC_IMG', DEPTH_LEVEL='$DEPTH_LEVEL' where ID=$id";
			$result = $connection->query($q)->fetch();
			if (!$result) {
				$errors[] = 'Не удалось изменить. ' . $connection->getError();
			}
		}
		if (!$errors) {
			$arArticle = \SkeitOl\Connection::getInstance()->query("SELECT * FROM comments_articles where ID=" . $ID)->fetch();
			$MES = "Данные были успешно обновлены";
		}
		
	}
}

$sys_special_head_text = @'
	<link rel="Stylesheet" type="text/css" href="cal.css?01" />
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js?01"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css?01" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css?01">
	 <!-- End Chose-->
	 <script src="script/cal.js?01"></script>
	 <script type="text/javascript">
		$(document).ready(function(){
		$("#calendar").simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
		});
	</script>
	<script>
		$(document).ready(function() {
			//Когда страница загружается...
			$(".tab_content").hide(); //Скрыть весь контент
			$("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
			$(".tab_content:first").show(); //Показать контент первой вкладки
			//Событие по клику
			$("ul.tabs li").click(function() {
				$("ul.tabs li").removeClass("active"); //Удаление любого "active" класса
				$(this).addClass("active"); //Добавление "active" класса на активную вкладку
				$(".tab_content").hide(); //Скрыть контент вкладок
				var activeTab = $(this).find("a").attr("href"); //Найти href значение атрибута для выявления активной вкладки и контента
				$(activeTab).fadeIn(); //Fade in контента с активным ID
				return false;
			});
		});
		//блокировка Ctr+s
		$(document).bind("keydown", function(e) {
		  if(e.ctrlKey && (e.which == 83)) {
			e.preventDefault();
			{
				//alert("Ctrl+S");
				Save_Page();
			}
			return false;
		  }
		});
		
		//Вставка html в richtextbox
		function add_html_box(char) {
			var textarea = document.getElementById("text-box");
			switch (char) {
				case "b": textarea.value += "<b></b>"; break;
				case "p": textarea.value += "<p></p>"; break;
				case "img": textarea.value += "<img src=\'\'/>"; break;
				case "a": textarea.value += "<a href=\'\'></a>"; break;
				case "a-out": textarea.value += "<a href=\'\' target=\'_blank\' class=\'link-out\'></a>"; break;
				case "h1": textarea.value += "<h1></h1>"; break;
				case "h2": textarea.value += "<h2></h2>"; break;
				case "h3": textarea.value += "<h3></h3>"; break;
			}
		}
	</script>
	';

include_once('blocks/header.php');
?>
	<div id="content" class="container">
		<div class="col">
			<div class="row">
				<style>
					.small-table {
						width: 100%;
					}

					.users_cart {
						box-shadow: 0 1px 8px #9b9a9a;
						padding: 2%;
						max-width: 500px;
						margin: 2% auto;
					}

					.users_cart p {
						margin: 2% 0 !important;
					}

					.users_cart label {
						width: 150px;
						display: inline-block;
						text-align: right;
						margin: 3px 3px 3px 0;
						vertical-align: top;
					}

					.users_cart input[type='text'], .users_cart input[type='email'] {
						height: 1.9rem;
						line-height: 1.9rem;
						padding: 0.2rem 0.5rem;
						border: 1px solid #aaa;
						outline: none;
					}

					.users_cart input[type='text']:focus, .users_cart input[type='email']:focus,
					.users_cart input[type='text']:active, .users_cart input[type='email']:active {
						box-shadow: 0 0 5px #FFE000 !important;
						border: 1px solid #EADD36 !important;
						background: #fff !important;
					}

					.users_cart input[type='text']:hover, .users_cart input[type='email']:hover {
						border: 1px solid #EADD36 !important;
						box-shadow: none !important;
						background: #fff;
					}

					#old_password:focus:invalid, .users_cart input[type='text']:focus:invalid, .users_cart input[type='email']:focus:invalid {
						background: #fff url('https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/invalid.png') no-repeat 98% center;
						box-shadow: 0 0 5px #d45252;
						border-color: #b03535;
					}

					.users_cart input[type='text']:required:valid, .users_cart input[type='text']:required:valid {
						background: #fff url(https://webdesigntutsplus.s3.amazonaws.com/tuts/214_html5_form_validation/demo/images/valid.png) no-repeat 98% center;
						box-shadow: 0 0 2px #5CD053;
						border-color: #5CD053;
					}

					.old_password {
						display: none;
					}

					.com_text {
						min-width: 285px;
						min-height: 75px;
						margin: 0
					}

					.small-table .input_text {
						padding: 5px 10px;
						margin: 8px 0;
						box-sizing: border-box;
						width: 100%
					}
				</style>
				<div class="">
					<h1 class="pb-4"><?= $sys_h1 ?></h1>
					<?php
					
					//вывод ошибок
					if ($errors) {
						foreach ($errors as $error) {
							?>
							<div class="alert alert-danger" role="alert"><?= $error ?></div>
							<?php
						}
					}
					
					//вывод успешного сообщения
					if ($MES) {
						?>
						<div class="alert alert-success" role="alert"><?= htmlspecialchars($MES) ?></div><?php
					}
					
					
					if (!empty($ID)) {
						//Вывод элемента
						if ($arArticle) {
							?>
							<div class="border rounded-3 row py-3 bg-white">
								<div class="col">
									<form action="" class="row g-3 " method="post">
										<input type="hidden" name="ID" value="<?= $arArticle['ID'] ?>">
										<div class="col-md-12">
											<div class="form-check">
												<input type="hidden" name="APPROVED" style="display:none" value="0">
												<input class="form-check-input" type="checkbox" id="input-APPROVED" name="APPROVED" <?php
												echo(($arArticle['APPROVED']) ? "checked" : ""); ?> type='checkbox' value="1">
												<label class="form-check-label" for="input-APPROVED">Одобрен</label>
											</div>
										</div>
										<div class="col-md-4">
											<label for="input-DATE_TIME" class="form-label">Дата</label>
											<input class="form-control" type="text" id="input-DATE_TIME" name="DATE_TIME" value="<?= $arArticle['DATE_TIME'] ?>">
										</div>
										<div class="col-md-4">
											<label for="inputName" class="form-label">Имя</label>
											<input class="form-control" type="text" id="inputName" name="NICK" value="<?= $arArticle['NICK'] ?>">
										</div>
										<div class="col-md-4">
											<label for="input-EMAIL" class="form-label">E-mail</label>
											<input class="form-control" type="email" id="input-EMAIL" name="EMAIL" value="<?= $arArticle['EMAIL'] ?>">
										</div>
										<div class="col-12">
											<label for="inputTEXT" class="form-label">Текст</label>
											<textarea id="inputTEXT" class="form-control" name="TEXT" rows="8"><?= htmlspecialchars($arArticle['TEXT']) ?></textarea>
										</div>
										<div class="col-12">
											<label for="input-SRC_IMG" class="form-label">SRC img</label>
											<input class="form-control" type="text" id="input-SRC_IMG" name="SRC_IMG" value="<?= $arArticle['SRC_IMG'] ?>">
										</div>

										<div class="col-md-6">
											<label for="input-DEPTH_LEVEL" class="form-label">DEPTH_LEVEL</label>
											<input class="form-control" type="text" id="input-DEPTH_LEVEL" name="DEPTH_LEVEL" value="<?= $arArticle['DEPTH_LEVEL'] ?>">
										</div>
										<div class="col-md-6">
											<label for="input-ID_ARTICLES" class="form-label"><a href="/admin/index.php?act=update&tp=articles&id=<?= $arArticle['ID_ARTICLES'] ?>" target='_blank'>ID_ARTICLES</a></label>
											<input class="form-control" type="text" id="input-ID_ARTICLES" name="ID_ARTICLES" value="<?= $arArticle['ID_ARTICLES'] ?>">
										</div>

										<div class="col-12">
											<div class="row  justify-content-between">
												<div class="col">
													<input class="btn btn-success save_bth" type="submit" name="edit" value="Изменить">
												</div>
												<div class="col-auto">
													<input class="btn btn-danger del_bth" type="submit" name="delete" value="Удалить">
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<?php
						}
					} else {
						//Вывод элементов
						
						$sFilter = [];
						$arFilter = [
							'APPROVED' => [
								'NAME'  => 'APPROVED',
								'TEXT'  => 'Одобренность',
								'ITEMS' => [
									['TEXT' => 'Только одобренные', 'VALUE' => 1],
									['TEXT' => 'Только не одобренные', 'VALUE' => 0]
								]
							]
						];
						?>
						<form action="/admin/comments.php">
							<p>Фильтр</p>
							<?php
							foreach ($arFilter as $key => $arItem) {
								$inputName = "filter-$key";
								?>
								<div class="mb-3">
									<select name="<?= $inputName ?>" class="form-select" aria-label="<?= $arItem['TEXT'] ?>">
										<option value="" selected>Все</option>
										<?php
										foreach ($arItem['ITEMS'] as $ITEM) {
											$selected = isset($_REQUEST[$inputName]) ? (string)$ITEM['VALUE'] === (string)$_REQUEST[$inputName] : false;
											?>
											<option value="<?= $ITEM['VALUE'] ?>"<?= $selected ? ' selected' : '' ?>><?= $ITEM['TEXT'] ?></option><?php
										}
										?>
									</select>
								</div>
								<?php
							}
							?>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
						
						<?
						require_once($_SERVER["DOCUMENT_ROOT"] . "/skeitol/core/Core.php");
						$cl = new \SkeitOl\Core();
						
						
						if (isset($_GET['list'])) {
							$list = htmlspecialchars($_GET['list']);
						} else {
							$list = 1;
						}
						$step = 9;
						$startI = 0;
						$endI = $step - 1;
						
						if (isset($list)) {
							if ($list <= 0) {
								echo "Нет такой страницы!!!<br>Вывод первой страницы";
							} else {
								$startI = ($list - 1) * $step;
								$endI = $startI + $step;
							}
						}
						
						$filter = [];
						$sTempFilter = [];
						if ($_REQUEST) {
							foreach ($_REQUEST as $key => $value) {
								if (substr($key, 0, 7) === 'filter-' && strlen($value) > 0) {
									$filter[substr($key, 7)] = $value;
									$sTempFilter[$key] = $value;
								}
							}
						}
						
						$sFilter = $sTempFilter ? http_build_query($sTempFilter) : '';
						unset($sTempFilter);
						
						$res = $cl->GetList("comments_articles", [
							"filter" => $filter,
							"order"  => ["id" => "DESC"],
							"limit"  => ["top" => $startI, "bottom" => $endI]
						]);
						while ($item = $res->fetch()) {
							$arComments[] = $item;
						}
						
						$special_sort = '';
						if (!empty($sort)) {
							$special_sort = '?sort=' . $sort["NAME"];
						}
						if ($sFilter) {
							if (!$special_sort) {
								$special_sort = '?' . $sFilter;
							} else {
								$special_sort .= '&' . $sFilter;
							}
						}
						
						?>
						<form action="/admin/comments.php<?= $special_sort ?>" method="post">
							<table class="table">
								<thead>
								<tr>
									<th></th>
									<th>ID</th>
									<th>Имя</th>
									<th>Текст</th>
									<th>Дата</th>
									<th>IDitem</th>
									<th>Одобрен</th>
									<th>IP</th>
								</tr>
								</thead>
								<?php
								
								
								// $result = mysql_query("SELECT * FROM comments_articles ORDER BY ID DESC", $db);
								//$myrow = mysql_fetch_array($result);
								//do
								foreach ($arComments as $myrow) {
									?>
									<tr>
									<td><input type="checkbox" name="ID[]" value="<?= $myrow['ID'] ?>"></td>
									<td><a href='/admin/comments.php?ID=<?= $myrow['ID'] ?>'><?= $myrow['ID'] ?></a>
									</td>
									<td class='align-center'><?= $myrow['NICK'] ?></td>
									<td class='align-center'><a
												href='/admin/comments.php?ID=<?= $myrow['ID'] ?>'><?= htmlspecialchars(substr($myrow['TEXT'], 0, 150)) ?></a>
									</td>
									<td class='align-center'><?= $myrow['DATE_TIME'] ?></td>
									<td class='align-center'><?= $myrow['ID_ARTICLES'] ?></td>
									<td class='align-center'><input type='checkbox' disabled='disabled'
											<?php echo(($myrow['APPROVED']) ? "checked" : ""); ?>></td>
									<td class='align-center'><?= $myrow['IP'] ?></td>
									</tr><?php
								}
								//while ($myrow = mysql_fetch_array($result));
								
								//Вывод списка
								$res = $cl->GetList("comments_articles", [
									'select' => ['COUNT(*)'],
									"filter" => $filter,
								])->fetch();
								
								$countAll = $res && $res['COUNT(*)'] ? $res['COUNT(*)'] : 0;
								if ($countAll > $step) {//"Записей больше".$step;
									$page_url = "/admin/comments.php";
									$i = 1;
									
									
									?><p class="no-text-indent">Всего записей: <?= $countAll ?><br>Страница
									№<?= $list ?>
									</p>
									<nav aria-label="Page navigation example">
										<ul class="pagination">
											<?php
											if ($list == 1) {
												echo '<li class="page-item active">';
												?>
												<span class="page-link active disabled"><span aria-hidden="true">&laquo;</span></span>
												<?php
											} else {
												echo '<li class="page-item">';
												$href = $page_url;
												if ($list - 1 > 1) {
													$href = "?list=" . ($list - 1);
												}
												if ($special_sort) {
													$href .= '?' . substr($special_sort, 1);
												}
												?>
											<a class="page-link" href="<?= $href . "\" data-list=" . ($list - 1) ?>" aria-label="Previous">
													<span aria-hidden="true">&laquo;</span></a><?php
											}
											echo '</li>';
											
											$n = (int)($countAll / $step);
											if ($countAll % $step > 0) {
												$n++;
											}
											for ($i = 1; $i <= $n; $i++) {
												$active = $i == $list;
												$href = '';
												
												if (!$active) {
													$href = $page_url;
													if ($i > 1) {
														$href = "?list=" . ($i);
													}
													if ($special_sort) {
														$href .= $special_sort;
													}
												}
												
												echo '<li class="page-item' . ($active ? ' active' : '') . '">';
												if (!$active) {
													echo "<a href='" . $href . "' data-list='" . ($i) . "' class='page-link ajax_nav_links'>" . ($i) . "</a>";
												} else {
													echo "<span class='page-link no-link'>" . ($i) . "</span>";
												}
												echo '</li>';
											}
											
											
											if ($list == $n) {
												echo '<li class="page-item active">';
												?>
												<span class="page-link disabled"><span aria-hidden="true">&raquo;</span></span>
												<?php
											} else {
												echo '<li class="page-item ">';
												$href = "?list=" . ($list + 1);
												if ($special_sort) {
													$href .= $special_sort;
												}
												
												
												?>
											<a class="page-link" href="<?= $href . "\" data-list=\"" . ($list - 1) ?>" aria-label="Next">
													<span aria-hidden="true">&raquo;</span></a><?php
											}
											echo '</li>';
											
											?>
										</ul>
									</nav>
									<?php
								}
								?>
							</table>
							<div class="m-b-10 m-t-10">
								<input class="btn btn-danger btn_delete" type="submit" name="delete" value="Удалить выделенное"
									   onclick="if(!confirm('вы уверены что хотите удалить элементы?'))return false;">
								<input class="btn btn-info btn_save" type="submit" name="CHANGE_APPROVED_TRUE" value="Одобрить выделенное">
							</div>
						</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php
include('blocks/footer.php');