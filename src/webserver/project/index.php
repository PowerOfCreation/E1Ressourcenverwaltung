<?php

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
		<form name="RegForm" id="registrierung" method="post">  
			<div id="content-container">                              
				<div id="projekte-container">	
					<h2>Projekte:</h2>
					<ul>
						<?php					
							$result = $connection->query("SELECT * FROM Project Order By ProjectName;");
							while ($row = $result->fetch_object()) 
							{						
								echo "<div class='projectname' data-project-id='" . $row->ProjectId . "'>" . $row->ProjectName . "</div><br/>";				
							}					
						?>
					</ul>
				</div>
				<div id="mitarbeiter-container">
					<h2>Mitarbeiter:</h2>	
					<ul>
						<?php					
							$result = $connection->query("SELECT * FROM User Order By Username;");
							while ($row = $result->fetch_object()) 
							{						
								echo "<input type='checkbox' class='user-checkbox' data-user-id='" . $row->UserId . "'>" . $row->Username . "</input><br/>";				
							}					
						?>
					</ul>			
				</div>	
			</div>
		</form>  
		<div id="button-container">
			<a href=".."><button id="back-button" type="button">Zurück</button></a>		
			<a href="newproject"><button id="btn-new-projects" type="button">Projekt erstellen</button></a>
		</div>
	</main>
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/project.js"></script>
</body>

</html>