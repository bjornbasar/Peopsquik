<?php

$news_id = @$PARAMS[0];

if (!$this->acl->isSignedIn())
{
	$this->forward('index');
}

$newsObj = new News();

if ($news_id)
{
	$this->assign('news', $newsObj->get($news_id));
}

$categoriesObj = new Categories();

$this->assign('categories', $categoriesObj->getAll());