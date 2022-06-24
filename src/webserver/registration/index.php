<?php

include("../login/checkForLogin.php");

require("registration_utility.php");

require_once("/app/config/credentials.php");

$password_error_messages = "";
$email_error_messages = "";

//More checks required...
if (isset($_POST["Username"]) && !empty(htmlspecialchars($_POST["Username"])) && !empty(htmlspecialchars($_POST["Forename"])) && !empty(htmlspecialchars($_POST["Surname"])) && !empty(htmlspecialchars($_POST["Department"])) && !empty(htmlspecialchars($_POST["EMail"])) && !empty(htmlspecialchars($_POST["Password"]))) {
	
	// Example how to use POST'ed values
	$username = htmlspecialchars($_POST["Username"]);
	$forename = htmlspecialchars($_POST["Forename"]);
	$surname = htmlspecialchars($_POST["Surname"]);
	$departmentId = htmlspecialchars($_POST["Department"]);
	$e_mail = htmlspecialchars($_POST["EMail"]);
	$password = htmlspecialchars($_POST["Password"]);
	
	if(!filter_var($e_mail, FILTER_VALIDATE_EMAIL)) {
		$email_error_messages = "Bitte eine gültige E-Mail-Adresse eingeben.";
	}
	
	$password_error_messages = checkPassword($password);

	if(empty($password_error_messages) && empty($email_error_messages))
	{
		$password = password_hash($password, PASSWORD_DEFAULT);

		$add_user_statement = $connection->prepare("INSERT INTO User(Username, Forename, Surname, DepartmentId, Email, Password) VALUES(?, ?, ?, ?, ?, ?);");

		$add_user_statement->bind_param('sssiss', $username, $forename, $surname, $departmentId, $e_mail, $password);

		if($add_user_statement->execute())
		{
			header("location: /index.php?registered_user={$username}");
		}
		else
		{
			echo "Fehler beim erstellen des Nutzers. Eingaben überprüfen.";
			echo $connection->error;
		}
		$add_user_statement->reset();
	}
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Mitarbeiter hinzufügen</title>
	<link rel="stylesheet" href="registration_style.css">
	<link rel="stylesheet" href="../buttons.css" type="text/css">
	<link rel="stylesheet" href="../font-size.css" type="text/css">

</head>

<body>
	
	<main>
		<h1>Mitarbeiter Hinzufügen</h1>
		<div id="form-wrapper-div">
			<form id = "registration-form" name="RegForm" method="post">                                
				Benutzername: <input class="textbox" type="text" autocomplete="username" name="Username" placeholder="Max123" required />

				Vorname: <input class="textbox" type="text" name="Forename" placeholder="Max" required />
				
				Nachname: <input class="textbox" type="text" name="Surname" placeholder="Mustermann" required />
				
				Abteilung:  
				<select class="textbox" name = "Department">
					<?php 
						$result = $connection->query("SELECT * FROM Department;");

						while ($row = $result->fetch_object()) 
						{
							echo "<option value='" . $row->DepartmentId . " '>" . $row->DepartmentName . "</option>";
						}				
					?>
				</select>
				
				E-mail: <input class="textbox" type="email" autocomplete="email" name="EMail" required title="Bitte überprüfen Sie das Format der eingegebenen E-Mail-Adresse." placeholder="max@mail.de" />
				<span class="text-danger"><?php echo $email_error_messages; ?></span>

				Passwort: <input class="textbox" type="password" autocomplete="new-password" name="Password" id="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required title="Mindestens 8 Zeichen, 1 Ziffer, 1 Kleinbuchstabe und 1 Großbuchstabe erforderlich." placeholder="Passwort" />
				<label for="check"><input id="check" type="checkbox" onclick="showPassword()" />Passwort anzeigen</label>
				<span class="text-danger"><?php echo $password_error_messages; ?></span>
				<div id="form-action-buttons-wrapper-div">
					<a href=".."><button id="back-button" type="button">Zurück</button></a>
					<button type="submit">Benutzer erstellen</button>
				</div>
			</form>
		</div>
	</main>
    <script src="../jquery-3.6.0.js"></script>
    <script src="js/registration.js"></script>
</body>

</html>