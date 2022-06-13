<?php
    include("/app/config/credentials.php");

    //Aufruf: /api/add_status.php?user=1&project=2&date=2022-04-25
    if(!isset($_GET['user']) || !isset($_GET['project']) || !isset($_GET['date'])){
        echo "Error: missing parameters";
        exit;
    }
    $user = htmlspecialchars($_GET['user']);
    $project = htmlspecialchars($_GET['project']);
    $date = htmlspecialchars($_GET['date']);

    $stmt = $connection->prepare("DELETE FROM Status WHERE UserId = ? AND ProjectId = ? AND Day = ?;");
    $stmt->bind_param('iis', $user, $project, $date);
    if($stmt->execute()){
        echo "Status deleted";
        return true;
    }else{
        echo "Error: " . $stmt->error;
        return false;
    }
    $stmt->close();
?>