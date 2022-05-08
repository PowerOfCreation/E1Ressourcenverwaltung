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
    <script type="text/javascript"></script>
</head>

<body>
	<main>
		<h1 style="text-align: justify;">Projekt Verwaltung</h1>
		<form name="RegForm" id="registrierung" method="post">                                
        	<div>	
				Projekte: 
				<ul>
					<?php					
						$result = $connection->query("SELECT * FROM Project Order By ProjectName;");
						while ($row = $result->fetch_object()) 
						{						
							echo "<div class='projectname' data-project-id='" . $row->ProjectId . "'>" . $row->ProjectName . "</div><br/>";				
						}					
					?>
				</ul>
				Mitarbeiter:	
				<ul>
					<?php					
						$result = $connection->query("SELECT * FROM User Order By Username;");
						while ($row = $result->fetch_object()) 
						{						
							echo "<input type='checkbox' class='user-checkbox' data-user-id='" . $row->UserId . "'>" . $row->Username . "</input><br/>";				
						}					
					?>
				</ul>		
				<a href="newproject"><button id="btn-new-projects" type="button">Projekt erstellen</button></a>
				<a href=".."><button id="back-button" type="button">Zurück</button></a>			
			</div>	
		</form>    
	</main>
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/project.js"></script>
</body>

</html>