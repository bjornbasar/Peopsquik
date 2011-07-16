<?php

if (!$this->acl->isSignedIn())
{
	$this->forward('index');
}

$newsObj = new News();

$this->assign('news', $newsObj->getAll());