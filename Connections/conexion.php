<?php
$hostname_conexion = "localhost";
$database_conexion = "bd_emaus_tesoreria";
$username_conexion = "user_tesoreria";
$password_conexion = "pass_tesoreria";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>