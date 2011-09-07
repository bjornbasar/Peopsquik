<?php /* Smarty version 2.6.25, created on 2011-09-07 17:58:49
         compiled from /home/www/dev/peopsquik/apps/views/main/sysinit.tpl */ ?>
<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php else: ?>
<h2>Database configuration : </h2>
<div>
	<form action="install.do" method="post">
		<p>
			<label>Database name : </label>
			<input type="text" name="dbname">
		</p>
	
		<p>
			<label>Database user : </label>
			<input type="text" name="dbuser">
		</p>
	
		<p>
			<label>Database password : </label>
			<input type="text" name="dbpass">
		</p>
	
		<p>
			<label>Database host : </label>
			<input type="text" name="dbhost">
		</p>
		
		<p>
			<input type="submit" value="Next">
		</p>
	</form>
</div>
<?php endif; ?>