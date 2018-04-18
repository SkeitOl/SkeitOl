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

	private $defaultDirCache = "/skeitol/cache/cphp/";

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

		if ($this->dirName[strlen($this->dirName) - 1] != $this->dirSeparator) $this->dirName .= $this->dirSeparator;

		$this->fileName = md5($id . $time . $dir . $this->fileMD5Str);


		$this->fullFileName = $this->dirName . $this->fileName;

		//Есть ли директория
		if (!file_exists($this->dirName)) {
			return false;
		}
		//Есть ли файл
		if (!file_exists($this->fullFileName)) {
			return false;
		}

		//Есть ли данные
		$handle = fopen($this->fullFileName, "r");
		$s = '';
		while (!feof($handle)) {
			$s = fgets($handle);
		}
		fclose($handle);

		if (!empty($s)) {
			$data = @unserialize($s);
			if ($data !== false) {
				if (!empty($data["timeDestroy"])) {
					if ($data["timeDestroy"] > time() && isset($data["data"])) {
						return true;
					}
				}
			}
		}
		return $res;
	}

	/**
	 * Извлечение переменных из кэша
	 */
	public function GetVars()
	{
		$res = false;
		//Есть ли файл
		if (!file_exists($this->fullFileName)) {
			return false;
		}

		//Есть ли данные
		$handle = fopen($this->fullFileName, "r");
		$s = '';
		while (!feof($handle)) {
			$s = fgets($handle);
		}
		fclose($handle);

		if (!empty($s)) {
			$data = @unserialize($s);
			if ($data !== false) {
				if (isset($data["timeDestroy"]) && isset($data["data"])) {
					return $data["data"];
				}

			}
		}
		return $res;
	}

	/**
	 * кэш валиден
	 * @throws Exception
	 */
	public function StartDataCache()
	{
		$res = true;

		if (!file_exists($this->dirName)) {
			if (!mkdir($this->dirName
				, $this->dirMode, true
			)
			) {
				throw new Exception('Не удаётся создать папку в скешем');
			}
		}
		//if (!file_exists($this->fullFileName))return false;


		return $res;
	}

	public function EndDataCache($var)
	{
		if (isset($var)) {
			$fp = fopen($this->fullFileName, "w");

			$timeNow = time();
			$destroeTime = $timeNow + $this->time;

			$arRes = array("timeDestroy" => $destroeTime, "data" => $var);

			$arRes = serialize($arRes);

			// записываем в файл текст
			fwrite($fp, $arRes);
			// закрываем
			fclose($fp);
			unset($fp);

		} else {
			return false;
		}
	}

	public function Destroy()
	{

	}

	private function getDocumentRoot()
	{
		return $_SERVER["DOCUMENT_ROOT"];
	}
}