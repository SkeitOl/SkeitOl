<?php
/**
 * Created by PhpStorm.
 * User: skeit
 * Date: 18.04.2018
 * Time: 13:23
 */

namespace SkeitOl;


class CPHPCache
{
	private $time = null;
	private $id = null;
	private $dir = null;

	private $fileName = null;
	private $fullFileName = null;
	private $dirName = null;

	private $dirMode = 0755;
	private $fileMD5Str = "file_cache";
	private $dirSeparator = "/";

	private $defaultDirCache = "/skeitol/cache/cphp";

	/**
	 * CCachePHP constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Если кэш валиден
	 */
	public function InitCache($time, $id, $dir)
	{
		$res = false;
		$this->time = $time;
		$this->id = $id;
		$this->dir = $dir;


		$this->dirName = $this->getDocumentRoot() . $this->defaultDirCache . $dir;

		if ($this->dirName[strlen($this->dirName) - 1] != $this->dirSeparator)
			$this->dirName .= $this->dirSeparator;

		$this->fileName = md5($id . $time . $dir . $this->fileMD5Str);


		$this->fullFileName = $this->dirName . $this->fileName . '.php';

		//Есть ли директория
		if (!file_exists($this->dirName)) {
			return false;
		}
		//Есть ли файл
		if (!file_exists($this->fullFileName)) {
			return false;
		}

		$data = $this->read();

		if ($data === '') {
			unlink($this->fullFileName);
			return false;
		}

		return true;
	}

	/**
	 * Извлечение переменных из кэша
	 */
	public function GetVars()
	{
		$data = $this->read();
		return is_array($data) ? $data['data'] : false;
	}

	/**
	 * кэш валиден
	 *
	 * @throws Exception
	 */
	public function StartDataCache()
	{
		$res = true;

		if (!file_exists($this->dirName)) {
			if (!mkdir($concurrentDirectory = $this->dirName, $this->dirMode, true) && !is_dir($concurrentDirectory)
			) {
				throw new Exception('Не удаётся создать папку в скешем');
			}
		}
		//if (!file_exists($this->fullFileName))return false;

		ob_start();
		$this->vars = [];
		$this->isStarted = true;

		return true;
	}

	public function EndDataCache($var = false)
	{
		if (!$this->isStarted) {
			return;
		}

		$this->isStarted = false;

		$timeNow = time();
		$destroeTime = $timeNow + $this->time;

		$arRes = [
			'content' => ob_get_contents(),
			'data'    => ($var !== false ? $var : $this->vars)
		];

		if (isset($var)) {
			$fp = fopen($this->fullFileName, 'wb+');

			static $search = ["\\", "'", "\0"];
			static $replace = ["\\\\", "\\'", "'.chr(0).'"];


			$contents = "<?";
			$contents .= "\nif(\$INCLUDE_FROM_CACHE!='Y')return false;";
			$contents .= "\n\$dateCreate = '" . str_pad($timeNow, 12, "0", STR_PAD_LEFT) . "';";
			$contents .= "\n\$dateDestroy = '" . str_pad($destroeTime, 12, "0", STR_PAD_LEFT) . "';";
			$contents .= "\n\$data = '" . str_replace($search, $replace, serialize($arRes)) . "';";
			$contents .= "\nreturn true;";
			$contents .= "\n?>";

			// записываем в файл текст
			fwrite($fp, $contents);
			// закрываем
			fclose($fp);
			unset($fp);

		}

		if (strlen(ob_get_contents()) > 0) {
			ob_end_flush();
		} else {
			ob_end_clean();
		}
	}

	protected function read()
	{
		//Есть ли файл
		if (!file_exists($this->fullFileName)) {
			return false;
		}

		$dateCreate = 0;
		$dateDestroy = 0;
		$data = '';
		$INCLUDE_FROM_CACHE = 'Y';
		if (!@include($this->fullFileName)) {
			return false;
		}

		$dateDestroy = (int)$dateDestroy;

		if ($dateDestroy > time()) {
			$data = $data ? unserialize($data) : '';
		} else {
			$data = '';
		}

		return $data;
	}


	public function AbortDataCache()
	{
		if (!$this->isStarted) {
			return;
		}

		$this->isStarted = false;
		ob_end_flush();
	}

	public function Destroy()
	{

	}

	private function getDocumentRoot()
	{
		return $_SERVER["DOCUMENT_ROOT"];
	}


	public static function clearDir($dir)
	{
		if ($dir[0] !== '/') {
			$dir = '/' . $dir;
		}
		$allPath = $_SERVER['DOCUMENT_ROOT'] . '/skeitol/cache/cphp' . $dir;

		if (is_dir($allPath)) {

			function dirDel($dir)
			{
				$d = opendir($dir);
				while (($entry = readdir($d)) !== false) {
					if ($entry != "." && $entry != "..") {
						if (is_dir($dir . "/" . $entry)) {
							dirDel($dir . "/" . $entry);
						} else {
							unlink($dir . "/" . $entry);
						}
					}
				}
				closedir($d);
				rmdir($dir);
			}

			dirDel($allPath);
		}
	}
}