<?php


namespace SkeitOl;


class CDatabase
{
	private $db_Conn;

	private $DBName;
	private $DBHost;
	private $DBLogin;
	private $DBPassword;
	private $bConnected;
	private $version;
	private $cntQuery;
	private $timeQuery;
	private $column_cache = Array();
	private $obSlave;

	//Connect to database
	function connect($DBHost, $DBName, $DBLogin, $DBPassword)
	{
		$this->debug = false;

		$this->type = 'MYSQL';
		$this->DBHost = $DBHost;
		$this->DBName = $DBName;
		$this->DBLogin = $DBLogin;
		$this->DBPassword = $DBPassword;
		$this->bConnected = false;

		if (!defined("DBPersistent"))
			define("DBPersistent", true);

		if (defined("DELAY_DB_CONNECT") && DELAY_DB_CONNECT === true)
			return true;
		else
			return $this->doConnect();
	}

	function doConnect()
	{
		if ($this->bConnected)
			return;
		$this->bConnected = true;

		if (DBPersistent && !$this->bNodeConnection) {
			$this->db_Conn = @mysqli_connect("p:" . $this->DBHost, $this->DBLogin, $this->DBPassword);
		} else {
			$this->db_Conn = @mysqli_connect($this->DBHost, $this->DBLogin, $this->DBPassword);
		}

		if (!$this->db_Conn) {
			$s = (DBPersistent && !$this->bNodeConnection ? "mysql_pconnect" : "mysql_connect");
			if ($this->debug || (@session_start() && $_SESSION["SESS_AUTH"]["ADMIN"])) {
				echo "<br><font color=#ff0000>Error! " . $s . "('-', '-', '-')</font><br>" . mysqli_error($this->db_Conn) . "<br>";
			}
			SendError("Error! " . $s . "('-', '-', '-')\n" . mysqli_error($this->db_Conn) . "\n");
			return false;
		}

		if (!mysqli_select_db($this->db_Conn, $this->DBName)) {
			if ($this->debug || (@session_start() && $_SESSION["SESS_AUTH"]["ADMIN"]))
				echo "<br><font color=#ff0000>Error! mysqli_select_db(" . $this->DBName . ")</font><br>" . mysqli_error($this->db_Conn) . "<br>";

			SendError("Error! mysqli_select_db(" . $this->DBName . ")\n" . mysqli_error($this->db_Conn) . "\n");
			return false;
		}


		$this->cntQuery = 0;
		$this->timeQuery = 0;
		$this->arQueryDebug = array();

		global $DB, $USER, $APPLICATION;
		if (file_exists($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/after_connect.php"))
			include($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/after_connect.php");

		return true;
	}
}