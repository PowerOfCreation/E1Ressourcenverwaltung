<?php
    //input: http://localhost/api/get_calendar_week.php?calendarWeek=17&year=2022
    //output: {"calendarWeek":"51","weekdays":["20.12.2021","21.12.2021","22.12.2021","23.12.2021","24.12.2021"],"year":"2021"}
    
    //check if file is called directly
    if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
        //calculate offset based on calendarWeek
        if(empty($_GET["calendarWeek"])) {
            $week = date("W");
        }else {
            $week = htmlspecialchars($_GET["calendarWeek"]);
        }

        $format = "en";
        
        if(!empty($_GET["format"])) {
            $format = htmlspecialchars($_GET["format"]);
        }

        echo json_encode(get_calendar_week($week, $format));
    }


    function get_calendar_week($calendarWeek, string $format) {  //string kommt rein
        if($format == "de") {
            $format = "d-m-Y";
        }else if($format == "en") {
            $format = "Y-m-d";
        }
        //calculate offset for calendarWeek
        $calendarWeek = $calendarWeek - date("W") - 1;
        //get dates of $calendarWeek
        $monday = strtotime('next Monday '.$calendarWeek.' week');
        $thuesday = strtotime(date($format,$monday)." +1 days");
        $wednesday = strtotime(date($format,$monday)." +2 days");
        $thursday = strtotime(date($format,$monday)." +3 days");
        $friday = strtotime(date($format,$monday)." +4 days");

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
        return $dates_of_this_week;
    }
 ?>
