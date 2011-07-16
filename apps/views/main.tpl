<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo APP_TITLE?></title>
        <base href="<?php echo APP_URI?>">
    </head>
	<body>

		<div id="wrapper">

			<div id="content">

				<?php include 'header.tpl'?>

				<div id="main">

				 	<?php include $view['body']?>

				</div><!-- end #main -->

				<br class="clear" />

			</div><!-- end #content -->

	 	</div><!-- end #wrapper -->

	</body>
</html>
