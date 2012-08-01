<?php

require_once 'conf.php';
require_once 'connect.php';
require_once 'lib/class.common.php';
require_once 'lib/class.order.php';

global $con;
global $calendar;
error_reporting(1);
session_start();

$classCommon = new common();
$classOrder = new order();

if(!$classCommon->isVerifiedUser($_GET['logout'] == 1)){
    session_unset();
    $classCommon->authenticate();
} else {
    $verify = $classCommon->verifiedUser();
    if($verify['result']) {
        $calendar = $classCommon->fillCalendar();
        //echo 'Welcome ' . $_SESSION["displayname"];
      
    }
    else {
        //echo $verify['message'];
        //echo '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to try again.';
    }
}

include 'html/index.phtml';

?>
