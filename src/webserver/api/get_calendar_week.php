<?php
    //input: http://localhost/api/get_calendar_week.php?calendarWeek=17&year=2022
    //output: {"calendarWeek":"51","weekdays":["20.12.2021","21.12.2021","22.12.2021","23.12.2021","24.12.2021"],"year":"2021"}
    
    //check if file is called directly
    if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
        //calculate offset based on calendarWeek
        if(!empty($_GET["calendarWeek"]) && ctype_digit(htmlspecialchars($_GET["calendarWeek"]))) {
            $week = htmlspecialchars($_GET["calendarWeek"]);
        }else {
            $week = date("W");
        }

        if(!empty($_GET["year"]) && ctype_digit(htmlspecialchars($_GET["year"]))) {
            $year = htmlspecialchars($_GET["year"]);
        }else {
            $year = date("Y");
        }

        $format = "en";
        
        if(!empty($_GET["format"])) {
            $format = htmlspecialchars($_GET["format"]);
        }

        echo json_encode(get_calendar_week((int) $year, (int) $week, $format));
    }

/**
 * It returns an array with the dates of a given week
 * 
 * @param int year The year you want to get the calendar week from.
 * @param int week The week number of the year.
 * @param string format de or en
 * 
 * @return array An array with the weekdays of the given week.
 */
    function get_calendar_week(int $year, int $week, string $format): array {
        if($format == "de") {
            $format = "d.m.Y";
        }else if($format == "en") {
            $format = "Y-m-d";
        }

        $dateTime = new DateTime();
        $dateTime->setISODate($year, $week);
        $dates_of_this_week = [
            "calendarWeek" => $week,
            "weekdays" => array(
                $dateTime->format($format),
                $dateTime->modify('+1 day')->format($format),
                $dateTime->modify('+1 day')->format($format),
                $dateTime->modify('+1 day')->format($format),
                $dateTime->modify('+1 day')->format($format),
            ),
            "year" => $year
        ];

        return $dates_of_this_week;
      }
 ?>
