<?php

use Mockery as m;
use Recca0120\LoDash\JString\Extensions\FullCase;

class JStringFullCaseTest extends PHPUnit_Framework_TestCase
{
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
