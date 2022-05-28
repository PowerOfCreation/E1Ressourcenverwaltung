<?php

require_once("/app/config/credentials.php");
include("../../database_structure.php");
//More checks required...
if (isset($_POST["ProjectName"]) && !empty(htmlspecialchars($_POST["ProjectName"]))) {
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
	<link rel="stylesheet" href="newproject.css">
	<link rel="stylesheet" href="../../buttons.css" type="text/css">
	<link rel="stylesheet" href="../../font-size.css" type="text/css">
	<title>Projekt hinzufügen</title>
    <script type="text/javascript">
</script>

</head>

<body>
	<main>
		<h1>Projekt Erstellen</h1>
        <div>
            <form name="RegForm" id="registrierung" method="post">
                Projektname:
					<input type="text" size="65" name="ProjectName" placeholder="Musterprojekt" />

                Verantwortlicher:  
					<select name = "ProjectOwner">
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
                <div id="button-container">
					<!-- <input type="submit" value="Projekt erstellen" name="Submit" /> -->
					<a href=".."><button id="create-project-button" type="button">Projekt erstellen</button></a>
                    <a href=".."><button id="back-button" type="button">Zurück</button></a>
                </div>   		
		    </form>
        </div>	
	</main>    
</body>

</html>