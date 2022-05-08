<?php
    include("/app/config/credentials.php");

    //Aufruf: /api/add_status.php?user=1&project=2&date=2022-04-25
    if(!isset($_GET['user']) || !isset($_GET['project']) || !isset($_GET['date'])){
        echo "Error: missing parameters";
        exit;
    }
    $user = $_GET['user'];
    $project = $_GET['project'];
    $date = $_GET['date'];

    $stmt = $connection->prepare("INSERT INTO Status (UserId, ProjectId, Day) VALUES (?, ?, ?)");
    $stmt->bind_param('iii', $user, $project, $date);
    if($stmt->execute()){
        echo "Status added";
        $stmt->close();
        return true;
    }else{
        echo "Error: " . $stmt->error;
        $stmt->close();
        return false;
    }
?>