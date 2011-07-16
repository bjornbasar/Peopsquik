<?php

$categories_id = @$PARAMS[0];

if (!$this->acl->isSignedIn())
{
	$this->forward('index');
}

$categoriesObj = new Categories();

if ($categories_id)
{
	$this->assign('categories', $categoriesObj->get($categories_id));
}
