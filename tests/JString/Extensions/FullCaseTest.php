<?php

namespace Recca0120\Lodash\Tests\JString\Extensions;

use PHPUnit\Framework\TestCase;
use Recca0120\Lodash\JString\Extensions\FullCase;

class FullCaseTest extends TestCase
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
