<?php

namespace SkeitOl;

use Exception;
use mysqli;

class Connection
{
	private static $instances = null;
	
	private $host = '';
	private $username = '';
	private $passwd = '';
	private $dbname = '';
	
	/** @var mysqli mysqli */
	private $mysqli = null;
	
	protected function __clone()
	{
	}
	
	public function __wakeup()
	{
		throw new Exception("Cannot unserialize a singleton.");
	}
	
	protected function __construct()
	{
		if (!require DOC_ROOT . '/skeitol/config.php') {
			throw new Exception('Error open SQLConnect config file');
		}
		/** @var array $DB */
		if (!empty($DB)) {
			
			$this->host = $DB['host'] ?: 'localhost';
			$this->username = $DB['username'] ?: '';
			$this->passwd = $DB['passwd'] ?: '';
			$this->dbname = $DB['dbname'] ?: '';
			
			if (empty($this->username) || empty($this->dbname)) {
				throw new \RuntimeException('Error settings SQLConnect config file');
			}
			
			$this->openConnection();
			
			// проверка соединения /
			if ($this->mysqli->connect_errno) {
				throw new \RuntimeException('Не удалось подключиться: ' . $this->mysqli->connect_error . '\n');
			}
			
		} else {
			throw new \RuntimeException('Error DB settings');
		}
	}
	
	public static function getInstance()
	{
		if (self::$instances === null) {
			self::$instances = new static();
		}
		
		return self::$instances;
	}
	
	
	/**
	 * @return mysqli
	 */
	protected function getConnection()
	{
		if ($this->mysqli !== null) {
			$this->openConnection();
		}
		return $this->mysqli;
	}
	
	protected function openConnection()
	{
		if ($this->mysqli === null) {
			
			$this->mysqli = new mysqli($this->host, $this->username, $this->passwd, $this->dbname);
		}
		
		return $this;
	}
	
	/**
	 * Закрывает соединение
	 */
	public function closeConnection()
	{
		if ($this->getConnection() !== null) {
			$this->getConnection()->close();
		}
		$this->mysqli = null;
		
		return $this;
	}
	
	public function query($strQuery)
	{
		return new Cbresult($this->getConnection()->query($strQuery));
	}
}