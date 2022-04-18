<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once("/app/config/credentials.php");

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Projekte</title>
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
		<h1 style="text-align: justify;">Projekt Verwaltung</h1>
		<form name="RegForm" id="registrierung" method="post">                                
        <div>
			

            Benutzername: <input type="text" size="65" name="Username" />

			Vorname: <input type="text" size="65" name="Forename" />
			
			Nachname: <input type="text" size="65" name="Surname" />
			
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
				
				<a href=".."><button id="back-button" type="button">Zurück</button></a>
				<button id="btn-new-projects">Projekt erstellen</button>   
		</form>
    </div>
	</main>
	<script src="../jquery-3.6.0.js"></script>
    <script src="../js/weekly-report.js"></script>
</body>

</html>