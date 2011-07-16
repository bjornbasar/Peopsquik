	<a href="index">Home</a> | 
<?php if ($this->acl->isSignedIn()) {?>
	<a href="news">Add/Edit News</a> | 
	<a href="categories">Add/Edit Categories</a> | 
	<a href="users">Add/Edit Users</a>
	<a href="logout.do">Sign Out</a>
	
<?php } else {?>
	<a href="login">Sign In</a>
<?php }?>