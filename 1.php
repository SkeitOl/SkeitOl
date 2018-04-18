<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

Class HUMAN{
	public $name="Вася";
	const name2="Вася";
	public  function HELLO(){
		echo "asdas ".$this->name;
	}
	public  function GOODBYE(){
		echo "asdas ".$this->name;
	}
	public static function DI2E(){
		echo "asda".self::name2;
	}
}

$b = new HUMAN();

$b->DI2E();