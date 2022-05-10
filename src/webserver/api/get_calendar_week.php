<?php
    function get_calendar_week($calendarWeek, $format) {
        if(!isset($_GET["week"])){
            if($calendarWeek == date("W")) {
                $calendarWeek = -1;
            }else {
                $calendarWeek = $calendarWeek - date("W") - 1;
            }
        }

        if($format == "en") {
            $format = "Y-m-d";
        }else{ 
            $format = "d.m.Y";
        }

        $monday = strtotime('next Monday '.$calendarWeek.' week');
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
    }
 ?>
