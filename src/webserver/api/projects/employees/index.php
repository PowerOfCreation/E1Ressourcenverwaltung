<?php
if (!isset($_GET["projectId"])) return;

$projectId = htmlspecialchars($_GET["projectId"]);

$rootPath = $_SERVER['DOCUMENT_ROOT'];

include("/app/config/credentials.php");

include($rootPath . "/database_structure.php");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "PUT":
        if (!isset($_GET["userId"])) return;

        $userId = htmlspecialchars($_GET["userId"]);

        if (!($insert_user_into_project_statement = $connection->prepare("INSERT IGNORE INTO User_Project(ProjectId, UserId) VALUES (?, ?);"))) {
            echo ("Prepare failed " . $connection->error);
        }

        $insert_user_into_project_statement->bind_param('ii', $projectId, $userId);

        if ($insert_user_into_project_statement->execute()) {
            echo (json_encode(["success" => "true"]));
        } else {
            http_response_code(500);
            echo (json_encode(["success" => "false"]));
            exit();
        }

        $insert_user_into_project_statement->reset();

        break;
    case "DELETE":
        if (!isset($_GET["userId"])) return;

        $userId = htmlspecialchars($_GET["userId"]);

        if (!($delete_user_from_project_statement = $connection->prepare("DELETE FROM User_Project WHERE ProjectId = ? AND UserId = ?;"))) {
            echo ("Prepare failed " . $connection->error);
        }

        $delete_user_from_project_statement->bind_param('ii', $projectId, $userId);

        if ($delete_user_from_project_statement->execute()) {
            echo (json_encode(["success" => "true"]));
        } else {
            http_response_code(500);
            echo (json_encode(["success" => "false"]));
            exit();
        }

        $delete_user_from_project_statement->reset();

        break;
    default:
        if (!($get_project_users_statement = $connection->prepare("Select UserId, Username From User Where UserId IN (SELECT UserId FROM User_Project WHERE ProjectId = ?);"))) {
            echo "Prepare failed " . $connection->error;
        }

        $get_project_users_statement->bind_param('i', $projectId);

        if ($get_project_users_statement->execute()) {
            $get_project_users_statement->bind_result($userId, $userName);

            $result_json_array = array();

            while ($row = $get_project_users_statement->fetch()) {
                array_push($result_json_array, (object) array("userId" => $userId, "userName" => $userName));
            }

            $result_json_array = array_reverse($result_json_array);

            echo (json_encode($result_json_array));

            $get_project_users_statement->reset();
        }
}
