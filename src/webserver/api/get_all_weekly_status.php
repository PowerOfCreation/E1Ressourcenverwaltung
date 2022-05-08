<?php
/*
Beispiel:
/api/get_all_weekly_status.php?calenderWeek=17&year=2022
Response:
[[user: 2, day: 25.04.2022, project: 1], [user: ....]]
*/
    include("/app/config/credentials.php");
    echo "hi";
    if(!isset($_GET['calenderWeek']) || !isset($_GET['year'])){
        echo "Error: missing parameters";
        exit;
    }

    $calenderWeek = $_GET['calenderWeek'];
    $year = $_GET['year'];


    $foo = strtotime(sprintf("%4dW%02d", $year, $calenderWeek));

    echo "foo: ".$foo."<br>";

    $format = "d.m.Y";

    //increment or decrement $week to change calendar week
    if(!isset($_GET['week'])){
        $week = -1;
    }else{
        $week = $_GET['week'];
    }

    $monday = strtotime('next Monday '.$week.' week');
    $thuesday = strtotime(date($format,$monday)." +1 days");
    $wednesday = strtotime(date($format,$monday)." +2 days");
    $thursday = strtotime(date($format,$monday)." +3 days");
    $friday = strtotime(date($format,$monday)." +4 days");
    $saturday = strtotime(date($format,$monday)." +5 days");
    $sunday = strtotime(date($format,$monday)." +6 days");
    $calendar_week = date("W" ,$monday);

    $dates_of_this_week = [
        "calendarWeek" => $calendar_week,
        "weekdays" => array(
            date($format,$monday),
            date($format,$thuesday),
            date($format,$wednesday),
            date($format,$thursday),
            date($format,$friday),
        ),
        "year" => date("Y",$monday),
    ];

    //returns json with calendar week and all dates of the week
    echo json_encode($dates_of_this_week);
?>