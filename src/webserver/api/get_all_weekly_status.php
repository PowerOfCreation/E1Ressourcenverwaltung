<?php
    //input: http://localhost/api/get_all_weekly_status.php?allCalendarWeek=18&allYear=2022
    //output: {"calendarWeek":"18","weekdays":["2022-05-02","2022-05-03","2022-05-04","2022-05-05","2022-05-06"],"year":"2022"}

    include("/app/config/credentials.php");

    //check if params are complete
    if(!isset($_GET["allCalendarWeek"]) || !isset($_GET["allYear"])) {
        echo "Error: calendarWeek and year are required";
        exit;
    }

    $calendarWeek = htmlspecialchars($_GET["allCalendarWeek"]);
    $year = htmlspecialchars($_GET["allYear"]);

    //get dates of $calendarWeek
    require_once("/app/public/api/get_calendar_week.php");
    $res = get_calendar_week($calendarWeek, "en");
    
    //decode response
    $response = json_decode($res);

    //convert date format to YYYY-MM-DD    
    $weekdays = array();
    $i = 0;

    if(is_array($response)) {
        foreach($response["weekdays"] as $day) {
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
    
    //echo "all: ".json_encode($statuses);
?>