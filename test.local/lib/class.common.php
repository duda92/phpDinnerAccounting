<?php

class common {
    public function authenticate() {
        header('WWW-Authenticate: Basic realm="Active Directory Login"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Sorry, you must login using the correct user and pass.';   
        echo '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to try again.';
        exit;
    }
    
    public function isVerifiedUser($logout=0) {
        if(!isset($_SERVER['PHP_AUTH_USER']) || ($logout == 1 && isset($_SESSION['user']) && isset($_SESSION['domain']))) return false;
        else return true;
    }
    
    public function saveUser($params) {
        global $con;
        $query = "SELECT id FROM users WHERE email='{$params['email']}' AND login='{$params['name']}'";
        $res = mysql_query($query, $con);
        if(mysql_num_rows($res)==0)
        {
            #add only new user
            $query = "INSERT INTO users(login, email, name, date_created)
                      VALUES('{$params['name']}', '{$params['email']}', '{$params['displayname']}', NOW())";
            $res = mysql_query($query, $con);
            $userID = mysql_insert_id($res);
        }
        else
        {
            $row = mysql_fetch_object($res);
            $userID = $row->id;
        }
        return $userID;    
    }
    public function verifiedUser() {
        $_SESSION["domain"] = DA_DOMAIN;
        $_SESSION["user"] = strtoupper($_SERVER["PHP_AUTH_USER"]); 
        $_SESSION["password"] = $_SERVER["PHP_AUTH_PW"]; 
        
        $BIND_username = DA_DOMAIN."\\".$_SERVER["PHP_AUTH_USER"]; // <- an account in AD to test using 
        $BIND_password = $_SERVER["PHP_AUTH_PW"];
        $filter = "sAMAccountName=".$_SESSION["user"]; 
        $login_error_code = 0;
        
        if(($ds = ldap_connect(DA_LDAP_SERVER_1)) || ($ds=ldap_connect(DA_LDAP_SERVER_2))) {
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            
            if($r = ldap_bind($ds, $BIND_username, $BIND_password)) {
                if($sr = ldap_search($ds, DA_LDAP_DOMAIN_INFO, $filter, array('distinguishedName'))) { 
                    if($info = ldap_get_entries($ds, $sr)) {
                        $BIND_username = $info[0]['distinguishedname'][0];
                        $BIND_password = $_SERVER["PHP_AUTH_PW"];
                    
                        if($r2 = ldap_bind($ds, $BIND_username, $BIND_password)) {
                            if($sr2 = ldap_search($ds, DA_LDAP_DOMAIN_INFO, $filter, array("givenName","sn","mail","displayName"))) {
                                if($info2 = ldap_get_entries($ds, $sr2)) {                         
                                    $_SESSION["name"] = $name = $info2[0]["givenname"][0]." ".$info2[0]["sn"][0];
                                    $_SESSION["email"] = $email = $info2[0]["mail"][0];
                                    $_SESSION["displayname"] = $info2[0]["displayname"][0];                                    
                                    $_SESSION["userid"] = $this->saveUser(array('name' => $_SESSION["user"], 'email' => $email, 'displayname' => $name));
                                } else {
                                    $login_error = "Could not read entries"; $login_error_code=1;
                                }
                            } else {
                                $login_error = "Could not search"; $login_error_code=2;
                            }
                        } else {
                            $login_error = "User password incorrect"; $login_error_code=3;
                        }
                    } else {
                       $login_error = "User name not found"; $login_error_code=4;
                    }
                } else {
                    $login_error = "Could not find user info"; $login_error_code=5;
                }
            } else {
                $login_error = "Could not find user"; $login_error_code=6;
            }
        } else {
          $login_error = "Could not connect to server"; $login_error_code=7;
        }
        
        if($login_error_code > 0){
            return array('result' => false, 'message' => $login_error);
        } else {
            return array('result' => true, 'message' => '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to logout and try again.');
            /*
             *    echo 'Welcome ' . $_SESSION["displayname"];
            echo '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to logout and try again.';
             */
        }
    }     
    
    public function fillCalendar() {
        global $calendar;
        $classOrder = new order();        
        $userOrders = $classOrder->getUserOrders($user, $date);
    }
}

?>