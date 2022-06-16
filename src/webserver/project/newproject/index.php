<?php

include("../../login/checkForLogin.php");

require_once("/app/config/credentials.php");
include("../../database_structure.php");
//More checks required...

function checkPostValues(): bool
{
    if (
        empty($_POST["ProjectName"])
        || empty($_POST["ProjectOwner"])
        || empty($_POST["Color"])
        || empty($_POST["Topic"])
        || empty($_POST["End"])
    ) return FALSE;

	return TRUE;
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
		$projectId =  $connection->insert_id;

		$add_project->reset();

		//insert Userid, projectid into User_Project
		$add_user_project = $connection->prepare("INSERT INTO User_Project(UserId, ProjectId) VALUES(?, ?);");
		$add_user_project->bind_param('ii', $projectOwner, $projectId);
		$add_user_project->execute();
		$add_user_project->reset();

		header("location: /index.php?created_project={$projectName}");
		exit(0);
	}
	else
	{
		echo "Fehler beim Erstellen des Projektes. Eingaben überprüfen.";
	}
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="newproject.css">
	<link rel="stylesheet" href="../../buttons.css" type="text/css">
	<link rel="stylesheet" href="../../font-size.css" type="text/css">
	<title>Projekt hinzufügen</title>
</head>

<body>
	<main>
		<h1>Projekt Erstellen</h1>
        <div id="form-wrapper-div">
            <form name="RegForm" id="register-form" method="post">
                Projektname:
					<input id="project-name-input" type="text" size="65" name="ProjectName" placeholder="Musterprojekt" required/>

                Verantwortlicher:  
					<select id="project-owner-select" name = "ProjectOwner" required>
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
					<textarea rows="4"  cols="64" id="project-topic-textarea" name="Topic" required></textarea>
                
					<div id="date-and-color-wrapper-div">
						<div id="date-wrapper-div">
						Abgabedatum:
							<?php 
								$month = date('m');
								$day = date('d');
								$year = date('Y');
								$today = $year . '-' . $month . '-' . $day;
							?>
							<input type="date" size="65" name="End" value="<?php echo $today; ?>" min = "<?php echo $today; ?>"/>
						</div>
						<div id="color-wrapper-div">
						Farbe: 
							<input type="color" size="65" name="Color" />
						</div>
					</div>            
                <div id="button-container">
					<a href=".."><button id="back-button" type="button">Zurück</button></a>
					<a href=".."><button id="create-project-button" type="submit">Projekt erstellen</button></a>
                </div>
				
				<script src="../../jquery-3.6.0.js"></script>
		    </form>
        </div>	
	</main>    
</body>

</html>