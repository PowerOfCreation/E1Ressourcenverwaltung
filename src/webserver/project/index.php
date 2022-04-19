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
			<input tpye = "text" name="ProjectName" value="<?php 
				$result = $connection->query("SELECT * FROM Project;");
				while ($row = $result->fetch_object()) 
				{
					if($row != NULL)
					{
						echo $row->ProjectName . "<br />";				
					}
				}			
			?>">

			
				
				<a href=".."><button id="back-button" type="button">Zurück</button></a>
				<button id="btn-new-projects">Projekt erstellen</button>   
		</form>
    </div>
	</main>
	<script src="../jquery-3.6.0.js"></script>
    <script src="../js/weekly-report.js"></script>
</body>

</html>