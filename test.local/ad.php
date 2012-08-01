<?php

error_reporting(1);
session_start();

function authenticate() {
   header('WWW-Authenticate: Basic realm="Active Directory Login"');
   header('HTTP/1.0 401 Unauthorized');
   echo 'Sorry, you must login using the correct user and pass.';
   echo '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to try again.';
   exit;
}

if(!isset($_SERVER['PHP_AUTH_USER']) || ($_GET['logout'] == 1 && isset($_SESSION['user']) && isset($_SESSION['domain']))){
   session_unset();
   authenticate();
} else {
     $_SESSION["domain"] = $domain = 'UNIVERSE'; // <- your domain 
    $_SESSION["user"] = strtoupper($_SERVER["PHP_AUTH_USER"]); 
    $_SESSION["password"] = $_SERVER["PHP_AUTH_PW"]; 
    $LDAPServerAddress1="192.168.160.35"; // <- IP address for your 1st DC 
    $LDAPServerAddress2="192.168.10.16"; // <- IP address for your 2nd DC...and so on... 
    $LDAPServerPort="389"; 
    $LDAPServerTimeOut ="60"; 
    $LDAPContainer="dc=universe,dc=dart,dc=spb"; // <- your domain info 
    $BIND_username = "universe\\ipodosinovskaya"; // <- an account in AD to test using 
    $BIND_password = "3a4cPZ5j1";
    $filter = "sAMAccountName=".$_SESSION["user"]; 
    $login_error_code = 0;
    
    
    
   if(($ds=ldap_connect($LDAPServerAddress1)) || ($ds=ldap_connect($LDAPServerAddress2))) {
      
      ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      
      if($r=ldap_bind($ds,$BIND_username,$BIND_password)) {
           
         if($sr=ldap_search($ds, $LDAPContainer, $filter, array('distinguishedName'))) { 
            if($info = ldap_get_entries($ds, $sr)) {
               $BIND_username = $info[0]['distinguishedname'][0];
               $BIND_password = $_SERVER["PHP_AUTH_PW"];
               if ($r2=ldap_bind($ds,$BIND_username,$BIND_password)) {
                   var_dump(ldap_search($ds, $LDAPContainer, $filter, array("givenName","sn","mail","displayName")));
                  if($sr2=ldap_search($ds, $LDAPContainer, $filter, array("givenName","sn","mail","displayName"))) { echo 2;
                     if($info2 = ldap_get_entries($ds, $sr2)) {
                         var_dump($info2);
                        $_SESSION["name"] = $info2[0]["givenname"][0]." ".$info2[0]["sn"][0];
                        $_SESSION["email"] = $info2[0]["mail"][0];
                        $_SESSION["displayname"] = $info2[0]["displayname"][0];
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
            $login_error = "Could not search"; $login_error_code=5;
         }
      } else {
         $login_error = "Could not bind"; $login_error_code=6;
      }
   } else {
      $login_error = "Could not connect"; $login_error_code=7;
   }
   echo $login_error;
   if($login_error_code > 0){
      authenticate();
   } else {
      echo 'Welcome ' . $_SESSION["displayname"];
      echo '<br><br><a href="' . $PHP_SELF . '?logout=1">Click here</a> to logout and try again.';
   }
}


?>
