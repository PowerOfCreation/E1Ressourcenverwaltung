<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];

include("/app/config/credentials.php");

include($rootPath . "/database_structure.php");

$json = file_get_contents('php://input');

$data = json_decode($json);

if (!isset($data->projectId)) exit_failure("projectId missing in POST data");

function bulk_prepared_statement($connection, $statement, $data)
{
    $projectId = $data->projectId;

    if (!$connection->begin_transaction()) {
        exit_failure();
    }

    foreach ($data->userIds as $userId) {
        $statement->bind_param('ii', $projectId, $userId);
        $statement->execute();
    }

    if ($connection->commit()) {
        echo (json_encode(["success" => "true"]));
    } else {
        exit_failure();
    }

    $statement->reset();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "PUT":
        if (!isset($data->userIds)) exit_failure("userIds missing in POST data");

        if (!($insert_user_into_project_statement = $connection->prepare("INSERT IGNORE INTO User_Project(ProjectId, UserId) VALUES (?, ?);"))) {
            exit_failure();
        }

        bulk_prepared_statement($connection, $insert_user_into_project_statement, $data);

        break;
    case "DELETE":
        if (!isset($data->userIds)) exit_failure("userIds missing in POST data");

        if (!($delete_user_from_project_statement = $connection->prepare("DELETE FROM User_Project WHERE ProjectId = ? AND UserId = ?;"))) {
            exit_failure();
        }

        bulk_prepared_statement($connection, $delete_user_from_project_statement, $data);

        break;
    default:
        if (!($get_project_users_statement = $connection->prepare("Select UserId, Username From User Where UserId IN (SELECT UserId FROM User_Project WHERE ProjectId = ?);"))) {
            echo "Prepare failed " . $connection->error;
        }

        $get_project_users_statement->bind_param('i', $data->projectId);

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
