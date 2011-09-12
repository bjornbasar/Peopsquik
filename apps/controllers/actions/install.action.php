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

mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);

$fh = fopen(APP_LIB . 'istrbuddy.sql', $mode);