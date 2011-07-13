<?php
abstract class DBAbstract
{
	protected $db;
	
	private $conf;
	
	public function __construct()
	{
		require 'config.php';
		$this->conf = $db;
	}
}