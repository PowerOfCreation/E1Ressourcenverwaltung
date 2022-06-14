<?php

include("../login/checkForLogin.php");

require_once("/app/config/credentials.php");

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Projekte</title>
	<link rel="stylesheet" href="project.css">
	<link rel="stylesheet" href="../buttons.css" type="text/css">
	<link rel="stylesheet" href="../font-size.css" type="text/css">

    <script type="text/javascript"></script>
</head>

<body>
	<main>
		<h1>Projekt Verwaltung</h1>
			<div id="content-container">                              
				<div id="projects-container">	
					<h2>Projekte:</h2>
					<ul>
						<?php					
							$result = $connection->query("SELECT * FROM Project Order By ProjectName;");
						
							while ($row = $result->fetch_object()) 
							{						
								echo "<input type='radio' id='project-{$row->ProjectId}' name='project'><label for='project-{$row->ProjectId}' class='projectname' data-project-id='{$row->ProjectId}'>{$row->ProjectName}</label><br/>";
							}					
						?>
					</ul>
				</div>
				<div id="employees-container">
					<h2>Mitarbeiter:</h2>	
					<ul>
						<?php					
							$result = $connection->query("SELECT * FROM User Order By Username;");
							while ($row = $result->fetch_object()) 
							{						
								echo "<input type='checkbox' class='user-checkbox' id='user-{$row->UserId}' data-user-id='{$row->UserId}'><label for='user-{$row->UserId}'>{$row->Username}</label></input><br/>";
							}					
						?>
					</ul>			
				</div>	 
			</div>
		<div id="button-container">
			<div id="button-width-container"> 

				<div id="project-button-container">
					<button id="btn-delete-project" type="button">Projekt löschen</button>
					<a href="./newproject/"><button id="btn-new-projects" type="button">Projekt erstellen</button></a>
				</div>
				<a href=".."><button id="back-button" type="button">Zurück</button></a>	
			</div>
		</div>
	</main>
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/project.js"></script>
</body>

</html>