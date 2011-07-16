<?php

$news_id = @$PARAMS[0];

$newsObj = new News();

if ($news_id)
{
	$newsObj->delete($news_id);
}

$this->forward('news');