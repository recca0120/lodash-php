<?php

namespace Recca0120\Lodash\Tests\JString\Extensions;

use PHPUnit\Framework\TestCase;
use Recca0120\Lodash\JString\Extensions\Converter;

class ConverterTest extends TestCase
{
    public function test_convert_to_zh_cn()
    {
        $this->assertSame('16进位制', (string) Converter::instance()->convertTo('16進位制', 'zh-cn'));
    }
}
