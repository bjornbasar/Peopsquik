<?php

require 'settings.php';

// set error and exception handlers
set_error_handler('Core_Handler::errorHandler');
set_exception_handler('Core_Handler::exceptionHandler');

if (!empty($_SERVER['REDIRECT_MODULE']))
{
	$PARAMS = explode('/', $_SERVER['REDIRECT_MODULE']);
}
else
{
	$PARAMS = array('index');
}

$module = array_shift($PARAMS);
$moduleBasePath = str_replace('_', '/', $module) . '.php';
$templateBasePath = str_replace('_', '/', $module) . '.tpl';

session_start();

if (stripos($module, '.do') !== false)
{
	$parameters['module'] = 'actions/' . str_replace('.do', '.action', $moduleBasePath);
	$parameters['allowdisplay'] = false;
}
else 
{
	$parameters['module'] = 'main/' . $moduleBasePath;
	$parameters['allowdisplay'] = true;
	$parameters['template'] = 'main' . $templateBasePath;
	
	if (stripos($templateBasePath, 'partial') === false)
	{
		$parameters['body'] = 'main/' . $templateBasePath;
		$parameters['template'] = APP_MAIN;
	}
}

if (file_exists(APP_CONTROLS . $parameters['module']) && (!isset($parameters['body']) || file_exists(APP_VIEWS . @$parameters['body'])))
{
	$OFUFE = new Core_Ofufe($parameters);
	
	$OFUFE->display();
}
else
{
	// display the 'module not found' page
	throw new Exception("Module $module not found");
}
