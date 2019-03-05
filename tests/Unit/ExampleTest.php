<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function test1()
    {
        $pattern = '/^[A-Z]{1}[a-z]*([\s\-]{1}[A-Z]{1}[a-z]*)*$/';
        $string = 'Cheong-Leen';
        $b = preg_match($pattern, $string);
        $string = 'Cheong Leen';
        $b = preg_match($pattern, $string);
        $string = 'Cheong L';
        $b = preg_match($pattern, $string);
    }
}
