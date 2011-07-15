<?php

require 'settings.php';

// set error and exception handlers
set_error_handler('Handler::errorHandler');
set_exception_handler('Handler::exceptionHandler');

if (!empty($_SERVER['REDIRECT_MODULE']))
{
	$PARAMS = explode('/', $_SERVER['REDIRECT_MODULE']);
}
else
{
	$PARAMS = array('index');
}

$module = array_shift($PARAMS);
$parameters['module'] = str_replace('_', '/', $module) . '.php';
$parameters['template'] = str_replace('_', '/', $module) . '.tpl';

if (stripos($module, '.do') !== false)
{
	$parameters['module'] = 'actions/' . str_replace('.do', '.action', $parameters['module']);
	$parameters['allowdisplay'] = false;
}

if (file_exists(APP_CONTROLS . $parameters['module']) && (!isset($parameters['body']) || file_exists(APP_VIEWS . @$parameters['body'])))
{
	$core = new Core($parameters);
	
	$core->display();
}
else
{
	// display the 'module not found' page
	throw new Exception("Module $module not found");
}
