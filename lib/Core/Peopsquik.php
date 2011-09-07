<?php
class Core_Peopsquik
{
	private $_parameters;
	private $_template;
	private $_vars;
	public $acl = false;
	
	public function __construct($params)
	{
		$this->_parameters = $params;
		if ($this->_parameters['allowdisplay'])
		{
			$this->_template = new Smarty();
			$this->_template->caching = APP_CACHE; // set to true to enable caching
			$this->_template->debugging = APP_DEBUG;
			$this->_template->template_dir = APP_VIEWS;
			$this->_template->compile_dir = APP_VIEWS_COMPILED;
			$this->_template->cache_dir = APP_VIEWS_CACHE;
			$this->assign('TEMPLATE_TITLE', APP_NAME);
			
			//$this->_setDisplayType($parameters['displaytype']);
		}
		$this->acl = new Core_ACL();
		
		global $PARAMS;
		require APP_CONTROLS . $this->_parameters['module'];
	}
	
	public function display()
	{
		if ($this->acl->isSignedIn())
		{
			$this->_template->assign('loggedIn', 1);
		}
		
		if (isset($this->_parameters['body']))
		{
			$this->_template->assign('body', APP_VIEWS . $this->_parameters['body']);
		}
		
		$this->_template->display($this->_parameters['template']);
	}
	
	public function assign($key, $value)
	{
		$this->_template->assign($key, $value);
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
	
	public function checkACL()
	{
		return $this->acl->isSignedIn();
	}
	
	public function authenticate($user, $pass)
	{
		return $this->acl->authenticate($user, $pass);
	}
}