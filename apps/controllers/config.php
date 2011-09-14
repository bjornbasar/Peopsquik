<?php

$error = !file_exists(APP_CONF . 'config.php');

if (!$error)
{
	$this->forward('home');
}

$this->assign('error', $error);