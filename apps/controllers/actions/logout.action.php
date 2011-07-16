<?php

$this->acl->signOut();

$this->forward($_SERVER['HTTP_REFERER'], false);