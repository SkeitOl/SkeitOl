<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/lock.php");

$connection = \SkeitOl\Connection::getInstance();

$tp = $connection->real_escape_string($_POST['tp']);

/* list */
if ($_POST['items'] && $tp && !empty($_POST['delet_items'])) {
	$result = false;
	$items = (array)$_POST['items'];
	$n = count($items);
	for ($i = 0; $i < $n; $i++) {
		$id = (int)$items[$i];
		if ($id > 0) {
			$result = $connection->query("DELETE FROM $tp WHERE id='" . $id . "'")->fetch();

		}
	}

	if ($result) {
		header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?act=update&tp=$tp");
		\SkeitOl\CPHPCache::clearDir('/' . $tp);
	} else {
		echo "-1";
		$message = 'Неверный запрос: ' . $connection->getError();
		echo $message;
	}
}
/* element */
if (isset($_POST['activ'])) {
	if ($_POST['activ'] === "del") {
		if (isset($_POST['id'])) {
			$_POST['id'] = (array)$_POST['id'];
			foreach ($_POST['id'] as $key => $value) {
				$value = (int)$value;
				if ($value) {
					$result = $connection->query("DELETE FROM $tp WHERE id='" . $value . "'");
				}
			}
			if ($result == 'true') {
				echo "1";
				\SkeitOl\CPHPCache::clearDir('/' . $tp);
			} else {
				echo "-1";
			}
		} else echo "0";
	} else {
		$fields = [];

		$fields['title'] = $connection->real_escape_string($_POST['title']);
		$fields['description'] = $connection->real_escape_string($_POST['description']);
		$fields['text'] = $connection->real_escape_string($_POST['text']);
		$fields['author'] = $connection->real_escape_string($_POST['author']);
		$fields['url'] = $connection->real_escape_string($_POST['url']);
		$fields['date'] = $connection->real_escape_string($_POST['date']);
		$fields['meta_title'] = $connection->real_escape_string($_POST['meta_title']);
		$fields['meta_description'] = $connection->real_escape_string($_POST['meta_description']);
		$fields['meta_keywords'] = $connection->real_escape_string($_POST['meta_keywords']);
		$fields['src_preview'] = $connection->real_escape_string($_POST['src_preview']);
		$fields['views'] = $connection->real_escape_string($_POST['views']);

		$fields['active'] = 0;
		if (!empty($_POST['active_p'])) {
			$fields['active'] = 1;
		}

		$id = (int)$_POST['id'];


		if ($tp && $fields['title']) {

			if ($tp === 'articles') {
				$string = '';
				if (count($_POST['category_m']) > 0) {
					$array = [];
					$i = 0;
					foreach ($_POST['category_m'] as $key => $value) {
						$array[$i] = $connection->real_escape_string($value);
						$i++;
					}
					$string = serialize($array);
				}
				$fields['category'] = $string;
			}


			if (!empty($_POST['RECOMMENDATIONS'])) {
				if (is_array($_POST['RECOMMENDATIONS'])) {
					foreach ($_POST['RECOMMENDATIONS'] as $key => $value) {
						if (empty($value)) {
							unset($_POST['RECOMMENDATIONS'][$key]);
						}
					}
					if (count($_POST['RECOMMENDATIONS']) > 0) {
						$RECOMMENDATIONS = serialize($_POST['RECOMMENDATIONS']);
					} else {
						$RECOMMENDATIONS = '';
					}

				} else {
					$RECOMMENDATIONS = htmlspecialchars($_POST['RECOMMENDATIONS']);
				}
				$fields['RECOMMENDATIONS'] = $RECOMMENDATIONS;
			}

			if ($_POST['activ'] === "update" && $id > 0) {
				/**
				 * Добавление элемента.  UPDATE
				 */
				//рекомендации

				//Нужно ли удалить прошлый превью файл
				if (!empty($_POST['clear_preview'])) {
					$fields['src_preview'] = '';
				}
				if (!empty($_POST['del_old_src_preview'])) {
					unlink($_SERVER['DOCUMENT_ROOT'] . $_POST['del_old_src_preview']);
				}
				/*
				 * Проверяем, есть ли файлы.
				 * Пытаемся их загрузить и если всё успешно, то сохранить
				 */
				if ($_FILES['img_preview']) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/images/" . $tp . "/" . $id . "/";
					if (!file_exists($uploaddir) && !mkdir($uploaddir) && !is_dir($uploaddir)) {
						throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploaddir));
					}

					$uploadfile = $uploaddir . basename($_FILES['img_preview']['name']);
					if (is_uploaded_file($_FILES['img_preview']['tmp_name']) && move_uploaded_file($_FILES['img_preview']['tmp_name'], $uploadfile)) {
						$fields['src_preview'] = (str_replace($_SERVER['DOCUMENT_ROOT'], "", $uploadfile));
					}
				}
				//Дата последнего обновления TIMESTAMP_X
				$fields['TIMESTAMP_X'] = date("Y-m-d H:i:s");

				$s = '';
				foreach ($fields as $key => $value) {
					$s .= ", $key='$value'";
				}
				$s = substr($s, 2);

				$result = $connection->query("UPDATE $tp SET $s WHERE id='$id'");

			} elseif ($_POST['activ'] == "add") {
				/**
				 * Добавление элемента.  ADD
				 */
				$upload_file_src = '';

				if (count($_FILES['filename']['name']) > 0) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/images/";
					if (isset($_REQUEST['uploaddir']))
						$uploaddir = $uploaddir . $_POST['uploaddir'] . "/";
					if (!file_exists($uploaddir))
						@mkdir($uploaddir);

					$Error = '';

					foreach ($_FILES['filename']['name'] as $k => $f) {
						//if (!$_FILES['filename']['error'][$k])
						if (is_uploaded_file($_FILES['filename']['tmp_name'][$k])) {
							if (move_uploaded_file($_FILES['filename']['tmp_name'][$k], $uploaddir . $_FILES['filename']['name'][$k])) {
								$url = str_replace($_SERVER['DOCUMENT_ROOT'], "", $uploaddir . $_FILES['filename']['name'][$k]);
								$upload_file_src = $url;
							} else $Error .= 'Error upload file: ' . $_FILES['filename']['name'][$k] . '.<br />';
						}
					}
				}

				if ($upload_file_src) {
					$fields['src_preview'] = $connection->real_escape_string($upload_file_src);
				} elseif (!empty($_POST['src_preview'])) {
					$fields['src_preview'] = $connection->real_escape_string($_POST['src_preview']);
				}

				$s = '(';
				foreach ($fields as $key => $value) {
					$s .= "$key,";
				}
				$s = substr($s, 0, -1);
				$s .= ') VALUES (';
				foreach ($fields as $key => $value) {
					$s .= "'$value',";
				}
				$s = substr($s, 0, -1);
				$s .= ')';

				$result = $connection->query("INSERT INTO $tp $s");
			}
			if ($result) {
				echo "1";
				\SkeitOl\CPHPCache::clearDir('/' . $tp);
			} else {
				echo "-1";
				$message = 'Неверный запрос: ' . $connection->getError();
				echo $message;
			}
		} else {
			echo "0";
		}
	}
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');