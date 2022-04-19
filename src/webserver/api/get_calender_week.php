<?php
    $format = "d.m.Y";
    
    if($_GET["format"] == "en") {
        $format = "Y-m-d";
    }

    //increment or decrement $week to change calender week
    $week = -1;
    
    $monday = strtotime('next Monday '.$week.' week');
    $thuesday = strtotime(date($format,$monday)." +1 days");
    $wednesday = strtotime(date($format,$monday)." +2 days");
    $thursday = strtotime(date($format,$monday)." +3 days");
    $friday = strtotime(date($format,$monday)." +4 days");
    $saturday = strtotime(date($format,$monday)." +5 days");
    $sunday = strtotime(date($format,$monday)." +6 days");
    $calender_week = date("W" ,$monday);

    $dates_of_this_week = [
        "calenderWeek" => $calender_week,
        "weekdays" => array(
            date($format,$monday),
            date($format,$thuesday),
            date($format,$wednesday),
            date($format,$thursday),
            date($format,$friday),
            date($format,$saturday),
            date($format,$sunday)
        )
    ];

    //returns json with calender week and all dates of the week
    echo json_encode($dates_of_this_week);
    
?>
