<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>{$TEMPLATE_TITLE}{if $modulename} - {$modulename}{/if}</title>
        <base href="{$smarty.const.APP_URI}">
        <link href="{$smarty.const.APP_INCLUDES}css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="{$smarty.const.APP_INCLUDES}js/mootools.js"></script>
		<script type="text/javascript" src="{$smarty.const.APP_INCLUDES}js/mooCenter.js"></script>
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
