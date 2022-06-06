<?php
    //input: http://localhost/api/get_all_weekly_status.php?calendarWeek=18&year=2022
    //output: [{"StatusId":4,"UserId":1,"ProjectId":221,"Day":"2022-05-06"},{"StatusId":5,"UserId":1,"ProjectId":221,"Day":"2022-05-03"},{"StatusId":6,"UserId":1,"ProjectId":221,"Day":"2022-05-05"}]

    include("/app/config/credentials.php");

    //check if params are complete
    if(isset($_GET["calendarWeek"]) && is_int(htmlspecialchars($_GET["calendarWeek"]))) {
        $calendarWeek = (int) htmlspecialchars($_GET["calendarWeek"]);
    }else {
        $calendarWeek = (int) date("W");
    }

    if(isset($_GET["year"]) && is_int(htmlspecialchars($_GET["year"]))) {
        $year = (int) htmlspecialchars($_GET["year"]);
    }else {
        $year = (int) date("Y");
    }

    //get dates of $calendarWeek
    require_once("get_calendar_week.php");
    $res = get_calendar_week($year, $calendarWeek, "en");

    //convert date format to YYYY-MM-DD    
    $weekdays = array();
    $i = 0;

        foreach($res["weekdays"] as $day) {
            $weekdays[$i] = date("Y-m-d", strtotime($day));
            $i++;
        }
    
    //call database
    $stmt = $connection->prepare("SELECT Status.`UserId`, Status.`ProjectId`, Status.`Day`, Project.`ProjectName` FROM `Status` INNER JOIN `Project` ON Status.`ProjectId` = Project.`ProjectId` WHERE Status.`Day` BETWEEN ? AND ?");
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