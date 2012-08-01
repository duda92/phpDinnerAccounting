<?php

class order {
    public function saveOrder($params) {
        global $con;
        $query = "SELECT * FROM orders WHERE user=".intval($params['user'])." AND menu_id=".intval($params['menuid']);
        $res = mysql_query($query, $con);
        
        if(mysql_num_rows($res)==0)
        {
            $query = "SELECT * FROM menu WHERE id=".intval($params['menuid']);
            $res = mysql_query($query, $con); 
            $menu_info = mysql_fetch_object($res);
            #add only new user            
            $query = "INSERT INTO orders(amount, order_date, created_date, user, menu_id)
                      VALUES({$menu_info->price}, '".date('Y-m-d H:i:s', $params['date'])."', NOW(), ".intval($params['user']).", ".intval($params['menuid']).")";
            $res = mysql_query($query, $con);
        }            
    }
    
    public function getUserOrders($userID, $date=null) {    
        $rows = array();
        if(!$date) return $rows;
        
        global $con;
        $query = "SELECT o.*, m.item_name, m.item_info
                  FROM orders o INNER JOIN menu m ON m.id=o.menu_id
                  WHERE user=".intval($userID);
        $res = mysql_query($query, $con);        
        while($row = mysql_fetch_object($res)) {
            $rows[] = $row; 
        }
        return $rows;        
    }
	
	public function getUserOrdersTotalAmount($userID, $date=null) {    
        $rows = array();
        if(!$date) return $rows;
        
        global $con;
        $query = "SELECT SUM(o.amount) as total
                  FROM orders o INNER JOIN menu m ON m.id=o.menu_id
                  WHERE user=".intval($userID);
        $res = mysql_query($query, $con);        
        $row = mysql_fetch_object($res);        
        return $row->total;        
    }
	
	public function deleteOrder($orderId) {
		global $con;
        $query = "DELETE FROM orders WHERE id=".intval($orderId);
        $res = mysql_query($query, $con);
	}
}

?>