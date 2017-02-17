<?php

// DB Connection
$mysql_db_hostname = "localhost";
$mysql_db_user = "root";
$mysql_db_password = "password";
$mysql_db_database = "dbname";

$dbc = mysql_connect($mysql_db_hostname, $mysql_db_user, 

$mysql_db_password) or die("Could not connect database");
mysql_select_db($mysql_db_database, $dbc) or die("Could not select database");

?>
