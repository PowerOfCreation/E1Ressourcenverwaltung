<?php
include("/app/config/credentials.php");

include("../../database_structure.php");

$json = file_get_contents('php://input');

$data = json_decode($json);

if (!isset($data->projectId)) exit_failure("projectId missing in POST data");

switch($_SERVER["REQUEST_METHOD"]) {
    case "DELETE":
        //delete status
        $stmt = $connection->prepare("DELETE FROM Status WHERE ProjectId = ?;");
        $stmt->bind_param('i', $data->projectId);
        if($stmt->execute()) {
            echo "Status deleted";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

        //delete User_Project
        $stmt = $connection->prepare("DELETE FROM User_Project WHERE ProjectId = ?;");
        $stmt->bind_param('i', $data->projectId);
        if($stmt->execute()) {
            echo "User_Project deleted";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

        //delete Project
        $stmt = $connection->prepare("DELETE FROM Project WHERE ProjectId = ?;");
        $stmt->bind_param('i', $data->projectId);
        if($stmt->execute()) {
            echo "Project deleted";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        
        break;
}
