<?php
    //input: http://localhost/api/get_all_weekly_status.php?calendarWeek=18&year=2022
    //output: [{"StatusId":4,"UserId":1,"ProjectId":221,"Day":"2022-05-06"},{"StatusId":5,"UserId":1,"ProjectId":221,"Day":"2022-05-03"},{"StatusId":6,"UserId":1,"ProjectId":221,"Day":"2022-05-05"}]

    include("/app/config/credentials.php");

    //check if params are complete
    if(!isset($_GET["calendarWeek"]) || !isset($_GET["year"])) {
        echo "Error: calendarWeek and year are required";
        exit;
    }

    $calendarWeek = htmlspecialchars($_GET["calendarWeek"]); //ist ein String
    $year = htmlspecialchars($_GET["year"]);

    //get dates of $calendarWeek
    require_once("get_calendar_week.php");
    $res = get_calendar_week($calendarWeek, "en");

    //convert date format to YYYY-MM-DD    
    $weekdays = array();
    $i = 0;

    if(is_array($res)) {
        foreach($res["weekdays"] as $day) {
            $weekdays[$i] = date("Y-m-d", strtotime($day));
            $i++;
        }
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