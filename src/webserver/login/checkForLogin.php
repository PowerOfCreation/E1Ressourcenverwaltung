<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
	header("location: /login/login.php");
	exit;
}

echo "Eingeloggt als {$_SESSION["username"]}. <a href='/login/logout.php'>Logout</a>"; 

?>