<?php
require_once '../conf.php';
require_once '../connect.php';
require_once '../lib/class.order.php';

$classOrder = new order();

error_reporting(E_ALL ^ E_NOTICE);

header("Content-type: text/xml");
echo('<?xml version="1.0" encoding="windows-1251"?>'); 

$mode = $_GET["!nativeeditor_status"]; //get request mode
$rowId = $_GET["gr_id"]; //id or row which was updated 
$newId = $_GET["gr_id"]; //will be used for insert operation


switch($mode){
	case "inserted":
		//row adding request
		$action = 'insert';
	break;
	case "deleted":
		//row deleting request
		$classOrder->deleteOrder($rowId);
		$action = 'delete';
	break;
	default:
		//row updating request		
		$action = 'update';
	break;
}


//output update results
echo "<data>";
echo "<action type='".$action."' sid='".$rowId."' tid='".$newId."'/>";
echo "</data>";
?>