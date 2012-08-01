<?php

require_once '../conf.php';
require_once '../connect.php';
require_once '../lib/class.order.php';

$classOrder = new order();
$data = explode('_', base64_decode($_REQUEST['order_data']));
$date = $data[0];
$user = intval($data[1]);
$userOrders = $classOrder->getUserOrders($user, $date);

error_reporting(E_ALL ^ E_NOTICE);
//include XML Header (as response will be in xml format)
header('Content-Type: text/xml; charset=windows-1251'); 
//header("Content-type: text/xml");

echo '<?xml version="1.0" encoding="windows-1251"?>';
echo '<rows id="'.$user.'">'; 
//echo mb_convert_encoding($order->item_name, 'utf-8');

foreach($userOrders as $order)
{
	echo '<row id="'.$order->id.'">
                <cell><![CDATA['.$order->item_name.']]></cell>
                <cell><![CDATA['.$order->item_info.']]></cell>
                <cell><![CDATA['.sprintf('%.2f', $order->amount).']]></cell>			
          </row>';		        
}
echo '</rows>';
?>