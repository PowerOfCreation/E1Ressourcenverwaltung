<?php

require_once("/app/config/credentials.php");
include("../../database_structure.php");
//More checks required...

function checkPostValues()
{
    if (
        empty($_POST["ProjectName"])
        || empty($_POST["ProjectOwner"])
        || empty($_POST["Color"])
        || empty($_POST["Topic"])
        || empty($_POST["End"])
    ) return FALSE;
}

if (checkPostValues() === TRUE ) 
{
	// Example how to use POST'ed values
	$projectName = htmlspecialchars($_POST["ProjectName"]);
	$projectOwner = htmlspecialchars($_POST["ProjectOwner"]);
	$topic = htmlspecialchars($_POST["Topic"]);
	$color = htmlspecialchars($_POST["Color"]);
	$end = htmlspecialchars($_POST["End"]);

	$color = substr($color,1);
	$add_project = $connection->prepare("INSERT INTO Project(ProjectName, ProjectOwner, Color, Topic, End) VALUES(?, ?, ?, ?,  ?);");
	$add_project->bind_param('sisss', $projectName, $projectOwner, $color, $topic, $end);

	if($add_project->execute())
	{
		echo "Projekt " . $projectName . " erfolgreich angelegt.";
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
</head>

<body>
	<main>
		<h1 style="text-align: justify;">Projekt Erstellen</h1>
        <div>
            <form name="RegForm" id="register-form" method="post">
                Projektname:
					<input id="project-name-input" type="text" size="65" name="ProjectName" placeholder="Musterprojekt"/>

                Verantwortlicher:  
					<select id="project-owner-select" name = "ProjectOwner">
						<option selected="true" disabled="disabled" hidden="true" value="">Wähle Verantwortlichen</option>
						<?php 
							$result = $connection->query("SELECT * FROM User;");
							while ($row = $result->fetch_object()) 
							{
								echo "<option value='" . $row->UserId . " '>" . $row->Forename . " " .  $row->Surname . "</option>";
							}			
						?>
					</select>

                Thema:              
					<textarea rows="4"  cols="64" id="project-topic-textarea" name="Topic"></textarea>
                
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

				<script src="../../jquery-3.6.0.js"></script>
				<script src="new-project.js"></script>
		    </form>
        </div>	
	</main>    
</body>

</html>