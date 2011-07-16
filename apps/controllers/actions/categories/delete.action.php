<?php

$categories_id = @$PARAMS[0];

$categoriesObj = new Categories();

if ($categories_id)
{
	$categoriesObj->delete($categories_id);
}

$this->forward('categories');