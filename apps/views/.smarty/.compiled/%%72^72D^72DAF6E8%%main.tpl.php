<?php /* Smarty version 2.6.25, created on 2011-09-07 15:53:35
         compiled from main.tpl */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $this->_tpl_vars['TEMPLATE_TITLE']; ?>
</title>
        <base href="<?php echo @APP_URI; ?>
">
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