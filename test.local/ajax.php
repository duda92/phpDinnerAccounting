<?php

require_once 'conf.php';
require_once 'connect.php';
require_once 'lib/class.order.php';

global $con;
$classOrder = new order();

switch($_REQUEST['action']) {
    case 'add-order':
        $data = explode('_', base64_decode($_REQUEST['order_data']));
        $date = $data[0];
        $user = intval($data[1]);
        $classOrder->saveOrder(array('date' => $date,
                                     'user' => $user,
                                     'menuid' => intval($_REQUEST['menuid'])));
        break;
		
	case 'get-total-amount':
		$data = explode('_', base64_decode($_REQUEST['order_data']));
        $date = $data[0];
        $user = intval($data[1]);
		$userTotal = $classOrder->getUserOrdersTotalAmount($user, $date);
		echo ($userTotal>0) ? sprintf('%.2f', $userTotal).' грн.' : '';
		break;
		
}


exit;
?>