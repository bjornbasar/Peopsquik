<form action="login.do" method="post">

	<p><label for="username">Username</label>
	<input type="text" name="username">
	</p>
	
	<p><label for="password">Password</label>
	<input type="password" name="password">
	</p>
	
	<input type="hidden" name="redir" value="<?php echo $view['redir']?>">
	<input type="submit" value="Sign In">
</form>