<?php
function checkPassword(string $password): string
{
	$error_message = "";

	if(strlen($password) < 7) {
		$error_message .= "Das Passwort muss mindestens 8 Zeichen lang sein.<br>";
	} 
	if(!preg_match('@[a-z]@',$password)) {
		$error_message .= "Das Passwort muss mindestens 1 Kleinbuchstabe enthalten.<br>";
	}	  
	if(!preg_match('@[A-Z]@',$password)) {
		$error_message .= "Das Passwort muss mindestens 1 Großbuchstabe enthalten.<br>";
	}
	if(!preg_match('@[0-9]@',$password)) {
		$error_message .= "Das Passwort muss mindestens 1 Ziffer enthalten.<br>";
	}

	return $error_message;
}
