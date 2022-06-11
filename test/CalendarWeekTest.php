<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalendarWeekTest extends TestCase
{
    public function testCalendarWeek(): void
    {
        $this->assertEquals(
            get_calendar_week(2022, 23, "en"),
            array("calendarWeek" => 23,"weekdays" => ["2022-06-06","2022-06-07","2022-06-08","2022-06-09","2022-06-10"],"year" => 2022)
        );

        $this->assertEquals(
            get_calendar_week(2022, 23, "de"),
            array("calendarWeek" => 23,"weekdays" => ["06.06.2022","07.06.2022","08.06.2022","09.06.2022","10.06.2022"],"year" => 2022)
        );
    }
}
