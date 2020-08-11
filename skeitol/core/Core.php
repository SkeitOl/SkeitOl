<?php

namespace SkeitOl;

use Exception;
use FilesystemIterator;
use mysqli;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

class Core
{
	var $defaultDirCache = '/skeitol/cache/';

	public function getCahcePath()
	{
		return $_SERVER['DOCUMENT_ROOT'] . $this->defaultDirCache;
	}

	private $DB_CONFIG = array();

	function __construct()
	{
		$this->init();
	}

	function __destruct()
	{
		unset($this->DB_CONFIG);
	}

	private function init()
	{
		if (!require DOC_ROOT . '/skeitol/config.php') {
			die('Error open SQLConnect config file');
		}
		if (!empty($DB)) {
			$this->DB_CONFIG['host'] = ($DB['host']) ? $DB['host'] : 'localhost';
			$this->DB_CONFIG['username'] = ($DB['username']) ? $DB['username'] : '';
			$this->DB_CONFIG['passwd'] = ($DB['passwd']) ? $DB['passwd'] : '';
			$this->DB_CONFIG['dbname'] = ($DB['dbname']) ? $DB['dbname'] : '';

			if (empty($this->DB_CONFIG['username']) OR empty($this->DB_CONFIG['dbname']))
				die('Error settings SQLConnect config file');

			if (!$this->objConnectServer()) {
				die('Error connect DB');
			}

		} else die('Error DB settings');


	}

	public static function dump($var, $printr = false)
	{
		if (!$printr) {
			echo '<pre>';
			$result = '';
			ob_start();
			var_dump($var);
			$result = ob_get_clean();
			echo '$result';
			echo '</pre>';
		} else {
			echo '<pre>' . print_r($var, true) . '</pre>';
		}
	}

	/**
	 * @return mysqli
	 */
	private function objConnectServer()
	{
		$mysqli = new mysqli($this->DB_CONFIG['host'], $this->DB_CONFIG['username'], $this->DB_CONFIG['passwd'], $this->DB_CONFIG['dbname']);
		// проверка соединения /
		if ($mysqli->connect_errno) {
			die('Не удалось подключиться: ' . $mysqli->connect_error . '\n');
		}
		return $mysqli;
	}

	/**
	 * Запрос к БД
	 *
	 * @param $string SQL-строка запроса
	 * @return array|bool
	 */
	public function SQLQuery($string)
	{
		if (!empty($string)) {
			$dataArr = array();
			$mysqli = $this->objConnectServer();

			// Посылаем запрос серверу
			if ($result = $mysqli->query($string)) {

				// Выбираем результаты запроса:
				while ($row = $result->fetch_assoc()) {
					$dataArr[] = $row;
				}
				// Освобождаем память
				$result->close();
			}
			// Закрываем соединение
			$mysqli->close();

			return $dataArr;
		}
		return false;
	}

	public function __debugInfo()
	{
		return [
			'DB_CONFIG' => array('1'),
		];
	}

	/**
	 * Выводим список из БД таблицы
	 */

	/**
	 * @param $table_name
	 * @param array $arr_params =array('select'=>array('*'),
	 * 'filter'=>array(),
	 * 'order'=>array(),
	 * 'limit'=>array('top'=>'1','bottom'=>'10'),
	 * @return array|bool
	 */
	public function GetList($table_name, $arr_params = array()
		//$arr_select = array('*'), $arr_filter = array(),$arr_order = array(),$arr_limit=array()
	)
	{
		$arr_data = array();
		if ($table_name) {
			$select_default = '*';
			$select = '';
			if (!empty($arr_params['select']))
				if (is_array($arr_params['select']) && count($arr_params['select']) > 0) {
					foreach ($arr_params['select'] as $val) {
						if (!empty($val)) {
							$select .= htmlspecialchars($val) . ', ';
						}
					}
					$select = mb_substr($select, 0, -2);
				}

			if (!$select) $select = $select_default;

			$filter = '';
			//if($_SERVER['REMOTE_ADDR']=='5.158.233.184'){ SkeiOl::dump($arr_params);}
			if (!empty($arr_params['filter']))
				if (is_array($arr_params['filter']) && count($arr_params['filter']) > 0) {
					$n = count($arr_params['filter']);
					$i = 0;
					foreach ($arr_params['filter'] as $key => $item) {
						if ($i != 0)
							$filter .= ' AND ';

						$def_operator = '=';
						if (in_array($key[0], array('>', '!', '<'))) {
							$rep_length = 1;
							if ($key[1] == '=') $rep_length = 2;
							if ($key[0] == '!') {
								$def_operator = '<>';
							} else {
								$def_operator = substr($key, 0, $rep_length);
								$key = substr($key, $rep_length);
							}
						}
						if (!in_array(gettype($item), array('integer', 'double'))) {
							if (gettype($item) == 'array') {
								$def_operator = 'in';
								$titem = '';
								foreach ($item as $arItem) {
									$titem .= $arItem . ',';
								}
								$titem = substr($titem, 0, -1);
								$item = '(' . $titem . ')';
							} else {
								$item = "'" . htmlspecialchars($item) . "'";
							}
						}

						$filter .= htmlspecialchars($key) . ' ' . $def_operator . ' ' . $item;
						$i++;
					}
				}

			$order = '';
			if (!empty($arr_params['order']))
				if (is_array($arr_params['order']) && count($arr_params['order']) > 0) {
					$n = count($arr_params['order']);
					$i = 0;
					foreach ($arr_params['order'] as $key => $item) {
						if ($i != 0)
							$order .= ', ';
						$order .= htmlspecialchars($key) . ' ' . htmlspecialchars($item);
						$i++;
					}
				}
			$limit = '';
			if (!empty($arr_params['limit']))
				if (is_array($arr_params['limit']) && count($arr_params['limit']) > 0) {
					if (isset($arr_params['limit']['top'])) {
						$limit = ($arr_params['limit']['top']);
						if ($arr_params['limit']['bottom'])
							$limit .= ',' . ($arr_params['limit']['bottom']);
					}
				}

			$sql_query = 'SELECT ' . $select . ' FROM ' . $table_name . ' ';

			if ($filter) {
				$sql_query .= 'WHERE ' . $filter . ' ';
			}
			if ($order) {
				$sql_query .= 'ORDER BY ' . $order . ' ';
			}
			if ($limit) {
				$sql_query .= 'LIMIT ' . $limit . ' ';
			}


			//Запрос к БД
			//if($_SERVER['REMOTE_ADDR']=='5.158.233.184'){ SkeiOl::dump($sql_query);}


			$arr_data = $this->SQLQuery($sql_query);


		}
		return $arr_data;
	}
}

include_once('Util.php');
include_once('CPHPCache.php');
include_once('DBArticles.php');