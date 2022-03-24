<?php
//More checks required...
if (!empty(htmlspecialchars($_POST["Username"]))) {

	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);

	require_once("/app/config/credentials.php");

	// Example how to use POST'ed values
	$username = htmlspecialchars($_POST["Username"]);
	$forename = htmlspecialchars($_POST["Forename"]);
	$surname = htmlspecialchars($_POST["Surname"]);
	$departmentId = htmlspecialchars($_POST["DepartmentId"]);
	$e_mail = htmlspecialchars($_POST["EMail"]);
	$password = password_hash(htmlspecialchars($_POST["Password"]), PASSWORD_DEFAULT);

	$add_user_statement = $connection->prepare("INSERT INTO User(Username, Forename, Surname, DepartmentId, Email, Password) VALUES(?, ?, ?, ?, ?, ?);");

	$add_user_statement->bind_param('sssiss', $username, $forename, $surname, $departmentId, $e_mail, $password);

	if($add_user_statement->execute())
	{
		echo "Nutzer " . $username . " erfolgreich angelegt.";
	}
	else
	{
		echo "Fehler beim erstellen des Nutzers. Eingaben überprüfen.";
		echo $connection->error;
	}
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Mitarbeiter hinzufügen</title>
	<style>
		div {
			width: 100%;
			border: 1px solid rgb(255, 255, 255);
			align-content: center;
			align-items: center;
            white-space: pre-line;
            display: inline-block;
		}
		form {
			margin: 0 auto;
			width: 500px;

    	}
	</style> 
    <script type="text/javascript">
    var repeatPw = function() {
     if (document.getElementById('registrierung').elements["Password"].value == document.getElementById('registrierung').elements["repeatPassword"].value) {
         document.getElementById('message').style.color = 'green';
         document.getElementById('message').innerHTML = 'Das Passwort stimmt überein';
     } 
     else {
             document.getElementById('message').style.color = 'red';
         document.getElementById('message').innerHTML = 'Das Passwort stimmt nicht überein';
     }
 }
</script>

</head>

<body>
	<main>
		<h1 style="text-align: justify;">Mitarbeiter Hinzufügen</h1>
		<form name="RegForm" id="registrierung" method="post">
			
        <div>
            Benutzername: <input type="text" size="65" name="Username" />

			Vorname: <input type="text" size="65" name="Forename" />
			
			Nachname: <input type="text" size="65" name="Surname" />
			
			Abteilung: <input type="text" size="65" name="DepartmentId" />
			
			E-mail: <input type="text" size="65" name="EMail" />
			
			Passwort: <input type="password" size="65" name="Password" onkeyup='repeatPw();' />

            Passwort wiederholen: <input type="password" size="65" name="repeatPassword" onkeyup='repeatPw();' />
			<span id='message'></span>

            
			<input type="submit" value="Benutzer erstellen" name="Submit" />
		</form>
		<button onclick="history.back()">Abbrechen und zurück</button>
    </div>
	</main>
    
</body>

</html>