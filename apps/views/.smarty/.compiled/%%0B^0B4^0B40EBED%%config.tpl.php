<?php /* Smarty version 2.6.25, created on 2011-09-14 10:04:11
         compiled from config.tpl */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $this->_tpl_vars['TEMPLATE_TITLE']; ?>
</title>
        <base href="<?php echo @APP_URI; ?>
">
        <link href="<?php echo @APP_INCLUDES; ?>
css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo @APP_INCLUDES; ?>
js/mootools.js"></script>
		<script type="text/javascript" src="<?php echo @APP_INCLUDES; ?>
js/mooCenter.js"></script>
    </head>
	<body>
		<?php if ($this->_tpl_vars['error']): ?>
		<h3>The system is not properly setup.</h3>
		
		<p>Kindly run the <a href="sysinit">Installation Script</a> to create the configuration files and setup the database.</p>
		
		<?php endif; ?>
		
	</body>
</html>