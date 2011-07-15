<?php
class Categories extends TableBase
{
	public function __construct()
	{
		$this->table = strtolower(__CLASS__);
		$this->primary = $this->table . '_id';
		parent::__construct();
	}
}