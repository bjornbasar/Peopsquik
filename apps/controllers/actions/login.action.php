<?php
extract($_POST, EXTR_REFS);

if ($username && $password)
{
	if ($this->acl->authenticate($username, $password))
	{
		if ($redir)
		{
			$this->forward($redir, false);
		}
		else 
		{
			$this->forward(APP_URI, false);	
		}
	}
}
