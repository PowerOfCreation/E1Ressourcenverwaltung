<?php
    if(!isset($_GET["name"])) return;

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    // The MySQL service named in the docker-compose.yml.
    include("/app/config/credentials.php");

    include("../database_structure.php");

    $username = htmlspecialchars($_GET["name"]);

    if(!($get_user_projects_statement = $connection->prepare("SELECT ProjectId, ProjectName FROM Project WHERE ProjectId IN (SELECT ProjectId FROM User_Project WHERE UserId = (Select UserId From User Where Username = ?));"))) {
        echo "Prepare failed " . $connection->error;
    }

    $get_user_projects_statement->bind_param('s', $username);

    if ($get_user_projects_statement->execute()) {
        $get_user_projects_statement->bind_result($projectId, $projectName);

        $result_json_array = array();

        while ($row = $get_user_projects_statement->fetch()) {
            array_push($result_json_array, (object) array("projectId" => $projectId, "projectName" => $projectName));
        }

        $result_json_array = array_reverse($result_json_array);
        
        echo(json_encode($result_json_array));

        $get_user_projects_statement->reset();
    }
?>