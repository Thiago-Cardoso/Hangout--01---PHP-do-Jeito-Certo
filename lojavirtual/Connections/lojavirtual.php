<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_lojavirtual = "localhost";
$database_lojavirtual = "curso_loja";
$username_lojavirtual = "root";//seu usuario
$password_lojavirtual = "";//sua senha
$lojavirtual = mysql_pconnect($hostname_lojavirtual, $username_lojavirtual, $password_lojavirtual) or trigger_error(mysql_error(),E_USER_ERROR); 
?>