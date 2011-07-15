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

define('APP_TITLE', 'News Service');

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

$PATHS = array(APP_LIB, APP_MODELS, APP_CONTROLS);
foreach ($PATHS as $PATH)
{
	set_include_path(get_include_path() . PATH_SEPARATOR . $PATH);
}

error_reporting(E_ALL);

/**
 * Custom global functions
 */

if (!function_exists('fileexists'))
{
	function fileexists($file)
	{
		global $PATHS;
		$found = false;
		foreach ($PATHS as $path)
		{
			if (!$found)
			{
				$found = file_exists($path . $file);
			}
		}
		
		return $found;
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

if (!function_exists('__autoload'))
{
	function __autoload($className)
	{
		$class = str_replace('_', '/', $className) . '.php';
		if (fileexists($class))
		{
			require_once $class;
		}
		else
		{
			require_once str_replace('_', '/', $className) . '.class.php';
		}
	}
}
