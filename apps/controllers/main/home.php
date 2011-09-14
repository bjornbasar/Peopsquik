<?php

if (!$this->checkACL())
{
	$this->forward('login');
}