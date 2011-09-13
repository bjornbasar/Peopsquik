<?php

extract($_POST, EXTR_REFS);

$fh = fopen(APP_CONF . 'config.php', 'w+');

$content = '<?php

/**
 * Database configurations
 */

$db[\'user\'] = \'' . $dbuser . '\';
$db[\'pass\'] = \'' . $dbpass . '\';
$db[\'name\'] = \'' . $dbname . '\';
$db[\'host\'] = \'' . $dbhost . '\';

?>';

fwrite($fh, $content);

fclose($fh);

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname);

$fh = fopen(APP_LIB . 'istrbuddy.sql', 'r');

$content = fread($fh, filesize(APP_LIB . 'istrbuddy.sql'));

$queries = explode(';', trim($content, " ;"));
array_pop($queries);

foreach ($queries as $query)
{
	$query = trim($query);
	mysql_query($query) or die(mysql_error());
}

echo 'Insert into users values (\'\', \'1\', \'' . $admin . '\', \'' . $adminpassword . '\', \'Administrator\', \'System Administrator User\' )';

mysql_query('Insert into users values (\'\', \'1\', \'' . $admin . '\', \'' . $adminpassword . '\', \'Administrator\', \'System Administrator User\', 1 )') or die(mysql_error());

$this->forward('sysinstall');

