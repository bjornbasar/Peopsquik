<?php
class Core
{
	protected $_parameters;
	protected $_controller;
	private $_vars;
	public $acl = false;
	
	public function __construct($params)
	{
		$this->_parameters = $params;
		$this->acl = '';

		global $PARAMS;
		require APP_CONTROLS . $this->_parameters['module'];
	}
	
	public function display()
	{
		$this->assign('body', APP_VIEWS . $this->_parameters['template']);
		$view = $this->_vars;
		
		require APP_VIEWS . 'main.tpl';
	}
	
	public function assign($key, $value)
	{
		$this->_vars[$key] = $value;
	}
		
	public function forward($url, $rel = true)
	{
		if ($rel)
		{
			header('Location: ' . APP_URI . $url);
		}
		else
		{
			header('Location: ' . $url);
		}
	}
	
}