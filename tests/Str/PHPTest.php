<?php

use Mockery as m;
use Recca0120\LoDash\Str;

class PHPTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_convert_encoding()
    {
        $this->assertSame(mb_convert_encoding('測', 'big5'), (string) (new Str('測'))->convertEncoding('big5'));
    }

    public function test_convert_to()
    {
        $this->assertSame('16进位制', (string) (new Str('16進位制'))->convertTo('zh-cn'));
    }

    public function test_explode()
    {
        $this->assertSame([
            'Oh',
            'brave',
            'new',
            'world',
            'that',
            'has',
            'such',
            'people',
            'in',
            'it.',
        ], (new Str('Oh brave new world that has such people in it.'))->explode(' '));
    }
}
