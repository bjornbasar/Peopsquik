<h1>Edit Category</h1>

<div>
<form action="categories_edit.do" method="post">
	<input type="hidden" name="categories_id" value="<?php echo $view['categories']['categories_id']?>">

	<p><label for="name">Name</label>
	<input type="text" name="name" id="name" value="<?php echo $view['categories']['name']?>">
	</p>
	
	<input type="submit" value="Save">
</form>
</div>