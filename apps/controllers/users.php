<?php

if (!$this->acl->isSignedIn())
{
	$this->forward('index');
}

$usersObj = new Users();

$this->assign('users', $usersObj->getAll());