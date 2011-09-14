<?php

$checkUsers = new Users();

if ($checkUsers->getAll())
{
	$this->forward('index');
}

$error = '';
if (!is_writable(APP_CONF))
{
	$error = "Please change the permission of the config folder to have write permissions";
}

$this->assign('error', $error);
$this->assign('modulename', 'System Install');