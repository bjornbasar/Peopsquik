<?php

class Users extends TableBase
{
	public function __construct()
	{
		$this->table = strtolower(__CLASS__);
		$this->primary = $this->table . '_id';
		$this->order = $this->primary . ', name';
		
		parent::__construct();
	}
}