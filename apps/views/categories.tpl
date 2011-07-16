<h2>Categories</h2>

<div>
	<table border='1'>
		<thead>
			<tr>
				<th>Name</th>
				<th>Delete?</th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($view['categories'] as $category) {?>
			<tr onclick="location.href='categories_edit/<?php echo $category['categories_id']?>'" >
				<td><?php echo $category['name']?></td>
				<td><a href="categories_delete.do/<?php echo $category['categories_id']?>">Y</a>
			</tr>
		<?php }?>
		</tbody>
	</table>
	
	<p><a href="categories_edit">Add New</a></p>
</div>