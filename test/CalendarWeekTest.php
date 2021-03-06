<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/* It tests the function `get_calendar_week` with different parameters */
final class CalendarWeekTest extends TestCase
{
    
/**
 * It returns an array with the calendar week, the weekdays and the year
 */
    public function testCalendarWeek(): void
    {
        $this->assertEquals(
            get_calendar_week(2022, 23, "en"),
            array("calendarWeek" => 23,"weekdays" => ["2022-06-06","2022-06-07","2022-06-08","2022-06-09","2022-06-10"],"year" => 2022)
        );

        $this->assertNotEquals(
            get_calendar_week(2023, 23, "en"),
            array("calendarWeek" => 23,"weekdays" => ["2022-06-06","2022-06-07","2022-06-08","2022-06-09","2022-06-10"],"year" => 2022)
        );

        $this->assertEquals(
            get_calendar_week(2022, 23, "de"),
            array("calendarWeek" => 23,"weekdays" => ["06.06.2022","07.06.2022","08.06.2022","09.06.2022","10.06.2022"],"year" => 2022)
        );

        $this->assertNotEquals(
            get_calendar_week(2023, 23, "de"),
            array("calendarWeek" => 23,"weekdays" => ["06.06.2022","07.06.2022","08.06.2022","09.06.2022","10.06.2022"],"year" => 2022)
        );
    }

/**
 * It returns an array with the calendar week number, the weekdays of the given week and the year
 */
    public function testAnotherYear(): void
    {
        $this->assertEquals(
            get_calendar_week(2023, 1, "en"),
            array("calendarWeek" => 1,"weekdays" => ["2023-01-02","2023-01-03","2023-01-04","2023-01-05","2023-01-06"],"year" => 2023)
        );

        $this->assertEquals(
            get_calendar_week(2023, 1, "de"),
            array("calendarWeek" => 1,"weekdays" => ["02.01.2023", "03.01.2023", "04.01.2023", "05.01.2023", "06.01.2023"],"year" => 2023)
        );
    }
}
