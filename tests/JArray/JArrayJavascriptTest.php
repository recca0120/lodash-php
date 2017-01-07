<?php

use Mockery as m;
use Recca0120\LoDash\JArray;

class JArrayJavascriptTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_concat()
    {
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f'], (array) (new JArray(['a', 'b', 'c']))->concat(['d', 'e', 'f']));
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], (array) (new JArray([1, 2, 3]))->concat([4, 5, 6], [7, 8, 9]));
        $this->assertSame(['a', 'b', 'c', 1, 2, 3], (array) (new JArray(['a', 'b', 'c']))->concat(1, [2, 3]));
    }

    public function test_entries()
    {
        $this->assertInstanceOf('ArrayIterator', (new JArray([]))->entries());
    }

    public function test_every()
    {
        $isBigEnough = function ($element, $index, $array) {
            return $element >= 10;
        };

        $this->assertFalse((new JArray([12, 5, 8, 130, 44]))->every($isBigEnough));
        $this->assertTrue((new JArray([12, 54, 18, 130, 44]))->every($isBigEnough));
    }

    public function test_fill()
    {
        $this->assertSame([4, 4, 4], (array) (new JArray([1, 2, 3]))->fill(4));
        $this->assertSame([1, 4, 4], (array) (new JArray([1, 2, 3]))->fill(4, 1));
        $this->assertSame([1, 4, 3], (array) (new JArray([1, 2, 3]))->fill(4, 1, 2));
        $this->assertSame([1, 2, 3], (array) (new JArray([1, 2, 3]))->fill(4, 1, 1));
        // $this->assertSame([4, 2, 3], (array) (new JArray([1, 2, 3]))->fill(4, -3, -2));
        // $this->assertSame([1, 2, 3], (array) (new JArray([1, 2, 3]))->fill(4, null, null));
    }

    public function test_filter()
    {
        $isBigEnough = function ($value) {
            return $value >= 10;
        };

        $this->assertSame([0 => 12, 3 => 130, 4 => 44], (array) (new JArray([12, 5, 8, 130, 44]))->filter($isBigEnough));
    }

    public function test_find()
    {
        $isBigEnough = function ($value) {
            return $value >= 15;
        };

        $this->assertSame(130, (new JArray([12, 5, 8, 130, 44]))->find($isBigEnough));
    }

    public function test_find_index()
    {
        $isPrime = function ($element, $index, $array) {
            $start = 2;
            while ($start <= sqrt($element)) {
                if ($element % $start++ < 1) {
                    return false;
                }
            }

            return $element > 1;
        };

        $this->assertSame(-1, (new JArray([4, 6, 8, 12]))->findIndex($isPrime));
        $this->assertSame(2, (new JArray([4, 6, 7, 12]))->findIndex($isPrime));
    }

    public function test_each()
    {
        $arr = ['a', 'b', 'c'];
        $i = 0;
        (new JArray($arr))->each(function ($value) use ($arr, &$i) {
            $this->assertSame($arr[$i], $value);
            $i++;
        });
    }

    public function test_includes()
    {
        $this->assertTrue((new JArray([1, 2, 3]))->includes(2));
        $this->assertFalse((new JArray([1, 2, 3]))->includes(4));
        $this->assertFalse((new JArray([1, 2, 3]))->includes(3, 3));
        $this->assertTrue((new JArray([1, 2, 3]))->includes(3, -1));
        $this->assertTrue((new JArray([1, 2, null]))->includes(null));
    }

    public function test_index_of()
    {
        $array = new JArray([2, 9, 9]);
        $this->assertSame(0, $array->indexOf(2));
        $this->assertSame(-1, $array->indexOf(7));
        // $this->assertSame(2, $array->indexOf(9, 2));
        // $this->assertSame(-1, $array->indexOf(2, -1));
        // $this->assertSame(0, $array->indexOf(2, -3));
    }

    public function test_join()
    {
        $array = new JArray(['Wind', 'Rain', 'Fire']);
        $this->assertSame('Wind,Rain,Fire', (string) $array->join());
        $this->assertSame('Wind, Rain, Fire', (string) $array->join(', '));
        $this->assertSame('Wind + Rain + Fire', (string) $array->join(' + '));
        $this->assertSame('WindRainFire', (string) $array->join(''));
    }

    public function test_keys()
    {
        $arr = new JArray(['a', 'b', 'c']);
        $iterator = $arr->keys();

        $this->assertSame(0, $iterator->current());
        $iterator->next();
        $this->assertSame(1, $iterator->current());
        $iterator->next();
        $this->assertSame(2, $iterator->current());
        $iterator->next();
        $this->assertNull($iterator->current());
    }

    public function test_last_index_of()
    {
        $numbers = new JArray([2, 5, 9, 2]);
        $this->assertSame(3, $numbers->lastIndexOf(2));
        $this->assertSame(-1, $numbers->lastIndexOf(7));
        // $this->assertSame(3, $numbers->lastIndexOf(2, 3));
        // $this->assertSame(0, $numbers->lastIndexOf(2, 2));
        // $this->assertSame(0, $numbers->lastIndexOf(2, -2));
        // $this->assertSame(3, $numbers->lastIndexOf(2, -1));
    }

    public function test_map()
    {
        $numbers = new JArray([1, 4, 9]);
        $roots = $numbers->map('sqrt');

        $this->assertSame([1.0, 2.0, 3.0], (array) $roots);
        $this->assertSame([1, 4, 9], (array) $numbers);
    }

    public function test_pop()
    {
        $a = new JArray([1, 2, 3]);
        $a->pop();

        $this->assertSame([1, 2], (array) $a);
    }

    public function test_push()
    {
        $sports = new JArray(['soccer', 'baseball']);
        $total = $sports->push('football', 'swimming');

        $this->assertSame(['soccer', 'baseball', 'football', 'swimming'], (array) $sports);
        $this->assertSame(4, $total);
    }

    public function test_reduce()
    {
        $this->assertSame(6, (new JArray([0, 1, 2, 3]))->reduce(function ($a, $b) {
            return $a + $b;
        }, 0));

        $this->assertSame([0, 1, 2, 3, 4, 5], (array) (new JArray([[0, 1], [2, 3], [4, 5]]))->reduce(function ($a, $b) {
            return (new JArray($a))->concat($b);
        }, []));
    }

    public function test_reduce_right()
    {
        $this->assertSame([4, 5, 2, 3, 0, 1], (array) (new JArray([[0, 1], [2, 3], [4, 5]]))->reduceRight(function ($a, $b) {
            return (new JArray($a))->concat($b);
        }, []));
    }

    public function test_reverse()
    {
        $a = new JArray(['one', 'two', 'three']);
        $reversed = $a->reverse();

        $this->assertSame(['three', 'two', 'one'], (array) $a);
        $this->assertSame(['three', 'two', 'one'], (array) $reversed);
    }

    public function test_shift()
    {
        $a = new JArray([1, 2, 3]);
        $a->shift();

        $this->assertSame([2, 3], (array) $a);
    }

    public function test_slice()
    {
        $a = new JArray(['zero', 'one', 'two', 'three']);
        $sliced = $a->slice(1, 3);
        $this->assertSame(['zero', 'one', 'two', 'three'], (array) $a);
        $this->assertSame(['one', 'two'], (array) $sliced);
    }

    public function test_some()
    {
        $isBiggerThan10 = function ($element, $index, $array) {
            return $element > 10;
        };

        $this->assertFalse((new JArray([2, 5, 8, 1, 4]))->some($isBiggerThan10));
        $this->assertTrue((new JArray([12, 5, 8, 1, 4]))->some($isBiggerThan10));
    }

    public function test_sort()
    {
        $fruit = new JArray(['cherries', 'apples', 'bananas']);
        $fruit->sort();

        $this->assertSame(['apples', 'bananas', 'cherries'], (array) $fruit);
    }

    public function test_splice()
    {
        $myFish = new JArray(['angel', 'clown', 'mandarin', 'surgeon']);
        $myFish->splice(2, 0, 'drum');

        $this->assertSame(['angel', 'clown', 'drum', 'mandarin', 'surgeon'], (array) $myFish);
    }

    public function test_to_string()
    {
        $months = new JArray(['Jan', 'Feb', 'Mar', 'Apr']);
        $this->assertSame('Jan,Feb,Mar,Apr', $months->toString());
        $this->assertSame('Jan,Feb,Mar,Apr', (string) $months);
    }

    public function test_unshift()
    {
        $arr = new JArray([1, 2]);

        $this->assertSame([0, 1, 2], (array) $arr->unshift(0));

        $this->assertSame([-2, -1, 0, 1, 2], (array) $arr->unshift(-2, -1));

        $this->assertSame([[-3], -2, -1, 0, 1, 2], (array) $arr->unshift([-3]));
    }

    public function test_values()
    {
        $a = new JArray(['w', 'y', 'k', 'o', 'p']);
        $iterator = $a->values();

        $this->assertSame('w', $iterator->current());
        $iterator->next();
        $this->assertSame('y', $iterator->current());
        $iterator->next();
        $this->assertSame('k', $iterator->current());
        $iterator->next();
        $this->assertSame('o', $iterator->current());
        $iterator->next();
        $this->assertSame('p', $iterator->current());
        $iterator->next();
        $this->assertNull($iterator->current());
    }

    public function test_is_array()
    {
        $this->assertTrue(JArray::supports([]));
        $this->assertTrue(JArray::supports(new JArray([])));
        $this->assertFalse(JArray::supports(''));
        $this->assertFalse(JArray::supports(new stdClass));
    }
}
