<?php

$news_id = @$PARAMS[0];

$newsObj = new News();

if ($news_id)
{
	$news = $newsObj->get($news_id);
}
else
{
	$news = $newsObj->getAll();
}

$this->assign('news', $news);