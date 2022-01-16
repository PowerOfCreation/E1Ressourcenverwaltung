<?php
//More checks required...
if (!empty($_POST["Username"])) {

	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);

	require_once("/app/config/credentials.php");

	// Example how to use POST'ed values
	echo "Username: " . htmlspecialchars($_POST["Username"]) . "</br>";
	echo "Forename: " . htmlspecialchars($_POST["Forename"]) . "</br>";
	echo "Surname: " . htmlspecialchars($_POST["Surname"]) . "</br>";
	echo "DepartmentId: " . htmlspecialchars($_POST["DepartmentId"]) . "</br>";
	echo "EMail: " . htmlspecialchars($_POST["EMail"]) . "</br>";
	echo "Password: " . htmlspecialchars($_POST["Password"]) . "</br>";

	// Just an example how to do database queries
	$result = $connection->query("SELECT * FROM User;");

	echo "Alle Nutzer:</br>";

	while ($row = mysqli_fetch_array($result)) {
		echo $row["Username"] . "</br>";
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