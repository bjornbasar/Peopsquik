<?php

extract($_POST, EXTR_REFS);

$usersObj = new Users();
$data = $_POST;

unset($data['cpassword']);

if ($cpassword == $userpassword)
{
	echo 1;
	$usersObj->update($data);
}

$this->forward('users');