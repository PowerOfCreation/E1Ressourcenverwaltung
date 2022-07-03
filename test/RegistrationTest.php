<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/* It tests the `checkPassword` function */
final class RegistrationTest extends TestCase
{
    public function testPasswordCheck(): void
    {
        $this->assertNotEquals(
            checkPassword("123456"),
            ""
        );

        $this->assertEquals(
            checkPassword("123456asdASD"),
            ""
        );

        $this->assertTrue(
            empty(checkPassword("123456asdASD"))
        );
    }
}
