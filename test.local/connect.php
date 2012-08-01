<?php

require_once 'conf.php';

global $con;

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db(DB_NAME);
mysql_set_charset('cp1251'); 

?>
