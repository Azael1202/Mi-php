<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Conexion = "localhost";
$database_Conexion = "productos";
$username_Conexion = "root";
$password_Conexion = "1234";
$Conexion = mysql_pconnect($hostname_Conexion, $username_Conexion, $password_Conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>