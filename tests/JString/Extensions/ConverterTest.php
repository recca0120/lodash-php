<?php

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Lodash\JString\Extensions\Converter;

class JStringConverterTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_convert_to_zh_cn()
    {
        $this->assertSame('16进位制', (string) Converter::instance()->convertTo('16進位制', 'zh-cn'));
    }
}
