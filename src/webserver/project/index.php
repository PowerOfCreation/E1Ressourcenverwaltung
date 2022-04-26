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
   
</script>

</head>

<body>
	<main>
		<h1 style="text-align: justify;">Projekt Verwaltung</h1>
		<form name="RegForm" id="registrierung" method="post">                                
        	<div>	
				Projekte: 
				<ul>
					<?php					
						$result = $connection->query("SELECT * FROM Project;");
						while ($row = $result->fetch_object()) 
						{						
							echo "<li>" . $row->ProjectName . "</li>";				
						}	
				
					?>
				</ul>		
				<a href="newproject"><button id="btn-new-projects" type="button">Projekt erstellen</button></a>
				<a href=".."><button id="back-button" type="button">Zurück</button></a>			
			</div>	
		</form>    
	</main>
</body>

</html>