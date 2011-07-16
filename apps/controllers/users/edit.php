<?php

$users_id = @$PARAMS[0];

if (!$this->acl->isSignedIn())
{
	$this->forward('index');
}

$usersObj = new Users();

if ($users_id)
{
	$this->assign('users', $usersObj->get($users_id));
}
