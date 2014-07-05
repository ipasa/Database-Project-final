<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_neticketing = "localhost";
$database_neticketing = "nticketing_project";
$username_neticketing = "root";
$password_neticketing = "";
$neticketing = mysql_pconnect($hostname_neticketing, $username_neticketing, $password_neticketing) or trigger_error(mysql_error(),E_USER_ERROR); 
?>