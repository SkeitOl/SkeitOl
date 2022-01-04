<?php

namespace SkeitOl;

use Exception;
use mysqli;
use mysqli_result;

class Cbresult
{
	/**
	 * @var mysqli_result
	 */
	protected $query;
	protected $messageError;
	
	/**
	 * @param mysqli_result $res
	 */
	public function __construct($query)
	{
		$this->query = $query;
	}
	
	
	public function fetch()
	{
		if ($this->query) {
			return is_bool($this->query) ?: $this->query->fetch_assoc();
		}
		
		return $this->query;
	}
}