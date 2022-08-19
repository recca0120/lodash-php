<?php

namespace Recca0120\Lodash\Tests\JString\Extensions;

use PHPUnit\Framework\TestCase;
use Recca0120\Lodash\JString\Extensions\Chinese;

class ChineseTest extends TestCase
{
    public function test_9()
    {
        $this->assertSame(9, (new Chinese('九'))->toNumber());
    }

    public function test_19()
    {
        $this->assertSame(19, (new Chinese('十九'))->toNumber());
    }

    public function test_94()
    {
        $this->assertSame(94, (new Chinese('九十四'))->toNumber());
    }

    public function test_947()
    {
        $this->assertSame(947, (new Chinese('九百四十七'))->toNumber());
    }

    public function test_9478()
    {
        $this->assertSame(9478, (new Chinese('九千四百七十八'))->toNumber());
    }

    public function test_94789()
    {
        $this->assertSame(94789, (new Chinese('九萬四千七百八十九'))->toNumber());
    }

    public function test_947894()
    {
        $this->assertSame(947894, (new Chinese('九十四萬七千八百九十四'))->toNumber());
    }
}
