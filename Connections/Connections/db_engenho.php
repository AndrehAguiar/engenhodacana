<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_db_engenho = "eng_cana.mysql.dbaas.com.br";
$database_db_engenho = "u105074624_edc";
$username_db_engenho = "u105074624_andre";
$password_db_engenho = "bd_TOP-Web*741";
$db_engenho = mysql_pconnect($hostname_db_engenho, $username_db_engenho, $password_db_engenho) or trigger_error(mysql_error(),E_USER_ERROR); 
?>