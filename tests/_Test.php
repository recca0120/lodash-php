<?php

use Mockery as m;
use Recca0120\Library\_;

class _Test extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_count_by()
    {
        $this->assertSame(['6' => 2, '4' => 1], _::countBy([6.1, 4.2, 6.3], 'floor'));
        $this->assertSame(['3' => 2, '5' => 1], _::countBy(['one', 'two', 'three'], 'strlen'));
    }

    public function test_for_each()
    {
        _::forEach([1, 2], function ($value, $key) {
            if ($key === 0) {
                $this->assertSame(1, $value);
            } else {
                $this->assertSame(2, $value);
            }
        });

        _::forEach(['a' => 1, 'b' => 2], function ($value, $key) {
            if ($key === 'a') {
                $this->assertSame(1, $value);
            } else {
                $this->assertSame('b', $key);
                $this->assertSame(2, $value);
            }
        });
    }

    public function test_for_each_right()
    {
        $i = 0;
        _::forEachRight([1, 2], function ($value, $key) use (&$i) {
            if ($i === 0) {
                $this->assertSame(2, $value);
            } else {
                $this->assertSame(1, $value);
            }
            ++$i;
        });
    }

    public function test_every()
    {
        $users = [
          ['user' => 'barney', 'age' => 36, 'active' => false],
          ['user' => 'fred',   'age' => 40, 'active' => false],
        ];

        $this->assertFalse(_::every($users, function ($o) {
            return $o['user'] === 'barney' && $o['active'] === false;
        }));

        $this->assertTrue(_::every($users, function ($o) {
            return $o['active'] === false;
        }));
    }

    public function test_filter()
    {
        $users = [
          ['user' => 'barney', 'age' => 36, 'active' => true],
          ['user' => 'fred',   'age' => 40, 'active' => false],
        ];

        $this->assertSame([1 => ['user' => 'fred', 'age' => 40, 'active' => false]], _::filter($users, function ($o) {
            return !$o['active'];
        }));
    }

    public function test_find()
    {
        $users = [
          ['user' => 'barney', 'age' => 36, 'active' => true],
          ['user' => 'fred',   'age' => 40, 'active' => false],
          ['user' => 'pebbles', 'age' => 1,  'active' => true]
        ];

        $this->assertSame(['user' => 'barney', 'age' => 36, 'active' => true], _::find($users, function ($o) {
            return !$o['age'] < 40;
        }));
    }

    public function test_find_last()
    {
        $this->assertSame(3, _::findLast([1, 2, 3, 4], function ($n) {
            return $n % 2 == 1;
        }));
    }

    public function test_group_by()
    {
        $this->assertSame(['6' => [6.1, 6.3], '4' => [4.2]], _::groupBy([6.1, 4.2, 6.3], 'floor'));
        $this->assertSame(['3' => ['one', 'two'], '5' => ['three']], _::groupBy(['one', 'two', 'three'], 'strlen'));
    }

    public function test_includes()
    {
        $this->assertTrue(_::includes([1, 2, 3], 1));
        $this->assertFalse(_::includes([1, 2, 3], 1, 2));
        $this->assertTrue(_::includes(['a' => 1, 'b' => 2], 1));
        // $this->assertTrue(_::includes('abcd', 'bc'));
    }

    public function test_key_by()
    {
        $array = [
          [ 'dir' => 'left', 'code' => 97 ],
          [ 'dir' => 'right', 'code' => 100 ],
        ];

        $this->assertSame([
            'a' => [ 'dir' => 'left', 'code' => 97 ],
            'd' => [ 'dir' => 'right', 'code' => 100 ],
        ], _::keyBy($array, function($o) {
            return chr($o['code']);
        }));

        $this->assertSame([
            97 => [ 'dir' => 'left', 'code' => 97 ],
            100 => [ 'dir' => 'right', 'code' => 100 ],
        ], _::keyBy($array, 'code'));
    }

    public function test_map()
    {
        $square = function($n) {
            return $n * $n;
        };

        $this->assertSame([16, 64], _::map([4, 8], $square));
        $this->assertSame(['a' => 16, 'b' => 64], _::map(['a' => 4, 'b' => 8], $square));
        // _.map(users, 'user');
        // => ['barney', 'fred']
    }

    public function test_camel_case()
    {
        $this->assertSame('fooBar', _::camelCase('Foo Bar'));
        // $this->assertSame('fooBar', _::camelCase('--foo-bar--'));
        // $this->assertSame('fooBar', _::camelCase('_FOO_BAR_'));
    }

    public function test_capitalize()
    {
        $this->assertSame('Fred', _::capitalize('FRED'));
    }

    public function test_deburr()
    {
        $this->assertSame('deja vu', _::deburr('déjà vu'));
    }

    public function test_ends_with()
    {
        $this->assertTrue(_::endsWith('abc', 'c'));
        $this->assertFalse(_::endsWith('abc', 'b'));
        $this->assertTrue(_::endsWith('abc', 'b', 2));
    }

    public function test_escape()
    {
        $this->assertSame('fred, barney, &amp; pebbles', _::escape('fred, barney, & pebbles'));
    }

    public function test_escape_reg_exp()
    {
        $this->assertSame('\[lodash\]\(https://lodash\.com/\)', _::escapeRegExp('[lodash](https://lodash.com/)'));
    }

    public function test_kebab_case()
    {
        $this->assertSame('foo-bar', _::kebabCase('Foo Bar'));
        // $this->assertSame('foo-bar', _::kebabCase('--foo-bar--'));
        // $this->assertSame('foo-bar', _::kebabCase('_FOO_BAR_'));
    }

    public function test_lower_case()
    {
        // $this->assertSame('foo bar', _::lowerCase('--Foo-Bar--'));
        $this->assertSame('foo bar', _::lowerCase('fooBar'));
        // $this->assertSame('foo bar', _::lowerCase('_FOO_BAR_'));
    }

    public function test_lower_first()
    {
        $this->assertSame('fred', _::lowerFirst('Fred'));
        $this->assertSame('fRED', _::lowerFirst('FRED'));
    }

    public function test_pad()
    {
        $this->assertSame('  abc   ', _::pad('abc', 8));
        $this->assertSame('_-abc_-_', _::pad('abc', 8, '_-'));
        $this->assertSame('abc', _::pad('abc', 3));
    }

    public function test_pad_end()
    {
        $this->assertSame('abc   ', _::padEnd('abc', 6));
        $this->assertSame('abc_-_', _::padEnd('abc', 6, '_-'));
        $this->assertSame('abc', _::padEnd('abc', 3));
    }

    public function test_pad_start()
    {
        $this->assertSame('   abc', _::padStart('abc', 6));
        $this->assertSame('_-_abc', _::padStart('abc', 6, '_-'));
        $this->assertSame('abc', _::padStart('abc', 3));
    }

    public function test_parse_int()
    {
        $this->assertSame(8, _::parseInt('08'));
    }

    public function test_words()
    {
        $this->assertSame(['fred', 'barney', 'pebbles'], _::words('fred, barney, & pebbles'));
        $this->assertSame(['fred', 'barney', '&', 'pebbles'], _::words('fred, barney, & pebbles', '/[^, ]+/'));
    }

    public function test_lcfirst()
    {
        $this->assertSame('helloWorld', _::lcfirst('HelloWorld'));
        $this->assertSame('hELLO WORLD!', _::lcfirst('HELLO WORLD!'));
        $this->assertSame('hELLO WORLD!', _::lcfirst(strtoupper('HELLO WORLD!')));
    }

    public function test_substr()
    {
        $this->assertSame('f', _::substr('abcdef', -1));
        $this->assertSame('ef', _::substr('abcdef', -2));
        $this->assertSame('d', _::substr('abcdef', -3, 1));
    }

    public function test_trim()
    {
        $this->assertSame('These are a few words :) ...', _::trim("\t\tThese are a few words :) ...  "));
        $this->assertSame('These are a few words :)', _::trim("\t\tThese are a few words :) ...  ", " \t."));
        $this->assertSame('o Wor', _::trim('Hello World', 'Hdle'));
        $this->assertSame('ello Worl', _::trim('Hello World', 'HdWr'));
        $this->assertSame('Example string', _::trim("\x09Example string\x0A", "\x00..\x1F"));
    }

    public function test_ucfirst()
    {
        $this->assertSame('Hello world!', _::ucfirst('hello world!'));
        $this->assertSame('HELLO WORLD!', _::ucfirst('HELLO WORLD!'));
        $this->assertSame('Hello world!', _::ucfirst(strtolower('HELLO WORLD!')));
    }
}
