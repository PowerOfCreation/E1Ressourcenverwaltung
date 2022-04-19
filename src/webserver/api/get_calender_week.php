<?php
    //increment or decrement $week to change calender week
    $week = -1;
    $monday = strtotime('next Monday '.$week.' week');
    $thuesday = strtotime(date("d-m-Y",$monday)." +1 days");
    $wednesday = strtotime(date("d-m-Y",$monday)." +2 days");
    $thursday = strtotime(date("d-m-Y",$monday)." +3 days");
    $friday = strtotime(date("d-m-Y",$monday)." +4 days");
    $saturday = strtotime(date("d-m-Y",$monday)." +5 days");
    $sunday = strtotime(date("d-m-Y",$monday)." +6 days");
    $calender_week = date("W" ,$monday);

    $dates_of_this_week = [
        "calenderWeek" => $calender_week,
        "startOfWeekDate" => date("d.m.Y",$monday),
        "weekdays" => array(
            date("d.m.Y",$thuesday),
            date("d.m.Y",$wednesday),
            date("d.m.Y",$thursday),
            date("d.m.Y",$friday),
            date("d.m.Y",$saturday),
            date("d.m.Y",$sunday)
        )
    ];

    //returns json with calender week and all dates of the week
    echo json_encode($dates_of_this_week);
    
?>
