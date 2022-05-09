<?php
    include("/app/config/credentials.php");

    //check if params are complete
    if(!isset($_GET["calendarWeek"]) || !isset($_GET["year"])) {
        echo "Error: calendarWeek and year are required";
        exit;
    }

    $calendarWeek = htmlspecialchars($_GET["calendarWeek"]);
    $year = htmlspecialchars($_GET["year"]);

    //get dates of $calendarWeek
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://localhost:80/api/get_calendar_week.php?week=".$calendarWeek);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($curl);
    curl_close($curl);

    //decode response
    $response = json_decode($res, true);

    //convert date format to YYYY-MM-DD    
    $weekdays = array();
    $i = 0;
    foreach($response["weekdays"] as $day) {
        $weekdays[$i] = date("Y-m-d", strtotime($day));
        $i++;
    }
    
    //call database
    $stmt = $connection->prepare("SELECT * FROM `Status` WHERE `day` BETWEEN ? AND ?");
    $stmt->bind_param("ss", $weekdays[0], $weekdays[4]);
    if($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Error: ".$stmt->error;
        exit;
    }
    $stmt->close();

    //create array with all statuses
    $statuses = array();
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $statuses[$i] = $row;
        $i++;
    }
    
    echo json_encode($statuses);
?>