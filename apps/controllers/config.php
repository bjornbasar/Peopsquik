<?php

$error = !file_exists(APP_CONF . 'config.php');

if (!$error)
{
	$this->forward('index');
}

$this->assign('error', $error);