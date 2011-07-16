<?php

$this->acl->signOut();

$this->assign('redir', $_SERVER['HTTP_REFERER']);