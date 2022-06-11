<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function exampleTest(): void
    {
        $this->assertEquals(
            get_calendar_week(2022, 23, "de"),
            array("calendarWeek" => 23,"weekdays" => ["2022-06-06","2022-06-07","2022-06-08","2022-06-09","2022-06-10"],"year" => 2022)
        );
    }
}