<?php
    include("/app/config/credentials.php");

    if(!isset($_GET['user'])){
        echo "Error: missing parameters";
        exit;
    }
    $user = htmlspecialchars($_GET['user']);

    //get UserId
    $stmt = $connection->prepare("SELECT UserId FROM User WHERE Username = ?;");
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    $userId = $row['UserId'];
    
    //delete all statuses of user
    $stmt = $connection->prepare("DELETE FROM Status WHERE UserId = ?;");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();

    //delete User_Project
    $stmt = $connection->prepare("DELETE FROM User_Project WHERE UserId = ?;");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();

    //obenren beiden Funktionieren, unteren beiden gehen nicht, aufgrund von Fremdschlüsseln
    //delete Project
    //wenn projekt gelöscht wird, müssen auch alle statuse des projektes gelöscht werden
    // $stmt = $connection->prepare("DELETE FROM Project WHERE ProjectOwner = ?;");
    // $stmt->bind_param('i', $userId);
    // $stmt->execute();
    // $stmt->close();

    //delete User
    //gelöschter user wird immer noch in der Tabelle angezeigt
    // $stmt = $connection->prepare("DELETE FROM User WHERE UserId = ?;");
    // $stmt->bind_param('i', $userId);
    // $stmt->execute();
    // $stmt->close();
?>