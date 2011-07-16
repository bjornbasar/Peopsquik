<h1>Edit News</h1>

<div>
<form action="news_edit.do" method="post">
	<input type="hidden" name="news_id" value="<?php echo $view['news']['news_id']?>">

	<p><label for="title">Title</label>
	<input type="text" name="title" id="title" value="<?php echo $view['news']['title']?>">
	</p>
	
	<p><label for="text">Text</label>
	<textarea rows="5" cols="30" name="text" id="text"><?php echo $view['news']['text']?></textarea>
	
	<p><label for="categories_id">Category</label>
	<select id="categories_id" name="categories_id">
		<?php foreach ($view['categories'] as $category) {?>
		<option value="<?php echo $category['categories_id']?>"><?php echo $category['name']?></option>
		<?php }?>
	</select>
	
	<input type="submit" value="Save">
</form>
</div>