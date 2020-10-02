<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_db_engenho = "localhost";
$database_db_engenho = "eng_cana";
$username_db_engenho = "Administrador";
$password_db_engenho = "bd_TOP-Web";
$db_engenho = mysql_pconnect($hostname_db_engenho, $username_db_engenho, $password_db_engenho) or trigger_error(mysql_error(),E_USER_ERROR); 
?>