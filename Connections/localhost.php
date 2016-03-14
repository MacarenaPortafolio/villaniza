<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_localhost = "localhost";
$database_localhost = "villaniza";
$username_localhost = "villaniza";
$password_localhost = "nhlwfwfrnvz5981m6nuo";
$localhost = mysql_connect($hostname_localhost, $username_localhost, $password_localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
?>