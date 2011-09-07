{if $error}
<p class="error">{$error}</p>
{else}
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
{/if}
