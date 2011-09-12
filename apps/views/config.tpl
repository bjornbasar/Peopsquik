<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>{$TEMPLATE_TITLE}</title>
        <base href="{$smarty.const.APP_URI}">
        <link href="{$smarty.const.APP_INCLUDES}css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="{$smarty.const.APP_INCLUDES}js/mootools.js"></script>
		<script type="text/javascript" src="{$smarty.const.APP_INCLUDES}js/mooCenter.js"></script>
    </head>
	<body>
		{if $error}
		<h3>The system is not properly setup.</h3>
		
		<p>Kindly run the <a href="sysinit">Installation Script</a> to create the configuration files and setup the database.</p>
		
		{/if}
		
	</body>
</html>