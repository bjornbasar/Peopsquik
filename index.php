<?php

include('settings.php');
include('config.php');

if (!empty($_SERVER['REDIRECT_MODULE']))
{
	$PARAMS = explode('/', $_SERVER['REDIRECT_MODULE']);
}
else
{
	$PARAMS = array('main');
}

$module = array_shift($PARAMS);
$module = explode('_', $module);

printr($module);

if (file_exists(APP_CONTROLS . $module[0] . '.php'))
{
	$control = new $module[0]();
}
else
{
	echo 'Module does not exist';
}
