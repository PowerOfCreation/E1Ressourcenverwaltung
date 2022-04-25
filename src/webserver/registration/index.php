<?php

require_once("/app/config/credentials.php");

//More checks required...
if (isset($_POST["Username"]) && !empty(htmlspecialchars($_POST["Username"]))) {
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
	$add_user_statement->reset();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Mitarbeiter hinzufügen</title>
    <link rel="stylesheet" href="registration_style.css">
</head>

<body>
	<main>
		<h1 style="text-align: justify;">Mitarbeiter Hinzufügen</h1>
		<div id="form-wrapper-div">
			<form id = "registration-form" name="RegForm" method="post">                                
				Benutzername: <input type="text" name="Username" />

				Vorname: <input type="text" name="Forename" />
				
				Nachname: <input type="text" name="Surname" />
				
				Abteilung:  
				<select name = "Department">
					<?php 
						$result = $connection->query("SELECT * FROM Department;");

						while ($row = $result->fetch_object()) 
						{
							echo "<option value='" . $row->DepartmentId . " '>" . $row->DepartmentName . "</option>";
						}				
					?>
				</select>
				
				E-mail: <input type="text" name="EMail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" requiered title="Bitte überprüfen Sie das Format der eingegebenen E-Mail-Adresse."/>
				
				Passwort: <input type="password" name="Password" id="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" requiered title="Mindestens 8 Zeichen, 1 Ziffer, 1 Großbuchstabe und 1 Sonderzeichen erforderlich."/>
				<label for="check"><input id="check" type="checkbox" onclick="showPassword()" />Passwort anzeigen</label>
<!--				Passwort wiederholen: <input type="password" name="repeatPassword" onkeyup='repeatPw();'/>
				<span id='password-message-span'></span>
-->
				<div id="form-action-buttons-wrapper-div">
					<a href=".."><button id="back-button" type="button">Zurück</button></a>
					<input type="submit" value="Benutzer erstellen" name="Submit" />
				</div>
			</form>
		</div>
	</main>
    <script src="../jquery-3.6.0.js"></script>
    <script src="js/registration.js"></script>
</body>

</html>