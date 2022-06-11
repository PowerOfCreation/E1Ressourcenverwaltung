<?php

if(defined('UNIT_TESTING') && UNIT_TESTING == 1) return;

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
	header("location: /login/login.php");
	exit;
}

echo "Eingeloggt als <a href='/mitarbeiter/?name={$_SESSION["username"]}'>{$_SESSION["username"]}</a>. <a href='/login/logout.php'>Logout</a><br>"; 

?>