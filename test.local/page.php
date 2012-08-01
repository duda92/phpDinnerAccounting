<?php
define('DB_NAME', 'sfera');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost'); 

global $con;

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) die('Could not connect: ' . mysql_error());

mysql_select_db(DB_NAME);
mysql_set_charset('cp1251'); 

echo 1;
?>