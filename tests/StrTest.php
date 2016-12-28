<?php

use Mockery as m;
use Recca0120\String\Str;

class StrTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_converter()
    {
        $this->assertSame('非常准', (string) (new Str('非常準'))->convertTo('zh-cn'));
    }
}
