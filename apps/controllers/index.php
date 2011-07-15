<?php

$news = new News();

$this->assign('news', $news->getAll());