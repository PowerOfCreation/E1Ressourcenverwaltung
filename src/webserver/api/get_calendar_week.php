<?php
    $format = "d.m.Y";

    if(htmlspecialchars($_GET["format"]) == "en") {
        $format = "Y-m-d";
    }

    //increment or decrement $week to change calendar week
    $week = -1;

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
        )
    ];

    //returns json with calendar week and all dates of the week
    echo json_encode($dates_of_this_week);

 ?>
