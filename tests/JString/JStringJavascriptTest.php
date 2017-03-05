<?php

use Mockery as m;
use Recca0120\Lodash\JString;

class JStringJavascriptTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_from_char_code()
    {
        $this->assertSame('ABC', (string) JString::fromCharCode(65, 66, 67));
    }

    public function test_char_at()
    {
        $anyString = new JString('Brave new world');
        $this->assertSame('B', (string) $anyString->charAt());
        $this->assertSame('B', (string) $anyString->charAt(0));
        $this->assertSame('r', (string) $anyString->charAt(1));
        $this->assertSame('a', (string) $anyString->charAt(2));
        $this->assertSame('v', (string) $anyString->charAt(3));
        $this->assertSame('e', (string) $anyString->charAt(4));
        // $this->assertSame('', (string) $anyString->charAt(999));
    }

    public function test_char_code_at()
    {
        $anyString = new JString('ABC');
        $this->assertSame(65, $anyString->charCodeAt(0));
    }

    public function test_concat()
    {
        $hello = new JString('Hello, ');
        $this->assertSame('Hello, Kevin have a nice day.', (string) $hello->concat('Kevin', ' have a nice day.'));
    }

    public function test_ends_with()
    {
        $str = new JString('To be, or not to be, that is the question.');
        $this->assertTrue($str->endsWith('question.'));
        $this->assertFalse($str->endsWith('to be'));
        $this->assertTrue($str->endsWith('to be', 19));
    }

    public function test_includes()
    {
        $str = new JString('To be, or not to be, that is the question.');
        $this->assertTrue($str->includes('To be'));
        $this->assertTrue($str->includes('To be'));
        $this->assertTrue($str->includes('question'));
        $this->assertFalse($str->includes('nonexistent'));
        $this->assertFalse($str->includes('To be', 1));
        $this->assertFalse($str->includes('TO BE'));
    }

    public function test_index_of()
    {
        $str = new JString('Blue Whale');
        $this->assertSame(0, $str->indexOf('Blue'));
        $this->assertSame(-1, $str->indexOf('Blute'));
        $this->assertSame(5, $str->indexOf('Whale', 0));
        $this->assertSame(5, $str->indexOf('Whale', 5));
        $this->assertSame(0, $str->indexOf(''));
        $this->assertSame(9, $str->indexOf('', 9));
        $this->assertSame(10, $str->indexOf('', 10));
        $this->assertSame(11, $str->indexOf('', 11));
    }

    public function test_last_index_of()
    {
        $str = new JString('canal');
        $this->assertSame(3, $str->lastIndexOf('a'));
        // $this->assertSame(1, $str->lastIndexOf('a', 2));
        $this->assertSame(-1, $str->lastIndexOf('a', 0));
        $this->assertSame(-1, $str->lastIndexOf('x'));
        $this->assertSame(0, $str->lastIndexOf('c', -5));
        $this->assertSame(0, $str->lastIndexOf('c', 0));
        $this->assertSame(5, $str->lastIndexOf(''));
        $this->assertSame(2, $str->lastIndexOf('', 2));
    }

    public function test_match()
    {
        $str = new JString('For more information, see Chapter 3.4.5.1');
        $this->assertSame([
            ['see Chapter 3.4.5.1'],
            ['Chapter 3.4.5.1'],
            ['.1'],
        ], $str->match('/see (chapter \d+(\.\d)*)/i'));

        $str = new JString('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        $this->assertSame([
            ['A', 'B', 'C', 'D', 'E', 'a', 'b', 'c', 'd', 'e'],
        ], $str->match('/[A-E]/i'));
    }

    public function test_repeat()
    {
        $this->assertSame('', (string) (new JString('abc'))->repeat(0));
        $this->assertSame('abc', (string) (new JString('abc'))->repeat(1));
        $this->assertSame('abcabc', (string) (new JString('abc'))->repeat(2));
        $this->assertSame('abcabcabc', (string) (new JString('abc'))->repeat(3.5));
    }

    public function test_replace()
    {
        $this->assertSame('abc - 12345 - #$*%', (string) (new JString('abc12345#$*%'))->replace('/([^\d]*)(\d*)([^\w]+)/', function ($m) {
            return implode(' - ', [$m[1], $m[2], $m[3]]);
        }));

        $this->assertSame('Twas the night before Christmas...', (string) (new JString('Twas the night before Xmas...'))->replace('/xmas/i', 'Christmas'));
        $this->assertSame('oranges are round, and oranges are juicy.', (string) (new JString('Apples are round, and apples are juicy.'))->replace('/apples/i', 'oranges'));
        $this->assertSame('Smith, John', (string) (new JString('John Smith'))->replace('/(\w+)\s(\w+)/', '$2, $1'));

        $this->assertSame('def', (string) (new JString('abc'))->replace([
            'abc' => 'def',
        ]));
    }

    public function test_search()
    {
        $this->assertSame(22, (new JString('Twas the night before Xmas...'))->search('/xmas/i'));
        $this->assertSame(-1, (new JString('Twas the night before Xmas...'))->search('/xmasx/i'));
    }

    public function test_slice()
    {
        $str = new JString('The morning is upon us.');
        $this->assertSame('he morn', (string) $str->slice(1, 8));
        $this->assertSame('morning is upon u', (string) $str->slice(4, -2));
        $this->assertSame('is upon us.', (string) $str->slice(12));
        $this->assertSame('', (string) $str->slice(30));

        $this->assertSame('us.', (string) $str->slice(-3));
        $this->assertSame('us', (string) $str->slice(-3, -1));
        $this->assertSame('The morning is upon us', (string) $str->slice(0, -1));
    }

    public function test_split()
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
        ], (array) (new JString('Oh brave new world that has such people in it.'))->split(' '));

        $this->assertSame([
            'Oh brave new world that has such people in it.',
        ], (array) (new JString('Oh brave new world that has such people in it.'))->split());

        $this->assertSame([
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ], (array) (new JString('Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec'))->split(','));
    }

    public function test_starts_with()
    {
        $str = new JString('To be, or not to be, that is the question.');
        $this->assertTrue($str->startsWith('To be'));
        $this->assertFalse($str->startsWith('not to be'));
        $this->assertTrue($str->startsWith('not to be', 10));
    }

    public function test_substr()
    {
        $str = new JString('abcdefghij');
        $this->assertSame('bc', (string) $str->substr(1, 2));
        $this->assertSame('hi', (string) $str->substr(-3, 2));
        $this->assertSame('hij', (string) $str->substr(-3));
        $this->assertSame('bcdefghij', (string) $str->substr(1));
        $this->assertSame('ab', (string) $str->substr(-20, 2));
        $this->assertSame('', (string) $str->substr(20, 2));
    }

    public function test_substring()
    {
        $str = new JString('Mozilla');
        $this->assertSame('Moz', (string) $str->substring(0, 3));
        $this->assertSame('Moz', (string) $str->substring(3, 0));

        $this->assertSame('lla', (string) $str->substring(4, 7));
        $this->assertSame('lla', (string) $str->substring(4));
        $this->assertSame('lla', (string) $str->substring(7, 4));

        $this->assertSame('Mozill', (string) $str->substring(0, 6));

        $this->assertSame('Mozilla', (string) $str->substring(0, 7));
        $this->assertSame('Mozilla', (string) $str->substring(0, 10));
    }

    public function test_to_lower_case()
    {
        $this->assertSame('alphabet', (string) (new JString('ALPHABET'))->toLowerCase());
    }

    public function test_to_upper_case()
    {
        $this->assertSame('ALPHABET', (string) (new JString('alphabet'))->toUpperCase());
    }

    public function test_trim()
    {
        $this->assertSame('foo', (string) (new JString('   foo  '))->trim());
    }

    public function test_trim_left()
    {
        $this->assertSame('foo  ', (string) (new JString('   foo  '))->trimLeft());
    }

    public function test_trim_right()
    {
        $this->assertSame('   foo', (string) (new JString('   foo  '))->trimRight());
    }

    public function test_value_of()
    {
        $this->assertSame('Hello world', (string) (new JString('Hello world'))->valueOf());
    }

    public function test_is_string()
    {
        $this->assertTrue(JString::supports(new JString([])));
        $this->assertTrue(JString::supports(''));
        $this->assertFalse(JString::supports([]));
        $this->assertFalse(JString::supports(new stdClass));
    }
}
