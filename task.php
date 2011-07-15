#!/usr/bin/php
<?
require 'lib/config.php';

$command = "mysqldump --opt -h $db[host] -u$db[user] -p$db[pass] $db[name] > $db[name].sql";

echo $command . "\r\n";
exec($command);
