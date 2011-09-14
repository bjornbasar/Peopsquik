<?php /* Smarty version 2.6.25, created on 2011-09-14 16:06:01
         compiled from main/login.tpl */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $this->_tpl_vars['TEMPLATE_TITLE']; ?>
 - Login</title>
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
		<div id="loginBox" class="centerbox">

			<h2><img src="includes/logo4.png"></h2>

			<form method="POST" action="login.do" id="loginform">

				<p>
					<label for="username">Username</label>
					<input type="text" name="username" id="username" autocomplete="off" />
				</p>
				<p>
					<label for="password">Password</label>
					<input type="password" name="password" id="password" autocomplete="off" />
				</p>
			
			</form> <!-- end form -->

			<div>

				<button class="submit" onclick="$('loginform').submit();">Sign In</button>
			
			</div>  <!-- end #button -->
			<script type="text/javascript">
				<?php echo '
				window.addEvent(\'domready\', function()
				{
					mooVCenter($(\'loginBox\'));
				});
				'; ?>

            </script>

		</div><!-- end #loginBox -->
	</body>
</html>
			