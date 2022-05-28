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
			<div id="button-width-container"> 
				<!-- neuen wrapper auf 100% und dann kind auf flex und500px und vllt wieder flex-->
				<div id="project-button-container">
					<a href="newproject"><button id="btn-new-projects" type="button">Projekt erstellen</button></a>
					<a href="deleteproject"><button id="btn-delet-project" type="button">Projekt löschen</button></a>
				</div>
				<a href=".."><button id="back-button" type="button">Zurück</button></a>	
			</div>
		</div>
	</main>
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/project.js"></script>
</body>

</html>