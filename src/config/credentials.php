<?php

// DEBUG
ini_set('display_startup_errors', '1');
ini_set('display_errors', '1');
error_reporting(-1);

$host = 'database';
// Database use name
$user = 'MYSQL_USER';

//database user password
$pass = 'MYSQL_PASSWORD';

$dbname = 'MY_DATABASE';

// check the MySQL connection status
$connection = new mysqli($host, $user, $pass, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

unset($host, $user, $pass, $dbname);

?>