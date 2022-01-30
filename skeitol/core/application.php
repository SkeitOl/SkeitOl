<?php

namespace SkeitOl;

use Exception;

class Application
{
	private static $instances = null;
	
	private $sDocTitle = '';
	private $arPageProperties = [];
	
	private $buffer_content = [];
	private $buffer_content_type = [];
	private $buffer_man;
	private $buffered;
	private $auto_buffer_cleaned;
	
	/**
	 * @return Application
	 */
	public static function getInstance()
	{
		if (self::$instances === null) {
			self::$instances = new static();
		}
		
		return self::$instances;
	}
	
	protected function __clone()
	{
	}
	
	public function __wakeup()
	{
		throw new Exception("Cannot unserialize a singleton.");
	}
	
	protected function __construct()
	{
	
	}
	
	public function showTitle($property_name = "title", $strip_tags = true)
	{
		$this->AddBufferContent([&$this, "getTitle"], $property_name, $strip_tags);
	}
	
	public function getTitle($property_name = false, $strip_tags = false)
	{
		if ($property_name !== false && $this->getProperty($property_name) <> '') {
			$res = $this->getProperty($property_name);
		} else {
			$res = $this->sDocTitle;
		}
		if ($strip_tags) {
			return strip_tags($res);
		}
		return $res;
	}
	
	/**
	 * @param       $PROPERTY_ID
	 * @param false $default_value
	 *
	 * @return false|mixed
	 */
	public function getProperty($PROPERTY_ID, $default_value = false)
	{
		$propVal = $this->getPageProperty($PROPERTY_ID);
		if ($propVal !== false) {
			return $propVal;
		}
		
		return $default_value;
	}
	
	public function getPageProperty($PROPERTY_ID, $default_value = false)
	{
		if (isset($this->arPageProperties[mb_strtoupper($PROPERTY_ID)]))
			return $this->arPageProperties[mb_strtoupper($PROPERTY_ID)];
		return $default_value;
	}
	
	public function addBufferContent($callback)
	{
		$args = [];
		$args_num = func_num_args();
		if ($args_num > 1)
			for ($i = 1; $i < $args_num; $i++)
				$args[] = func_get_arg($i);
		
		if (!defined("BX_BUFFER_USED") || BX_BUFFER_USED !== true) {
			echo call_user_func_array($callback, $args);
			return;
		}
		$this->buffer_content[] = ob_get_contents();
		$this->buffer_content[] = "";
		$this->buffer_content_type[] = ["F" => $callback, "P" => $args];
		$this->buffer_man = true;
		$this->auto_buffer_cleaned = false;
		ob_end_clean();
		$this->buffer_man = false;
		$this->buffered = true;
		if ($this->auto_buffer_cleaned) // cross buffer fix
			ob_start([&$this, "endBufferContent"]);
		else
			ob_start();
	}
	
	public function endBufferContent($content = "")
	{
		if ($this->buffer_man) {
			$this->auto_buffer_cleaned = true;
			return "";
		}
		
		//RM CODE
		
		/*$asset = Asset::getInstance();
		$asset->addString(CJSCore::GetCoreMessagesScript(), false, AssetLocation::AFTER_CSS, AssetMode::STANDARD);
		$asset->addString(CJSCore::GetCoreMessagesScript(true), false, AssetLocation::AFTER_CSS, AssetMode::COMPOSITE);
		
		$asset->addString($this->GetSpreadCookieHTML(), false, AssetLocation::AFTER_JS, AssetMode::STANDARD);
		if ($asset->canMoveJsToBody() && \CJSCore::IsCoreLoaded()) {
			$asset->addString(\CJSCore::GetInlineCoreJs(), false, AssetLocation::BEFORE_CSS, AssetMode::ALL);
		}*/
		
		if (is_object($GLOBALS["APPLICATION"])) //php 5.1.6 fix: http://bugs.php.net/bug.php?id=40104
		{
			$cnt = count($this->buffer_content_type);
			for ($i = 0; $i < $cnt; $i++) {
				$this->buffer_content[$i * 2 + 1] = call_user_func_array($this->buffer_content_type[$i]["F"], $this->buffer_content_type[$i]["P"]);
			}
		}
		
		//$compositeContent = Composite\Engine::startBuffering($content);
		$content = implode("", $this->buffer_content) . $content;
		
		/*if (function_exists("getmoduleevents")) {
			foreach (GetModuleEvents("main", "OnEndBufferContent", true) as $arEvent) {
				ExecuteModuleEventEx($arEvent, [&$content]);
			}
		}*/
		
		/*$wasContentModified = Composite\Engine::endBuffering($content, $compositeContent);
		if (!$wasContentModified && $asset->canMoveJsToBody()) {
			$asset->moveJsToBody($content);
		}*/
		
		return $content;
	}
}