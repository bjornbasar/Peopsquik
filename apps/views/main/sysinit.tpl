{if $error}
<p class="error">{$error}</p>
{else}
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
{literal}
window.addEvent('domready', function()
{
	mooVCenter($('dbinfo'));
});
{/literal}
</script>
{/if}
