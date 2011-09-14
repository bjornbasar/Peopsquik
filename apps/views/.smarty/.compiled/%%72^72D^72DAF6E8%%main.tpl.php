<?php /* Smarty version 2.6.25, created on 2011-09-14 10:04:15
         compiled from main.tpl */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $this->_tpl_vars['TEMPLATE_TITLE']; ?>
<?php if ($this->_tpl_vars['modulename']): ?> - <?php echo $this->_tpl_vars['modulename']; ?>
<?php endif; ?></title>
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

		<div id="wrapper">

			<div id="content">

				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<div id="main">

				 	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['body'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				</div><!-- end #main -->

				<br class="clear" />

			</div><!-- end #content -->

	 	</div><!-- end #wrapper -->

	</body>
</html>