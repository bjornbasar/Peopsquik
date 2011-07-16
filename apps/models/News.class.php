<?php
class News extends TableBase
{
	public function __construct()
	{
		$this->table = strtolower(__CLASS__);
		$this->primary = $this->table . '_id';
		$this->order = 'date desc';
		parent::__construct();
	} 
}