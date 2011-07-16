<h2>Users</h2>

<div>
	<table border='1'>
		<thead>
			<tr>
				<th>User Name</th>
				<th>Delete?</th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($view['users'] as $users) {?>
			<tr onclick="location.href='users_edit/<?php echo $users['users_id']?>'" >
				<td><?php echo $users['username']?></td>
				<td><a href="users_delete.do/<?php echo $users['users_id']?>">Y</a>
			</tr>
		<?php }?>
		</tbody>
	</table>
	
	<p><a href="users_edit">Add New</a></p>
</div>