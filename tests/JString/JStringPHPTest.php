<?php

use Mockery as m;
use Recca0120\Lodash\JString;
use PHPUnit\Framework\TestCase;

class JStringPHPTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_convert_encoding()
    {
        $this->assertSame(mb_convert_encoding('測', 'big5'), (string) (new JString('測'))->convertEncoding('big5'));
    }

    public function test_convert_to()
    {
        $this->assertSame('16进位制', (string) (new JString('16進位制'))->convertTo('zh-cn'));
    }

    public function test_htmlentities()
    {
        $flag = ENT_COMPAT | ENT_HTML401;
        $this->assertSame(htmlentities('foo', $flag), (string) (new JString('foo'))->htmlentities($flag));
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
        ], (array) (new JString('Oh brave new world that has such people in it.'))->explode(' '));
    }
}
