<?php

require_once("/app/config/credentials.php");
include("../../database_structure.php");
//More checks required...
function check()
{
	if(	   !empty($_POST["ProjectName"])
		&& ($_POST["ProjectOwner"] !== "Choose...")
		&& !empty($_POST["Color"])
		&& !empty($_POST["Topic"])
		&& !empty($_POST["End"]) ) return TRUE;

	else return FALSE;
}


if (check() == TRUE ) 
{
	// Example how to use POST'ed values
	$projectname = htmlspecialchars($_POST["ProjectName"]);
	$projectowner = htmlspecialchars($_POST["ProjectOwner"]);
	$color = htmlspecialchars($_POST["Color"]);
	$topic = htmlspecialchars($_POST["Topic"]);
	$end = htmlspecialchars($_POST["End"]);

	$color = substr($color,1);
	$add_project = $connection->prepare("INSERT INTO Project(ProjectName, ProjectOwner, Color, Topic, End) VALUES(?, ?, ?, ?,  ?);");
	$add_project->bind_param('sisss', $projectname, $projectowner, $color, $topic, $end);

	if($add_project->execute())
	{
		echo "Projekt " . $projectname . " erfolgreich angelegt.";
	}
	else
	{
		echo "Fehler beim Erstellen des Projektes. Eingaben überprüfen.";
		echo $connection->error;
	}
	$add_project->reset();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Projekt hinzufügen</title>
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
		<h1 style="text-align: justify;">Projekt Erstellen</h1>
        <div>
            <form name="RegForm" id="registrierung" method="post">
                Projektname:
					<input id="ProjectNameInput" type="text" size="65" name="ProjectName" placeholder="Musterprojekt" />

                Verantwortlicher:  
					<select id="ProjectOwnerSelect" name = "ProjectOwner">
						<option hidden="">Choose... </option>
						<?php 
							$result = $connection->query("SELECT * FROM User;");
							while ($row = $result->fetch_object()) 
							{
								echo "<option value='" . $row->UserId . " '>" . $row->Forename . " " .  $row->Surname . "</option>";
							}			
						?>
					</select>

                Thema:              
					<textarea rows="4"  cols="64" name="Topic"></textarea>
                
				Abgabedatum:
					<?php 
						$month = date('m');
						$day = date('d');
						$year = date('Y');
						$today = $year . '-' . $month . '-' . $day;
					?>
					<input type="date" size="65" name="End" value="<?php echo $today; ?>" min = "<?php echo $today; ?>"/>
    
				Farbe: 
					<input type="color" size="65" name="Color" />    

                <div>
					<input id="CreateProjectButton" type="submit" value="Projekt erstellen" name="CreateProject" />
                    <a href=".."><button id="backButton" type="button">Zurück</button></a>
                </div> 
				
				<script>
					let button = document.getElementById("CreateProjectButton");
					let name  = document.getElementById("ProjectNameInput");
					let owner = document.getElementById("ProjectOwnerSelect");

					button.addEventListener('click', function() { 
						if(name.value  == "" || owner.value  == "Choose...")
						{
							button.disabled = true; 
							alert("Bitte gib einen Namen und einen Verantwortlichen an!");
						} 
					});
					name.addEventListener(  'input', function() { if(name.value !== "" && owner.value !== "Choose...") button.disabled = false; });
					owner.addEventListener( 'input', function() { if(name.value !== "" && owner.value !== "Choose...") button.disabled = false; });
				</script>
		    </form>
        </div>	
	</main>    
</body>

</html>