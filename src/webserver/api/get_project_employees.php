<?php
    if(!isset($_GET["project"])) return;

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    // The MySQL service named in the docker-compose.yml.
    include("/app/config/credentials.php");

    include("../database_structure.php");

    $projectname = htmlspecialchars($_GET["project"]);

    if(!($get_project_users_statement = $connection->prepare("Select UserId, Username From User Where UserId IN (SELECT UserId FROM User_Project WHERE ProjectId = (SELECT ProjectId From Project Where ProjectName = ?));"))) {
        echo "Prepare failed " . $connection->error;
    }

    $get_project_users_statement->bind_param('s', $projectname);

    if ($get_project_users_statement->execute()) {
        $get_project_users_statement->bind_result($UserId, $UserName);

        $result_json_array = array();

        while ($row = $get_project_users_statement->fetch()) {
            array_push($result_json_array, (object) array("UserId" => $UserId, "UserName" => $UserName));
        }

        $result_json_array = array_reverse($result_json_array);
        
        echo(json_encode($result_json_array));

        $get_project_users_statement->reset();
    }
?>