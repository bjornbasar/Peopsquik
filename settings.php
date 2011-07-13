<?php

/**
 * Site settings
 */

define('APP_ROOT', dirname(__FILE__) . '/');
define('APP_LIB', APP_ROOT . 'lib/');
define('APP_APPS', APP_ROOT . 'apps/');
define('APP_MODELS', APP_APPS . 'models/');
define('APP_CONTROLS', APP_APPS . 'controllers/');
define('APP_VIEWS', APP_APPS . 'views/');

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
{
	define('APP_PROTOCOL', 'https');
}
else
{
	define('APP_PROTOCOL', 'http');
}

if (isset($_SERVER['HTTP_HOST']))
{
	define('APP_URI', trim(APP_PROTOCOL . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']), '/') . '/');
	define('APP_INCLUDES', APP_URI . 'includes/');
}

$PATHS = array(APP_LIB, APP_MODELS); 
foreach ($PATHS as $PATH) 
{
	set_include_path(get_include_path() . PATH_SEPARATOR . $PATH);
}

error_reporting(E_ALL);

if (!function_exists('__autoload'))
{
	function __autoload($className)
	{
		require_once '';
	}
}

if (!function_exists('printr')) 
{
	function printr($mixed)
	{
		echo '<pre>';
		print_r($mixed);
		echo '</pre>';
	}
}

if (!function_exists('vardump'))
{
	function vardump($mixed)
	{
		echo '<pre>';
		var_dump($mixed);
		echo '</pre>';
	}
}
