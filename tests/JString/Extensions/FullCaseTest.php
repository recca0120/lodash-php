<?php

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Lodash\JString\Extensions\FullCase;

class JStringFullCaseTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_full_case()
    {
        $map = FullCase::$fullCaseMap;

        foreach ($map as $key => $value) {
            $this->assertSame($key, (new FullCase($value))->toFullCase());
        }
    }

    public function test_half_case()
    {
        $map = FullCase::$fullCaseMap;

        foreach ($map as $key => $value) {
            $this->assertSame($value, (new FullCase($key))->toHalfCase());
        }
    }
}
