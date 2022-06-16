<?php
    include("/app/config/credentials.php");

    if(!isset($_GET["user"])) {
        echo "Error: missing parameters";
        exit();
    }

    $user = htmlspecialchars($_GET["user"]);

    //get UserId from username
    $stmt = $connection->prepare("SELECT UserId FROM User WHERE Username = ?;");
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    $userId = $row['UserId'];

    //delete all status of user
    $stmt = $connection->prepare("DELETE FROM Status WHERE UserId = ?;");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();

    //delete User_Project
    $stmt = $connection->prepare("DELETE FROM User_Project WHERE UserId = ?;");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();

    //delete project
    $stmt = $connection->prepare("DELETE FROM Project WHERE ProjectOwner = ?;");
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $stmt->close();

    //delete user
    $stmt = $connection->prepare("DELETE FROM User WHERE UserId = ?;");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();
?>