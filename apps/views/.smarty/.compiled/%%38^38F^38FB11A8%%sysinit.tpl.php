<?php /* Smarty version 2.6.25, created on 2011-09-14 10:04:15
         compiled from /home/www/dev/peopsquik/apps/views/main/sysinit.tpl */ ?>
<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php else: ?>
<div id="dbinfo" class="centerbox">
	<h2 style="text-align: center;"><img id="logo" src="includes/logo4.png"></h2>
	<h2>Database configuration</h2>
	<form action="install.do" method="post">
		<p>
			<label>Database name </label>
			<input type="text" name="dbname">
		</p>
	
		<p>
			<label>Database user </label>
			<input type="text" name="dbuser">
		</p>
	
		<p>
			<label>Database password </label>
			<input type="text" name="dbpass">
		</p>
	
		<p>
			<label>Database host </label>
			<input type="text" name="dbhost">
		</p>
		
		<br class="clear"><div class="separator horizontalsep" style="width: 347px;" ></div><br class="clear">
		
		<p>
			<label>Primary User </label>
			<input type="text" name="admin">
		</p>
		
		<p>
			<label>Primary Password </label>
			<input type="text" name="adminpassword">
		</p>
		
		<p>
			<input class="submit" type="submit" value="Next">
		</p>
	</form>
</div>
<script type="text/javascript">
<?php echo '
window.addEvent(\'domready\', function()
{
	mooVCenter($(\'dbinfo\'));
});
'; ?>

</script>
<?php endif; ?>