<h1>Edit User</h1>

<div>
<form action="users_edit.do" method="post">
	<input type="hidden" name="users_id" value="<?php echo $view['users']['users_id']?>">

	<p><label for="username">Name</label>
	<input type="text" name="username" id="username" value="<?php echo $view['users']['username']?>">
	</p>

	<p><label for="userpassword">Password</label>
	<input type="password" name="userpassword" id="userpassword">
	</p>

	<p><label for="cpassword">Confirm password</label>
	<input type="password" name="cpassword" id="cpassword">
	</p>
	
	<input type="submit" value="Save">
</form>
</div>