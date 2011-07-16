<h2>News</h2>

<div>
	<table border='1'>
		<thead>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Delete?</th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($view['news'] as $news) {?>
			<tr onclick="location.href='news_edit/<?php echo $news['news_id']?>'" >
				<td><?php echo $news['title']?></td>
				<td><?php echo $news['date']?></td>
				<td><a href="news_delete.do/<?php echo $news['news_id']?>">Y</a>
			</tr>
		<?php }?>
		</tbody>
	</table>
	
	<p><a href="news_edit">Add New</a></p>
</div>