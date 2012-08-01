<?php

define('SITE_TITLE', 'Обеды в DataArt - Харьков');
define('DA_DOMAIN', 'universe');
define('DA_LDAP_SERVER_1', '192.168.160.35');
define('DA_LDAP_SERVER_2', '192.168.10.16');
define('DA_LDAP_SERVER_PORT', '389');
define('DA_LDAP_SERVER_TIMEOUT', '60');
define('DA_LDAP_DOMAIN_INFO', 'dc=universe,dc=dart,dc=spb');

define('DB_NAME', 'lunch');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost'); 


global $dayOfWeek;
$dayOfWeek = array('Monday' => 'ПН',
				   'Tuesday' => 'ВТ',
				   'Wednesday' => 'СР',
				   'Thursday' => 'ЧТ',
				   'Friday' => 'ПТ',
                   'Saturday' => 'СБ',
                   'Sunday' => 'ВС');

?>