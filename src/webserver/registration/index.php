<?php

require_once("/app/config/credentials.php");

//More checks required...
if (isset($_POST["Username"]) && !empty(htmlspecialchars($_POST["Username"]))  && isset($_POST["Forename"]) && !empty(htmlspecialchars($_POST["Forename"])) && isset($_POST["Surname"]) && !empty(htmlspecialchars($_POST["Surname"])) && isset($_POST["DepartmentId"]) && !empty(htmlspecialchars($_POST["DepartmentId"])) && isset($_POST["EMail"]) && !empty(htmlspecialchars($_POST["EMail"])) && isset($_POST["Password"]) && !empty(htmlspecialchars($_POST["Password"]))) {
	// Example how to use POST'ed values
	$username = htmlspecialchars($_POST["Username"]);
	$forename = htmlspecialchars($_POST["Forename"]);
	$surname = htmlspecialchars($_POST["Surname"]);
	$departmentId = htmlspecialchars($_POST["DepartmentId"]);
	$e_mail = htmlspecialchars($_POST["EMail"]);
	$password = password_hash(htmlspecialchars($_POST["Password"]), PASSWORD_DEFAULT);

	if(!filter_var($e_mail,FILTER_VALIDATE_EMAIL)) {
		$e_mailError = "Bitte eine gültige E-Mail-Adresse eingeben.";
		}
	if(strlen($password) < 7) {
		$passwordErrorLength = "Das Passwort muss mindestens 8 Zeichen lang sein.";
		}   
	if(!preg_match("(?=\S*[A-Z])",$password)) {
		$passwordErrorUpperCase = "Das Passwort muss mindestens 1 Großbuchstabe enthalten.";
		}
	if(!preg_match("(?=\S*[\W])",$password)) {
		$passwordErrorSpecificCharacter = "Das Passwort muss mindestens 1 Sonderzeichen enthalten.";
		}	
	if(!preg_match("(?=\S*[\d])",$password)) {
		$passwordErrorNumber = "Das Passwort muss mindestens 1 Ziffer enthalten.";
		}	

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
	<link rel="stylesheet" href="../buttons.css" type="text/css">
	<link rel="stylesheet" href="../font-size.css" type="text/css">

</head>

<body>
	
	<main>
		<h1>Mitarbeiter Hinzufügen</h1>
		<div id="form-wrapper-div">
			<form id = "registration-form" name="RegForm" method="post">                                
				Benutzername: <input class="textbox" type="text" name="Username" placeholder="Max123" required />

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
				
				E-mail: <input class="textbox" type="email" name="EMail" required title="Bitte überprüfen Sie das Format der eingegebenen E-Mail-Adresse." placeholder="max@mail.de" />
				<span class="text-danger"><?php if (isset($e_mailError)) echo $e_mailError; ?></span>

				Passwort: <input class="textbox" type="password" name="Password" id="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required title="Mindestens 8 Zeichen, 1 Ziffer, 1 Großbuchstabe und 1 Sonderzeichen erforderlich." placeholder="Passwort!1" />
				<div id="show-pwd">
					<label for="check"><input id="check" type="checkbox" onclick="showPassword()" />Passwort anzeigen</label>
				</div>	
				<span class="text-danger"><?php if (isset($passwordErrorLength)) echo $passwordErrorLength; ?>
					<?php if (isset($passwordErrorUpperCase)) echo $passwordErrorUpperCase; ?>
					<?php if (isset($passwordErrorSpecificCharacter)) echo $passwordErrorSpecificCharacter; ?>
					<?php if (isset($passwordErrorNumber)) echo $passwordErrorNumber; ?></span>

<!--				Passwort wiederholen: <input type="password" name="repeatPassword" onkeyup='repeatPw();'/>
				<span id='password-message-span'></span>
-->
				<div id="form-action-buttons-wrapper-div">
					<a href=".."><button id="back-button" type="button">Zurück</button></a>
					<!--<input type="button" id="go" value="projekt-erstellen" /> -->
					<!--<<input type="submit" value="Benutzer erstellen" name="Submit" />  -->
					<a href=".."><button id="benutzer-create" type="button">Mitarbeiter erstellen</button></a> 
						<!--dann werden auch die dropdowns in der kalenderübersicht pink-->
				</div>
			</form>
		</div>
	</main>
    <script src="../jquery-3.6.0.js"></script>
    <script src="js/registration.js"></script>
</body>

</html>