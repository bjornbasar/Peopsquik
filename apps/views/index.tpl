<?php
foreach($view['news'] as $news)
{
?>
	<div>	
		<h2><?php echo $news['title'];?></h2>
		<h6>Posted on <?php echo $news['date'];?></h6>

		<p>
		<?php echo $news['text'];?>
		</p>

		<br />
	</div>
<?php 
}
?>