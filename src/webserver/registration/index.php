<?php
//More checks required...
if (!empty($_POST["Username"])) {

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
			box-sizing: border-box;
			width: 100%;
			border: 100px solid black;
			float: left;
			align-content: center;
			align-items: center;
		}

		form {
			margin: 0 auto;
			width: 600px;
		}
	</style>
</head>

<body>
	<main>
		<h1 style="text-align: justify;">Mitarbeiter Hinzufügen</h1>
		<form name="RegForm" method="post">
			<p>Benutzername: <input type="text" size="60" name="Username" /></p>
			<br />
			<p>Vorname: <input type="text" size="65" name="Forename" /></p>
			<br />
			<p>Nachname: <input type="text" size="65" name="Surname" /></p>
			<br />
			<p>Abteilung: <input type="text" size="65" name="DepartmentId" /></p>
			<br />
			<p>E-mail: <input type="text" size="65" name="EMail" /></p>
			<br />
			<p>Passwort: <input type="password" size="65" name="Password" /></p>
			<br />


			<br />
			<br />
			<p>
				<input type="submit" value="Benutzer erstellen" name="Submit" />
			</p>
		</form>
		<button onclick="history.back()">Abbrechen und zurück</button>
	</main>
</body>

</html>