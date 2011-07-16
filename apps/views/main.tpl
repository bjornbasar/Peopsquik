<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>{$TEMPLATE_TITLE}</title>
        <base href="{$smarty.const.APP_URI}">
    </head>
	<body>

		<div id="wrapper">

			<div id="content">

				{include file='header.tpl'}

				<div id="main">

				 	{include file=$body}

				</div><!-- end #main -->

				<br class="clear" />

			</div><!-- end #content -->

	 	</div><!-- end #wrapper -->

	</body>
</html>
