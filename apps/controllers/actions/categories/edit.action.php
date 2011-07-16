<?php

$categoriesObj = new Categories();

$categoriesObj->update($_POST);

$this->forward('categories');