<?php

function filePermissions($file)
{
	return substr(decoct(fileperms($file)), -3, 1) . '';
}

$error = '';
if (!is_writable(APP_CONF))
{
	$error = "Please change the permission of the config folder to have write permissions";
}

$this->assign('error', $error);
$this->assign('modulename', 'System Install');