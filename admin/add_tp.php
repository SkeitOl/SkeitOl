<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/prolog_before.php');
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/lock.php");


$connection = \SkeitOl\Connection::getInstance();

/*New*/
if (!empty($_POST['items']) && !empty($_POST['tp']) && !empty($_POST['delet_items']) && $_POST['items']) {
	$result = false;
	$_POST['items'] = (array)$_POST['items'];
	$n = count($_POST['items']);
	for ($i = 0; $i < $n; $i++) {
		$id = (int)$_POST['items'][$i];
		if ($id > 0) {
			$result = $connection->query("DELETE FROM " . $connection->real_escape_string($_POST['tp']) . " WHERE id='" . $id . "'")->fetch();
			\SkeitOl\CPHPCache::clearDir('/articles');
		}
	}
	if ($result) {
		echo "1";
	} else {
		echo "-1";
	}
}
/*.New*/
/*OLD*/
if (isset($_POST['activ'])) {
	if ($_POST['activ'] == "del") {
		if (isset($_POST['id'])) {
			$_POST['id'] = (array)$_POST['id'];
			foreach ($_POST['id'] as $key => $value) {
				$value = (int)$value;
				if ($value) {
					$result = $connection->query("DELETE FROM " . $connection->real_escape_string($_POST['tp']) . " WHERE id='" . $value . "'");
				}
			}
			if ($result == 'true') {
				echo "1";
				\SkeitOl\CPHPCache::clearDir('/articles');
			} else {
				echo "-1";
			}
		} else echo "0";
	} else {
		if (isset($_POST['title'])) {
			$title = $_POST['title'];
			if ($title == '') {
				unset($title);
			}
		}
		if (isset($_POST['date'])) {
			$date = $_POST['date'];
			if ($date == '') {
				unset($date);
			}
		}
		if (isset($_POST['description'])) {
			$description = $_POST['description'];
			if ($description == '') {
				unset($description);
			}
		}
		if (isset($_POST['text'])) {
			$text = $_POST['text'];
			if ($text == '') {
				unset($text);
			}
		}
		if (isset($_POST['author'])) {
			$author = $_POST['author'];
			if ($author == '') {
				unset($author);
			}
		}
		if (isset($_POST['url'])) {
			$author = $_POST['url'];
			if ($url == '') {
				unset($url);
			}
		}
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if ($id == '') {
				unset($id);
			}
		}
		if (isset($_POST['tp']) && isset($title) && isset($date) && isset($description) && isset($text)) {
			$tp = $connection->real_escape_string($_POST['tp']);
			$title = $connection->real_escape_string($title);
			$text = $connection->real_escape_string($text);
			$description = $connection->real_escape_string($description);
			$add_value = "";
			$add_key = "";
			if ($_POST['activ'] == "update") {
				/**
				 * Добавление элемента.  UPDATE
				 */
				if ($tp == 'articles') {
					$string = '';
					if (count($_POST['category_m']) > 0) {
						$array = [];
						$i = 0;
						foreach ($_POST['category_m'] as $key => $value) {
							$array[$i] = $value;
							$i++;
						}
						$string = serialize($array);
					}
					$add_value .= ",category='$string'";
				}
				if (isset($_POST['meta_title'])) {
					$add_value .= ",meta_title='" . $connection->real_escape_string($_POST['meta_title']) . "'";
				}
				if (isset($_POST['meta_description'])) {
					$add_value .= ",meta_description='" . $connection->real_escape_string($_POST['meta_description']) . "'";
				}
				if (isset($_POST['meta_keywords'])) {
					$add_value .= ",meta_keywords='" . $connection->real_escape_string($_POST['meta_keywords']) . "'";
				}
				
				/*Актовность элемента*/
				if (!empty($_POST['active_p'])) {
					$add_value .= ",active='1'";
				} else {
					$add_value .= ",active='0'";
				}
				
				if (!empty($_POST['url'])) {
					$add_value .= ",url='" . $connection->real_escape_string($_POST['url']) . "'";
				}
				if (!empty($_POST['author'])) {
					$add_value .= ",author='" . $connection->real_escape_string($_POST['author']) . "'";
				}
				if (!empty($_POST['src_preview'])) {
					$add_value .= ",src_preview='" . $connection->real_escape_string($_POST['src_preview']) . "'";
				}
				if (!empty($_POST['views'])) {
					$add_value .= ",views='" . $connection->real_escape_string($_POST['views']) . "'";
				}
				
				//рекомендации
				if (!empty($_POST['RECOMMENDATIONS'])) {
					
					if (is_array($_POST['RECOMMENDATIONS'])) {
						foreach ($_POST['RECOMMENDATIONS'] as $key => $value) {
							if (empty($value)) {
								unset($_POST['RECOMMENDATIONS'][$key]);
							}
						}
						if (count($_POST['RECOMMENDATIONS']) > 0)
							$RECOMMENDATIONS = serialize($_POST['RECOMMENDATIONS']);
						else $RECOMMENDATIONS = '';
						
					} else $RECOMMENDATIONS = htmlspecialchars($_POST['RECOMMENDATIONS']);
					$add_value .= ",RECOMMENDATIONS='" . $RECOMMENDATIONS . "'";
				}
				/*?>
<pre><?print_r($_FILES)?></pre>
				<?*/
				//Нужно ли удалить прошлый превью файл
				if (!empty($_POST['clear_preview']))
					$add_value .= ",src_preview=''";
				if (!empty($_POST['del_old_src_preview']))
					unlink($_SERVER['DOCUMENT_ROOT'] . $_POST['del_old_src_preview']);
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
						$add_value .= ",src_preview='" . (str_replace($_SERVER['DOCUMENT_ROOT'], "", $uploadfile)) . "'";
					}
				}
				//Дата последнего обновления TIMESTAMP_X
				$add_value .= ",TIMESTAMP_X='" . date("Y-m-d H:i:s") . "'";
				
				$result = $connection->query("UPDATE $tp SET title='$title',date='$date',description='$description',text='$text'" . $add_value . " WHERE id='$id'");
				
				if ($result) {
					\SkeitOl\CPHPCache::clearDir('/articles');
				}
				
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
//print_r($_FILES);
				if ($tp == 'articles') {
					$string = '';
					if (count($_POST['category_m']) > 0) {
						$array = [];
						$i = 0;
						foreach ($_POST['category_m'] as $key => $value) {
							$array[$i] = $value;
							$i++;
						}
						$string = serialize($array);
					}
					$add_value .= ",'$string'";
					$add_key .= ",category";
				}
				
				if (!empty($_POST['meta_title'])) {
					$add_key .= ",meta_title";
					$add_value .= ",'" . $connection->real_escape_string($_POST['meta_title']) . "'";
				}
				if (!empty($_POST['meta_description'])) {
					$add_key .= ",meta_description";
					$add_value .= ",'" . $connection->real_escape_string($_POST['meta_description']) . "'";
				}
				if (!empty($_POST['meta_keywords'])) {
					$add_key .= ",meta_keywords";
					$add_value .= ",'" . $connection->real_escape_string($_POST['meta_keywords']) . "'";
				}
				//if(!empty($_POST[active_p_bool]))
				if (!empty($_POST['active_p'])) {
					$add_key .= ",active";
					$add_value .= ",'1'";
				} else {
					$add_key .= ",active";
					$add_value .= ",'0'";
				}
				
				if (!empty($_POST['url'])) {
					$add_key .= ",url";
					$add_value .= ",'" . $connection->real_escape_string($_POST['url']) . "'";
				}
				if (!empty($_POST['author'])) {
					$add_key .= ",author";
					$add_value .= ",'" . $connection->real_escape_string($_POST['author']) . "'";
				}
				
				if ($upload_file_src) {
					$add_key .= ",src_preview";
					$add_value .= ",'" . $connection->real_escape_string($upload_file_src) . "'";
				} elseif (!empty($_POST['src_preview'])) {
					$add_key .= ",src_preview";
					$add_value .= ",'" . $connection->real_escape_string($_POST['src_preview']) . "'";
				}
				
				
				$result = $connection->query("INSERT INTO $tp (title,date,description,text" . $add_key . ") VALUES ('$title','$date','$description','$text'" . $add_value . ")");
			}
			if ($result) {
				echo "1";
				\SkeitOl\CPHPCache::clearDir('/articles');
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