<?php

use Mockery as m;
use Recca0120\LoDash\Arr;

class ArrJavascriptTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_concat()
    {
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f'], (array) (new Arr(['a', 'b', 'c']))->concat(['d', 'e', 'f']));
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], (array) (new Arr([1, 2, 3]))->concat([4, 5, 6], [7, 8, 9]));
        $this->assertSame(['a', 'b', 'c', 1, 2, 3], (array) (new Arr(['a', 'b', 'c']))->concat(1, [2, 3]));
    }

    public function test_entries()
    {
        $this->assertInstanceOf('ArrayIterator', (new Arr([]))->entries());
    }

    public function test_every()
    {
        $isBigEnough = function($element, $index, $array) {
            return $element >= 10;
        };

        $this->assertFalse((new Arr([12, 5, 8, 130, 44]))->every($isBigEnough));
        $this->assertTrue((new Arr([12, 54, 18, 130, 44]))->every($isBigEnough));
    }

    public function test_fill()
    {
        $this->assertSame([4, 4, 4], (array) (new Arr([1, 2, 3]))->fill(4));
        $this->assertSame([1, 4, 4], (array) (new Arr([1, 2, 3]))->fill(4, 1));
        $this->assertSame([1, 4, 3], (array) (new Arr([1, 2, 3]))->fill(4, 1, 2));
        $this->assertSame([1, 2, 3], (array) (new Arr([1, 2, 3]))->fill(4, 1, 1));
        // $this->assertSame([4, 2, 3], (array) (new Arr([1, 2, 3]))->fill(4, -3, -2));
        // $this->assertSame([1, 2, 3], (array) (new Arr([1, 2, 3]))->fill(4, null, null));
    }

    public function test_filter()
    {
        $isBigEnough = function($value) {
            return $value >= 10;
        };


        $this->assertSame([0 => 12, 3 => 130, 4 => 44], (array) (new Arr([12, 5, 8, 130, 44]))->filter($isBigEnough));
    }

    public function test_find()
    {
        $isBigEnough = function($value) {
            return $value >= 15;
        };


        $this->assertSame(130, (new Arr([12, 5, 8, 130, 44]))->find($isBigEnough));
    }

    public function test_find_index()
    {
       $isPrime = function($element, $index, $array) {
            $start = 2;
            while ($start <= sqrt($element)) {
                if ($element % $start++ < 1) {
                    return false;
                }
            }
            return $element > 1;
       };


        $this->assertSame(-1, (new Arr([4, 6, 8, 12]))->findIndex($isPrime));
        $this->assertSame(2, (new Arr([4, 6, 7, 12]))->findIndex($isPrime));
    }

    public function test_for_each()
    {
        $arr = ['a', 'b', 'c'];
        $i = 0;
        (new Arr($arr))->forEach(function($value) use ($arr, &$i) {
            $this->assertSame($arr[$i], $value);
            $i++;
        });
    }

    public function test_includes()
    {
        $this->assertTrue((new Arr([1, 2, 3]))->includes(2));
        $this->assertFalse((new Arr([1, 2, 3]))->includes(4));
        $this->assertFalse((new Arr([1, 2, 3]))->includes(3, 3));
        $this->assertTrue((new Arr([1, 2, 3]))->includes(3, -1));
        $this->assertTrue((new Arr([1, 2, null]))->includes(null));
    }

    public function test_index_of()
    {
        $array = new Arr([2, 9, 9]);
        $this->assertSame(0, $array->indexOf(2));
        $this->assertSame(-1, $array->indexOf(7));
        // $this->assertSame(2, $array->indexOf(9, 2));
        // $this->assertSame(-1, $array->indexOf(2, -1));
        // $this->assertSame(0, $array->indexOf(2, -3));
    }

    public function test_join()
    {
        $array = new Arr(['Wind', 'Rain', 'Fire']);
        $this->assertSame('Wind,Rain,Fire', (string) $array->join());
        $this->assertSame('Wind, Rain, Fire', (string) $array->join(', '));
        $this->assertSame('Wind + Rain + Fire', (string) $array->join(' + '));
        $this->assertSame('WindRainFire', (string) $array->join(''));
    }

    public function test_keys()
    {
        $arr = new Arr(["a", "b", "c"]);
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
        $numbers = new Arr([2, 5, 9, 2]);
        $this->assertSame(3, $numbers->lastIndexOf(2));
        $this->assertSame(-1, $numbers->lastIndexOf(7));
        // $this->assertSame(3, $numbers->lastIndexOf(2, 3));
        // $this->assertSame(0, $numbers->lastIndexOf(2, 2));
        // $this->assertSame(0, $numbers->lastIndexOf(2, -2));
        // $this->assertSame(3, $numbers->lastIndexOf(2, -1));
    }

    public function test_map() {
        $numbers = new Arr([1, 4, 9]);
        $roots = $numbers->map('sqrt');

        $this->assertSame([1.0, 2.0, 3.0], (array) $roots);
        $this->assertSame([1, 4, 9], (array) $numbers);
    }

    public function test_pop() {
        $a = new Arr([1, 2, 3]);
        $a->pop();

        $this->assertSame([1, 2], (array) $a);
    }

    public function test_push()
    {
        $sports = new Arr(['soccer', 'baseball']);
        $total = $sports->push('football', 'swimming');

        $this->assertSame(['soccer', 'baseball', 'football', 'swimming'], (array) $sports);
        $this->assertSame(4, $total);
    }

    public function test_reduce()
    {
        $this->assertSame(6, (new Arr([0, 1, 2, 3]))->reduce(function($a, $b) {
          return $a + $b;
        }, 0));

        $this->assertSame([0, 1, 2, 3, 4, 5], (array) (new Arr([[0, 1], [2, 3], [4, 5]]))->reduce(function($a, $b) {
          return (new Arr($a))->concat($b);
        }, []));
    }

    public function test_reduce_right()
    {
        $this->assertSame([4, 5, 2, 3, 0, 1], (array) (new Arr([[0, 1], [2, 3], [4, 5]]))->reduceRight(function($a, $b) {
            return (new Arr($a))->concat($b);
        }, []));
    }

    public function test_reverse()
    {
        $a = new Arr(['one', 'two', 'three']);
        $reversed = $a->reverse();

        $this->assertSame(['three', 'two', 'one'], (array) $a);
        $this->assertSame(['three', 'two', 'one'], (array) $reversed);
    }

    public function test_shift()
    {
        $a = new Arr([1, 2, 3]);
        $a->shift();

        $this->assertSame([2, 3], (array) $a);
    }

    public function test_slice()
    {
        $this->assertSame(["one", "two"], (array) (new Arr(["zero", "one", "two", "three"]))->slice(1, 3));
    }
}
