<?php
/**
 * Created by PhpStorm.
 * User: skeit
 * Date: 18.04.2018
 * Time: 13:21
 */

namespace SkeitOl;


class Util
{
	public function getStrFileSize($size, $round = 2)
	{
		$sizes = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb');
		for ($i = 0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
		return round($size, $round) . " " . $sizes[$i];
	}

	function getSymbolByQuantity($bytes)
	{
		$symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
		$exp = floor(log($bytes) / log(1024));

		return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
	}

	function getFilesSize($path)
	{
		$it = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
		);

		$size = 0;
		foreach ($it as $fi) {
			$size += $fi->getSize();
		}
		return $size;
	}


	/**
	 * выводим 404
	 * @return void
	 */
	public static function set404(){
		header("HTTP/1.0 404 Not Found");
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/error-pages/error404.htm');

		include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');
	}
}