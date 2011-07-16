<?php

$users_id = @$PARAMS[0];

$usersObj = new Users();

if ($users_id)
{
	$usersObj->delete($users_id);
}

$this->forward('users');