<?php

namespace FredBradley\Cacher\Tests;

use FredBradley\Cacher\Cacher;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function return_same_value()
    {
        $value = Cacher::setAndGet("phpunittest", 5, function () {
            return 'My Value';
        });

        $this->assertSame("My Value", $value);
    }
}
